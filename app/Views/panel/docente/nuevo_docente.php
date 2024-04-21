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
                <?= form_open("registrar_docente", ["id" => "form-nuevo-docente"]) ?>
                    <div class="row">
                        
                        <div class="form-group col-4">
                        <label for="usuario">Seleccionar usuario</label><font color="red">*</font>
                            <?php 
                            $options = ['' => 'Selecciona un usuario']; // Array para opciones del select
                            foreach ($usuarios as $usuario) {
                                $esDocente = false; // Bandera para indicar si el usuario es docente
                                foreach ($docentes as $docente) {
                                    if ($docente->usuario_idusuario == $usuario->idusuario) {
                                        $esDocente = true;
                                        break; // Si el usuario es encontrado como docente, no es necesario seguir buscando
                                    }
                                }
                                // Si el usuario no es administrador (idrol != 745) y no es un docente, agrégalo a la lista
                                if ($usuario->idrol != 745 && !$esDocente && $usuario->idrol != 120) {
                                    $options[$usuario->idusuario] = $usuario->nombre . ' ' . $usuario->ap_paterno . ' ' . $usuario->ap_materno;
                                }
                            }
                            echo form_dropdown('usuario', $options, '', 'class="form-control" id="usuario" required');
                            ?>



                        </div>
                        <div class="form-group col-2">
                            <label for="acronimo">Numero de empleado</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"text",
                                "id" =>"numeroempleado",
                                "name" =>"numeroempleado",
                                "placeholder" =>"Numero de empleado",
                                "required" => TRUE
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-2">
                            <label for="creditos">Grado de estudios</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"text",
                                "id" =>"gradoestudios",
                                "name" =>"gradoestudios",
                                "placeholder" =>"Grado de estudios",
                                "required" => TRUE
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-4">
                            <label for="creditos">Programa educativo</label><font color="red">*</font>
                            <?php 
                        $options = ['' => 'Selecciona un programa']; // Array para opciones del select
                        foreach ($programas as $programa) {
                            
                            $options[$programa->idprograma_educativo] = $programa->programaeducativo;
                    }
                        echo form_dropdown('programa', $options, '', 'class="form-control" id="programa" required');
                        ?>

                        </div>

                    </div>
                    </div>
                    <div class="card-footer text-right">
                        <?= form_submit('btn-enviar','Registrar',["class" => "btn btn-success"]); ?>
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
