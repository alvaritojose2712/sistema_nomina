<?php 
	session_start();
	include '../conexion_bd.php'; 
	$valores = (new sql("valores_globales","WHERE id='1'"))->select()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>.:: Partidas presupuestarias ::.</title>

	<link rel="stylesheet" type="text/css" href="../css/w3.css">
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="../js/formato_moneda.js"></script>
	<script type="text/javascript" src="../js/param_url.js"></script>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script src="../js/jquery-ui/jquery-ui.js"></script>
	<script type="text/javascript" src="../js/jquery.cookie.js"></script>
 		<link rel="stylesheet" type="text/css" href="../css/loaders.css/loaders.css">
		<script src="../css/loaders.css/loaders.css.js"></script>
 		<script src="../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../css/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		var disponibles = { 
				"estado" : <?php echo $valores['estado']; ?>,
				"genero" : {0:'Masculino',1:'Femenino'},
				"estatus" : <?php echo $valores['estatus']; ?>,
				"grado_instruccion" : <?php echo $valores['grado_instruccion']; ?>,
				"categoria" : 
					<?php
						$cat = json_decode($valores['cat_car_dedic']); 
						$arr = array();
						foreach ($cat as $key => $value) {
							array_push($arr, $key);
						}
						echo json_encode($arr);
					?>	
				,
				"dedicacion" : 
					<?php
						$cat = json_decode($valores['cat_car_dedic']); 
						$arr = array();
						foreach ($cat as $cat => $car_dedic) {
							foreach ($car_dedic as $car_dedic_key => $sub_arr_final) {
								if ($car_dedic_key=="dedicacion") {
									foreach ($sub_arr_final as $key => $value) {
										if (in_array($value, $arr)==false) {
											array_push($arr, $value);
										}
									}
								}
							}
						}
						echo json_encode($arr);
					?>	
				,
				"caja_ahorro" : {0:'si',1:'no'},
				"cargo" : 
					<?php
						$cat = json_decode($valores['cat_car_dedic']); 
						$arr = array();
						foreach ($cat as $cat => $car_dedic) {
							foreach ($car_dedic as $car_dedic_key => $sub_arr_final) {
								if ($car_dedic_key=="cargo") {
									foreach ($sub_arr_final as $key => $value) {
										if (in_array($value, $arr)==false) {
											array_push($arr, $value);
										}
									}
								}
							}
						}
						echo json_encode($arr);
					?>	
				};
		var json_partidas_disponibles = {}
		var json_prueba = {}
		$(document).on("keypress",".input_partidas",function (e) {
			tecla=(document.all) ? e.keyCode: e.which;
			if (tecla == 8) return true;
			patron =/[0-9]/;
			te=String.fromCharCode(tecla);
			return patron.test(te);
		})
		$(document).ready(f_disponibles)
		$(document).on("click",".select_formula",function () {
			if ($(".select_"+$(this).find(".id_formula").text()).length==0) {
				var id = $(this).find(".id_formula").text()
				var des = $(this).find(".descripcion_formula").text()
				
				$(".list_agregados_formulas").append('<div class="btn-group w3-margin-bottom select_'+id+'" style="width: 100%">\
		  						<button type="button" style="width: 80%" class="btn btn-secondary button_formula_add">'+des+' <span class="id_formula_ready">'+id+'</span></button>\
		  						<button type="button" style="width: 20%" onclick="$(this).parent(\'.btn-group\').remove()" class="btn btn-warning button_formula_add"><i class="fa fa-close"></i></button>\
		  					</div>')
			}
		})
		$(document).on("click",".agregar-card-condicion",function () {
			$('.contenedor-agregar-condicion').toggle('display')
			$(".list_entidad").empty()
			for(i in disponibles){
				turn = ($(".campo-condicionado:contains('"+i+"')").parents(".card-condicion").length==1)?"w3-blue":""
				$(".list_entidad").append("<li class='li_campo "+turn+"'>"+i+"</li>")
			}
			$(".nombre_entidad").text("Nombre de la Entidad")
		})
		$(document).on("click",".cerrar-card-condicion",function () {
			$(this).parent(".card-condicion").remove()
		})
		$(document).on("click",".li_campo",function () {
			$(this).toggleClass("w3-blue")
			if (c_existencia(".campo-condicionado",$(this).text())) {
				$(".campo-condicionado:contains('"+$(this).text()+"')").parents(".card-condicion").remove()
			}else{
				$('.contenedor-card-condiciones').append('\
				<div class="col-md-5 w3-margin w3-padding-16 card bg-warning text-white card-condicion">\
					<i class="w3-display-topright btn btn-warning cerrar-card-condicion fa fa-close"></i>\
					<div><span class="h2 campo-condicionado">'+$(this).text()+'</span> <i class="fa fa-plus add-valor-condicion"></i></div><hr>\
					<div class="">\
						<ul class="grupo-condiciones-especificas w3-ul">\
						</ul>\
					</div>\
				</div>')
			}
		})

		$(document).on("click",".add-valor-condicion",function () {
			$('.contenedor-agregar-condicion').toggle('display')
			$(".list_entidad").empty()
			var val = $(this).parent().find('.campo-condicionado').text()
			
			for(i in disponibles[val]){
				turn = ($(".card-condicion").find(".campo-especifico:contains('"+disponibles[val][i]+"')").length==1)?"w3-blue":""
				$(".list_entidad").append("<li class='li_campo_especifico "+turn+"'>"+disponibles[val][i]+"</li>")
			}
			$(".nombre_entidad").text(val)
		})
		$(document).on("click",".li_campo_especifico",function () {
			$(this).toggleClass("w3-blue")
			var v = $(".nombre_entidad").text()
			if (c_existencia(".campo-especifico",$(this).text())) {
				$(".campo-especifico:contains('"+$(this).text()+"')").remove()
			}else{
				$(".campo-condicionado:contains('"+v+"')").parents(".card-condicion").find('.grupo-condiciones-especificas').append('\
				<li class="campo-especifico">'+$(this).text()+'</li>')
			}
		})
		$(document).on("keyup",".input_partidas",function () {
			var index = $(this).index()+1

			for(var e = index; e<=4; e++){
				$($(".input_partidas")[e]).val("")
			}
			 index = $(this).index()-1
			for(var e = index; e>=0; e--){
				if($($(".input_partidas")[e]).val()==""){
					$(this).val("")
				}
			}
		})
		$(document).on("click",".guardar_partida",function () {
			if($(".input_partidas")[0].value!="" && $("#nombre_partida").val()!=""){
				try{
					var arr = $(".input_partidas").toArray()
					var string = ""
					for(i in arr){
						if ($($(".input_partidas")[i]).val()!="") {
							string+="['"+$($(".input_partidas")[i]).val()+"']['hijos']"
						}
					}
					string = string.slice(0,-9)
					
						var json = eval("json_partidas_disponibles"+string)
						json = {
							nombre: $("#nombre_partida").val(),
							condiciones: function () {

							},
							conceptos: function () {
								
							},
							hijos: new Object()
						}
						alert(JSON.stringify(obj))
				}catch(err){
					alert("Error: Partida padre no se ha creado. "+err)
				}				
			}else{
				alert("Error: Campos vacíos");
			}
		})
		$(document).ready(ver_partidas_registradas)
		function f_disponibles(){
		   	$.ajax({
		        url:"../operaciones_parametros_nomina/proceso.php",
		        data:{
					accion:'f_disponibles'
					
		   		},
		        type:"post",
		        async:false, 
		        datatype:"json",
		        beforeSend:function () {
		        	$(".datos-f-disponibles").append("<i class='fa fa-pulse fa-3x fa-spinner w3-display-middle'></i>")
		        },
		        success:function(response)
		        {	//alert(response)
		        	var incluido = "";
		        	var obj = JSON.parse(response)
		        	$(".datos-f-disponibles").empty()
		        	var temple = ''

		        	obj.map(function (element,i) {
		        		if(incluido.indexOf(element.tipo_concepto)==-1){
		        				temple+='<tr>'
		        					temple+='<td colspan="3" class="bg-secundary text-warning"><h3>'+element.tipo_concepto+'</h3></td>'
		        				temple+='</tr>'
		        				incluido = element.tipo_concepto
		        		}
		        		

		        	 
		        			temple+='<tr class="select_formula">'
			        			temple+='<td><span class="id_formula">'+ element.id +'</span></td>'
			        			temple+='<td><span class="descripcion_formula">'+ element.descripcion +'</span></td>'
			        			
			        			temple+='<td>'+ element.fecha +'</td>'
			        		temple+='</tr>'        			        		
		        	})
		   			$(".datos-f-disponibles").append(temple)
				}		  
		    })
		} 
		function c_existencia(clase,buscar) {
			var arr = $(clase).toArray()
			var validar = false
			for(i in arr){
				if($(arr[i]).text()==buscar){
					validar =  true
					break;
				}
			}
			return validar
		}
		function ver_partidas_registradas() {
			$.ajax({
				url: "leer_partida.php",
				type: "post",
				data: {},
				beforeSend: function () {
					
				},
				success: function (res) {
					json_partidas_disponibles = JSON.parse(res)	

					var html_partida = '<table class="table table-hover table-bordered">\
													<thead>\
														<tr>\
															<th>Código</th>\
															<th>Denominación</th>\
														</tr>\
													</thead>\
													<tbody>'
														
							var obj_global = json_partidas_disponibles			
							for(i in obj_global){
								html_partida += '<tr class="font-weight-bold">\
													<td>\
														'+i+".00"+".00"+".00"+".00"+'\
													</td>\
													<td>\
														'+obj_global[i]['nombre']+'\
													</td>\
												</tr>'
								if (obj_global[i]['hijos']!=undefined) {
									var obj_partida = obj_global[i]['hijos']
									for(ii in obj_partida){
										html_partida += '<tr class="font-weight-bold">\
													<td>\
														'+i+"."+ii+".00"+".00"+".00"+'\
													</td>\
													<td>\
														'+obj_partida[ii]['nombre']+'\
													</td>\
												</tr>'
										if (obj_partida[ii]['hijos']!=undefined) {
											var obj_generico = obj_partida[ii]['hijos']
											for(iii in obj_generico){
												html_partida += '<tr class="text-primary">\
															<td>\
																'+i+"."+ii+"."+iii+".00"+".00"+'\
															</td>\
															<td>\
																'+obj_generico[iii]['nombre']+'\
															</td>\
														</tr>'
												if (obj_generico[iii]['hijos']!=undefined) {
													var obj_especifico = obj_generico[iii]['hijos']
													for(iiii in obj_especifico){
														html_partida += '<tr class="">\
																	<td>\
																		'+i+"."+ii+"."+iii+"."+iiii+".00"+'\
																	</td>\
																	<td>\
																		'+obj_especifico[iiii]['nombre']+'\
																	</td>\
																</tr>'
														if (obj_especifico[iiii]['hijos']!=undefined) {
															var obj_sub_especifico = obj_especifico[iiii]['hijos']
															for(iiiii in obj_sub_especifico){
																html_partida += '<tr class="">\
																			<td>\
																				'+i+"."+ii+"."+iii+"."+iiii+"."+iiiii+'\
																			</td>\
																			<td>\
																				'+obj_sub_especifico[iiiii]['nombre']+'\
																			</td>\
																		</tr>'
															}
														}
													}
												}
											}
										}
									}
								}
							}			

							html_partida += '</tbody></table>'
							$(".resultados_partida_server").empty().append(html_partida)
				}
			})
		}
	</script>
	<style type="text/css">
		@font-face {
		  font-family: 'Roboto';
		  font-style: italic;
		  font-weight: 400;
		 /* src: url(../fonts/OpenSans-Light.ttf);*/
		  src: url(../fonts/Roboto-Light.ttf);
		  
		}
		html,body{
			font-family: 'Roboto', sans-serif;
			height: 100%;
			width: 100%;
			background-color: #f2f2f2

		}	
		.input_partidas{
			border-radius: 15px;
			margin: 10px;
			font-size: 60px;
			border: solid 2px #f0ad4e;
			text-align: center;
			width: 110px;
			outline:0px;
		}
		.card{
			font-size: 30px;
			word-wrap: break-word;
		}
		.cerrar-card-condicion{
			cursor: pointer;
		}
		li:hover{
			color: green;
			font-size: 35px;
			cursor: pointer;
			transition: 0.5s;
		}
		li{
			color: white;
			font-size: 30px;
			cursor: pointer;
			transition: 0.5s;
		}
		i:hover{
			color: green;
			cursor: pointer;
		}
		.contenedor-agregar-condicion{
			display: none;
			width:100%;
			height: 100%;
			z-index: 2100;
			position: fixed;
		}
		tr:hover{
			background-color: white;
			cursor: pointer;
		}
		button{
			cursor: pointer;
		}
	</style>
</head>
<body>
	<div class="contenedor-agregar-condicion w3-display-topmiddle">
		<div class="bg-warning card container w3-card-4 w3-display-middle" style="width: 700px;position: fixed;z-index: 2150">
			<div class="row">
				<button class="fa fa-close btn btn-warning col-2" onclick="$('.contenedor-agregar-condicion').toggle('display')"></button>
				<div class="col">
					<span class="w3-right nombre_entidad text-white"></span>
				</div>
			</div>
			<div class="row">
				<ul class="w3-ul w3-hoverable list_entidad" style="width: 100%">
				  
				</ul>
			</div>
		</div>
		<div style="width:100%;height: 100%;position: fixed;background-color: gray;opacity: 0.5"></div>

	</div>
	<div class="container-fluid" style="height: 100%">
		<div class="row">
			<div class="col" style="height: 100%;overflow-y: auto;">
				<div class="container-fluid">
					<div class="row w3-center">
						<div class="col">
							<span class="h1">Crear partida presupuestaria</span>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<button class="btn btn-success w3-right guardar_partida"><i class="fa fa-save fa-3x"></i></button>
						</div>
					</div>
					<div class="row w3-center w3-margin">
						<div class="col contenedor-inputs-partidas">
							<input class="input_partidas" type="text" maxlength="2">
							<input class="input_partidas" type="text" maxlength="2">
							<input class="input_partidas" type="text" maxlength="2">
							<input class="input_partidas" type="text" maxlength="2">
							<input class="input_partidas" type="text" maxlength="2">
						</div>
					</div>
					<div class="row w3-border w3-margin w3-round-xlarge w3-padding w3-hover-border-orange">
						<div class="col">
							<div class="form-group">
								<label for="nombre_partida" class="h3">Nombre de la partida</label>
								<input type="text" id="nombre_partida" class="form-control" value="Nombre de la partida">
							</div>
						</div>
					</div>
					<div class="w3-border w3-margin w3-round-xlarge w3-padding w3-hover-border-orange">
						<div class="row">
							<div class="col">
								<span class="h1">Condiciones <button class="btn btn-success agregar-card-condicion fa fa-plus"></button></span>
							</div>
						</div>
						<div class="row w3-margin contenedor-card-condiciones">
							
						</div>
					</div>
					<div class="w3-margin">
						<div class="row">
							<div class="col">
								<span class="h1">Asociar conceptos</span>
							</div>
						</div>
						<div class="row">
							<div class="col w3-margin w3-round-xlarge w3-panel w3-border w3-border-orange contenedor_agregados">
					  			<div style="width: 100%;height: 400px;overflow-y: auto;">
					  				<div class="w3-center w3-padding w3-margin-bottom w3-border-bottom">
					  					<span class="h5">
					  						Agregados
					  					</span>
					  				</div>
					  				
									<div class="list_agregados_formulas" style="width: 100%"></div>
					  			</div>
					  		</div>
					  		<div class="col w3-margin w3-round-xlarge w3-panel w3-border w3-hover-border-orange">
					  			<div style="width: 100%;height: 400px;overflow-y: auto;">
					  				<input type="text" class="w3-margin-bottom w3-margin-top form-control solicitar_personal_incl_excl" placeholder="Busqueda...">
					  				<table class="table">
					  					<thead>
					  						<tr class="bg-warning text-white">
					  							<th>Id</th>
					  							<th>Descripción</th>
					  							<th>Fecha</th>
					  						</tr>
					  					</thead>
					  					<tbody class="datos-f-disponibles"></tbody>
					  				</table>
					  			</div>
					  		</div>
						</div>
					</div>	
				</div>
			</div>
			<div class="col-4" style="height: 100%;overflow-y: auto;">
				<div class="container-fluid">
					<div class="row w3-center">
						<div class="col">
							<span class="h1">Creadas</span>
						</div>
					</div>
					<div class="row w3-center">
						<div class="col resultados_partida_server">
							<span class="font-italic">Sin resultados</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>