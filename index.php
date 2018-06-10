<?php 
	include "conexion_bd.php";
	$sql = (new sql("instituciones"))->select();
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title> .: Sinapsis :.</title>
	<link rel="shortcut icon" type="image/png" href="image/sinapsis/sinapsis-icon.png"/>
	<link rel="stylesheet" href="css/w3.css">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
		<script src="css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap/dist/css/bootstrap.min.css">
		<script src="css/bootstrap/dist/js/bootstrap.min.js"></script>
		<link href="css/hover/css/hover.css" rel="stylesheet" media="all">

	<script type="text/javascript">
		var word = ["Sistema Integral Administrativo de Procesos, Soporte, Información y  Seguridad"]
		function ww() {
			var num = 0
			var n_word = 0
			var wr = $(".text_write")
			let word1 = setInterval(function () {
				
				if (word[n_word][num]==undefined) {
					
					//alert("holaa")
						var len = wr.text().length
						// var borrar = setInterval(function () {
						// 	wr.text(function (i,text) {
						// 		return text.slice(0,len--)
						// 	})
						// 	if (len<0) {
						// 		clearInterval(borrar)
						// 		setTimeout(ww,200)
						// 	}
						// },80)
						clearInterval(word1)
						
					
				}else{
					wr.text(function (i,text) {
						return text+=word[n_word][num]
					})
					
					num++;
				}
			},50)
		}
		    $(document).ready(function () {
				$("#acceder").click(auten); 
				ww()
				setInterval(function () {
					var es = $("#escritor")
					es.toggleClass("escritor")
				},300)
		    }); 
		    $(document).keypress(function (e) {
				if(e.keyCode==13){
					auten()
				}
			})
			function auten() {
		    	$("#notificacion")
				.empty()
				.show(200,function () {
					$.ajax({
				        url:"autenticar.php",
				        data:{
							"usuario" : $('#usuario').val(), 
							"clave" : $('#clave').val(),
							"institucion_seleccionada" : $('#institucion_seleccionada').val()
							
				   		},
				        type:"post",
				        beforeSend:function(){
				        	$("#notificacion").append('<center><i class="fa fa-spinner fa-pulse fa-2x fa-fw w3-text-black"></i><span class="sr-only">Loading...</span></center>')
				        },
				        success:function(response)
				        {	
				        	
				        	if (response=="false") {
				        		$("#notificacion")
				        		.empty()
				        		.append("Lo sentimos, pero eso no funcionó, <b>por favor intente de nuevo!</b>")
				        		$('#clave').val("");
				        	}
				        	else{
				        		window.location="menu.php";
				        	}
				        }
				   });
				})
		    }    
	</script>
	<style type="text/css">
		@font-face {
		  font-family: 'Open Sans';
		  font-style: italic;
		  font-weight: 400;
		  src: url(fonts/OpenSans-Light.ttf);
		}
		@font-face {
		  font-family: 'Roboto';
		  font-style: italic;
		  font-weight: 400;
		  src: url(fonts/Roboto-LightItalic.ttf);
		}
		@font-face {
		  font-family: 'CaviarDreams';
		  font-style: italic;
		  font-weight: 400;
		  src: url(fonts/CaviarDreams.ttf);
		}
		html,body{
			height: 100%;
			width: 100%;
			background: rgba(10,47,92,1);
			background: -moz-linear-gradient(45deg, rgba(10,47,92,1) 0%, rgba(36,97,130,1) 16%, rgba(12,210,245,1) 53%, rgba(36,97,130,1) 82%, rgba(10,47,92,1) 100%);
			background: -webkit-gradient(left bottom, right top, color-stop(0%, rgba(10,47,92,1)), color-stop(16%, rgba(36,97,130,1)), color-stop(53%, rgba(12,210,245,1)), color-stop(82%, rgba(36,97,130,1)), color-stop(100%, rgba(10,47,92,1)));
			background: -webkit-linear-gradient(45deg, rgba(10,47,92,1) 0%, rgba(36,97,130,1) 16%, rgba(12,210,245,1) 53%, rgba(36,97,130,1) 82%, rgba(10,47,92,1) 100%);
			background: -o-linear-gradient(45deg, rgba(10,47,92,1) 0%, rgba(36,97,130,1) 16%, rgba(12,210,245,1) 53%, rgba(36,97,130,1) 82%, rgba(10,47,92,1) 100%);
			background: -ms-linear-gradient(45deg, rgba(10,47,92,1) 0%, rgba(36,97,130,1) 16%, rgba(12,210,245,1) 53%, rgba(36,97,130,1) 82%, rgba(10,47,92,1) 100%);
			background: linear-gradient(45deg, rgba(10,47,92,1) 0%, rgba(36,97,130,1) 16%, rgba(12,210,245,1) 53%, rgba(36,97,130,1) 82%, rgba(10,47,92,1) 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0a2f5c', endColorstr='#0a2f5c', GradientType=1 );
		}
		#notificacion{
			
		}
		#contenedor{
			width: 450px;
			background-color: #333;
			border-radius: 7px;
		}
		input{
			background-color: #333;
			color:#F2F4F4;
		}
		i{
			color:white;
		}
		.panel_izquierdo{
			font-family: 'Open Sans', sans-serif;

			background-image: url(image/math.jpg);
			font-size: 15px

		}
		.panel_derecho{
			font-family: 'CaviarDreams', sans-serif;
			font-size: 20px
			background: rgba(0,64,71,1);
			background: -moz-linear-gradient(left, rgba(0,64,71,1) 0%, rgba(14,57,62,1) 34%, rgba(41,43,44,1) 100%);
			background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,64,71,1)), color-stop(34%, rgba(14,57,62,1)), color-stop(100%, rgba(41,43,44,1)));
			background: -webkit-linear-gradient(left, rgba(0,64,71,1) 0%, rgba(14,57,62,1) 34%, rgba(41,43,44,1) 100%);
			background: -o-linear-gradient(left, rgba(0,64,71,1) 0%, rgba(14,57,62,1) 34%, rgba(41,43,44,1) 100%);
			background: -ms-linear-gradient(left, rgba(0,64,71,1) 0%, rgba(14,57,62,1) 34%, rgba(41,43,44,1) 100%);
			background: linear-gradient(to right, rgba(0,64,71,1) 0%, rgba(14,57,62,1) 34%, rgba(41,43,44,1) 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#004047', endColorstr='#292b2c', GradientType=1 );

		}
		#acceder{
			cursor: pointer;
		}
		.font-regular-bebas{
			font-family: 'Roboto', sans-serif;
		}
		.escritor{
			background-color: #00FEEE;
			width: 10px;
			height: 20px;
			color: #00FEEE;
			margin: 0px
		}

	</style>
</head>
<body>
	
	<div class="w3-display-middle w3-card-4 w3-animate-opacity" style="width: 80%">
		<div class="container-fluid h-100 table-responsive">
			<div class="row h-100">
				<div class="col-5 bg-faded panel_izquierdo" style="padding: 30px">
					<div class="row w3-section">
						<di class="col w3-center">
							<img src="image/sinapsis/sinapsis_completo.svg" width="100%" alt="" class="w3-animate-top">
						</di>
					</div>
					<div class="row w3-section">
						<div class="col w3-center">
							<h4 class="font-regular-bebas">
								<span class="text_write"></span>
								<span class="escritor" id="escritor">&nbsp;&nbsp;</span>
							</h4>
							<p class="w3-section">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid adipisci non quod qui, pariatur laborum maiores recusandae cumque ab, officiis aut voluptatibus soluta. Provident, beatae nisi aliquam. Cumque repellendus, perspiciatis.
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col">
							
						</div>
					</div>
				</div>
				<div class="col text-white panel_derecho" style="padding: 30px">
					<div class="row h-100">
						<div class="col">	
							<div class="row w3-section w3-border-bottom">
								<div class="col h2" style="padding: 0">
									Iniciar Sesión / <span style="color:#96D7D9">Recursos Humanos</span>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div id="notificacion" class="w3-round w3-padding alert alert-danger w-100" style="display: none;cursor: pointer;" onclick="$(this).hide(200).empty()"></div>
								</div>
							</div>
							<div class="row w3-section">	
								<div class="col-2 w3-center" style="">
									<i class="fa fa-user fa-2x"></i>	
								</div>
								<div class="col">
									<input class="form-control-lg form-control  w3-border" placeholder="Nombre de usuario" autocomplete="off" id="usuario" type="text" placeholder="Nombre de usuario"/>
								</div>
							</div>
							<div class="row w3-section">			
								<div class="col-2 w3-center" style="">
									<i class="fa fa-key fa-2x"></i>	
								</div>	
								<div class="col">
									<input class="form-control-lg form-control  w3-border" placeholder="Clave" autocomplete="off" id="clave" type="password" placeholder="Clave">
								</div>
							</div>	
							<div class="row w3-section">
								<div class="col-2 w3-center" style="">
									<i class="fa fa-database fa-2x w3-display-middle"></i>	
								</div>
								<div class="col">
									<div class="form-group">
										<div class="text-white w3-margin-bottom">Seleccione una institución:</div>
										<select id="institucion_seleccionada" class="form-control-lg form-control ">
											<?php 
												while($row = $sql->fetch_assoc()){
													echo "<option value='".$row['id']."'>".$row['denominacion']."</option>";
												}
												
											 ?>
										</select>
									</div>
										
								</div>
							</div>	
							<div class="row align-items-end">
								<div class="col-2">
									
								</div>
								<div class="col">
									<button type="button" class="btn hvr-icon-forward btn-lg" style="width: 100%;background-color: #96D7D9" id="acceder">Acceder</button>
								</div>
							</div>
						</div>
						<div class="col-4 w3-border-left">
							<div class="w3-display-middle w-100 w3-padding-large">
								<p>
									<span style="color:#96D7D9">¿Problemas al Iniciar?</span>
								</p>
								<p>
									Contacte al administrador para obtener más ayuda!
								</p>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>