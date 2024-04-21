<?php

namespace App\Controllers\Panel;
use App\Controllers\BaseController;


class Dashboard extends BaseController {

    private $view = 'panel\dashboard';

    private $session = NULL;
    private $permiso = TRUE;
    
    public function __construct(){
        //instancia de la variable de sesion
        $this->session = session();
    
        //instancia del permisos helper
        helper("permisos_roles_helper");

        if (!acceso_usuario(TAREA_DASHBOARD, $this->session->rol_actual)){
            $this->permiso = FALSE;
        }
        $this->session->tarea_actual = TAREA_DASHBOARD;
    }//end constructor


    private function cargar_datos(){

        $datos = array();
    
        $datos['nombre_pagina'] = 'Dashboard';
        $datos['titulo_pagina'] = 'Dashboard';

        $datos['nombre_completo'] = $this->session->nombre_completo;
        $datos['nombre_user'] = $this->session->nombre;
        $datos['imagen_user'] = ($this->session->imagen_perfil == NULL) 
                                                            ? (($this->session->sexo != MASCULINO) ? 'icon-woman.png': 'icon-man.webp')
                                                            : $this->session->imagen_perfil;



        $breadcrumb = array(
            array(
                'href' => '#',
                'titulo' => 'dashboard',    
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
    public function index(){

        if ($this->permiso){
            return $this-> crear_vista($this->view,$this->cargar_datos());
        }else{
            mensaje("No tienes permisos para acceder a este modulo, contacte al administrador", "Error", 3);
            return redirect()->to(route_to("acceso"));
        }

    }
}   
