<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title> .: Sistema de Nómina :.</title>
	<link rel="stylesheet" href="css/w3.css">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
		<script src="css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap/dist/css/bootstrap.min.css">
		<script src="css/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		    $(document).ready(function () {
				$("#acceder").click(auten); 
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
							"clave" : $('#clave').val()	
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
				        		.append("<b>Lo sentimos, pero eso no funcionó, por favor intente de nuevo!</b>")
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
		html,body{
			font-family: 'Open Sans', sans-serif;
			font-size: 18px;
			zoom: 0.90;
			height: 100%;
			width: 100%;
			background-color: #2C3E50
		}
		#notificacion{
			color:#333;

			width: 450px;
			background-color: #F2F4F4;
			border-radius: 7px
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
	</style>
</head>
<body>
	<div class="w3-display-middle">
		<div id="notificacion" class="w3-padding" style="display: none;cursor: pointer;" onclick="$(this).hide(200).empty()"></div>
		<div id="contenedor" class="container w3-padding w3-margin-top w3-animate-top">	
			
			<div class="row w3-margin">	
				<div class="col">
					<input class="w3-input w3-border" placeholder="Nombre de usuario" autocomplete="off" id="usuario" type="text" placeholder="Nombre de usuario"/>
				</div>
				<div class="col-1" style="padding: 0px">
					<center><i class="fa fa-user fa-2x"></i></center>	
				</div>
			</div>
			<div class="row w3-margin">			
				<div class="col">
					<input class="w3-input w3-border" placeholder="Clave" autocomplete="off" id="clave" type="password" placeholder="Clave">
				</div>
				<div class="col-1" style="padding: 0px">
					<center><i class="fa fa-key fa-2x"></i></center>	
				</div>	
			</div>		

			<button type="button" class="btn btn-primary btn-lg btn-block" id="acceder">Acceder</button>
		</div>
		
	</div>
</body>
</html>