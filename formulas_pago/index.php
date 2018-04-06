<?php 
	session_start();
	include '../conexion_bd.php'; 
	$valores = (new sql("valores_globales","WHERE id='1'"))->select()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Fórmulas</title>
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/hover/css/hover.css">
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery.cookie.js"></script>
		<script src="../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../css/bootstrap/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var json = {};
		
			var disponibles = { 
				"estado" : <?php echo $valores['estado']; ?>,
				"numero_hijos" : {0 : "discapacidad", 1 : "estudia", 2 : "edad"},
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

			var color = 0 ;
			function validar_cedula(e){
				tecla=(document.all) ? e.keyCode: e.which;
				if (tecla == 8) return true;
				patron =/[0-9]/;
				te=String.fromCharCode(tecla);
				return patron.test(te);
			}
			function borrar_sub_element(valor,campo){	
				delete json[campo.replace(/\u00a0/g, " ")][valor.replace(/\u00a0/g, " ")];
			}
			function agg_valor(select_campo){
				var valor = $("#select_valor_disponible_"+select_campo).val(),
				operador = $("#select_operador_disponible_"+select_campo).val(),
				lugar_botones = $("#botones_valor_"+select_campo);
				
				if (select_campo=="numero_hijos") {	
					
					var v_condic_hijos = $(".div_valor_hijos").find(".form-control").val()
					if (JSON.stringify(json[select_campo])=="{}") {
						json[select_campo] = new Object();
						json[select_campo][valor] = new Object();
						json[select_campo][valor][v_condic_hijos] = operador;
						agg_boton();
					}else{
						var string_js = JSON.stringify(json[select_campo]);
						if (string_js.includes(valor)==false) {
							json[select_campo][valor] = new Object();
							json[select_campo][valor][v_condic_hijos] = operador;
							agg_boton();
						}			    
					}
					function agg_boton(){
						lugar_botones.append("<button class='btn btn-primary w3-margin-right w3-margin-top' onclick=borrar_sub_element('"+valor.replace(/ /g,"&nbsp;")+"','"+select_campo.replace(/ /g,"&nbsp;")+"');$(this).remove()>"+valor+" "+operador+" "+v_condic_hijos+"</button>");
					} 
				}else{
					function agg_boton(){
						lugar_botones.append("<button class='btn btn-primary w3-margin-right w3-margin-top' onclick=borrar_sub_element('"+valor.replace(/ /g,"&nbsp;")+"','"+select_campo.replace(/ /g,"&nbsp;")+"');$(this).remove()>"+operador+" "+valor+"</button>");
					} 
					if (JSON.stringify(json[select_campo])=="{}") {
						json[select_campo] = new Object();
						json[select_campo][valor] = operador;
						agg_boton();
					}else{
						var string_js = JSON.stringify(json[select_campo]);
						if (string_js.includes(valor)==false) {
							json[select_campo][valor] = operador;
							agg_boton();
						}			    
					}
				}
			}
			function crear_html_campo(select_campo){
				if (select_campo=="cualquiera") {
					var html = "<div id='div_cualquiera' class='w3-center w3-border w3-margin w3-hover-border-blue w3-padding'>\
									<button class='btn btn-danger delete_todo_campo' title='cualquiera'>\
										<i class='fa fa-window-close' aria-hidden='true'></i>\
									</button>\
									<h2 style='color:green'>Aplica para cualquier tipo de personal</h2>\
								</div>"		
					$("#items").append(html);
				}else if (select_campo=="numero_hijos") {
					var html = "<div class='container-fluid w3-border w3-margin w3-hover-border-blue' id='div_"+select_campo+"'>\
									<div class='row w3-padding w3-center'>\
										<div class='col'>\
											<button class='btn btn-danger delete_todo_campo' title='"+select_campo+"'><i class='fa fa-window-close' aria-hidden='true'></i>\
											</button>\
											<h3>"+select_campo+"</h3>\
										</div>\
									</div>\
									<div class='row w3-padding'>\
										<div class='col'>Condición para: \
											<select class='form-control' id=select_valor_disponible_"+select_campo+">";
												for(key in disponibles[select_campo]){					
													html += "<option value='"+disponibles[select_campo][key]+"'>"+disponibles[select_campo][key]+"</option>";
												}	
									html += "</select>\
										</div>\
										<div class='col'>operador: \
									    	<select class='form-control' id=select_operador_disponible_"+select_campo+">\
												<option value='='>Igual</option>\
												<option value='!='>Diferente</option>\
												<option value='>'>Mayor</option>\
												<option value='<'>Menor</option>\
												<option value='>='>Mayor o igual</option>\
												<option value='<='>Menor o igual</option>\
											</select>\
										</div>\
										<div class='col div_valor_hijos'>Valor:\
									    	<select class='form-control'>\
												<option value='si'>Si</option>\
												<option value='no'>No</option>\
											</select>\
										</div>\
									</div>\
									<div class='row w3-padding'>\
										<div class='col'>\
												<button style='width:100%' class='btn btn-outline-info' onclick=agg_valor('"+select_campo+"')>Aplicar\
												</button>\
										</div>\
									</div>\
									<div class='row w3-padding'>\
										<div id=botones_valor_"+select_campo+" class='col'>\
										</div>\
									</div>\
							</div>";
					$("#items").append(html);
				}else{
					var html = "<div class='container-fluid w3-border w3-margin w3-hover-border-blue' id='div_"+select_campo+"'>\
									<div class='row w3-padding w3-center'>\
										<div class='col'>\
											<button class='btn btn-danger delete_todo_campo' title='"+select_campo+"'>\
												<i class='fa fa-window-close' aria-hidden='true'></i>\
											</button>\
											<h3>"+select_campo+"</h3>\
										</div>\
									</div>\
									<div class='row w3-padding'>\
										<div class='col'>Valor disponible:\
											<select class='form-control' id=select_valor_disponible_"+select_campo+">";
												for(key in disponibles[select_campo]){					
													html += "<option value='"+disponibles[select_campo][key]+"'>"+disponibles[select_campo][key]+"</option>";
												}	
									html += "</select>\
										</div>\
										<div class='col'>operador: \
									    	<select class='form-control' id=select_operador_disponible_"+select_campo+">\
												<option value='igual'>Igual</option>\
												<option value='diferente'>Diferente</option>\
												<option value='mayor'>Mayor</option>\
												<option value='menor'>Menor</option>\
												<option value='mayor o igual'>Mayor o igual</option>\
												<option value='menor o igual'>Menor o igual</option>\
											</select>\
										</div>\
									</div>\
									<div class='row w3-padding'>\
										<div class='col'>\
												<button style='width:100%' class='btn btn-outline-info' onclick=agg_valor('"+select_campo+"')>Aplicar\
												</button>\
										</div>\
									</div>\
									<div class='row w3-padding'>\
										<div id=botones_valor_"+select_campo+" class='col'>\
										</div>\
									</div>\
							</div>";
					$("#items").append(html);
				}
			}
			$(document).ready(function() {
				$(document).on("click",".delete_todo_campo",function() {
					var c = $(this).attr("title")
					delete json[c]
					$('#div_'+c).animate({opacity:0},150,function(){$('#div_'+c).remove()})
					$("#select_campo").val("seleccione")
				})
				$("#select_campo").change(function(){
					var select_campo = $("#select_campo").val();
					if (select_campo!="seleccione") {
						if(select_campo=="cualquiera"){
							if (JSON.stringify(json)=="{}") {
								json={"cualquiera":""};
								crear_html_campo("cualquiera");
							}	
						}else if(select_campo=="numero_hijos"){
							json["numero_hijos"]={};
							crear_html_campo("numero_hijos");
						}else{
							if (json[select_campo]==undefined && $("#div_cualquiera").length == 0 && $("#div_numero_hijos").length == 0) {
								json[select_campo]={};
								crear_html_campo(select_campo);
							}
						}
					}
				});	
				$(document).on("change","#select_valor_disponible_numero_hijos",function () {
					if ($(this).val()=="edad") {
						$(".div_valor_hijos")
						.empty()
						.append("Valor:<input type='text' class='form-control' placeholder='Valor' onKeyPress='return validar_cedula(event)' maxlength='2' value='0'>")
					}else{
						$(".div_valor_hijos")
						.empty()
						.append("Valor:<select class='form-control'>\
									<option value='si'>Si</option>\
									<option value='no'>No</option>\
								</select>")
					}
				})						
			});
			//Crear condiciones si es que ya se encontraban en el JSON
			function json_create() {
				if (JSON.stringify(json)!="{}") {
					for(campo in json){
						if (campo=="cualquiera") {
							crear_html_campo("cualquiera");
						}else if (campo=="numero_hijos") {
							crear_html_campo("numero_hijos");
						}else{
							crear_html_campo(campo);
						}
						if (JSON.stringify(json[campo])!="{}") {
							for(valor in json[campo]){
								var opera = json[campo][valor];
								if (campo=="numero_hijos") {
									$("#botones_valor_"+campo).append("<button class='btn btn-primary w3-margin-right w3-margin-top' onclick=borrar_sub_element('"+valor.replace(/ /g,"&nbsp;")+"','"+campo.replace(/ /g,"&nbsp;")+"');$(this).remove()>"+valor+" "+Object.values(opera)+" "+Object.keys(opera)+"</button>");	
								}else{
									$("#botones_valor_"+campo).append("<button class='btn btn-primary w3-margin-right w3-margin-top' onclick=borrar_sub_element('"+valor.replace(/ /g,"&nbsp;")+"','"+campo.replace(/ /g,"&nbsp;")+"');$(this).remove()>"+opera+" "+valor+"</button>");	
								}			
							}
						}
					}
				}
			}
		</script>
		<script type="text/javascript">
			function buscar() {
			 	$.ajax({
			        url:"procesar.php",
			        data:{
			        	operacion:"buscar",
						b:$("#buscar_input").val()
			   		},
			        type:"post",
			        async:false, 
			        datatype:"json",
			        success:function(response)
			        {	//alert(response)
			        	var incluido = "";
			        	obj = JSON.parse(response)
			        	var temple = ''
			        	obj.map(function (element,i) {
			        		if(incluido.indexOf(element.tipo_concepto)==-1){
		        				temple+='<tr>'
		        					temple+='<td colspan="2" class="bg-info text-white"><h3>'+element.tipo_concepto+'</h3></td>'
		        				temple+='</tr>'
		        				incluido = element.tipo_concepto
			        		}
			        			temple+='<tr class="formula_selected" title="' + i + '">'
				        			temple+='<td>'+ element.id +'</td>'
				        			temple+='<td>'+ element.descripcion +'</td>'
				        		temple+='</tr>'        			        		
			        	})
			   			$("#resultados")
			   			.empty()
			   			.append(temple)
					}		  
			    })
			}
			$(document).ready(function () {
				buscar()
				$("#buscar_input").keyup(buscar)
				$(document).on("click",".formula_selected",function () {
					var i = $(this).attr('title')
						var opera = JSON.parse(obj[i].operaciones);
						json = JSON.parse(obj[i].condiciones)
						$("#items").empty()
						json_create()
						var arr_opera = Object.keys(opera)
						if (arr_opera.includes("aporte_patronal")) {
							$("#formula").val(opera.deduccion)
							$("#formula_aporte").val(opera.aporte_patronal)
							$("#contenedor_formula_aporte").css("display","")
						}else{
							$("#formula").val(opera.operacion)
							$("#contenedor_formula_aporte").css("display","none")

						}
						
						$("#descripcion_formula").val(obj[i].descripcion)
						$("#vigencia").val(obj[i].fecha)
						$("#tipo_concepto").val(obj[i].tipo_concepto)
						$("#tipo_sueldo").val(obj[i].tipo_sueldo)
						$("#asignacion_deduccion").val(obj[i].asignacion_deduccion)
						$("#periodo_pago").val(obj[i].periodo_pago)
						$("#name_formula")
						.attr('title',obj[i].id)
						.text(obj[i].descripcion)
						$("#datos_operaciones_formula").css("display","")
				})
				$(document).on("click",".guardar_cambios",function () {
					save_insert("update")
					
				})
				$(document).on("click","#crear_nueva_formula",function () {
					update_insert("insert")
				})
				$("#asignacion_deduccion").change(function () {
					var c = $("#contenedor_formula_aporte")
					if ($(this).val()=="aporte_patronal") {
						c.css("display","")
					}else{
						c.css("display","none")
					}
				})
			})
			function update_insert(opera_ejecutar) {
				var id = $("#name_formula").attr("title")
				if (JSON.stringify(json)=="{}") {
					alert("Especifique el campo a condicionar!")
				}else{
					var campos_vacios = 0;
					for(campo in json){
						if (JSON.stringify(json[campo])=="{}" && campo!="cualquiera") {
							alert(campo + " no puede estar vacío!");
							campos_vacios++;
						}
					}
					if (campos_vacios==0) {
						if ($("#vigencia").val()=="" || $("#descripcion").val()=="") {
						alert("Error: Campos vacíos!")
					}else{
						$.ajax({
							url:"procesar.php",
							data:{
								"operacion":opera_ejecutar,
								"id":id,
								"condiciones":JSON.stringify(json),
								operaciones:function () {
									if ($("#contenedor_formula_aporte").css('display')=="none") {
										return JSON.stringify({operacion:$("#formula").val()})
									}else{
										return JSON.stringify({aporte_patronal:$("#formula_aporte").val(),deduccion:$("#formula").val()})
									}
								},
								"tipo_concepto":$("#tipo_concepto").val(),
								"tipo_sueldo":$("#tipo_sueldo").val(),
								"asignacion_deduccion":$("#asignacion_deduccion").val(),
								"periodo_pago":$("#periodo_pago").val(),
								"descripcion":$("#descripcion_formula").val(),
								"fecha":$("#vigencia").val()
							},
							type:"post",
							beforeSend:function () {
								
							},
							success:function (res) {
								
								if (res=="Exito al actualizar") {
									if (window.confirm("Exito al actualizar!. ¿Desea recargar la página?")) {
										location.reload();
										buscar()
									}
								}else{
									alert(res)
								}
							}
						})
					}
					}
				}
			}
			function delete_formula() {
				if (window.confirm("Está a punto de eliminar una fórmula. Desea continuar?")) {
					var id = $("#name_formula").attr("title")

					$.ajax({
						url:"procesar.php",
						data:{
							"operacion":"delete",
							"id":id
						},
						type:"post",
						beforeSend:function () {
							
						},
						success:function (res) {
							alert(res)
						}
					})
				}
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
				background-color: #F5F5F5;
				overflow: hidden;
			}
			.formula_selected:hover{
				background-color: grey;
				color:white;
				cursor: pointer;
				transition: 0.2s;
			}
			button{
				cursor: pointer;
			}
		</style>
</head>
<body>
	<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse bg-faded" style="height: 10%">
	  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <a class="navbar-brand text-primary" href="#" id="crear_nueva_formula"><i class="fa fa-puzzle-piece"></i> Crear nueva fórmula</a>
	  <div class="collapse navbar-collapse" id="navbarNavDropdown">
	    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
	      <li class="nav-item active">
	        	
	      </li>
	    </ul>
	    <ul class="form-inline my-2 my-lg-0">
        	<input type="text" class="form-control mr-sm-2" placeholder="Buscar fórmula" id="buscar_input"/>
       		<button class="btn btn-outline-info my-2 my-sm-0" onclick="buscar()" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
     	</ul>
	  </div>
	</nav>
	<div class="row w3-margin-top" style="height: 90%;width: 100%;margin: 0;padding: 0">

		<div class="col" style="height: 100%;overflow-y: auto;">
			<div class="row">
				<span class="h1 w3-center w3-margin">Configurar fórmula</span>
			</div>
			<div class="row" id="datos_operaciones_formula" style="display: none;z-index: 1000">
				<div class="col">
					<div class="form-group">
						<label for="">Nombre de la fórmula: </label>
						<h2><span id="name_formula" class="text-primary"></span></h2>
					</div>
					<div class="form-group" id="operaciones_formula">
						<button class="btn btn-danger" onclick="delete_formula()">Eliminar</button>
						<button class="btn btn-warning guardar_cambios">Guardar cambios</button>
					</div>
				</div>
			</div>
			<div class="row w3-border w3-margin">
				<div class="col">
					<div class="w3-padding">
						<div class="bg-danger text-white" style="padding: 5px">
							<center>
								<h4>Condiciones</h4>
								<button class="btn btn-danger" onclick="alert(JSON.stringify(json))">
									Ver condiciones (JSON)
								</button>
							</center>
						</div><hr>
						<h2>¿Quién aplica para esta fórmula? </h2>
						
						<div style="width: 100%" class="w3-display-top">
							<label for="select_campo">Condicionar campo:</label>
							<select class="form-control" id="select_campo">
								<option value="seleccione">-- Seleccione --</option>
								<option value="estado">Estado</option>
								<option value="genero">Género</option>
								<option value="estatus">Estatus</option>
								<option value="grado_instruccion">Grado de instrucción</option>
								<option value="categoria">Categoría</option>
								<option value="cargo">Cargo</option>	
								<option value="dedicacion">Dedicación</option>
								<option value="caja_ahorro">Caja de ahorro</option>
								<option value="numero_hijos">Hijos</option>
								<option value="cualquiera">* Aplica para cualquier tipo de personal *</option>
							</select>
						</div>
						<div style="width: 100%" id="items">
						</div>
					</div>
				</div>
			</div>
			<div class="row w3-border w3-margin">
				<div class="col">
					<div class="w3-padding">
						<div class="bg-danger text-white" style="padding: 5px"><center><h4>Parámetros de la nómina</h4></center></div>
						<hr>
						<div class="row">
							<div class="col">
								<article class="form-group">
									<header>Descripción</header>
									<textarea placeholder="Nombre de la fórmula" id="descripcion_formula" style="width: 100%"></textarea>
								</article>
								<article class="form-group">
									<header>Vigente desde</header>
									<input type="date" class="form-control" id="vigencia">
								</article>
								<article class="form-group">
									<header>Tipo de concepto</header>
									<select class="form-control" id="tipo_concepto">
										<option value="prima salarial">Prima salarial</option>
										<option value="deduccion salarial">Deducción salarial</option>
										<option value="bono salarial">Bono salarial</option>
										<option value="bono alimentacion">Bono de alimentación</option>
										<option value="aporte_patronal">Aporte patronal</option>
									</select>
								</article>
							</div>
							<div class="col">
								<article class="form-group">
									<header>Tipo de sueldo</header>
									<select class="form-control" id="tipo_sueldo">
										<option value="sueldo basico">Sueldo básico</option>
										<option value="sueldo normal">Sueldo normal</option>
										<option value="aporte_patronal">Aporte patronal</option>
									</select>
								</article>
								<article class="form-group">
									<header>Asignación-Deducción-Aporte</header>
									<select class="form-control" id="asignacion_deduccion">
										<option value="asignacion">Asignación</option>
										<option value="deduccion">Deducción</option>
										<option value="aporte_patronal">Aporte patronal</option>
									</select>
								</article>
								<article class="form-group">
									<header>Período de pago</header>
									<select class="form-control" id="periodo_pago">
										<option value="semanal">Semanal</option>
										<option value="mensual" selected="">Mensual</option>
										<option value="anual">Anual</option>
									</select>
								</article>
							</div>
						</div>
						<div class="bg-danger text-white" style="padding: 5px"><center><h4>Operaciones</h4></center></div>
						<header style="padding: 10px">Variables posibles: 
								<strong>unidad_tributaria</strong>,
								<strong>sueldo_tabla</strong>,
								<strong>años_antiguedad</strong>,
								<strong>prima_hijos</strong>,
								<strong>lunes_del_mes</strong>,
								<strong>sueldo_normal</strong>
								<br>
								Operaciones posible: 
									<strong>menos</strong>,
									<strong>mas</strong>,
									<strong>entre</strong>,
									<strong>por</strong>
						</header>
							<hr>	
						<div>
							<div class="form-control">
								<label for="formula">Fórmula de <b>asignación o deducción</b></label>
								<textarea placeholder='Escriba su fórmula' id='formula' style='width: 100%;height:100px'></textarea>
							</div>
							<div class="form-control" style="display: none" id="contenedor_formula_aporte">
								<label for="formula">Fórmula de <b>aporte patronal</b></label>
								<textarea placeholder='Escriba su fórmula' id='formula_aporte' style='width: 100%;height:100px'></textarea>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-4" style="height: 100%;overflow-y: auto;">
			<center><h3>Repositorio de fórmulas</h3></center>	
			
			<table class="table table-responsive">
				<thead>
					<tr>
						<th>Id</th>
						<th>Descripción</th>
					</tr>
				</thead>
				<tbody id="resultados"></tbody>
			</table>
		</div>
	</div>
</body>
</html>