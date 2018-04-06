<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title> .: Administrar usuarios :. </title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" type="text/css" href="../css/w3.css">
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
		<script type="text/javascript" src="../js/formato_moneda.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script src="../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../css/bootstrap/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			function buscar() {
				$.ajax({
						url:"usuarios.php",
						data:{buscar:$("#buscar").val(),"operacion":"buscar"},
						type:"post",
						datatype:"json",
						success:function(data){
							
							$("#resultados_buscar").empty();
							var objeto = JSON.parse(data);
							objeto.forEach(function(elemento,indice){
								$("#resultados_buscar").append("<tr><div class='usuario'><td><input style='border-width: 0px;pointer-events:none;' size='3' type='text' value='"+elemento['id']+"' /></td><td><input type='text' class='inactive nombre_input' value='"+elemento['nombre']+"' /></td><td><input type='text' class='inactive apellido_input' value='"+elemento['apellido']+"' /></td><td><input type='text' class='inactive usuario_input' value='"+elemento['usuario']+"' /></td><td><input type='text' class='inactive clave_input' size='3' value='*'  /></td><td><input type='text' class='inactive departamento_input'  value='"+elemento['departamento']+"' /></td><td><input type='text' class='inactive permiso_input'  onkeyup='validar_palabras(this)' value='"+elemento['permiso']+"' /></td><td><div><button style='width:50%' onclick=editar(this,'"+elemento['id']+"') class='w3-button '><i class='fa fa-cog' aria-hidden='true'></i></button><button style='width:50%' onclick=eliminar('"+elemento['id']+"') class='w3-button w3-red'><i class='fa fa-window-close-o' aria-hidden='true'></i></button></div></td></div></tr>");
							});
							var inac = $(".inactive").toArray()

							for(i in inac){
								inac[i].style.width = ((inac[i].value.length + 1) * 8) + 'px'
							}
						}
					});
			}
			$(document).ready(function () {
				$("#buscar").keyup(buscar);
				buscar()
				$("#add").click(function() {
					$("#resultados_buscar").append("<tr><td></td><td><input type='text' class='nombre_nuevo' maxlength='30' placeholder='Nombres'/></td><td><input type='text' class='apellido_nuevo' maxlength='30' placeholder='Apellidos'/></td><td><input type='text' class='usuario_nuevo' maxlength='30' placeholder='Usuario'/></td><td><input type='password' class='clave_nuevo' maxlength='30'  placeholder='Clave'/></td><td><input type='text' class='departamento_nuevo' maxlength='30' placeholder='Departamento'/></td><td><input type='text' class='permiso_nuevo' maxlength='15' placeholder='Permiso' onkeyup='validar_palabras(this)' /></td><td><div><button style='width:50%' onclick=guardar(this) class='w3-button w3-green'><i class='fa fa-check-square' aria-hidden='true'></i></button><button style='width:50%' onclick=$(this).parents('tr').remove() class='w3-button w3-red'><i class='fa fa-window-close-o' aria-hidden='true'></i></button></div></td></tr>");
				});
				
			});
			function eliminar(id){
				var confirm = window.confirm("¿Realmente desea eliminar el usuario "+id+" ?");
				if (confirm) {
					$.ajax({
						url:"usuarios.php",
						data:{"id":id,"operacion":"eliminar"},
						type:"post",
						success:function(data){
							alert(data);
							buscar();
						}
					});
				}
			}
			function editar(this_all,id){
				$(this_all).parents('tr').find('td').css({'display':'none'});
				$(this_all).parents('tr').append("<td colspan=7><center><input class='w3-input' style='width:30%' type='text' placeholder='Escriba la clave actual para este usuario'/><span></span><br><button class='w3-button w3-green' onclick='comprobar(this)' id='listo'>Esta es</button><button class='w3-button w3-red' id='cancelar' onclick=$(this).parents('tr').find('td').css({'display':''});$(this).parents('td').remove();>No me la sé</button></center></td>")
			}
			function comprobar(this_all) {
				var input_clave = $(this_all).siblings('input').val();
				var input_usuario = $(this_all).parents('tr').find('td:eq(3)').children().val();
				$.ajax({
						url:"usuarios.php",
						data:{"usuario":input_usuario,"clave":input_clave,"operacion":"comprobar"},
						type:"post",
						datatype:"json",
						success:function(data){
							var obj = JSON.parse(data);
							$(this_all).siblings('span').empty();
							if (obj['estado']=="exito") {
								
								$(this_all).parents('tr').find('td').css({'display':''});
								$(this_all).parents('tr').find('td:eq(7)').find('div').css({'display':'none'});
								$(this_all).parents('tr').find('td:eq(7)').append("<button style='width:50%' onclick=actualizar_datos($(this).parents('tr').find('td:eq(0)').find('input').val(),this) class='w3-button w3-green'><i class='fa fa-check-square' aria-hidden='true'></i></button><button style='width:50%' onclick=reponer(this,$(this).parents('tr').find('td:eq(0)').find('input').val()); class='w3-button w3-red'><i class='fa fa-ban' aria-hidden='true'></i></button>");

								$(this_all).parents('tr').find('input').removeClass('inactive');
								$(this_all).parents('td').remove();
							}else{
								$(this_all).siblings('span').append("<sub style='color:red'>Clave incorrecta</sub>");

							}
							
						}
					});
			}
			function validar_palabras(this_all) {
				var palabras_a_validar = ["administrador","lectura","escritura","modificacion"];
				var cadena_encontrada = "";
				for(indice_cadena in palabras_a_validar){
					
					var cadena_actual = palabras_a_validar[indice_cadena];
					var verificador = true;
					for (var i = 0; i < $(this_all).val().length; i++) {	
						if (cadena_actual[i]!=$(this_all).val()[i]) {
							verificador=false;
						}
					}
					if (verificador) {
						cadena_encontrada=indice_cadena;
						break;
					}	
				}
					if (cadena_encontrada!="") {
						var cadena_escrita = "";
						for (var i = 0 ; i < $(this_all).val().length; i++) {
							cadena_escrita += $(this_all).val()[i];	
							if (palabras_a_validar[cadena_encontrada].indexOf(cadena_escrita)==-1 || cadena_escrita[i]!=palabras_a_validar[cadena_encontrada][i]) {
								$(this_all).val("");
							}
						}
					}else{
						$(this_all).val("");
					}
			}
			function actualizar_datos(id_user,this_all) {
					var inputs = $(this_all).parents('tr');
					var nombre = inputs.find('.nombre_input').val();
					var apellido = inputs.find('.apellido_input').val();
					var usuario = inputs.find('.usuario_input').val();
					var clave = inputs.find('.clave_input').val();
					var departamento = inputs.find('.departamento_input').val();
					var permiso = inputs.find('.permiso_input').val();
					
					
					$.ajax({
						url:"usuarios.php",
						data:{"id_user":id_user,"operacion":"actualizar_datos",'nombre':nombre,'apellido':apellido,'usuario':usuario,'clave':clave,'departamento':departamento,'permiso':permiso},
						type:"post",
						datatype:"json",
						success:function(data){

							var obj = JSON.parse(data);
							if (obj['estado']=="exito") {
								alert("Actualizado!");
								$(this_all).siblings('div').css({'display':''});
								$(this_all).parents('tr').find('input').addClass('inactive');
								$(this_all).parents('td').children('button').remove();
								buscar();

							}else{
								alert(obj['estado']);
							}
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
							url:"usuarios.php",
							data:json_valores,
							type:"post",
							datatype:"json",
							success:function(data){
								
								
								var obj = JSON.parse(data);
								if (obj['estado']=="exito") {
									alert("Agregado!");
									buscar();

								}else{
									alert(obj['estado']);
								}
							}
					});
				}
			}
			function reponer(this_all,id_user){
				$.ajax({
						url:"usuarios.php",
						data:{
							"id_user":id_user,
							"operacion":"reponer"
						},
						type:"post",
						datatype:"json",
						success:function(data){
							
							var obj = JSON.parse(data);
								
							var tr = $(this_all).parents('tr')
							tr.before("<tr><div class='usuario'><td><input style='border-width: 0px;pointer-events:none;' size='3' type='text' value='"+obj['id']+"' /></td><td><input type='text' class='inactive nombre_input' value='"+obj['nombre']+"' /></td><td><input type='text' class='inactive apellido_input' value='"+obj['apellido']+"' /></td><td><input type='text' class='inactive usuario_input' value='"+obj['usuario']+"' /></td><td><input type='text' class='inactive clave_input' size='3' value='*'  /></td><td><input type='text' class='inactive departamento_input'  value='"+obj['departamento']+"' /></td><td><input type='text' class='inactive permiso_input'  onkeyup='validar_palabras(this)' value='"+obj['permiso']+"' /></td><td><div><button style='width:50%' onclick=editar(this,'"+obj['id']+"') class='w3-button '><i class='fa fa-cog' aria-hidden='true'></i></button><button style='width:50%' onclick=eliminar('"+obj['id']+"') class='w3-button w3-red'><i class='fa fa-window-close-o' aria-hidden='true'></i></button></div></td></div></tr>");
							tr.remove()
							
							
						}
				});
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

			}
			.inactive{
				border-width: 0px;
				pointer-events:none;
				width: 200px;
			}
			
		</style>
</head>
<body>
	<div class="container-fluid">
		<center><header class="header w3-header"><h1>Administrar usuarios</h1></header></center>

        <input type="text" class="w3-input w3-animate-input" placeholder="Buscar por Permiso, Usuario, Nombre, Apellido o Departamento" id="buscar">
        
        <center>
        	<button class="w3-button w3-green w3-margin-top w3-margin-bottom" id="add">Agregar nuevo usuario</button>
        </center>
        
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Id</th>
					<th>Nombres</th>
					<th>Apellidos</th>
					<th>Usuario</th>
					<th>Clave</th>
					<th>Departamento adscrito</th>
					<th>Permiso</th>
					<th>Operaciones</th>
				</tr>
			</thead>
			<tbody id="resultados_buscar">
			</tbody>
		</table>
	</div>
</body>
</html>
