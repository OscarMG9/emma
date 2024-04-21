<?php

    namespace App\Models;
    use CodeIgniter\Model;

    Class Tabla_listaalum extends Model {
        protected $table      = 'lista_alumnos';
        protected $primaryKey = 'idlista_alumnos';
        protected $returnType = 'object';
        protected $allowedFields = [
                                    'idlista_alumnos','fecha_registro','alumno_idalumno','docente_iddocente',
                                    'asignatura_idasignatura','tipo_asistencia','fecha_asistencia','estatus_alumno'
        ];
        
        ////////////////////////////////
        //Consultas especificas o basicas
        //Created Read Update Delete
        ////////////////////////////////

        public function create_data($data = array()) {
            if (!empty($data)){
                return $this
                    ->table($this->table)
                    ->insert($data);
            }else{
                return FALSE;
            }

        }//end created

        public function get_user($contraints = array()){
            return $this   
                ->table($this->table)
                ->where($contraints)
                ->get()
                ->getRow();
        }//end get_user

        public function get_table($contraints = array()){
            return $this   
                ->table($this->table)
                ->get()
                ->getResult();
        }

        public function update_data($id = 0, $data = array()){

            if (!empty($data)) {
            return $this   
                ->table($this->table)
                ->where([$this->primaryKey => $id])
                ->set($data)
                ->update();
        }else{
            return FALSE;
        }
    }
    }