<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title> .: Sistema de Nómina :.</title>
	<link rel="shortcut icon" type="image/png" href="image/sinapsis/sinapsis-icon.png"/>
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
			$(".denominacion_institucion").append($.cookie("denominacion_institucion"))
		}
		$(document).ready(function () {
			ww()
			user()
			//Escritor- Funciona
			setInterval(function () {
				var es = $("#escritor")
				es.toggleClass("escritor")
			},300)

			$(".link_opciones").click(function () {
				window.location = "vistas.php?path="+$(this).attr("title")
			})
		})
		$(document).on("click",".boton-chat",function() {
			
			if ($(".ventana-chat").css("display")=="none") {
				$(".ventana-chat").css("display","")
				$(this).css({
					width: "100px",
					height: "100px",
					backgroundColor: "#5bc0de"
				})
			}else{
				$(".ventana-chat").css("display","none")
				$(this).css({
					width: "90px",
					height: "90px",
					backgroundColor: "#88b7d5"
				})
			}
				

		})
			
	</script>
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
							<div class='row w3-section'>\
								<div class='cuadro-msj col-6 bg-info w3-round'>\
									<span class='mensaje'>"+arr[i]['msj']+"</span>\
								</div>\
								<div class='col'>\
								<span class='fecha'>"+arr[i]['fecha']+"</span>\
								</div>\
							</div>")
					}else if(arr[i]['para']==$("#para").text() || arr[i]['de']==$("#para").text()){
						$(".show-msj").append("\
							<div class='row w3-section'>\
								<div class='col text-right'>\
									<span class='fecha'>"+arr[i]['fecha']+"</span>\
								</div>\
								<div class='cuadro-msj col-6 bg-success w3-round text-right'>\
									<span class='mensaje'>"+arr[i]['msj']+"</span>\
								</div>\
							</div>")
					}
				}
				var target = $(".all_msj") 
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
				$(".contactos-vista").css("display","none")
				
			}
		})
		$(document).on("click",".alternar-contactos",function() {
			$(".contactos-vista").toggle(0)
			$(".chat-vista").toggle(0)
		})
		$(document).ready(contactos_busqueda)
		$(document).on("keyup","#buscar_contactos_input",contactos_busqueda)
		function contactos_busqueda() {
			$.ajax({
				url: "usuarios_autenticar/usuarios.php",
				type: "post",
				data: {operacion:"buscar",buscar: $("#buscar_contactos_input").val()},
				success:function (response) {
					var res = JSON.parse(response)
					$(".list-contactos").empty()
					for(i in res){
						if (res[i]['usuario']!="-" && res[i]['usuario']!=$.cookie('usuario')) {
							$(".list-contactos").append('<button class="btn btn-info contacto">'+res[i]['usuario']+'</button>')
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
		$(document).on("click",".abrir_modo_send_file",function() {
			$("#modal_send_file").modal()
		})
		$(document).on("click",".send-file",function() {
			$("#archivo_adjunto_chat")
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
			width: 300px;
			background-color: #5B738C;
			color: #FBFCFC;
		}
		.card-herramientas{
			width: 300px;
			background-color: #8B5D5D;
			color: #FBFCFC;
		}
		.card-personal{
			width: 300px;
			background-color: #6C8055;
			color: #FBFCFC;
		}
		.card-parametros{
			width: 300px;
			background-color: #487366;
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

		.icon-send{
			
		}
		.boton-chat {
			position: relative;
			background: #88b7d5;
			border: 2px solid #c2e1f5;
			width: 90px;
			height: 90px;
			border-radius: 20px;
			transition: 0.1s;
			cursor: pointer;
		}
		.boton-chat:hover{
			width: 100px;
			height: 100px;
			border-radius: 25px;
			transition: 0.1s;
			
		}
		.ventana-chat{
			width: 350px;
			height: 100%;
			background: #BBDAEE;
			border-radius: 7px;
			position: relative;
		}
		.show-msj{
			
		}
		.mensaje{
			word-wrap: break-word;
		}
		.fecha{
			word-wrap: break-word;
			color:grey;
			font-size: 10px
		}
		.cuadro-msj{
			padding: 5px
		}
		.ventana-chat button{
			cursor: pointer;
		}
		#lateral_usuario{
			background: rgba(0,64,71,1);
			background: -moz-linear-gradient(left, rgba(0,64,71,1) 0%, rgba(14,57,62,1) 34%, rgba(41,43,44,1) 100%);
			background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,64,71,1)), color-stop(34%, rgba(14,57,62,1)), color-stop(100%, rgba(41,43,44,1)));
			background: -webkit-linear-gradient(left, rgba(0,64,71,1) 0%, rgba(14,57,62,1) 34%, rgba(41,43,44,1) 100%);
			background: -o-linear-gradient(left, rgba(0,64,71,1) 0%, rgba(14,57,62,1) 34%, rgba(41,43,44,1) 100%);
			background: -ms-linear-gradient(left, rgba(0,64,71,1) 0%, rgba(14,57,62,1) 34%, rgba(41,43,44,1) 100%);
			background: linear-gradient(to right, rgba(0,64,71,1) 0%, rgba(14,57,62,1) 34%, rgba(41,43,44,1) 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#004047', endColorstr='#292b2c', GradientType=1 );
		}
		#cabezera_lateral_opciones{
			background-image: url(image/math2.jpg);
		}
	</style>
	</head>
<body>
	<div class="container-fluid" style="height: 100%">
		<div class="row" style="height: 100%">
			<div class="col-2 text-white table-responsive" id="lateral_usuario">
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
				<div class="row">
					<div class="col">
						
					</div>
				</div>
			</div>
			<div class="col" style="overflow:auto">
				<div class="row">
					<nav class="navbar navbar-toggleable-md navbar-light bg-faded" style="width: 100%">
					  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
					    <span class="navbar-toggler-icon"></span>
					  </button>
					  <a class="navbar-brand" href="#">
					  	<img src="image/sinapsis/sinapsis_completo.svg" width="150" alt=""> / Recursos Humanos / <span class="denominacion_institucion"></span></a>
					  <div class="collapse navbar-collapse" id="navbarText">
					    <ul class="navbar-nav mr-auto">
					      <li class="nav-item">
					        <a class="nav-link" href="#">Acerca de Sinapsis</a>
					      </li>
					    </ul>
					    <span class="navbar-text">
					      <a href="log_out.php"><button class="btn btn-outline-danger">Cerrar Sesión <i class="fa fa-close"></i></button></a>
					    </span>
					  </div>
					</nav>
				</div>
				<div class="row w3-center w3-section" id="cabezera_lateral_opciones">
					<div class="col w3-padding">
						<h1>Sistema Integral Administrativo de Procesos, Soporte, Información y  Seguridad</h1>
						<div style="font-size: 50px">
							Jamás fué tan fácil...
							<b><span class="text_write"></span></b>
							<span class="escritor" id="escritor">&nbsp;&nbsp;</span>
						</div>
					</div>
					
				</div>
				<div class="w3-margin-left">
					<div class="row">
						<div class="card-nomina w3-margin w3-padding w3-border hvr-grow w3-card-4 w3-round-large">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-id-card fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Crear nueva nómina</u></h6>
									<span title="operaciones_parametros_nomina/index.php" class="btn-outline-primary  w3-hover-text-white w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal text-white">
									Vamos! 
									</span>
								</div>
							</div>
						</div>
						<div class="card-nomina w3-margin w3-padding w3-border hvr-grow w3-card-4 w3-round-large">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-mouse-pointer fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Seleccionar nómina</u></h6>
									<span title="operaciones_parametros_nomina/select_nomina.php" class="btn-outline-primary  w3-hover-text-white w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal text-white">
									Vamos! 
									</span>
								</div>
							</div>
						</div>	
					</div>
					<div class="row">
						<div class="card-nomina w3-margin w3-padding w3-border hvr-grow w3-card-4 w3-round-large">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-calculator fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Prestaciones sociales</u></h6>
									<span title="prestaciones_sociales/" class="btn-outline-primary  w3-hover-text-white w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal text-white">
									Vamos! 
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="card-personal w3-margin w3-padding w3-border hvr-grow w3-card-4 w3-round-large">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-search fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Buscar personal</u></h6>
									<span title="ficha_personal/index.php" class="btn-outline-primary  w3-hover-text-white w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal text-white">
									Vamos! 
									</span>
								</div>
							</div>
						</div>
						<div class="card-personal w3-margin w3-padding w3-border hvr-grow w3-card-4 w3-round-large">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-user-plus fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Incluir nuevo personal</u></h6>
									<span title="ficha_personal/incluir_personal.php" class="btn-outline-primary  w3-hover-text-white w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal text-white">
									Vamos! 
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="card-herramientas w3-margin w3-padding w3-border hvr-grow w3-card-4 w3-round-large">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-clipboard fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Motor de documentos</u></h6>
									<span title="constancia/index.php" class="btn-outline-primary  w3-hover-text-white w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal text-white">
									Vamos! 
									</span>
								</div>
							</div>
						</div>
						<div class="card-herramientas w3-margin w3-padding w3-border hvr-grow w3-card-4 w3-round-large">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-envelope fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Webmail RainLoop</u></h6>
									<span title="webmail/rainloop" class="btn-outline-primary  w3-hover-text-white w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal text-white">
									Vamos! 
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="card-parametros w3-margin w3-padding w3-border hvr-grow w3-card-4 w3-round-large">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-wpforms fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Creador de fórmulas</u></h6>
									<span title="formulas_pago/" class="btn-outline-primary  w3-hover-text-white w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal text-white">
									Vamos! 
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="card-parametros w3-margin w3-padding w3-border hvr-grow w3-card-4 w3-round-large">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-paperclip fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Partidas presupuestarias</u></h6>
									<span title="partida_presupuestaria/" class="btn-outline-primary  w3-hover-text-white w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal text-white">
									Vamos! 
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="card-parametros w3-margin w3-padding w3-border hvr-grow w3-card-4 w3-round-large">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-cog fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Parámetros globales</u></h6>
									<span title="parametros_globales/" class="btn-outline-primary  w3-hover-text-white w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal text-white">
									Vamos! 
									</span>
								</div>
							</div>
						</div>
						<div class="card-parametros w3-margin w3-padding w3-border hvr-grow w3-card-4 w3-round-large">
							<div class="row">
								<div class="col-4">
									<i class="fa fa-cog fa-3x"></i>
								</div>
								<div class="col">
									<h6><u>Administrar usuarios</u></h6>
									<span title="usuarios_autenticar/" class="btn-outline-primary  w3-hover-text-white w3-btn w3-border w3-border-blue link_opciones hvr-icon-wobble-horizontal text-white">
									Vamos! 
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="w3-display-bottomright" style="margin-bottom: 20px;margin-right: 45px;position: fixed;height: 300px">
						<div class="container-fluid" style="height: 100%">
							<div class="row" style="height: 100%">
								<div class="col">
									<div class="ventana-chat w3-card-2 w3-padding w3-animate-bottom" style="display: none">
										
											<div class="row" style="height: 15%">
												<div class="col">
													<button class="btn btn-info alternar-contactos"><i class="fa fa-users"></i></button>
												</div>
												<div class="col w3-center">
													<b class=""><span id="para" class="h3"></span></b>
												</div>
											</div>
											<div class="row" style="height: 85%">
												<div class="col contactos-vista" style="overflow-y: auto;">
													<div class="row">
														<div class="col w3-center">
															<h3 class="w3-margin">Contactos</h3>
														</div>
													</div>
													<div class="row">
														<div class="col">
															<input type="text" id="buscar_contactos_input" placeholder="Buscar contacto..." class="form-control">
														</div>
													</div>
													<div class="row w3-margin-top">
														<div class="col">
															<div class="btn-group-vertical list-contactos" style="width: 100%">
																
															</div>
														</div>
													</div>
												</div>
												<div class="col chat-vista" style="display: none;padding: 0;">
													<div class="container-fluid" style="height: 100%">
														<div class="row all_msj" style="overflow-y: auto;height: 85%">
															<div class="col text-white">
																<div class="container-fluid">
																	<div class="show-msj"></div>
																</div>
															</div>
														</div>
														<div class="row" style="height: 15%">
																<div class="input-group h-100 d-inline-bloc">
																  <input type="text" class="form-control msj" placeholder="Escriba aquí su mensaje...">
																  <span class="input-group-addon btn-success send-msj">
																  	<i class="fa fa-arrow-right"></i>
																  </span>
																  <button class="input-group-addon btn-success abrir_modo_send_file" type="button">
																  	<i class="fa fa-file-o"></i>
																  </button>
																</div>
														</div>
													</div>
												</div>
											</div>
									</div>
								</div>
								<div class="col" style="">
									<div style="width: 100px">
									</div>
									<div class="w3-display-bottommiddle">
										<div class="boton-chat w3-card-2">
											<i class="fa fa-send fa-3x text-white icon-send w3-display-middle"></i>
										</div>
									</div>
									
								</div>
							</div>
						</div>				
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_send_file">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Enviar Archivo</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <p><input type="file" id="archivo_adjunto_chat"></p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary send-file">Enviar <i class="fa fa-send"></i></button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>
	  </div>
	</div>
</body>
</html>