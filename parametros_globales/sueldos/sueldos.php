<?php 
	session_start();
	include '../../conexion_bd.php'; 
	$valores = (new sql("valores_globales","WHERE id='1'"))->select()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title> .: Tabla de sueldos:.</title>
		<link rel="stylesheet" type="text/css" href="../../css/w3.css">
		<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
		<script type="text/javascript" src="../../js/formato_moneda.js"></script>
		<script type="text/javascript" src="../../js/jquery.js"></script>
		<script src="../../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../../css/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		function validar_cedula(e){
			tecla=(document.all) ? e.keyCode: e.which;
			if (tecla == 8) return true;
			patron =/[0-9]/;
			te=String.fromCharCode(tecla);
			return patron.test(te);
		}
	</script>
	<script type="text/javascript">
		var opciones_correctas = <?php echo $valores['cat_car_dedic']; ?>;
		$(document).ready(function () {
		 	buscar()
		 	$("#buscar").keyup(buscar)

		 	const cat = $("#categoria, #editar_categoria")
		 	const car = $("#cargo, #editar_cargo")
		 	const dedic = $("#dedicacion, #editar_dedicacion")
			for(i in opciones_correctas){
				cat.append('<option value="'+i+'">'+i+'</option>')
			}
			cat.change(function() {
				if ($(this).val()!="-Seleccione-") {
					
					var cargo = opciones_correctas[$(this).val()]['cargo'];
					var dedicacion = opciones_correctas[$(this).val()]['dedicacion'];
					
					dedic.attr("disabled",false)
					car.attr("disabled",false)
					car.empty();
					dedic.empty();

					for(i in cargo){						
						car.append("<option value='"+cargo[i]+"'>"+cargo[i]+"</option>")
					}

					for(i in dedicacion){	

						dedic.append("<option value='"+dedicacion[i]+"'>"+dedicacion[i]+"</option>")
					}	
				}else{
					car.empty();
					dedic.empty();

					dedic.attr("disabled",true)
					car.attr("disabled",true)
				}
			});

			$("input[name='bs_o_porcen']").click(function () {
				var val = $(this).val()
				var all = $(".valor_individual_aumento")
				var one = $("#i_aplicar_todos")
				var formatear = 'formatear(this,this.value.charAt(this.value.length-1));'

				var siblic = "$(this).parents('.form-control').siblings('table').find('#tabla_aumento_sueldo').find('.valor_individual_aumento').val($(this).val());"
			
				all.val("")
				one.val("")
				if (val=="bs") {
					
					all.attr({'onkeyup':formatear+siblic})
					all.removeAttr('onKeyPress')
					all.removeAttr('disabled')
					
					one.attr({'onkeyup':formatear+siblic, "onKeyPress":""})
					one.removeAttr('onKeyPress')
					one.removeAttr('disabled')

					var va_ = $(".value_porcen")
					var va_c = $(".value_porcen_control")
					va_.remove()
					va_c.remove()

				}else if(val=="porcen"){
					var i_sueldo_last_individual = "$(this).siblings('.valor_individual_aumento').val(formato(Number($(this).siblings('.i_sueldo_last').val())+Number($(this).val()*$(this).siblings('.i_sueldo_last').val()/100)))"

					var i_sueldo_last_control = "$('.value_porcen').val(this.value);var inp = $('.valor_individual_aumento').toArray();for(i in inp){var bro=$(inp[i]).siblings('.i_sueldo_last').val();$(inp[i]).val(formato(Number(bro)+Number(bro*this.value/100)))}"
					

					all.attr({'onkeyup':siblic,"disabled":"true"})
					
					one.attr({'onkeyup':siblic,"disabled":"true"})
					
					$(".valor_individual_aumento").parents('td').append('<input type="text" class="value_porcen" size="3" maxlength="3" onkeyup="'+i_sueldo_last_individual+'" placeholder="%" onKeyPress="return validar_cedula(event)"/>')
					$(".input_control").append('<input type="text" class="value_porcen_control" size="3" maxlength="3" onkeyup="'+i_sueldo_last_control+'" placeholder="%" onKeyPress="return validar_cedula(event)"/>')

					

					
				}
			})
			$("#file_txt").on("submit", function(e){
	            e.preventDefault();
	            var f = $(this);
	            var formData = new FormData(document.getElementById("file_txt"));
	            //formData.append("dato", "valor");
	            formData.append(f.attr("name"), $("#cargar_txt"));
	            $.ajax({
	                url: "cargar_txt.php",
	                type: "post",
	                dataType: "html",
	                data: formData,
	                cache: false,
	                beforeSend:function () {
	                	$("#file_txt").find('.col_cargando').append('<div id="loading_center" style=""><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i><span class="sr-only">Loading...</span></div>')
	                },
	                contentType: false,
		    		processData: false
	            })
	                .done(function(res){
	                  $("#loading_center").remove()
	                  //alert(res)
	                  //$("#aumento_sueldo").append("<div class='w3-display-topmiddle w3-light-grey'>"+res+"</div>")
	                  var obj_file = JSON.parse(res)
	                  for(i in obj_file){
	                  	var categoria = obj_file[i].categoria
						var cargo = obj_file[i].cargo
						var dedicacion = obj_file[i].dedicacion
						var fecha = obj_file[i].fecha
						var salario = obj_file[i].salario


						var select = $("#tabla_aumento_sueldo").find(".td_categoria[name='"+categoria+"']").parents('tr').find(".td_cargo[name='"+cargo+"']").parents('tr').find(".td_dedicacion[name='"+dedicacion+"']").parents('tr')

						select.find('.valor_individual_aumento').val(formato(salario))
						select.find('.td_fecha').val(fecha)
						//alert(cargo)
	                  }
	                 // alert(res)
				  	   

	                });
	        });
	        $("#cargar_to_aumento").on('click',function() {
		
				$("#aumento_sueldo").modal()
				$("#tabla_aumento_sueldo").empty()
				$("#fecha_aplicar_todos").val("")
				$("#i_aplicar_todos").val("")
				$("#en_bs").prop("checked",true)

				if (obj!=undefined) {
					for(i in obj){
						var html = "<tr>"

						html+="<td>"+i+"</td>"
						html+="<td><input type='text' class='td_categoria w3-round-large w3-input' disabled name='"+obj[i].categoria+"' value='"+obj[i].categoria+"'/></td>"
						html+="<td><input type='text' class='td_cargo w3-round-large w3-input' disabled name='"+obj[i].cargo+"' value='"+obj[i].cargo+"'/></td>"
						html+="<td><input type='text' class='td_dedicacion w3-round-large w3-input' disabled name='"+obj[i].dedicacion+"' value='"+obj[i].dedicacion+"'/></td>"
						html+="<td><input type='date' min='2000-01-02' class='td_fecha' class='w3-round-large'></td>"
						html+="<td><input type='text' placeholder='Valor' class='valor_individual_aumento w3-blue w3-input w3-border w3-round-large w3-right' onkeyup='formatear(this,this.value.charAt(this.value.length-1))'><input type='text' class='i_sueldo_last' value='"+Object.values(obj[i].salario)[Object.values(obj[i].salario).length-1]+"' hidden disabled/></td>"
						html+="</tr>"
						$("#tabla_aumento_sueldo").append(html)

					}
				}
			})
			$(document).on("mouseenter",".editable",
		        function(){
		            var m = $("#editable_menu")
			    	var ele = $(this)
			    	var botto = m.find(".operaciones_div")
			    	var select = m.find("#data_selected")
			    	m.css({ 
			    		'left': parseFloat(ele.offset().left-botto.width()), 
			    		'top': parseFloat(ele.offset().top),
			    		'opacity': 1,
			    		'height': ele.height()

			    		
			    	})
			    	botto.css({ 
			    		'height': ele.height()
			    		
			    	})
			    	var index = $('.editable').index(ele)
			    	select.val(index)
			    	      
		        }
		    ).on("mouseleave","#editable_menu",
		        function(){
		            $("#editable_menu").css('opacity','0');   
		        }
		    )
		    $('#editar_show').on('click',function(){
		    	var modal = $("#editar_sueldo")
		    	var numeral = $("#editable_menu").find("#data_selected").val()
		    	
		    	var tr = $(".editable").toArray()[numeral]

		    	var t_sala = $(tr).find("td:eq(3)").find("table tr").toArray()
		    	
		    	var fechas = $(t_sala[0]).find('th').toArray()
		    	var salarios = $(t_sala[1]).find('td').toArray()

		    	$("#editar_categoria").val($(tr).find('td:eq(0)').text())
		    	$("#editar_cargo").val($(tr).find('td:eq(1)').text())
		    	$("#editar_dedicacion").val($(tr).find('td:eq(2)').text())


		    	var html_salarios = "<h3>Salarios </h3><table class='table table-striped'><thead><tr><th>Fecha</th><th>Monto Bs.</th><th></th></tr></thead><tbody>"
		    	for(i in fechas){
		    		html_salarios += "<tr>\
						<td><input type='date' min='2000-01-02' class='fecha_edit_reference' hidden value='"+$(fechas[i]).text()+"'/><input type='date' min='2000-01-02' class='fecha_editar w3-input w3-border w3-round-large w3-teal' placeholder='Salario en Bs.' value='"+$(fechas[i]).text()+"'/></td>\
						<td><input type='text' class='monto_edit_reference' hidden value='"+$(salarios[i]).text()+"'/><input type='text' class='monto_editar w3-input w3-border w3-round-large w3-blue' placeholder='Salario en Bs.' value='"+$(salarios[i]).text()+"' onkeyup='formatear(this,this.value.charAt(this.value.length-1))'/></td><td class='estatus_edit_sueldo'></td>\
		    		</tr>"
		    	}
		    	html_salarios += "</tbody></table>"

		    	modal.modal()
		    	modal.find(".numeral_sueldo").val(numeral)

		    	$("#salarios_edit_tabla")
		    	.empty()
		    	.append(html_salarios)
		    }) 
		    $('#enviar_edicion').on('click',function(){
		    	$.ajax({
			        url:"procesar.php",
			        data:{
						"operacion":'editar',
						"categoria":$('#editar_categoria').val(),
						"cargo":$('#editar_cargo').val(),
						"dedicacion":$('#editar_dedicacion').val(),
						values:function(){

							var tr = $("#salarios_edit_tabla").find("table tbody tr").toArray()
							var json = {}
							for(i in tr){
								var date = $(tr[i]).find(".fecha_edit_reference")
								var val = $(tr[i]).find(".monto_edit_reference")

								var bro_date = date.siblings('td input[type=date]').val()
								var bro_monto = val.siblings('td input[type=text]').val().replace(/\./g,"").replace(/,/g,'.').replace(/\.00/,"")
								if (bro_monto!="" && bro_monto!=0 && bro_date!="") {
									json[i] = {
										fecha_reference:date.val(),
										monto_reference:val.val().replace(/\./g,"").replace(/,/g,'.').replace(/\.00/,""),
										fecha_new:bro_date,
										monto_new:bro_monto
									}
								}
								
							}
							return JSON.stringify(json)
						}
						
			   		},
			        type:"post",
			        datatype:"json",
			        beforeSend:function () {
			        	$(".estatus_edit_sueldo").append('<div><i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i><span class="sr-only">Loading...</span></div>')
			        },
			        success:function(res)
			        {	//document.write(response)
			        	var tr = $("#salarios_edit_tabla").find("table tbody tr").toArray()
			        	$(".estatus_edit_sueldo").empty()
			        	var res_obj = JSON.parse(res)
			        	for(i in res_obj){
			        		$(tr[i]).find('.estatus_edit_sueldo')
			        		.append(res_obj[i])
			        		if (res_obj[i].indexOf("Actualizado")!=-1) {
			        			$(tr[i]).find('td .monto_edit_reference').val($(tr[i]).find('td .monto_editar').val())
			        			$(tr[i]).find('td .fecha_edit_reference').val($(tr[i]).find('td .fecha_editar').val())
			        			buscar()
			        		}
			        	}

			        }			  
			    })
		    })
		    $('#eliminar_show').on('click',function(){
		    	$("#eliminar_sueldo").modal()
		    	var numeral = $("#editable_menu").find("#data_selected").val()
		    	
		    	var tr = $(".editable").toArray()[numeral]

		    	$("#eliminar_categoria").val($(tr).find('td:eq(0)').text())
		    	$("#eliminar_cargo").val($(tr).find('td:eq(1)').text())
		    	$("#eliminar_dedicacion").val($(tr).find('td:eq(2)').text())
		    	$(".numeral_sueldo").val(numeral)
				
				var t_sala = $(tr).find("td:eq(3)").find("table tr").toArray()
		    	
		    	var fechas = $(t_sala[0]).find('th').toArray()
		    	var salarios = $(t_sala[1]).find('td').toArray()

		    	var html_salarios = "<h3>Salarios </h3><table class='table table-bordered'><thead><tr><th>Seleccione</th><th>Fecha</th><th>Monto Bs.</th></tr></thead><tbody>"
		    	for(i in fechas){
		    		html_salarios += "<tr><td><input type='checkbox' class='w3-check select_delete'/></td>\
						<td class='fecha_delete'>"+$(fechas[i]).text()+"</td>\
						<td class='salario_delete'>"+$(salarios[i]).text()+"</td>\
		    		</tr>"
		    	}
		    	html_salarios += "</tbody></table>"

		    	$("#salarios_delete_tabla")
		    	.empty()
		    	.append(html_salarios)
		    })
		    $("#action_borrar").on('click',function(){
		    	var json_delete = {}
		    	var numeral = $("#editable_menu").find("#data_selected").val()
				var tr = $(".editable").toArray()[numeral]

		    	if($(".option_borrar").find("#salarios_delete_tabla").length==1){
		    		//Tabla
		    		var tr_delete = $("#salarios_delete_tabla").find('tbody tr').find('input[type=checkbox]:checked').toArray()
		    		json_delete['modo'] = {}

		    		for(i in tr_delete){
		    			var t = $(tr_delete[i]).parent('td')
		    			json_delete['modo'][i] = {fecha:t.siblings('.fecha_delete').text(),salario:t.siblings('.salario_delete').text().replace(/\./g,"").replace(/,/g,'.').replace(/\.00/,"")}
		    			
		    			
		    		}
		    	}else{
		    		json_delete['modo'] = "borrar_todos" 

		    	}
		    	if (JSON.stringify(json_delete)!='{"modo":{}}') {
			    	if (confirm("Está a punto de borrar un salario, tenga en cuenta que la eliminación de este, implica la imposibilidad de cálculo en algunos puntos de la nómina. ¿Realmente desea continuar?")) {
			    		$.ajax({
					        url:"procesar.php",
					        data:{
								"operacion":'eliminar',
								"categoria":$('#eliminar_categoria').val(),
								"cargo":$('#eliminar_cargo').val(),
								"dedicacion":$('#eliminar_dedicacion').val(),
								"values":JSON.stringify(json_delete)	
					   		},
					        type:"post",
					        datatype:"json",
					        beforeSend:function () {
					        	//$(".estatus_edit_sueldo").append('<div><i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i><span class="sr-only">Loading...</span></div>')
					        },
					        success:function(res)
					        {	//document.write(response)
					        	try{
						        	var obj_delete = JSON.parse(res)
						        	for(i in obj_delete){
						        		if (i=="todos") {
						        			if(obj_delete[i]=="Exito al eliminar"){
						        				alert(obj_delete[i])
						        				$("#eliminar_sueldo").modal('hide')
				    							
				    							$(tr).remove()

						        			}else{
						        				alert(obj_delete[i])
						        			}
						        		}else{
						     				
						     				if(Object.keys(obj_delete[i])=="err"){
						     					alert(obj_delete[i]['err'])
						     				}else{
					     						if ($(tr).find('td:eq(3) td').length==1) {
					    							$(tr).remove()
							        				$("#eliminar_sueldo").modal('hide')

								        			alert("Exito al eliminar")

							        			}else{
							        				for(fecha in obj_delete[i]['indiv']){
								        				$(tr).find('td:eq(3) th:contains('+fecha+')').remove()
								        				$(tr).find('td:eq(3) td:contains('+formato(obj_delete[i]['indiv'][fecha])+')').remove()
								        				$("#salarios_delete_tabla").find('.fecha_delete:contains('+fecha+')').parent().find('.salario_delete:contains('+formato(obj_delete[i]['indiv'][fecha])+')').parent().remove()
								        				alert("Exito al eliminar")       				
								        			}		
							        			}	
						     				}
					        		
						        		}
						        	}
						        }
					        	catch(err){
			        				alert(err.message)
			        			}
					        }			  
					    })
			    	}
		    	}else{
		    		alert("Seleccione...")
		    	}
		    })
			
		})
		
		function buscar() {
		   $.ajax({
		        url:"procesar.php",
		        data:{
					"operacion":'buscar',
					"busqueda":$('#buscar').val()
					
		   		},
		        type:"post",
		        datatype:"json",
		        beforeSend:function () {
		        	$("#cuerpo_s").append('<div><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>')
		        },
		        success:function(response)
		        {	//document.write(response)
		        	
					$("#cuerpo_s").empty()
		        	obj = JSON.parse(response);	
		        	for(i in obj){
		        		var html = "<tr class='editable'>\
					      <th scope='row'>"+i+"</th>\
					      <td>"+obj[i].categoria+"</td>\
					      <td>"+obj[i].cargo+"</td>\
					      <td>"+obj[i].dedicacion+"</td><td><table class='w3-table'>\
					      	<thead>\
					      		<tr>"
					      for(fecha in obj[i].salario){
					      	html+="<th>"+fecha+"</th>"
					      		
					      }
					      html+="</tr></thead><tbody><tr>"
 
					      for(fecha in obj[i].salario){
					      	html+="<td>"+formato(obj[i].salario[fecha])+"</td>"	
					      }
					      html+="</tr></tbody>"
					    html+="</tr>"
		        		$("#cuerpo_s").append(html)

		        	}

		        }			  
		   })
		}	
		function guardar_new_sueldo() {
			if ($('#categoria').val()!="-Seleccione-" && $('#salario').val()!="" && $('#fecha_vigencia').val()!="") {
				$.ajax({
			        url:"procesar.php",
			        data:{
						"operacion":'add_sueldo',
						"categoria":$('#categoria').val(),
						"cargo":$('#cargo').val(),
						"dedicacion":$('#dedicacion').val(),
						"salario":$('#salario').val().replace(/\./g,"").replace(/,/g,'.').replace(/\.00/,""),
						"fecha_vigencia":$('#fecha_vigencia').val()
						
			   		},
			        type:"post",
			        datatype:"json",
			        beforeSend:function () {
			        	
			        },
			        success:function(response)
			        {	//document.write(response)
			        	alert(response)
			        	buscar()
			        	
			        }			  
			    })
			}else{
				alert("Campo vacío. Por favor revise!")
			}
		}
		function guardar_new_aumento() {
			var trs = $("#tabla_aumento_sueldo").find('tr')
			var erros = ""
			
				var values = ""

				trs.each(function (i,tr) {
					var id = $(tr).find('td:eq(0)').text()
					var categoria = $(tr).find('td:eq(1)').find('.td_categoria').val()
					var cargo = $(tr).find('td:eq(2)').find('.td_cargo').val()
					var dedicacion = $(tr).find('td:eq(3)').find('.td_dedicacion').val()
					var fecha = $(tr).find('td:eq(4)').find('input').val()
					var salario = $(tr).find('td:eq(5)').find('input').val().replace(/\./g,"").replace(/,/g,'.').replace(/\.00/,"")
					
					if (salario=="" || salario==0 || fecha=="") {
						erros+="#"+id
					}else{
						values += "("+ 
						"'"+ categoria +"'," + 
						"'"+ cargo +"'," + 
						"'"+ dedicacion +"'," + 
						"'"+ salario +"',"  +
						"'"+ fecha +"'" + 

						"),"
					}
				})
				values = values.substr(1,values.length-3)
			
			if (erros!="") {
				if(confirm("Por lo menos un campo esta Vacío, desea continuar?")){
					send(values)
				}
			}else{
				send(values)
			}
			function send(v) {
				$.ajax({
			        url:"procesar.php",
			        data:{
						"operacion":'add_aumento',
						"values":v
						
			   		},
			        type:"post",
			        beforeSend:function () {
			        	$("#body").append('<div id="loading_center" class="w3-display-topmiddle" style="z-index:3000"><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i><span class="sr-only">Loading...</span></div>')
			        },
			        success:function(response)
			        {	//document.write(response)
			        	alert(response)
			        	buscar()
			        	
			        }			  
			    })
			}
		}
		function formatear(donde,caracter,campo){
			dec = 2
			decimales = true
			pat = /[\*,\+,\(,\),\?,\\,\$,\[,\],\^]/
			valor = donde.value
			largo = valor.length
			crtr = true
			if(isNaN(caracter) || pat.test(caracter) == true)
			    {
			    if (pat.test(caracter)==true)
			        {caracter = "\\" + caracter}
			    carcter = new RegExp(caracter,"g")
			    valor = valor.replace(carcter,"")
			    donde.value = valor
			    crtr = false
			    }
			else
			    {
			    var nums = new Array()
			    cont = 0
			    for(m=0;m<largo;m++)
			        {
			        if(valor.charAt(m) == "," || valor.charAt(m) == " " || valor.charAt(m) == ".")
			            {continue;}
			        else{
			            nums[cont] = valor.charAt(m)
			            cont++
			            }
			        }
			    }
			if(decimales == true) {
			    ctdd = eval(1 + dec);
			    nmrs = 1
			    }
			else {
			    ctdd = 1; nmrs = 3
			    }

			var cad1="",cad2="",cad3="",tres=0
			if(largo > nmrs && crtr == true){
			    for (k=nums.length-ctdd;k>=0;k--){
			        cad1 = nums[k]
			        cad2 = cad1 + cad2
			        tres++
			        if((tres%3) == 0){
			            if(k!=0){
			                cad2 = "." + cad2
			                }
			            }
			        }
			    for (dd = dec; dd > 0; dd--)   
			    {cad3 += nums[nums.length-dd] }
			    if(decimales == true)
			    {cad2 += "," + cad3}
			     donde.value = cad2
			}
			donde.focus()
		}
	</script>
	<style type="text/css">
		@font-face {
		  font-family: 'Open Sans';
		  font-style: italic;
		  font-weight: 400;
		  src: url(../../fonts/OpenSans-Light.ttf);
		}
		html,body{
			font-family: 'Open Sans', sans-serif;
			font-size: 20px;
			zoom: 0.90;
			height: 100%;
			width: 100%;
			overflow: hidden;
			padding-left: 30px;
		}
		.editable:hover{
			background-color: #5D7F9A;
			color:white;
			cursor: pointer;
		}
		button{
			cursor: pointer;
			padding: 0px
		}	
		.option_borrar{
			
			width: 100%;
			cursor:pointer;
			margin-bottom: 20px;
			padding: 10px;
			border-radius: 20px;
			border:2px #0065FF solid ;
			background-color: #AACCFF;
			transition:1s;
			zoom: 1.5;

		}
		.option_borrar_select{
			filter: grayscale(100%);
			overflow-y:auto;
			opacity: 0.5;
			zoom: 0.5;
			cursor:pointer;
			margin-bottom: 20px;
			padding: 10px;
			border-radius: 20px;
			border:2px #FF0036 solid ;
			opacity: 0.8;
			transition:1s;

		}
	</style>
</head>
<body>
	<aside style="height: 100%;overflow: auto;">
		<center><header class="header w3-header"><h1>Configurar tabla de sueldos</h1></header></center>

		<input type="text" class="w3-input" placeholder="Buscar..." id="buscar" autocomplete="off">
		<hr>
			<button class="w3-button w3-teal" onclick='$("#agregar_sueldo").modal()' style="border-radius: 5px">
				<i class="fa fa-plus" aria-hidden="true"></i> 
				Agregar sueldo particular
			</button>
			
			<button class="w3-button w3-blue w3-right" id="cargar_to_aumento" style="border-radius: 5px">
				<i class="fa fa-arrow-up" aria-hidden="true"></i> 
				Nuevo aumento de sueldo
			</button>
		<hr>
		<table class="table table-bordered">
		  <thead>
		    <tr>
		      <th>#</th>
		      <th>Categoría</th>
		      <th>Cargo</th>
		      <th>Dedicación</th>
		      <th><center>Salario</center></th>
		    </tr>
		  </thead>
		  <tbody id="cuerpo_s">
		
		  </tbody>
		</table>
	</aside>
	<aside>
		<div class="modal fade" id="agregar_sueldo">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Agregar sueldo</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body w3-light-grey">
		        	<div class="form-group">
					    <label for="categoria">Categoría</label>
					  	 <select class="form-control" id="categoria">
					  	 	<option>-Seleccione-</option>   
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
				    	<label for="fecha_vigencia">Inicio de vigencia</label>
					  	<input type="date" min="2000-01-02" class="form-control" id="fecha_vigencia">
				 	</div>
				 	<div class="form-group">
				    	<label for="salario">Salario Bs.</label>
					  	<input type="text" class="form-control" placeholder="Salario en Bs." id="salario" onkeyup="formatear(this,this.value.charAt(this.value.length-1))">
				 	</div>
		      </div>
		      <div class="modal-footer w3-light-grey">
		        <button type="button" class="btn btn-secondary" onclick="guardar_new_sueldo()">Guardar</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>

		<div class="modal modal-wide" id="aumento_sueldo">
			<div class="modal-dialog modal-lg" role='document'>
			    <div class="modal-content w3-display-topmiddle" style="width: 1500px;">
			      <div class="modal-header">
				        <h5 class="modal-title">Aumento de sueldo</h5>
				        <div>
				        	<button type="button" class="btn btn-secondary" onclick="guardar_new_aumento()">Guardar</button>
				      		<button type="button" class="btn btn-danger" onclick="$('#aumento_sueldo').modal('hide')"><span aria-hidden="true">&times;</span></button>
				        </div>
			      </div>
			      <div class="modal-body">

						<div class="form-check">
						  <input class="w3-radio" type="radio" name="bs_o_porcen" id="en_bs" value="bs" checked>
						  <label class="form-check-label" for="en_bs">
						    En Bs.
						  </label>
						</div>
						<div class="form-check">
						  <input class="w3-radio" type="radio" name="bs_o_porcen" id="en_porcen" value="porcen">
						  <label class="form-check-label" for="en_porcen">
						    En % (porcentaje)
						  </label>
						</div>	
						<hr>
						<div class="form-control">
							<form id="file_txt" enctype="multipart/form-data" method="post">
								<div class="row">
									<div class="col">
										<h3 style="margin: 5px" class="text-info">Cargar desde <strong>(.txt)</strong> <i class="fa fa-info-circle fa-3" style="cursor: pointer;" aria-hidden="true" onclick="help=$(this).parent().siblings('div');help.css('display')=='none'?help.css('display',''):help.css('display','none')"></i></h3>
										<div class="alert alert-info w3-card-4" style="position: absolute;display: none;z-index: 100">
											  <h4 class="alert-heading">Instrucciones...</h4>
											  <hr>
											  <ol>
											  	<li>
											  		Deberá seguir la siguiente estructura en su hoja de cálculo:
											  		<hr>
											  		<table class="table table-inverse table-bordered">
											  			<tr>
											  				<td>CATEGORÍA</td>
											  				<td>CARGO</td>
											  				<td>DEDICACIÓN</td>
											  				<td>INICIO_DE_VIGENCIA (AAAA-MM-DD)</td>
											  				<td>SALARIO</td>
											  			</tr>
											  			<tr>
											  				<td>CATEGORÍA</td>
											  				<td>CARGO</td>
											  				<td>DEDICACIÓN</td>
											  				<td>INICIO_DE_VIGENCIA (AAAA-MM-DD)</td>
											  				<td>SALARIO</td>
											  			</tr>
											  			<tr>
											  				<td>CATEGORÍA</td>
											  				<td>CARGO</td>
											  				<td>DEDICACIÓN</td>
											  				<td>INICIO_DE_VIGENCIA (AAAA-MM-DD)</td>
											  				<td>SALARIO</td>
											  			</tr>
											  			<tr>
											  				<td>CATEGORÍA</td>
											  				<td>CARGO</td>
											  				<td>DEDICACIÓN</td>
											  				<td>INICIO_DE_VIGENCIA (AAAA-MM-DD)</td>
											  				<td>SALARIO</td>
											  			</tr>
											  			<tr>
											  				<td>CATEGORÍA</td>
											  				<td>CARGO</td>
											  				<td>DEDICACIÓN</td>
											  				<td>INICIO_DE_VIGENCIA (AAAA-MM-DD)</td>
											  				<td>SALARIO</td>
											  			</tr>

											  		</table>
											  	</li>
											  	<hr>
											  	<li>
											  		<ul>
											  			<li>
											  				<p><strong>CATEGORÍA, CARGO y DEDICACIÓN</strong> deberán ser iguales a lo configurado en los valores globales, de lo contrario, el campo no será reconocido.</p>
											  			</li>
											  			<li>
											  				<p>El formado del SALARIO debe usar los puntos (.) como separador de millares y la coma (,) como separador de decimales.</p>
											  			</li>
											  		</ul>
											  	</li>
											  	<hr>
											  	<li>
											  		<p>
											  			Exporte de <strong>OpenOffice Calc</strong> o <strong>Microsoft Excel</strong> el documento como <strong>Texto (delimitado por tabulaciones) (*.txt)</strong>
											  		</p>
											  	</li>
											  	<hr>
											  	
											  	<li>
											  		<p>Cargue al sistema un documento de texto plano <strong>.txt</strong></p>
											  	</li>
											  
											  </ol>
										</div>
									</div>
									<div class="col">
										<input type="file" id="cargar_txt" name="cargar_txt" class="w3-input w3-border w3-round-large">
									</div>
									<div class="col">
										
										<div class="row">
											<button class="btn btn-success col" type="submit">Cargar</button>
											<div class="col_cargando col-lg-3"></div>

										</div>
									</div>
								</div>
							</form>
						</div>
						<hr>
						<div class="form-control">
							<div class="row">
								<div class="col">
									<h3 style="margin: 5px" class="text-info">Aplicar a todos:</h3>
								</div>
							    <div class="col">
							      
							      <input class="w3-input w3-border w3-round-large mb-2" id="fecha_aplicar_todos" type="date" min="2000-01-02" onkeyup="$(this).parents('.form-control').siblings('table').find('#tabla_aumento_sueldo').find('.td_fecha').val($(this).val())">
							    </div>
							    <div class="col input_control">
							      <input class="w3-input w3-border w3-round-large mb-2" id="i_aplicar_todos" type="text" placeholder="Valor" onkeyup="formatear(this,this.value.charAt(this.value.length-1));$(this).parents('.form-control').siblings('table').find('#tabla_aumento_sueldo').find('.valor_individual_aumento').val($(this).val())">
							    </div>
						    </div>	
						</div>
						<br>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Id</th>
									<th>Categoría</th>
									<th>Cargo</th>
									<th>Dedicación</th>
									<th>Inicio de vigencia</th>
									<th>Valor</th>
								</tr>
							</thead>
							<tbody id="tabla_aumento_sueldo">
								
							</tbody>
						</table>
			      </div>
			    </div>
			</div>
		</div>

		<div class="modal fade" id="editar_sueldo">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Editar sueldo # <input type="text" class="numeral_sueldo" size="1"  disabled=""></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body w3-light-grey">
		        	<div class="form-group">
					    <label for="categoria">Categoría</label>
					  	 <input disabled="" class="form-control" id="editar_categoria">
					</div>

					<div class="form-group">
					    <label for="dedicacion">Dedicación</label>
					  	 <input disabled="" class="form-control" id="editar_dedicacion">
					</div>
					<div class="form-group">
				    	<label for="cargo">Cargo</label>
					  	 <input disabled="" class="form-control" id="editar_cargo">
				 	</div>
				 	<div id="salarios_edit_tabla">
				 		
				 	</div>
		      </div>
		      <div class="modal-footer w3-light-grey">
		        <button type="button" class="btn btn-secondary" id="enviar_edicion">Guardar</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>

		<div class="modal fade" id="eliminar_sueldo">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Eliminar salario # <input type="text" class="numeral_sueldo" size="1"  disabled=""></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body w3-light-grey">
			        <div class="row">
			        	<div class="form-group col">
						    <label for="categoria">Categoría</label>
						  	 <input disabled="" class="form-control" id="eliminar_categoria">
						</div>

						<div class="form-group col">
						    <label for="dedicacion">Dedicación</label>
						  	 <input disabled="" class="form-control" id="eliminar_dedicacion">
						</div>
						<div class="form-group col">
					    	<label for="cargo">Cargo</label>
						  	 <input disabled="" class="form-control" id="eliminar_cargo">
					 	</div>
			        </div>
			        	<span style="background-color: #AACCFF">__</span> Seleccionado
						<span style="background-color: white">__</span> Deseleccionado <br>	
						<hr>
					<div>
						<div class="option_borrar w3-card-4" onclick="$(this).removeClass('option_borrar_select');$(this).addClass('option_borrar');var bro=$(this).siblings('div');bro.removeClass('option_borrar');bro.addClass('option_borrar_select')">
							<center><h1>Borrar todos</h1>
								<p>Se borrarán todos los salarios asociados a esta Categoría, Cargo y dedicación</p>
							</center>
						</div>
						<div class="option_borrar_select w3-card-4" onclick="$(this).removeClass('option_borrar_select');$(this).addClass('option_borrar');var bro=$(this).siblings('div');bro.removeClass('option_borrar');bro.addClass('option_borrar_select')">
							<div id="salarios_delete_tabla">
				 			</div>
						</div>
					</div>

				 	
		      </div>
		      <div class="modal-footer w3-light-grey">
		        <button type="button" class="btn btn-secondary" id="action_borrar">Borrar</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>
	</aside>

	<div id="editable_menu" class="" style="position: absolute;z-index: 1;opacity:0">
		<div class="btn-group-vertical mr-2 operaciones_div" role="group">
	     <button type="button" style="height: 50%" class="btn w3-blue" id="editar_show"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
	     <button type="button" style="height: 50%" class="btn w3-red" id="eliminar_show"><i class="fa fa-ban" aria-hidden="true"></i></button>
	  	</div>
	  	<textarea hidden="" disabled="" id="data_selected"></textarea>
	</div>
</body>
</html>


