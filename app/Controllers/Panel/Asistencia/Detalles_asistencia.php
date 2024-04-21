<?php

namespace App\Controllers\Panel\Asistencia;
use App\Controllers\BaseController;


class Detalles_asistencia extends BaseController {

    private $view = 'panel\asistencia\detalles_asistencia';

    private $session = NULL;
    private $permiso = TRUE;

    public function __construct(){
        //instancia de la variable de sesion
        $this->session = session();
    
        //instancia del permisos helper
        helper("permisos_roles_helper");

        if (!acceso_usuario(TAREA_ASISTENCIAS, $this->session->rol_actual)){
            $this->permiso = FALSE;
        }
        $this->session->tarea_actual = TAREA_ASISTENCIAS;
    }//end constructor


    private function cargar_datos($idlista_alumnos = 0){

        $datos = array();
    
        $datos['nombre_pagina'] = 'Pase de asistencia | Docente';
        $datos['titulo_pagina'] = 'Pase de asistencia';

        $datos['id_docente'] = $this->session->idusuario;
        $datos['nombre_completo'] = $this->session->nombre_completo;
        $datos['nombre_user'] = $this->session->nombre;
        $datos['imagen_user'] = ($this->session->imagen_perfil == NULL) 
                                                            ? (($this->session->sexo != MASCULINO) ? 'icon-woman.png': 'icon-man.webp')
                                                            : $this->session->imagen_perfil;



        $breadcrumb = array(
            array(
                'href' => route_to("administracion_materias"),
                'titulo' => 'Alumnos',    
            ),
            array(
                'href' => '#',
                'titulo' => 'Estatus alumno',    
            )

        );

        $datos['breadcrumb_panel'] = breadcrumb_panel($datos['titulo_pagina'], $breadcrumb);

        // INFORMACION DEL SISTEMA 
        //BREADCRUM
        //PETICIONES- MODELOS JQUERY
        $tabla_docentes = new \App\Models\Tabla_docente;
        $datos["docentes"] = $tabla_docentes->get_table();
        $tabla_usuario = new \App\Models\Tabla_usuario;
        $datos["usuarios"] = $tabla_usuario->get_table();
        $tabla_programa = new \App\Models\Tabla_programa;
        $datos["programas"] = $tabla_programa->get_table();
        $tabla_carga = new \App\Models\Tabla_asigmat;
        $datos["cargas"] = $tabla_carga->get_table();
        $tabla_periodo = new \App\Models\Tabla_periodo;
        $datos["periodos"] = $tabla_periodo->get_table();
        $tabla_asignatura = new \App\Models\Tabla_materia;
        $datos["listasalu"] = $tabla_asignatura->get_table();
        $tabla_lista = new \App\Models\Tabla_listaalum;
        $datos["listas"] = $tabla_lista ->get_table();
        $datos['lista'] = $tabla_lista ->get_user(["idlista_alumnos" => $idlista_alumnos]);

        return $datos;
    }



    private function crear_vista($nombre_vista='', $contenido = array()){
        $contenido["menu_lateral"] = crear_menu_panel($this->session->tarea_actual,$this->session->rol_actual);
        return view($nombre_vista,$contenido);  
    }


    public function index($idlista_alumnos = 0) {
        // Verificar permisos
        if ($this->permiso) {
            // Cargar datos generales para la vista
            $datos = $this->cargar_datos($idlista_alumnos); // Aquí se pasa $idcarga_horaria
            $tabla_carga = new \App\Models\Tabla_listaalum;
    
            if($tabla_carga->find($idlista_alumnos) == null){
                mensaje("El docente que solicitaste no se encuentra en la BD", "Error", 3);
                return redirect()->to(route_to("operador_alumnos"));
            } else {
                return $this->crear_vista($this->view, $datos); // Aquí se pasa $datos en lugar de cargar_datos($idcarga_horaria)
            }
        } else {
            mensaje("No tienes permisos para acceder a este modulo, contacte al administrador", "Error", 3);
            return redirect()->to(route_to("acceso"));
        }
    }


    public function actualizar($idlista_alumnos = 0){

        $tabla_lista = new \App\Models\Tabla_listaalum;
        if($tabla_lista->find($idlista_alumnos) != null){
        
            //arreglo temporal
            $asistencia = array();
            $asistencia["tipo_asistencia"] = $this->request->getPost("asistencia");
            $asistencia["fecha_asistencia"] = $this->request->getPost("fechaasistencia");

            //-------------------------
            // UPDATE
            //-------------------------
            if($tabla_lista->update_data($idlista_alumnos,$asistencia)){
                mensaje("La asistencia se actualizo correctamente", "Actualización Exitosa!", 1);
                return redirect()->to(route_to("operador_asistencias"));
            }else{
                mensaje("Ocurrio un error al procesar la actualización" , "Error al Actualizar!", 3);
                return $this->index($idlista_alumnos);
            }

        }else{
            mensaje("la asistencia que solicitas actualizar no se encuentra en la BD", "Error", 3);
            return $this->index($idlista_alumnos);
        }

    }  
    }
