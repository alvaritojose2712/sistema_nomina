<?php 
	session_start(); 
	setcookie("nombre",$_SESSION['nombre']);
	setcookie("apellido",$_SESSION['apellido']);
	setcookie("usuario",$_SESSION['usuario']);
	setcookie("departamento",$_SESSION['departamento']);
	setcookie("permiso",$_SESSION['permiso']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title> .: Sistema de Nómina :.</title>
	<link rel="stylesheet" href="css/w3.css">
	<link rel="stylesheet" href="css/hover/css/hover.css">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
		<script src="css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap/dist/css/bootstrap.min.css">
		<script src="css/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		
		var word = ["Procesar pagos","Gestionar información","Emitir documentos"]
		
	

		function ww() {
			var num = 0
			var n_word = 0
			var wr = $(".text_write")
			let word1 = setInterval(function () {
				
				if (word[n_word][num]==undefined) {
					
					//alert("holaa")
						var len = wr.text().length
						var borrar = setInterval(function () {
							wr.text(function (i,text) {
								return text.slice(0,len--)
							})
							if (len<0) {
								clearInterval(borrar)
								setTimeout(word2,800)
							}
						},80)
						clearInterval(word1)
						
					
				}else{
					wr.text(function (i,text) {
						return text+=word[n_word][num]
					})
					
					num++;
				}
			},200)
		}
		function word2() {
			var num = 0
			var n_word = 1
			var wr = $(".text_write")
			let word1 = setInterval(function () {
				
				if (word[n_word][num]==undefined) {
					
					//alert("holaa")
						var len = wr.text().length
						var borrar = setInterval(function () {
							wr.text(function (i,text) {
								return text.slice(0,len--)
							})
							if (len<0) {
								clearInterval(borrar)
								setTimeout(word3,800)
							}
						},80)
						clearInterval(word1)
						
					
				}else{
					wr.text(function (i,text) {
						return text+=word[n_word][num]
					})
					
					num++;
				}
			},200)
		}
		function word3() {
			var num = 0
			var n_word = 2
			var wr = $(".text_write")
			let word1 = setInterval(function () {
				
				if (word[n_word][num]==undefined) {
					
					//alert("holaa")
						var len = wr.text().length
						var borrar = setInterval(function () {
							wr.text(function (i,text) {
								return text.slice(0,len--)
							})
							if (len<0) {
								clearInterval(borrar)
								setTimeout(ww,800)
							}
						},80)
						clearInterval(word1)
						
					
				}else{
					wr.text(function (i,text) {
						return text+=word[n_word][num]
					})
					
					num++;
				}
			},200)
		}
		function user() {
			$(".nombre").append($.cookie("nombre"))
			$(".apellido").append($.cookie("apellido"))
			$(".usuario").append($.cookie("usuario"))
			$(".departamento").append($.cookie("departamento"))
			$(".permiso").append($.cookie("permiso"))
		}
		$(document).ready(function () {
			ww()
			user()
			//Escritor- Funciona
			setInterval(function () {
				var es = $("#escritor")
				es.hasClass("escritor")?es.removeClass("escritor"):es.addClass("escritor")
			},300)

			$(".link_opciones").click(function () {
				window.location = "vistas.php?path="+$(this).attr("title")
			})

			
		})
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
				height: 100%;
				width: 100%;
				background-color: #F5F5F5;
				overflow:hidden;
			}
			.img-user{
				margin: 0px;
				width: 100%;
			}
			.img-user-top{
				width: 40px;
				margin: 0px;
			}
			.card-nomina{
				width: 250px;
				background-color: #2C3E50;
				color: #FBFCFC;
			}
			.card-herramientas{
				width: 250px;
				background-color: #502C2C;
				color: #FBFCFC;
			}
			.card-personal{
				width: 250px;
				background-color: #3F502C;
				color: #FBFCFC;
			}
			.card-parametros{
				width: 250px;
				background-color: #2C5045;
				color: #FBFCFC;
			}
			.escritor{
				background-color: #00FEEE;
				width: 10px;
				height: 20px;
				color: #00FEEE;
				margin: 0px
			}
			frame{
				padding: 10px
			}
		</style>
	</head>
<body>
	<div class="container-fluid" style="height: 100%">
		<div class="row" style="height: 100%">
			<div class="col-2 bg-inverse text-white" id="lateral_usuario">
				<div class="row w3-margin-top">
					<div class="col">
						<div>
							<img src="image/empty.png" class="img-user w3-circle" alt="Imagen de usuario">
						</div>
						<div class="w3-margin-top">
							<center><b><span class="usuario"></span></b></center>		
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<p class="w3-margin-top">
							<h5 class="">
								<h3>
									<span class="nombre"></span> 
									<span class="apellido"></span>
								</h3>
								<small><span class="departamento"></span></small>
							</h5>
							
							<h6>
								<span class="w3-text-green">Acceso: </span>  
								<span class="permiso"></span><a href="perfil.php">
								<i class="fa fa-cogs"></i></a>
							</h6>
						</p>
					</div>
				</div>
			</div>
			
			<div class="col" style="overflow:auto">
				<div class="row bg-inverse text-white" id="barra-top" style="opacity: 0">
					<div class="col" style="text-align: right;">
						<b><span class="usuario" style="bottom: 0px"></span></b>
					</div>
					<div class="col-1">
						<img src="image/empty.png" class="img-user-top w3-circle" alt="Imagen de usuario">
					</div>
				</div>
				<div class="row w3-center">
					
					<div style="font-size: 20px;width: 100%" class="w3-margin">
						<center>
							<h1>Sistema integral para el procesamiento y emisión de pagos</h1>
							<div class="w3-center" style="font-size: 40px">
								Jamás fué tan fácil...
								<b><span class="text_write"></span></b>
								<span class="escritor" id="escritor">&nbsp;&nbsp;</span>
							</div>
						</center>
					</div>
						
					<div style="height: 200px;opacity: 0.5"></div>
				</div>
				<div class="w3-margin-left">
					<div class="row">
						<div class="card-nomina w3-margin w3-padding w3-border hvr-grow">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-id-card fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Crear nueva nómina</u></h6>
									<span title="operaciones_parametros_nomina/index.php" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal">
									Vamos! 
									</span>
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
									<span title="operaciones_parametros_nomina/select_nomina.php" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal">
									Vamos! 
									</span>
								</div>
							</div>
						</div>	
					</div>
					<div class="row">
						<div class="card-nomina w3-margin w3-padding w3-border hvr-grow">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-calculator fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Prestaciones sociales</u></h6>
									<span title="prestaciones_sociales/" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal">
									Vamos! 
									</span>
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
									<span title="ficha_personal/index.php" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal">
									Vamos! 
									</span>
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
									<span title="ficha_personal/incluir_personal.php" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal">
									Vamos! 
									</span>
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
									<span title="constancia/index.php" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal">
									Vamos! 
									</span>
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
									<span title="webmail/rainloop" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal">
									Vamos! 
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="card-parametros w3-margin w3-padding w3-border hvr-grow">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-wpforms fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Creador de fórmulas</u></h6>
									<span title="formulas_pago/" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal">
									Vamos! 
									</span>
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
									<span title="parametros_globales/" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal">
									Vamos! 
									</span>
								</div>
							</div>
						</div>
						<div class="card-parametros w3-margin w3-padding w3-border hvr-grow">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-cog fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Administrar usuarios</u></h6>
									<span title="usuarios_autenticar/" class="w3-white w3-hover-text-blue w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal">
									Vamos! 
									</span>
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