<?php

namespace App\Controllers\Panel\Docente;
use App\Controllers\BaseController;


class Detalles_docente extends BaseController {

    private $view = 'panel\docente\detalles_docente';

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


    private function cargar_datos($iddocente = 0){

        $datos = array();
    
        $datos['nombre_pagina'] = 'Detalles docente | Admin';
        $datos['titulo_pagina'] = 'Detalles docente';

        $datos['nombre_completo'] = $this->session->nombre_completo;
        $datos['nombre_user'] = $this->session->nombre;
        $datos['imagen_user'] = ($this->session->imagen_perfil == NULL) 
                                                            ? (($this->session->sexo != MASCULINO) ? 'icon-woman.png': 'icon-man.webp')
                                                            : $this->session->imagen_perfil;



        $breadcrumb = array(
            array(
                'href' => route_to("administracion_materias"),
                'titulo' => 'Docentes',    
            ),
            array(
                'href' => '#',
                'titulo' => 'Detalles docente',    
            )

        );

        $datos['breadcrumb_panel'] = breadcrumb_panel($datos['titulo_pagina'], $breadcrumb);

        // INFORMACION DEL SISTEMA 
        //BREADCRUM
        //PETICIONES- MODELOS JQUERY
        $tabla_docentes = new \App\Models\Tabla_docente;
        $datos['docente'] = $tabla_docentes->get_user(["iddocente" => $iddocente]);
        $datos["docentes"] = $tabla_docentes->get_table();
        $tabla_usuario = new \App\Models\Tabla_usuario;
        $datos["usuarios"] = $tabla_usuario->get_table();
        $tabla_programa = new \App\Models\Tabla_programa;
        $datos["programas"] = $tabla_programa->get_table();

        return $datos;
    }



    private function crear_vista($nombre_vista='', $contenido = array()){
        $contenido["menu_lateral"] = crear_menu_panel($this->session->tarea_actual,$this->session->rol_actual);
        return view($nombre_vista,$contenido);  
    }



    public function index($iddocente = 0 ) {
        // Verificar permisos
        if ($this->permiso) {
            // Cargar datos generales para la vista
            $datos = $this->cargar_datos($iddocente);

            $tabla_docentes = new \App\Models\Tabla_docente;

            if($tabla_docentes->find($iddocente) == null){
                mensaje("El docente que solicitaste no se encuentra en la BD", "Error", 3);
                return redirect()->to(route_to("administracion_docentes"));
            }else{
                return $this->crear_vista($this->view, $this->cargar_datos($iddocente));
            }

        } else {
            mensaje("No tienes permisos para acceder a este modulo, contacte al administrador", "Error", 3);
            return redirect()->to(route_to("acceso"));
        }
    }

    public function actualizar($iddocente = 0){

        $tabla_docentes = new \App\Models\Tabla_docente;
        if($tabla_docentes->find($iddocente) != null){
        
            //arreglo temporal
            $docente = array();
            $docente["numeroempleado"] = $this->request->getPost("numeroempleado");
            $docente["gradoestudios"] = $this->request->getPost("gradoestudios");
            $docente["usuario_idusuario"] = $this->request->getPost("usuario");
            $docente["programa_educativo_idpe"] = $this->request->getPost("programa");
    
            //-------------------------
            // UPDATE
            //-------------------------
            if($tabla_docentes->update_data($iddocente,$docente)){
                mensaje("El docente se actualizo correctamente", "Actualización Exitosa!", 1);
                return redirect()->to(route_to("administracion_docentes"));
            }else{
                mensaje("Ocurrio un error al procesar la actualización" , "Error al Actualizar!", 3);
                return $this->index($iddocente);
            }

        }else{
            mensaje("El docente que solicitas actualizar no se encuentra en la BD", "Error", 3);
            return $this->index($iddocente);
        }

    }  
    } 
