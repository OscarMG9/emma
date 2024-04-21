<?= $this->extend('plantillas/panel_base') ?>

<?= $this->section('CSS') ?>
<!-- Aquí puedes incluir cualquier CSS específico si es necesario -->
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<div class="content">
    <div class="container-fluid">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Ingresa tus datos</h3> 
                <br>
                <small>Todos los campos marcados con(<font color="red">*</font>) son obligatorios</small>
            </div>
            <div class="card-body">
            <?= form_open("actualizar_periodo/".$periodo->idperiodo, ["id" => "form-nuevo-periodo"]) ?>
                    <div class="row">
                    <div class="form-group col-3">
                        <label for="materia">Nombre del periodo</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"text",
                                "id" =>"nombreperiodo",
                                "name" =>"nombreperiodo",
                                "value" => $periodo->nombreperiodo,
                                "placeholder" =>"nombreperiodo",
                                "required" => TRUE
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                        <label for="materia">Acronimo del periodo</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"text",
                                "id" =>"acronimo",
                                "name" =>"acronimo",
                                "value" => $periodo->acronimo,
                                "placeholder" =>"acronimo",
                                "required" => TRUE
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="acronimo">Fecha de Inicio</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"date",
                                "id" =>"fechainicio",
                                "name" =>"fechainicio",
                                "value" => $periodo->fechainicio,
                                "placeholder" =>"fechainicio",
                                "required" => TRUE
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="creditos">Fecha de finalización</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"date",
                                "id" =>"fechafin",
                                "name" =>"fechafin",
                                "value" => $periodo->fechafin,
                                "placeholder" =>"fechafin",
                                "required" => TRUE
                                
                            );
                                echo form_input($attributes);
                            ?>
                        </div>

                    </div>
                    </div>
                    <div class="card-footer text-right">
                        <?= form_submit('btn-enviar','Actualizar',["class" => "btn btn-success"]); ?>
                        <a href="<?= route_to("administracion_periodos")?>" class="btn btn-danger">Regresar</a>
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
