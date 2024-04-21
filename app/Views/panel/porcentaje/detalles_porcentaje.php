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
            </div>
            <div class="card-body">
            <?= form_open("actualizar_porcentaje/".$carga->idcarga_horaria, ["id" => "form-nuevo-carga"]) ?>
                    <div class="row">
                        
                        <div class="form-group col-3">
                            <label for="acronimo">Parcial A</label>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"number",
                                "id" =>"parciala",
                                "name" =>"parciala",
                                "min" => 0,
                                "max" =>100,
                                "value" =>$carga->ponderacion_parcial_a,
                                "required" => TRUE
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="creditos">Parcial B</label>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"number",
                                "id" =>"parcialb",
                                "name" =>"parcialb",
                                "min" => 0,
                                "max" =>100,
                                "value" =>$carga->ponderacion_parcial_b,
                                "required" => TRUE
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="acronimo">Parcial C</label>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"number",
                                "id" =>"parcialc",
                                "name" =>"parcialc",
                                "min" => 0,
                                "max" =>100,
                                "value" =>$carga->ponderacion_parcial_c,
                                "required" => TRUE
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="creditos">Parcial D</label>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"number",
                                "id" =>"parciald",
                                "name" =>"parciald",
                                "min" => 0,
                                "max" =>100,
                                "value" =>$carga->ponderacion_parcial_d,
                                "required" => TRUE
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        
                    </div>
                    </div>
                    <div class="card-footer text-right">
                        <?= form_submit('btn-enviar','Actualizar',["class" => "btn btn-primary"]); ?>
                        <a href="<?= route_to("administracion_docentes")?>" class="btn btn-danger">Regresar</a>
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
