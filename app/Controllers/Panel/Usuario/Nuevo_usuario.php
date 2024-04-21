<?php

namespace App\Controllers\Panel\Usuario;
use App\Controllers\BaseController;
use App\Models\Tabla_usuario;


class Nuevo_usuario extends BaseController {

    private $view = 'panel\usuario\nuevo_usuario';

    private $session = NULL;
    private $permiso = TRUE;
    
    public function __construct(){
        //instancia de la variable de sesion
        $this->session = session();
    
        //instancia del permisos helper
        helper("permisos_roles_helper");

        if (!acceso_usuario(TAREA_USUARIOS, $this->session->rol_actual)){
            $this->permiso = FALSE;
        }
        $this->session->tarea_actual = TAREA_USUARIOS;
    }//end constructor


    private function cargar_datos(){

        $datos = array();
    
        $datos['nombre_pagina'] = 'Registrar usuario | Admin';
        $datos['titulo_pagina'] = 'Registrar usuario';

        $datos['nombre_completo'] = $this->session->nombre_completo;
        $datos['nombre_user'] = $this->session->nombre;
        $datos['imagen_user'] = ($this->session->imagen_perfil == NULL) 
                                                            ? (($this->session->sexo != MASCULINO) ? 'icon-woman.png': 'icon-man.webp')
                                                            : $this->session->imagen_perfil;



        $breadcrumb = array(
            array(
                'href' => route_to("administracion_usuarios"),
                'titulo' => 'Usuarios',    
            ),
            array(
                'href' => '#',
                'titulo' => 'Registrar usuario',    
            )

        );

        $datos['breadcrumb_panel'] = breadcrumb_panel($datos['titulo_pagina'], $breadcrumb);

        // INFORMACION DEL SISTEMA 
        //BREADCRUM
        //PETICIONES- MODELOS JQUERY
        $tabla_usuario = new \App\Models\Tabla_usuario;
        $datos["usuarios"] = $tabla_usuario->get_table();
        $tabla_alumno= new \App\Models\Tabla_alumno;
        $datos["alumnos"] = $tabla_alumno->get_table();

        return $datos;
    }



    private function crear_vista($nombre_vista='', $contenido = array()){
        $contenido["menu_lateral"] = crear_menu_panel($this->session->tarea_actual,$this->session->rol_actual);
        return view($nombre_vista,$contenido);
        
    }
    public function index() {
        // Verificar permisos
        if ($this->permiso) {
            // Cargar datos generales para la vista
            $datos = $this->cargar_datos();

            // Crear vista con los datos
            return $this->crear_vista($this->view, $datos);
        } else {
            mensaje("No tienes permisos para acceder a este modulo, contacte al administrador", "Error", 3);
            return redirect()->to(route_to("acceso"));
        }
    }
    


    public function registrar(){
        //arreglo temporal
        $usuario = array();

        $usuario["nombre"] = $this->request->getPost("nombre");
        $usuario["ap_paterno"] = $this->request->getPost("ap_paterno");
        $usuario["ap_materno"] = $this->request->getPost("ap_materno");
        $usuario["sexo"] = $this->request->getPost("sexo");
        $usuario["correo"] = $this->request->getPost("correo");

        if(!empty($this->request->getPost("password"))){
            if($this->request->getPost("password") == $this->request->getPost("repassword")){
                $usuario["password"] = hash("sha256", $this->request->getPost("password"));

            }else{
                mensaje("Las contraseñas no coinciden", "Error", 3);
                return $this->index();
            }
            }

        $usuario["imagen_perfil"] = $this->request->getPost("imagen_perfil"); 
        $usuario["idrol"] = $this->request->getPost("idrol");


        $tabla_usuarios = new \App\Models\Tabla_usuario;
        if($tabla_usuarios->create_data($usuario)){
            mensaje("El usuario se a registrado correctamente", "Petición Exitosa!", 1);
            return redirect()->to(route_to("administracion_usuarios"));
        }else{
            mensaje("Hubo un problema al registrar el usuario", "Error!", 3);
            return $this->index();

        }
    }


    
    public function eliminar($idusuario = 0) {
        $tabla_usuarios = new \App\Models\Tabla_usuario;
        
        // Verificar si el usuario existe
        $usuario = $tabla_usuarios->find($idusuario);
        if ($usuario != null) {
            // Eliminar el usuario
            if ($tabla_usuarios->delete($idusuario)) {
                mensaje("El usuario se eliminó correctamente", "Eliminación Exitosa!", 1);
                return redirect()->to(route_to("administracion_usuarios"));
            } else {
                mensaje("Ocurrió un error al procesar la eliminación", "Error al Eliminar!", 3);
                return $this->index($idusuario);
            }
        } else {
            mensaje("El usuario que solicitas eliminar no se encuentra en la BD", "Error", 3);
            return $this->index($idusuario);
        }
    }
}   
