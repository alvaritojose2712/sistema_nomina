<?php 
	session_start();
	include '../conexion_bd.php';
	$valores = (new sql("valores_globales","WHERE id='1'"))->select()->fetch_assoc();
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title> .: Personal | Sinapsis :.</title>
	<link rel="stylesheet" type="text/css" href="../css/w3.css">
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.css">
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

		function validar_fecha(e){
			tecla=(document.all) ? e.keyCode: e.which;
			if (tecla == 8) return true;
			patron =/[0-9-/]/;
			te=String.fromCharCode(tecla);
			return patron.test(te);
		}
		function validar_cedula(e){
			tecla=(document.all) ? e.keyCode: e.which;
			if (tecla == 8) return true;
			patron =/[0-9]/;
			te=String.fromCharCode(tecla);
			return patron.test(te);
		}
		function changeUrlParam (param, value) { 
	        var currentURL = window.location.href+'&'; 
	        var change = new RegExp('('+param+')=(.*)&', 'g'); 
	        var newURL = currentURL.replace(change, '$1='+value+'&'); 
	 
	        if (getParameterByName(param) !== null){ 
	                try { 
	                        window.history.replaceState('', '', newURL.slice(0, - 1) ); 
	                } catch (e) { 
	                        console.log(e); 
	                } 
	        } else { 
	                var currURL = window.location.href; 
	                if (currURL.indexOf("?") !== -1){ 
	                        window.history.replaceState('', '', currentURL.slice(0, - 1) + '&' + param + '=' + value); 
	                } else { 
	                        window.history.replaceState('', '', currentURL.slice(0, - 1) + '?' + param + '=' + value); 
	                } 
	        } 
		}
		const word = ["Incluir Personal"]
		
		function ww() {
			var num = 0
			var n_word = 0
			var wr = $(".text_write")
			let word1 = setInterval(function () {
				
				if (word[n_word][num]==undefined) {
					clearInterval(word1)
				}else{
					wr.text(function (i,text) {
						return text+=word[n_word][num]
					})
					
					num++;
				}
			},200)
		}


		const cat_car_dedic = <?php echo $valores['cat_car_dedic']; ?>;
		const estado = <?php echo $valores['estado']; ?>;
		const estatus = <?php echo $valores['estatus']; ?>;
		const grado_instruccion = <?php echo $valores['grado_instruccion']; ?>;

		$(document).ready(function(){
			ww()
			setInterval(function () {
				var es = $("#escritor")
				es.toggleClass("escritor")
			},300)
			for(i in cat_car_dedic){
				$("#categoria").append('<option value="'+i+'">'+i+'</option>')
			}
			for(i in grado_instruccion){
				$("#grado_instruccion").append('<option value="'+grado_instruccion[i]+'">'+grado_instruccion[i]+'</option>')
			}

			for(i in estado){
				$("#estado").append('<option value="'+estado[i]+'">'+estado[i]+'</option>')
			}

			for(i in estatus){
				$("#estatus").append('<option value="'+estatus[i]+'">'+estatus[i]+'</option>')
			}
			$("#categoria").change(function() {
				if ($(this).val()!="-Seleccione-") {
					
					var cargo = cat_car_dedic[$(this).val()]['cargo'];
					var dedicacion = cat_car_dedic[$(this).val()]['dedicacion'];
					
					$("#dedicacion").attr("disabled",false)
					$("#cargo").attr("disabled",false)
					$("#cargo").empty();
					$("#dedicacion").empty();

					for(i in cargo){						
						$("#cargo").append("<option value='"+cargo[i]+"'>"+cargo[i]+"</option>")
					}

					for(i in dedicacion){	

						$("#dedicacion").append("<option value='"+dedicacion[i]+"'>"+dedicacion[i]+"</option>")
					}
						
					
				}else{
					$("#cargo").empty();
					$("#dedicacion").empty();
					$("#dedicacion").attr("disabled",true)
					$("#cargo").attr("disabled",true)
				}
			});

			if(getParameterByName('id')!=""){
				word[0] = "Editar Personal"
				$(".cedula_editando").text(getParameterByName('id'))
				$("#enviar_datos").attr("title","editar")
				$(".editando").show()

				<?php 
					if (isset($_GET['id'])) {
						$consulta_valores = (new sql("personal_upt","WHERE cedula='$_GET[id]' LIMIT 1"))->select();
						if ($consulta_valores->num_rows==1) {
							echo "test_values(".json_encode($consulta_valores->fetch_assoc()).");";
							$consulta_valores_hijos = (new sql("hijos_personal","WHERE cedula_representante='$_GET[id]'"))->select();
							if ($consulta_valores_hijos->num_rows>0) {
								while ($row_hijos = $consulta_valores_hijos->fetch_assoc()) {
									echo "crear_fila_hijo(".json_encode($row_hijos).");";
								}
							}
						}else{
							exit();
						}
					}
				?>
			}
		});
		$(document).on("click","#enviar_datos",function() {
			if (validar_todos_inputs()) {
				let json_campos = {}
				$(".notificacion").show()

				json_campos['accion']=$(this).attr("title");
				json_campos['editando'] = $(".cedula_editando").text();


				let arr = $("#form_trabajador .validar_este").toArray();
				let arr_hijos = $("#tabla_hijos_trabajador").find('tr').toArray();

				let campos = "";
				let valores = "";
				for(i in arr){
					campos += $(arr[i]).attr("id")+",";
					valores += "'"+$(arr[i]).val()+"',";
				}
				json_campos['valores'] = valores.slice(0, -1);
				json_campos['campos'] = campos.slice(0, -1);


				json_campos['valores_hijos'] = {};
				for(i in arr_hijos){

					let id_hijo = $(arr_hijos[i]).find('.id_hijo').val()
					let nombre_hijo = $(arr_hijos[i]).find('.nombre_nuevo').val()
					let apellido_hijo = $(arr_hijos[i]).find('.apellido_nuevo').val()
					let cedula_representante = $("#cedula").val()
					let fecha_nacimiento_hijo = $(arr_hijos[i]).find('.fecha_nacimiento_nuevo').val()
					let estudia_hijo = $(arr_hijos[i]).find('.estudia_nuevo').val()
					let discapacidad_hijo = $(arr_hijos[i]).find('.discapacidad_nuevo').val()
					
					json_campos['valores_hijos'][i] = "'"+id_hijo+"','"+nombre_hijo+"','"+apellido_hijo+"','"+cedula_representante+"','"+fecha_nacimiento_hijo+"','"+estudia_hijo+"','"+discapacidad_hijo+"'"					

				}
			
				send_data(json_campos)	
			}
		})
		$(document).on("click","#agregar_nuevo_hijo",function() {
			crear_fila_hijo({
				id: null,
				nombre: "",
				apellido: "",
				fecha_nacimiento: "",
				estudia: "",
				discapacidad: ""
			})

		});
		function crear_fila_hijo(json) {
			let turn_estudia = (json.estudia==="si")?"selected":"";
			let turn_discapacidad = (json.discapacidad==="si")?"selected":"";

			let html = "<tr>\
							<td class='form-group'>\
								<input type='text' class='id_hijo form-control' size='5' value='"+json.id+"' disabled/>\
							</td>\
							<td class='form-group'>\
								<input type='text' class='nombre_nuevo form-control validar_este' maxlength='30' value='"+json.nombre+"' placeholder='Nombres'/>\
							</td>\
							<td class='form-group'>\
								<input type='text' class='apellido_nuevo form-control validar_este' maxlength='30' value='"+json.apellido+"' placeholder='Apellidos'/>\
							</td>\
							<td class='form-group'>\
								<input type='date' class='fecha_nacimiento_nuevo form-control validar_este' maxlength='30' value='"+json.fecha_nacimiento+"' placeholder='Fecha de nacimiento'/>\
							</td>\
							<td class='form-group'>\
								<select class='estudia_nuevo form-control validar_este'>\
									<option value='no'>No</option>\
									<option value='si' "+turn_estudia+">Si</option>\
								</select>\
							</td>\
							<td class='form-group'>\
								<select class='discapacidad_nuevo form-control validar_este'>\
									<option value='no'>No</option>\
									<option value='si' "+turn_discapacidad+">Si</option>\
								</select>\
							</td>\
							<td class='form-group'>\
								<div onclick=$(this).parents('tr').remove() class='btn btn-danger btn-block'>\
									<i class='fa fa-window-close-o' aria-hidden='true'></i>\
								</div>\
							</td>\
						</tr>"
			$("#tabla_hijos_trabajador").append(html)
		}
		function send_data(json_campos) {
			$.ajax({
			    url:"procesar.php",
			    data:json_campos,
			    type:"post",
			   	beforeSend:function() {
			   		$(".notificacion").html('<div class="cargando w3-center"><div class="loader section-large">\
			            <div class="loader-inner line-scale-pulse-out">\
				          <div class="bg-inverse"></div>\
				          <div class="bg-inverse"></div>\
				          <div class="bg-inverse"></div>\
				          <div class="bg-inverse"></div>\
				          <div class="bg-inverse"></div>\
				        </div>\
			      </div></div>')
			   	},
			    success:function(res)
			    {
			    	let obj = JSON.parse(res)

			        $(".notificacion").html(obj.estado);
			        if (obj.estado=="Actualizado con éxito") {
			        	$(".cedula_editando").text($("#cedula").val())
			        	changeUrlParam("id",$("#cedula").val())
			        }
			    }
			});
		}
		function validar_todos_inputs() {
			let all = $(".validar_este").toArray()
			let check = true
			for(i in all){
				let ele_actual = $(all[i])
				let form_padre = ele_actual.parents('.form-group') 

				if (ele_actual.val()=="" || ele_actual.val()==null || ele_actual.val()=="-Seleccione-") {
					
					form_padre.addClass('has-danger')
					ele_actual.addClass('form-control-danger')
					if (form_padre.find(".msj").length==0) {
						ele_actual.after('<div class="form-control-feedback msj">Campo Inválido!</div>')
					}
					check=false
				}else{
					form_padre.find(".msj").remove()
					form_padre.switchClass('has-danger',"has-success",20)
					ele_actual.switchClass('form-control-danger',"form-control-success",20)
				}
			}
			return check
		}
		const json_test_values = {
			nombre: 'Alvaro Jose',
			apellido: 'Ospino',
			cedula: '26767116',
			nacionalidad: 'V',
			genero: 'Masculino',
			fecha_nacimiento: '1998-12-27',
			telefono_1: '04164521234',
			telefono_2: '02409940123',
			correo: 'alvaroospino79@gmail.com',
			cuenta_bancaria: '017500901234000172',
			profesion: 'Informático',
			departamento_adscrito: 'PNFI',
			cargo_desempeñado_departamento: 'Coordinador',
			estado: 'ACTIVO',
			estatus: 'EMPLEADO FIJO',
			grado_instruccion: 'DOCTOR',
			categoria: 'ADMINISTRATIVO',
			dedicacion: 'TIEMPO COMPLETO',
			cargo: 'APOYO NIVEL 1',
			fecha_ingreso: '2016-10-29',
			caja_ahorro: 'no',
			antiguedad_otros_ieu: '6',
			hrs_nocturnas: '0',
			hrs_diurnas: '0',
			hrs_feriadas: '0',
			hrs_feriadas_nocturnas:'0'
		}
		function test_values(obj) {
			$("#nombre").val(obj.nombre)
			$("#apellido").val(obj.apellido)
			$("#cedula").val(obj.cedula)
			$("#nacionalidad").val(obj.nacionalidad)
			$("#genero").val(obj.genero)
			$("#fecha_nacimiento").val(obj.fecha_nacimiento)
			$("#telefono_1").val(obj.telefono_1)
			$("#telefono_2").val(obj.telefono_2)
			$("#correo").val(obj.correo)
			$("#cuenta_bancaria").val(obj.cuenta_bancaria)
			$("#profesion").val(obj.profesion)
			$("#departamento_adscrito").val(obj.departamento_adscrito)
			$("#cargo_desempeñado_departamento").val(obj.cargo_desempeñado_departamento)
			$("#estado").val(obj.estado)
			$("#estatus").val(obj.estatus)
			$("#grado_instruccion").val(obj.grado_instruccion)
			$("#categoria").val(obj.categoria)
			$("#categoria").trigger('change')
			$("#dedicacion").val(obj.dedicacion)
			$("#cargo").val(obj.cargo)
			$("#fecha_ingreso").val(obj.fecha_ingreso)
			$("#caja_ahorro").val(obj.caja_ahorro)
			$("#antiguedad_otros_ieu").val(obj.antiguedad_otros_ieu)
			$("#hrs_nocturnas").val(obj.hrs_nocturnas)
			$("#hrs_diurnas").val(obj.hrs_diurnas)
			$("#hrs_feriadas").val(obj.hrs_feriadas)
			$("#hrs_feriadas_nocturnas").val(obj.hrs_feriadas_nocturnas)
		}
	</script>
	<style type="text/css">
		@font-face {
		  font-family: 'Open Sans';
		  font-style: italic;
		  font-weight: 400;
		  src: url(../fonts/OpenSans-Light.ttf);
		}
		@font-face {
		  font-family: 'Roboto';
		  font-style: italic;
		  font-weight: 400;
		  src: url(../fonts/Roboto-LightItalic.ttf);
		}
		@font-face {
		  font-family: 'CaviarDreams';
		  font-style: italic;
		  font-weight: 400;
		  src: url(../fonts/CaviarDreams.ttf);
		}
		html,body{
			height: 100%;
			width: 100%;
		}
		.blanco{
			background-color: #F7F7F7
		}
		.block{
			display: block;
		}
		.btn{
			cursor: pointer;
		}
		.nopadding {
		   padding: 0 !important;
		   margin: 0 !important;
		}
		.lista .li{
			cursor: pointer;
			display: block;
		    width: 100%;
			text-align: left;
			padding: 20px; 
			font-family: "Open Sans";
			font-size: 1.5em;

		}
		.bg-oscuro,.lista .text-inactive:hover{
			background-color: #303436
		}

		.text-inactive{
			color: #B9B9B9;
		}
		.text-active{
			color: #171B21;
		}
		.divisor{
			display: block;
			height: 2px;
			background-color: #4F5457
		}
		.font-70x{
			font-size: 70px;
		}
		.font-30x{
			font-size: 30px;
		}

		.font-20x{
			font-size: 20px;
			
		}
		.num{
			padding: 18px;
			-moz-border-radius: 50%;
    		-webkit-border-radius: 50%;
    		border-radius: 50%;
		}
		.text-active .num{
			background-color: #DD3E00;
			color: white;
		}
		.text-inactive .num{
			border: 1px solid;
			background-color: transparent;

		}
		.btn-naranja{
			background-color: #DD3E00;

		}
		.btn-naranja:hover{
			background-color:#FF3F3F
		}
		.open-sans{
			font-family: "Open Sans";
		}
		.caviar-dreams{
			font-family: "CaviarDreams";
		}
		.roboto{
			font-family: "Roboto";
		}
		.padding-large{
			padding: 80px;
		}
		.section{
			margin-bottom: 50px;
		}
		.section-large{
			margin-bottom: 30px;
			margin-top: 30px;
		}

		.text-right{
			text-align: right;
		}
		.btn-tab{
			background-color: transparent;
			border-left: none;
			border-top: none;
			border-right: none;
			padding-left: 10px;
			padding-right: 10px;
			padding-bottom: 30px;
			cursor: pointer;
			border-color: #515151; 
			color: #515151; 
			border-radius: 0px;
		}
		.btn-inactive{
			color: #A8A8A8;
			border-color: #A8A8A8; 
		}
		.font-auto{
			font-size: 3em
		}
		tr{
			cursor: pointer;
		}
		.loader{
			transform: scale(2);
		}
		.escritor{
			background-color: #00FEEE;
			width: 10px;
			height: 20px;
			color: #00FEEE;
			margin: 0px
		}
		.notificacion{
			word-wrap: break-word;
		}
	</style>
</head>
<body>
	<div class="container-fluid h-100">
		<div class="row h-100">
			<div class="col blanco table-responsive padding-large open-sans">
			  <div class="row">
				  	<div class="col font-70x">
						<b><span class="text_write"></span></b>
						<span class="escritor" id="escritor">&nbsp;&nbsp;</span>
				  	</div>
			  </div>
			  <div class="row w3-section editando" style="display: none">
				  	<div class="col font-30x">
				  		Editando a: <span class="text-primary cedula_editando"></span>
				  	</div>
			  </div>
			  <div class="row w3-section">
				  	<div class="col">
				  		<div class="btn-group">
							<button type="submit" id="enviar_datos" title="agregar" class="btn btn-info btn-lg"><i class="fa fa-save"></i> Guardar información</button>
							<button type="button" class="btn btn-warning btn-lg" onclick="window.location='index.php'">Administrar personal</button>
						</div>
				  	</div>
			  </div>
			  <div class="row w3-section">
				  	<div class="col">
				  		<div class="alert alert-info notificacion font-70x" style="display: none"></div>
				  	</div>
			  </div>
			  <div class="row w3-section" id="form_trabajador">
					<div class="col">
						  	<div class="form-group">
						    	<label for="nombre">Nombres</label>
						    	<input type="text" maxlength="30" class="form-control form-control-lg validar_este" id="nombre" placeholder="Introduzca primer y segundo nombre">
						  	</div>
						  	
						  	<div class="form-group">
						    	<label for="apellido">Apellidos</label>
						   	 	<input type="text" class="form-control form-control-lg validar_este" maxlength="30" id="apellido" placeholder="Introduzca ambos apellidos">
						  	</div>
						  	<hr>
						  	<div class="form-group">
							    <label for="cedula">Cédula de identidad</label>
							    <input type="text" class="form-control form-control-lg validar_este" onKeyPress='return validar_cedula(event)' id="cedula" placeholder="Cédula de identidad" maxlength="8">
							</div>
							 
							 <div class="form-group">
						  		<label for="nacionalidad">Nacionalidad</label>
							  	 <select class="form-control form-control-lg validar_este" id="nacionalidad">
								    <option value="V">V</option>
								    <option value="E">E</option>
								</select>
						  	</div>
						  	<hr>
							<div class="form-group">
							    <label for="genero">Género</label>
							  	 <select class="form-control form-control-lg validar_este" id="genero">
								    <option value="Masculino">Masculino</option>
								    <option value="Femenino">Femenino</option>
								</select>
							</div>

							<div class="form-group">
							    <label for="fecha_nacimiento">Fecha de nacimiento</label>
							    <input type="date" maxlength="10" class="form-control form-control-lg validar_este" onKeyPress='return validar_fecha(event)' placeholder="Fecha de nacimiento" id="fecha_nacimiento" min="1930-01-01"  pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
							</div>
							<hr>
						  	<div class="form-group">
							    <label for="telefono_1">Teléfono móvil</label>
							    <input type="text" maxlength="15" class="form-control form-control-lg validar_este" onKeyPress='return validar_fecha(event)' id="telefono_1">
							</div>

							<div class="form-group">
							    <label for="telefono_2">Teléfono de casa</label>
							    <input type="text" maxlength="15" class="form-control form-control-lg validar_este" onKeyPress='return validar_fecha(event)' id="telefono_2">
							</div>
							<hr>
							<div class="form-group">
						    	<label for="correo">Dirección de correo electrónico</label>
						    	<input type="email" maxlength="30" class="form-control form-control-lg validar_este" id="correo" placeholder="Correo electrónico">
						    	
						 	</div>
						 	<div class="form-group">
							    <label for="cuenta_bancaria">Cuenta bancaria</label>
							    <input type="text" class="form-control form-control-lg validar_este" placeholder="Número de cuenta bancaria" onKeyPress='return validar_cedula(event)' maxlength="99" id="cuenta_bancaria">
							</div>

							<div class="form-group">
							    <label for="profesion">Profesión</label>
							    <input type="text" class="form-control form-control-lg validar_este" placeholder="Profesión" maxlength="50" id="profesion">
							</div>
							<div class="form-group">
							    <label for="departamento_adscrito">Departamento adscrito</label>
							    <input type="text" class="form-control form-control-lg validar_este" placeholder="Departamento adscrito" maxlength="50" id="departamento_adscrito">
							</div>
							<div class="form-group">
							    <label for="cargo_desempeñado_departamento">Cargo desempeñado en el departamento</label>
							    <input type="text" class="form-control form-control-lg validar_este" placeholder="Cargo desempeñado en el departamento" maxlength="50" id="cargo_desempeñado_departamento">
							</div>
					</div>
				  	<div class="col">
						  	<div class="form-group">
						    	<label for="estado">Estado</label>
							  	 <select class="form-control form-control-lg validar_este" id="estado">
							  	 	<option> -Seleccione- </option>
								    
								</select>
						  	</div>
						  	<div class="form-group">
						  		<label for="estatus">Estatus</label>
							  	 <select class="form-control form-control-lg validar_este" id="estatus">
							  	 	<option> -Seleccione- </option>
								    
								</select>
						  	</div>
						  	<div class="form-group">
							    <label for="grado_instruccion">Grado de intrucción</label>
							  	 <select class="form-control form-control-lg validar_este" id="grado_instruccion">
							  	 	<option> -Seleccione- </option>
								    
								</select>
							</div>
						  	<div class="form-group">
							    <label for="categoria">Categoría</label>
							  	 <select class="form-control form-control-lg validar_este" id="categoria">
							  	 	<option> -Seleccione- </option>
								    
								</select>
							</div>

							<div class="form-group">
							    <label for="dedicacion">Dedicación</label>
							  	 <select class="form-control form-control-lg validar_este" id="dedicacion" disabled>
						
								</select>
							</div>
							<div class="form-group">
						    	<label for="cargo">Cargo</label>
							  	 <select class="form-control form-control-lg validar_este" id="cargo" disabled>
							  	 
								</select>
						 	</div>	 
						 	<div class="form-group">
						    	<label for="fecha_ingreso">Fecha de ingreso</label>
						    	<input type="date" maxlength="10" class="form-control form-control-lg validar_este" id="fecha_ingreso" onKeyPress='return validar_fecha(event)' pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" placeholder="Fecha de ingreso a la institución">
						    	
						 	</div>
						 	<div class="form-group">
						  		<label for="caja_ahorro">¿Aplica caja de ahorro?</label>
							  	 <select class="form-control form-control-lg validar_este" id="caja_ahorro" style="width: 30%">
								    <option value="no">No</option>
								    <option value="si">Si</option>
								</select>
						  	</div>
						  	<div class="form-group">
							    <label for="antiguedad_otros_ieu">Años en otros Institutos de educación universitaria</label>
							    <input type="number" min="0" value="0" max="80" maxlength="3"  class="form-control form-control-lg validar_este" placeholder="Años en otros IEU" onKeyPress='return validar_cedula(event)' id="antiguedad_otros_ieu">
							</div>
							<hr>
							<div class="form-group">
							    <label for="hrs_nocturnas">Horas extras nocturnas <strong>mensuales</strong></label>
							    <input type="number" min="0" value="0" max="80" maxlength="3"  class="form-control form-control-lg validar_este" placeholder="Horas por munsuales" onKeyPress='return validar_cedula(event)' id="hrs_nocturnas">
							</div>
							<div class="form-group">
							    <label for="hrs_diurnas">Horas extras diurnas <strong>mensuales</strong></label>
							    <input type="number" min="0" value="0" max="80" maxlength="3"  class="form-control form-control-lg validar_este" placeholder="Horas por munsuales" onKeyPress='return validar_cedula(event)'  id="hrs_diurnas">
							</div>
							<div class="form-group">
							    <label for="hrs_feriadas">Horas extras feriadas <strong>mensuales</strong></label>
							    <input type="number" min="0" value="0" max="80" maxlength="3"  class="form-control form-control-lg validar_este" placeholder="Horas por munsuales" onKeyPress='return validar_cedula(event)' id="hrs_feriadas">
							</div>
							<div class="form-group">
							    <label for="hrs_feriadas_nocturnas">Horas extras feriadas-nocturnas <strong>mensuales</strong></label>
							    <input type="number" min="0" value="0" max="80" maxlength="3"  class="form-control form-control-lg validar_este" placeholder="Horas por munsuales" onKeyPress='return validar_cedula(event)' id="hrs_feriadas_nocturnas">
							</div>
					</div>
			  </div>
			  <div id="form_hijos" class="row w3-section">
				  <div class="col">
						<div class="w3-center">
							<h1>
								Agregar hijos 
								<button class="btn btn-outline-success btn-lg" type="button" id="agregar_nuevo_hijo"><i class="fa fa-plus"></i></button>
							</h1>
						</div>
					  	<table class='w3-table table-bordered table'>
					  		<thead>
						  		<tr>
						  			<th>Id</th>
						  			<th>Nombres</th>
						  			<th>Apellidos</th>
						  			<th>Fecha de nacimiento</th>
						  			<th>¿Es estudiante?</th>
						  			<th>¿Tiene alguna discapacidad?</th>
						  			<th>Cancelar</th>
						  		</tr>
					  		</thead>
					  		<tbody id="tabla_hijos_trabajador"></tbody>
					  	</table>
				  </div>
			  </div>
			</div>
		</div>
	</div>
</body>
</html>
