<?php

namespace App\Controllers\Panel\AsigAlum;
use App\Controllers\BaseController;
use App\Models\Tabla_alumno;


class Nuevo_alumno extends BaseController {

    private $view = 'panel\asigalum\nuevo_alumno';

    private $session = NULL;
    private $permiso = TRUE;
    
    public function __construct(){
        //instancia de la variable de sesion
        $this->session = session();
    
        //instancia del permisos helper
        helper("permisos_roles_helper");

        if (!acceso_usuario(TAREA_ASIGALUM, $this->session->rol_actual)){
            $this->permiso = FALSE;
        }
        $this->session->tarea_actual = TAREA_ASIGALUM;
    }//end constructor


    private function cargar_datos(){
 
        $datos = array();
    
        $datos['nombre_pagina'] = 'Registrar alumnos | Admin';
        $datos['titulo_pagina'] = 'Registrar alumnos';

        $datos['nombre_completo'] = $this->session->nombre_completo;
        $datos['nombre_user'] = $this->session->nombre;
        $datos['imagen_user'] = ($this->session->imagen_perfil == NULL) 
                                                            ? (($this->session->sexo != MASCULINO) ? 'icon-woman.png': 'icon-man.webp')
                                                            : $this->session->imagen_perfil;



        $breadcrumb = array(
            array(
                'href' => route_to("administracion_usuarios"),
                'titulo' => 'Alumnos',    
            ),
            array(
                'href' => '#',
                'titulo' => 'Asignar alumno',    
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

        $tabla_calificacion= new \App\Models\Tabla_calificaciones;
        $datos["calificaciones"] = $tabla_calificacion->get_table();
        $tabla_alumno= new \App\Models\Tabla_alumno;
        $datos["alumnos"] = $tabla_alumno->get_table();
        $tabla_listaalum= new \App\Models\Tabla_listaalum;
        $datos["listaalums"] = $tabla_listaalum->get_table();
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
        $alumno = array();
        $alumno["matricula"] = $this->request->getPost("matricula");
        $alumno["grado"] = $this->request->getPost("grado");
        $alumno["grupo"] = $this->request->getPost("grupo");
        $alumno["idusuario"] = $this->request->getPost("alumno");
        $tabla_alumnos = new \App\Models\Tabla_alumno;
        if($tabla_alumnos->create_data($alumno)){
            mensaje("El alumno se a registrado correctamente", "Petición Exitosa!", 1);
            return redirect()->to(route_to("administracion_asignacionalums"));
        }else{
            mensaje("Hubo un problema al realizar el registro", "Error!", 3);
            return $this->index();

        }
        
    }

    public function eliminarAlumno($idAlumno) {
        // Eliminar el alumno
        $tabla_alumnos = new \App\Models\Tabla_alumno;
        if ($tabla_alumnos->delete($idAlumno)) {
            // Eliminar la lista asociada al alumno
            $tabla_listas = new \App\Models\Tabla_listaalum;
            // Buscar la lista asociada al alumno
            $lista = $tabla_listas->where('alumno_idalumno', $idAlumno)->first();
            if ($lista) {
                // Si se encuentra la lista, eliminarla
                $idLista = $lista['idLista']; // Asumiendo que 'idLista' es el nombre del campo ID de la lista
                if ($tabla_listas->delete($idLista)) {
                    // Eliminar las calificaciones asociadas a la lista
                    $tabla_calificaciones = new \App\Models\Tabla_calificaciones;
                    $calificaciones = $tabla_calificaciones->where('lista_alumnos_idlista_alumnos', $idLista)->findAll();
                    foreach ($calificaciones as $calificacion) {
                        $idCalificacion = $calificacion['idCalificacion']; // Asumiendo que 'idCalificacion' es el nombre del campo ID de la calificación
                        $tabla_calificaciones->delete($idCalificacion);
                    }
                    mensaje("El alumno y sus datos asociados se han eliminado correctamente", "Eliminación Exitosa!", 1);
                } else {
                    mensaje("Hubo un problema al eliminar la lista asociada al alumno", "Error!", 3);
                }
            } else {
                mensaje("No se encontró la lista asociada al alumno", "Error!", 3);
            }
            return redirect()->to(route_to("administracion_asignacionalums"));
        } else {
            mensaje("Hubo un problema al eliminar al alumno", "Error!", 3);
            return $this->index($idAlumno);
        }
    }
    
}   
