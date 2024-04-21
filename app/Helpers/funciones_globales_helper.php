<?php

function breadcrumb_panel($titulo_pagina = '', $breadcrumb = array()){
$html = '';
$html = '
<div class="row mb-2">
<div class="col-sm-6">
  <h1 class="m-0">'.$titulo_pagina.'</h1>
</div><!-- /.col -->
<div class="col-sm-6">
  <ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href='.route_to("administracion_dashboard").'><i class="fa fa-home" aria-hidden="true"></i></a>
  </li>'; 
  foreach($breadcrumb as $bd){
    if($bd["href"] != "#"){
        $html.= '<li class="breadcrumb-item"><a href='.$bd["href"].'>'.$bd["titulo"].'</a></li>';
    }else{
        $html.= '<li class="breadcrumb-item active">'.$bd["titulo"].'</li>';
    }
  } 
  $html.='</ol>
</div><!-- /.col -->
</div><!-- /.row -->
'; 

return $html;
}

function mensaje($texto = "", $titulo="",$tipo = 0){
    session();
    $mensaje = array();
    $mensaje['texto'] = $texto;
    $mensaje['titulo'] = $titulo;
    $mensaje['tipo'] = $tipo;
    session()->set('mensaje',$mensaje);

}

function mostrar_mensaje(){
    $html = '';
    $session = session();
    $mensaje = $session->get('mensaje');


    if($mensaje == null){
        return "";
    }

    switch ($mensaje["tipo"]) {
        case 1:
                $tipo_mensaje = "success";
            break;
            case 2:
                $tipo_mensaje = "warning";
            break;
            case 3:
                $tipo_mensaje = "error";
            break;
        
        default:
        $tipo_mensaje = "info";
            break;
    }

    $html .= 'toastr.'.$tipo_mensaje.'("'.$mensaje["texto"].'","'.$mensaje["titulo"].'");';

    $session->set("mensaje",null);

    return $html;
}