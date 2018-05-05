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
			$(document).on("click",".sessiones",function () {
				$('.cargando').css('display','')
				$("#vista_frame").attr("src",$(this).attr("title"))
				//$("#name_vista").html($(this).html())
				$(".opciones_explora").toggle()
			})
			$(document).on("click",".abrir_explora",function () {
				var t = $(this)
				$(".opciones_explora")
				.css({
					"left":t.offset().left,
				})
				.toggle()
			})
			$(document).on("click",".abrir_opciones_cuenta",function () {
				var t = $(this)
				var c = $(".opciones_cuenta")
				//alert(t.offset().left-c.css("width").replace("px",""))
				c.css({
					"right":"0px",
				})
				c.toggle()
			})
			$(document).ready(function () {
				$(".user").text($.cookie("usuario"))
				ajustar()
			})
			window.onresize = function(){ajustar()}
			function ajustar() {
				let num = parseInt($(window).height())-parseInt($("#barra_navegador").height())
				$("#vista_frame").css("height",num)
			}
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
				overflow:hidden;
			}
			button{
				cursor: pointer;
			}
			#vista_frame{
				width: 100%;
			}
			.contenedorExterior {
			    display: table;
			    height: 100%;
			    overflow: hidden;
			}
			.contenedorExterior .contenedorInterior {
			    display: table-cell;
			    vertical-align: middle;
			    width: auto;
			    margin: 0 auto;
			    text-align: center;
			}
			.opciones_explora{
				position: absolute;
				width: 350px;
				height: 400px;
				overflow-y: auto;
				display: none;
				background-color: #f2f2f2;
			}
			.opciones_cuenta{
				position: absolute;
				width: 200px;
				overflow-y: auto;
				display: none;
				margin-right:30px 
			}
			.row{
				height: 100%;
			}
			.imagen_usuario{
				border-radius: 10px;
				margin:5px;
			}
			li:hover{
				background-color: #0097C2;
				color:white;
				cursor: pointer;
			}
			.list-group-item{
				border: 0px;
			}
		</style>
	</head>
<body>
	<nav class="bg-inverse bg-faded container-fluid w3-card-2 w3-margin-bottom" id="barra_navegador">
	  <div class="row">
	  	<div class="col">
  			<div class="contenedorExterior">
	  			<div class="col contenedorInterior">
		  			<a href="menu.php" class="h2 text-white">
		  				<i class="fa fa-home"></i> Inicio
		  			</a>	
			  	</div>
			  	<div class="col contenedorInterior">
			  		<a class="h4 text-primary" href="webmail/rainloop"><i class="fa fa-mail-forward"></i> Correo Electrónico</a>	
			  	</div>
			  	<div class="col contenedorInterior">
			  		<button class="btn btn-primary abrir_explora">Explora <i class="fa fa-arrow-down"></i></button>
			  	</div>
  			</div>
	  	</div>
	  	<div class="col">
  			<div class="contenedorExterior w3-right abrir_opciones_cuenta" style="cursor: pointer;">
			  	<div class="col contenedorInterior">
			  		<img src="image/empty.png" width="50" height="50" alt="Imagen de usuario" class="imagen_usuario">
			  	</div>
			  	<div class="col contenedorInterior" style="padding-left: 0">
			  		<i class="fa fa-angle-down text-white fa-2x" ></i>
			  	</div>
  			</div>
	  	</div>
	  </div>
	</nav>
	<div class="w3-card-2 w3-padding opciones_explora">
  		<span class="dropdown-header h2 text-primary">Nómina</span>
			<a class="dropdown-item sessiones" href="#" title="operaciones_parametros_nomina/index.php">	
				<div class="row">
					<div class="col-3"><i class="text-primary fa fa-id-card fa-3x"></i></div>
					<div class="col">
						<span class="text-primary">Crear nueva nómina
						</span>
					</div>
				</div>
			</a>
			<a class="dropdown-item sessiones" href="#" title="operaciones_parametros_nomina/select_nomina.php">
				<div class="row">
					<div class="col-3"><i class="text-primary fa fa-mouse-pointer fa-3x"></i></div>
					<div class="col">
						<span class="text-primary">Seleccionar nómina
						</span>
					</div>
				</div>
			</a>
		<span class="dropdown-header h2 text-primary">Personal</span>
			<a class="dropdown-item sessiones" href="#" title="ficha_personal/index.php">	
				<div class="row">
					<div class="col-3"><i class="text-primary fa fa-search fa-3x"></i></div>
					<div class="col">
						<span class="text-primary">Buscar personal
						</span>
					</div>
				</div>
			</a>
			<a class="dropdown-item sessiones" href="#" title="ficha_personal/incluir_personal.php">
				<div class="row">
					<div class="col-3"><i class="text-primary fa fa-user-plus fa-3x"></i></div>
					<div class="col">
						<span class="text-primary">Incluir nuevo personal
						</span>
					</div>
				</div>
			</a>
		<span class="dropdown-header h2 text-primary">Prestaciones sociales</span>
			<a class="dropdown-item sessiones" href="#" title="prestaciones_sociales/">
				<div class="row">
					<div class="col-3"><i class="text-primary fa fa-calculator fa-3x"></i></div>
					<div class="col">
						<span class="text-primary">Prestaciones sociales
						</span>
					</div>
				</div>
			</a>
		<span class="dropdown-header h2 text-primary">Partidas presupuestarias</span>
			<a class="dropdown-item sessiones" href="#" title="partida_presupuestaria/">
				<div class="row">
					<div class="col-3"><i class="text-primary fa fa-calendar fa-3x"></i></div>
					<div class="col">
						<span class="text-primary">Creador de partidas
						</span>
					</div>
				</div>
			</a>
		<span class="dropdown-header h2 text-primary">Herramientas</span>
			<a class="dropdown-item sessiones" href="#" title="constancia/index.php">	
				<div class="row">
					<div class="col-3"><i class="text-primary fa fa-clipboard fa-3x"></i></div>
					<div class="col">
						<span class="text-primary">Motor de documentos
						</span>
					</div>
				</div>
			</a>
		<span class="dropdown-header h2 text-primary">Fórmulas de pago</span>
			<a class="dropdown-item sessiones" href="#" title="formulas_pago/index.php">
				<div class="row">
					<div class="col-3"><i class="text-primary fa fa-wpforms fa-3x"></i></div>
					<div class="col">
						<span class="text-primary">Creador de fórmulas
						</span>
					</div>
				</div>
			</a>	
		<span class="dropdown-header h2 text-primary">Globales</span>
			<a class="dropdown-item sessiones" href="#" title="parametros_globales/">	
				<div class="row">
					<div class="col-3"><i class="text-primary fa fa-cogs fa-3x"></i></div>
					<div class="col">
						<span class="text-primary">Parámetros globales
						</span>
					</div>
				</div>
			</a>
			<a class="dropdown-item sessiones" href="#" title="usuarios_autenticar/">
				<div class="row">
					<div class="col-3"><i class="text-primary fa fa-cog fa-3x"></i></div>
					<div class="col">
						<span class="text-primary">Administrar usuarios
						</span>
					</div>
				</div>
			</a>	
	</div>
	<div class="w3-card-4 w3-white opciones_cuenta">
		<div class="container-fluid">
			<div class="row w3-padding"><span class="font-italic">Ha iniciado sesión</span></div>
			<div class="row w3-padding w3-border-bottom"><span class="user h4 font-weight-bold"></span></div>
			<div class="row list-group w3-margin-top w3-margin-bottom">
				<li class="list-group-item">Perfil</li>
				<li class="list-group-item">Sugerencias</li>
				<li class="list-group-item text-danger" onclick="window.location='log_out.php'">Cerrar sesión</li>
			</div>
		</div>
	</div>
	<iframe src="<?php echo $_GET['path'] ?>" frameborder="0" id="vista_frame" onload="$('.cargando').css('display','none')"></iframe>
	<div class="cargando" style="width: 100%;height: 100%;color: red"><i class="w3-display-middle fa fa-spinner fa-pulse fa-5x fa-fw"></i><span class="sr-only">Loading...</span>
	<div class="modal-backdrop show"></div>
	</div>
</body>
</html>