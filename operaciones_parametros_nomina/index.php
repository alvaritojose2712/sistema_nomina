<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> .: Creador | Divisiones :.</title>
	<link rel="stylesheet" type="text/css" href="../css/w3.css">
	<link rel="stylesheet" type="text/css" href="../css/font.css">
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">

	<script type="text/javascript" src="../js/formato_moneda.js"></script>
	<script type="text/javascript" src="../js/param_url.js"></script>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery.cookie.js"></script>
  		<script src="../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../css/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript">

	    $(document).ready(function () {	
			f_disponibles()  
			if(getParameterByName('id')!=''){
				$.ajax({
			        url:"proceso.php",
			        data:{
						accion:'buscar',
						id_nomina:getParameterByName('id')	
			   		},
			        type:"post",
			        async:false, 
			        datatype:"json",
			        success:function(response)
			        {	
			        	//alert(response)
			        	var obj = JSON.parse(response)
			        	$("#nombre_nomina").val(obj.denominacion)
			        	$("#tipo_periodo").val(obj.tipo_periodo)
			        	$("#engine").val(obj.engine)
						var f_a_pagar = JSON.parse(obj.formulas_a_pagar)
						for(i in f_a_pagar){
							var check_bro = $("#repositorio_f").find('tr').find('td:eq(0)').toArray()
							for(ii in check_bro){
								if ($(check_bro[ii]).text()==i) {
									$(check_bro[ii]).siblings('td:eq(2)').children('input').prop('checked',true)
								}
							}
						}
						
						var divisiones = JSON.parse(obj.divisiones)
						for(i in divisiones){
							if ($("#d-head > button").length==0) {
				    			turn=' active'
				    			turn_show="''"
				    		}else{ 
				    			turn=""
				    			turn_show='none'}
							
							$("#d-head").append('<button type="button" class="btn btn-primary'+turn+'" onclick="nav(this);" id="'+i+'"  title="Haga DobleClick para Acciones especiales" ondblclick="a_especi(this,event)">'+i.replace(/_/g," ")+'</button>')

							var html_divi = '<div class="division w3-animate-bottom" id="'+i+'_show" style="display:'+turn_show+'">'

				    		html_divi += '<table class="table table-bordered">\
												<thead>\
													<tr>\
											        	<th>#</th>\
											        	<th>Denominación</th>\
											       		<th>Valor de 0 a 100 porciento</th>\
										       		</tr>\
									       		</thead>\
									       		<tbody>'
				    		
									
		    		       		
				    		$("#table_f").find('tr').each(function(indice,ele){
				    			var $tr = $(ele)	
								var id = $tr.find("td:eq(0)").text()
								var desc = $tr.find("td:eq(1)").text()
								var check = $tr.find("td:eq(3)").find('input').prop("checked")
								if (check) {
									html_divi += '<tr><td>'+ id +'</td><td>'+ desc +'</td><td><input type="text" maxlength="3" onkeypress="return soloNumeros(event)" placeholder="Valor para esta división" value="'+divisiones[i][id]+'" class="v_'+id+'"/></td></tr>'

								}						
				    		})
				    		html_divi += '</tbody></table></div>'
							$("#d-body").append(html_divi)
						}
					}		  
			   })
			}
			$("#b_formulas").keyup(function () {
				if ($(this).val()!="") {
					$("#repositorio_f").find('tr').css('display','none')
					$("#repositorio_f").find('td:contains("'+$(this).val()+'")').parents('tr').css('display','')
				}else{
					$("#repositorio_f").find('tr').css('display','')
				}
				
			})
	    })
	    function soloNumeros(e){
			tecla=(document.all) ? e.keyCode: e.which;
			if (tecla == 8) return true;
			patron =/[0-9]/;
			te=String.fromCharCode(tecla);
			return patron.test(te);
		}
		function f_disponibles(){
		   	$.ajax({
		        url:"proceso.php",
		        data:{
					accion:'f_disponibles'
					
		   		},
		        type:"post",
		        async:false, 
		        datatype:"json",
		        success:function(response)
		        {	//alert(response)
		        	var incluido = "";
		        	var obj = JSON.parse(response)
		        	$("#repositorio_f").empty()
		        	var temple = '<table class="w3-table w3-bordered " id="table_f">'

		        	obj.map(function (element,i) {
		        		if(incluido.indexOf(element.tipo_concepto)==-1){
		        				temple+='<tr>'
		        					temple+='<td colspan="4" class="bg-info text-white"><h3>'+element.tipo_concepto+'</h3></td>'
		        				temple+='</tr>'
		        				incluido = element.tipo_concepto
		        		}
		        		

		        	 
		        			temple+='<tr>'
			        			temple+='<td>'+ element.id +'</td>'
			        			temple+='<td>'+ element.descripcion +'</td>'
			        			
			        			temple+='<td>'+ element.fecha +'</td>'
			        			temple+='<td><input type="checkbox" class="w3-check" onchange="add_f(this)" /></td>'
			        		temple+='</tr>'        			        		
		        	})
		   			temple+='</table>'
		   			$("#repositorio_f").append(temple)
				}		  
		    })
		} 
		function row(id,desc) {
			return '<tr><td>'+ id +'</td><td>'+ desc +'</td><td><input type="text" maxlength="3" onkeypress="return soloNumeros(event)" placeholder="Valor para esta división" class="v_'+id+'"/></td></tr>'
		}  
	    function add_f(this_all){
	    	var tr = $(this_all).parents('tr')	
			
			var id = tr.find("td:eq(0)").text()
			var desc = tr.find("td:eq(1)").text()
			var check = tr.find("td:eq(3)").find('input').prop("checked")
			
			if(check==true){
				$("#d-body").find("tbody").append(row(id,desc))  		

			}else{
				$(".v_"+id).parents('tr').remove()
			}	
	    }
	    function add_division(){
	    	var name_d = prompt("¿Nombre de la división?")
	    	if (name_d!=null && name_d!="") {
	    		
	    		var n_replace = name_d.replace(/ /g,"_")
		    	var f = $("#table_f").find('tr')		       		

	    		if ($("#"+n_replace).length==0) {
	    			if ($(".division").length>0) {
	    				$("#d-head").append('<button type="button" class="btn btn-primary"  title="Haga DobleClick para Acciones especiales" ondblclick="a_especi(this,event)" onclick="nav(this);" id="'+n_replace+'">'+name_d+'</button>')
			    		
			    		var html_divi = '<div class="division w3-animate-bottom" id="'+n_replace+'_show" style="display:none">'

			    		html_divi += '<table class="table table-bordered">\
											<thead>\
												<tr>\
										        	<th>#</th>\
										        	<th>Denominación</th>\
										       		<th>Valor de 0 a 100 porciento</th>\
									       		</tr>\
								       		</thead>\
								       		<tbody>'
			    		
			    		html_divi += $(".division").find('tbody').html()
			    		html_divi += '</tbody></table></div>'
						$("#d-body").append(html_divi)
	    			}else{
	    		
			    		if ($("#d-head > button").length==0) {
			    			turn=' active'
			    			turn_show="''"
			    		}else{ 
			    			turn=""
			    			turn_show='none'}
			    	
			    		$("#d-head").append('<button type="button" class="btn btn-primary'+turn+'" onclick="nav(this);" id="'+n_replace+'"  title="Haga DobleClick para Acciones especiales" ondblclick="a_especi(this,event)">'+name_d+'</button>')
			    		
			    		var html_divi = '<div class="division w3-animate-bottom" id="'+n_replace+'_show" style="display:'+turn_show+'">'

			    		html_divi += '<table class="table table-bordered">\
											<thead>\
												<tr>\
										        	<th>#</th>\
										        	<th>Denominación</th>\
										       		<th>Valor de 0 a 100 porciento</th>\
									       		</tr>\
								       		</thead>\
								       		<tbody>'
			    		
			    		f.each(function(i,ele){
			    			var $tr = $(ele)	
							var id = $tr.find("td:eq(0)").text()
							var desc = $tr.find("td:eq(1)").text()
							var check = $tr.find("td:eq(3)").find('input').prop("checked")
							if (check) {

								html_divi += row(id,desc)
							}						
			    		})
			    		html_divi += '</tbody></table></div>'
						$("#d-body").append(html_divi)
					}
				}else{alert("El nombre que has introducido ya existe!. Vuelve a intentarlo")}
	    	}
	    }
	    function a_especi(this_all,e){

	    	$("#a_especiales").css({'display':'','left':e.clientX,'top':e.clientY})
	    	$("#a_especiales").find('textarea').val(this_all.id)
	    	
	    }

	    function b_divi(this_all) {
	    	var a = $(this_all).attr('id')
	    	if(confirm("¿Realmente desea eliminar la división "+a+" ?")){
	    		var heredero = $(this_all).siblings('button:first')
	    		heredero.addClass('active')
	    		$('#'+heredero.attr('id')+'_show').css("display",'')

	    		$("#"+a+"_show").remove()
	    		$('#'+$(this_all).attr('aria-describedby')).remove()
	    		$(this_all).remove()
	    		$("#a_especiales").css({'display':'none'})

	    	}
	    }
	    function rename_divi(this_all) {
	    	var a = $(this_all)
	    	var n_actual = a.attr('id')
	    	var name = prompt('Escriba el nuevo nombre para la división '+a.text())
	    	if (name!=null) {
	    		a.attr('id',name.replace(/ /g,"_"))
	    		a.text(name)
	    		$("#"+n_actual+'_show').attr('id',name.replace(/ /g,"_")+'_show')
	    		$("#a_especiales").css({'display':'none'})

	    	}
	    }
	    //Ocultar acciones especiales cuando no se necesita
	    $(document).on("click",function(e) {
	         var container = $("#a_especiales");
	            if (!container.is(e.target) && container.has(e.target).length === 0) { 
	    		$("#a_especiales").css({'display':'none'})
	            }
	     });
		function nav(this_all){
			var show = "#"+$(this_all).attr("id")+"_show"		
			$(show).css("display",'')
			$(show).siblings('div').css("display",'none')
			$(this_all).addClass("active")
			$(this_all).siblings('button').removeClass("active")
		}
		function json_create(){
			if ($(".division").length>0) {
				var inputs_all = $(".division:first").find('input:text').toArray()
				if (inputs_all.length>0) {
					var error = []
					for(i in inputs_all) {
						var i_grupo = $(inputs_all[i]).attr('class')
						var i_bros = $('.'+i_grupo).toArray()
						
						var suma_t = 0
						for(ii in i_bros){
							var i_individual = $(i_bros[ii])

							suma_t+=Number(i_individual.val())		
						}
						if (suma_t!=100) {
							error.push(i_grupo.replace('v_',""))
						}
					}
					if (error.length!=0) {
						alert('Error: La denominación # '+error+" no suma el 100% en todas las divisiones!")
					}else{
						return generate()
					}	
				}
								
					
			}else{
				alert("Error: Por favor, cree una división para continuar...")
			}
			function generate() {
				var json = {}
				var divisiones = $(".division").toArray()
				for(i in divisiones){
					var div_a = $(divisiones[i])
					var n_div = div_a.attr('id').replace('_show',"")
					json[n_div]={}
					var tr_a = div_a.find('tbody').find('tr').toArray()
					for(ii in tr_a){
						var $tr = $(tr_a[ii])	
						var id = $tr.find("td:eq(0)").text()
						var val = $tr.find("td:eq(2)").find('input').val()
						json[n_div][id]=val	

					}
				}
				return JSON.stringify(json)
			}
		}
		function save(){
			if($("#tipo_periodo").val()!="- Período de emisión -" && $("#nombre_nomina").val()!=''){
				if(json_create()!=undefined){
					if(getParameterByName('id')!=''){
						var action_a_tomar = 'update'
					}else{						
						var action_a_tomar = 'save'
					}
					$.ajax({
				        url:"proceso.php",
				        data:{
							accion:action_a_tomar,
							id_nomina:getParameterByName('id'),
							nombre_nomina:$("#nombre_nomina").val(),
							tipo_periodo:$("#tipo_periodo").val(),
							engine:$("#engine").val(),
							formulas_a_pagar:function () {
								var json_a_apagar = {}
								
								$("#repositorio_f").find('input:checked').each(function (i,element) {
									json_a_apagar[$(element).parents('tr').find("td:eq(0)").text()]=''
								})
								return JSON.stringify(json_a_apagar)
							},
							divisiones:json_create()
							
				   		},
				        type:"post",
				        datatype:"json",
				        beforeSend:function () {
				        	$("body").append('<div class="cargando w3-display-topmiddle"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>')
				        },
				        success:function(response)
				        {	
				        	$(".cargando").remove()
				        	alert(response)
				        	var c = window.confirm("Desea volver?")
				        	if (c) {
				        		history.back(1);
				        	}
						}		  
				    })
					
				}
			}else{alert("Campos vacíos!. Por favor revise")}
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
			font-size: 1rem;
		}	
		strong:hover{
			color:#563d7c;
		}
	</style>
</head>
<body>	
	<div>
		<button class="btn btn-secundary" onclick="$(this).siblings('#mySidebar').css('display','block')">+fórmula</button>
		<button class="btn btn-secundary" onclick="add_division()">+división</button>
		<button class="btn btn-secundary" onclick="alert(json_create())">Ver JSON</button>
		
		<button class="btn btn-success w3-right" onclick="save()">Guardar</button>
		
		<div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display: none; z-index: 2;" id="mySidebar">
		  <button onclick="$(this).parent('div').css('display','none')" class="w3-bar-item w3-button w3-large">Cerrar ×</button>
		  <input type="text" class="w3-input" id="b_formulas" placeholder="Buscar en el repositorio de fórmulas">
		  
		  <div id="repositorio_f" style="width:50%;height:80%;overflow-y:auto"></div>
		</div>
	</div>
	<hr>
	<aside class="container">
		<article>
			<div class="form-group">
				<label for="nombre_nomina">Denominación de la nómina</label>
				<input type="text" placeholder="Nombre de la nómina" id="nombre_nomina"  class="form-control">
			</div>
			<div class="form-group">
				<label for="engine">Motor de proceso</label>
				<select class="form-control form-control-lg" id="engine">
				 
				  <option value="convencional">Convencional</option>
				  <option value="aporte patronal">Aporte patronal</option>
				 
				</select>
			</div>
			<div class="form-group">
				<label for="engine">Período de emisión</label>

				<select class="form-control form-control-lg" id="tipo_periodo">
				  <option value="mensual">Mensual</option>
				  <option value="semanal">Semanal</option>
				  <option value="anual">Anual</option>
				</select>
			</div>
		</article>
		
		<article>  
			<header><h1 class="h1">Divisiones</h1></header>  
			<hr> 
			<div class="btn-group-horizontal" id="d-head">	
			</div> 		
		</article>	
		<article>
			<div id="d-body">
			</div> 	
		</article>
	</aside>
	<div style="border-radius: 10px;display: none;position: absolute;color: white;padding:5px" class="w3-card-4 w3-light-grey" id="a_especiales">
		<textarea hidden=""></textarea>
		<strong style="cursor: pointer;" onclick="id=$(this).siblings('textarea').val();rename_divi($('#'+id))">1- Renombrar</strong><br>
		<strong style="cursor: pointer;" onclick="id=$(this).siblings('textarea').val();b_divi($('#'+id))">2- Eliminar</strong>
		
	</div>
</body>
</html>


