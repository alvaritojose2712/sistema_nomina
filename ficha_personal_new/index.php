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
		function MaysPrimera(string){

		  return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
		}
		let estatus_filtro = ""
		$(document).on("click",".lista > .item-li",function() {
			$(this).siblings('.item-li').switchClass('blanco text-active',"text-inactive",0)
			$(this).switchClass('text-inactive',"blanco text-active",0)
			estatus_filtro = $(this).attr("title")
			buscar()
		})
		$(document).on("click",".estado",function() {
			$(this).addClass('bg-oscuro')
			$(this).siblings('.estado').removeClass('bg-oscuro')
		})

		let estado_filtro = ""
		$(document).on("click",".lista .estado",function() {
			estado_filtro = $(this).attr("title")
			buscar()
		})
		$(document).on("click",".btn-group > .btn-tab",function() {
			$(this).removeClass('btn-inactive')
			$(this).siblings('.btn-tab').addClass('btn-inactive')
		})
		let ordenar = ["apellido","ASC"]
		$(document).on("click",".alternar-flechas",function() {
			$(this).find('i').toggle()
			if ($(this).attr("title")=="Alfabéticamente") {
				ordenar[0] = "apellido"
			}else{
				ordenar[0] = "cedula"
			}
			if ($(this).find('.fa-arrow-down').css("display")=="none") {
				ordenar[1] = "ASC"
			}else{
				ordenar[1] = "DESC"
			}
			buscar()
		})
		
		const type_user = {"Masculino":"male","Femenino":"female"};
		const type_estado = {"ACTIVO":"fa-play-circle text-success","PENSIONADO":"fa-circle-o text-warning","JUBILADO":"fa-circle-thin text-alert","INACTIVO":"fa-circle-o-notch text-danger"};
		const colors_bg = {"0":"bg-primary","1":"bg-danger","2":"bg-info","3":"bg-warning","4":"bg-success"}

		function buscar() {
			$(".div-ver-mas").hide(100)
			$(".table-personal-resumida").addClass('font-30x')
			let place = $(".table-personal-resumida")
			$.ajax({
				url: "procesar.php",
				type: "post",
				data:{
					accion: "buscar",
					ordenar: ordenar,
					estatus_filtro: estatus_filtro,
					estado_filtro: estado_filtro,
					buscar: $("#input-buscar").val()
				},
				beforeSend: function() {
					place.parents("table").after('<div class="cargando w3-center"><div class="loader section-large">\
				            <div class="loader-inner line-scale-pulse-out">\
					          <div class="bg-inverse"></div>\
					          <div class="bg-inverse"></div>\
					          <div class="bg-inverse"></div>\
					          <div class="bg-inverse"></div>\
					          <div class="bg-inverse"></div>\
					        </div>\
				      </div></div>')
				},
				success: function(res) {

					$(".cargando").remove()
					place.empty()
					try{
						obj = JSON.parse(res)
						obj_personal = obj['personal']
						todos_estatus = obj['todos_estatus']


						num_colors = 0
						for(i in obj_personal){
							let html = '\
							<tr title="'+i+'" class="tr_persona">\
								<td><i class="fa fa-'+type_user[obj_personal[i]["Genero"]]+'"></i> <i class="fa '+type_estado[obj_personal[i]['Estado']]+'"></i></td>\
								<td> <b>'+obj_personal[i]['Apellidos']+', '+obj_personal[i]['Nombres']+'</b> </td>\
								<td>'+obj_personal[i]['Departamento adscrito']+' <span class="badge badge-default '+colors_bg[num_colors]+'">'+obj_personal[i]['Profesión']+'</span></td>\
								<td class="text-right">'+obj_personal[i]['Nacionalidad']+'</span>-</td>\
								<td class=""><span><b>'+format_cedula(obj_personal[i]['Cédula'])+'</b></td>\
							</tr>'
							place.append(html)
							num_colors++;
							if (num_colors==5) {num_colors=0}
						}
						if ($(".lista-estatus > div").length==0) {
							for(i in todos_estatus){
								if (i=="Todos") {
									e=""
									turn = "blanco text-active"
								}else{
									turn = "text-inactive"
									e=i
								}
								let html_estatus = '<div class="item-li li '+turn+'" title="'+e+'">\
									<div class="row">\
										<div class="col w3-padding">'+MaysPrimera(i)+'</div>\
										<div class="col-md-auto w3-padding">\
											<span class="num">'+todos_estatus[i]+'</span>\
										</div>\
									</div>\
								</div>'
								$(".lista-estatus").append(html_estatus)

							}
						}
						$(".num-resultados").text(todos_estatus['Todos'])
					}catch(err){
						place.append(res)
					}
					
				}

			})
		}
		$(document).ready(buscar)
		$(document).on("keyup","#input-buscar",function() {
			$(".lista-estatus").empty()
			estatus_filtro=""
			estado_filtro=""
			buscar()
		})
		$(document).on("click",".tr_persona",function() {
			$(".div-ver-mas").show(100)
			$(".table-personal-resumida").removeClass('font-30x')
			let id = $(this).attr("title")
			let obj_personal = obj['personal'][id]

			$(".nombre-apellido-show").text(obj_personal['Nombres']+" "+obj_personal['Apellidos'])
			$(".cedula-show").text(format_cedula(obj_personal['Cédula']))
			$(".nacionalidad-show").text(obj_personal['Nacionalidad'])
			$(".estado-show").html('<i class="fa '+type_estado[obj_personal['Estado']]+'"></i> '+obj_personal['Estado'])
			
			$(".estatus-show").text(obj_personal['Estatus'])
			$(".categoria-show").text(obj_personal['Categoría'])
			$(".cargo-show").text(obj_personal['Cargo'])
			$(".dedicacion-show").text(obj_personal['Dedicación'])

			$(".fecha-nacimiento-show").text(obj_personal['Fecha nacimiento'])
			$(".años-show").text(obj_personal['edad'])

			$(".telefono-1-show").text(obj_personal['Teléfono 1'])
			$(".telefono-2-show").text(obj_personal['Teléfono 2'])
			$(".correo-show").text(obj_personal['Correo electrónico'])

			$(".cuenta-bancaria-show").text(obj_personal['Cuenta bancaria'])
			$(".fecha-ingreso-show").text(obj_personal['Fecha de ingreso'])
			$(".antiguedad-ieu-show").text(obj_personal['Antiguedad en otros IEU'])
			$(".caja-ahorro-show").text(obj_personal['Caja de ahorro'])
			$(".años-fecha-ingreso-show").text(obj_personal['años-fecha-ingreso-show'])

			$(".grado-instruccion-show").text(obj_personal['Grado de instrucción'])
			$(".departamento-show").text(obj_personal['Departamento adscrito'])
			$(".cargo_desempeñado_departamento-show").text(obj_personal['Cargo desempeñado en el departamento'])
			
			$(".horas-diurnas-show").text(obj_personal['Horas extras diurnas'])
			$(".horas-nocturnas-show").text(obj_personal['Horas extras nocturnas'])
			$(".horas-feriadas-show").text(obj_personal['Horas extras feriadas'])
			$(".horas-ferias-nocturnas-show").text(obj_personal['Horas extras feriadas-nocturnas'])
			$(".profesion-show").html('<span class="badge badge-default">'+obj_personal['Profesión']+'</span>')

			$(".boton_eliminar").attr("title",obj_personal['Cédula'])
			$(".boton_editar").attr("title",obj_personal['Cédula'])

			$(".genero-show").html('<i class="fa fa-'+type_user[obj_personal["Genero"]]+'"></i> '+obj_personal['Genero'])
			$(".numero_hijos").text(obj_personal['num_hijos'])
			$(".hijos-personal").empty()
			for(let i in obj_personal['hijos']){

				$(".hijos-personal").append('<tr>\
								<td>'+obj_personal['hijos'][i]['Nombre']+' '+obj_personal['hijos'][i]['Apellido']+'</td>\
								<td>'+obj_personal['hijos'][i]['Fecha de nacimiento']+' (<b>'+obj_personal['hijos'][i]['edad']+'</b> años)</td>\
								<td>'+obj_personal['hijos'][i]['Discapacidad']+'</td>\
								<td>'+obj_personal['hijos'][i]['Estudia']+'</td>\
							</tr>')
			}			
		})
		$(document).on("click",".generar_pdf_general",function() {
			$("[name='data_reporte_general_ficha']").val(JSON.stringify(obj['personal']))
			
			$("#form_reporte_general_ficha").submit();
		})
		$(document).on("click",".boton_eliminar",function() {
			let ced = $(this).attr("title")
			if (window.confirm("¿Realmente desea eliminar a "+ced+" con todo el grupo familiar asociado ?")) {
				$.ajax({
					url:"procesar.php",	
					data:{"cedula":ced,"accion":"eliminar"},
					type:"post",
					success:function(data){
						alert(data);
						$("#input-buscar").trigger('keyup')
					}
				});
			}
		})
		$(document).on("click",".boton_editar",function() {
			window.location = "incluir.php?id="+$(this).attr('title');
		})
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
			font-size: 2vw;
		}
		.font-30x{
			font-size: 1.5vw;
		}

		.font-20x{
			font-size: 1vw;
			
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
	</style>
</head>
<body>
	<div class="container-fluid h-100">
		<div class="row h-100">
			<div class="col-md-2 bg-inverse nopadding table-responsive">
				<div class="w3-padding-xlarge w3-center w3-section">
					<a href="incluir.php">
						<button class="btn btn-naranja btn-block btn-lg text-inactive"><i class="fa fa-user"></i> Nuevo personal</button>
					</a>
				</div>
				<div class="w3-center lista w3-section lista-estatus">
					
				</div>
				<div class="divisor"></div>
				<div class="w3-section lista font-30x caviar-dreams">
					<div class="li text-inactive estado" title="ACTIVO"><i class="fa fa-play-circle text-success"></i> Activo</div>
					<div class="li text-inactive estado" title="PENSIONADO"><i class="fa fa-circle-o text-warning"></i> Pensionado</div>
					<div class="li text-inactive estado" title="JUBILADO"><i class="fa fa-circle-thin text-alert"></i> Jubilado</div>
					<div class="li text-inactive estado" title="INACTIVO"><i class="fa fa-circle-o-notch text-danger"></i> Inactivo</div>
					<div class="li text-inactive estado" title=""><i class="fa fa-circle"></i> Todos</div>
				</div>
			</div>
			<div class="col blanco open-sans table-responsive padding-large">
				<div class="container-fluid">
					<div class="row section">
						<div class="col"><span class="h1">Personal</span></div>
						<div class="col">
							<div class="input-group h-100">
						      <input type="text" class="form-control form-control-lg" id="input-buscar" placeholder="Buscar...">
						      <span class="input-group-addon btn btn-outline-primary" id="" onclick="buscar()"><i class="fa fa-search"></i></span>
						    </div>
						</div>
					</div>
					<div class="row section">
						<div class="col">
							<i class="fa fa-file-pdf-o fa-4x w3-margin generar_pdf_general"></i>
							<i class="fa fa-file-excel-o fa-4x w3-margin"></i>
						</div>
						<div class="col text-right">
							<div class="btn-group">
								<span class="btn btn-tab alternar-flechas" title="Alfabéticamente">
									Alfabéticamente 
									<span class="">
										<i class="fa fa-arrow-up"></i>
										<i class="fa fa-arrow-down" style="display: none"></i>
									</span>
								</span>
								<span class="btn btn-tab btn-inactive alternar-flechas" title="Cédula">
									Nº de Cédula 
									<span class="">
										<i class="fa fa-arrow-up"></i>
										<i class="fa fa-arrow-down" style="display: none"></i>
									</span>
								</span>
							</div>	
						</div>
					</div>
					<div class="row w3-section">
						<div class="col font-30x">
							<span class="num-resultados font-weight-bold"></span> resultados
						</div>
					</div>
					<div class="row section">
						<div class="col">
							<table class="w-100 table-hover table">
								<tbody class="table-personal-resumida font-30x">
									
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>
			<div class="col blanco table-responsive padding-large roboto div-ver-mas" style="display: none">
				<div class="section-large">
					<div class="btn-group w-100">
						
						<button class="btn btn-outline-success btn-lg boton_editar" title=""><i class="fa fa-edit"></i></button>
						<button class="btn btn-outline-danger btn-lg boton_eliminar" title=""><i class="fa fa-trash"></i></button>
					</div>
				</div>
				<div>
					<span class="font-auto"><i class="fa fa-user-circle-o"></i> <span class="nombre-apellido-show"></span></span>
				</div>
				<div class="text-right">
					<code class="font-30x"><span class="nacionalidad-show"></span>-<b class="cedula-show"></b></code>
				</div>
				<div class="w3-section">
					<span class="font-30x estado-show"></span>
				</div>
				<div>
					<table class="table font-20x">
						<thead>
							<tr>
								<th>Estatus</th>
								<th>Categoría</th>
								<th>Cargo</th>
								<th>Dedicación</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="estatus-show"></td>
								<td class="categoria-show"></td>
								<td class="cargo-show"></td>
								<td class="dedicacion-show"></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="section-large">
					<table class="table font-30x w3-center">
						<tr>
							<td class="genero-show"></td>
							<td><span class="fecha-nacimiento-show"></span> (<span class="años-show font-weight-bold"></span> años)</td>
						</tr>
					</table>
				</div>
				<div class="">
					<table class="table font-20x w3-center table-info">
						<tr>
							<td><i class="fa fa-phone"></i></td>
							<td><i class="fa fa-phone-square"></i></td>
							<td><i class="fa fa-mail-reply"></i></td>
						</tr>
						<tr>
							<td class="telefono-1-show"></td>
							<td class="telefono-2-show"></td>
							<td class="correo-show"></td>
						</tr>
					</table>
				</div>
				<div class="w3-section">
					<table class="table font-20x">
						<tr>
							<th>Cuenta Bancaria</th>
							<td class="cuenta-bancaria-show"></td>
						</tr>
						<tr>
							<th>Fecha de ingreso</th>
							<td><span class="fecha-ingreso-show"></span><span class="hace-fecha-ingreso-show"> (Hace <span class="años-fecha-ingreso-show font-weight-bold"></span> años)</span></td>
						</tr>
						<tr>
							<th>Antiguedad en otros IEU</th>
							<td class=""><span class="antiguedad-ieu-show"></span> años</td>
						</tr>
						<tr>
							<th>¿Aplica a caja de ahorro?</th>
							<td class="caja-ahorro-show"></td>
						</tr>
					</table>
				</div>
				<div class="w3-section">
					<table class="table font-20x table-striped">
						<tr>
							<th>Grado de instrucción</th>
							<td class="grado-instruccion-show"></td>
						</tr>
						<tr>
							<th>Profesión</th>
							<td class="profesion-show"></td>
						</tr>
						<tr>
							<th>Departamento abscrito</th>
							<td class="departamento-show text-info"></td>
						</tr>
						<tr>
							<th>Cargo desenpeñado en el departamento</th>
							<td class="cargo_desempeñado_departamento-show"></td>
						</tr>
						<tr>
							<th>Horas Extras-Diurnas</th>
							<td class="horas-diurnas-show"></td>
						</tr>
						<tr>
							<th>Horas Extras-Nocturnas</th>
							<td class="horas-nocturnas-show"></td>
						</tr>
						<tr>
							<th>Horas Extras-Feriadas</th>
							<td class="horas-feriadas-show"></td>
						</tr>
						<tr>
							<th>Horas Feriadas-Nocturnas</th>
							<td class="horas-ferias-nocturnas-show"></td>
						</tr>
					</table>
				</div>
				<div class="section-large">
					<h1 class="">Nº Hijos <span class="numero_hijos font-weight-bold"></span></h1>
					<table class="table table-info font-20x">
						<thead>
							<tr>
								<th>Nombres y Apellidos</th>
								<th>Fecha de nacimiento</th>
								<th>¿Tiene alguna discapacidad?</th>
								<th>¿Es estudiante?</th>
							</tr>
						</thead>
						<tbody class="hijos-personal">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<form action="../generar_pdf/reporte_general_ficha.php" method="post" id="form_reporte_general_ficha" hidden="" target="_blank">
		<textarea name="data_reporte_general_ficha"></textarea>
	</form>
</body>
</html>
