<?php 
	session_start();
	include '../../conexion_bd.php'; 
	
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title> .: Emails :.</title>
		<link rel="stylesheet" type="text/css" href="../../css/w3.css">
		<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
		<script type="text/javascript" src="../../js/formato_moneda.js"></script>
		<script type="text/javascript" src="../../js/jquery.js"></script>
		<script src="../../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../../css/bootstrap/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				buscar()
			})
			function buscar() {
				$.ajax({
						url:"procesar.php",
						data:{"operacion":"buscar"},
						type:"post",
						datatype:"json",
						beforeSend:function(){
							$("#resultados_buscar").append('<center><div><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div></center>')
						},

						success:function(data){
							//alert(data)
							$("#resultados_buscar").empty();
							var objeto = JSON.parse(data);

							objeto.forEach(function(elemento,indice){
								$("#resultados_buscar").append("\
									<tr>\
										<td>"+elemento['id']+"</td>\
										<td>"+elemento['nombre']+"</td>\
										<td>"+elemento['cuenta']+"</td>\
										<td>"+elemento['clave']+"</td>\
										<td>"+elemento['servidor_smtp']+"</td>\
										<td>\
											<div class='row'>\
												<button onclick=editar(this,"+elemento['id']+") class='col w3-button w3-green'><i class='fa fa-check-square' aria-hidden='true'></i>\
												</button>\
												<button onclick=eliminar("+elemento['id']+") class='col w3-button w3-red'><i class='fa fa-window-close-o' aria-hidden='true'></i>\
												</button>\
											</div>\
										</td>\
									</tr>\
									");
							})
						}
				});
			}
			function eliminar(id) {
				if (confirm("¿Desea eliminar?")) {
					$.ajax({
						url:"procesar.php",
						data:{"operacion":"eliminar",id:id},
						type:"post",
						datatype:"json",
						beforeSend:function(){
							
						},

						success:function(data){
							alert(data)
							buscar()
							
						}
					});
				}
			}
			function guardar() {
				if ($("#remitente").val()=="" ||
					$("#cuenta").val()=="" ||
					$("#clave").val()=="" ||
					$("#servidor").val()=="") {
					alert("Campos vacíos!")
				}else{
					$.ajax({
							url:"procesar.php",
							data:{
								"operacion":"agregar",
								"remitente":$("#remitente").val(),
								"cuenta":$("#cuenta").val(),
								"clave":$("#clave").val(),
								"servidor":$("#servidor").val()
							},
							type:"post",
							datatype:"json",
							beforeSend:function(){
								
							},

							success:function(data){
								var obj = JSON.parse(data);
								if (obj['estado']=="exito") {
									alert("Guardado!");
									buscar()
									
								}else{
									alert(obj['estado']);
								}
								
							}
					});
				}
			}

			function editar(this_all,id) {
				var tr = $(this_all).parents("tr")

				$("#remitente").val(tr.find("td:eq(1)").html())
				$("#cuenta").val(tr.find("td:eq(2)").html())
				$("#clave").val(tr.find("td:eq(3)").html())
				$("#servidor").val(tr.find("td:eq(4)").html())

				$("#buttons")
				.empty()
				.append("\
					<div class='row'>\
						<button onclick=editar_send("+id+") class='col w3-button w3-green'>Actualizar\
						</button>\
						<button onclick=reponer() class='col w3-button w3-red'>\
							Cancelar\
						</button>\
					<div>\
					")

			}
			function editar_send(id) {
				$.ajax({
						url:"procesar.php",
						data:{
							"operacion":"actualizar_datos",
							"remitente":$("#remitente").val(),
							"cuenta":$("#cuenta").val(),
							"clave":$("#clave").val(),
							"servidor":$("#servidor").val(),
							"id_user":id
						},
						type:"post",
						datatype:"json",
						beforeSend:function(){
							
						},

						success:function(data){
							var obj = JSON.parse(data);
							if (obj['estado']=="exito") {
								alert("Actualizado!");
								buscar()
								reponer()
							}else{
								alert(obj['estado']);
							}
							
						}
				});
			}
			function reponer() {
				$("#buttons").empty()
				$("#buttons").append("<button class='w3-button w3-teal' onclick=guardar()>Guardar</button>")
				$("#remitente").val("")
				$("#cuenta").val("")
				$("#clave").val("")
				$("#servidor").val("")
			}
		</script>
		<style type="text/css">
			@font-face {
			  font-family: 'Open Sans';
			  font-style: italic;
			  font-weight: 400;
			  src: url(../../fonts/OpenSans-Light.ttf);
			}
			html,body{
				font-family: 'Open Sans', sans-serif;
				font-size:25px;
			}
		</style>
</head>						
<body>
	
	<div class="container-fluid">
		<header class="w3-margin">
			<center>
				<h1>Configurar <strong>Email</strong></h1>
			</center>
		</header>
		<div class="form-group row">
		  <label for="remitente" class="col-2 col-form-label">Remitente</label>
		  <div class="col-10">
		    <input class="form-control" type="text" id="remitente" placeholder="Ejemplo: UPTAAPC">
		  </div>
		</div>
		<div class="form-group row">
		  <label for="cuenta" class="col-2 col-form-label">Correo Electrónico</label>
		  <div class="col-10">
		    <input class="form-control" type="text" placeholder="Ejemplo: ejemplo@gmail.com" id="cuenta">
		  </div>
		</div>
		<div class="form-group row">
		  <label for="clave" class="col-2 col-form-label">Clave</label>
		  <div class="col-10">
		    <input class="form-control" type="text" id="clave">
		  </div>
		</div>
		<div class="form-group row">
		  <label for="servidor" class="col-2 col-form-label">Servidor SMTP</label>
		  <div class="col-10">
		    <input class="form-control" type="text" id="servidor" placeholder="Ejemplo: smtp.gmail.com">
		  </div>
		</div>
		<div class="form-group row">
		  <div class="col-3" id="buttons">
		    <button class="w3-button w3-teal" onclick="guardar()">Guardar</button>
		  </div>
		</div>

		<div class="form-group row">
			<table class="table table-bordered">
				<thead class="thead-inverse">
					<tr>
						<th>Id</th>
						<th>Remitente</th>
						<th>Correo electrónico</th>
						<th>Clave</th>
						<th>Servidor SMTP</th>
						<th>Operaciones</th>
					</tr>
				</thead>
				<tbody id="resultados_buscar">
					
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
