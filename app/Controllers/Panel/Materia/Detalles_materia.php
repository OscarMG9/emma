<?php

namespace App\Controllers\Panel\Materia;
use App\Controllers\BaseController;


class Detalles_materia extends BaseController {

    private $view = 'panel\materia\detalles_materia';

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


    private function cargar_datos($idasignatura = 0){

        $datos = array();
    
        $datos['nombre_pagina'] = 'Detalles materia | Admin';
        $datos['titulo_pagina'] = 'Detalles materia';

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
                'titulo' => 'Detalles materia',    
            )

        );

        $datos['breadcrumb_panel'] = breadcrumb_panel($datos['titulo_pagina'], $breadcrumb);

        // INFORMACION DEL SISTEMA 
        //BREADCRUM
        //PETICIONES- MODELOS JQUERY
        $tabla_materias = new \App\Models\Tabla_materia;
        
        $datos['asignatura'] = $tabla_materias->get_user(["idasignatura" => $idasignatura]);

        return $datos;
    }



    private function crear_vista($nombre_vista='', $contenido = array()){
        $contenido["menu_lateral"] = crear_menu_panel($this->session->tarea_actual,$this->session->rol_actual);
        return view($nombre_vista,$contenido);  
    }



    public function index($idasignatura = 0 ) {
        // Verificar permisos
        if ($this->permiso) {
            // Cargar datos generales para la vista
            $datos = $this->cargar_datos($idasignatura);

            $tabla_materias = new \App\Models\Tabla_materia;

            if($tabla_materias->find($idasignatura) == null){
                mensaje("La materia que solicitaste no se encuentra en la BD", "Error", 3);
                return redirect()->to(route_to("administracion_materias"));
            }else{
                return $this->crear_vista($this->view, $this->cargar_datos($idasignatura));
            }

        } else {
            mensaje("No tienes permisos para acceder a este modulo, contacte al administrador", "Error", 3);
            return redirect()->to(route_to("acceso"));
        }
    }

    public function actualizar($idasignatura = 0){

        $tabla_materias = new \App\Models\Tabla_materia;
        if($tabla_materias->find($idasignatura) != null){
        
            //arreglo temporal
            $asignatura = array();
            $asignatura["asignatura"] = $this->request->getPost("materia");
            $asignatura["acronimo"] = $this->request->getPost("acronimo");
            $asignatura["creditos"] = $this->request->getPost("creditos");
    
            //-------------------------
            // UPDATE
            //-------------------------
            if($tabla_materias->update_data($idasignatura,$asignatura)){
                mensaje("la materia se actualizo correctamente", "Actualización Exitosa!", 1);
                return redirect()->to(route_to("administracion_materias"));
            }else{
                mensaje("Ocurrio un error al procesar la actualización" , "Error al Actualizar!", 3);
                return $this->index($idasignatura);
            }

        }else{
            mensaje("La materia que solicitas actualizar no se encuentra en la BD", "Error", 3);
            return $this->index($idasignatura);
        }

    }  
    } 
