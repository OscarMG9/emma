<?php

function acceso_usuario($tarea_actual = "",$rol_actual = ""){
    $permiso = TRUE;
    
    switch($rol_actual){
        case ROL_ADMINISTRADOR["clave"]:
            $permiso = in_array($tarea_actual,PERMISOS_ADMIN);
        break;
        case ROL_DOCENTE["clave"]:
            $permiso = in_array($tarea_actual,PERMISOS_DOCENTES);
            break;
        default:
        $permiso = FALSE;
        break;
    }


    return $permiso;
}