<?php

namespace App\Controllers\Panel\Porcentaje;
use App\Controllers\BaseController;


class Detalles_porcentaje extends BaseController {

    private $view = 'panel\porcentaje\detalles_porcentaje';

    private $session = NULL;
    private $permiso = TRUE;

    public function __construct(){
        //instancia de la variable de sesion
        $this->session = session();
    
        //instancia del permisos helper
        helper("permisos_roles_helper");

        if (!acceso_usuario(TAREA_PORCENTAJES, $this->session->rol_actual)){
            $this->permiso = FALSE;
        }
        $this->session->tarea_actual = TAREA_PORCENTAJES;
    }//end constructor


    private function cargar_datos($idcarga_horaria = 0){

        $datos = array();
    
        $datos['nombre_pagina'] = 'Actualizar Ponderaciones | Docente';
        $datos['titulo_pagina'] = 'Actualizar Ponderaciones';

        $datos['id_docente'] = $this->session->idusuario;
        $datos['nombre_completo'] = $this->session->nombre_completo;
        $datos['nombre_user'] = $this->session->nombre;
        $datos['imagen_user'] = ($this->session->imagen_perfil == NULL) 
                                                            ? (($this->session->sexo != MASCULINO) ? 'icon-woman.png': 'icon-man.webp')
                                                            : $this->session->imagen_perfil;



        $breadcrumb = array(
            array(
                'href' => route_to("administracion_materias"),
                'titulo' => 'Porcentajes',    
            ),
            array(
                'href' => '#',
                'titulo' => 'Actualizar Ponderaciones',    
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
        $datos['carga'] = $tabla_carga->get_user(["idcarga_horaria" => $idcarga_horaria]);
        $datos["cargas"] = $tabla_carga->get_table();
        $tabla_periodo = new \App\Models\Tabla_periodo;
        $datos["periodos"] = $tabla_periodo->get_table();
        $tabla_asignatura = new \App\Models\Tabla_materia;
        $datos["materias"] = $tabla_asignatura->get_table();

        return $datos;
    }



    private function crear_vista($nombre_vista='', $contenido = array()){
        $contenido["menu_lateral"] = crear_menu_panel($this->session->tarea_actual,$this->session->rol_actual);
        return view($nombre_vista,$contenido);  
    }


    public function index($idcarga_horaria = 0) {
        // Verificar permisos
        if ($this->permiso) {
            // Cargar datos generales para la vista
            $datos = $this->cargar_datos($idcarga_horaria); // Aquí se pasa $idcarga_horaria
            $tabla_carga = new \App\Models\Tabla_asigmat;
    
            if($tabla_carga->find($idcarga_horaria) == null){
                mensaje("El docente que solicitaste no se encuentra en la BD", "Error", 3);
                return redirect()->to(route_to("operador_porcentajes"));
            } else {
                return $this->crear_vista($this->view, $datos); // Aquí se pasa $datos en lugar de cargar_datos($idcarga_horaria)
            }
        } else {
            mensaje("No tienes permisos para acceder a este modulo, contacte al administrador", "Error", 3);
            return redirect()->to(route_to("acceso"));
        }
    }
    
    public function actualizar($idcarga_horaria = 0){

        $tabla_carga = new \App\Models\Tabla_asigmat;
        $parciala = $this->request->getPost("parciala");
        $parcialb = $this->request->getPost("parcialb");
        $parcialc = $this->request->getPost("parcialc");
        $parciald = $this->request->getPost("parciald");
    
        // Verificar que la suma de los parciales sea igual a 100
        $suma_parciales = $parciala + $parcialb + $parcialc + $parciald;
    
        if($suma_parciales == 100){
            // Realizar la actualización
            // Arreglo temporal
            $ponderaciones = array(
                "ponderacion_parcial_a" => $parciala,
                "ponderacion_parcial_b" => $parcialb,
                "ponderacion_parcial_c" => $parcialc,
                "ponderacion_parcial_d" => $parciald
            );
    
            // Actualizar en la base de datos
            if($tabla_carga->update_data($idcarga_horaria, $ponderaciones)){
                mensaje("Las ponderaciones se actualizaron correctamente", "Actualización Exitosa!", 1);
                return redirect()->to(route_to("operador_porcentajes"));
            } else {
                mensaje("Ocurrió un error al procesar la actualización" , "Error al Actualizar!", 3);
                return $this->index($idcarga_horaria);
            }
        } else {
            mensaje("La suma de las ponderaciones de los parciales debe ser igual a 100. Por favor, verifica nuevamente.", "Error", 3);
            return $this->index($idcarga_horaria);
        }
    }
}