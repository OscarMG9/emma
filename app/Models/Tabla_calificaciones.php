<?php

    namespace App\Models;
    use CodeIgniter\Model;

    Class Tabla_calificaciones extends Model {
        protected $table      = 'calificaciones';
        protected $primaryKey = 'idcalificaciones';
        protected $returnType = 'object';
        protected $allowedFields = [
                                    'idcalificaciones','calificacion_a','calificacion_b','calificacion_c',
                                    'calificacion_d','calificacion_final','lista_alumnos_idlista_alumnos','periodo_idperiodo'
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