<?php

namespace App\Controllers\Panel\Calificacion;

use App\Controllers\BaseController;

class Detalles_calificacion extends BaseController
{

    private $view = 'panel\calificacion\detalles_calificacion';

    private $session = NULL;
    private $permiso = TRUE;
    private $tabla_asigmat; // Instancia de la clase Tabla_asigmat

    public function __construct()
    {
        //instancia de la variable de sesion
        $this->session = session();

        //instancia del permisos helper
        helper("permisos_roles_helper");

        if (!acceso_usuario(TAREA_CALIFICACIONES, $this->session->rol_actual)) {
            $this->permiso = FALSE;
        }
        $this->session->tarea_actual = TAREA_CALIFICACIONES;

        
  // Instancia de Tabla_asigmat
  $this->tabla_asigmat = new \App\Models\Tabla_asigmat();
    } //end constructor


    private function cargar_datos($idcalificaciones = 0)
    {

        $datos = array();

        $datos['nombre_pagina'] = 'Actualizar Calificaciones | Docente';
        $datos['titulo_pagina'] = 'Actualizar Calificaciones';

        $datos['id_docente'] = $this->session->idusuario;
        $datos['nombre_completo'] = $this->session->nombre_completo;
        $datos['nombre_user'] = $this->session->nombre;
        $datos['imagen_user'] = ($this->session->imagen_perfil == NULL) ?
            (($this->session->sexo != MASCULINO) ? 'icon-woman.png' : 'icon-man.webp') :
            $this->session->imagen_perfil;

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
        $datos["asignaturas"] = $tabla_asignatura->get_table();
        $tabla_lista = new \App\Models\Tabla_listaalum;
        $datos["listas"] = $tabla_lista->get_table();
        $tabla_cali = new \App\Models\Tabla_calificaciones;
        $datos['calificacion'] = $tabla_cali->get_user(["idcalificaciones" => $idcalificaciones]);

        return $datos;
    }



    private function crear_vista($nombre_vista = '', $contenido = array())
    {
        $contenido["menu_lateral"] = crear_menu_panel($this->session->tarea_actual, $this->session->rol_actual);
        return view($nombre_vista, $contenido);
    }


    public function index($idcalificaciones = 0)
    {
        // Verificar permisos
        if ($this->permiso) {
            // Cargar datos generales para la vista
            $datos = $this->cargar_datos($idcalificaciones); // Aquí se pasa $idcarga_horaria
            $tabla_cali = new \App\Models\Tabla_calificaciones;

            if ($tabla_cali->find($idcalificaciones) == null) {
                mensaje("El docente que solicitaste no se encuentra en la BD", "Error", 3);
                return redirect()->to(route_to("operador_calificaciones"));
            } else {
                return $this->crear_vista($this->view, $datos); // Aquí se pasa $datos en lugar de cargar_datos($idcarga_horaria)
            }
        } else {
            mensaje("No tienes permisos para acceder a este modulo, contacte al administrador", "Error", 3);
            return redirect()->to(route_to("acceso"));
        }
    }



    
    public function actualizar($idcalificaciones = 0)
    {
        // Verificar permisos
        if ($this->permiso) {
            // Obtener las calificaciones parciales del formulario
            $calificacion_a = floatval($this->request->getPost("calificaciona"));
            $calificacion_b = floatval($this->request->getPost("calificacionb"));
            $calificacion_c = floatval($this->request->getPost("calificacionc"));
            $calificacion_d = floatval($this->request->getPost("calificaciond"));
    
            // Verificar si los valores son numéricos
            if (!is_numeric($calificacion_a) || !is_numeric($calificacion_b) || !is_numeric($calificacion_c) || !is_numeric($calificacion_d)) {
                mensaje("Las calificaciones deben ser valores numéricos", "Error", 3);
                return redirect()->to(route_to("operador_calificacion"));
            }
    
            // Obtener el ID de lista
            $idlista = $this->tabla_asigmat->getidlista($idcalificaciones);
            $idasig = $this->tabla_asigmat->getidasig($idlista->lista_alumnos_idlista_alumnos);
            $iddoce = $this->tabla_asigmat->getiddo($idlista->lista_alumnos_idlista_alumnos);
    
            // Verificar si se encontró el ID de lista
            if (!$idlista) {
                mensaje("No se encontró el ID de lista para estas calificaciones", "Error", 3);
                return redirect()->to(route_to("operador_calificacion"));
            }
    
            // Obtener los porcentajes de ponderación
            $porcentajes = $this->tabla_asigmat->getPorcentajesPorAsignatura($idasig->asignatura_idasignatura, $iddoce->docente_iddocente);
    
            // Verificar si se encontraron los porcentajes
            if (!$porcentajes) {
                mensaje("No se encontraron los porcentajes de ponderación para esta asignatura", "Error", 3);
                return redirect()->to(route_to("operador_calificacion"));
            }
    
            // Calcular el promedio ponderado
            $promedio_ponderado = (($calificacion_a * $porcentajes->ponderacion_parcial_a) +
                ($calificacion_b * $porcentajes->ponderacion_parcial_b) +
                ($calificacion_c * $porcentajes->ponderacion_parcial_c) +
                ($calificacion_d * $porcentajes->ponderacion_parcial_d)) / 100;
    
            // Obtener el modelo correspondiente para actualizar la calificación
            $tabla_calificacion = new \App\Models\Tabla_calificaciones;
    
            $data = [
                'calificacion_final' => $promedio_ponderado,
                'calificacion_a' => $calificacion_a,
                'calificacion_b' => $calificacion_b,
                'calificacion_c' => $calificacion_c,
                'calificacion_d' => $calificacion_d
            ];
    
            if ($tabla_calificacion->update_data($idcalificaciones, $data)) {
                mensaje("La calificación final y parciales se actualizaron correctamente", "Actualización Exitosa!", 1);
                return redirect()->to(route_to("operador_calificacion"));
            } else {
                mensaje("Ocurrió un error al procesar la actualización", "Error al Actualizar!", 3);
                return $this->index($idcalificaciones);
            }
        } else {
            mensaje("No tienes permisos para acceder a este módulo, contacta al administrador", "Error", 3);
            return redirect()->to(route_to("acceso"));
        }
    }
    
}