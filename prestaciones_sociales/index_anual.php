
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
					"show" : "LIT_C", 
					"fecha_inicio" : "2001-01-01", 
					"fecha_cierre" : $("#fecha_cierre").val(), 
					"busqueda" : $("#busqueda").val()
		   		},
		        type:"post",
		        datatype:"json",
		        beforeSend: function() {
		        	$(".notificacion").empty().append('<div class="cargando w3-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>').show()
		        },
		        success: function(response){	
		        	$(".fecha_actual").text($("#fecha_cierre").val())
		        
		        	const place = $(".datos_resumidos_personal") 
		        	const place_resumido_anual = $(".data_personas_resumido_anual") 
			        $(".cargando").remove()
			        $(".data_trabajador").empty()
			        place.empty()
			        place_resumido_anual.empty()
			        $(".data_calculo_prestaciones_lit_b").empty()
			        $("#datos_especificos_prestaciones").css({display:"none"})

		        	try{
		        		$(".notificacion").hide()
		        		obj = JSON.parse(response)

			        	for(i in obj){
			        		var monto = obj[i].data_prestaciones.c.monto

			        		html_trimestral_resumido = "<tr class='hover tr_persona_calculo_prest_anuales' title='"+i+"'>"
			        		html_trimestral_resumido += "\
			        		<td>"+obj[i].nombre+"</td>\
			        		<td>"+obj[i].apellido+"</td>\
			        		<td class='cedula_person_pres_anuales' title='"+i+"'>"+format_cedula(i)+"</td>\
			        		<td class='cuenta_bancaria_person_pres_anuales'>"+obj[i].cuenta_bancaria+"</td>\
			        		<td class=''>"+obj[i].fecha_ingreso+"</td>\
			        		<td class='monto_person_pres_anuales'>"+formato(monto)+"</td>"
			        		html_trimestral_resumido += "</tr>"
			        		place_resumido_anual.append(html_trimestral_resumido)

			        	}

			        	
		        	}catch(err){
		        		
			        	$(".notificacion").empty().append(response).show()
		        			
		        	}			  
		        }
		   })
	    }
	    function format_cedula(val) {
			var count = 1
			var format = ""
			for (var i = val.length - 1; i >= 0; i--) {
				format = val[i]+format
				if (count%3==0) {
					format = "."+format
				}
				count++
			}
			return format
		}
		$(document).on("click",".tr_persona_calculo_prest_anuales",function() {
			let ced = $(this).attr("title")
			let lit_c = obj[ced].data_prestaciones.c
			$(".seleccion").show()
			$(".backdrop_seleccion").show()

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

			$(".tiempo_trabajado").text(lit_c['tiempo_trabajado'])
	        $(".en_años").text(lit_c['años']+" años")
	        $(".dias_prestaciones_x_año").text(lit_c['dias_x_año'])
	        $(".dias_prestaciones_correspondientes").text(lit_c['dias_totales'])
	        $(".sueldo_devengado").text(formato(lit_c['sueldo_devengado']))
	        $(".formula_utilizada").text(lit_c['formula_utilizada'])
	        $(".sueldo_devengado_x_dia").text(formato(lit_c['sueldo_devengado_x_dia']))
	        $(".total_literal_c").text(formato(lit_c.monto))
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
			const panels = $("#panels_prestaciones .tab-pane").toArray()
			for(i in panels){
				if($(panels[i]).hasClass('active')){
					const panel = $(panels[i])
					let data_all = new Object()
					let tr = $(panel).find(".tr_persona_calculo_prest_anuales").toArray()

					for(e in tr){
						let data_local = new Object()
						let cedula = $(tr[e]).find(".cedula_person_pres_anuales").attr("title")
						let cuenta_bancaria = $(tr[e]).find(".cuenta_bancaria_person_pres_anuales").text()
						let monto = $(tr[e]).find(".monto_person_pres_anuales").text().replace(/\./g,"").replace(/,/g,"")
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

					break;
				}
			}
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
			transition: 0.5s;
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
	<div class="bg-faded w3-display-middle w3-padding w3-card-4" style="display: none;position:fixed; ;z-index: 5000;width: 90%;height: 90%;overflow-y: auto;overflow-x:hidden;" id="content-detalles-sueldos">
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
	        <a class="nav-link text-primary h4" href="#">Cálculo hasta:</a>
	      </li>
	      <li class="nav-item active">
	        <a class="nav-link text-primary" href="#"><input type="date" value="2018-03-31" id="fecha_cierre" class="form-control"></a>
	      </li>
	      <li class="nav-item active text-danger">
	      	<a class="nav-link text-primary" href="#">
	      		<button class="btn btn-outline-warning" onclick="buscar()">Procesar Cálculo <i class="fa fa-calculator"></i></button>
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
       		<button class="btn btn-outline-info my-2 my-sm-0" onclick="buscar()" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
     	</ul>
	  </div>
	</nav>
	<div class="w3-display-container" style="z-index: 2000">
		<div class="alert alert-success w3-section w3-display-topright w3-card-4 seleccion" style="width: 950px;height:800px;display: none;overflow: auto;">
			<div class="container-fluid">
				<div class="row w3-margin-bottom">
					<div class="col">
						<b class="text-success h3">Hasta: </b><span class="h3 text-success fecha_actual"></span>
					</div>
					<div class="col" style="padding: 0px">
						<button class="btn btn-success w3-right" onclick="$('.seleccion').hide();$('.backdrop_seleccion').hide()"><i class="fa fa-close"></i></button>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<table class="table" >
							<tr>
								<td class="bg-faded h6 estado_select data_trabajador right"></td>
								<td class="bold">Estado</td>
							</tr>
							<tr>
								<td class="bg-faded h6 estatus_select data_trabajador right"></td>
								<td class="bold">Estatus</td>
							</tr>
							<tr>
								<td style="background-color: #BBDCE6" class="h6 fecha_ingreso_select data_trabajador right"></td>
								<td class="bold">Fecha de Ingreso</td>

							</tr>
						</table>
					</div>
					<div class="col">
						<table class="table" >
							<tr>
								<td class="right bold">Categoría</td>
								<td class="bg-faded h6 categoria_select data_trabajador"></td>
							</tr>
							<tr>
								<td class="right bold">Cargo</td>
								<td class="bg-faded h6 cargo_select data_trabajador"></td>
							</tr>
							<tr>
								<td class="right bold">Dedicación</td>
								<td class="bg-faded h6 dedicacion_select data_trabajador"></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<button class="btn btn-outline-info ver_detalles_sueldos" title="" style="width: 100%">Ver detalles de Sueldos</button>
					</div>
				</div>
				<div class="row">
					<div class="col">
			            <h3 class="w3-section">Base de cálculo</h3>
			            <table class="table">
			              <tr>
			                <th>Tiempo trabajado</th>
			                <td class="tiempo_trabajado"></td>
			              </tr>
			              <tr>
			                <th>Tiempo trabajado En años</th>
			                <td class="en_años"></td>
			              </tr>
			              <tr>
			                <th>Días de prestaciones por año</th>
			                <td class="dias_prestaciones_x_año"></td>
			              </tr>
			              <tr>
			                <th>Días de prestaciones totales correspondientes</th>
			                <td class="dias_prestaciones_correspondientes"></td>
			              </tr>
			              <tr>
			                <th>Último sueldo devengado Bs.</th>
			                <td class="sueldo_devengado"></td>
			              </tr>
			              <tr>
			                <th>Último sueldo devengado / día Bs.</th>
			                <td class="sueldo_devengado_x_dia"></td>
			              </tr>
			              <tr>
			                <th>Fórmula utilizada</th>
			                <td class="formula_utilizada text-primary"></td>
			              </tr>
			              <tr>
			                <th class="h3">Monto resultante Bs. </th>
			                <td class="total_literal_c text-success h3"></td>
			              </tr>
			            </table>
					</div>
				</div>
			</div>
		</div>
	</div>
		<div class="modal-backdrop show backdrop_seleccion" style="display: none"></div>
	<hr>
		<div class="alert alert-info container notificacion w3-center w3-section" style="display: none">
			
		</div>
	<hr>
	<div class="tab-panels">
		<ul class="nav nav-pills nav-fill">
		  <li class="nav-item">
		    <button class="btn-outline-primary btn tab active" data-toggle="tab" href="#resumido_anual" role="tab">Resumen Anual</button>
		  </li>
		  <li class="nav-item">
		    <a href="index.php"><button class="btn-outline-success btn tab">Prestaciones Trimestrales <i class="fa fa-arrow-left"></i></button></a>
		  </li>
		</ul>
	</div>
	<hr>
	<div class="tab-content" id="panels_prestaciones">
		<div class="tab-pane active" id="resumido_anual" role="tabpanel">
			<table class="table table-bordered table-striped right">
				<thead>
					<tr class="bg-faded text-primary">
						<th class="h4 right">Nombres</th>
						<th class="h4 right">Apellidos</th>
						<th class="h4 right">Cédula de Identidad</th>
						<th class="h4 right">Cuenta Bancaria</th>
						<th class="h4 right">Fecha de Ingreso</th>
						<th class="h4 right">Monto a Depositar Bs.</th>
					</tr>
				</thead>
				<tbody class="data_personas_resumido_anual">
					
				</tbody>
			</table>
		</div>
	</div>
	
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
