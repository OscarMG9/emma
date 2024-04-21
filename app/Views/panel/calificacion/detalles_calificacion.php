<?= $this->extend('plantillas/panel_base') ?>

<?= $this->section('CSS') ?>
<!-- Aquí puedes incluir cualquier CSS específico si es necesario -->
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<div class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Actualizar calificaciones</h3> 
                <br>
            </div>
            <div class="card-body">
                                <?= form_open("actualizar_calificacion/".$calificacion->idcalificaciones, ["id" => "form-nuevo-alumno"]) ?>
                        <div class="row">
                        <div class="form-group col-3">
                            <label for="acronimo">Calificacion A</label>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"number",
                                "id" =>"calificaciona",
                                "name" =>"calificaciona",
                                "min" => 0,
                                "max" =>100,
                                "value" =>$calificacion->calificacion_a
                                
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="acronimo">Calificacion B</label>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"number",
                                "id" =>"calificacionb",
                                "name" =>"calificacionb",
                                "min" => 0,
                                "max" =>100,
                                "value" =>$calificacion->calificacion_b
                              
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="acronimo">Calificacion C</label>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"number",
                                "id" =>"calificacionc",
                                "name" =>"calificacionc",
                                "min" => 0,
                                "max" =>100,
                                "value" =>$calificacion->calificacion_c
                            
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="acronimo">Calificacion D</label>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"number",
                                "id" =>"calificaciond",
                                "name" =>"calificaciond",
                                "min" => 0,
                                "max" =>100,
                                "value" =>$calificacion->calificacion_d
                            
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        </div>
                        <div class="card-footer text-right">
                            <?= form_submit('btn-enviar','Actualizar',["class" => "btn btn-primary"]); ?>
                            <a href="<?= route_to("operador_calificacion")?>" class="btn btn-danger">Regresar</a>
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
