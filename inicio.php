<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>.: Inicio :. </title>
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/formato_moneda.js"></script>
	<script type="text/javascript" src="js/param_url.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
 	
 		<script src="css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap/dist/css/bootstrap.min.css">
		<script src="css/bootstrap/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			function pagina_actual(pag){
				$("#contenedor").attr('src',pag)
				$("body").append('<div class="loading_center w3-display-middle"><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i><span class="sr-only">Loading...</span></div>')
			}
			$(document).ready(function () {
				$("#arrow").click(function () {
					$("#barra").animate({
						'opacity': 'toggle',
						'display': ''
					},500)
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
				font-size: 1rem;
				zoom: 0.90;
				height: 100%;
				width: 100%;
				overflow:hidden;
			}
			p {
			  animation-duration: 0.5s;
			  animation-name: slidein;
			}
			@keyframes slidein {
			  from {
			    margin-left: 100%;
			    width: 300%
			  }
			  to {
			    margin-left: 0%;
			    width: 100%;
			  }
			}
			@include media-breakpoint-up(sm) {
			  html {
			    font-size: 1.2rem;
			  }
			}

			@include media-breakpoint-up(md) {
			  html {
			    font-size: 1.4rem;
			  }
			}

			@include media-breakpoint-up(lg) {
			  html {
			    font-size: 1.6rem;
			  }
			}
			#barra{
				z-index: 1000;
				
			}
			button{
				cursor: pointer;
			}
		</style>
</head>
<body>	
	<article class="w3-display-bottommiddle" >     
		
		<div class="btn-group" id="barra">
			<button type="button" class="btn btn-primary" onclick="pagina_actual('inicio.php')">Inicio</button>
			<button type="button" class="btn btn-primary" onclick="pagina_actual('operaciones_parametros_nomina/index.php')">Crear nueva nómina</button>
			<button type="button" class="btn btn-primary" onclick="pagina_actual('operaciones_parametros_nomina/select_nomina.php')">Seleccionar nómina</button>
			<button type="button" class="btn btn-primary" onclick="pagina_actual('constancia/index.php')">Generar constancia de trabajo</button>
			<button type="button" class="btn btn-success " onclick="pagina_actual('ficha_personal_new/index.php')">Buscar personal</button>
			<button type="button" class="btn btn-success " onclick="pagina_actual('ficha_personal_new/incluir_personal.php')">Incluir personal nuevo</button>
			<button type="button" class="btn btn-danger " onclick="pagina_actual('creador_formulas/formulas_creator.php')">Agregar nuevas fórmulas</button>	
			<button type="button" class="btn btn-danger " onclick="pagina_actual('parametros_globales/')">Globales</button>	
		</div>
		<center><i class="fa fa-angle-up fa-4x" id="arrow" style="cursor: pointer;"></i></center>
		 		
	</article>	

	<!-- <div class="w3-bar" style="background-color: #212529;color: white;height: 100%">
	  <a href="#" class="w3-bar-item w3-button" style="height: 100%">****</a>
	  <a href="#" class="w3-bar-item w3-button" style="height: 100%">****</a>
	  
	    <a href="log_out.php" class="w3-button w3-right" style="height: 100%">
	    	<i class="fa fa-window-close-o" aria-hidden="true"></i>
	    </a>   
	    <a href="#" onclick="pagina_actual('usuarios_autenticar/')" class="w3-button w3-right" style="height: 100%">
		    <i class="fa fa-cog" aria-hidden="true"></i>  
	    </a>			      

	</div> -->
	
	<iframe src="welcome.php" id="contenedor" onload="$('.loading_center').remove()" frameborder="0" style="width: 100%;height: 100%">	
	</iframe>

</body>
</html>
