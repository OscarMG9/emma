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
                <?= form_open("actualizar_usuario/".$usuario->idusuario, ["id" => "form-nuevo-usuario"]) ?>
                    <div class="row">
                        <div class="form-group col-3">
                        <label for="nombre">Nombre</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"text",
                                "id" =>"nombre",
                                "name" =>"nombre",
                                "value" => $usuario->nombre,
                                "placeholder" =>"Nombre"
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="ap_paterno">Apellido Paterno</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"text",
                                "id" =>"ap_paterno",
                                "name" =>"ap_paterno",
                                "value" => $usuario->ap_paterno,
                                "placeholder" =>"Apellido Paterno"
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="ap_materno">Apellido Materno</label>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"text",
                                "id" =>"ap_materno",
                                "name" =>"ap_materno",
                                "value" => $usuario->ap_materno,
                                "placeholder" =>"Apellido Materno"
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="sexo">Sexo</label><font color="red">*</font>
                            <?php 
                        $options = [
                            '0' => 'MASCULINO',
                            '1' => 'FEMENINO'
                        ];
                        $attributes = [
                            'class' => 'custom-select',
                            'id'    => 'sexo',
                            'name'  => 'sexo'
                        ];
                        echo form_dropdown('sexo', $options, $usuario->sexo, $attributes);
                        ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="correo">Correo</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"email",
                                "id" =>"correo",
                                "name" =>"correo",
                                "value" => $usuario->correo,
                                "placeholder" =>"Correo electrónico"
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="password">Contraseña</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"password",
                                "id" =>"password",
                                "name" =>"password",
                                "placeholder" =>"Contraseña"
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                        <div class="form-group col-3">
                            <label for="password">Repetir Contraseña</label><font color="red">*</font>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"password",
                                "id" =>"repassword",
                                "name" =>"repassword",
                                "placeholder" =>"Repetir Contraseña"
                            );
                                echo form_input($attributes);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-8">
                            <label for="imagen_perfil">Imagen de perfil</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <?php 
                                $attributes = array(
                                    "class" =>"custom-file-input",
                                    "type" =>"file",
                                    "value" => $usuario->imagen_perfil,
                                    "id" =>"imagen_perfil",
                                    "name" =>"imagen_perfil",
                                    "placeholder" =>"Contraseña"
                                );
                                    echo form_input($attributes);
                                ?>
                                    <label class="custom-file-label" for="imagen_perfil">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label for="idrol">Rol</label> <font color="red">*</font>
                            <?php 
                            $options = [
                                '745' => 'ADMINISTRADOR',
                                '125' => 'DOCENTE',
                                '120' => 'ALUMNO'
                            ];
                            $attributes = [
                                'class' => 'custom-select',
                                'id'    => 'idrol',
                                'name'  => 'idrol'
                            ];
                            echo form_dropdown('idrol', $options, $usuario->idrol, $attributes);
                            ?>
                        </div>
                    </div>
                      </div>
                    <div class="card-footer text-right">
                        <?= form_submit('btn-actualizar','Actualizar',["class" => "btn btn-success"]); ?>
                        <a href="<?= route_to("administracion_usuarios")?>" class="btn btn-danger">Regresar</a>
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
