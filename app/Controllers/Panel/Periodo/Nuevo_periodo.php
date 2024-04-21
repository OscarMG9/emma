<?php

namespace App\Controllers\Panel\Periodo;
use App\Controllers\BaseController;
use App\Models\Tabla_periodo;


class Nuevo_periodo extends BaseController {

    private $view = 'panel\periodo\nuevo_periodo';

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
    
        $datos['nombre_pagina'] = 'Registrar periodo | Admin';
        $datos['titulo_pagina'] = 'Registrar periodo';

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
                'titulo' => 'Registrar periodo',    
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
        $tabla_periodos = new \App\Models\Tabla_periodo;
        //arreglo temporal
        $periodo = array();
        $periodo["nombreperiodo"] = $this->request->getPost("nombreperiodo");
        $periodo["acronimo"] = $this->request->getPost("acronimo");
        $periodo["fechainicio"] = $this->request->getPost("fechainicio");
        $periodo["fechafin"] = $this->request->getPost("fechafin");
        $periodo["estatus"] = ESTATUS_HABILITADO;



        if($tabla_periodos->create_data($periodo)){
            mensaje("El periodo se a registrado correctamente", "Petición Exitosa!", 1);
            return redirect()->to(route_to("administracion_periodos"));
        }else{
            mensaje("Hubo un problema al registrar el periodo", "Error!", 3);
            return $this->index();

        }
    }


    
    public function eliminar($idperiodo = 0) {
        $tabla_periodos = new \App\Models\Tabla_periodo;
        
        // Verificar si el usuario existe
        $periodo = $tabla_periodos->find($idperiodo);
        if ($periodo != null) {
            // Eliminar el usuario
            if ($tabla_periodos->delete($idperiodo)) {
                mensaje("El periodo se eliminó correctamente", "Eliminación Exitosa!", 1);
                return redirect()->to(route_to("administracion_periodos"));
            } else {
                mensaje("Ocurrió un error al procesar la eliminación", "Error al Eliminar!", 3);
                return $this->index($idperiodo);
            }
        } else {
            mensaje("El periodo que solicitas eliminar no se encuentra en la BD", "Error", 3);
            return $this->index($idperiodo);
        }
    }
}   
