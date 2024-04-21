<?php

    namespace App\Models;
    use CodeIgniter\Model;

    Class Tabla_periodo extends Model {
        protected $table      = 'periodo';
        protected $primaryKey = 'idperiodo';
        protected $returnType = 'object';
        protected $allowedFields = [
                                    'idperiodo','nombreperiodo','acronimo','fechainicio','fechafin','estatus'
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