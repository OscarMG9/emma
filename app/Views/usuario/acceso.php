<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title></title>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' rel='stylesheet'>
    <link href="<?php echo base_url('recursos_login/css/style.css'); ?>" rel='stylesheet'>
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo base_url('recursos_panel/toastr/toastr.min.css'); ?>">
</head>
<body class='snippet-body'>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card my-5 mx-auto">
                    <div class="card-body cardbody-color p-lg-5">
                        <div class="text-center">
                            <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                                width="200px" alt="profile">
                            </div>
						<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Inicio de sesión</h3>
			      		</div>
					
			      	</div>
					<?= form_open('validar_usuario',["class"=> 'signin-form']) ?>
			      		<div class="form-group mb-3">
			      			<label class="label">Correo</label>
							
							<?php $attributes = array(
								'class' => 'form-control', 
								'type' => 'text', 
								'placeholder' => 'email@domain.com',
								'name' => 'correo',
								'required' => true,
								
							); 
							echo form_input($attributes);
							?>
			
			      		<!-- <input type="text" class="form-control" placeholder="Username" required> -->
			      		</div>
		            <div class="form-group mb-3">
		            	<label class="label">Contraseña</label>

						<?php $attributes = array(
								'class' => 'form-control', 
								'placeholder' => 'Contraseña',
								'name' => 'contraseña',
								'required' => true,
								
							); 
							echo form_password($attributes);
							?>

		            <!-- <input type="password" class="form-control" placeholder="Password" required> -->
		            </div>
		            <div class="form-group">	
					<?php
				echo form_submit('iniciar', 'iniciar Sesión',['class'=>' danger form-control text-light btn rounded submit px-3']);
				?>
		        <!-- <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button> -->
		            </div>

					
					<?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr -->
    <script src="<?php echo base_url('recursos_panel/toastr/toastr.min.js')?>"></script>
    <script>
        <?= 
        mostrar_mensaje()
        ?>
    </script>
</body>
</html>