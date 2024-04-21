<?= $this->extend('plantillas/panel_base') ?>

<?= $this->section('CSS') ?>
<!-- Aquí puedes incluir cualquier CSS específico si es necesario -->
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<div class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Actualizar asistencia</h3> 
                <br>
            </div>
            <div class="card-body">
                                <?= form_open("actualizar_asistencia/".$lista->idlista_alumnos, ["id" => "form-nuevo-alumno"]) ?>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="grado">Tipo de asistencia</label><font color="red">*</font>
                                <?php
                                $options = array(
                                    '' => 'SELECCIONA ASISTENCIA',
                                    'A' => 'Asistencia',
                                    'P' => 'Permiso',
                                    'F' => 'Falta',
                                    // Puedes continuar añadiendo opciones según necesites
                                );

                                $attributes = array(
                                    "class" => "form-control",
                                    "id" => "asistencia",
                                    "required" => TRUE
                                );

                                echo form_dropdown('asistencia', $options, $lista->tipo_asistencia, $attributes);
                                ?>
                            </div>
                            <div class="form-group col-6">
                            <label for="acronimo">Fecha de asistencia</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"date",
                                "id" =>"fechaasistencia",
                                "name" =>"fechaasistencia",
                                "value" => $lista->fecha_asistencia,
                                "placeholder" =>"fechaasistencia",
                                "required" => TRUE
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        </div>
                        <div class="card-footer text-right">
                            <?= form_submit('btn-enviar','Actualizar',["class" => "btn btn-primary"]); ?>
                            <a href="<?= route_to("operador_asistencias")?>" class="btn btn-danger">Regresar</a>
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
