<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>.: Administrar Instituciones :.</title>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery.cookie.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/w3.css">
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
	<script src="../css/bootstrap/dist/js/tether.min.js"></script>
	<link rel="stylesheet" href="../css/bootstrap/dist/css/bootstrap.min.css">
	<script src="../css/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		
		function buscar() {
			const place = $(".cards_instituciones")
			$.ajax({
				url: 'procesar.php',
				type: 'POST',
				beforeSend: function() {
					place.append("<div class='cargando w3-center'><i class='fa fa-pulse fa-spinner fa-3x'></i></div>")
				},
				data: {"operacion": "buscar","buscar": $("#input_buscar").val()},
				success: function(res) {
					$(".cargando").remove()
					place.empty()
					let obj = JSON.parse(res)

						for(i in obj){
							var html = '\
							<div class="alert alert-info cont_institucion">\
								<div class="container-fluid">\
									<div class="row">\
										<div class="col">\
											<div class="btn-group w3-right">\
												<button class="btn btn-outline-success mod_edit"><i class="fa fa-edit"></i></button>\
												<button class="btn btn-outline-danger delete_institucion"><i class="fa fa-trash"></i></button>\
											</div>	\
										</div>\
									</div>\
									<div class="row">\
										<div class="col-5">\
											<div class="row">\
												<div class="col">\
													<h2><b class="denominacion_data">'+obj[i].denominacion+'</b></h2>\
												</div>\
											</div>\
											<div class="row">\
												<div class="col">\
													<h5 class="organo_adscripcion_data">'+obj[i].organo_adscripcion+'</h5>\
												</div>\
											</div>\
										</div>\
										<div class="col">\
											<table class="table">\
												<tr>\
													<th>Código Presupuestario</th>\
													<td class="codigo_presupuestario_data">'+obj[i].codigo_presupuestario+'</td>\
												</tr>\
												<tr>\
													<th>Código Bancario</th>\
													<td class="codigo_institucion_data">'+obj[i].codigo_institucion+'</td>\
												</tr>\
												<tr>\
													<th>Cuenta Bancaria</th>\
													<td class="cuenta_matriz_data">'+obj[i].cuenta_matriz+'</td>\
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
		function validar_num(e){
			tecla=(document.all) ? e.keyCode: e.which;
			if (tecla == 8) return true;
			patron =/[0-9]/;
			te=String.fromCharCode(tecla);
			return patron.test(te);
		}
		$(document).ready(buscar)
		$(document).on("keyup","#input_buscar",buscar)
		$(document).on("click",".mod_edit",function() {
			$("#modal_edit_institucion").modal()
			
			const p = $(this).parents(".cont_institucion")
			let clave = p.find(".denominacion_data").text()
			
			$(".denominacion_edit_val").val(clave)
			$(".organo_adscripcion_edit_val").val(p.find(".organo_adscripcion_data").text())
			$(".codigo_presupuestario_edit_val").val(p.find(".codigo_presupuestario_data").text())
			$(".codigo_institucion_edit_val").val(p.find(".codigo_institucion_data").text())
			$(".cuenta_matriz_edit_val").val(p.find(".cuenta_matriz_data").text())

			$(".edit_to").text(clave)
		})
		$(document).on("click",".actualizar_datos_instituciones",function() {
			$.ajax({
				url: 'procesar.php',
				type: 'POST',
				beforeSend: function() {
					$(".edit_to").parent().append("<div class='cargando w3-center'><i class='fa fa-pulse fa-spinner fa-3x'></i></div>")
				},
				data: {
					operacion: "actualizar_datos",
					clave: $(".edit_to").text(),
					denominacion_edit_val: $(".denominacion_edit_val").val(),
					organo_adscripcion_edit_val: $(".organo_adscripcion_edit_val").val(),
					codigo_presupuestario_edit_val: $(".codigo_presupuestario_edit_val").val(),
					codigo_institucion_edit_val: $(".codigo_institucion_edit_val").val(),
					cuenta_matriz_edit_val: $(".cuenta_matriz_edit_val").val()
				},
				success: function(res) {
					$(".cargando").remove()
					try{
						var obj = JSON.parse(res)
						if (obj.estado=="exito") {
							alert("Exito al actualizar!")
							$(".edit_to").text($(".denominacion_edit_val").val())
							// if ($.cookie('denominacion_institucion')==$(".edit_to").text()) {
							// 	window.location = "../log_out.php";
							// }
						}
					}catch(err){
						alert(res)
					}

				}
			})
		})
		$(document).on("click",".delete_institucion",function() {
			const p = $(this).parents(".cont_institucion")
			let clave = p.find(".denominacion_data").text()
			$.ajax({
				url: 'procesar.php',
				type: 'POST',
				beforeSend: function() {
					$(".cards_instituciones").append("<div class='cargando w3-center'><i class='fa fa-pulse fa-spinner fa-3x'></i></div>")
				},
				data: {
					operacion: "eliminar",
					clave: clave
				},
				success: function(res) {
					$(".cargando").remove()
					
					alert(res)
					buscar()

				}
			})
		})
		$(document).on("click",".insertar_institucion",function() {
			$.ajax({
				url: 'procesar.php',
				type: 'POST',
				beforeSend: function() {
					$("#modal_add_institucion").parent().append("<div class='cargando w3-center'><i class='fa fa-pulse fa-spinner fa-3x'></i></div>")
				},
				data: {
					operacion: "agregar",
					denominacion: $(".denominacion_add_val").val(),
					organo_adscripcion: $(".organo_adscripcion_add_val").val(),
					codigo_presupuestario: $(".codigo_presupuestario_add_val").val(),
					codigo_institucion: $(".codigo_institucion_add_val").val(),
					cuenta_matriz: $(".cuenta_matriz_add_val").val()
				},
				success: function(res) {
					$(".cargando").remove()
					try{
						var obj = JSON.parse(res)
						if (obj.estado=="exito") {
							alert("Exito al Registrar!")
							buscar()
						}
					}catch(err){
						alert(res)
					}

				}
			})
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
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col w3-center">
				<span class="h1 w3-section">Administrar Instituciones</span>	
			</div>
		</div>
		<div class="row w3-section">
			<div class="col">
				<input placeholder="Buscar..." id="input_buscar" type="text" class="form-control">
			</div>
		</div>	
		<div class="row w3-section">
			<div class="col w3-center">
				<button class="btn btn-outline-success" onclick="$('#modal_add_institucion').modal()">Agregar Nueva</button>
			</div>
		</div>
		<div class="row">
			<div class="col cards_instituciones">
			
			</div>
		</div>
	</div>
	<div class="modal" id="modal_edit_institucion">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body constainer-fluid">
					<div class="row w3-section">
						<div class="col">
							<h4>Ediatando a: <span class="edit_to text-primary"></span></h4>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="">Denominación de la Institución</label>
								<input type="text" class="form-control denominacion_edit_val">	
							</div>	
							<div class="form-group">
								<label for="">Órgano de adscripción</label>
								<input type="text" class="form-control organo_adscripcion_edit_val">
							</div>
							<div class="form-group">
								<label for="">Código presupuestario</label>
								<input type="text" class="form-control codigo_presupuestario_edit_val" size="8" >
							</div>
							<div class="form-group">
								<label for="">Código Bancario</label>
								<input type="text" class="form-control codigo_institucion_edit_val" onkeypress="return validar_num(event)">
							</div>
							<div class="form-group">
								<label for="">Cuenta Bancaria</label>
								<input type="text" class="form-control cuenta_matriz_edit_val" maxlength="20" onkeypress="return validar_num(event)">							
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="btn-group w3-right">
								<button class="btn btn-outline-warning actualizar_datos_instituciones">Actualizar</button>
								<button class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="modal_add_institucion">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body constainer-fluid">
					<div class="row w3-section">
						<div class="col">
							<h4 class="text-primary">Agregar Nueva Institución</h4>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="">Denominación de la Institución</label>
								<input type="text" class="form-control denominacion_add_val">	
							</div>	
							<div class="form-group">
								<label for="">Órgano de adscripción</label>
								<input type="text" class="form-control organo_adscripcion_add_val">
							</div>
							<div class="form-group">
								<label for="">Código presupuestario</label>
								<input type="text" class="form-control codigo_presupuestario_add_val" size="8" >
							</div>
							<div class="form-group">
								<label for="">Código Bancario</label>
								<input type="text" class="form-control codigo_institucion_add_val" onkeypress="return validar_num(event)">
							</div>
							<div class="form-group">
								<label for="">Cuenta Bancaria</label>
								<input type="text" class="form-control cuenta_matriz_add_val" maxlength="20" onkeypress="return validar_num(event)">							
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="btn-group w3-right">
								<button class="btn btn-outline-success insertar_institucion">Registrar</button>
								<button class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>