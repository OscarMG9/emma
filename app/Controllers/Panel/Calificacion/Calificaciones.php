<?php

namespace App\Controllers\Panel\Calificacion;
use App\Controllers\BaseController;


class Calificaciones extends BaseController {

    private $view = 'panel\calificacion\calificaciones';

    private $session = NULL;
    private $permiso = TRUE;

    public function __construct(){
        //instancia de la variable de sesion
        $this->session = session();
    
        //instancia del permisos helper
        helper("permisos_roles_helper");

        if (!acceso_usuario(TAREA_CALIFICACIONES, $this->session->rol_actual)){
            $this->permiso = FALSE;
        }
        $this->session->tarea_actual = TAREA_CALIFICACIONES;
    }//end constructor


    private function cargar_datos(){

        $datos = array();
    
        $datos['nombre_pagina'] = 'Calificaciones  | Docente';
        $datos['titulo_pagina'] = 'Calificaciones';

        $datos['id_docente'] = $this->session->idusuario;
        $datos['nombre_completo'] = $this->session->nombre_completo;
        $datos['nombre_user'] = $this->session->nombre;
        $datos['imagen_user'] = ($this->session->imagen_perfil == NULL) 
                                                            ? (($this->session->sexo != MASCULINO) ? 'icon-woman.png': 'icon-man.webp')
                                                            : $this->session->imagen_perfil;



        $breadcrumb = array(
            array(
                'href' => '#',
                'titulo' => 'Calficaciones',    
            )

        );

        $datos['breadcrumb_panel'] = breadcrumb_panel($datos['titulo_pagina'], $breadcrumb);

        // INFORMACION DEL SISTEMA 
        //BREADCRUM
        //PETICIONES- MODELOS JQUERY

        $tabla_docentes = new \App\Models\Tabla_docente;
        $datos["docentes"] = $tabla_docentes->get_table();
        $tabla_carga = new \App\Models\Tabla_asigmat;
        $datos["cargas"] = $tabla_carga->get_table();
        $tabla_usuario = new \App\Models\Tabla_usuario;
        $datos["usuarios"] = $tabla_usuario->get_table();
        $tabla_asignatura = new \App\Models\Tabla_materia;
        $datos["materias"] = $tabla_asignatura->get_table();
        $tabla_programa = new \App\Models\Tabla_programa;
        $datos["programas"] = $tabla_programa->get_table();
        $tabla_periodo = new \App\Models\Tabla_periodo;
        $datos["periodos"] = $tabla_periodo->get_table();
        $tabla_alumnos = new \App\Models\Tabla_alumno;
        $datos["alumnos"] = $tabla_alumnos->get_table();
        $tabla_lista = new \App\Models\Tabla_listaalum;
        $datos["listas"] = $tabla_lista->get_table();
        $tabla_calificaciones = new \App\Models\Tabla_calificaciones;
        $datos["calificaciones"] = $tabla_calificaciones->get_table();

        
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
    
}   
