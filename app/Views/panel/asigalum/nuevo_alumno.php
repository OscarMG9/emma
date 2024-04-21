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
                <?= form_open("registrar_alumno", ["id" => "form-nuevo-alumno"]) ?>
                    <div class="row">
                        <div class="form-group col-3">
                        <label for="alumno">Selecciona el Alumno</label><font color="red">*</font>
                        <?php 
                        $options = ['' => 'Selecciona un alumno']; // Array para opciones del select
                        foreach ($usuarios as $usuario) {
                            if ($usuario->idrol != 745 && $usuario->idrol != 125) {
                                $agregar = true;
                                foreach ($alumnos as $alumno) {
                                    if ($alumno->idusuario == $usuario->idusuario) {
                                        $agregar = false;
                                        break; // No es necesario continuar si ya se encontró el alumno en la lista
                                    }
                                }
                                if ($agregar) {
                                    $options[$usuario->idusuario] = $usuario->nombre . ' ' . $usuario->ap_paterno . ' ' . $usuario->ap_materno;
                                }
                            }
                        }

                        echo form_dropdown('alumno', $options, '', 'class="form-control" id="alumno" required');
                        ?>

                        </div>
                        <div class="form-group col-3">
                            <label for="matricula">matricula</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"text",
                                "id" =>"matricula",
                                "required" =>TRUE,
                                "name" =>"matricula"
                            );
                                echo form_input($attributes);
                            ?>
                        </div> 
                        <div class="form-group col-3">
                            <label for="grado">Grado</label><font color="red">*</font>
                            <?php 
                            $options = array(
                                '' => 'selecciona un grado',
                                'Primero' => 'PRIMERO',
                                'Segundo' => 'SEGUNDO',
                                'Tercero' => 'TERCERO',
                                'Cuarto' => 'CUARTO',
                                'Quinto' => 'QUINTO',
                                'Sexto' => 'SEXTO',
                                'Septimo' => 'SEPTIMO',
                                'Octavo' => 'OCTAVO',
                                'Noveno' => 'NOVENO',
                                // Puedes continuar añadiendo opciones según necesites
                            );

                            $attributes = array(
                                "class" => "form-control",
                                "id" => "grado",
                                "required" => TRUE
                            );

                            echo form_dropdown('grado', $options, '', $attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="grupo">Grupo</label><font color="red">*</font>
                            <?php 
                            $options = array(
                                '' => 'selecciona un grupo',
                                'A' => 'Grupo A',
                                'B' => 'Grupo B',
                                'C' => 'Grupo C',
                                'D' => 'Grupo D',
                                'E' => 'Grupo E',
                                'F' => 'Grupo F',
                                'G' => 'Grupo G',
                                'H' => 'Grupo H',
                                'I' => 'Grupo I',
                                // Puedes continuar añadiendo opciones según necesites
                            );

                            $attributes = array(
                                "class" => "form-control",
                                "id" => "grupo",
                                "required" => TRUE
                            );

                            echo form_dropdown('grupo', $options, '', $attributes);
                            ?>
                        </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <?= form_submit('btn-enviar','Registrar',["class" => "btn btn-success"]); ?>
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
