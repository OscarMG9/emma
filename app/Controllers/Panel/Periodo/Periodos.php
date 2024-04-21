<?php

namespace App\Controllers\Panel\Periodo;
use App\Controllers\BaseController;


class Periodos extends BaseController {

    private $view = 'panel\periodo\periodos';

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


    private function cargar_datos(){

        $datos = array();
    
        $datos['nombre_pagina'] = 'Periodos | Admin';
        $datos['titulo_pagina'] = 'Periodos';

        $datos['nombre_completo'] = $this->session->nombre_completo;
        $datos['nombre_user'] = $this->session->nombre;
        $datos['imagen_user'] = ($this->session->imagen_perfil == NULL) 
                                                            ? (($this->session->sexo != MASCULINO) ? 'icon-woman.png': 'icon-man.webp')
                                                            : $this->session->imagen_perfil;



        $breadcrumb = array(
            array(
                'href' => '#',
                'titulo' => 'Periodo',    
            )

        );

        $datos['breadcrumb_panel'] = breadcrumb_panel($datos['titulo_pagina'], $breadcrumb);

        // INFORMACION DEL SISTEMA 
        //BREADCRUM
        //PETICIONES- MODELOS JQUERY

        $tabla_periodo = new \App\Models\Tabla_periodo;
        $datos["periodos"] = $tabla_periodo->get_table();

        
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
    

    public function estatus($idperiodo= 0 ,$estatus = FALSE){
        $tabla_periodos = new \App\Models\Tabla_periodo;

        if($tabla_periodos->find($idperiodo) != null){
            //-------------------------
            // UPDATE
            //-------------------------
            if($tabla_periodos->update_data($idperiodo,["estatus" => $estatus])){
                mensaje("El estatus se actualizo correctamente", "Actualización Exitosa!", 1);
                return redirect()->to(route_to("administracion_periodos"));
            }else{
                mensaje("Ocurrio un error al procesar la actualización del estatus" , "Error al Actualizar!", 3);
            }

        }else{
            mensaje("El estatus no se ha encontrado", "Oppps!", 2);
        }
        return redirect()->to(route_to("administracion_periodos"));
    }
}   
