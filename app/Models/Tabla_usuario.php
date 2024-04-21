<?php

    namespace App\Models;
    use CodeIgniter\Model;

    Class Tabla_usuario extends Model {
        protected $table      = 'usuario';
        protected $primaryKey = 'idusuario';
        protected $returnType = 'object';
        protected $allowedFields = [
                                    'idusuario','nombre','ap_paterno','ap_materno','sexo',
                                    'correo','password','imagen_perfil','idrol'
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
        // Consultas especificas
        public function iniciar_sesion($email = "", $password = ""){
        if ($email != NULL && $password != NULL){
            return $this   
            ->table($this->table) 
            ->select("
            usuario.idusuario, usuario.nombre, usuario.ap_paterno, 
            usuario.ap_materno,
            usuario.sexo,  usuario.correo, 
            usuario.imagen_perfil, usuario.idrol")
            ->join("rol","usuario.idrol = rol.idrol")
            ->where("usuario.correo",$email)
            ->where("usuario.password",$password)
            ->first();
            ;
        }else {
            return array();
        }
    }
    }