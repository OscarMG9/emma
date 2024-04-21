<?php

    namespace App\Models;
    use CodeIgniter\Model;

    Class Tabla_asigmat extends Model {
        protected $table      = 'carga_horaria';
        protected $primaryKey = 'idcarga_horaria';
        protected $returnType = 'object';
        protected $allowedFields = [
                                    'idcarga_horaria','asignatura_idasignatura','docente_iddocente','periodo_idperiodo',
                                    'fecha_asignacion','ponderacion_parcial_a','ponderacion_parcial_b','ponderacion_parcial_c',
                                    'ponderacion_parcial_d'
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
    public function getidlista($idcalificaciones)
    {
        return $this->db->table('calificaciones')
                        ->select('lista_alumnos_idlista_alumnos')
                        ->where('idcalificaciones', $idcalificaciones)
                        ->get()
                        ->getRow();
    }
    
    public function getidasig($idlista)
    {
        return $this->db->table('lista_alumnos')
                        ->select('asignatura_idasignatura')
                        ->where('idlista_alumnos', $idlista)
                        ->get()
                        ->getRow();
    }
    
    public function getiddo($iddoce)
    {
        return $this->db->table('lista_alumnos')
                        ->select('docente_iddocente')
                        ->where('idlista_alumnos', $iddoce)
                        ->get()
                        ->getRow();
    }
 
    public function getPorcentajesPorAsignatura($idlista,$iddoce)
    {
        return $this->db->table('carga_horaria')
                        ->select('ponderacion_parcial_a, ponderacion_parcial_b, ponderacion_parcial_c, ponderacion_parcial_d')
                        ->where('asignatura_idasignatura', $idlista,'docente_iddocente', $iddoce)
                        ->get()
                        ->getRow();
    }

    
    }