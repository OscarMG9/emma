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
                <h3 class="card-title">Materias Asignadas</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="col-sm-12 text-left">
                <a class="btn btn-success" href="<?= route_to('nuevo_asigmat')?>" >Asignar materias</a>
                <table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                  <thead>
                  <tr>
                  <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">#</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Asignatura</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Docente</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Periodo</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Fecha de asignación</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Acciones</th>
                </tr>
                  </thead>
                  <tbody>

                  <?php 
                    $html = '';
                    $index = 0;
                    if(sizeof($asigmats) > 0){
                      foreach($asigmats as $asigmat){
                        $html.='  
                        <tr class="odd">
                        <td class="dtr-control sorting_1" tabindex="0">'.++$index.'</td>
                        
                        
                        <td style="">';
                        if(sizeof($materias) > 0){
                          $materiaEncontrado = false; // Bandera para indicar si se encontró la materia
                          foreach($materias as $materia){
                              if ($asigmat->asignatura_idasignatura == $materia->idasignatura){
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
                        <td style="">';

                        if (sizeof($docentes) > 0) {
                          $docenteEncontrado = false; // Bandera para indicar si se encontró el docente
                          foreach ($docentes as $docente) {
                              if ($asigmat->docente_iddocente == $docente->iddocente) {
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
                        if(sizeof($periodos) > 0){
                          $periodoEncontrado = false; // Bandera para indicar si se encontró el periodo
                          foreach($periodos as $periodo){
                              if ($asigmat->periodo_idperiodo == $periodo->idperiodo){
                                  $html.= $periodo->acronimo;
                                  $periodoEncontrado = true; // Marcar que se encontró el periodo
                                  break; // Salir del bucle una vez que se encontró el periodo
                              }
                          }
                          if (!$periodoEncontrado) { // Si no se encontró el periodo
                              $html.= 'No se encuentra ningún periodo con ese ID';
                          }
                      }
                      
                        $html.='</td>
                        <td style="">'.$asigmat->fecha_asignacion.'</td>
                        <td style="">
                        <a class="btn btn-success"   href="'.route_to("detalles_asigmat",$asigmat->idcarga_horaria).'">Detalles</a>
                        <a class="btn btn-danger" href="'.route_to("eliminar_asigmat",$asigmat->idcarga_horaria).'">Eliminar</a>
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
                  <th rowspan="1" colspan="1" style="">Asignatura</th>
                  <th rowspan="1" colspan="1" style="">Docente</th>
                  <th rowspan="1" colspan="1" style="">Periodo</th>
                  <th rowspan="1" colspan="1" style="">Fecha de asignación</th>
                  <th rowspan="1" colspan="1" style="">Acciones</th>
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