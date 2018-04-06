<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title> .: Enviar Correo :. </title>
		<link rel="stylesheet" type="text/css" href="../css/w3.css">
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script src="../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../css/bootstrap/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				$("#search_de").click(function () {
					$("#modal_de").modal()
					buscar_de()
				})
				$("#add_destinatarios").click(function () {
					$("#destinatarios").append("<div><input class=\"destinatario\" placeholder=\"Destinatario\"/><button class=\"w3-red\" onclick=\"$(this).parent().remove()\">x</button></div>")
				})
				
				$(document).on("click","input[name=select_de]",function () {
					
					$("#de").html($(this).val())
				})
			})
			function buscar_de() {
				$.ajax({
					url:"search_de.php",
					data:{},
					type:"post",
					datatype:"json",
					beforeSend:function(){
						
					},

					success:function(data){
						$("#resultados_de").html(data)
						
						
					}
				});
			}
			function enviar_email() {
					var desti = $(".destinatario:input")
					var de = $("#de").text()
					var msj = $("#mensaje").val()
					var asunto = $("#asunto").val()

					var err = 0;
					for(i in desti){
						if(desti[i].value==""){
							err=err+1
						}
					}
					
					if (err==0) {
						if (de=="") {
							alert("Elija una cuenta de la cual se enviará el mensaje")
						}else{
							if (asunto=="") {
								alert("Asunto en blanco")
							}else{
								if (msj=="") {
									alert("Mensaje en blanco")
								}else{
									$.ajax({
										url:"proceso.php",
										data:{
											de:de,
											msj:msj,
											asunto:asunto,
											desti:function () {
												var json = {}
												for(i in desti){												
													json[i] = desti[i].value
												}
												return JSON.stringify(json)
											}
										},
										type:"post",
										datatype:"json",
										beforeSend:function(){
											
										},

										success:function(data){
											$("body").append("<div onclick='$(this).remove()' class='w3-display-topmiddle w3-green' style='overflow:auto;height:500px'>"+data+"</div>")
										}
									});
								}
							}
						}
					}else{
						alert("Campo de destinatario vacío!")
					}		
			}
		</script>
		<style type="text/css">
			
			@font-face {
			  font-family: 'Open Sans';
			  font-style: italic;
			  font-weight: 400;
			  src: url(../fonts/OpenSans-light.ttf);
			}
			html,body{
				font-family: 'Open Sans', sans-serif;
				font-size: 30px;
				zoom: 0.90;
				height: 100%;
				width: 100%;
			}	
			.destinatario{
				width: 500px;
			}	
		</style>
</head>
<body>
	<div class="container">
		<header class="w3-panel w3-border w3-dark-grey ">
			<center>
				<h1>
					Enviar correo electrónico
				</h1>
			</center>
		</header>
		<section>
			<div class="row w3-margin">
				<div class="col-2">
					De: <a href="#" id="search_de"><i class="fa fa-search"></i></a>
				</div>
				<div class="col" id="de">alvaroospino79@gmail.com</div>
			</div>
			<div class="row w3-margin">
				<div class="col">
					Destinatarios: <a href="#" id="add_destinatarios"><i class="fa fa-plus-square"></i></a>

				</div>
				<div class="col">
					<div id="destinatarios" class="float-right">
						<input class="destinatario" value="alvaroospino79@gmail.com" placeholder="Destinatario"/>
							
					</div>
				</div>
			</div>
			<div class="row w3-margin">
				<div class="col-2">
					Asunto: 
				</div>
				<div class="col">
					<textarea id="asunto" rows="1" style="width: 100%"></textarea>
				</div>
			</div>
			<div class="row w3-margin">
				<div class="col">
					<textarea style="height: 400px" rows="10" class="w3-border" id="mensaje"></textarea>
				</div>		
			</div>
		</section>
		<footer class="">
			<button class="w3-button w3-dark-grey w3-block" onclick="enviar_email()">
				Enviar
			</button>
		</footer>
	</div>

	<div class="modal" tabindex="-1" role="dialog" id="modal_de">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">

	      <div class="modal-body">
	      	<center>
	      		<h5>Añadir cuenta</h5><hr>
	      	</center>
			<div class="container-fluid" id="resultados_de">
				
			</div>
	      </div>
	      <div class="modal-footer">
        	<div class="col-3">
    			<a href="#" onclick="window.open('../parametros_globales/mail/')"><i class="fa fa-cog"></i></a>
    			<a href="#" onclick="buscar_de()"><i class="fa fa-repeat"></i></a> 	
        	</div>
        	<div class="col">
        		<button type="button" class="btn btn-success float-right" onclick="validar_fechas_inicio_cierre()" data-dismiss="modal">Acceptar</button> 
        	</div>
	      </div>
	    </div>
	  </div>
	</div>
</body>
</html>
