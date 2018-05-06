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
					        {	
								try{
									$("#seccion_divisiones").empty()
									obj = JSON.parse(response);	
									var divi = obj.data_general.array_divisiones	
									///Cabezera de divisones
									if ($("#grupo_divisiones > div").length==0) {

										var template_group = '<div class="btn-group" role="group">'
										
										
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

												var template_tabla = "<div id='"+ nom_divi +"_show' style='display:"+turn+"'>\
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
								}catch(err){
									document.write(response)
								}
					        }			  
					   })
			    })	   
	    }
		function d_recibo(){				
		  $("#g-recibo-data").val($("#d_recibo_data").html())
		  $("#g-recibo").submit()			 
		}
		function nav(this_all) {
			var show = "#"+$(this_all).attr("id")+"_show"		
			$(show).css("display",'')
			$(show).siblings('div').css("display",'none')
			$(this_all).addClass("active")
			$(this_all).siblings('button').removeClass("active")
		}
		$(document).on("click",".buscar",function () {
			buscar()
		})
		$(document).on("click",".filtro_estatus",function () {
			if(!$(this).hasClass('w3-red')){
				$(this).addClass('w3-red');
				$(this).siblings('button').removeClass('w3-red')
			}
		})
			
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
		.title_institucion:hover{
			cursor: pointer;
			color: blue;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<nav class="navbar navbar-toggleable-md navbar-inverse bg-faded bg-faded row">
		 
		  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		 
		  <a class="navbar-brand text-primary" href="#" onclick="window.location = '../operaciones_parametros_nomina/index.php?id='+getParameterByName('id')">División de períodos</a>
		  
		  <div class="collapse navbar-collapse" id="navbarNavDropdown">
		    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		      <li class="nav-item active">
		        <a class="nav-link text-primary" href="#" onclick="$('#fechas_periodo').modal('toggle')">Fechas del período</a>
		      </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle text-danger" href="#" id="filtar_drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          <i class="fa fa-filter" aria-hidden="true"></i> Filtrar 
		        </a>
		        <div class="dropdown-menu" aria-labelledby="filtar_drop">
		          <a class="dropdown-item" href="#">
					<div style="padding: 5px">				   
								
						<h4>Género</h4>	
							<input type="radio" name="genero" class="w3-radio buscar" value="Masculino"> Masculino <br>
							<input type="radio" name="genero" class="w3-radio buscar" value="Femenino"> Femenino <br>
							<input type="radio" name="genero" class="w3-radio buscar" value="" checked=""> Todos
		            	<hr>
							<h4>Categoría</h4>	
								<input type="checkbox" name="categoria[]" class="w3-check buscar" value="OBRERO"> Obrero <br>
								<input type="checkbox" name="categoria[]" class="w3-check buscar" value="DOCENTE"> Docente <br> 
								<input type="checkbox" name="categoria[]" class="w3-check buscar" value="ADMINISTRATIVO"> Administrativo							
		           		<hr>
							<h4>Estatus</h4>	
							        		
						       <button onclick="estatus=this.value" class="w3-button estatus buscar filtro_estatus" style="width:100%" value="ALTO NIVEL">Alto Nivel</button><br>	
						       <button onclick="estatus=this.value" class="w3-button  estatus buscar filtro_estatus" style="width:100%" value="EMPLEADO FIJO">Empleado Fijo</button><br>	
						       <button onclick="estatus=this.value" class="w3-button  estatus buscar filtro_estatus" style="width:100%" value="CONTRATADO">Contratado</button><br>			        			
							   <button onclick="estatus=this.value" class="w3-button w3-red estatus buscar filtro_estatus" style="width:100%">Todos</button>
			        </div>
		          </a> 
		        </div>
		      </li>
		    </ul>
		    <ul class="form-inline my-2 my-lg-0">
	        	<input type="text" class="form-control mr-sm-2" placeholder="Buscar por Nombre, Apellido, Cédula, Cargo o Dedicación" id="busqueda" onkeyup="buscar()">
	       		<button class="btn btn-outline-info my-2 my-sm-0 buscar" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
	     	</ul>
		  </div>
		</nav>
		<div class="row">
			<aside class="w3-section col">
				<div class="" id="grupo_divisiones">	
				</div><hr>
				<div class="table-responsive table table-bordered" id="seccion_divisiones">
				</div>
			</aside>
		</div>
	</div>
	 
	<div class="modal" tabindex="-1" role="dialog" id="fechas_periodo">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	      <div class="modal-body w3-center">
      		<h5 class="text-danger">Introduzca la fecha de inicio y cierre del período</h5>
      		<hr>
	        <label for="fecha_inicio">Fecha de Inicio</label><br>
	        <input type="date" id="fecha_inicio" required="">
	        <hr>
	        <label for="fecha_cierre">Fecha de Cierre</label><br>
	        <input type="date" id="fecha_cierre" required="">
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


