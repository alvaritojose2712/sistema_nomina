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
		$(document).on("click",".campo-especifico",function () {
			$(this).remove()
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
			
			if ($(this).val().length==2) {
				$($(".input_partidas")[index]).focus()
			}

			for(var e = index; e<=4; e++){
				$($(".input_partidas")[e]).val("")
			}
			index = $(this).index()-1
			for(var e = index; e>=0; e--){
				if($($(".input_partidas")[e]).val()==""){
					$(this).val("")
				}
			}

			var arr_dirty = $(".input_partidas").toArray()
			var arr = []
			for(i in arr_dirty){
				if($(arr_dirty[i]).val()!=""){
					arr.push(arr_dirty[i])
				}
			}
			if ($(".input_partidas")[0].value!="") {
				var string = ""
				for(i in arr){
					var val = $(arr[i]).val()
					
					var add = "['"+val+"']['hijos']"
					string += add
					try{
						
						if (arr.length==(Number(i)+1)) {
							string = string.slice(0,-9)
							var json = eval("json_partidas_disponibles"+string)
							json['nombre']
							$("body").animate({"backgroundColor":"#FFE9C1"},250)
							$(".input_partidas").animate({"borderColor":"#AB6F03"},250)
							$(".modo-actual").text("Alerta: Ya existe").animate({"color":"#FF9E21"},250)
						}
					}catch(err){
						try {
							string = string.slice(0,-(4+val.length))
							var json = eval("json_partidas_disponibles"+string)
							$("body").animate({"backgroundColor":"#C1FFD0"},250)
							$(".input_partidas").animate({"borderColor":"#008E22"},250)
							$(".modo-actual").text("Espacio disponible").animate({"color":"#1CFF1C"},250)
							
						}catch(err){
							$("body").animate({"backgroundColor":"#FFC1C4"},250)
							$(".input_partidas").animate({"borderColor":"#9F0008"},250)
							$(".modo-actual").text("No se puede crear").animate({"color":"#FE3434"},250)
						}
					}
				}
			}else{
				$("body").animate({"backgroundColor":"#f2f2f2"},250)
				$(".input_partidas").animate({"borderColor":"#594747"},250)
				$(".modo-actual").animate({"color":"#594747"},250).text("Neutro")
			}

			var str_inp_class = ""
			for(i in arr){
				str_inp_class += $(arr[i]).val()+"_"
			}			
			str_inp_class = str_inp_class.slice(0,-1)
			$(".tr_resul_partidas")
			.removeClass("text-white")
			.removeClass("bg-warning")
			$("."+str_inp_class)
			.addClass("bg-warning")
			.addClass("text-white")
		})
		$(document).on("click",".guardar_partida",function () {
			if($(".input_partidas")[0].value!="" && $("#nombre_partida").val()!=""){

					var arr_dirty = $(".input_partidas").toArray()
					var arr = []
					for(i in arr_dirty){
						if($(arr_dirty[i]).val()!=""){
							arr.push(arr_dirty[i])
						}
					}
					
					var name = $("#nombre_partida").val()
					var condiciones = function () {
						let json = new Object()
						let arr  = $(".card-condicion").toArray()
						for(i in arr){
							let n = $(arr[i]).find(".campo-condicionado").text()
							var s_arr =  $(arr[i]).find(".campo-especifico").toArray()
							if (s_arr.length!=0) {
								json[n] = new Object()
								for(ii in s_arr){
									json[n][$(s_arr[ii]).text()] = ""
								}
							}
						}
						return json  
					}
				    var	conceptos = function () {
						let json = {}
						let arr = $(".id_formula_ready").toArray()
						for(i in arr){
							json[$(arr[i]).text()] = ""
						}
						return json
					}

					var nueva = {
							nombre: name,
							condiciones: condiciones(),
							conceptos: conceptos(),
							hijos: new Object()
					}
					var string = ""

					for(i in arr){
						var val = $(arr[i]).val()
						
						var add = "['"+val+"']['hijos']"
						string += add
						try{
							
							if (arr.length==(Number(i)+1)) {
								string = string.slice(0,-9)
								var json = eval("json_partidas_disponibles"+string)
								json['nombre'] = name 
								json['condiciones'] = condiciones()
								json['conceptos'] = conceptos()
								alert("Renombrado!")
							}
						}catch(err){
							try {
								string = string.slice(0,-(4+val.length))
								var json = eval("json_partidas_disponibles"+string)
								json[val] = nueva
								alert("Agregado!")
								
							}catch(err){
								alert("Error: Partida padre no se ha creado. "+err.messaje)
							}
						}
					}

				cargar_partidas(json_partidas_disponibles)
				registrar_datos(JSON.stringify(json_partidas_disponibles))
				$($(".input_partidas")[4]).keyup()
			}else{
				alert("Error: Campos vacíos");
			}
		})
		$(document).on("click",".borrar_partida",function () {
			if($(".input_partidas")[0].value!=""){

					var arr_dirty = $(".input_partidas").toArray()
					var arr = []
					for(i in arr_dirty){
						if($(arr_dirty[i]).val()!=""){
							arr.push(arr_dirty[i])
						}
					}

					var string = ""

					for(i in arr){
						var val = $(arr[i]).val()
						
						var add = "['"+val+"']['hijos']"
						string += add
						try{
							if (arr.length==(Number(i)+1)) {
								string = string.slice(0,-9)
								
								 if (window.confirm("ALERTA: Es una acción peligrosa!. ¿Realmente desea borrar?.")) {
								 	eval("delete json_partidas_disponibles"+string)
								 }
							}
						}catch(err){
							alert("Error: Partida no encontrada. "+err)
						}
					}

				cargar_partidas(json_partidas_disponibles)

			}else{
				alert("Introduzca una partida!");
			}
		})
		$(document).on("click",".tr_resul_partidas",function () {
			var v = $(this).attr("title")
			var arr = v.split("_")
			var str = ""
			for(i in arr){
				$(".input_partidas")[i].value=arr[i]
				$($(".input_partidas")[i]).keyup()
				str += "['"+arr[i]+"']['hijos']"
			}

			str = str.slice(0,-9)
			var json = eval("json_partidas_disponibles"+str)
			$("#nombre_partida").val(json["nombre"])
			
			var concep = json["conceptos"]
			$(".list_agregados_formulas").empty()
			for(i in concep){
				$(".id_formula").filter(function () {
					if($(this).text()===i){
						$(this).parents(".select_formula").click()
					}
				})
			}
			
			var condi = json["condiciones"]
			$(".contenedor-card-condiciones").empty()
			for(i in condi){
				var html_condi = '<div class="col-md-5 w3-margin w3-padding-16 card bg-warning text-white card-condicion">\
						<i class="w3-display-topright btn btn-warning cerrar-card-condicion fa fa-close"></i>\
					<div>\
						<span class="h2 campo-condicionado">'+i+'</span>\
						<i class="fa fa-plus add-valor-condicion"></i>\
					</div><hr>\
					<div>\
						<ul class="grupo-condiciones-especificas w3-ul">';						
							for(ii in condi[i]){
								html_condi += '<li class="campo-especifico">'+ii+'</li>';			
							}
					html_condi += '</ul>\
						</div>\
					</div>';
				$(".contenedor-card-condiciones").append(html_condi)
			}
			

		})
		$(document).ready(ver_partidas_registradas)
		$(document).on("keyup",".solicitar_personal",function () {
			if ($(this).val()!="") {
				$(".datos-f-disponibles").find('tr').css('display','none')
				$(".datos-f-disponibles").find('td:contains("'+$(this).val()+'")').parents('tr').css('display','')
			}else{
				$(".datos-f-disponibles").find('tr').css('display','')
			}
		})
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
				data: {
					accion:"ver"
				},
				beforeSend: function () {
					
				},
				success: function (res) {
					try {
						json_partidas_disponibles = JSON.parse(res)	

						cargar_partidas(json_partidas_disponibles)
					} catch (error) {
						if (res!="") {
							alert(res)
						}
						
					}
				}
			})
		}
		function cargar_partidas(json_partidas_disponibles) {
			var html_partida = '<table class="table table-hover table-bordered">\
									<thead>\
										<tr>\
											<th></th>\
											<th>Partida</th>\
											<th>Genérica</th>\
											<th>Específica</th>\
											<th>Sub-Específica</th>\
											<th>Denominación</th>\
										</tr>\
									</thead>\
									<tbody>'
														
			var obj_global = json_partidas_disponibles			
			for(i in obj_global){
				html_partida += '<tr title="'+i+'" class="tr_resul_partidas '+i+'">\
									<td class="h1">\
										<b>'+i+'</b>\
									</td>\
									<td class="h1">\
										00\
									</td>\
									<td class="h1">\
										00\
									</td>\
									<td class="h1">\
										00\
									</td>\
									<td class="h1">\
										00\
									</td>\
									<td>\
										'+obj_global[i]['nombre']+'\
									</td>\
								</tr>'
				if (obj_global[i]['hijos']!=undefined) {
					var obj_partida = obj_global[i]['hijos']
					for(ii in obj_partida){
						html_partida += '<tr title="'+i+"_"+ii+'" class="tr_resul_partidas '+i+"_"+ii+'">\
									<td class="h2">\
										<b>'+i+'</b>\
									</td>\
									<td class="h2">\
										<b>'+ii+'</b>\
									</td>\
									<td class="h2">\
										00\
									</td>\
									<td class="h2">\
										00\
									</td>\
									<td class="h2">\
										00\
									</td>\
									<td>\
										'+obj_partida[ii]['nombre']+'\
									</td>\
								</tr>'
						if (obj_partida[ii]['hijos']!=undefined) {
							var obj_generico = obj_partida[ii]['hijos']
							for(iii in obj_generico){
								html_partida += '<tr title="'+i+"_"+ii+"_"+iii+'" class="text-primary tr_resul_partidas '+i+"_"+ii+"_"+iii+'">\
											<td class="h3">\
												<b>'+i+'</b>\
											</td>\
											<td class="h3">\
												<b>'+ii+'</b>\
											</td>\
											<td class="h3">\
												<b>'+iii+'</b>\
											</td>\
											<td class="h3">\
												00\
											</td>\
											<td class="h3">\
												00\
											</td>\
											<td>\
												'+obj_generico[iii]['nombre']+'\
											</td>\
										</tr>'
								if (obj_generico[iii]['hijos']!=undefined) {
									var obj_especifico = obj_generico[iii]['hijos']
									for(iiii in obj_especifico){
										html_partida += '<tr title="'+i+"_"+ii+"_"+iii+"_"+iiii+'" class="tr_resul_partidas '+i+"_"+ii+"_"+iii+"_"+iiii+'">\
													<td class="h4">\
														<b>'+i+'</b>\
													</td>\
													<td class="h4">\
														<b>'+ii+'</b>\
													</td>\
													<td class="h4">\
														<b>'+iii+'</b>\
													</td>\
													<td class="h4">\
														<b>'+iiii+'</b>\
													</td>\
													<td class="h4">\
														00\
													</td>\
													<td>\
														'+obj_especifico[iiii]['nombre']+'\
													</td>\
												</tr>'
										if (obj_especifico[iiii]['hijos']!=undefined) {
											var obj_sub_especifico = obj_especifico[iiii]['hijos']
											for(iiiii in obj_sub_especifico){
												html_partida += '<tr title="'+i+"_"+ii+"_"+iii+"_"+iiii+"_"+iiiii+'" class="tr_resul_partidas '+i+"_"+ii+"_"+iii+"_"+iiii+"_"+iiiii+'">\
															<td class="h5">\
																<b>'+i+'</b>\
															</td>\
															<td class="h5">\
																<b>'+ii+'</b>\
															</td>\
															<td class="h5">\
																<b>'+iii+'</b>\
															</td>\
															<td class="h5">\
																<b>'+iiii+'</b>\
															</td>\
															<td class="h5">\
																<b>'+iiiii+'</b>\
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
		function registrar_datos(json) {
			$.ajax({
				url: 'leer_partida.php',
				type: "post",
				data:{
					json:json,
					accion:"guardar"
				},
				beforeSend: function () {  },
				success: function (res) { 
					console.log(res)
				 }
			});
			
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
			background-color: #f2f2f2;
			overflow-y: auto;
		}	
		.input_partidas{
			border-radius: 15px;
			margin: 10px;
			font-size: 60px;
			border: solid 2px #594747;
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
			color: #00ABBA;
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
		.col{
			word-wrap: break-word;
		}

	</style>
</head>
<body class="">
	<div class="contenedor-agregar-condicion w3-display-topmiddle">
		<div class="card container w3-card-4 w3-display-topmiddle" style="width: 700px;position: fixed;z-index: 2150;">
			<div class="row bg-white text-warning">
				<button class="fa fa-close btn btn-white col-2" onclick="$('.contenedor-agregar-condicion').toggle('display')"></button>
				<div class="col">
					<span class="w3-right nombre_entidad" style="text-shadow:1px 1px 0 #444"></span>
				</div>
			</div>
			<div class="row w3-padding-32 bg-warning" style="overflow-y: auto;height: 700px">
				<ul class="w3-ul w3-hoverable list_entidad" style="width: 100%">
				  
				</ul>
			</div>
		</div>
		<div style="width:100%;height: 100%;position: fixed;background-color: gray;opacity: 0.5" onclick="$('.contenedor-agregar-condicion').toggle('display')"></div>
	</div>
	<div class="container-fluid" style="height: 100%">
		<div class="row">
			<div class="col" style="height: 100%;overflow-y: auto;">
				<div class="container-fluid">
					<div class="row w3-center">
						<div class="col w3-padding-32 ">
							<span class="h1">Crear partida presupuestaria</span>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<span class="w3-left w3-margin borrar_partida"><i class="fa fa-remove fa-3x"></i></span>
						</div>
						<div class="col-5 w3-center">
							<span class="modo-actual h1">Neutro</span>
						</div>
						<div class="col">
							<span class="w3-right w3-margin guardar_partida"><i class="fa fa-save fa-3x"></i></span>
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
					<div class="row w3-border w3-margin w3-round-xlarge w3-padding-large w3-hover-border-orange w3-white">
						<div class="col">
							<div class="form-group">
								<label for="nombre_partida" class="h1">Nombre de la partida</label>
								<input type="text" id="nombre_partida" class="w3-input w3-border-0 w3-round" placeholder="Nombre de la partida">
							</div>
						</div>
					</div>
					<div class="w3-padding-large w3-border w3-margin w3-round-xlarge w3-hover-border-orange w3-white">
						<div class="row">
							<div class="col">
								<span class="h1">Condiciones <button class="btn btn-success agregar-card-condicion fa fa-plus"></button></span>
							</div>
						</div>
						<div class="row w3-margin contenedor-card-condiciones">
							
						</div>
					</div>
					<div class="w3-round-xlarge w3-padding-large w3-margin w3-white">
						<div class="row">
							<div class="col">
								<span class="h1">Asociar conceptos</span>
							</div>
						</div>
						<div class="row">
							<div class="col w3-margin w3-round-xlarge w3-panel w3-border contenedor_agregados">
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
					  				<input type="text" class="w3-margin-bottom w3-margin-top form-control solicitar_personal" placeholder="Busqueda...">
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
			<div class="col-5" style="height: 100%;overflow-y: auto;">
				<div class="container-fluid">
					<div class="row w3-center">
						<div class="col w3-padding-32 ">
							<span class="h1">Creadas</span>
						</div>
					</div>
					<div class="row w3-center w3-padding-32">
						<div class="col resultados_partida_server">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>