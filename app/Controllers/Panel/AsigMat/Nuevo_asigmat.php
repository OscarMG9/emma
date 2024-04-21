<?php

namespace App\Controllers\Panel\AsigMat;
use App\Controllers\BaseController;
use App\Models\Tabla_asigmat;


class Nuevo_asigmat extends BaseController {

    private $view = 'panel\asigmat\nuevo_asigmat';

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


    private function cargar_datos(){

        $datos = array();
    
        $datos['nombre_pagina'] = 'Asignar materias | Admin';
        $datos['titulo_pagina'] = 'Asignar materias';

        $datos['nombre_completo'] = $this->session->nombre_completo;
        $datos['nombre_user'] = $this->session->nombre;
        $datos['imagen_user'] = ($this->session->imagen_perfil == NULL) 
                                                            ? (($this->session->sexo != MASCULINO) ? 'icon-woman.png': 'icon-man.webp')
                                                            : $this->session->imagen_perfil;



        $breadcrumb = array(
            array(
                'href' => route_to("administracion_usuarios"),
                'titulo' => 'Materias',    
            ),
            array(
                'href' => '#',
                'titulo' => 'Asignar materia',    
            )

        );

        $datos['breadcrumb_panel'] = breadcrumb_panel($datos['titulo_pagina'], $breadcrumb);

        // INFORMACION DEL SISTEMA 
        //BREADCRUM
        //PETICIONES- MODELOS JQUERY

        $tabla_asigmat= new \App\Models\Tabla_asigmat;
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
        //arreglo temporal
        $asigmat = array();

        $asigmat["asignatura_idasignatura"] = $this->request->getPost("asignatura");
        $asigmat["docente_iddocente"] = $this->request->getPost("docente");
        $asigmat["periodo_idperiodo"] = $this->request->getPost("periodo");
        $asigmat["fecha_asignacion"] = $this->request->getPost("fechaasignacion");


        $tabla_asigmats = new \App\Models\Tabla_asigmat;
        if($tabla_asigmats->create_data($asigmat)){
            mensaje("La asignación se a registrado correctamente", "Petición Exitosa!", 1);
            return redirect()->to(route_to("administracion_asignacionmats"));
        }else{
            mensaje("Hubo un problema al asignar la materia", "Error!", 3);
            return $this->index();

        }
    }


    
    public function eliminar($idcarga_horaria = 0) {
        $tabla_asigmats = new \App\Models\Tabla_asigmat;
        
        // Verificar si el usuario existe
        $carga = $tabla_asigmats->find($idcarga_horaria);
        if ($carga != null) {
            // Eliminar el usuario
            if ($tabla_asigmats->delete($idcarga_horaria)) {
                mensaje("La asignacion se eliminó correctamente", "Eliminación Exitosa!", 1);
                return redirect()->to(route_to("administracion_asignacionmats"));
            } else {
                mensaje("Ocurrió un error al procesar la eliminación", "Error al Eliminar!", 3);
                return $this->index($idcarga_horaria);
            }
        } else {
            mensaje("La asignación que solicitas eliminar no se encuentra en la BD", "Error", 3);
            return $this->index($idcarga_horaria);
        }
    }
}   
