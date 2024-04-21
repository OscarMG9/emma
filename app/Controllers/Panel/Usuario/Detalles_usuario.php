<?php

namespace App\Controllers\Panel\Usuario;
use App\Controllers\BaseController;


class Detalles_usuario extends BaseController {

    private $view = 'panel\usuario\detalles_usuario';

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


    private function cargar_datos($idusuario = 0){

        $datos = array();
    
        $datos['nombre_pagina'] = 'Detalles usuario | Admin';
        $datos['titulo_pagina'] = 'Detalles usuario';

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
                'titulo' => 'Detalles usuario',    
            )

        );

        $datos['breadcrumb_panel'] = breadcrumb_panel($datos['titulo_pagina'], $breadcrumb);

        // INFORMACION DEL SISTEMA 
        //BREADCRUM
        //PETICIONES- MODELOS JQUERY
        $tabla_usuarios = new \App\Models\Tabla_usuario;
        
        $datos['usuario'] = $tabla_usuarios->get_user(["idusuario" => $idusuario]);

        return $datos;
    }



    private function crear_vista($nombre_vista='', $contenido = array()){
        $contenido["menu_lateral"] = crear_menu_panel($this->session->tarea_actual,$this->session->rol_actual);
        return view($nombre_vista,$contenido);  
    }



    public function index($idusuario = 0 ) {
        // Verificar permisos
        if ($this->permiso) {
            // Cargar datos generales para la vista
            $datos = $this->cargar_datos($idusuario);

            $tabla_usuarios = new \App\Models\Tabla_usuario;

            if($tabla_usuarios->find($idusuario) == null){
                mensaje("El usuario que solicitaste no se encuentra en la BD", "Error", 3);
                return redirect()->to(route_to("administracion_usuarios"));
            }else{
                return $this->crear_vista($this->view, $this->cargar_datos($idusuario));
            }

        } else {
            mensaje("No tienes permisos para acceder a este modulo, contacte al administrador", "Error", 3);
            return redirect()->to(route_to("acceso"));
        }
    }

    public function actualizar($idusuario = 0){

        $tabla_usuarios = new \App\Models\Tabla_usuario;
        if($tabla_usuarios->find($idusuario) != null){
        
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
                return $this->index($idusuario);
            }
            }
            
            $usuario["imagen_perfil"] = $this->request->getPost("imagen_perfil"); 
            $usuario["idrol"] = $this->request->getPost("idrol");
            //-------------------------
            // UPDATE
            //-------------------------
            if($tabla_usuarios->update_data($idusuario,$usuario)){
                mensaje("El usuario se actualizo correctamente", "Actualización Exitosa!", 1);
                return redirect()->to(route_to("administracion_usuarios"));
            }else{
                mensaje("Ocurrio un error al procesar la actualización" , "Error al Actualizar!", 3);
                return $this->index($idusuario);
            }

        }else{
            mensaje("El usuario que solicitas actualizar no se encuentra en la BD", "Error", 3);
            return $this->index($idusuario);
        }

    }  
    } 
