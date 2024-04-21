<?php

    //nos permite la creacion e intacia del menu panel lateral de manera dinamica
    function configurar_menu_panel($tarea_actual = '', $rol_actual = 0){
        //permite almcenar todas las opciones dentro del menu
        $menu = array();
        // Permite identificar las caracteristicas de la opcion
        $menu_opcion = array();
        // Permite identificar las caracteristicas de la subopcion dque se encuentra en la opcion principal
        $menu_sub_opcion = array();

        //tarea DASHBOARD
        $menu_opcion = array();
        $menu_opcion['is_active'] = ($tarea_actual == TAREA_DASHBOARD) ?  TRUE : FALSE ;
        $menu_opcion['href'] = route_to("administracion_dashboard");
        $menu_opcion['text'] = 'Dashboard';
        $menu_opcion['icon'] = 'far fa-bookmark';
        $menu_opcion['submenu'] = array();
        $menu['dashboard'] = $menu_opcion;

        //Menu administrador
        if($rol_actual == ROL_ADMINISTRADOR["clave"]) {
            $menu_opcion = array();
            $menu_opcion['is_active'] = ($tarea_actual == TAREA_USUARIOS) ?  TRUE : FALSE ;
            $menu_opcion['href'] = route_to("administracion_usuarios");
            $menu_opcion['text'] = 'Usuarios';
            $menu_opcion['icon'] = 'fas fa-address-card';
            $menu_opcion['submenu'] = array();
            $menu['usuarios'] = $menu_opcion;

            $menu_opcion = array();
            $menu_opcion['is_active'] = ($tarea_actual == TAREA_MATERIAS) ?  TRUE : FALSE ;
            $menu_opcion['href'] = route_to("administracion_materias");
            $menu_opcion['text'] = 'Materias';
            $menu_opcion['icon'] = 'fas fa-book-open';
            $menu_opcion['submenu'] = array();
            $menu['materias'] = $menu_opcion;

            $menu_opcion = array();
            $menu_opcion['is_active'] = ($tarea_actual == TAREA_PERIODOS) ?  TRUE : FALSE ;
            $menu_opcion['href'] = route_to("administracion_periodos");
            $menu_opcion['text'] = 'Periodos';
            $menu_opcion['icon'] = 'fas fa-chart-pie';
            $menu_opcion['submenu'] = array();
            $menu['periodos'] = $menu_opcion;

            $menu_opcion = array();
            $menu_opcion['is_active'] = ($tarea_actual == TAREA_DOCENTES) ?  TRUE : FALSE ;
            $menu_opcion['href'] = route_to("administracion_docentes");
            $menu_opcion['text'] = 'Docentes';
            $menu_opcion['icon'] = 'fas fa-chalkboard-teacher';
            $menu_opcion['submenu'] = array();
            $menu['docentes'] = $menu_opcion;

            $menu_opcion = array();
            $menu_opcion['is_active'] = ($tarea_actual == TAREA_ASIGMAT) ?  TRUE : FALSE ;
            $menu_opcion['href'] = route_to("administracion_asignacionmats");
            $menu_opcion['text'] = 'Asignación de materias';
            $menu_opcion['icon'] = 'fab fa-creative-commons-share';
            $menu_opcion['submenu'] = array();
            $menu['asignacion_materias'] = $menu_opcion;

            $menu_opcion = array();
            $menu_opcion['is_active'] = ($tarea_actual == TAREA_ASIGALUM) ?  TRUE : FALSE ;
            $menu_opcion['href'] = route_to("administracion_asignacionalums");
            $menu_opcion['text'] = 'Asignación de alumnos';
            $menu_opcion['icon'] = 'fab fa-creative-commons-by';
            $menu_opcion['submenu'] = array();
            $menu['asignacion_alumnos'] = $menu_opcion;
        //end menu administrador
        }else{ //menu operador
            $menu_opcion = array();
            $menu_opcion['is_active'] = ($tarea_actual == TAREA_PORCENTAJES) ?  TRUE : FALSE ;
            $menu_opcion['href'] = route_to("operador_porcentajes");
            $menu_opcion['text'] = 'Asignación de porcentajes';
            $menu_opcion['icon'] = '	fa fa-check';
            $menu_opcion['submenu'] = array();
            $menu['porcentajes'] = $menu_opcion;
            //
            $menu_opcion = array();
            $menu_opcion['is_active'] = ($tarea_actual == TAREA_ALUMNOS) ?  TRUE : FALSE ;
            $menu_opcion['href'] = '#';
            $menu_opcion['text'] = 'Lista alumnos';
            $menu_opcion['icon'] = 'fa fa-user';
            
            $menu_opcion['submenu'] = array();
            
            $menu_sub_opcion = array();
            $menu_sub_opcion['is_active'] = ($tarea_actual == TAREA_ALUMNOS) ?  TRUE : FALSE ;
            $menu_sub_opcion['href'] = route_to("operador_alumnos");
            $menu_sub_opcion['text'] = 'Lista de alumnos';
            $menu_sub_opcion['icon'] = 'fa fa-user';
            $menu_opcion['submenu']['listas'] = $menu_sub_opcion;
            
            $menu_sub_opcion = array();
            $menu_sub_opcion['is_active'] = ($tarea_actual == TAREA_CALIFICACIONES) ?  TRUE : FALSE ;
            $menu_sub_opcion['href'] = route_to("operador_calificacion");
            $menu_sub_opcion['text'] = 'Asignación de calificación';
            $menu_sub_opcion['icon'] = 'fa fa-clipboard';
            $menu_opcion['submenu']['listasc'] = $menu_sub_opcion;
            
            $menu_sub_opcion = array(); 
            $menu_sub_opcion['is_active'] = ($tarea_actual == TAREA_ASISTENCIAS) ?  TRUE : FALSE ;
            $menu_sub_opcion['href'] = route_to("operador_asistencias");
            $menu_sub_opcion['text'] = 'Pase de asistencia';
            $menu_sub_opcion['icon'] = 'fa fa-eye';
            $menu_opcion['submenu']['listaa'] = $menu_sub_opcion;
            
            $menu['listas'] = $menu_opcion;
            
        }//end menu operador 

        //ejemplo subopciones
        //$menu_opcion = array();
        //$menu_opcion['is_active'] = FALSE;
        //$menu_opcion['href'] = '#';
        // $menu_opcion['text'] = 'Opcion B';
        //$menu_opcion['icon'] = 'fa fa-battery-full';

        //$menu_opcion['submenu'] = array();
        //    $menu_sub_opcion['is_active'] = FALSE;
        //    $menu_sub_opcion['href'] = route_to('administracion_dashboard');
        //    $menu_sub_opcion['text'] = 'Opcion B1';
        //    $menu_sub_opcion['icon'] = ' fa fa-battery-three-quarters';
        //$menu_opcion['submenu']['opcionb1'] = $menu_sub_opcion;

        //$menu_opcion['submenu'] = array();
        //    $menu_sub_opcion['is_active'] = FALSE;
        //    $menu_sub_opcion['href'] = route_to('administracion_dashboard');
        //    $menu_sub_opcion['text'] = 'Opcion B2';
        //    $menu_sub_opcion['icon'] = ' fa fa-battery-half';
        //    $menu_opcion['submenu']['opcionb2'] = $menu_sub_opcion;
        //$menu['opcionB'] = $menu_opcion;

        return $menu;
    }//end configurar

    function crear_menu_panel($tarea_actual = '', $rol_actual = 0){
        $menu = configurar_menu_panel($tarea_actual,$rol_actual);
        $html = '';
        $html.= '
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">MENU LATERAL</li>';
            foreach($menu as $opcion){
                if($opcion["href"] != "#"){
                    $html.='
                        <li class="nav-item">
                            <a href="'.$opcion["href"].'" class="nav-link '.(($opcion["is_active"] == TRUE) ? "active" : "" ).'">
                            <i class="nav-icon '.$opcion["icon"].'"></i>
                            <p>'.$opcion["text"].'</p>
                            </a>
                        </li>
                        ';
                }//end if
                else{
                $html.='
                    <li class="nav-item">
                            <a href="#" class="nav-link '.(($opcion["is_active"] == TRUE) ? "active" : "" ).'">
                            <i class="nav-icon '.$opcion["icon"].'"></i>
                            <p>
                            '.$opcion["text"].'
                                <i class="right fas fa-angle-left"></i>
                        </p>
                            </a>';
                            if(sizeof($opcion["submenu"]) > 0 ){
                                $html.='<ul class="nav nav-treeview">';
                                foreach($opcion["submenu"] as $sub_opcion_menu){
                                $html.='
                                <li class="nav-item">
                                    <a href="'.$sub_opcion_menu["href"].'" class="nav-link '.(($sub_opcion_menu["is_active"] == TRUE) ? "active" : "").'">
                                        <i class="nav-icon '.$sub_opcion_menu["icon"].'"></i>
                                        <p>'.$sub_opcion_menu["text"].'</p>
                                    </a>
                                </li>
                                ';
                               } // end foreach
                            }// end if

                    $html.'</li>
                    ';
                }
            }
        $html.='</ul>';
        return $html;
    }//end crear