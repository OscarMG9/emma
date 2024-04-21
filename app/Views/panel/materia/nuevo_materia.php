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
                <?= form_open("registrar_materia", ["id" => "form-nuevo-materia"]) ?>
                    <div class="row">
                        <div class="form-group col-6">
                        <label for="materia">Nombre de la materia</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"text",
                                "id" =>"materia",
                                "name" =>"materia",
                                "placeholder" =>"materia",
                                "required" => TRUE
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="acronimo">Acronimo</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"text",
                                "id" =>"acronimo",
                                "name" =>"acronimo",
                                "placeholder" =>"Acronimo",
                                "required" => TRUE
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="creditos">Creditos</label>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"number",
                                "id" =>"creditos",
                                "name" =>"creditos",
                                "placeholder" =>"Creditos",
                                "min"=> "1"
                                
                            );
                                echo form_input($attributes);
                            ?>
                        </div>

                    </div>
                    </div>
                    <div class="card-footer text-right">
                        <?= form_submit('btn-enviar','Registrar',["class" => "btn btn-success"]); ?>
                        <a href="<?= route_to("administracion_materias")?>" class="btn btn-danger">Regresar</a>
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
