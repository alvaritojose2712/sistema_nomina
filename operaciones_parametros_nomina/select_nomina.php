<?php include '../conexion_bd.php'; ?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<link rel="stylesheet" type="text/css" href="../css/w3.css">
		<link rel="stylesheet" type="text/css" href="../css/font.css">
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
		<script type="text/javascript" src="../js/formato_moneda.js"></script>
		<script type="text/javascript" src="../js/param_url.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/jquery.cookie.js"></script>
	  	<script src="../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../css/bootstrap/dist/js/bootstrap.min.js"></script>
		<title> Seleccionar nómina</title>
		<script type="text/javascript">
			function buscar_nomina() {
				const place = $(".cards_nominas")
				$.ajax({
					url: 'search_nomina.php',
					type: 'POST',
					beforeSend: function() {
						place.append("<div class='cargando w3-center'><i class='fa fa-pulse fa-spinner fa-3x'></i></div>")
					},
					data: {"operacion": "buscar","buscar": $("#input_buscar").val()},
					success: function(res) {
						$(".cargando").remove()
						place.empty()
						let obj = JSON.parse(res)
						let divisiones = function(arr) {
							let d = ""
							for(e in arr){
								d += "<li>"+arr[e]+"</li>"
							}
							return d
						}
							for(i in obj){
								
								var html = '\
								<div class="alert alert-info cont_nomina w3-card-2">\
									<div class="container-fluid">\
										<div class="row w3-section">\
											<div class="col">\
												<div class="btn-group w3-right">\
													<a href="index.php?id='+i+'"<button class="btn btn-outline-success mod_edit"><i class="fa fa-edit"></i></button></a>\
													<button class="btn btn-outline-danger delete_nomina" title="'+i+'"><i class="fa fa-trash"></i></button>\
												</div>	\
											</div>\
										</div>\
										<div class="row">\
											<div class="col-5">\
												<div class="row">\
													<div class="col">\
														<h2><b class="">'+obj[i].denominacion+'</b></h2>\
													</div>\
												</div>\
												<div class="row">\
													<div class="col">\
														<h5 class="">'+obj[i].tipo_periodo+'</h5>\
													</div>\
												</div>\
												<div class="row">\
													<div class="col">\
														<a href="../'+obj[i].motor+'?id='+i+'&denominacion='+obj[i].denominacion+'"><button class="btn btn-info"><i class="fa fa-cog fa-3x"></i></button></a>\
													</div>\
												</div>\
											</div>\
											<div class="col">\
												<table class="table table-bordered">\
													<tr>\
														<th>Fecha de Creación</th>\
														<td class="">'+obj[i].fecha+'</td>\
													</tr>\
													<tr>\
														<th>Divisiones</th>\
														<td class=""><ul class="">'+divisiones(Object.keys(JSON.parse(obj[i].divisiones)))+'</ul></td>\
													</tr>\
													<tr>\
														<th>Nº de Fórmulas Asociadas</th>\
														<td class="">'+Object.keys(JSON.parse(obj[i].formulas)).length+'</td>\
													</tr>\
												</table>\
											</div>\
										</div>\
									</div>\
								</div>'

								place.append(html)
							}
						
					}
				})	
			}
			$(document).ready(buscar_nomina)
			$(document).on("keyup","#input_buscar",buscar_nomina)
			$(document).on("click",".delete_nomina",function() {
				let id = $(this).attr("title")
				if (window.confirm("¿Desea realmente eliminar la nómina " + id + "?")) {
					
					$.ajax({
						url:'borrar_nomina.php',
						type:"post",
						data:{
							id: id
						},
						success:function(data){
							alert(data);
							buscar_nomina()
						}
					});
				}
			})
		</script>
		<style type="text/css">
			@font-face {
			  font-family: 'Open Sans';
			  font-weight: 400;
			  src: url(../fonts/OpenSans-Light.ttf);
			}
			html,body{
				font-family: 'Open Sans', sans-serif;
				font-size: 20px;
				height: 100%;
				width: 100%;
				background-color:#f2f2f2;
			}
			.cont_nomina{
				transition: 0.2s
			}
			.cont_nomina:hover{
				transform: scale(1.020);
				transition: 0.2s
			}
			button{
				cursor: pointer;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col w3-center">
					<span class="h1 w3-section">Seleccionar Nómina</span>	
				</div>
			</div>
			<div class="row w3-section">
				<div class="col">
					<input placeholder="Buscar..." id="input_buscar" type="text" class="form-control">
				</div>
			</div>	
			<div class="row w3-section">
				<div class="col w3-center">
					<a href="index.php"><button class="btn btn-outline-success">Crear Nueva</button></a>
				</div>
			</div>
			<div class="row">
				<div class="col cards_nominas">
				
				</div>
			</div>
		</div>
	
	</body>
	</html>