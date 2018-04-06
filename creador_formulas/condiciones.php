<?php 
	session_start();
	include '../conexion_bd.php'; 
	$valores = (new sql("valores_globales","WHERE id='1'"))->select()->fetch_assoc();
?>
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

	var color = 0 ;
	function borrar_sub_element(valor,campo){	
		delete json[campo.replace(/\u00a0/g, " ")][valor.replace(/\u00a0/g, " ")];
	}
	function agg_valor(select_campo){
		var valor = $("#select_valor_disponible_"+select_campo).val(),
		operador = $("#select_operador_disponible_"+select_campo).val(),
		lugar_botones = $("#botones_valor_"+select_campo);
					    
		function agg_boton(){
			lugar_botones.append("<button class='w3-button w3-red' onclick=borrar_sub_element('"+valor.replace(/ /g,"&nbsp;")+"','"+select_campo.replace(/ /g,"&nbsp;")+"');$(this).remove()>"+operador+" "+valor+"</button>");
		}    
		if (JSON.stringify(json[select_campo])=="{}") {
			json[select_campo] = JSON.parse('{"'+valor+'":"'+operador+'"}');
			agg_boton();
		}else{
			var string_js = JSON.stringify(json[select_campo]);
			if (string_js.includes(valor)==false) {
			json[select_campo] = JSON.parse(string_js.replace('"}','","'+valor+'":"'+operador+'"}'));
				agg_boton();
			}			    
		}
	}
	function crear_html_campo(select_campo){
		if (select_campo=="cualquiera") {
			var html = "<div class='w3-animate-bottom' id='div_cualquiera'><center><button class='btn btn-danger' onclick=delete&nbsp;json['cualquiera'];$('#div_cualquiera').animate({opacity:0},150,function(){$('#div_cualquiera').remove()})><i class='fa fa-window-close' aria-hidden='true'></i></button><h2 style='color:green'>Aplica para cualquier tipo de personal</h2></center></div>"		
			$("#items").append(html);
		}else{
			var html = "<div class='' id='div_"+select_campo+"'><center><button class='btn btn-danger' onclick=delete&nbsp;json['"+select_campo+"'];$('#div_"+select_campo+"').animate({opacity:0},150,function(){$('#div_"+select_campo+"').remove()})><i class='fa fa-window-close' aria-hidden='true'></i></button></center><center><h3>"+select_campo+"</h3></center><div style='float:left'>Valor disponible: <select id=select_valor_disponible_"+select_campo+">";
				for(key in disponibles[select_campo]){					
					html += "<option value='"+disponibles[select_campo][key]+"'>"+disponibles[select_campo][key]+"</option>";
				}	
				html+="</select></div>";
				html+="<div style='float:right'>operador: <select id=select_operador_disponible_"+select_campo+"><option value='igual'>Igual</option><option value='diferente'>Diferente</option><option value='mayor'>Mayor</option><option value='menor'>Menor</option><option value='mayor o igual'>Mayor o igual</option><option value='menor o igual'>Menor o igual</option></select></div>";
				html+="<br><br><center><button style='width:100%' class='w3-button w3-light-blue' onclick=agg_valor('"+select_campo+"')>Aplicar</button></center>";
				html+="<div id=botones_valor_"+select_campo+"></div>";
				html+="<hr></div>"		
			$("#items").append(html);
		}
	}
	$(document).ready(function() {
		$("#select_campo").change(function(){
			var select_campo = $("#select_campo").val();
			if(select_campo=="cualquiera"){
				if (JSON.stringify(json)=="{}") {
					json={"cualquiera":""};
					crear_html_campo("cualquiera");
				}	
			}else{
				if (json[select_campo]==undefined && $("#div_cualquiera").length == 0) {
					json[select_campo]={};
					crear_html_campo(select_campo);
				}
			}
		});							
	});
	//Crear condiciones si es que ya se encontraban en el JSON
	$(document).ready(function(){
		if (JSON.stringify(json)!="{}") {
			for(campo in json){
					if (campo=="cualquiera") {
						crear_html_campo("cualquiera");
					}else{
						crear_html_campo(campo);
					}
					
				if (JSON.stringify(json[campo])!="{}") {
					for(valor in json[campo]){
						var opera = json[campo][valor];
						$("#botones_valor_"+campo).append("<button class='w3-button w3-red' onclick=borrar_sub_element('"+valor.replace(/ /g,"&nbsp;")+"','"+campo.replace(/ /g,"&nbsp;")+"');$(this).remove()>"+opera+" "+valor+"</button>");					
					}
				}
			}
		}
	});
	function ir_a_operaciones(){
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
				pagina_actual('operaciones.html')
			}
		}
	}
</script>
<button onclick="ir_a_operaciones()" class="w3-button w3-circle w3-teal w3-display-right"><i class="fa fa-hand-o-right fa-5x" aria-hidden="true"></i></button>
	<div style="width: 50%;height: 100%;overflow: auto;" class="w3-display-topmiddle w3-container">
		<center><h1>Condiciones</h1></center><hr>
		<h2>¿Quién aplica para esta fórmula?</h2>
		<button class="w3-button" style="float: right;" onclick="alert(JSON.stringify(json))">Ver fórmula</button>
		<div style="width: 100%" class="w3-display-top">
			
			<select class="form-control" id="select_campo">
				<option value="">-- Seleccione --</option>
				<option value="estado">Estado</option>
				<option value="genero">Género</option>
				<option value="estatus">Estatus</option>
				<option value="grado_instruccion">Grado de instrucción</option>
				<option value="categoria">Categoría</option>
				<option value="cargo">Cargo</option>	
				<option value="dedicacion">Dedicación</option>
				<option value="caja_ahorro">Caja de ahorro</option>
				<option value="cualquiera">* Aplica para cualquier tipo de personal *</option>
						
			</select>
			
		</div>
		<hr>
		<div style="width: 100%" id="items">
		</div>
	</div>


