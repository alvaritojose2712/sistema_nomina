<?php 
	include 'conexion_bd.php';
	$consulta_parametros_nomina = (new sql("parametros_nomina","WHERE id='".$_GET['id']."'"))->select()->fetch_assoc();
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> .: Búsqueda | Nómina :.</title>
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/formato_moneda.js"></script>
	<script type="text/javascript" src="js/param_url.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script src="js/jquery-ui/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
 		
 		<link rel="stylesheet" type="text/css" href="css/loaders.css/loaders.css">
		<script src="css/loaders.css/loaders.css.js"></script>
 		
 		<script src="css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap/dist/css/bootstrap.min.css">
		<script src="css/bootstrap/dist/js/bootstrap.min.js"></script>
		
	<script type="text/javascript">
		var estatus = "";
	    var num=1;
	    var operaciones_especiales_json = new Object();
		$(document).ready(function () {
			if ($.cookie('fecha_cierre')==undefined || $.cookie('fecha_cierre')==undefined) {
				$("#fechas_periodo").modal()
			}else{
				$("#fecha_inicio").val($.cookie('fecha_inicio'))
				$("#fecha_cierre").val($.cookie('fecha_cierre'))

				$("#mostrar_fecha_inicio").text($.cookie('fecha_inicio').replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1'))
				$("#mostrar_fecha_cierre").text($.cookie('fecha_cierre').replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1'))
				buscar()
			}
			$("#search_de").click(function(){
				$("#modal_de").modal()
				buscar_de()
			})
			$("#add_destinatarios").click(function(){
				$("#destinatarios").append("<div><input class=\"destinatario\" placeholder=\"Destinatario\"/><button class=\"w3-red\" onclick=\"$(this).parent().remove()\">&times;</button></div>")
			})
			$(document).on("click","input[name=select_de]",function () {
				$("#de").html($(this).val())
			})
			$("#año,#meses").change(function () {
				var m = $("#meses").val()
				var a = $("#año").val()
				function cant_ds(mes,ano){ 
					di=28 
					f = new Date(ano,mes-1,di); 
					while(f.getMonth()==mes-1){ 
						di++; 
						f = new Date(ano,mes-1,di); 
					} 
					return di-1; 
				} 
				if (m>=1 && m<=12) {
					$("#fecha_inicio").val(a+"-"+m+"-01")
					$("#fecha_cierre").val(a+"-"+m+"-"+cant_ds(m,a))
				}else{
					var arr = []
					arr['1er'] = ["-01-01","-03-31"]
					arr['2do'] = ["-04-01","-06-30"]
					arr['3er'] = ["-07-01","-09-30"]
					arr['4to'] = ["-10-01","-12-31"]
						

					$("#fecha_inicio").val(a+arr[m][0])
					$("#fecha_cierre").val(a+arr[m][1])
				}
			})
			$(".cerrar_partidas_presupuestarias,.abrir_partidas_presupuestarias").click(function () {
				$("#show_partidas").animate({'width':"100%"},100)
					$( "#show_partidas" ).toggle( "display" );
			})
			$('#tab_casos_a a').click(function (e) {
			  e.preventDefault()
			  $(this).tab('show')
			})
			$("#switch_p").click(function () {
				if($(this).prop("checked")){
					$(".info_switch").text("Incluir").switchClass( "text-danger", "text-primary", 100, "easeInOutQuad" )
					$(".contenedor_agregados").switchClass( "w3-border-red", "w3-border-blue", 100, "easeInOutQuad" )
				}else{
					$(".info_switch").text("Excluir").switchClass( "text-primary", "text-danger", 100, "easeInOutQuad" )
					$(".contenedor_agregados").switchClass( "w3-border-blue", "w3-border-red", 100, "easeInOutQuad" )
				}
			})
			$(document).on("click","#abrir_casos_especiales",function () {
				solicitar_personas()
			})
			$(document).on("keyup",".solicitar_personal_incl_excl",solicitar_personas)
			$(document).on("click",".abrir_opera_espec",solicitar_personas_operaciones)
			$(document).on("keyup",".solicitar_personal_opera_input",solicitar_personas_operaciones)
			$(document).on("click",".select_incl_excl",function () {
				if ($(".select_"+$(this).find(".cedula_selected").text()).length==0) {
					
					var c = $(this).find(".cedula_selected").text()
					var n = $(this).find(".nombre_selected").text()
					
					$(".list_incl_excl").append('<div class="btn-group w3-margin-bottom select_'+c+'" style="width: 100%">\
			  						<button type="button" style="width: 80%" class="btn btn-secondary button-incl-excl">'+n+' <span class="cedula_ready">'+c+'</span></button>\
			  						<button type="button" style="width: 20%" onclick="$(this).parent(\'.btn-group\').remove()" class="btn btn-danger button-incl-excl"><i class="fa fa-close"></i></button>\
			  					</div>')

				}
			})
			$(document).on("click",".select_opera_espec",function () {
				if ($(".select_opera_espec_"+$(this).find(".cedula_selected").text()).length==0) {
					var c = $(this).find(".cedula_selected").text()
					var n = $(this).find(".nombre_selected").text()
					var active = ($(".list_opera_espec").find('.active').length==0)?"active":""
					$(".list_opera_espec").append('<div class="btn-group w3-margin-bottom select_opera_espec_'+c+'" style="width: 100%">\
			  						<button type="button" style="width: 20%" class="btn btn-warning borrar_user_opera_espec"><i class="fa fa-close"></i></button>\
			  						<button type="button" style="width: 80%" class="btn btn-secondary button_opera_espec '+active+'">'+n+' <span class="cedula_ready active">'+c+'</span></button>\
			  					</div>')
					if ($(".user_adding_opera").text()=="") {
						$(".user_adding_opera").text(c)
					}
				}
			})
			$(document).on("click",".agg_opera_espec",function () {
				var html_card = '<div class="card container-fluid w3-card-4 w3-margin-top bg-primary text-white">\
											<div class="row w3-margin text-white">\
												<div class="h3 col motivo_opera_espec" style="max-width: 100%;overflow:hidden;" contenteditable="true">Motivo. Click aquí</div>\
												<div class="col-3"><button class="btn btn-danger w3-right borrar_card_operacion"><i class="fa fa-close"></i></button></div>\
											</div>\
											<div class="row w3-margin">\
												<select class="form-control select_asig_deduc">\
													<option value="asignacion">Asignación</option>\
													<option value="deduccion">Deducción</option>\
												</select>\
											</div>\
											<div class="row w3-margin">\
												<div class="container-fluid division_opera_espe">'
						for(i in obj['data_general']['array_divisiones']){
							if (obj['data_general']['array_divisiones'][i]!="Total_periodo") {
								html_card+='<div class="row">\
												<div class="col name_division_opera_espec">'+obj['data_general']['array_divisiones'][i]+'</div>\
												<div class="col"><input type="text" class="form-control value_division_opera_espec" ></div>\
											</div>'
							}
						}
									html_card+='</div>\
											</div>\
											<div class="row w3-margin">\
												<textarea placeholder="Operación" class="form-control monto_opera_espec"></textarea>\
											</div>\
										</div>'
				if ($(".user_adding_opera").text()!="") {
					$(".ver_opera_espec").append(html_card)
				}else{
					alert("Seleccione a un trabajador!")
				}
			})
			$(document).on("click",".borrar_card_operacion",function () {
				var card = $(this).parents('.card')
				var user = $(".user_adding_opera").text()
				try{
					delete operaciones_especiales_json[user][card.index()]
					card.remove()
				}catch(err){
					card.remove()
				}
			})
			$(document).on("click",".borrar_user_opera_espec",function () {
				$(this).parent('.btn-group').remove()
				let c = $(this).siblings('button').find(".cedula_ready").text()
				delete operaciones_especiales_json[c]
				$(".user_adding_opera").text("")
				$(".ver_opera_espec").empty()
			})
			$(document).on("click",".button_opera_espec",function () {
				if(json_opera_espec()===true || $(".user_adding_opera").text()==""){
					let c = $(this).find(".cedula_ready").text()
					$(".ver_opera_espec").empty()
					$(".user_adding_opera").text(c)
					$(this).parents(".list_opera_espec").find('.button_opera_espec').removeClass("active")
					$(this).addClass("active")
					try{
						for (i_nume in operaciones_especiales_json[c]) {

							for(indice in operaciones_especiales_json[c][i_nume]){
								if (indice=="asignacion" || indice=="deduccion") {
									var a = (indice=="asignacion")?"selected":""
									var d = (indice=="deduccion")?"selected":""
									var html_card = '<div class="card container-fluid w3-card-4 w3-margin-top bg-primary text-white">\
												<div class="row w3-margin text-white">\
													<div class="h3 col motivo_opera_espec" style="max-width: 100%;overflow:hidden;" contenteditable="true">'+operaciones_especiales_json[c][i_nume][indice]['motivo']+'</div>\
													<div class="col-3"><button class="btn btn-danger w3-right borrar_card_operacion"><i class="fa fa-close"></i></button></div>\
												</div>\
												<div class="row w3-margin">\
													<select class="form-control select_asig_deduc">\
														<option value="asignacion" '+a+'>Asignación</option>\
														<option value="deduccion" '+d+'>Deducción</option>\
													</select>\
												</div>'
									var html_monto = '<div class="row w3-margin">\
														<textarea placeholder="Operación" class="form-control monto_opera_espec">'+operaciones_especiales_json[c][i_nume][indice]['monto']+'</textarea>\
													</div>'
								}else if(indice=="divisiones"){
									var html_divi = '<div class="row w3-margin">\
														<div class="container-fluid division_opera_espe">'
													for(i in operaciones_especiales_json[c][i_nume][indice]){
														html_divi+='<div class="row">\
																		<div class="col name_division_opera_espec">'+i+'</div>\
																		<div class="col"><input value="'+operaciones_especiales_json[c][i_nume][indice][i]+'" type="text" class="form-control value_division_opera_espec" ></div>\
																	</div>'
													}
											html_divi+='</div>\
													</div>'
								}
							}
							html_monto+='</div>'		
							$(".ver_opera_espec").append(html_card+html_divi+html_monto)
						}
					}catch(err){
						alert(err)
					}
				}else{
					alert(json_opera_espec())
				}
			})
			$(document).on("click",".guardar_oper_espe",function () {
				if(json_opera_espec()===true || $(".user_adding_opera").text()==""){
					$(".ver_opera_espec").empty()
					$(".user_adding_opera").text($(this).find(".cedula_ready").text())
					$.ajax({
				        url:"operaciones_parametros_nomina/casos_especiales/procesar.php",
				        type:"post",
				        datatype:"json",
				        data:{
				        	operaciones_especiales_json:function () {
				        		return JSON.stringify(operaciones_especiales_json)
				     	    },
			     	    	id: getParameterByName('id')
				    	},
				        beforeSend:function () {
				        	$(".ver_opera_espec").before('<center><div class="cargando"><i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Loading...</span></div></center>')
				        },
				        success:function(response)
				        {	
				        	$(".cargando").remove()	
				        	alert(response)	
				        	buscar()		
				        }			  
				    })
				}else{
					alert(json_opera_espec())
				}
			})
			$(document).on("click",".guardar_incl_exclu",function () {
				$.ajax({
			        url:"operaciones_parametros_nomina/casos_especiales/procesar.php",
			        type:"post",
			        datatype:"json",
			        data:{
			        	incl_excl:function () {
			        		var json = {}
			        		var incl_excl = $(".info_switch:first").text().toLowerCase()
			        		json[incl_excl] = new Object()
			        		var arr = $(".list_incl_excl").find(".cedula_ready").toArray()
			        		for(i in arr){

			        			json[incl_excl][$(arr[i]).html()] = ""
			        		}
			        		if (arr.length==0) {
			        			return "{}"
			        		}else{
			        			return JSON.stringify(json)
			        		}
			        		
			     	    },
			     	    id: getParameterByName('id')
			    	},
			        beforeSend:function () {
			        	$(".guardar_incl_exclu").before('<center><div class="cargando"><i class="fa fa-spinner fa-pulse fa-fw fa-3x"></i><span class="sr-only">Loading...</span></div></center>')
			        },
			        success:function(response)
			        {	
			        	$(".cargando").remove()	
			        	alert(response)		
			        	buscar()	
			        }			  
			    })
			})

			$(document).on("click",".abrir_pago_retroactivo",function () {
				$("#modal_pago_retroactivo").modal("show")
			})
		})
		function json_opera_espec() {
			let c = $(".user_adding_opera").text()
			if (c!="") {
				var err = ""
				operaciones_especiales_json[c] = new Object()
				let card = $(".ver_opera_espec").find(".card")
				card.each(function (i,e) {
					
					var asig_deduc = $(this).find(".select_asig_deduc").val()
						var motivo = $(this).find(".motivo_opera_espec").text()
						var monto =  $(this).find(".monto_opera_espec").val()
					var division_opera_espe = $(this).find(".division_opera_espe .row")

					operaciones_especiales_json[c][i] = new Object()
					operaciones_especiales_json[c][i][asig_deduc] = new Object() 
					operaciones_especiales_json[c][i][asig_deduc]["motivo"] = motivo 
					operaciones_especiales_json[c][i][asig_deduc]["monto"] = monto 
					operaciones_especiales_json[c][i]['divisiones'] = new Object()

					var sum = 0
					division_opera_espe.each(function (indice,elemento) {
						var name = $(elemento).find(".name_division_opera_espec").text()
						var value = $(elemento).find(".value_division_opera_espec").val()
						value = (value!='')?value:0
						operaciones_especiales_json[c][i]['divisiones'][name] = value
						sum+=parseInt(value)
					})
					if (sum!=100) {
						err+="Error: <"+c+"><"+i+"> No suma el 100% en todas las divisiones!\n"
					}
					if (motivo=="" || monto=="") {
						err+="Error: <"+c+"><"+i+"> Se encontraron campos vacíos!\n"
					}
				})
				if(card.length==0){
					err+="Error: <"+c+"> Debe agregar por lo menos una operación!\n"
				}
				if (err=="") {
					return true
				}else{
					delete operaciones_especiales_json[c]
					return err
				}
			}
		}
		function solicitar_personas() {
			$('#casos_especiales').modal('show')
			$.ajax({
		        url:"ficha_personal/procesar_ficha.php",
		        data:{
					"operacion" : "buscar",
					"buscar" : $(".solicitar_personal_incl_excl").val()
		   		},
		        type:"post",
		        datatype:"json",
		        beforeSend:function (x) {
		        	$(".personas_incl_excl").append('<center><div><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div></center>')
		        },
		        success:function(response)
		        {	//document.write(response)
		        	var res = JSON.parse(response)
					var place = $(".personas_incl_excl")
					place.empty()

					let casos_especiales = obj['data_general']['casos_especiales']
					if(casos_especiales!="{}"){
						casos_especiales = JSON.parse(casos_especiales)
						var as_de = Object.keys(casos_especiales)[0]
						if(as_de=="incluir"){
							$(".info_switch").text('Incluir')
							$("#switch_p").prop("checked",true)
							$(".info_switch").text("Incluir").switchClass( "text-danger", "text-primary", 100, "easeInOutQuad" )
							$(".contenedor_agregados").switchClass( "w3-border-red", "w3-border-blue", 100, "easeInOutQuad" )
						}
						$(".list_incl_excl").empty()
						for(i in casos_especiales[as_de]){
							$(".list_incl_excl").append('<div class="btn-group w3-margin-bottom select_'+i+'" style="width: 100%">\
								<button type="button" style="width: 80%" class="btn btn-secondary button-incl-excl">'+res[i]['Nombres']+' <span class="cedula_ready">'+i+'</span></button>\
								<button type="button" style="width: 20%" onclick="$(this).parent(\'.btn-group\').remove()" class="btn btn-danger button-incl-excl"><i class="fa fa-close"></i></button></div>')


						}
					}
					for(i in res){
						place.append("<tr class='w3-hover-grey select_incl_excl'>\
										<td class='nombre_selected'>"+res[i]['Nombres']+"</td>\
										<td class='cedula_selected'>"+res[i]['Cédula']+"</td></tr>");
					}
		        }			  
		    })
		}
		function solicitar_personas_operaciones() {
			$('#casos_especiales').modal('show')
			$.ajax({
		        url:"ficha_personal/procesar_ficha.php",
		        data:{
					"operacion" : "buscar",
					"buscar" : $(".solicitar_personal_opera_input").val()
		   		},
		        type:"post",
		        datatype:"json",
		        beforeSend:function (x) {
		        	$(".personas_opera_espec").append('<center><div><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div></center>')
		        },
		        success:function(response)
		        {	
		        	var res = JSON.parse(response)
					var place = $(".personas_opera_espec")

					let operaciones_especiales = obj['data_general']['operaciones_especiales']
					if(operaciones_especiales!="{}"){
						operaciones_especiales = JSON.parse(operaciones_especiales)
						operaciones_especiales_json = operaciones_especiales
						for(i in operaciones_especiales){
							var c = res[i]['Cédula']
							var n = res[i]['Nombres']
							var active = ($(".list_opera_espec").find('.active').length==0)?"active":""
							$(".list_opera_espec").append('<div class="btn-group w3-margin-bottom select_opera_espec_'+c+'" style="width: 100%">\
					  						<button type="button" style="width: 20%" class="btn btn-warning borrar_user_opera_espec"><i class="fa fa-close"></i></button>\
					  						<button type="button" style="width: 80%" class="btn btn-secondary button_opera_espec '+active+'">'+n+' <span class="cedula_ready active">'+c+'</span></button>\
					  					</div>')
						}
					}

					place.empty()
					for(i in res){
						place.append("<tr class='w3-hover-grey select_opera_espec'>\
										<td class='nombre_selected'>"+res[i]['Nombres']+"</td>\
										<td class='cedula_selected'>"+res[i]['Cédula']+"</td></tr>");
					}
		        }			  
		    })
		}
		function validar_fechas_inicio_cierre() {
			if ($("#fecha_inicio").val()!="" && $("#fecha_cierre").val()!="") {
				buscar()
				$.cookie('fecha_inicio', $("#fecha_inicio").val());
				$.cookie('fecha_cierre', $("#fecha_cierre").val());

				$("#mostrar_fecha_inicio").text($("#fecha_inicio").val().replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1'))
				$("#mostrar_fecha_cierre").text($("#fecha_cierre").val().replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1'))
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
			   
			    var categoria_valores = [];
			    $('input[name="categoria[]"]:checked').each(function() {
			       categoria_valores.push($(this).val());
			    });
			   		
			    $.ajax({
			        url:"personal.php",
			        data:{
						"fecha_inicio" : $("#fecha_inicio").val(), 
						"fecha_cierre" : $("#fecha_cierre").val(), 
						"busqueda" : $("#busqueda").val(), 
						"categoria" : categoria_valores,
						"genero" : $('input[name=genero]:checked').val(),
						"estatus" : estatus,
						"ordenar":ordenar_asc_desc,
						"id_nomina":getParameterByName('id'),
						"confirm_retroactivo":$("#confirm_retroactivo").prop('checked'),
						"fecha_retroactivo":$("#fecha_retroactivo").val()
			   		},
			        type:"post",
			        datatype:"json",
			        beforeSend:function (x) {
			        	$("#calculos").append('\
			        		<div class="container cargando w3-display-bottommiddle">\
						        <div class="loader-inner ball-pulse-rise" style="width:200px">\
						          <div class="bg-inverse"></div>\
						          <div class="bg-inverse"></div>\
						          <div class="bg-inverse"></div>\
						          <div class="bg-inverse"></div>\
						          <div class="bg-inverse"></div>\
						        </div>\
					        </div>\
						')
			        },
			        success:function(response)
			        {	
			        	try{
				        	$(".cargando").remove()
							$("#seccion_divisiones").empty()
				        	obj = JSON.parse(response);	
				        	var divi = obj.data_general.array_divisiones	
				        	///Grupo de divisones
								if ($("#grupo_divisiones > div").length==0) {

									var template_group = '<div class="btn-group" role="group">'
									
									for(i in divi){
										i==0?turn='active':turn=''
										template_group+='<button onclick="nav(this)" id="'+ divi[i] +'" class="btn btn-primary '+turn+'" role="button" aria-pressed="true"> '+ divi[i].replace(/_/g,"&nbsp") +' </button>' 
									}	
									template_group+="</div>"						
									$("#grupo_divisiones").append(template_group);
								}
							///Termina grupo de divisines		        	
				        	if (obj.data_general.num_resultados==0) {
				        		$("#seccion_divisiones").append("<center><h1>¡No se encontraron resultados!</h1></center>")
				        	}else{
								for(indice_division in divi){
				        			
									var nom_divi = divi[indice_division]
									nom_divi===$("#grupo_divisiones").find(".active").attr('id')?turn='':turn='none'

							    	var template_tabla = "<div class='' id='"+ nom_divi +"_show' style='display:"+turn+"'>\
							    	    Unos <strong>"+obj['data_general']['num_resultados']+"</strong> resultados\
							    	    <table class='table table-striped table-hover' style='cursor:pointer' >\
													<thead>\
														<tr>\
															<th scope='col' onclick=buscar('id')>#</th>\
															<th scope='col' onclick=buscar('estatus')>Estatus</th>\
															<th scope='col' onclick=buscar('nombre')>Nombre</th>\
															<th scope='col' onclick=buscar('apellido')>Apellido</th>\
															<th scope='col' onclick=buscar('cedula')>Cédula</th>\
															<th scope='col' onclick=buscar('genero')>Género</th>\
															<th scope='col' onclick=buscar('categoria')>Categoría</th>\
															<th scope='col' onclick=buscar('cargo')>Cargo</th>\
															<th scope='col' onclick=buscar('dedicacion')>Dedicación</th>\
															<th scope='col'>Años de servicio</th>\
															<th scope='col'>Salario básico Bs.</th>\
															<th scope='col'>Total a pagar Bs.</th>\
														</tr>\
													</thead>\
													<tbody>"									
																		
									for(indice_persona in obj){										
										if (indice_persona!="data_general") {
											
											var data_comun = obj[indice_persona]["Total_periodo"]
											var data_unica = obj[indice_persona][nom_divi]
			
											template_tabla+="<tr onclick=show_data(this)>\
												<th scope='row'>" + data_comun.id + "</th>\
												<td>" + data_comun.estatus + "</td>\
												<td>" + data_comun.nombre + "</td>\
												<td>" + data_comun.apellido + "</td>\
												<td>" + data_comun.cedula + "</td>\
												<td>" + data_comun.genero[0] + "</td>\
												<td>" + data_comun.categoria + "</td>\
												<td>" + data_comun.cargo + "</td>\
												<td>" + data_comun.dedicacion + "</td>\
												<td>" + data_comun.años_servicio + "</td>\
												<td>" + formato(data_comun.salario,2,['.',".",',']) + "</td>\
												<td class='text-success'>" + formato(data_unica.total,2,['.',".",','])+ "</td>\
											</tr>"	
										}								
									}										
									template_tabla+="</tbody></table></div>"
									$("#seccion_divisiones").append(template_tabla);
								}	
							}
							var html_partida = '<table class="table table-hover table-bordered">\
													<thead>\
														<tr>\
															<th>Código</th>\
															<th>Denominación</th>\
															<th>Total requerimiento Bs.</th>\
														</tr>\
													</thead>\
													<tbody>'
														
							var obj_global = obj['data_general']['partida_presupuestaria']			
							for(i in obj_global){
								html_partida += '<tr class="h1 font-weight-bold">\
													<td>\
														'+i+".00"+".00"+".00"+".00"+'\
													</td>\
													<td>\
														'+obj_global[i]['nombre']+'\
													</td>\
													<td>\
														'+formato(obj_global[i]['monto'])+'\
													</td>\
												</tr>'
								if (obj_global[i]['hijos']!=undefined) {
									var obj_partida = obj_global[i]['hijos']
									for(ii in obj_partida){
										html_partida += '<tr class="h2 font-weight-bold">\
													<td>\
														'+"&nbsp;"+i+"."+ii+".00"+".00"+".00"+'\
													</td>\
													<td>\
														'+obj_partida[ii]['nombre']+'\
													</td>\
													<td>\
														'+formato(obj_partida[ii]['monto'])+'\
													</td>\
												</tr>'
										if (obj_partida[ii]['hijos']!=undefined) {
											var obj_generico = obj_partida[ii]['hijos']
											for(iii in obj_generico){
												html_partida += '<tr class="text-primary h3">\
															<td>\
																'+"&nbsp;"+"&nbsp;"+i+"."+ii+"."+iii+".00"+".00"+'\
															</td>\
															<td>\
																'+obj_generico[iii]['nombre']+'\
															</td>\
															<td>\
																'+formato(obj_generico[iii]['monto'])+'\
															</td>\
														</tr>'
												if (obj_generico[iii]['hijos']!=undefined) {
													var obj_especifico = obj_generico[iii]['hijos']
													for(iiii in obj_especifico){
														html_partida += '<tr class="h4">\
																	<td>\
																		'+"&nbsp;"+"&nbsp;"+"&nbsp;"+i+"."+ii+"."+iii+"."+iiii+".00"+'\
																	</td>\
																	<td>\
																		'+obj_especifico[iiii]['nombre']+'\
																	</td>\
																	<td>\
																		'+formato(obj_especifico[iiii]['monto'])+'\
																	</td>\
																</tr>'
														if (obj_especifico[iiii]['hijos']!=undefined) {
															var obj_sub_especifico = obj_especifico[iiii]['hijos']
															for(iiiii in obj_sub_especifico){
																html_partida += '<tr class="h5">\
																			<td>\
																				'+"&nbsp;"+"&nbsp;"+"&nbsp;"+"&nbsp;"+i+"."+ii+"."+iii+"."+iiii+"."+iiiii+'\
																			</td>\
																			<td>\
																				'+obj_sub_especifico[iiiii]['nombre']+'\
																			</td>\
																			<td>\
																				'+formato(obj_sub_especifico[iiiii]['monto'])+'\
																			</td>\
																		</tr>'
															}
														}
													}
												}
											}
										}
									}
								}
							}			

							html_partida += '</tbody></table>'
							$("#resultados_partida").empty().append(html_partida)	
							
						}catch(err){
							alert(err)
							$("#seccion_divisiones").append(response)
						}		
			        }			  
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
			recibo_html+="<tr>\
							<td colspan=2></td>\
							<th>"+ formato(suma_asig) +"</th>\
							<th>"+ formato(suma_deduc) +"</th>\
						</tr>"
			recibo_html+="<tr>\
							<td colspan=2><h4>Total Bs.</h4></td>\
							<th colspan=2><h4><center>"+ formato(suma_asig-suma_deduc) +"</center></h4></th>\
						</tr>"
			
			template_recibo = '<div><img src="image/cintillo.jpg" style="width:100%"><hr> \
									<center>'+ div.replace(/_/g,"&nbsp") +'\
									<br>Período: Desde <strong>'+ $("#fecha_inicio").val().replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1') +'</strong> Hasta <strong>'+ $("#fecha_cierre").val().replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1') +'</strong></center><hr>\
								<h4>:estado:</h4>\
							</div>\
							<table class="w3-table w3-bordered">\
								<thead>\
									<tr>\
										<th>Nombre y Apellido</th>\
										<th>Cédula</th>\
										<th>Cuenta bancaria</th>\
									</tr>\
								</thead>\
								<tbody>\
									<tr>\
										<td>:nombre: :apellido:</td>\
										<td>:cedula:</td>\
										<td>:cuenta_bancaria:</td>\
									</tr>\
								</tbody>\
							</table>\
							<hr>\
							<table class="w3-table w3-bordered">\
								<thead>\
									<tr>\
										<th>Sueldo básico Bs.</th>\
										<th>Sueldo normal Bs.</th>\
										<th>Sueldo integral Bs.</th>\
									</tr>\
								</thead>\
								<tbody>\
									<tr>\
										<td>:sueldo:</td>\
										<td>:sueldo_normal:</td>\
										<td>:sueldo_integral:</td>\
									</tr>\
								</tbody>\
							</table>\
							<hr>\
							<table class="w3-table w3-bordered">\
								<thead>\
									<tr>\
										<th>Estatus</th>\
										<th>Categoría</th>\
										<th>Cargo</th>\
										<th>Dedicación</th>\
									</tr>\
								</thead>\
								<tbody>\
									<tr>\
										<td>:estatus:</td>\
										<td>:categoria:</td>\
										<td>:cargo:</td>\
										<td>:dedicacion:</td>\
									</tr>\
								</tbody>\
							</table>\
							<br>\
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
							<div>\
								<i>\
									<small>\
										Fecha de Emisión: :fecha:<br>Hora: :hora:\
									</small>\
								</i>\
							</div>\
						</div>'
						.replace(":estado:",data.estado)
						.replace(":estatus:",data.estatus)
						.replace(":categoria:",data.categoria)
						.replace(":cargo:",data.cargo)
						.replace(":dedicacion:",data.dedicacion)
						.replace(":fecha:",data.fecha)
						.replace(":hora:",data.hora)
						.replace(":nombre:",data.nombre)
						.replace(":apellido:",data.apellido)
						.replace(":cedula:",data.cedula)
						.replace(":sueldo:",formato(data.salario))
						.replace(":sueldo_normal:",formato(data.salario_normal))
						.replace(":sueldo_integral:",formato(data.salario_integral))
						.replace(":cuenta_bancaria:",data.cuenta_bancaria)
						.replace(":recibo:",recibo_html)

						$("#body_show")
						.empty()
						.append(template_recibo)	

						$(".destinatario:input").val(data.correo)
						$("#mensaje").val()
						$("#asunto").val("Recibo de pago "+data.nombre+" "+data.apellido+"_"+data.cedula+" | "+div.replace(/_/g," "))
		}
		function d_recibo(){
			$("#g-recibo-data").val($("#d_recibo_data").html())
			$("#g-recibo").submit()			 
		}
		function buscar_de() {
			$.ajax({
				url:"mail/search_de.php",
				data:{},
				type:"post",
				datatype:"json",
				beforeSend:function(){
					
				},
				success:function(data){
					$("#resultados_de").html(data)
				}
			});
		}
		function enviar_email() {
				var desti = $(".destinatario:input")
				var de = $("#de").text()
				var msj = $("#mensaje").val()
				var asunto = $("#asunto").val()
				var err = 0;
				for(i in desti){
					if(desti[i].value==""){
						err=err+1
					}
				}
				if (err==0) {
					if (de=="") {
						alert("Elija una cuenta de la cual se enviará el mensaje")
					}else{
						if (asunto=="") {
							alert("Asunto en blanco")
						}else{
							
								$.ajax({
									url:"mail/enviar_recibo_individual.php",
									data:{
										de:de,
										msj:msj,
										asunto:asunto,
										desti:function () {
											var json = {}
											for(i in desti){												
												json[i] = desti[i].value
											}
											return JSON.stringify(json)
										},
										adjunto:$("#d_recibo_data").html()
									},
									type:"post",
									datatype:"json",
									beforeSend:function(){
										$("#seccion_divisiones").append('<div class="loading w3-display-topmiddle" style="z-index:2000"><i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i><span class="sr-only">Loading...</span></div>')
									},
									success:function(data){
										$(".loading").remove()
										$("body").append("<div onclick='$(this).remove()' class='w3-display-topmiddle w3-green' style='overflow:auto;height:500px;z-index:2030'>"+data+"</div>")
									}
								});
						}
					}
				}else{
					alert("Campo de destinatario vacío!")
				}		
		}
		function pre_send_email() {
			$('#show_data').modal('hide');
			$('#enviar_recibo_email').modal()
		}
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
		  src: url(fonts/OpenSans-Light.ttf);
		}
		html,body{
			font-family: 'Open Sans', sans-serif;
			font-size: 20px;
			zoom: 0.90;
			height: 100%;
			width: 100%;
		}	
		button,tr{
			cursor: pointer;
		}
		.switch {
		  position: relative;
		  display: inline-block;
		  width: 60px;
		  height: 34px;
		}

		.switch input {display:none;}

		.slider {
		  position: absolute;
		  cursor: pointer;
		  top: 0;
		  left: 0;
		  right: 0;
		  bottom: 0;
		  background-color: #d9534f;
		  -webkit-transition: .4s;
		  transition: .4s;
		}

		.slider:before {
		  position: absolute;
		  content: "";
		  height: 26px;
		  width: 26px;
		  left: 4px;
		  bottom: 4px;
		  background-color: white;
		  -webkit-transition: .4s;
		  transition: .4s;
		}

		input:checked + .slider {
		  background-color: #2196F3;
		}

		input:focus + .slider {
		  box-shadow: 0 0 1px #2196F3;
		}

		input:checked + .slider:before {
		  -webkit-transform: translateX(26px);
		  -ms-transform: translateX(26px);
		  transform: translateX(26px);
		}

		/* Rounded sliders */
		.slider.round {
		  border-radius: 34px;
		}

		.slider.round:before {
		  border-radius: 50%;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse bg-faded">
	  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	 
	  <a class="navbar-brand" href="#" onclick="window.location='operaciones_parametros_nomina/index.php?id='+getParameterByName('id')"><i class="fa fa-windows"></i> División de períodos</a>
	  
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
	<div class="w3-card-4 bg-warning text-white" id="show_partidas" style="/*background-color: #f5f5f5;*/display: none;width: 0%;position: absolute;z-index: 1000">
		<div class="row">
			<div class="col">
				<button class='btn btn-danger w3-right cerrar_partidas_presupuestarias'">
					<i class='fa fa-arrow-left fa-3x' aria-hidden='true'></i>
				</button>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<header class="w3-center h1">
					Partidas presupuestarias
				</header>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div id="resultados_partida">
					
				</div>
			</div>
		</div>
	</div>
	<aside class="col w3-margin-top" id="calculos">
		<div class="row">
			<div class="col w3-margin-bottom">
				<button class="btn btn-outline-warning abrir_partidas_presupuestarias" >
					<i class="fa fa-paste fa-3x"></i> Partidas presupuestarias
				</button>
				<button class="btn btn-outline-primary" id="abrir_casos_especiales">
					<i class="fa fa-street-view fa-3x"></i> Casos especiales
				</button>
				<button class="btn btn-outline-info abrir_pago_retroactivo" >
					<i class="fa fa-paste fa-3x"></i> Pago de retroactivo
				</button>
			</div>
		</div>
		<div class="row w3-margin-bottom">
			<div class="col" id="grupo_divisiones"></div>
			<div class="col-4 w3-border-bottom">
				Desde: <span class="text-primary h4" id="mostrar_fecha_inicio"></span>
				Hasta: <span class="text-primary h4" id="mostrar_fecha_cierre"></span>
			</div>
		</div>
		<div class="row">
			<div class="col table-responsive" id="seccion_divisiones">
			</div>
		</div>
	</aside>
    <div class="modal" tabindex="-1" role="dialog" id="show_data">
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
	          <button type="button" class="btn btn-info float-left" style="cursor: pointer;" email=""  onclick="pre_send_email()" id="botton_Send_email">Enviar por correo <i class="fa fa-paper-plane"></i></button>
	          <button type="button" class="btn btn-success" style="cursor: pointer;"  onclick="d_recibo()">Descargar <i class="fa fa-download"></i></button>

	        </div>
	      </div> 
	    </div>
    </div>
	<div class="modal" tabindex="-1" role="dialog" id="fechas_periodo">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-body">
			<div class="row">
				<div class="col w3-center">
					<h3 class="text-primary">Introduzca la fecha de inicio y cierre del período</h3>
				</div>
			</div>
	      	<div class="row">
	      		<div class="col-4">
	      			<div class="form-group">
	      				<label for="">Año</label>
		      			<select class="form-control" id="año">
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
	      			</div>
	      		</div>
	      		<div class="col">
	      			<div class="form-group">
	      				<label for="">Mes/Trimestre</label>
	      				<select id="meses" class="form-control">
	      					<option value="01">Enero</option>
							<option value="02">Febrero</option>
							<option value="03">Marzo</option>
							<option value="04">Abril</option>
							<option value="05">Mayo</option>
							<option value="06">Junio</option>
							<option value="07">Julio</option>
							<option value="08">Agosto</option>
							<option value="09">Septiembre</option>
							<option value="10">Octubre</option>
							<option value="11">Noviembre</option>
							<option value="12">Diciembre</option>
							<option value="1er">1er trimestre</option>
			    			<option value="2do">2do trimestre</option>
			    			<option value="3er">3er trimestre</option>
			    			<option value="4to">4to trimestre</option>
	      				</select>
	      			</div>
	      		</div>
	      	</div>
	      	<div class="row w3-margin-top">
	      		<div class="col">
	      			<div class="form-group">
	      				<label for="fecha_inicio">Fecha de Inicio</label><br>
		       			<input type="date" class="form-control" value="2018-01-01" id="fecha_inicio">
	      			</div>
		        	<div class="form-group">
		        		<label for="fecha_cierre">Fecha de Cierre</label>
		       			<input type="date" class="form-control" value="2018-01-31" id="fecha_cierre">
		        	</div>
	      		</div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-primary" onclick="validar_fechas_inicio_cierre()">Continuar</button>  
	      </div>
	    </div>
	  </div>
	</div>
	<div class="modal" tabindex="-1" role="dialog" id="enviar_recibo_email" style="width: 100%">
	  <div class="modal-dialog modal-lg" role="document" style="width: 100%">
	    <div class="modal-content w3-display-topmiddle" style="width: 100%">

	      <div class="modal-body" >
			<center>
	      	<h5 class="text-danger">Enviar por correo electrónico</h5><hr>
		    </center>
				<div class="container">

					<section>
						<div class="row w3-margin">
							<div class="col-2">
								De: <a href="#" id="search_de"><i class="fa fa-search"></i></a>
							</div>
							<div class="col" id="de"></div>
						</div>
						<div class="row w3-margin">
							<div class="col">
								Destinatarios: <a href="#" id="add_destinatarios"><i class="fa fa-plus-square"></i></a>

							</div>
							<div class="col">
								<div id="destinatarios" class="float-right">
									<input class="destinatario" class="w3-input" placeholder="Destinatario"/>
										
								</div>
							</div>
						</div>
						<div class="row w3-margin">
							<div class="col-2">
								Asunto: 
							</div>
							<div class="col">
								<textarea id="asunto" rows="2" style="width: 100%"></textarea>
							</div>
						</div>
						<div class="row w3-margin">
							<div class="col">
								<textarea style="width:100%" rows="5" placeholder="Mensaje..." class="w3-border" id="mensaje">Recibo de pago</textarea>
							</div>		
						</div>
						<div class="row w3-margin">
							<div class="col">
								Adjunto:
							</div>
							<div class="col">
								<ol>
									<li><strong>Recibo de pago.pdf</strong></li>
								</ol>
							</div>		
						</div>
					</section>
				</div>

				<div class="modal" tabindex="-1" role="dialog" id="modal_de">
				  <div class="modal-dialog modal-lg w3-card-4" role="document">
				    <div class="modal-content">

				      <div class="modal-body w3-light-grey">
				      	<center>
				      		<h5>Añadir cuenta</h5><hr>
				      	</center>
						<div class="container-fluid" id="resultados_de">
							
						</div>
				      </div>
				      <div class="modal-footer w3-light-grey">
			        	<div class="col-3">
			    			<a href="#" onclick="window.open('parametros_globales/mail/')"><i class="fa fa-cog"></i></a>
			    			<a href="#" onclick="buscar_de()"><i class="fa fa-repeat"></i></a> 	
			        	</div>
			        	<div class="col">
			        		<button type="button" class="btn btn-info float-right" onclick="$('#modal_de').modal('hide')">Acceptar</button> 
			        	</div>
				      </div>
				    </div>
				  </div>
				</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-success" onclick="enviar_email()">Enviar</button>    
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>    
	      </div>
	    </div>
	  </div>
	</div> 
	<div class="modal" tabindex="-1" role="dialog" id="casos_especiales" style="margin: 0">
      <div class="modal-content w3-display-topmiddle" style="width: 1300px">
        <div class="modal-header">
          <div class="col">
          	 <button type="button" class="close w3-left" data-dismiss="modal">&times;</button>
          </div>
          <div class="col">
          	<h4 class="w3-right text-primary"><i class="fa fa-user"></i> Casos especiales</h4>
          </div>
        </div>
        <div class="modal-body">
            <ul class="nav nav-tabs" id="tab_casos_a">
			  <li class="nav-item">
			    <a class="nav-link active" href="#incluir_excluir_p" role="tab" data-toggle="tab">Incluir/Excluir personal</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link abrir_opera_espec" href="#operaciones_particulares" role="tab" data-toggle="tab">Operaciones particulares</a>
			  </li>
			</ul>
			<hr>
			<div class="tab-content">
			  <div class="tab-pane active" id="incluir_excluir_p" role="tabpanel">
			  	<div class="row">
			  		<div class="col-1">
			  			<label class="switch">
						  <input type="checkbox" id="switch_p">
						  <span class="slider"></span>
						</label>
			  		</div>
			  		<div class="col">
			  			<div class="info_switch text-danger h4"><b>Excluir</b></div>
			  		</div>
			  		<div class="col">
			  			<button class="btn btn-outline-success w3-right guardar_incl_exclu">Guardar</button>
			  		</div>
			  	</div>
			  	<div class="row">
			  		<div class="col w3-margin w3-round-xlarge w3-panel w3-border w3-border-red contenedor_agregados">
			  			<div style="width: 100%;height: 400px;overflow-y: auto;">
			  				<div class="w3-center w3-padding w3-margin-bottom w3-border-bottom">
			  					<span class="h5">
			  						Agregados a <span class="info_switch text-danger h4">Excluir</span>
			  					</span>
			  				</div>
			  				
							<div class="list_incl_excl" style="width: 100%"></div>
			  			</div>
			  		</div>
			  		<div class="col w3-margin w3-round-xlarge w3-panel w3-border w3-hover-border-blue">
			  			<div style="width: 100%;height: 400px;overflow-y: auto;">
			  				<input type="text" class="w3-margin-top w3-input solicitar_personal_incl_excl" placeholder="Busqueda..." style="width: 50%">
			  				<table class="table">
			  					<thead>
			  						<tr class="bg-primary text-white">
			  							<th>Nombres</th>
			  							<th>C.I.</th>
			  						</tr>
			  					</thead>
			  					<tbody class="personas_incl_excl"></tbody>
			  				</table>
			  			</div>
			  		</div>
			  	</div>
			  </div>
			  <div class="tab-pane fade"  id="operaciones_particulares" role="tabpanel">
			  	<div class="row">
			  		<div class="col">
			  			<button class="btn btn-outline-primary abrir_buca_perso_opera_espec">Buscar trabajador <i class="fa fa-search"></i></button>
			  		</div>
			  		<div class="col">
			  			<button class="btn btn-outline-success w3-right guardar_oper_espe">Guardar</button>
			  		</div>
			  	</div>
			  	<div class="row">
			  		<div class="col w3-margin w3-round-xlarge w3-panel w3-border">
			  			<div style="width: 100%;height: 300px;overflow-y: auto;" class="contenedor_personas_opera_espec">
			  				<input type="text" class="w3-margin-top w3-input solicitar_personal_opera_input" placeholder="Busqueda..." style="width: 50%">
			  				<table class="table">
			  					<thead>
			  						<tr class="bg-primary text-white">
			  							<th>Nombres</th>
			  							<th>C.I.</th>
			  						</tr>
			  					</thead>
			  					<tbody class="personas_opera_espec"></tbody>
			  				</table>
			  			</div>
			  			<script type="text/javascript">
			  				$(".abrir_buca_perso_opera_espec").click(function () {
			  					$(".contenedor_personas_opera_espec").parent().animate({opacity:"toggle",height:"toggle"},200)
			  				})
			  			</script>
			  		</div>
			  	</div>
			  	<div class="row">
			  		<div class="col w3-margin w3-round-xlarge w3-panel w3-border contenedor_agregados">
			  			<div style="width: 100%;height: 600px;overflow-y: auto;">
			  				<div class="w3-center w3-padding w3-margin-bottom w3-border-bottom">
			  					<span class="h5">
			  						Seleccionados
			  					</span>
			  				</div>
							<div class="list_opera_espec" style="width: 100%"></div>
			  			</div>
			  		</div>
			  		<div class="col w3-margin w3-round-xlarge w3-panel w3-border w3-hover-border-blue" style="height: 600px;overflow-y: auto;">
			  			<div class="row w3-padding w3-margin-bottom w3-border-bottom">
		  					<div class="w3-center" style="width: 100%">
		  						<span class="h5">
			  						Operaciones
			  					</span>
		  					</div>
		  				</div>
			  			<div class="row">
			  				<div class="col">
			  					<span><i class="fa fa-user text-warning"></i></span> <span class="text-warning h4 user_adding_opera"></span>
			  				</div>
			  				<div class="col">
			  					<button class="btn btn-outline-warning w3-right agg_opera_espec"><i class="fa fa-plus"></i></button>
			  				</div>
			  			</div>
						<div class="row w3-margin-top">
							<div class="col">
								<div class="ver_opera_espec" style="width: 100%;height: 400px;">
									
								</div>
							</div>
						</div>
			  		</div>
			  	</div>
			  </div>
			</div>
        </div>
      </div> 
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="modal_pago_retroactivo">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	        <div class="modal-header">
	          <div class="col">
	          	 <button type="button" class="close w3-left" data-dismiss="modal">&times;</button>
	          </div>
	          <div class="col">
	          	<h4 class="w3-right text-primary"><i class="fa fa-user"></i> Pago de retroactivo</h4>
	          </div>
	        </div>
	      <div class="modal-body">
			<div class="row">
				<div class="col">
					<div class="form-group">
						<label for="">Pagar retroactivo</label>
						<input type="checkbox" class="w3-check" id="confirm_retroactivo">
					</div>
				</div>
			</div>
	      	<div class="row">
	      		<div class="col-4">
	      			<div class="form-group">
						<label for="">Con respecto a la fecha de aumento:</label>
						<input type="date" class="form-control" id="fecha_retroactivo" value="2018-01-01">
					</div>
	      		</div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-primary" onclick="buscar()">Continuar</button>  
	      </div>
	    </div>
	  </div>
	</div>
</body>
</html>