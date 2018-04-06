<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> .: Aporte patronal :.</title>
	<link rel="stylesheet" type="text/css" href="../css/w3.css">
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="../js/formato_moneda.js"></script>
	<script type="text/javascript" src="../js/param_url.js"></script>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery.cookie.js"></script>
  		<script src="../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../css/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		var estatus = "";
	    var num=1;
		$(document).ready(function () {
			$("#fechas_periodo").modal()
			if ($.cookie('fecha_inicio')!=undefined) {
				$("#fecha_inicio").val($.cookie('fecha_inicio'))
				$("#fecha_cierre").val($.cookie('fecha_cierre'))
			}
			$(document).on("click",".title_institucion",function () {
				
				$("#data_recibo_aporte_patronal").val($(this).parents('div').html())
				$("#recibo_aporte_patronal").submit()
			})
		})
		function validar_fechas_inicio_cierre() {
			if ($("#fecha_inicio").val()!="" && $("#fecha_cierre").val()!="") {
				buscar()
				$.cookie('fecha_inicio', $("#fecha_inicio").val());
				$.cookie('fecha_cierre', $("#fecha_cierre").val());
				return $('#fechas_periodo').modal('toggle')
			}else{
				return false
			}
		}
		function buscar (ordenar){
			
				num++;
				var asc_desc="";
				if (this.num%2==0) {
					var asc_desc="asc";
			    }else{
					var asc_desc="desc";
			    }
		    	var ordenar_asc_desc = [ordenar,asc_desc];
			    $(document).ready(function () {
				    var categoria_valores = [];
				     $('input[name="categoria[]"]:checked').each(function() {
				       categoria_valores.push($(this).val());
				     });
				   		
					   $.ajax({
					        url:"procesar.php",
					        data:{
								"fecha_inicio" : $("#fecha_inicio").val(), 
								"fecha_cierre" : $("#fecha_cierre").val(), 
								"busqueda" : $("#busqueda").val(), 
								"categoria" : categoria_valores,
								"genero" : $('input[name=genero]:checked').val(),
								"estatus" : estatus,
								"ordenar":ordenar_asc_desc,
								"id_nomina":getParameterByName('id')
					   		},
					        type:"post",
					        datatype:"json",
					        beforeSend:function (x) {
					        	$("#seccion_divisiones").append('<center><div><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div></center>')
					        },
					        success:function(response)
					        {	//document.write(response)
					        	
								$("#seccion_divisiones").empty()
					        	obj = JSON.parse(response);	
					        	var divi = obj.data_general.array_divisiones	
					        	///Cabezera de divisones
									if ($("#grupo_divisiones > div").length==0) {

										var template_group = '<div class="btn-group" role="group" aria-label="Basic example">'
										
										
										for(i in divi){
											i==0?turn='active':turn=''
											template_group+='<button onclick="nav(this)" id="'+ divi[i] +'" class="btn btn-primary '+turn+'" role="button" aria-pressed="true"> '+ divi[i].replace(/_/g,"&nbsp") +' </button>' 
										}	
										template_group+="</div>"						
										$("#grupo_divisiones").append(template_group);
									}
								///Termina Cabezera de divisines		        	
					        	if (obj.data_general.num_resultados==0) {
					        		$("#seccion_divisiones").append("<center><h1>¡No se encontraron resultados!</h1></center>")
					        	}else{

									for(indice_division in divi){
					        			
										var nom_divi = divi[indice_division]

										nom_divi===$("#grupo_divisiones").find(".active").attr('id')?turn='':turn='none'

								    	var template_tabla = "<div class='' id='"+ nom_divi +"_show' style='display:"+turn+"'>\
								    	    Unos <strong>"+obj['data_general']['num_resultados']+"</strong> resultados"
								    	    
								    	    for(i in obj.data_general.arr_apors){
								    	    	var num_insti = i 
								    	    	var name_insti = obj.data_general.arr_apors[i] 
								    	    	template_tabla+="<div id='"+nom_divi+"_"+name_insti.replace(/ /g,"_")+"'><div><h1>"+name_insti+" <i class='title_institucion fa fa-download' aria-hidden='true'></i></h1>"
								    	    		template_tabla+="<table class='table'>\
																		<thead>\
																			<tr>\
																				<th>#</th>\
																				<th>Nombre</th>\
																				<th>Apellido</th>\
																				<th>Cédula</th>\
																				<th>Aporte</th>\
																				<th>Deducción</th>\
																				<th>Total Bs.</th>\
																			</tr>\
																		</thead>\
																		<tbody>"
								    	    		for(i in obj){
								    	    			
								    	    			if (i!="data_general" && obj[i][nom_divi][num_insti]!=undefined) {
								    	    				var id = obj[i]['Total_periodo']['id']
															var nombre = obj[i]['Total_periodo']['nombre']
															var apellido = obj[i]['Total_periodo']['apellido']
															var cedula = obj[i]['Total_periodo']['cedula']
															
								    	    					template_tabla+="<tr>\
																				<td>"+id+"</td>\
																				<td>"+nombre+"</td>\
																				<td>"+apellido+"</td>\
																				<td>"+cedula+"</td>\
																				<td>"+formato(obj[i][nom_divi][num_insti]['aporte'])+"</td>\
																				<td>"+formato(obj[i][nom_divi][num_insti]['deduccion'])+"</td>\
																				<td>"+formato(obj[i][nom_divi][num_insti]['total'])+"</td>\
																			</tr>"
								    	    				
								    	    			}
								    	    			if (nom_divi=="Total_periodo" && i!="data_general" && obj[i]['Total_periodo']['recibo_aporte_patronal'][num_insti]!=undefined) {
		    	    						template_tabla+="<tr>\
														<td>"+obj[i]['Total_periodo']['id']+"</td>\
														<td>"+obj[i]['Total_periodo']['nombre']+"</td>\
														<td>"+obj[i]['Total_periodo']['apellido']+"</td>\
														<td>"+obj[i]['Total_periodo']['cedula']+"</td>\
														<td>"+formato(obj[i]['Total_periodo']['recibo_aporte_patronal'][num_insti]['aporte'])+"</td>\
														<td>"+formato(obj[i]['Total_periodo']['recibo_aporte_patronal'][num_insti]['deduccion'])+"</td>\
														<td>"+formato(obj[i]['Total_periodo']['recibo_aporte_patronal'][num_insti]['total'])+"</td>\
													</tr>"
								    	    				}
								    	    			
								    	    		}
								    	    		template_tabla+="</tbody></table></div>"
								    	    	template_tabla+="<div>"
								    	    }
								    	template_tabla+="</div>"   
										$("#seccion_divisiones").append(template_tabla);
									}	
								}			
					        }			  
					   })
			    })
			   
	    }

		function show_data(elem){	
			//Mostrar modal
			$("#show_data").modal()
			//Cédula de la persona seleccionada
			var ced = $(elem).children('td:eq(3)').text()
			//Nombre de la división
			var div = $(elem).parents('div').attr('id').replace('_show',"")
			//Buscar persona seleccionada
			for(i in obj){
				if (i!='data_general') {
					if (obj[i]['Total_periodo']['cedula']==ced) {
						var persona = i;
						break
					}
				}
			}
			var asig = obj[persona][div].recibo_asignaciones
			var deduc = obj[persona][div].recibo_deducciones
			const data = obj[persona].Total_periodo

			var recibo_html = ""
			var suma_asig = 0
			var suma_deduc = 0
			for(i in asig){
				recibo_html += "<tr><th>"+ i +"</th><td>"+ Object.keys(asig[i]) +"</td><td>"+ formato(Object.values(asig[i])) +"</td><td></td></tr>"
				suma_asig+=Number(Object.values(asig[i]))
			}
			for(i in deduc){
				recibo_html += "<tr><th>"+ i +"</th><td>"+ Object.keys(deduc[i]) +"</td><td></td><td>"+ formato(Object.values(deduc[i])) +"</td></tr>"
				suma_deduc+=Number(Object.values(deduc[i]))

			}
			recibo_html+="<tr><td colspan=2><h4>Total Bs.</h4></td><th>"+ formato(suma_asig) +"</th><th>"+ formato(suma_deduc) +"</th></tr>"
			
			template_recibo = '<div><img src="image/cintillo.jpg" style="width:100%"><hr> \
									<center>'+ div.replace(/_/g,"&nbsp") +'</center>\
									<center>Período: Desde <strong>'+ $("#fecha_inicio").val() +'</strong> Hasta <strong>'+ $("#fecha_cierre").val() +'</strong></center><hr>\
								<div>\
									<i>\
										<small>\
											Fecha de Emisión: :fecha:<br>Hora: :hora:\
										</small>\
									</i>\
									<h4>:estatus:</h4>\
								</div><br>\
							</div>\
							<table border="1" style="width:100%" class="w3-table w3-border"><thead><tr><th>Nombre y Apellido</th><th>Cédula</th><th>Sueldo base Bs.</th><th>Cuenta bancaria</th></tr></thead><tbody><tr><td>:nombre: :apellido:</td><td>:cedula:</td><td>:sueldo:</td><td>:cuenta_bancaria:</td></tr></tbody></table>\
							<hr>\
							<table border="1" style="width:100%" class="w3-table w3-border">\
								<thead id="cabezera_tabla_recibo">\
									<tr>\
										<th width="10%">#</th>\
										<th width="30%">Denominación</th>\
										<th width="30%">Asignaciones</th>\
										<th width="30%">Deducciones</th>\
									</tr>\
								</thead>\
								<tbody>:recibo:</tbody>\
							</table>\
						</div>'
						.replace(":estatus:",data.estatus)
						.replace(":fecha:",data.fecha)
						.replace(":hora:",data.hora)
						.replace(":nombre:",data.nombre)
						.replace(":apellido:",data.apellido)
						.replace(":cedula:",data.cedula)
						.replace(":sueldo:",formato(data.salario))
						.replace(":cuenta_bancaria:",data.cuenta_bancaria)
						.replace(":recibo:",recibo_html)

						$("#body_show").empty()
						$("#body_show").append(template_recibo)					    
		}
		function d_recibo(){				
		  $("#g-recibo-data").val($("#d_recibo_data").html())
		  $("#g-recibo").submit()			 
		}

	</script>
	<script type="text/javascript">
		function nav(this_all) {
			var show = "#"+$(this_all).attr("id")+"_show"		
			$(show).css("display",'')
			$(show).siblings('div').css("display",'none')
			$(this_all).addClass("active")
			$(this_all).siblings('button').removeClass("active")
		}	
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
		.title_institucion:hover{
			cursor: pointer;
			color: blue;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse bg-faded">
	 
	  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	 
	  <a class="navbar-brand" href="#" onclick="window.location = '../operaciones_parametros_nomina/index.php?id='+getParameterByName('id')">División de períodos</a>
	  
	  <div class="collapse navbar-collapse" id="navbarNavDropdown">
	    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
	      <li class="nav-item active">
	        <a class="nav-link text-primary" href="#" onclick="$('#fechas_periodo').modal('toggle')">Fechas del período</a>
	      </li>
	      <li class="nav-item dropdown">
	        <a class="nav-link dropdown-toggle" href="#" id="filtar_drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          <i class="fa fa-filter" aria-hidden="true"></i> Filtrar 
	        </a>
	        <div class="dropdown-menu" aria-labelledby="filtar_drop">
	          <a class="dropdown-item" href="#">
				<div style="padding: 5px">				   
							
					<h4>Género</h4>	
						<input type="radio" name="genero" class="w3-radio" onclick="buscar()" value="Masculino"> Masculino <br>
						<input type="radio" name="genero" class="w3-radio" onclick="buscar()" value="Femenino"> Femenino <br>
						<input type="radio" name="genero" class="w3-radio" onclick="buscar()" value="" checked=""> Todos
	            	<hr>
						<h4>Categoría</h4>	
							<input type="checkbox" name="categoria[]" class="w3-check" onclick="buscar()" value="OBRERO"> Obrero <br>
							<input type="checkbox" name="categoria[]" class="w3-check" onclick="buscar()" value="DOCENTE"> Docente <br> 
							<input type="checkbox" name="categoria[]" class="w3-check" onclick="buscar()" value="ADMINISTRATIVO"> Administrativo							
	           		<hr>
						<h4>Estatus</h4>	
						        		
					       <button onclick="estatus=this.value;buscar();if(!$(this).hasClass('w3-red')){$(this).addClass('w3-red');$(this).siblings('button').removeClass('w3-red')}" class="w3-button estatus" style="width:100%" value="ALTO NIVEL">Alto Nivel</button><br>	
					       <button onclick="estatus=this.value;buscar();if(!$(this).hasClass('w3-red')){$(this).addClass('w3-red');$(this).siblings('button').removeClass('w3-red')}" class="w3-button  estatus" style="width:100%" value="EMPLEADO FIJO">Empleado Fijo</button><br>	
					       <button onclick="estatus=this.value;buscar();if(!$(this).hasClass('w3-red')){$(this).addClass('w3-red');$(this).siblings('button').removeClass('w3-red')}" class="w3-button  estatus" style="width:100%" value="CONTRATADO">Contratado</button><br>			        			
						   <button onclick="estatus=this.value;buscar();if(!$(this).hasClass('w3-red')){$(this).addClass('w3-red');$(this).siblings('button').removeClass('w3-red')}" class="w3-button w3-red estatus" style="width:100%">Todos</button>
		        </div>
	          </a> 
	        </div>
	      </li>
	    </ul>
	    <ul class="form-inline my-2 my-lg-0">
        	<input type="text" class="form-control mr-sm-2" placeholder="Buscar por Nombre, Apellido, Cédula, Cargo o Dedicación" id="busqueda" onkeyup="buscar()">
       		<button class="btn btn-outline-info my-2 my-sm-0" onclick="buscar()" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
     	</ul>
	  </div>
	</nav>
	<aside class="col" id="calculos">
		<div class="" id="grupo_divisiones">	
		</div><hr>
		<div class=" table-responsive" id="seccion_divisiones" style="margin:0px">
		</div>
	</aside>

	  
    <div class="modal fade" id="show_data" role="dialog">
	    <div class="modal-dialog modal-lg">
	    
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title" ></h4>
	          <form action="generar_pdf/recibo_individual_nomina.php" id="g-recibo" method="post" target="_blank" hidden="true"><textarea name="g-recibo-data" id="g-recibo-data"></textarea></form>
	        </div>
	        <div class="modal-body" id="d_recibo_data">
	          <p id="body_show"></p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-success" style="cursor: pointer;"  onclick="d_recibo()">Descargar</button>
	        </div>
	      </div> 
	    </div>
    </div>
	<div class="modal" tabindex="-1" role="dialog" id="fechas_periodo">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">

	      <div class="modal-body">
			<center>
	      	<h5 class="text-danger">Introduzca la fecha de inicio y cierre del período</h5><hr>
	      	
		        <label for="fecha_inicio">Fecha de Inicio</label><br>
		        <input type="date" id="fecha_inicio" required="">
		        <hr>
		        <label for="fecha_cierre">Fecha de Cierre</label><br>
		        <input type="date" id="fecha_cierre" required="">
		    </center>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" onclick="validar_fechas_inicio_cierre()">Continuar</button>    
	      </div>
	    </div>
	  </div>
	</div>
	
	<div id="reportes" style="display: none">
		<form method="post" action="../generar_pdf/recibo_aporte_patronal.php" target="_blank" id="recibo_aporte_patronal">
			<textarea name="data_recibo_aporte_patronal" id="data_recibo_aporte_patronal"></textarea>
		</form>
	</div>
	

</body>
</html>


