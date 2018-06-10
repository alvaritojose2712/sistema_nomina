<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> .: Parámetros globales:.</title>
	<link rel="stylesheet" type="text/css" href="../css/w3.css">
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="../js/formato_moneda.js"></script>
	<script type="text/javascript" src="../js/param_url.js"></script>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery.cookie.js"></script>
	<script src="../css/bootstrap/dist/js/tether.min.js"></script>
	<link rel="stylesheet" href="../css/bootstrap/dist/css/bootstrap.min.css">
	<script src="../css/bootstrap/dist/js/bootstrap.min.js"></script>

	<style type="text/css">
		@font-face {
		  font-family: 'Open Sans';
		  font-style: italic;
		  font-weight: 400;
		  src: url(../fonts/OpenSans-Regular.ttf);
		}
		html,body{
			font-family: 'Open Sans', sans-serif;
			font-size: 18px;
			zoom: 0.90;
			height: 100%;
			width: 100%;
		}
		.sueldos:hover{
			background-color: #B3F6BB;
			color:#037111;
			cursor: pointer;

			transition: 0.5s
		}
		.tributaria:hover{
			background-color: #AAEEDD;
			color:#037156;
			cursor: pointer;

			transition: 0.5s
		}
		.valores:hover{
			background-color: #EEAABF;
			color:#730A2A;
			cursor: pointer;

			transition: 0.5s
		}
		.card{
			width: 20rem;
			margin: 20px;
		}
	</style>
</head>
<body>	
	<aside class="w3-display-topmiddle">
		<header>
			<center>
				<h3>Configurar parámetros globales</h3>
			</center>
		</header>	
		<div class="card sueldos" style="">
		  <div class="card-block">
		    <h4 class="card-title">Tabla de sueldos</h4>
		    <p class="card-text">Los valores de la tabla de sueldos son indispensables para la realización de cualquier cálculo.</p>
		    <a href="sueldos/sueldos.php" class="btn btn-info">Configurar <i class="fa fa-wrench" aria-hidden="true"></i></a>
		  </div>
		</div>

		<div class="card tributaria" style="">
		  <div class="card-block">
		    <h4 class="card-title">Unidad tributaria</h4>
		    <p class="card-text">La configuración de la unidad tributaria es primordial para la base de cálculo de una nómina.</p>
		    <a href="unidad_tributaria/" class="btn btn-info">Configurar <i class="fa fa-wrench" aria-hidden="true"></i></a>
		  </div>
		</div>

		<div class="card valores" style="">
		  <div class="card-block">
		    <h4 class="card-title">Valores globales</h4>
		    <p class="card-text">Inserte, modifique o elimine valores globales como Categoría, cargo, dedicación y Grado de instrucción posibles para un trabajador (a).</p>
		    <a href="valores_globales/" class="btn btn-info">Configurar <i class="fa fa-wrench" aria-hidden="true"></i></a>
		  </div>
		</div>

		<div class="card sueldos" style="">
		  <div class="card-block">
		    <h4 class="card-title">Email</h4>
		    <p class="card-text">Configure la cuenta predeterminada para enviar correos electrónicos</p>
		    <a href="mail/" class="btn btn-info">Configurar <i class="fa fa-wrench" aria-hidden="true"></i></a>
		  </div>
		</div>
		<div class="card sueldos" style="">
		  <div class="card-block">
		    <h4 class="card-title">Instituciones</h4>
		    <p class="card-text">Administre las instituciones registradas en el sistema</p>
		    <a href="../administrar_instituciones" class="btn btn-info">Configurar <i class="fa fa-wrench" aria-hidden="true"></i></a>
		  </div>
		</div>
	</aside>
</body>
</html>


