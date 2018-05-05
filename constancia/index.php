<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title> Constancia de trabajo </title>
	<link rel="stylesheet" type="text/css" href="../css/w3.css">
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/formato_moneda.js"></script>
		<script src="../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../css/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		function buscar_constancia(){
				$.ajax({
					url:"buscar_personal_constancia.php",
					data:{buscar:$("#buscar_personal_constancia").val()},
					type:"post",
					datatype:"json",
					beforeSend:function(){
				        	$("#resultados_buscar_personal_constancia").append('<center><i class="fa fa-spinner fa-pulse fa-2x fa-fw w3-text-black"></i><span class="sr-only">Loading...</span></center>')
				    },
					success:function(data){
						//alert(data);
						$("#resultados_buscar_personal_constancia").empty();
						objeto_constancia = JSON.parse(data);
						objeto_constancia.forEach(function(elemento,indice){
							$("#resultados_buscar_personal_constancia").append("\
								<tr>\
									<td>"+elemento['id']+"</td>\
									<td>"+elemento['estatus']+"</td>\
									<td>"+elemento['cedula']+"</td>\
									<td>"+elemento['nombre']+"</td>\
									<td>"+elemento['apellido']+"</td>\
									<td>\
										<button style='width:100%' onclick=buscar_temple("+indice+") class='w3-btn w3-blue'>\
											<i class='fa fa-file-word-o fa-6' aria-hidden='true' ></i>\
										</button>\
									</td>\
								</tr>");
						});
					}
				});
		}
		function buscar_temple(indice){
			$("#select_t").modal()
			temple(indice)

		}
		function temple(indice) {
			$.ajax({
				url:"operaciones/use_temple.php",
				data:{buscar:$("#buscar_temple").val()},
				type:"post",
				datatype:'json',
				success:function(data){
					var json_t = JSON.parse(data)
					$("#result_temples").empty()
					for(i in json_t){
						
						$("#result_temples").append('\
							<div class="col">\
								<div class="card">\
								  <div class="card-block">\
								    <h3 class="card-title">'+json_t[i]+'</h3>\
								    <a href="#" onclick=use_file("'+json_t[i].replace(/ /g,":::")+'",'+indice+') class="btn btn-success">Usar</a>\
								    <a href="#" onclick=delete_file("'+json_t[i].replace(/ /g,":::")+'") class="btn btn-danger">Eliminar</a>\
								  </div>\
								</div>\
							</div>\
							')
					}
					 
				}
			});
		}
		function delete_file(name) {
			var file = name.replace(/:::/g," ")
			if (confirm('¿Realmente desea borrar la plantilla '+file+"?")) {
				$.ajax({
				  type: "POST",
				  url: 'operaciones/eliminar.php',
				  data: {name:file},
				  success: function(data) {
				  	alert(data)
				  	$("#select_t").modal('toggle')
				  }
				});
			}
		}
		function use_file(name,indice) {
			var file = name.replace(/:::/g," ")
			this.objeto_constancia[indice]['salario']=formato(this.objeto_constancia[indice]['salario'])
			$("#valor_send").val(JSON.stringify(this.objeto_constancia[indice]))
			$("#temple_use").val(file)
			$("#form").submit()
			$("#select_t").modal('toggle')
			
		}
	</script>
	<script>
	    $(function(){
	        $("#formuploadajax").on("submit", function(e){
	            e.preventDefault();
	            var f = $(this);
	            var formData = new FormData(document.getElementById("formuploadajax"));
	            //formData.append("dato", "valor");
	            formData.append(f.attr("name"), $("#archivo1"));
	            $.ajax({
	                url: "operaciones/subir.php",
	                type: "post",
	                dataType: "html",
	                data: formData,
	                cache: false,
	                contentType: false,
		     		processData: false
	            })
	                .done(function(res){
	                   alert(res)
				  	   $("#select_t").modal('toggle')

	                });
	        });
	    });
	    
    </script>
	<style type="text/css">
		@font-face {
		  font-family: 'Open Sans';
		  src: url(../fonts/OpenSans-Light.ttf);
		}
		html,body{
			font-family: 'Open Sans', sans-serif;
			height: 100%;
			width: 100%;
		}	
	</style>
</head>
<body onload="buscar_constancia()">
<!-- 	<div class="nav_contenedor"></div>
	<script type="text/javascript">
		// $(function(){
		//   $(".nav_contenedor").load("../nav.php");
		// });
	</script> -->
	<div class="modal fade" id="select_t">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Selecciona una platilla</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	
	      	<form enctype="multipart/form-data" id="formuploadajax" method="post">
		     
		        <div class="form-group">
			    	<h4>
			    		<label for="archivo1">Subir nueva plantilla </label>
			    		<i class="fa fa-info-circle fa-3" style="cursor: pointer;" aria-hidden="true" data-toggle="collapse" href="#collapseExample"></i>
			    	</h4>

			    	<div class="alert alert-success collapse" id="collapseExample" role="alert">
					  <h4 class="alert-heading">Instrucciones para subir una plantilla...</h4>
					  <hr>
					  <ol>
					  	<li>
					  		<p>Cargue al sistema un documento <strong>.docx</strong> para usarlo como plantilla</p>
					  	</li>
					  	<li>
					  		<p>
					  			El formato y el resto del documento permanecen intactos. Solo tiene que usar el patrón de búsqueda como ${miValorAReemplazar}. Ejemplo: ${nombre} ${apellido} ➨ Alvaro Ospino
					  		</p>
					  	</li>
					  	<li>
					  		<ul>	
					  			<li>*** Las siguientes variables pueden ser reemplazadas en su documento Word con los datos guardados en el sistema:</li>
					  			<li>${nombre}</li>
					  			<li>${apellido}</li>
					  			<li>${cedula}</li>
								<li>${nacionalidad}</li>
								<li>${fecha_ingreso}</li>
								<li>${categoria}</li>
								<li>${cargo}</li>
								<li>${dedicacion}</li>
								<li>${departamento_adscrito}</li>
								<li>${profesion}</li>
								<li>${estatus}</li>
								<li>${sueldo_basico}</li>
								<li>${usuario_nombre}</li>
								<li>${genero}</li>
								<li>${cuenta_bancaria}</li>
								<li>${numero_hijos}</li>
								<li>${telefono_1}</li>
								<li>${telefono_2}</li>
								<li>${correo}</li>
								<li>${caja_ahorro}</li>
								<li>${antiguedad_otros_ieu}</li>
								<li>${años_servicio}</li>
					  		</ul>
					  	</li>
					  </ol>
					 				    
					</div>

			    	<div class="col-auto my-1">
			   			<input type="file" class="form-control-file" id="archivo1" name="archivo1">
			    	</div>
			    	<div class="col-auto my-1">
			   			<button type="submit" class="btn btn-primary mb-2 my-1">Subir</button>	
			    	</div>
			    </div>
		    </form>
		    <h4>Plantillas disponibles</h4>
			<input type="text" class="w3-input" onkeyup="temple()" placeholder="Buscar..." id="buscar_temple"><hr>
	         <div id="result_temples">
	         	
	         </div>



	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	      </div>
	    </div>
	  </div>
	</div>
	
	<center>
		<header>
			<h1>Motor de documentos</h1>
		</header>
	</center>

	<div class="w3-container">
		<input type="text" class="w3-input w3-animate-input" placeholder="Buscar por Estatus, Cédula, Nombre o Apellido" id="buscar_personal_constancia" onkeyup="buscar_constancia()">
			<div>
				<table class='w3-table table-bordered table'>
					<thead>
						<tr>
		 					<th width='50'>Id</th>
							<th width='50'>Estatus</th>
							<th width='50'>Cédula de identidad</th>
							<th width='50'>Nombres</th>
							<th width='50'>Apellidos</th>
							<th width='30'>Generar</th>
						</tr>
					</thead>
					<tbody id="resultados_buscar_personal_constancia">
					</tbody>
				</table>
			</div>
	</div>  

	<form action="generar.php" hidden="" method="post" id="form" target="_black">
		<textarea name="obj" id="valor_send"></textarea>
		<textarea name="temple_use" id="temple_use"></textarea>
	</form> 
</body>
</html>