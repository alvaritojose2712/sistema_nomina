<?php 
	session_start();
	include '../conexion_bd.php'; 
	$valores = (new sql("valores_globales","WHERE id='1'"))->select()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title> .: Buscar personal :. </title>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/w3.css">
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
		<script src="../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../css/bootstrap/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var cat_car_dedic = <?php echo $valores['cat_car_dedic']; ?>;

			var estado = <?php echo $valores['estado']; ?>;
			var estatus = <?php echo $valores['estatus']; ?>;
			var grado_instruccion = <?php echo $valores['grado_instruccion']; ?>;
			
			function validar_categoria() {
					if ($("#categoria").val()!="-Seleccione-") {
						
						var cargo = cat_car_dedic[$("#categoria").val()].cargo;
						var dedicacion = cat_car_dedic[$("#categoria").val()].dedicacion;
						
						$("#dedicacion").attr("disabled",false).empty();
						$("#cargo").attr("disabled",false).empty();
						

						for(i in cargo){						
							$("#cargo").append("<option value='"+cargo[i]+"'>"+cargo[i]+"</option>")
						}

						for(i in dedicacion){	
							$("#dedicacion").append("<option value='"+dedicacion[i]+"'>"+dedicacion[i]+"</option>")
						}
							
					}else{
						$("#cargo")
						.empty()
						.attr("disabled",true);
						$("#dedicacion")
						.empty()
						.attr("disabled",true);
						
					}
			}
			function buscar() {
				$.ajax({
						url:"procesar_ficha.php",
						data:{buscar:$("#buscar").val(),"operacion":"buscar"},
						type:"post",
						datatype:"json",
						success:function(data){
							//alert(data);
							$("#resultados_buscar").empty();
							objeto = JSON.parse(data);
							
							for(i in objeto){
								$("#resultados_buscar").append("<tr><td>"+objeto[i]['Id']+"</td><td>"+objeto[i]['Cédula']+"</td><td>"+objeto[i]['Nombres']+"</td><td><div style='float:left;width:80%'>"+objeto[i]['Apellidos']+"</div><div style='float:right;'><button class='w3-button w3-teal' style='float:left' onclick=ver_mas("+i+")><i class='fa fa-eye' aria-hidden='true'></i></button><button onclick='editar("+i+")' style='float:left' class='w3-button w3-green'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button><button onclick='eliminar("+i+")' style='float:left' class='w3-button w3-red'><i class='fa fa-trash-o' aria-hidden='true'></i></button></div></td></tr>");
							}
						}
					});
			}
			$(document).ready(function () {
				$("#buscar").keyup(buscar);
			});
			
			function ver_mas(indice){
				var obj = this.objeto[indice];
				$("#ver_mas_datos").empty();
				$('#ver_mas').css({'display':'block'});

				var html = "<table class='table table-bordered'>";
				for(i in obj){
					if (i!="hijos") {
						html += "<tr><th>"+i+"</th><td>"+obj[i]+"</td></tr>";
					}
				}
				html += "</table>";
				$("#ver_mas_datos").append(html);

				
				var obj_hijos = this.objeto[indice]['hijos'];
				html="<hr><header><center><h3>Hijos del trabajador</h3></center></header><table class='w3-table table-bordered' style='width:100%'><thead><tr><th>Id</th><th>Nombre</th><th>Apellido</th><th>Fecha de nacimiento</th><th>¿Estudia?</th><th>¿Es discapacitado?</th></tr></thead><tbody>";
				
				for(ii in obj_hijos){		

					html+="<tr>";
					for(i in obj_hijos[ii]){
						html += "<td>"+obj_hijos[ii][i]+"</td>";
					}
					html+="<tr>";

					
				}
				html += "</tbody></table>";
					$("#ver_mas_datos").append(html);
				
			}
			function editar(indice) {
				
				$('#categoria').val(this.objeto[indice]['Categoría']);
				validar_categoria();
				$("#modal_editar").css({'display':'block'});
				$('#Id').val(this.objeto[indice]['Id']);               
				$('#estado').val(this.objeto[indice]['Estado']);               
				$('#nombre').val(this.objeto[indice]['Nombres']);                 
				$('#apellido').val(this.objeto[indice]['Apellidos']);               
				$('#cedula').val(this.objeto[indice]['Cédula']);                
				$('#nacionalidad').val(this.objeto[indice]['Nacionalidad']);          
				$('#genero').val(this.objeto[indice]['Genero']);                 
				$('#fecha_nacimiento').val(this.objeto[indice]['Fecha nacimiento']);       
				$('#telefono_1').val(this.objeto[indice]['Teléfono 1']);             
				$('#telefono_2').val(this.objeto[indice]['Teléfono 2']);            
				$('#correo').val(this.objeto[indice]['Correo electrónico']);
				$('#profesion').val(this.objeto[indice]['Profesión']);                
				$('#departamento_adscrito').val(this.objeto[indice]['Departamento adscrito']);                
				$('#cargo_desempeñado_departamento').val(this.objeto[indice]['Cargo desempeñado en el departamento']);                
				$('#estatus').val(this.objeto[indice]['Estatus']);                
				$('#fecha_ingreso').val(this.objeto[indice]['Fecha de ingreso']);         
				$('#grado_instruccion').val(this.objeto[indice]['Grado de instrucción']);     
				             
				$('#dedicacion').val(this.objeto[indice]['Dedicación']);            
				$('#caja_ahorro').val(this.objeto[indice]['Caja de ahorro']);           
				$('#cargo').val(this.objeto[indice]['Cargo']);                  
				$('#cuenta_bancaria').val(this.objeto[indice]['Cuenta bancaria']);        
				$('#antiguedad_otros_ieu').val(this.objeto[indice]['Antiguedad en otros IEU']);   
				$('#hrs_nocturnas').val(this.objeto[indice]['Horas extras nocturnas']);          
				$('#hrs_feriadas').val(this.objeto[indice]['Horas extras feriadas']);           
				$('#hrs_diurnas').val(this.objeto[indice]['Horas extras diurnas']);            
				$('#hrs_feriadas_nocturnas').val(this.objeto[indice]['Horas extras feriadas-nocturnas']);
				
				var objeto_hijos = this.objeto[indice]['hijos'];
				$("#tabla_hijos_trabajador").empty();
				for(i in objeto_hijos){
					var si_estu = ""
					if (objeto_hijos[i]['Estudia']=="si") {
						si_estu="selected";
					}
					var si_disca = ""

					if (objeto_hijos[i]['Discapacidad']=="si") {
						si_disca="selected";
					}
					$("#tabla_hijos_trabajador").append("<tr><td><input disabled='' type='text' class='id_nuevo'  value='"+objeto_hijos[i]['Id']+"' /></td><td><input type='text' maxlength='20' class='nombre_nuevo' value='"+objeto_hijos[i]['Nombre']+"' /></td><td><input type='text' maxlength='20' class='apellido_nuevo' value='"+objeto_hijos[i]['Apellido']+"' /></td><td><input type='date' class='fecha_nacimiento_nuevo' value='"+objeto_hijos[i]['Fecha de nacimiento']+"' /></td><td><select class='estudia_nuevo' ><option value='no'>No</option><option value='si' "+si_estu+">Si</option></select></td><td><select class='discapacidad_nuevo' ><option value='no'>No</option><option value='si' "+si_disca+">Si</option></select></td><td><div style='width:100%' onclick=if(window.confirm('¿Realmente_desea_eliminar_a_este_hijo_de_la_ficha?')){$(this).parents('tr').remove()} class='w3-button w3-red'><i class='fa fa-window-close-o' aria-hidden='true'></i></div></td></tr>");
				}
			}
			function eliminar(indice) {
				
				var confirm = window.confirm("¿Realmente desea eliminar la ficha de "+this.objeto[indice]['Nombres']+" "+this.objeto[indice]['Apellidos']+" con todo el grupo familiar asociado ?");
				if (confirm) {
					$.ajax({
						url:"procesar_ficha.php",	
						data:{"cedula":this.objeto[indice]['Cédula'],"operacion":"eliminar"},
						type:"post",
						success:function(data){
							alert(data);
							buscar();
						}
					});
				}
			}
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
			$(document).ready(function(){
					$("#categoria").change(validar_categoria);
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
					$("#enviar_datos").click(function(){
						var validar_select = true;
						var inputs_select = $("#form_trabajador").find('select').toArray();
						for(i in inputs_select){
							if($(inputs_select[i]).val()=="-Seleccione-" || $(inputs_select[i]).val()==null || $(inputs_select[i]).val()==""){
								validar_select = false;
								alert('Campo inválido: '+$(inputs_select[i]).siblings('label').text())
								break;
							}
						}

						var validar_input = true;
						var inputs_text = $("#form_trabajador").find('input[type!="radio"]').toArray();
						for(i in inputs_text){
							if($(inputs_text[i]).val()=="-Seleccione-" || $(inputs_text[i]).val()==null || $(inputs_text[i]).val()==""){
								validar_input = false;
								alert('Campo inválido: '+$(inputs_text[i]).siblings('label').text())
								break;
							}
						}

						var tr = $("#tabla_hijos_trabajador").find("tr").toArray();
						var json_tr_hijos = {};
						for(i in tr){
							var tr_actual = $(tr[i]).find("input,select").toArray();
							json_tr_hijos[i]={};
							for(ii in tr_actual){
								if($(tr_actual[ii]).val()==""){
									validar_input = false;
									alert('Campo inválido en hijos del trabajador: '+$(tr_actual[ii]).attr('class').replace("_nuevo",""))
									break;
								}else{
									json_tr_hijos[i][$(tr_actual[ii]).attr('class').replace("_nuevo","")]=$(tr_actual[ii]).val();
								}
							} 
							
						}
						

						if (validar_select==true && validar_input==true) {

							var json_campos = {};

							for(i in inputs_select){
								json_campos[$(inputs_select[i]).attr('id')]=$(inputs_select[i]).val();		
							}							
							
							for(i in inputs_text){
								json_campos[$(inputs_text[i]).attr('id')]=$(inputs_text[i]).val();																	
							}

							
							json_campos['operacion']='editar';	
							json_campos['hijos']=json_tr_hijos;	
							
							
							$.ajax({
							    url:"procesar_ficha.php",
							    data:json_campos,
							    type:"post",
							   
							    success:function(response)
							    {
							        alert(response);
							        buscar();
									
							    }
							}); 

							
						}
					});	

					$("#agregar_nuevo_hijo").click(function() {
						$("#tabla_hijos_trabajador").append("<tr><td><input type='text' class='id_nuevo' value='agregar' disabled/></td><td><input type='text' class='nombre_nuevo' maxlength='30' placeholder='Nombres'/></td><td><input type='text' class='apellido_nuevo' maxlength='30' placeholder='Apellidos'/></td><td><input type='date' class='fecha_nacimiento_nuevo' maxlength='30' placeholder='Fecha de nacimiento'/></td><td><select class='estudia_nuevo'><option value='no'>No</option><option value='si'>Si</option></select></td><td><select class='discapacidad_nuevo'><option value='no'>No</option><option value='si'>Si</option></select></td><td><div style='width:100%' onclick=$(this).parents('tr').remove() class='w3-button w3-red'><i class='fa fa-window-close-o' aria-hidden='true'></i></div></td></tr>");
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
				zoom: 0.90;
				height: 100%;
				width: 100%;
			}
			aside{
				width: 50%;
				float: left;
				padding: 20px;
			}
		</style>
</head>
<body onload="buscar()">
		<div class="w3-container">
			<center>
				<header>
					<h1>Buscar personal en la ficha</h1>
				</header>
			</center>

        	<input type="text" class="w3-input w3-animate-input" placeholder="Buscar por Nombre, Apellido o Cédula" id="buscar">
			<table class='table table-bordered'>
				<thead>
					<tr>
						<th width='50'>Id</th>
						<th width='50'>Cédula de identidad</th>		
						<th width='50'>Nombres</th>
						<th width='50'>Apellidos</th>
					</tr>
				</thead>
				<tbody id="resultados_buscar">
				</tbody>
			</table>
		</div>	

		<div id="ver_mas" class="w3-modal w3-display-topmiddle bg-inverse bg-faded text-white" style="overflow:auto;width: 60%;padding: 20px">
			<div class="row">
				<div class="col">
					<center>
						<button class="btn btn-danger" onclick="$('#ver_mas').css({'display':'none'})">
				  			<i class="fa fa-window-close" aria-hidden="true"></i>
						</button>
					</center>
				</div>
			</div>
			<div class="row">
				<div id="ver_mas_datos" class="col"></div>
			</div>
						      
	  	</div>		

	  	<div style="display: none;z-index: 3;width: 80%;padding: 20px" id="modal_editar" class="w3-modal w3-card-4 w3-white w3-display-topmiddle">
	  		<div class="row" >
			  	<div class="col">
			  		<center>
			  			<button class="btn btn-danger" onclick="$('#modal_editar').css({'display':'none'})">
			  				<i class="fa fa-window-close" aria-hidden="true"></i>
			  			</button>	
			  		</center>		
			  	</div>
			</div>
	  		<form class="row">
				<div class="col">
					<button type="submit" id="enviar_datos" onclick="return false" class="btn btn-success">Guardar</button>
					  <div class="row" id="form_trabajador">
						  <aside class="col">
								  	<div class="form-group">
								    	<label for="nombre">Nombres</label>
								    	<input type="text" maxlength="30" class="form-control" id="nombre" placeholder="Introduzca primer y segundo nombre" required>
								  	</div>
								  	<hr>
								  	<div class="form-group">
								    	<label for="apellido">Apellidos</label>
								   	 	<input type="text" class="form-control" maxlength="30" id="apellido" placeholder="Introduzca ambos apellidos" required>
								  	</div>
								  	<hr>
								  	<div class="form-group">
									    <label for="cedula">Cédula de identidad</label>
									    <input type="text" class="form-control" onKeyPress='return validar_cedula(event)' id="cedula" placeholder="Cédula de identidad" maxlength="8" required>
									</div>
									 <hr>
								  	<div class="form-group">
								  		<label for="nacionalidad">Nacionalidad</label>
									  	 <select class="form-control" id="nacionalidad" style="width: 30%">
										    <option value="V">V</option>
										    <option value="E">E</option>
										</select>
								  	</div>
								  	<hr>
								  	
									<div class="form-group">
									    <label for="">Género</label><br>
									    <select id="genero" class="form-control">
									    	<option value="Masculino">Masculino</option>
									    	<option value="Femenino">Femenino</option>
									    </select>
									</div>

									<div class="form-group">
									    <label for="fecha_nacimiento">Fecha de nacimiento</label>
									    <input type="date" maxlength="10" class="form-control" onKeyPress='return validar_fecha(event)' placeholder="Fecha de nacimiento" id="fecha_nacimiento" min="1980-01-01" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
									</div>
									<hr>
									<div class="form-group">
									    <label for="cuenta_bancaria">Cuenta bancaria</label>
									    <input type="text"  class="form-control" placeholder="Número de cuenta bancaria" onKeyPress='return validar_cedula(event)' maxlength="99" id="cuenta_bancaria" required>
									</div>
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
						  </aside>			 
						  <aside class="col">
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
									  	 <select class="form-control" id="dedicacion">
								
										</select>
									</div>
									<div class="form-group">
								    	<label for="cargo">Cargo</label>
									  	 <select class="form-control" id="cargo">
									  	 
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
									<div style="display: none">
										<input type="text" id="Id">
									</div>
						  </aside>
					  </div>
					  <div id="form_hijos">
					  	<header class="header w3-header"><center><h1>Hijos del trabajador</h1></center></header>
			 		
						<div style="width: 50%">	
							<button class="w3-button w3-green " style="float: right;" onclick="return false;" id="agregar_nuevo_hijo">+</button>
						</div>
					  	<table class='w3-table table-bordered table' style="margin-bottom: 100px;margin-top: 20px;">
					  		<thead>
						  		<tr>
						  			<th width="18%">Id</th>
						  			<th width="18%">Nombres</th>
						  			<th width="18%">Apellidos</th>
						  			<th width="18%">Fecha de nacimiento</th>
						  			<th width="18%">¿Es estudiante?</th>
						  			<th width="18%">¿Tiene alguna discapacidad?</th>
						  			<th width="10%">Borrar</th>
						  		</tr>
					  		</thead>
					  		<tbody id="tabla_hijos_trabajador"></tbody>
					  	</table>
					  </div>
				</div>
			</form>
	  	</div>	
				
</body>
</html>
