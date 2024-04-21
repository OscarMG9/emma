<?= $this->extend('plantillas/panel_base') ?>

<?= $this->section('CSS') ?>
<!-- Aquí puedes incluir cualquier CSS específico si es necesario -->
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<div class="content">
    <div class="container-fluid">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Actualizar estatus</h3> 
                <br>
            </div>
            <div class="card-body">
                                <?= form_open("actualizar_alumno/".$lista->idlista_alumnos, ["id" => "form-nuevo-alumno"]) ?>
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="grado">Estatus del alumno</label><font color="red">*</font>
                                <?php
                                $options = array(
                                    '' => 'SELECCIONA ESTATUS',
                                    125 => 'INACTIVO',
                                    85 => 'REGULAR',
                                    8 => 'IRREGULAR',
                                    // Puedes continuar añadiendo opciones según necesites
                                );

                                $attributes = array(
                                    "class" => "form-control",
                                    "id" => "estatus",
                                    "required" => TRUE
                                );

                                echo form_dropdown('estatus', $options, $lista->estatus_alumno, $attributes);
                                ?>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <?= form_submit('btn-enviar','Actualizar',["class" => "btn btn-success"]); ?>
                            <a href="<?= route_to("operador_alumnos")?>" class="btn btn-danger">Regresar</a>
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
