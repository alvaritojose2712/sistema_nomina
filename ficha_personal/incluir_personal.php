<?php 
	session_start();
	include '../conexion_bd.php'; 
	$valores = (new sql("valores_globales","WHERE id='1'"))->select()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title> .: Incluir personal </title>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/w3.css">
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
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
			}function validar_cedula(e){
				tecla=(document.all) ? e.keyCode: e.which;
				if (tecla == 8) return true;
				patron =/[0-9]/;
				te=String.fromCharCode(tecla);
				return patron.test(te);
			}
		</script>
		<script type="text/javascript">
			
			
			var cat_car_dedic = <?php echo $valores['cat_car_dedic']; ?>;
			var estado = <?php echo $valores['estado']; ?>;
			var estatus = <?php echo $valores['estatus']; ?>;
			var grado_instruccion = <?php echo $valores['grado_instruccion']; ?>;
			//Validar cargo y dedicación
			$(document).ready(function(){
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
			});

			
			$(document).ready(function(){
				$("#enviar_datos").click(function(){
					var validar_select = true;
					var inputs_select = $("#form_trabajador").find('select').toArray();
					for(i in inputs_select){
						if($(inputs_select[i]).val()=="-Seleccione-" || $(inputs_select[i]).val()==null || $(inputs_select[i]).val()==""){
							validar_select = false;
							alert('Campo inválido: <i class="fa fa-exclamation-triangle"></i> '+$(inputs_select[i]).siblings('label').text())
							break;
						}
					}

					var validar_input = true;
					var inputs_text = $("#form_trabajador").find('input[type!="radio"]').toArray();
					for(i in inputs_text){
						if($(inputs_text[i]).val()=="-Seleccione-" || $(inputs_text[i]).val()==null || $(inputs_text[i]).val()==""){
							validar_input = false;
							alert('Campo inválido: <i class="fa fa-exclamation-triangle"></i> '+$(inputs_text[i]).siblings('label').text())
							break;
						}
					}


					var inputs_text_hijos = $("#form_hijos").find('input,select').toArray();
					var insert_hijos = "";
					for(i in inputs_text_hijos){
						if($(inputs_text_hijos[i]).val()==""){
							validar_input = false;
							alert('Campo inválido: '+$(inputs_text_hijos[i]).attr('class'))
							break;
						}else{
							if ($(inputs_text_hijos[i]).attr('class')=="nombre_nuevo") {
								insert_hijos+="("
							}
							if ($(inputs_text_hijos[i]).attr('class')=="fecha_nacimiento_nuevo") {
								insert_hijos+="'"+$("#cedula").val()+"',";
							}
							insert_hijos+="'"+$(inputs_text_hijos[i]).val()+"',";
							if ($(inputs_text_hijos[i]).attr('class')=="discapacidad_nuevo") {
								insert_hijos=insert_hijos.slice(0,-1);
								insert_hijos+="),";
							}
						}
						
					}
					insert_hijos=insert_hijos.slice(1,-2);
					
					
					if (validar_select==true && validar_input==true) {

						var json_campos = {};

						for(i in inputs_select){
							json_campos[$(inputs_select[i]).attr('id')]=$(inputs_select[i]).val();		
						}							
						
						for(i in inputs_text){
							json_campos[$(inputs_text[i]).attr('id')]=$(inputs_text[i]).val();																	
						}

						json_campos['genero']=$('[name=genero]:checked').val();	
						json_campos['operacion']='agregar';	
						json_campos['insert_hijos']=insert_hijos;
						
						$.ajax({
						    url:"procesar_ficha.php",
						    data:json_campos,
						    type:"post",
						   
						    success:function(response)
						    {
						        alert(response);
								
						    }
						}); 	
					}
				});
			});	
			$(document).ready(function() {
				$("#agregar_nuevo_hijo").click(function() {
					$("#tabla_hijos_trabajador").append("<tr><td><input type='text' class='nombre_nuevo' maxlength='30' placeholder='Nombres'/></td><td><input type='text' class='apellido_nuevo' maxlength='30' placeholder='Apellidos'/></td><td><input type='date' class='fecha_nacimiento_nuevo' maxlength='30' placeholder='Fecha de nacimiento'/></td><td><select class='estudia_nuevo'><option value='no'>No</option><option value='si'>Si</option></select></td><td><select class='discapacidad_nuevo'><option value='no'>No</option><option value='si'>Si</option></select></td><td><div style='width:100%' onclick=$(this).parents('tr').remove() class='w3-button w3-red'><i class='fa fa-window-close-o' aria-hidden='true'></i></div></td></tr>");
				});
			});
		</script>
		<style type="text/css">
			
			@font-face {
			  font-family: 'Open Sans';
			  font-style: italic;
			  font-weight: 400;
			  src: url(../fonts/OpenSans-Regular.ttf);
			}
			html,body{
				font-family: 'Open Sans', sans-serif;
				font-size: 18px;
				padding: 10px;
				height: 100%;
				width: 100%;
			}
		</style>
</head>
<body>
	<center><header class="header w3-header"><h1>Agregar personal a la Ficha</h1></header></center>

	<form>
	  <h1>
	  	<header>
	  		<button type="submit" id="enviar_datos" onclick="return false" class="btn btn-primary header w3-header">Guardar</button>
	  	</header>
	  </h1>
	  <div id="form_trabajador" class="row">
		  <aside class="col">

			  <div class="col">
				  	<div class="form-group">
				    	<label for="nombre">Nombres</label>
				    	<input type="text" maxlength="30" class="form-control" id="nombre" placeholder="Introduzca primer y segundo nombre" required>
				  	</div>
				  	
				  	<div class="form-group">
				    	<label for="apellido">Apellidos</label>
				   	 	<input type="text" class="form-control" maxlength="30" id="apellido" placeholder="Introduzca ambos apellidos" required>
				  	</div>
				  	<hr>
				  	<div class="form-group">
					    <label for="cedula">Cédula de identidad</label>
					    <input type="text" class="form-control" onKeyPress='return validar_cedula(event)' id="cedula" placeholder="Cédula de identidad" maxlength="8" required>
					</div>
					 
					 <div class="form-group">
				  		<label for="nacionalidad">Nacionalidad</label>
					  	 <select class="form-control" id="nacionalidad" style="width: 10%">
						    <option value="V">V</option>
						    <option value="E">E</option>
						</select>
				  	</div>
				  	<hr>
					<div class="form-group">
					    <label for="">Género</label><br>
					    <input type="radio" name="genero" class="w3-radio" value="Masculino" checked> Masculino <br>
					    <input type="radio" name="genero" class="w3-radio" value="Femenino"> Femenino 
					</div>

					<div class="form-group">
					    <label for="fecha_nacimiento">Fecha de nacimiento</label>
					    <input type="date" maxlength="10" class="form-control" onKeyPress='return validar_fecha(event)' placeholder="Fecha de nacimiento" id="fecha_nacimiento" min="1980-01-01" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
					</div>
					<hr>
				  	<div class="form-group">
					    <label for="telefono_1">Teléfono móvil</label>
					    <input type="text" maxlength="15" class="form-control" onKeyPress='return validar_fecha(event)'  id="telefono_1" required>
					</div>

					<div class="form-group">
					    <label for="telefono_2">Teléfono de casa</label>
					    <input type="text" maxlength="15" class="form-control" onKeyPress='return validar_fecha(event)'  id="telefono_2" required>
					</div>
					<hr>
					<div class="form-group">
				    	<label for="correo">Dirección de correo electrónico</label>
				    	<input type="email" maxlength="30" class="form-control" id="correo" placeholder="Correo electrónico" required>
				    	<small class="form-text text-muted">Nunca se compartirá su correo electrónico.</small>
				 	</div>
				 	<div class="form-group">
					    <label for="cuenta_bancaria">Cuenta bancaria</label>
					    <input type="text"  class="form-control" placeholder="Número de cuenta bancaria" onKeyPress='return validar_cedula(event)' maxlength="99" id="cuenta_bancaria" required>
					</div>

					<div class="form-group">
					    <label for="profesion">Profesión</label>
					    <input type="text"  class="form-control" placeholder="Profesión" maxlength="50" id="profesion" required>
					</div>
					<div class="form-group">
					    <label for="departamento_adscrito">Departamento adscrito</label>
					    <input type="text"  class="form-control" placeholder="Departamento adscrito" maxlength="50" id="departamento_adscrito" required>
					</div>
					<div class="form-group">
					    <label for="cargo_desempeñado_departamento">Cargo desempeñado en el departamento</label>
					    <input type="text"  class="form-control" placeholder="Cargo desempeñado en el departamento" maxlength="50" id="cargo_desempeñado_departamento" required>
					</div>
					
			  </div>
		  </aside>
		 
		  <aside class="col">
		  	 <div class="col">
				  	<div class="form-group">
				    	<label for="estado">Estado</label>
					  	 <select class="form-control" id="estado">
					  	 	<option> -Seleccione- </option>
						    
						</select>
				  	</div>
				  	<div class="form-group">
				  		<label for="estatus">Estatus</label>
					  	 <select class="form-control" id="estatus">
					  	 	<option> -Seleccione- </option>
						    
						</select>
				  	</div>
				  	<div class="form-group">
					    <label for="grado_instruccion">Grado de intrucción</label>
					  	 <select class="form-control" id="grado_instruccion">
					  	 	<option> -Seleccione- </option>
						    
						</select>
					</div>
				  	<div class="form-group">
					    <label for="categoria">Categoría</label>
					  	 <select class="form-control" id="categoria">
					  	 	<option> -Seleccione- </option>
						    
						</select>
					</div>

					<div class="form-group">
					    <label for="dedicacion">Dedicación</label>
					  	 <select class="form-control" disabled="" id="dedicacion">
				
						</select>
					</div>
					<div class="form-group">
				    	<label for="cargo">Cargo</label>
					  	 <select class="form-control" disabled="" id="cargo">
					  	 
						</select>
				 	</div>	 
				 	<div class="form-group">
				    	<label for="fecha_ingreso">Fecha de ingreso</label>
				    	<input type="date" maxlength="10" class="form-control" id="fecha_ingreso" onKeyPress='return validar_fecha(event)' required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" placeholder="Fecha de ingreso">
				    	
				 	</div>
				 	<div class="form-group">
				  		<label for="caja_ahorro">¿Aplica caja de ahorro?</label>
					  	 <select class="form-control" id="caja_ahorro" style="width: 30%">
						    <option value="no">No</option>
						    <option value="si">Si</option>
						</select>
				  	</div>
				  	<div class="form-group">
					    <label for="antiguedad_otros_ieu">Años en otros Institutos de educación universitaria</label>
					    <input type="number" min="0" value="0" max="80" maxlength="3"  class="form-control" placeholder="Años en otros IEU" onKeyPress='return validar_cedula(event)'  id="antiguedad_otros_ieu">
					</div>
					<hr>
					<div class="form-group">
					    <label for="hrs_nocturnas">Horas extras nocturnas <strong>mensuales</strong></label>
					    <input type="number" min="0" value="0" max="80" maxlength="3"  class="form-control" placeholder="Horas por munsuales" onKeyPress='return validar_cedula(event)'  id="hrs_nocturnas">
					</div>
					<div class="form-group">
					    <label for="hrs_diurnas">Horas extras diurnas <strong>mensuales</strong></label>
					    <input type="number" min="0" value="0" max="80" maxlength="3"  class="form-control" placeholder="Horas por munsuales" onKeyPress='return validar_cedula(event)'  id="hrs_diurnas">
					</div>
					<div class="form-group">
					    <label for="hrs_feriadas">Horas extras feriadas <strong>mensuales</strong></label>
					    <input type="number" min="0" value="0" max="80" maxlength="3"  class="form-control" placeholder="Horas por munsuales" onKeyPress='return validar_cedula(event)'  id="hrs_feriadas">
					</div>
					<div class="form-group">
					    <label for="hrs_feriadas_nocturnas">Horas extras feriadas-nocturnas <strong>mensuales</strong></label>
					    <input type="number" min="0" value="0" max="80" maxlength="3"  class="form-control" placeholder="Horas por munsuales" onKeyPress='return validar_cedula(event)'  id="hrs_feriadas_nocturnas">
					</div>
			  </div>
		  </aside>
	  </div>
	  <hr>
	  <aside id="form_hijos" class="row" style="margin-bottom: 100px;">
		  <div class="col">
				<header class="header w3-header"><center><h1>Agregar hijos al trabajador</h1></center></header>
	 		
				<div style="width: 50%">	
					<button class="w3-button w3-green " style="float: right;" onclick="return false;" id="agregar_nuevo_hijo">+</button>
				</div>
			  	<table class='w3-table table-bordered table' style="margin-bottom: 100px;margin-top: 20px;">
			  		<thead>
				  		<tr>
				  			<th width="18%">Nombres</th>
				  			<th width="18%">Apellidos</th>
				  			<th width="18%">Fecha de nacimiento</th>
				  			<th width="18%">¿Es estudiante?</th>
				  			<th width="18%">¿Tiene alguna discapacidad?</th>
				  			<th width="10%">Cancelar</th>
				  		</tr>
			  		</thead>
			  		<tbody id="tabla_hijos_trabajador"></tbody>
			  	</table>
		  </div>
	  </aside>
	</form>

</body>
</html>
