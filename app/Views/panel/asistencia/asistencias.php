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
                <h3 class="card-title">Pase de asistencia</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                  <thead>
                  <tr>
                  <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">#</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Alumno</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Asignatura</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Asistencia</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Fecha de asistencia</th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"  style="">Acciones</th>
                  </thead>
                  <tbody>

                  <?php 
                    $html = ''; 
                    $index = 0;
                    if(sizeof($listas) > 0){
                      foreach($listas as $lista){
                          foreach($docentes as $docente){
                              if($docente->usuario_idusuario == $id_docente && $lista->docente_iddocente == $docente->iddocente){

                        $html.='  
                        <tr class="odd">
                        <td class="dtr-control sorting_1" tabindex="0">'.++$index.'</td>
                        <td style="">';                   
                          foreach($alumnos as $alumno){
                              if ($alumno->idalumno == $lista->alumno_idalumno){
                                foreach($usuarios as $usuario){
                                  $usEncontrado= false;
                                  if($alumno->idusuario == $usuario->idusuario){
                                    $html.= $usuario->nombre.' '.$usuario->ap_paterno.' '.$usuario->ap_materno.' ';
                                    $usEncontrado= true;
                                    break;
                                  }
                                }
                                if(!$usEncontrado){
                                  $html.= 'No se encuentra ningún usuario con ese ID';
                                }
                              }
                          }   $html.='</td>

                          <td style="">';                   
                          foreach($materias as $materia){
                              if ($materia->idasignatura == $lista->asignatura_idasignatura){
                                    $html.= $materia->asignatura;
                                }
                              }
                            $html.='</td>
                            <td style="">'.$lista->tipo_asistencia.'</td>
                            <td style="">'.$lista->fecha_asistencia.'</td>
                    
                      </td>
                        <td style="">
                        <a class="btn btn-primary" href="'.route_to("detalles_asistencia",$lista->idlista_alumnos).'">Pase de asistencia</a>
                        </td> 
                      </tr>
                      ';
                    }
                  }
                }
              }
                    echo $html;
                  ?>
              </tbody>
                  <tfoot>
                  <tr><th rowspan="1" colspan="1">#</th>
                  <th rowspan="1" colspan="1" style="">Alumno</th>
                  <th rowspan="1" colspan="1" style="">Asignatura</th>
                  <th rowspan="1" colspan="1" style="">Asistencia</th>
                  <th rowspan="1" colspan="1" style="">Fecha de asistencia</th>
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