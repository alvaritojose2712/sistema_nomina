
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> .: Prestaciones sociales :.</title>
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
		var fecha = new Date()
		function buscar(){			
		   $.ajax({
		        url:"procesar.php",
		        data:{
					"show" : "LIT_A_B", 
					"fecha_inicio" : $("#fecha_inicio").val(), 
					"fecha_cierre" : $("#fecha_cierre").val(), 
					"busqueda" : $("#busqueda").val()
		   		},
		        type:"post",
		        datatype:"json",
		        beforeSend: function() {
		        	$(".notificacion").empty().append('<div class="cargando w3-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>').show()
		        },
		        success: function(response){	
		        	const place = $(".datos_resumidos_personal") 
		        	const place_resumido_trimestral = $(".data_personas_resumido_trimestral") 
			        $(".cargando").remove()
			        $(".data_trabajador").empty()
			        place.empty()
			        place_resumido_trimestral.empty()
			        $(".data_calculo_prestaciones_lit_b").empty()
			        $("#datos_especificos_prestaciones").css({display:"none"})

		        	try{
		        		$(".notificacion").hide()
		        		obj = JSON.parse(response)

			        	html_trimestral = "<tr>"
			        	html_trimestral += "<th><h3><b>Personal</b></h3></th>"


			        	for(i in obj){
			        		var lon = obj[i].data_prestaciones.b.length-1

			        		html_trimestral += "<td class='tr_persona hover' title='"+i+"'>"+obj[i].nombre+" "+obj[i].apellido+" <b>"+format_cedula(i)+"</b></td>"
			        		
			        		html_trimestral_resumido = "<tr class='hover tr_persona_calculo_prest_trimestrales tr_persona' title='"+i+"'>"
			        		html_trimestral_resumido += "\
			        		<td>"+obj[i].nombre+"</td>\
			        		<td>"+obj[i].apellido+"</td>\
			        		<td class='cedula_person_pres_trimestrales h4' title='"+i+"'>"+format_cedula(i)+"</td>\
			        		<td class='cuenta_bancaria_person_pres_trimestrales'>"+obj[i].cuenta_bancaria+"</td>\
			        		<td class='bg-info text-white'>"+obj[i].fecha_ingreso+"</td>\
			        		<td class='monto_person_pres_trimestrales h4 text-primary'>"+formato(obj[i].data_prestaciones.b[lon].total)+"</td>"
			        		html_trimestral_resumido += "</tr>"
			        		place_resumido_trimestral.append(html_trimestral_resumido)

			        	}
			        	html_trimestral += "</tr>"

			        	place.append(html_trimestral)
			        
			        	
		        	}catch(err){
		        		
			        	$(".notificacion").empty().append(response).show()
		        			
		        	}			  
		        }
		   })
	    }
		$(document).ready(function(){
			$(".fecha_actual").text((parseInt(fecha.getDate())+1)+"-"+(parseInt(fecha.getMonth())+1)+"-"+fecha.getFullYear())
			$("#ano,#trimestre").change(function () {
				var a = $("#ano").val()
				var t = $("#trimestre").val()
				
				var arr = [
					["-01-01","-03-31"],
					["-04-01","-06-30"],
					["-07-01","-09-30"],
					["-10-01","-12-31"]
				]

				$("#fecha_inicio").val(a+arr[t][0])
				$("#fecha_cierre").val(a+arr[t][1])
			})
		})
		$(document).on("click",".tr_persona",function () {
			let ced = $(this).attr("title")
				$('#trimestral').tab('show')
				$('#resumido_trimestral').removeClass('active')

				$("[href='#trimestral']").addClass('active')
				$("[href='#resumido_trimestral']").removeClass('active')

			$("#datos_especificos_prestaciones").css({display:"initial"})
			
			$(".tr_persona").removeClass('bg-info text-white')
			$(".datos_resumidos_personal .tr_persona[title='"+ced+"']").addClass('bg-info text-white')
			
			$(".nombre_select").text(obj[ced].nombre)
			$(".apellido_select").text(obj[ced].apellido)
			$(".cedula_select").text(format_cedula(obj[ced].cedula))
			$(".estado_select").text(obj[ced].estado)
			$(".estatus_select").text(obj[ced].estatus)
			$(".fecha_ingreso_select").text(obj[ced].fecha_ingreso)
			$(".categoria_select").text(obj[ced].categoria)
			$(".cargo_select").text(obj[ced].cargo)
			$(".dedicacion_select").text(obj[ced].dedicacion)
			$(".ver_detalles_sueldos").attr("title",ced)

			let pres = obj[ced].data_prestaciones 

			let lit_b = pres['b']

			var data_calculo_prestaciones_lit_b = ""
			$(".data_calculo_prestaciones_lit_b").empty()
			for(i in lit_b){

				año = function() {return (lit_b[i].tiempo['año']>0)?"<b class='text-info'>"+lit_b[i].tiempo['año']+"</b> A":"";}
				var rows = 0
				data_calculo_prestaciones_lit_b = "<tr>\
					<td>\
		              "+año()+"\
		              <b class='text-info'>"+lit_b[i].tiempo['meses']+"</b> M \
		              <b class='text-info'>"+lit_b[i].tiempo['dias']+"</b> D\
		            </td>\
					<td>"+lit_b[i].fecha+"</td>\
					<td>"+lit_b[i].apodo+"</td>\
					<td>"+lit_b[i].dias_trabajados+"</td>\
					<td>"+formato(lit_b[i].sueldo)+"</td>\
					<td>"+lit_b[i].dias_prestaciones+"</td>\
					<td>"+lit_b[i].dias_adicionales+"</td>\
					<td>"+lit_b[i].total_dias+"</td>\
					<td>"+formato(lit_b[i].monto)+"</td>\
					<td>"+formato(lit_b[i].total)+"</td>\
					</tr>\
				"

				$(".data_calculo_prestaciones_lit_b").append(data_calculo_prestaciones_lit_b)
				rows = 0
			}
		})
		$(document).on("click",".ver_detalles_sueldos",function() {
			let ced = $(this).attr("title")
			let pres = obj[ced].data_prestaciones['sueldos']
			$("#content-detalles-sueldos").toggle()
			let temple = ""
			let html = ""
			var primas_salariales_bonos = function(valor) {
				//alert(JSON.stringify(valor))
				temple = ""
					for(let i in valor){
						temple+="<tr><td>"+valor[i]['descripcion']+"</td><td>"+formato(valor[i]['monto'])+"</td></tr>";
					}
				return temple
				
			}
			$(".data_sueldos_detalles").empty()
			for(i in pres){

				html = "<tr>\
					<td>"+pres[i]['sueldo_tabla_fecha']+"</td>\
					<td><table>"+formato(pres[i]['sueldo_tabla'])+"</table></td>\
					<td><table>"+primas_salariales_bonos(pres[i]['primas_salariales'])+"</table></td>\
					<td><table>"+primas_salariales_bonos(pres[i]['bonos_anuales'])+"</table></td>\
					<td>"+formato(pres[i]['aporte_caja_ahorro'])+"</td>\
					<td>"+formato(pres[i]['sueldo_integral'])+"</td>\
				</tr>"
				$(".data_sueldos_detalles").append(html)
				
			}
		})
		$(document).on("click","#boton_config_const",function() {
			$('#configurar_constantes').modal()
			$.ajax({
				url: 'configurar_constantes.php',
				type: 'POST',
				data: {accion: 'consultar'},
				success: function (res) {
					res = JSON.parse(res)
					$(".data_DIAS_TRABAJADOS_literal_b").val(res['DIAS_TRABAJADOS_literal_b'])
					$(".data_DIAS_DE_PRESTACIONES_literal_b").val(res['DIAS_DE_PRESTACIONES_literal_b'])
					$(".data_MAX_DIAS_ADICIONALES_literal_b").val(res['MAX_DIAS_ADICIONALES_literal_b'])
					$(".data_DIAS_ADICIONALES_literal_b").val(res['DIAS_ADICIONALES_literal_b'])
					$(".data_DIAS_x_AÑO_literal_c").val(res['DIAS_x_AÑO_literal_c'])
				}
			})
		})
		$(document).on("click","#boton_actualizar_config_const",function() {
			$.ajax({
				url: 'configurar_constantes.php',
				type: 'POST',
				data: {
					accion: 'editar',
					DIAS_TRABAJADOS_literal_b: $(".data_DIAS_TRABAJADOS_literal_b").val(),
					DIAS_DE_PRESTACIONES_literal_b: $(".data_DIAS_DE_PRESTACIONES_literal_b").val(),
					MAX_DIAS_ADICIONALES_literal_b: $(".data_MAX_DIAS_ADICIONALES_literal_b").val(),
					DIAS_ADICIONALES_literal_b: $(".data_DIAS_ADICIONALES_literal_b").val(),
					DIAS_x_AÑO_literal_c: $(".data_DIAS_x_AÑO_literal_c").val()
				},
				success: function (res) {
					alert(res)
				
				}
			})
		})
		$(document).on("click","#generar_txt_boton",function() {

			let data_all = new Object()
			let tr = $("#resumido_trimestral").find(".tr_persona_calculo_prest_trimestrales").toArray()

			for(e in tr){
				let data_local = new Object()
				let cedula = $(tr[e]).find(".cedula_person_pres_trimestrales").attr("title")
				let cuenta_bancaria = $(tr[e]).find(".cuenta_bancaria_person_pres_trimestrales").text()
				let monto = $(tr[e]).find(".monto_person_pres_trimestrales").text().replace(/\./g,"").replace(/,/g,"")
				//data_local['EMPRESA_cuerpo'] = 
				data_local['MONTO_cuerpo'] = monto;
				data_local['CUENTA_cuerpo'] = cuenta_bancaria;
				data_local['CEDULA_cuerpo'] = cedula;
				// data_local['FILLER_1_cuerpo'] = "00000"
				// data_local['TIPO_cuerpo'] = "0"
				// data_local['FILLER_2_cuerpo'] = "00"
				data_all[e] = data_local;
			}
			$("textarea[name=data_generar_txt]").val(JSON.stringify(data_all))
			$("#form_generar_txt").submit()
		})
	</script>
	<style type="text/css">
		@font-face {
		  font-family: 'Open Sans';
		  font-weight: 400;
		  src: url(../fonts/OpenSans-Light.ttf);
		}
		html,body{
			font-family: 'Open Sans', sans-serif;
			font-size: 20px;
			height: 100%;
			width: 100%;
		}	
		.hover:hover{
			background-color: #E2E2E2;
			cursor: pointer;
		}
		.left{
			text-align: left;
		}
		.right{
			text-align: right;
		}
		.bold{
			font-weight: 900;
		}
		button:hover{
			cursor: pointer;
		}
	</style>
</head>
<body>
	<div class="font-weight text-white w3-display-middle w3-padding w3-card-4" style="display: none;position:fixed; ;z-index: 5000;width: 90%;height: 90%;overflow-y: auto;overflow-x:hidden;background-color: #7D8185" id="content-detalles-sueldos">
		<div class="row w3-padding">
			<div class="col">
				<button class="btn btn-danger" onclick="$('#content-detalles-sueldos').toggle()"><i class="fa fa-close"></i></button>
			</div>
			<div class="col">
				<h2 class="w3-right">Ver detalles de Sueldos</h2>	
			</div>
		</div>
		<div class="row">
			<div class="col">
				<p>
		      		<table class="table table-bordered">
		      			<thead>
		      				<tr>
		      					<th>Fecha</th>
		      					<th>Sueldo Básico Bs.</th>
		      					<th>Primas Salariales</th>
		      					<th>Bonos Anuales</th>
		      					<th>Aporte Caja de Ahorro</th>
		      					<th>Sueldo Integral Bs.</th>
		      				</tr>
		      			</thead>
		      			<tbody class="data_sueldos_detalles">
		      				
		      			</tbody>
		      		</table>
		      	</p>
			</div>
		</div>
	</div>
	<nav class="navbar navbar-toggleable-md navbar-secundary bg-secundary bg-faded">
	  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	 
	  
	  <div class="collapse navbar-collapse" id="navbarNavDropdown">
	    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
	      <li class="nav-item active">
	        <a class="nav-link text-primary" href="#">Inicio <input type="date" value="2018-01-01" id="fecha_inicio" class="form-control"></a>
	      </li>
	      <li class="nav-item active">
	        <a class="nav-link text-primary" href="#">Cierre <input type="date" value="2018-03-31" id="fecha_cierre" class="form-control"></a>
	      </li>
	      <li class="nav-item active text-danger">
	       		
	      </li>
	      <li class="nav-item active">
			<a href="#" class="nav-link text-primary">
				Año
			    <select class="form-control" id="ano">
			      <option value="1995">1995</option>
			      <option value="1996">1996</option>
			      <option value="1997">1997</option>
			      <option value="1998">1998</option>
			      <option value="1999">1999</option>
			      <option value="2000">2000</option>
			      <option value="2001">2001</option>
			      <option value="2002">2002</option>
			      <option value="2003">2003</option>
			      <option value="2004">2004</option>
			      <option value="2005">2005</option>
			      <option value="2006">2006</option>
			      <option value="2007">2007</option>
			      <option value="2008">2008</option>
			      <option value="2009">2009</option>
			      <option value="2010">2010</option>
			      <option value="2011">2011</option>
			      <option value="2012">2012</option>
			      <option value="2013">2013</option>
			      <option value="2014">2014</option>
			      <option value="2015">2015</option>
			      <option value="2016">2016</option>
			      <option value="2017">2017</option>
			      <option value="2018" selected="">2018</option>
			      <option value="2019">2019</option>
			      <option value="2020">2020</option>
			      <option value="2021">2021</option>
			      <option value="2022">2022</option>
			      <option value="2023">2023</option>
			      <option value="2024">2024</option>
			      <option value="2025">2025</option>
			      <option value="2026">2026</option>
			      <option value="2027">2027</option>
			      <option value="2028">2028</option>
			      <option value="2029">2029</option>
			    </select>
			</a>
	      </li>
	      <li class="nav-item active">
			<a href="#" class="nav-link text-primary">
				Trimestre
			    <select class="form-control" id="trimestre">
			     <option value="0">1er trimestre</option>
			     <option value="1">2do trimestre</option>
			     <option value="2">3er trimestre</option>
			     <option value="3">4to trimestre</option>
			    </select>
			</a>
	      </li>	      
	    </ul>
	    <ul class="form-inline my-2 my-lg-0">
	   		<button class="nav-link text-primary btn btn-outline-info my-2 my-sm-0" id="generar_txt_boton">Archivo TXT</button> 
	 	</ul>
	    <ul class="form-inline my-2 my-lg-0">
	   		<button class="nav-link text-primary btn btn-outline-info my-2 my-sm-0" data-target="configurar_constantes" id="boton_config_const">* Constantes *</button>
	 	</ul>
	    <ul class="form-inline my-2 my-lg-0">
        	<input type="text" class="form-control mr-sm-2" style="width: 500px" placeholder="Buscar por Nombre, Apellido o Cédula" id="busqueda">
       		<button class="btn btn-outline-info my-2 my-sm-0" onclick="buscar()" type="button">Procesar <i class="fa fa-search" aria-hidden="true"></i></button>
     	</ul>
	  </div>
	</nav>
	<div class="tab-panels w3-section w3-margin-left" >
		<ul class="nav nav-pills nav-fill">
		  <li class="nav-item">
		    <button class="btn-outline-primary btn tab active" data-toggle="tab" href="#resumido_trimestral" role="tab">Resumen Trimestral</button>
		    <button class="btn-outline-primary btn tab" data-toggle="tab" href="#trimestral" role="tab">Detallado Trimestral</button>
		  </li>
		  <li class="nav-item">
		    <a href="index_anual.php"><button class="btn-outline-success btn tab">Prestaciones culminado la Relación Laboral <i class="fa fa-arrow-right"></i></button></a>
		  </li>
		</ul>
	</div>
	<hr>
	<div class="tab-content" id="panels_prestaciones">
		<div class="tab-pane active" id="resumido_trimestral" role="tabpanel">
			<table class="table table-bordered table-striped right">
				<thead>
					<tr class="bg-faded text-primary">
						<th class="h4 bold right">Nombres</th>
						<th class="h4 bold right">Apellidos</th>
						<th class="h4 bold right">Cédula de Identidad</th>
						<th class="h4 bold right">Cuenta Bancaria</th>
						<th class="h4 bold right">Fecha de Ingreso</th>
						<th class="h4 bold right">Monto a Depositar Bs.</th>
					</tr>
				</thead>
				<tbody class="data_personas_resumido_trimestral">
					
				</tbody>
			</table>
		</div>
		<div class="tab-pane" id="trimestral" role="tabpanel">
			<aside class="container-fluid">
				<div class="row">
					<div class="col">
						<span class="h1 text-primary w3-right w3-margin">Hoy: <b><span class="fecha_actual"></span></b> </span>
					</div>
				</div>				
				<div class="row">
					<div class="col table-responsive">
						<table class="table table-bordered" style="cursor: pointer;">
							<tbody class="datos_resumidos_personal">
								
							</tbody>
						</table>
					</div>
				</div>
				<div class="row w3-padding" style="display: none" id="datos_especificos_prestaciones">
					<div class="col">
						<div class="row">
							<div class="col">
								<table class="table">
									<tr>
										<td class="h4 w3-center" colspan="2">Datos Generales</td>
									</tr>
									<tr>
										<td class="h2">
											<span class="nombre_select data_trabajador"></span> 
											<b class="apellido_select data_trabajador"></b>
										</td>
										<td class="w3-right h3">
											<code class="cedula_select data_trabajador"></code>
										</td>
									</tr>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<table class="table" >
									<tr>
										<td class="bg-faded h4 estado_select data_trabajador right"></td>
										<td class="bold">Estado</td>
									</tr>
									<tr>
										<td class="bg-faded h4 estatus_select data_trabajador right"></td>
										<td class="bold">Estatus</td>
									</tr>
									<tr>
										<td style="background-color: #BBDCE6" class="h4 fecha_ingreso_select data_trabajador right"></td>
										<td class="bold">Fecha de Ingreso</td>

									</tr>
								</table>
							</div>
							<div class="col">
								<table class="table" >
									<tr>
										<td class="right bold">Categoría</td>
										<td class="bg-faded h4 categoria_select data_trabajador"></td>
									</tr>
									<tr>
										<td class="right bold">Cargo</td>
										<td class="bg-faded h4 cargo_select data_trabajador"></td>
									</tr>
									<tr>
										<td class="right bold">Dedicación</td>
										<td class="bg-faded h4 dedicacion_select data_trabajador"></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<button class="btn btn-outline-info ver_detalles_sueldos" style="width: 100%">Ver detalles de Sueldos</button>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<table class="table w3-hoverable" style="width: 100%">
									<thead>
										<tr>
											<td class="h4 w3-center" colspan="10">Prestaciones Sociales</td>
										</tr>
										<tr class="bg-inverse text-white">
											<th title="Tiempo al servicio del patrono">Tiempo</th>
											<th>Fecha de Corte</th>
											<th>Trimestre</th>
											<th>Días trabajados</th>
											<th>Sueldo a la fecha Bs.</th>
											<th>Días de prestaciones</th>
											<th>Días adicionales</th>
											<th>Total días</th>
											<th>Monto Bs.</th>
											<th>Acumulado Bs.</th>
										</tr>
									</thead>
									<tbody class="data_calculo_prestaciones_lit_b">
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</aside>
		</div>
	</div>
		<hr>
			<div class="alert alert-info container notificacion w3-center w3-section">
				<b>Teniendo ya Establecidos Los parámetros de las Prestaciones Sociales => <button class="btn-lg btn btn-outline-warning" onclick="buscar()">Procesar Cálculo <i class="fa fa-calculator"></i></button></b>
			</div>
		<hr>
	<div class="modal" id="configurar_constantes">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Configurar Constantes</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <p class="	">
	        	<table class="table striped">
	        		<tr>
	        			<th>DIAS_TRABAJADOS_literal_a</th>
	        			<td>
	        				<input type="text" class="form-control data_DIAS_TRABAJADOS_literal_b">
	        			</td>
	        		</tr>
					<tr>
						<th>DIAS_DE_PRESTACIONES_literal_a</th>
						<td>
							<input type="text" class="form-control data_DIAS_DE_PRESTACIONES_literal_b">
						</td>
					</tr>
					<tr>
						<th>DIAS_ADICIONALES_literal_b</th>
						<td>
							<input type="text" class="form-control data_DIAS_ADICIONALES_literal_b">
						</td>
					</tr>
					<tr>
						<th>MAX_DIAS_ADICIONALES_literal_b</th>
						<td>
							<input type="text" class="form-control data_MAX_DIAS_ADICIONALES_literal_b">
						</td>
					</tr>
					<tr>
						<th>DIAS_x_AÑO_literal_c</th>
						<td>
							<input type="text" class="form-control data_DIAS_x_AÑO_literal_c">
						</td>
					</tr>
	        	</table>
	        </p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" id="boton_actualizar_config_const">Guardar</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	      </div>
	    </div>
	  </div>
	</div>
	<form action="../generar_txt/bicentenario.php" id="form_generar_txt" hidden="" target="_blank" method="post">
		<textarea name="data_generar_txt"></textarea>
	</form>
</body>
</html>
