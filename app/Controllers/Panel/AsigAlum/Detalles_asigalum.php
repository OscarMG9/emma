<?php

namespace App\Controllers\Panel\AsigMat;
use App\Controllers\BaseController;


class Detalles_asigmat extends BaseController {

    private $view = 'panel\asigmat\detalles_asigmat';

    private $session = NULL;
    private $permiso = TRUE;
    
    public function __construct(){
        //instancia de la variable de sesion
        $this->session = session();
    
        //instancia del permisos helper
        helper("permisos_roles_helper");

        if (!acceso_usuario(TAREA_ASIGMAT, $this->session->rol_actual)){
            $this->permiso = FALSE;
        }
        $this->session->tarea_actual = TAREA_ASIGMAT;
    }//end constructor


    private function cargar_datos($idasigmat = 0){

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
                'href' => route_to("administracion_asignacionmats"),
                'titulo' => 'Asignaciones',    
            ),
            array(
                'href' => '#',
                'titulo' => 'Detalles asignación materia',    
            )

        );

        $datos['breadcrumb_panel'] = breadcrumb_panel($datos['titulo_pagina'], $breadcrumb);

        // INFORMACION DEL SISTEMA 
        //BREADCRUM
        //PETICIONES- MODELOS JQUERY

        $tabla_asigmat= new \App\Models\Tabla_asigmat;
        $datos['asigmat'] = $tabla_asigmat->get_user(["idcarga_horaria" => $idasigmat]);
        $datos["asigmats"] = $tabla_asigmat->get_table();
        $tabla_docentes = new \App\Models\Tabla_docente;
        $datos["docentes"] = $tabla_docentes->get_table();
        $tabla_usuario = new \App\Models\Tabla_usuario;
        $datos["usuarios"] = $tabla_usuario->get_table();
        $tabla_programa = new \App\Models\Tabla_programa;
        $datos["programas"] = $tabla_programa->get_table();
        $tabla_materia = new \App\Models\Tabla_materia;
        $datos["materias"] = $tabla_materia->get_table();
        $tabla_periodo = new \App\Models\Tabla_periodo;
        $datos["periodos"] = $tabla_periodo->get_table();
        return $datos;
    }



    private function crear_vista($nombre_vista='', $contenido = array()){
        $contenido["menu_lateral"] = crear_menu_panel($this->session->tarea_actual,$this->session->rol_actual);
        return view($nombre_vista,$contenido);  
    }



    public function index($idasigmat = 0 ) {
        // Verificar permisos
        if ($this->permiso) {
            // Cargar datos generales para la vista
            $datos = $this->cargar_datos($idasigmat);

            $tabla_asigmats = new \App\Models\Tabla_asigmat;

            if($tabla_asigmats->find($idasigmat) == null){
                mensaje("La asignación que solicitaste no se encuentra en la BD", "Error", 3);
                return redirect()->to(route_to("administracion_asignacionmats"));
            }else{
                return $this->crear_vista($this->view, $this->cargar_datos($idasigmat));
            }

        } else {
            mensaje("No tienes permisos para acceder a este modulo, contacte al administrador", "Error", 3);
            return redirect()->to(route_to("acceso"));
        }
    }

    public function actualizar($idasigmat = 0){

        $tabla_asigmats = new \App\Models\Tabla_asigmat;
        if($tabla_asigmats->find($idasigmat) != null){
        
            //arreglo temporal
            $asigmat = array();

            $asigmat["asignatura_idasignatura"] = $this->request->getPost("asignatura");
            $asigmat["docente_iddocente"] = $this->request->getPost("docente");
            $asigmat["periodo_idperiodo"] = $this->request->getPost("periodo");
            $asigmat["fecha_asignacion"] = $this->request->getPost("fechaasignacion");
            //-------------------------
            // UPDATE
            //-------------------------
            if($tabla_asigmats->update_data($idasigmat,$asigmat)){
                mensaje("La asignación se actualizo correctamente", "Actualización Exitosa!", 1);
                return redirect()->to(route_to("administracion_asignacionmats"));
            }else{
                mensaje("Ocurrio un error al procesar la actualización" , "Error al Actualizar!", 3);
                return $this->index($idasigmat);
            }

        }else{
            mensaje("la asignación que solicitas actualizar no se encuentra en la BD", "Error", 3);
            return $this->index($idasigmat);
        }

    }  
    } 
