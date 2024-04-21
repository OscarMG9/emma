<?= $this->extend('plantillas/panel_base') ?>

<?= $this->section('CSS') ?>
<!-- Aquí puedes incluir cualquier CSS específico si es necesario -->
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<div class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Ingresa tus datos</h3> 
                <br>
                <small>Todos los campos marcados con(<font color="red">*</font>) son obligatorios</small>
            </div>
            <div class="card-body">
                <?= form_open("actualizar_asigmat/".$asigmat->idcarga_horaria, ["id" => "form-nuevo-asigmat"]) ?>
                <div class="row">
                    <div class="form-group col-2">
                        <label for="asignatura">Seleccionar asignatura</label><font color="red">*</font>
                            <?php 
                            $options = ['' => 'Selecciona una asignatura']; // Array para opciones del select
                            foreach ($materias as $asignatura) {
                                    $options[$asignatura->idasignatura] = $asignatura->asignatura;
                            }
                            echo form_dropdown('asignatura', $options, $asigmat->asignatura_idasignatura, 'class="form-control" id="asignatura" required');
                            ?>

                        </div>
                        <div class="form-group col-3">
                        <label for="docente">Seleccionar docente</label><font color="red">*</font>
                        <?php 
                            $options = ['' => 'Selecciona un docente']; // Array para opciones del select
                            foreach ($usuarios as $usuario) {
                                $esDocente = false; // Bandera para indicar si el usuario es docente
                                foreach ($docentes as $docente) {
                                    if ($docente->usuario_idusuario == $usuario->idusuario) {
                                        $esDocente = true;
                                        break; // Si el usuario es encontrado como docente, no es necesario seguir buscando
                                    }
                                }
                                // Si el usuario no es administrador (idrol != 745) y no es un docente, agrégalo a la lista
                                if ($usuario->idrol != 745 && $esDocente && $usuario->idrol != 120) {
                                    $options[$docente->iddocente] = $usuario->nombre . ' ' . $usuario->ap_paterno . ' ' . $usuario->ap_materno;
                                }
                            }
                            echo form_dropdown('docente', $options,  $asigmat->docente_iddocente, 'class="form-control" id="docente" required');
                            ?>
                        </div>
                        <div class="form-group col-2">
                            <label for="periodo">Seleccionar Periodo</label><font color="red">*</font>
                            <?php 
                            $options = ['' => 'Selecciona un periodo']; // Array para opciones del select
                            foreach ($periodos as $periodo) {
                                    $options[$periodo->idperiodo] = $periodo->acronimo;
                            }
                            echo form_dropdown('periodo', $options,  $asigmat->periodo_idperiodo, 'class="form-control" id="periodo" required');
                            ?>
                        </div>
                        <div class="form-group col-5">
                            <label for="fechaasignacion">Fecha de asignación</label>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"datetime-local",
                                "id" =>"fechaasignacion",
                                "name" =>"fechaasignacion",
                                "value" =>  $asigmat->fecha_asignacion
                                
                            );
                                echo form_input($attributes);
                            ?>
                        </div> 
                    </div>
                    </div>
                    <div class="card-footer text-right">
                        <?= form_submit('btn-enviar','Actualizar',["class" => "btn btn-success"]); ?>
                        <a href="<?= route_to("administracion_asignacionmats")?>" class="btn btn-danger">Regresar</a>
                    </div>
                <?= form_close()?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("JS") ?>
<!-- Aquí puedes incluir cualquier JS específico si es necesario -->
<?= $this->endSection() ?>
