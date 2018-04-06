<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title> .: Perfil de usuario :.</title>
	<link rel="stylesheet" href="css/w3.css">
	<link rel="stylesheet" href="css/hover/css/hover.css">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
		<script src="css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap/dist/css/bootstrap.min.css">
		<script src="css/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		        
	</script>
	<style type="text/css">
		@font-face {
		  font-family: 'Open Sans';
		  font-style: italic;
		  font-weight: 400;
		  src: url(fonts/OpenSans-Light.ttf);
			}
			html,body{
				font-family: 'Open Sans', sans-serif;
				font-size: 18px;
				zoom: 0.90;
				height: 100%;
				width: 100%;
				background-color: #FBFCFC;
			}
			
		</style>
	</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-2">
				<div class="row">
					<div class="col">
						<img src="image/empty.png" class="img-user w3-circle" alt="Imagen de usuario">
					</div>
				</div>
				<div class="row">
					<div class="col">
						<p class="w3-margin-top">
							<h4><?php echo $_SESSION['nombre']." ".$_SESSION['apellido'] ?></h4>
							<small><b><?php echo $_SESSION['usuario'] ?></b></small>
							<a href="usuarios_autenticar/"><i class="fa fa-cogs"></i></a>
						</p>
					</div>
				</div>
				
			</div>
			<div class="col">
				<div class="w3-margin-top w3-margin-left">
					<div class="row">
						<div class="card-nomina w3-margin w3-padding w3-border hvr-grow">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-id-card fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Crear nueva nómina</u></h6>
									<a href="operaciones_parametros_nomina/index.php" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue hvr-icon-wobble-horizontal">
									Vamos! 
									</a>
								</div>
							</div>
						</div>
						<div class="card-nomina w3-margin w3-padding w3-border hvr-grow">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-mouse-pointer fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Seleccionar nómina</u></h6>
									<a href="operaciones_parametros_nomina/select_nomina.php" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue hvr-icon-wobble-horizontal">
									Vamos! 
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="card-personal w3-margin w3-padding w3-border hvr-grow">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-search fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Buscar personal</u></h6>
									<a href="ficha_personal/index.php" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue hvr-icon-wobble-horizontal">
									Vamos! 
									</a>
								</div>
							</div>
						</div>
						<div class="card-personal w3-margin w3-padding w3-border hvr-grow">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-user-plus fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Incluir nuevo personal</u></h6>
									<a href="ficha_personal/incluir_personal.php" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue hvr-icon-wobble-horizontal">
									Vamos! 
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="card-herramientas w3-margin w3-padding w3-border hvr-grow">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-clipboard fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Motor de plantillas</u></h6>
									<a href="constancia/index.php" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue hvr-icon-wobble-horizontal">
									Vamos! 
									</a>
								</div>
							</div>
						</div>
						<div class="card-herramientas w3-margin w3-padding w3-border hvr-grow">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-envelope fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Webmail RainLoop</u></h6>
									<a href="webmail/rainloop" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue hvr-icon-wobble-horizontal">
									Vamos! 
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="card-parametros w3-margin w3-padding w3-border hvr-grow">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-cog fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Parámetros globales</u></h6>
									<a href="parametros_globales/" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue hvr-icon-wobble-horizontal">
									Vamos! 
									</a>
								</div>
							</div>
						</div>
						<div class="card-parametros w3-margin w3-padding w3-border hvr-grow">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-cog fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Configurar cuentas</u></h6>
									<a href="usuarios_autenticar/" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue hvr-icon-wobble-horizontal">
									Vamos! 
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>