<?php

namespace App\Controllers\Panel\Docente;
use App\Controllers\BaseController;
use App\Models\Tabla_docente;


class Nuevo_docente extends BaseController {

    private $view = 'panel\docente\nuevo_docente';

    private $session = NULL;
    private $permiso = TRUE;
    
    public function __construct(){
        //instancia de la variable de sesion
        $this->session = session();
    
        //instancia del permisos helper
        helper("permisos_roles_helper");

        if (!acceso_usuario(TAREA_DOCENTES, $this->session->rol_actual)){
            $this->permiso = FALSE;
        }
        $this->session->tarea_actual = TAREA_DOCENTES;
    }//end constructor


    private function cargar_datos(){

        $datos = array();
    
        $datos['nombre_pagina'] = 'Registrar docente | Admin';
        $datos['titulo_pagina'] = 'Registrar docente';

        $datos['nombre_completo'] = $this->session->nombre_completo;
        $datos['nombre_user'] = $this->session->nombre;
        $datos['imagen_user'] = ($this->session->imagen_perfil == NULL) 
                                                            ? (($this->session->sexo != MASCULINO) ? 'icon-woman.png': 'icon-man.webp')
                                                            : $this->session->imagen_perfil;



        $breadcrumb = array(
            array(
                'href' => route_to("administracion_docente"),
                'titulo' => 'Docentes',    
            ),
            array(
                'href' => '#',
                'titulo' => 'Registrar docente',    
            )

        );

        $datos['breadcrumb_panel'] = breadcrumb_panel($datos['titulo_pagina'], $breadcrumb);

        // INFORMACION DEL SISTEMA 
        //BREADCRUM
        //PETICIONES- MODELOS JQUERY

        $tabla_usuario = new \App\Models\Tabla_usuario;
        $datos["usuarios"] = $tabla_usuario->get_table();
        $tabla_programa = new \App\Models\Tabla_programa;
        $datos["programas"] = $tabla_programa->get_table();
        $tabla_docentes = new \App\Models\Tabla_docente;
        $datos["docentes"] = $tabla_docentes->get_table();
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
        $tabla_docentes = new \App\Models\Tabla_docente;
        //arreglo temporal
        $docente = array();
        $docente["numeroempleado"] = $this->request->getPost("numeroempleado");
        $docente["gradoestudios"] = $this->request->getPost("gradoestudios");
        $docente["usuario_idusuario"] = $this->request->getPost("usuario");
        $docente["programa_educativo_idpe"] = $this->request->getPost("programa");

        if($tabla_docentes->create_data($docente)){
            mensaje("El docente se a registrado correctamente", "Petición Exitosa!", 1);
            return redirect()->to(route_to("administracion_docentes"));
        }else{
            mensaje("Hubo un problema al registrar al docente", "Error!", 3);
            return $this->index();

        }
    }


    
    public function eliminar($iddocente = 0) {
        $tabla_docentes = new \App\Models\Tabla_docente;
        
        // Verificar si el usuario existe
        $docente = $tabla_docentes->find($iddocente);
        if ($docente != null) {
            // Eliminar el usuario
            if ($tabla_docentes->delete($iddocente)) {
                mensaje("El docente se eliminó correctamente", "Eliminación Exitosa!", 1);
                return redirect()->to(route_to("administracion_docentes"));
            } else {
                mensaje("Ocurrió un error al procesar la eliminación", "Error al Eliminar!", 3);
                return $this->index($iddocente);
            }
        } else {
            mensaje("El docente que solicitas eliminar no se encuentra en la BD", "Error", 3);
            return $this->index($iddocente);
        }
    }
}   
