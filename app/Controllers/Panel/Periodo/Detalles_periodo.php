<?php

namespace App\Controllers\Panel\Periodo;
use App\Controllers\BaseController;


class Detalles_periodo extends BaseController {

    private $view = 'panel\periodo\detalles_periodo';

    private $session = NULL;
    private $permiso = TRUE;
    
    public function __construct(){
        //instancia de la variable de sesion
        $this->session = session();
    
        //instancia del permisos helper
        helper("permisos_roles_helper");

        if (!acceso_usuario(TAREA_PERIODOS, $this->session->rol_actual)){
            $this->permiso = FALSE;
        }
        $this->session->tarea_actual = TAREA_PERIODOS;
    }//end constructor


    private function cargar_datos($idperiodo = 0){

        $datos = array();
    
        $datos['nombre_pagina'] = 'Detalles periodo | Admin';
        $datos['titulo_pagina'] = 'Detalles periodo';

        $datos['nombre_completo'] = $this->session->nombre_completo;
        $datos['nombre_user'] = $this->session->nombre;
        $datos['imagen_user'] = ($this->session->imagen_perfil == NULL) 
                                                            ? (($this->session->sexo != MASCULINO) ? 'icon-woman.png': 'icon-man.webp')
                                                            : $this->session->imagen_perfil;



        $breadcrumb = array(
            array(
                'href' => route_to("administracion_periodos"),
                'titulo' => 'Periodos',    
            ),
            array(
                'href' => '#',
                'titulo' => 'Detalles periodo',    
            )

        );

        $datos['breadcrumb_panel'] = breadcrumb_panel($datos['titulo_pagina'], $breadcrumb);

        // INFORMACION DEL SISTEMA 
        //BREADCRUM
        //PETICIONES- MODELOS JQUERY
        $tabla_periodos = new \App\Models\Tabla_periodo;
        
        $datos['periodo'] = $tabla_periodos->get_user(["idperiodo" => $idperiodo]);

        return $datos;
    }



    private function crear_vista($nombre_vista='', $contenido = array()){
        $contenido["menu_lateral"] = crear_menu_panel($this->session->tarea_actual,$this->session->rol_actual);
        return view($nombre_vista,$contenido);  
    }



    public function index($idperiodo = 0 ) {
        // Verificar permisos
        if ($this->permiso) {
            // Cargar datos generales para la vista
            $datos = $this->cargar_datos($idperiodo);

            $tabla_periodos = new \App\Models\Tabla_periodo;

            if($tabla_periodos->find($idperiodo) == null){
                mensaje("El periodo que solicitaste no se encuentra en la BD", "Error", 3);
                return redirect()->to(route_to("administracion_periodos"));
            }else{
                return $this->crear_vista($this->view, $this->cargar_datos($idperiodo));
            }

        } else {
            mensaje("No tienes permisos para acceder a este modulo, contacte al administrador", "Error", 3);
            return redirect()->to(route_to("acceso"));
        }
    }

    public function actualizar($idperiodo = 0){

        $tabla_periodos = new \App\Models\Tabla_periodo;
        if($tabla_periodos->find($idperiodo) != null){
        
            //arreglo temporal
            $periodo = array();
            $periodo["nombreperiodo"] = $this->request->getPost("nombreperiodo");
            $periodo["acronimo"] = $this->request->getPost("acronimo");
            $periodo["fechainicio"] = $this->request->getPost("fechainicio");
            $periodo["fechafin"] = $this->request->getPost("fechafin");
    
            //-------------------------
            // UPDATE
            //-------------------------
            if($tabla_periodos->update_data($idperiodo,$periodo)){
                mensaje("El periodo se actualizo correctamente", "Actualización Exitosa!", 1);
                return redirect()->to(route_to("administracion_periodos"));
            }else{
                mensaje("Ocurrio un error al procesar la actualización" , "Error al Actualizar!", 3);
                return $this->index($idperiodo);
            }

        }else{
            mensaje("El periodo que solicitas actualizar no se encuentra en la BD", "Error", 3);
            return $this->index($idperiodo);
        }

    }  
    } 
