<?php

namespace App\Controllers\Usuario;
use App\Controllers\BaseController;

class Login extends BaseController {

    private $view = 'usuario\acceso';
    private function cargar_datos(){

        $datos = array();

        return $datos;
    }

    private function crear_vista($nombre_vista='', $contenido = array()){
        return view($nombre_vista,$contenido);
        
    }
    public function index(){
        return $this-> crear_vista($this->view,$this->cargar_datos());
    }

    public function validar(){
        d("Validando credenciales");
        $email = $this->request->getPost("correo");
        $password = $this->request->getPost("contraseña");
        
        //instancia del modelo
        $tabla_usuario = new \App\Models\Tabla_usuario;
        //QUERY
        $usuario = $tabla_usuario->iniciar_sesion($email,hash("sha256", $password));
        
        if ($usuario == array()) {
            mensaje("Las credenciales son incorrectas, comunícate con el administrador", "Error", 3);
            return redirect()->route("acceso");
        }

        $session = session();
        $session->set("sesion_iniciada",TRUE);
        $session->set("idusuario", $usuario->idusuario);
        $session->set("nombre", $usuario->nombre);
        $session->set("nombre_completo", $usuario->nombre." ". $usuario->ap_paterno." ". $usuario->ap_materno);
        $session->set("sexo", $usuario->sexo);
        $session->set("correo", $usuario->correo);
        $session->set("sexo", $usuario->sexo);
        $session->set("imagen_perfil", $usuario->imagen_perfil);
        $session->set("rol_actual", $usuario->idrol);
        $session->set("tarea_actual", TAREA_DASHBOARD);

        mensaje("Hola de nuevo ".$session->nombre." a el panel de administración", "Bienvenido", 0);
        return redirect()->route("administracion_dashboard");
    }
}
