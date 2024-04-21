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
                <?= form_open("registrar_asigalum", ["id" => "form-nuevo-asigalum"]) ?>
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="alumno">Selecciona el Alumno</label><font color="red">*</font>
                            <?php 
                            $options = ['' => 'Selecciona un alumno']; // Array para opciones del select
                            foreach ($usuarios as $usuario) {
                                foreach ($alumnos as $alumno) {
                                    if ($alumno->idusuario == $usuario->idusuario) {
                                        $options[$alumno->idalumno] = $usuario->nombre . ' ' . $usuario->ap_paterno . ' ' . $usuario->ap_materno;
                                    }
                                } 
                            }
                            echo form_dropdown('alumno', $options, '', 'class="form-control" id="alumno" required');
                            ?>
                        </div>
                     
                        <div class="form-group col-3">
                            <label for="fecharegistro">Fecha de registro</label>
                            <?php 
                            $attributes = array(
                                "class" =>"form-control",
                                "type" =>"date",
                                "id" =>"fecharegistro",
                                "name" =>"fecharegistro"
                            );
                            echo form_input($attributes);
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
                                // Si el usuario no es administrador (idrol != 745) y es un docente, agrégalo a la lista
                                if ($usuario->idrol != 745 && $esDocente && $usuario->idrol != 120) {
                                    $options[$docente->iddocente] = $usuario->nombre . ' ' . $usuario->ap_paterno . ' ' . $usuario->ap_materno;
                                }
                            }
                            echo form_dropdown('docente', $options, '', 'class="form-control" id="docente" required');
                            ?>
                        </div>

                        <div class="form-group col-3" id="asignatura-field" style="display: none;">
                            <label for="asignatura">Seleccionar asignatura</label><font color="red">*</font>
                            <?php 
                            $options = ['' => 'Selecciona una asignatura']; // Array para opciones del select
                            echo form_dropdown('asignatura', $options, '', 'class="form-control" id="asignatura" required');
                            ?>
                        </div>
                        
                        <div class="form-group col-3">
                            <label for="periodo">Seleccionar Periodo</label><font color="red">*</font>
                            <?php 
                            $options = ['' => 'Selecciona un periodo']; // Array para opciones del select
                            foreach ($periodos as $periodo) {
                                if ($periodo->estatus == ESTATUS_HABILITADO){
                                    $options[$periodo->idperiodo] = $periodo->acronimo;
                                }
                            }
                            echo form_dropdown('periodo', $options, '', 'class="form-control" id="periodo" required');
                            ?>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <?= form_submit('btn-enviar','Registrar',["class" => "btn btn-success"]); ?>
                        <a href="<?= route_to("administracion_asignacionalums")?>" class="btn btn-danger">Regresar</a>
                    </div>
                <?= form_close()?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("JS") ?>
<!-- Aquí puedes incluir cualquier JS específico si es necesario -->
<script>
    // Obtener el campo de selección de docente
    var docenteSelect = document.getElementById('docente');
    // Obtener el campo de selección de asignatura
    var asignaturaField = document.getElementById('asignatura-field');

    // Agregar un evento onchange al campo de selección de docente
    docenteSelect.addEventListener('change', function() {
        // Verificar si se ha seleccionado un docente
        if (this.value !== '') {
            // Mostrar el campo de selección de asignatura
            asignaturaField.style.display = 'block';
            // Filtrar las asignaturas que imparte el docente seleccionado
            var selectedDocente = this.value;
            var asignaturaOptions = <?= json_encode($asigmats); ?>;
            var asignaturaName = <?= json_encode($materias); ?>;
            var filteredOptions = {'': 'Selecciona una asignatura'};
            asignaturaOptions.forEach(function(asignatura) {
                asignaturaName.forEach(function(materia) {
                    if (asignatura.docente_iddocente == selectedDocente && asignatura.asignatura_idasignatura == materia.idasignatura) {
                        filteredOptions[asignatura.asignatura_idasignatura] = materia.asignatura;
                    }
                });
            });
                
            // Actualizar las opciones del campo de selección de asignatura
            var asignaturaDropdown = document.getElementById('asignatura');
            asignaturaDropdown.innerHTML = '';
            for (var key in filteredOptions) {
                var option = document.createElement('option');
                option.value = key;
                option.text = filteredOptions[key];
                asignaturaDropdown.appendChild(option);
            }
        } else {
            // Ocultar el campo de selección de asignatura si no se ha seleccionado un docente
            asignaturaField.style.display = 'none';
        }
    });
</script>

<?= $this->endSection() ?>
