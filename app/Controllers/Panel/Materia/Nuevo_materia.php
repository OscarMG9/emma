<?php

namespace App\Controllers\Panel\Materia;
use App\Controllers\BaseController;
use App\Models\Tabla_materia;


class Nuevo_materia extends BaseController {

    private $view = 'panel\materia\nuevo_materia';

    private $session = NULL;
    private $permiso = TRUE;
    
    public function __construct(){
        //instancia de la variable de sesion
        $this->session = session();
    
        //instancia del permisos helper
        helper("permisos_roles_helper");

        if (!acceso_usuario(TAREA_MATERIAS, $this->session->rol_actual)){
            $this->permiso = FALSE;
        }
        $this->session->tarea_actual = TAREA_MATERIAS;
    }//end constructor


    private function cargar_datos(){

        $datos = array();
    
        $datos['nombre_pagina'] = 'Registrar materia | Admin';
        $datos['titulo_pagina'] = 'Registrar materia';

        $datos['nombre_completo'] = $this->session->nombre_completo;
        $datos['nombre_user'] = $this->session->nombre;
        $datos['imagen_user'] = ($this->session->imagen_perfil == NULL) 
                                                            ? (($this->session->sexo != MASCULINO) ? 'icon-woman.png': 'icon-man.webp')
                                                            : $this->session->imagen_perfil;



        $breadcrumb = array(
            array(
                'href' => route_to("administracion_materias"),
                'titulo' => 'Materias',    
            ),
            array(
                'href' => '#',
                'titulo' => 'Registrar materia',    
            )

        );

        $datos['breadcrumb_panel'] = breadcrumb_panel($datos['titulo_pagina'], $breadcrumb);

        // INFORMACION DEL SISTEMA 
        //BREADCRUM
        //PETICIONES- MODELOS JQUERY

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
        $tabla_materias = new \App\Models\Tabla_materia;
        //arreglo temporal
        $asignatura = array();
        $asignatura["asignatura"] = $this->request->getPost("materia");
        $asignatura["acronimo"] = $this->request->getPost("acronimo");
        $asignatura["creditos"] = $this->request->getPost("creditos");


        if($tabla_materias->create_data($asignatura)){
            mensaje("La materia se a registrado correctamente", "Petición Exitosa!", 1);
            return redirect()->to(route_to("administracion_materias"));
        }else{
            mensaje("Hubo un problema al registrar la materia", "Error!", 3);
            return $this->index();

        }
    }


    
    public function eliminar($idasignatura = 0) {
        $tabla_materias = new \App\Models\Tabla_materia;
        
        // Verificar si el usuario existe
        $asignatura = $tabla_materias->find($idasignatura);
        if ($asignatura != null) {
            // Eliminar el usuario
            if ($tabla_materias->delete($idasignatura)) {
                mensaje("La materia se eliminó correctamente", "Eliminación Exitosa!", 1);
                return redirect()->to(route_to("administracion_materias"));
            } else {
                mensaje("Ocurrió un error al procesar la eliminación", "Error al Eliminar!", 3);
                return $this->index($idasignatura);
            }
        } else {
            mensaje("La materia que solicitas eliminar no se encuentra en la BD", "Error", 3);
            return $this->index($idasignatura);
        }
    }
}   
