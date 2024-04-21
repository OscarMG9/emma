<!-- llamado de plantilla -->
<?= $this->extend('plantillas/panel_base') ?>


<!-- CSS ESPECIFICO DE LA VISTA -->
<?= $this->section('CSS') ?>
 <!-- DataTables -->
 <link rel="stylesheet" href="<?= base_url('recursos_panel/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')?>">
  <link rel="stylesheet" href="<?= base_url('recursos_panel/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')?>">
  <link rel="stylesheet" href="<?= base_url('recursos_panel/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')?>">
<?= $this->endSection() ?>

<!-- CONTENIDO ESPECIFICO DE LA VISTA -->
<?= $this->section('contenido') ?>

<div class="content">
    <div class="container-fluid">
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Alumnos Asignados</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="col-sm-12 text-left">
                <a class="btn btn-warning" href="<?= route_to('nuevo_alumno')?>" >Registrar alumnos</a>
                <a class="btn btn-info" href="<?= route_to('nuevo_asigalum')?>" >Asignar alumnos</a>
                <table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                  <thead>
                  <tr>
                  <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">#</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Fecha de registro</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Alumno</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Docente</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Materia</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Estatus alumno</th>
                </tr>
                  </thead>
                  <tbody>

                  <?php 
                    $html = '';
                    $index = 0;
                    if(sizeof($listaalums) > 0){
                      foreach($listaalums as $listaalum){
                        $html.='  
                        <tr class="odd">
                        <td class="dtr-control sorting_1" tabindex="0">'.++$index.'</td>
                        <td style="">'.$listaalum->fecha_registro.'</td>
                        <td style="">';

                        if (sizeof($alumnos) > 0) {
                          $alumEncontrado = false; // Bandera para indicar si se encontró el docente
                          foreach ($alumnos as $alumno) {
                              if ($listaalum->alumno_idalumno == $alumno->idalumno) {
                                  $alumEncontrado = true; // Marcar que se encontró el docente
                                  // No es necesario continuar buscando, así que salimos del bucle
                                  break;
                              }
                          }
                          if ($alumEncontrado) {
                              // Si se encontró el docente, ahora buscamos el usuario asociado
                              if (sizeof($usuarios) > 0) {
                                  $usuarioEncontrado = false; // Bandera para indicar si se encontró el usuario
                                  foreach ($usuarios as $usuario) {
                                      if ($alumno->idusuario == $usuario->idusuario) {
                                          // Si se encuentra el usuario, se muestra su información y se marca como encontrado
                                          $html .= $usuario->nombre . ' ' . $usuario->ap_paterno . ' ' . $usuario->ap_materno;
                                          $usuarioEncontrado = true;
                                          break; // Salir del bucle una vez que se encontró el usuario
                                      }
                                  }
                                  if (!$usuarioEncontrado) {
                                      // Si no se encuentra el usuario, se muestra un mensaje
                                      $html .= 'No se encuentra ningún usuario asociado a este docente';
                                  }
                              }
                          } else {
                              // Si no se encuentra el docente, se muestra un mensaje
                              $html .= 'No se encuentra ningún docente con ese ID';
                          }
                      }
                      
                      
                        $html.='</td>


                        <td style="">';

                        if (sizeof($docentes) > 0) {
                          $docenteEncontrado = false; // Bandera para indicar si se encontró el docente
                          foreach ($docentes as $docente) {
                              if ($listaalum->docente_iddocente == $docente->iddocente) {
                                  $docenteEncontrado = true; // Marcar que se encontró el docente
                                  // No es necesario continuar buscando, así que salimos del bucle
                                  break;
                              }
                          }
                          if ($docenteEncontrado) {
                              // Si se encontró el docente, ahora buscamos el usuario asociado
                              if (sizeof($usuarios) > 0) {
                                  $usuarioEncontrado = false; // Bandera para indicar si se encontró el usuario
                                  foreach ($usuarios as $usuario) {
                                      if ($docente->usuario_idusuario == $usuario->idusuario) {
                                          // Si se encuentra el usuario, se muestra su información y se marca como encontrado
                                          $html .= $usuario->nombre . ' ' . $usuario->ap_paterno . ' ' . $usuario->ap_materno;
                                          $usuarioEncontrado = true;
                                          break; // Salir del bucle una vez que se encontró el usuario
                                      }
                                  }
                                  if (!$usuarioEncontrado) {
                                      // Si no se encuentra el usuario, se muestra un mensaje
                                      $html .= 'No se encuentra ningún usuario asociado a este docente';
                                  }
                              }
                          } else {
                              // Si no se encuentra el docente, se muestra un mensaje
                              $html .= 'No se encuentra ningún docente con ese ID';
                          }
                      }
                      
                      
                        $html.='</td>
                        <td style="">';
                        if(sizeof($materias) > 0){
                          $materiaEncontrado = false; // Bandera para indicar si se encontró la materia
                          foreach($materias as $materia){
                              if ($listaalum->asignatura_idasignatura == $materia->idasignatura){
                                  $html.= $materia->asignatura;
                                  $materiaEncontrado = true; // Marcar que se encontró la materia
                                  break; // Salir del bucle una vez que se encontró la materia
                              }
                          }
                          if (!$materiaEncontrado) { // Si no se encontró ningúna materia
                              $html.= 'No se encuentra ninguna materia con ese ID';
                          }
                      }
                      
                        $html.='</td>

                        <td style="" class="text-center">';
                        if ($listaalum->estatus_alumno == ESTATUS_REGULAR){
                          $html.= '<a class="btn btn-success">Regular</a>';
                        }elseif($listaalum->estatus_alumno == ESTATUS_IRREGULAR){
                          $html.= '<a class="btn btn-danger">Irregular</a>';
                        }elseif($listaalum->estatus_alumno == ESTATUS_INACTIVO){
                          $html.= '<a class="btn btn-dark">Inactivo</a>';
                        }
                        $html.='
                      </td>

                      </tr>
                      ';
                      }
                    }
                    echo $html;
                  ?>
              </tbody>
                  <tfoot>
                  <tr><th rowspan="1" colspan="1">#</th>
                  <th rowspan="1" colspan="1" style="">Fecha de registro</th>
                  <th rowspan="1" colspan="1" style="">Alumno</th>
                  <th rowspan="1" colspan="1" style="">Docente</th>
                  <th rowspan="1" colspan="1" style="">Materia</th>
                  <th rowspan="1" colspan="1" style="">Estatus alumno</th>
                </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
    </div>
</div>

<?= $this->endSection() ?>  

<!-- JS ESPECIFICO DE LA VISTA -->
<?= $this->section("JS") ?>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('recursos_panel/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('recursos_panel/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('recursos_panel/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('recursos_panel/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('recursos_panel/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('recursos_panel/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('recursos_panel/plugins/jszip/jszip.min.js') ?>"></script>
<script src="<?= base_url('recursos_panel/plugins/pdfmake/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('recursos_panel/plugins/pdfmake/vfs_fonts.js') ?>"></script>
<script src="<?= base_url('recursos_panel/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('recursos_panel/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('recursos_panel/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
<script>
$(document).ready(function(){

    $('#dataTable').DataTable({
      'processing': true,
      "responsive": true,
     // "scrollX": true,
      "language": {
        "lengthMenu": "Mostrar MENU datos",
        "info": "Página PAGES de PAGES",
        "infoEmpty": "Datos no disponibles por el momento",
        "processing": "Procesando....",
        "search": "Buscar:",
        "zeroRecords": "Datos no disponibles por el momento",
        "paginate": {
        "first": "Primera",
        "last": "Última",
        "next": "Siguiente",
        "previous": "Anterior"
      },
      }
    });
});

</script>


<?= $this->endSection() ?>