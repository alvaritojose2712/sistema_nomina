<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title> .: Unidad tributaria:.</title>
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
				$("#buscar").keyup(buscar);

				$("#add").click(function() {
					$("#resultados_buscar").append("\
						<tr>\
							<td>\
							</td>\
							<td>\
								<input type='date' class='fecha_inicio_vigencia_nuevo' maxlength='30' placeholder='Inicio de vigencia'/>\
							</td>\
							<td>\
								<input type='date' class='fecha_decreto_nuevo' maxlength='30' placeholder='Fecha del decreto'/>\
							</td>\
							<td>\
								<input type='text' class='gaceta_oficial_nuevo' maxlength='30' placeholder='Gaceta oficial'/>\
							</td>\
							<td>\
								<input type='text' class='valor_nuevo' onKeyPress='return numeros(event)' maxlength='11' placeholder='Valor Bs.'/>\
							</td>\
							<td>\
								<div class='row'>\
									<button onclick=guardar(this) class='col w3-button w3-green'><i class='fa fa-check-square' aria-hidden='true'></i>\
									</button>\
									<button onclick=$(this).parents('tr').remove() class='col w3-button w3-red'><i class='fa fa-window-close-o' aria-hidden='true'></i>\
									</button>\
								</div>\
							</td>\
						</tr>");
				});
			});
			function buscar() {
				$.ajax({
						url:"procesar.php",
						data:{buscar:$("#buscar").val(),"operacion":"buscar"},
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
										<div class='usuario'>\
											<td>\
												<input style='border-width: 0px;pointer-events:none;' type='text' value='"+elemento['id']+"' />\
											</td>\
											<td>\
												<input type='date' class='inactive fecha_inicio_vigencia_input' value='"+elemento['fecha_inicio_vigencia']+"' />\
											</td>\
											<td>\
												<input type='date' class='inactive fecha_decreto_input' value='"+elemento['fecha_decreto']+"' />\
											</td>\
											<td>\
												<input type='text' class='inactive gaceta_oficial_input' value='"+elemento['gaceta_oficial']+"' />\
											</td>\
											<td>\
												<input type='text' class='inactive valor_input' onKeyPress='return numeros(event)' maxlength='11' value='"+elemento['valor']+"' />\
											</td>\
											<td>\
												<div class='row'>\
													<button onclick=editar(this,'"+elemento['id']+"') class='col w3-button '>\
														<i class='fa fa-cog' aria-hidden='true'></i>\
													</button>\
													<button onclick=eliminar('"+elemento['id']+"') class='col w3-button w3-red'>\
														<i class='fa fa-window-close-o' aria-hidden='true'></i>\
													</button>\
												</div>\
											</td>\
										</div>\
									</tr>");
								});
							}
				});
			}
			function guardar(this_all) {
				var json_valores = {};
				var array = $(this_all).parents('tr').find('input').toArray();
				var verificar = true;
				for(i in array){
					if ($(array[i]).val()!="") {
						json_valores[$(array[i]).attr('class')]=$(array[i]).val();	
					}else{
						alert("Campo inválido: "+$(array[i]).attr('class').replace('_nuevo',""));
						verificar = false;
						break
					}
				}
				if (verificar) {
					json_valores['operacion']='agregar';
					$.ajax({
							url:"procesar.php",
							data:json_valores,
							type:"post",
							datatype:"json",
							success:function(data){
								var obj = JSON.parse(data);
								if (obj['estado']=="exito") {
									alert("Agregado!");
									if (confirm("¿Desea actualizar?")) {
										buscar();
									}

								}else{
									alert(obj['estado']);
								}
							}
					});
				}
			}
			function eliminar(id){
				var confirm = window.confirm("¿Realmente desea eliminar el usuario "+id+" ?");
				if (confirm) {
					$.ajax({
						url:"procesar.php",
						data:{"id":id,"operacion":"eliminar"},
						type:"post",
						success:function(data){
							alert(data);
							buscar();
						}
					});
				}
			}
			function editar(this_all,id) {
				
				$(this_all).parents('tr').find('td:eq(5) div').css({'display':'none'});
				var id_user = "$(this).parents('tr').find('td:eq(0)').find('input').val()"
				$(this_all).parents('tr').find('td:eq(5)').append("\
					<div class='row'><button onclick=actualizar_datos("+id_user+",this) class='col w3-button w3-green'><i class='fa fa-check-square' aria-hidden='true'></i>\
					</button>\
					<button onclick=reponer(this,"+id_user+"); class='col w3-button w3-red'><i class='fa fa-ban' aria-hidden='true'></i>\
					</button></div>");

				$(this_all).parents('tr').find('input').removeClass('inactive');	
			}
			function actualizar_datos(id_user,this_all) {
					var i = $(this_all).parents('tr')
					 ,fecha_inicio_vigencia = i.find('.fecha_inicio_vigencia_input').val()
					 ,fecha_decreto = i.find('.fecha_decreto_input').val()
					 ,gaceta_oficial = i.find('.gaceta_oficial_input').val()
					 ,valor = i.find('.valor_input').val()			
					
					$.ajax({
						url:"procesar.php",
						data:{
							"id_user":id_user,
							"operacion":"actualizar_datos",
							'fecha_inicio_vigencia':fecha_inicio_vigencia,
							'fecha_decreto':fecha_decreto,
							'gaceta_oficial':gaceta_oficial,
							'valor':valor
						},
						type:"post",
						datatype:"json",
						success:function(data){
							
							var obj = JSON.parse(data);
							if (obj['estado']=="exito") {
								alert("Actualizado!");
								$(this_all).parent().siblings('div').css({'display':''});
								$(this_all).parents('tr').find('input').addClass('inactive');
								$(this_all).parent().remove();
							}else{
								alert(obj['estado']);
							}
						}
					});
			}
			function reponer(this_all,id_user){
				$.ajax({
						url:"procesar.php",
						data:{
							"id_user":id_user,
							"operacion":"reponer"
						},
						type:"post",
						datatype:"json",
						success:function(data){
							
							var obj = JSON.parse(data);
								
							var tr = $(this_all).parents('tr')
							tr.before("<tr>\
								<div class='usuario'>\
									<td>\
										<input style='border-width: 0px;pointer-events:none;' type='text' value='"+obj['id']+"' />\
									</td>\
									<td>\
										<input type='date' class='inactive fecha_inicio_vigencia_input' value='"+obj['fecha_inicio_vigencia']+"' />\
									</td>\
									<td>\
										<input type='date' class='inactive fecha_decreto_input' value='"+obj['fecha_decreto']+"' />\
									</td>\
									<td>\
										<input type='text' class='inactive gaceta_oficial_input' value='"+obj['gaceta_oficial']+"' />\
									</td>\
									<td>\
										<input type='text' class='inactive valor_input'  value='"+obj['valor']+"' />\
									</td>\
									<td>\
										<div class='row'>\
											<button onclick=editar(this,'"+obj['id']+"') class='col w3-button '>\
												<i class='fa fa-cog' aria-hidden='true'></i>\
											</button>\
											<button onclick=eliminar('"+obj['id']+"') class='col w3-button w3-red'>\
												<i class='fa fa-window-close-o' aria-hidden='true'></i>\
											</button>\
										</div>\
									</td>\
								</div></tr>");
							tr.remove()
							
							
						}
				});
			}
			function numeros(e){
				tecla=(document.all) ? e.keyCode: e.which;
				if (tecla == 8) return true;
				patron =/[0-9]/;
				te=String.fromCharCode(tecla);
				return patron.test(te);
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
				font-size: 20px;
				zoom: 0.90;
				height: 100%;
				width: 100%;
			}
			.inactive{
				border-width: 0px;
				pointer-events:none;
			}
			input{
				width:70%;
			}
		</style>
</head>
<body>
	<div class="w3-container" style=";overflow-x: auto">
		<center><header class="header w3-header"><h1>Configurar unidad tributaria</h1></header></center>

        <input type="text" class="w3-input w3-animate-input" placeholder="Buscar..." id="buscar">
        
        <center>
        	<button class="w3-button w3-green" style="margin-top:20px;margin-bottom: 20px" id="add">
        		Agregar nueva
        	</button>
        </center>
        
		<table class='table-bordered table'>
			<thead>
				<tr>
					<th>Id</th>
					<th>Inicio de vigencia</th>
					<th>Fecha del decreto</th>
					<th>Gaceta oficial</th>
					<th>Valor Bs.</th>
					<th>Operaciones</th>
				</tr>
			</thead>
			<tbody id="resultados_buscar">
			</tbody>
		</table>
	</div>							
</body>
</html>
