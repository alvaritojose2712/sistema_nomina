<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Chating </title>
	<link rel="stylesheet" type="text/css" href="../css/w3.css">
	
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script src="../js/jquery-ui/jquery-ui.js"></script>
	<script type="text/javascript" src="../js/jquery.cookie.js"></script>
 		
 		<link rel="stylesheet" type="text/css" href="../css/loaders.css/loaders.css">
		<script src="../css/loaders.css/loaders.css.js"></script>
 		
 		<script src="../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../css/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		var URLdomain = window.location.host;
		var conn = new WebSocket('ws://'+URLdomain+':33006');

		$(document).on("click",".send-msj",send_mensaje)
		$(document).keypress(function (e) {
			if(e.keyCode==13){
				send_mensaje()
			}
		})

			conn.onopen = function(e) {
			    console.log("Se ha establecido conexión!")
			    conn.send(JSON.stringify({
			    	idUser: $.cookie('usuario')
			    }))
			};
		

			conn.onmessage = function(e) {	
				//alert(e.data)
				var arr = JSON.parse(e.data)
				for(i in arr){
					
					
					if ($.cookie('usuario')==arr[i]['de']) {
						$(".show-msj").append("\
							<div class='row w3-margin'>\
								<div class='col-6 bg-primary w3-round-large'>\
									<span class='mensaje'>"+arr[i]['msj']+"</span>\
								</div>\
								<div class='col'>\
								<span class='fecha'>"+arr[i]['fecha']+"</span>\
								</div>\
							</div>")
					}else if(arr[i]['para']==$("#para").text() || arr[i]['de']==$("#para").text()){
						$(".show-msj").append("\
							<div class='row w3-margin'>\
								<div class='col text-right'>\
									<span class='fecha'>"+arr[i]['fecha']+"</span>\
								</div>\
								<div class='col-6 bg-success w3-round-large text-right'>\
									<span class='mensaje'>"+arr[i]['msj']+"</span>\
								</div>\
							</div>")
					}
				}
				var target = $(".contenedor_mensajes") 
			    target.animate({scrollTop:9999}, 500, 'swing');
			   
			};
		
		$(document).on("click",".contacto",function () {
			
			if ($("#para").text()!=$(this).text()) {
				$("#para").text($(this).text())
				$(".show-msj").empty()
				$(".chat-vista").show(300)
				var user = $.cookie('usuario')
				var d = {
						msj: "--show_all--",
						de: user,
						para: $(this).text()
				}
				conn.send(JSON.stringify(d))
			}
			

		})
		$(document).ready(contactos_busqueda)
		$(document).on("keyup","#buscar_contactos_input",contactos_busqueda)
		function contactos_busqueda() {
			$.ajax({
				url: "../usuarios_autenticar/usuarios.php",
				type: "post",
				data: {operacion:"buscar",buscar: $("#buscar_contactos_input").val()},
				success:function (response) {
					var res = JSON.parse(response)
					$(".list-contactos").empty()
					for(i in res){
						if (res[i]['usuario']!="-" && res[i]['usuario']!=$.cookie('usuario')) {
							$(".list-contactos").append('<button class="btn btn-primary contacto">'+res[i]['usuario']+'</button>')
						}
					}
				} 
			})
		}
		function send_mensaje() {
			var msj = $(".msj").val(function (err,data) {
				if (data.length>0) {
					var user = $.cookie('usuario')
					var d = {
							msj: data,
							de: user,
							para: $("#para").text()
					}
					conn.send(JSON.stringify(d))
					return ""
				}
			})
		}
	</script>
	<style type="text/css">
		@font-face {
		  font-family: 'Open Sans';
		  font-style: italic;
		  font-weight: 400;
		  src: url(../fonts/OpenSans-Light.ttf);
		}
		html,body{
			font-family: 'Open Sans', sans-serif;
			height: 100%;
			width: 100%;
			overflow: hidden;
		}	
		button{
			cursor: pointer;
		}
		.show-msj{
			font-size: 35px
		}
		.mensaje{
			word-wrap: break-word;
		}
		.fecha{
			word-wrap: break-word;
			color:grey;
			font-size: 10px
		}
	</style>
</head>
<body>
	<div class="container-fluid" style="height: 100%">
		<div class="row" style="height: 100%">
			<div class="col-3" style="overflow: auto;">
				<div class="row">
					<div class="col w3-center">
						<h3 class="w3-margin">Contactos</h3>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<input type="text" id="buscar_contactos_input" placeholder="Buscar contacto..." class="w3-input">
					</div>
				</div>
				<div class="row w3-margin-top">
					<div class="col">
						<div class="btn-group-vertical list-contactos" style="width: 100%">
							
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9 chat-vista w3-border-rounded" style="display: none;">
				
				
				<div class="row" style="height: 10%">
					<div class="col" style="display: table-cell">
						<b class="w3-display-middle">Enviar Mensaje a  <span id="para" class="h1"></span></b>
					</div>
				</div>
				<div class="row" style="height: 80%">
					<div class="col text-white contenedor_mensajes" style="width: 100%;height: 100%;overflow-y: auto;">
						<div class="container-fluid">
							<div class=" show-msj "></div>
						</div>
					</div>
				</div>
				<div class="row w3-padding" style="height: 10%">
					<div class="col">
						<textarea placeholder="Escriba aquí su mensaje..." style="height: 100%" class="w3-input w3-border msj"></textarea>
					</div>
					<div class="col-1">
						<button class="btn btn-success send-msj"><i class="fa fa-arrow-right"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>