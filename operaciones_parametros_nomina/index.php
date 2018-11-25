<?php 
	session_start();
	include '../conexion_bd.php'; 
	$valores = (new sql("valores_globales","WHERE id='1'"))->select()->fetch_assoc();
?>
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
		const co = ["#001819","#002426","#00494D","#00585D","#006D73","#008C94","#00ACB6","#00C6D1","#00CED9","#00F2FF"] 
		const disponibles_condiciones = { 
			"estado" : <?php echo $valores['estado']; ?>,
			"genero" : {0:'Masculino',1:'Femenino'},
			"estatus" : <?php echo $valores['estatus']; ?>,
			"grado_instruccion" : <?php echo $valores['grado_instruccion']; ?>,
			"categoria" : 
				<?php
					$cat = json_decode($valores['cat_car_dedic']); 
					$arr = array();
					foreach ($cat as $key => $value) {
						array_push($arr, $key);
					}
					echo json_encode($arr);
				?>	
			,
			"dedicacion" : 
				<?php
					$cat = json_decode($valores['cat_car_dedic']); 
					$arr = array();
					foreach ($cat as $cat => $car_dedic) {
						foreach ($car_dedic as $car_dedic_key => $sub_arr_final) {
							if ($car_dedic_key=="dedicacion") {
								foreach ($sub_arr_final as $key => $value) {
									if (in_array($value, $arr)==false) {
										array_push($arr, $value);
									}
								}
							}
						}
					}
					echo json_encode($arr);
				?>	
			,
			"caja_ahorro" : {0:'si',1:'no'},
			"cargo" : 
				<?php
					$cat = json_decode($valores['cat_car_dedic']); 
					$arr = array();
					foreach ($cat as $cat => $car_dedic) {
						foreach ($car_dedic as $car_dedic_key => $sub_arr_final) {
							if ($car_dedic_key=="cargo") {
								foreach ($sub_arr_final as $key => $value) {
									if (in_array($value, $arr)==false) {
										array_push($arr, $value);
									}
								}
							}
						}
					}
					echo json_encode($arr);
				?>	
			};
		function soloNumeros(e){
			tecla=(document.all) ? e.keyCode: e.which;
			if (tecla == 8) return true;
			patron =/[0-9]/;
			te=String.fromCharCode(tecla);
			return patron.test(te);
		}


	    $(document).ready(function () {	
	    	////////Condiciones posibles///////
		    	let num_color = 0
				for(i in disponibles_condiciones){
					let html = '<div class="btn-group grupo_condiciones_campo" title="'+i+'">'

					html += '<button class="btn btn-secundary text-inverse">'+i+'</button>'
					for(e in disponibles_condiciones[i]){
						html += '<button class="btn text-white condicion_campo" style="background-color:'+co[num_color]+'" title="'+disponibles_condiciones[i][e]+'" value="'+disponibles_condiciones[i][e]+'">'+disponibles_condiciones[i][e]+'</button>'
					}
					html += "</div><hr>"
					$(".group-condiciones").append(html)
				
					num_color++
				}
			

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
							var check_bro = $("#repositorio_f").find('.tr_formula').find('.id_formula').toArray()
							for(ii in check_bro){
								if ($(check_bro[ii]).text()==i) {
									$(check_bro[ii]).siblings('.td_cont_check_formula').children('.check_formula').prop('checked',true)
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
				    			turn_show='none'
				    		}
							

				       		$("#d-head").append('<button type="button" class="cabereza_division btn btn-lg btn-primary'+turn+' pestaña"  title="'+i+'">'+i+'</button>')
	
				    		var html_divi = '<div class="division w3-animate-bottom" title="'+i+'_show" style="display:'+turn_show+'">'

				    		html_divi += '<table class="table table-bordered">\
												<thead>\
													<tr>\
											        	<th>#</th>\
											        	<th>Denominación</th>\
											       		<th>Valor de 0 a 100 porciento</th>\
										       		</tr>\
									       		</thead>\
									       		<tbody>'
				    		
				    		let f = divisiones[i]
				    		for(e in f){
				    			let tr = $("tr[title='formula_id_"+e+"']")
								let id = tr.find(".id_formula").text()
								let desc = tr.find(".descripcion_formula").text()
								let check = tr.find(".td_cont_check_formula").find('.check_formula').prop("checked")
								if (check) {
									html_divi += row(id,desc,divisiones[i][id])
								}
				    		}
				    		html_divi += '</tbody></table></div>'
							$("#d-body").append(html_divi)
						}

						var filtros_obj = JSON.parse(obj.filtros)

						for(ii in filtros_obj){
							var padre_group = $(".grupo_condiciones_campo[title='"+ii+"']")
							for(e in filtros_obj[ii]){
								padre_group.find(".condicion_campo[title='"+e+"']").addClass('bg-primary')
							}
						}

					}		  
			   })
			}

			///Buscador de Fórmulas///
				$("#b_formulas").keyup(function () {
					if ($(this).val()!="") {
						$("#repositorio_f").find('tr').css('display','none')
						$("#repositorio_f").find('td:contains("'+$(this).val()+'")').parents('tr').css('display','')
					}else{
						$("#repositorio_f").find('tr').css('display','')
					}
					
				})
	    })
	    
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
		        {	
		        	var incluido = "";
		        	var obj = JSON.parse(response)
		        	var temple = '<table class="w3-table w3-bordered" id="table_f">'

		        	for(i in obj){
		        		
		        		if(incluido.indexOf(obj[i].tipo_concepto)==-1){
		        				temple+='<tr>'
		        					temple+='<td colspan="4" class="bg-primary text-white"><h3>'+obj[i].tipo_concepto+'</h3></td>'
		        				temple+='</tr>'
		        				incluido = obj[i].tipo_concepto
		        		}
		        		
	        			temple+='<tr class="tr_formula" title="formula_id_'+obj[i].id+'">\
		        			<td class="id_formula">'+ obj[i].id +'</td>\
		        			<td class="descripcion_formula">'+ obj[i].descripcion +'</td>\
		        			<td class="fecha_formula">'+ obj[i].fecha +'</td>\
		        			<td class="td_cont_check_formula"><input type="checkbox" class="w3-check check_formula"/></td>\
		        		</tr>'   
		        	}

		   			temple+='</table>'
		   			$("#repositorio_f").empty().append(temple)
				}		  
		    })
		} 
	    $(document).on("change",".check_formula",function() {
	    	var tr = $(this).parents('.tr_formula')	
			
			var id = tr.find(".id_formula").text()
			var desc = tr.find(".descripcion_formula").text()
			var check = $(this).prop("checked")
			
			if(check){
				$("#d-body").find("tbody").append(row(id,desc,""))  		

			}else{
				$("input[title='v_"+id+"']").parents('tr').remove()
			}
	    })
		function row(id,desc,value="") {
			return '<tr class="tr_formula_agregada">\
						<td class="id_formula_agregada">'+ id +'</td>\
						<td class="descripcion_formula_agregada">'+ desc +'</td>\
						<td class="td_contenedor_input_formula_agregada"><input type="text" maxlength="3" onkeypress="return soloNumeros(event)" placeholder="Valor para esta división" title="v_'+id+'" class="form-control input_formula_agregada" value="'+value+'"/></td>\
					</tr>'
		}  

	    $(document).on("click",".guardar_division",function() {
	    	let name_d = $("#nombre_division").val()
	    	if (name_d!=null && name_d!="") {
	    		
	    		var n_replace = name_d.replace(/'/g,"").replace(/"/g,"")
		    	var f = $("#table_f").find('.tr_formula').toArray()	       		

	    		if ($("button[title='"+n_replace+"']").length==0) {
	    				
	    		
			    		if ($("#d-head > button").length==0) {
			    			turn=' active'
			    			turn_show="''"
			    		}else{ 
			    			turn=""
			    			turn_show='none'}
			    	
			    		$("#d-head").append('<button type="button" class="cabereza_division btn btn-lg btn-primary'+turn+' pestaña"  title="'+n_replace+'">'+name_d+'</button>')
			    		
			    		var html_divi = '<div class="division w3-animate-bottom" title="'+n_replace+'_show" style="display:'+turn_show+'">'

			    		html_divi += '<table class="table table-bordered">\
											<thead>\
												<tr>\
										        	<th>#</th>\
										        	<th>Denominación</th>\
										       		<th>Valor de 0 a 100 porciento</th>\
									       		</tr>\
								       		</thead>\
								       		<tbody>'
			    		for(i in f){
			    			let tr = $(f[i])	
							let id = tr.find(".id_formula").text()
							let desc = tr.find(".descripcion_formula").text()
							let check = tr.find(".td_cont_check_formula").find('.check_formula').prop("checked")
							if (check) {
								html_divi += row(id,desc,"")
							}	
			    		}
			    		html_divi += '</tbody></table></div>'
						$("#d-body").append(html_divi)
				}else{
					alert("La división que has introducido ya existe!. Vuelve a intentarlo")
				}
				$("#modal_nombre_division").modal("hide")
	    	}else{
	    		alert("Error: Nombre inválido!")
	    	}
	    })

	    $(document).on("click",".eliminar_division",function() {
	    	var val = $(this).siblings('.valor_a_especiales').val()
	    	if(confirm("¿Realmente desea eliminar la división "+val+" ?")){
	    		let d_a_borrar = $("button[title='"+val+"']")
	    		
	    		let heredero = $(d_a_borrar).siblings('button:first')
	    		heredero.addClass('active')
	    		
	    		$("div[title='"+heredero.attr("title")+"_show']").css("display",'')

	    		d_a_borrar.remove()
	    		$("div[title='"+val+"_show']").remove()


	    		$("#a_especiales").css({'display':'none'})

	    	}
	    })
	    $(document).on("click",".renombrar_division",function() {

	    	let n_actual = $(this).siblings('.valor_a_especiales').val()
	    	let name = prompt('Escriba el nuevo nombre para la división '+n_actual)
	    	if (name!=null && name!="") {
	    		
	    		$("button[title='"+n_actual+"']").text(name).attr("title",name)
	    		$("div[title='"+n_actual+"_show']").attr("title",name+"_show")
	    		$("#a_especiales").css({'display':'none'})
	    	}
	    })

		function json_create(){
			if ($(".division").length>0) {
				var inputs_all = $(".division:first").find('input:text').toArray()
				if (inputs_all.length>0) {
					var error = []
					for(i in inputs_all) {
						var i_grupo = $(inputs_all[i]).attr('title')
						var i_bros = $("input[title="+i_grupo+"]").toArray()
						
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
				let json = {}
				let divisiones = $(".division").toArray()
				for(i in divisiones){
					let div_a = $(divisiones[i])
					let n_div = div_a.attr('title').replace('_show',"")
					json[n_div]={}
					let tr_a = div_a.find('.tr_formula_agregada').toArray()
					for(ii in tr_a){
						let tr = $(tr_a[ii])	
						let id = tr.find(".id_formula_agregada").text()
						let val = tr.find(".td_contenedor_input_formula_agregada").find('.input_formula_agregada').val()
						if(val==""){val="0"}
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
					$("#modal_notificacion").modal()
					$(".notificacion").empty()
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
									json_a_apagar[$(element).parents('.tr_formula').find(".id_formula").text()]=''
								})
								return JSON.stringify(json_a_apagar)
							},
							divisiones:json_create(),
							filtros: crear_json_condiciones()
							
				   		},
				        type:"post",
				        datatype:"json",
				        beforeSend:function () {
				        	$(".notificacion").append('<div class="cargando w3-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>')
				        },
				        success:function(response)
				        {	
				        	$(".cargando").remove()

				        	$(".notificacion").append(response)
				        	
						}		  
				    })
					
				}
			}else{alert("Campos vacíos!. Por favor revise")}
		}
		$(document).on("click",".pestaña",function() {
			var show = $(this).attr("title")+"_show"		
			$("div[title='"+show+"']").css("display",'')
			$("div[title='"+show+"']").siblings('.division').css("display",'none')
			$(this).addClass("active")
			$(this).siblings('.pestaña').removeClass("active")
		})
		///////////////////////Listo//////////////////////////

		//Ocultar acciones especiales cuando no se necesita
		$(document).on("click",function(e) {
	        var container = $("#a_especiales");
            if (!container.is(e.target) && container.has(e.target).length === 0) { 
    		$("#a_especiales").css({'display':'none'})
            }
	    });
		$(document).on("keyup",".aplicar_todos",function() {
			let active = $(".division").toArray()
			for(i in active){
				if ($(active[i]).css("display")!="none") {
					$(active[i]).find('input:text').val($(this).val())
					break;	
				}
			}
		})
		///Abrir Acciones especiales///
		$(document).on("dblclick",".cabereza_division",function(e) {
	    	$("#a_especiales").css({
	    		'display':'',
	    		'margin-left':$(this).position().left
	    		//'top':$(this).offset().top
	    	})
	    	$("#a_especiales").find('.valor_a_especiales').val($(this).attr("title"))
	    })
		/////////////////////////Condiciones//////////////////////////////
		$(document).on("click",".open-condiciones",function() {
			$(this).children().toggle()
			$(".group-condiciones").toggle()
		})
		$(document).on("click",".condicion_campo",function() {
			$(this).toggleClass('bg-primary')
		})
		function crear_json_condiciones() {
			let json_condiciones_campo = {};
			let arr_ = $(".grupo_condiciones_campo").toArray()
			for(i in arr_){
				let campo_padre = $(arr_[i]).attr("title")
				let campos_group = $(arr_[i]).find(".bg-primary").toArray()
				if (campos_group.length>0) {
					json_condiciones_campo[campo_padre] = {}
					for(e in campos_group){
						if ($(campos_group[e]).hasClass('bg-primary')) {
							json_condiciones_campo[campo_padre][$(campos_group[e]).val()] = ""
						}
					}
				}
				
			} 
			return JSON.stringify(json_condiciones_campo)
		}
		$(document).on("click",".open-modo-new-division",function() {
			$('#modal_nombre_division').modal();
			$('#nombre_division').focus()
		})
	</script>

	<style type="text/css">
		@font-face {
		  font-family: 'Open Sans';
		  src: url(../fonts/OpenSans-Light.ttf);
		}
		html,body{
			font-family: 'Open Sans', sans-serif;
		}	
		strong:hover{
			color:#033140;
		}
		.btn,.item_a_especial{
			cursor: pointer;
		}
		.open-condiciones:hover{
			cursor: pointer;
			color: #1BDCFF
		}
		#a_especiales{
			display: inline-block;
			z-index: 2500;
			border: 4px solid #F5C2C9;
			position: relative;
		}
		#a_especiales:after, #a_especiales:before {
			top: 100%;
			left: 50%;
			border: solid transparent;
			content: " ";
			height: 0;
			width: 0;
			position: absolute;
			pointer-events: none;
		}

		#a_especiales:after {
			border-color: rgba(136, 183, 213, 0);
			border-top-color: #d9534f;
			border-width: 15px;
			margin-left: -15px;
		}
		#a_especiales:before {
			border-color: rgba(194, 225, 245, 0);
			border-top-color: #F5C2C9;
			border-width: 21px;
			margin-left: -21px;
		}
	</style>
</head>
<body>	
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<div class="btn-group-vertical h-100 w3-display-middle">
					<button class="btn-lg btn btn-outline text-white open-modo-new-division" style="background-color: #001819"><i class="fa fa-plus"></i> división</button>
					<button class="btn-lg btn btn-outline text-white" style="background-color: #00585D" onclick="$('#bar_formulas').modal()"><i class="fa fa-plus"></i> fórmula</button>
					<button class="btn-lg btn btn-outline text-white" style="background-color: #008C94" onclick="alert(json_create())">Ver Divisiones (JSON)</button>
					<button class="btn-lg btn btn-outline text-inverse" style="background-color: #00C6D1" onclick="alert(crear_json_condiciones())">Ver condiciones (JSON)</button>
					<button class="btn-lg btn btn-outline text-inverse" style="background-color: #00F2FF" onclick="save()"><i class="fa fa-save"></i> Guardar</button>
				</div>
			</div>
			<div class="col-md-10 w3-padding-xlarge">
				<div class="form-group w3-section w3-center">
					<h1>Crear nueva nómina de pago <i class="fa fa-file-o"></i></h1>
				</div>
				<div class="form-group w3-section">
					<label for="nombre_nomina"><h3>Denominación de la nómina</h3></label>
					<input type="text" placeholder="Nombre de la nómina" id="nombre_nomina" class="form-control-lg form-control">
				</div>
				<div class="form-group w3-section">
					<label for="engine"><h3>Motor de proceso</h3></label>
					<select class="form-control form-control-lg" id="engine">
					 
					  <option value="convencional">Normal</option>
					  <option value="aporte patronal">Aporte patronal</option>
					 
					</select>
				</div>
				<div class="form-group w3-section">
					<label for="engine"><h3>Período de emisión</h3></label>
					<select class="form-control form-control-lg" id="tipo_periodo">
					  <option value="mensual">Mensual</option>
					  <option value="semanal">Semanal</option>
					  <option value="anual">Anual</option>
					</select>
				</div>
				<hr>
				<div class="form-group w3-section">
					
					<div class="" style="display: block;">
						<h1>Divisiones <button class="btn btn-outline-primary open-modo-new-division"><i class="fa fa-plus"></i></button></h1>
					</div>
					<div class="" style="display: block;">
						<input type="text" placeholder="Aplicar a todos (Solo esta División)" style="text-align: right;" class="form-control form-control-lg aplicar_todos" onkeypress="return soloNumeros(event)" maxlength="3" style="width: 50px">
					</div>
					<div class="w3-section" style="display: block;margin-bottom: 20px">
						<div class="w3-padding w3-card-2 bg-danger text-white w3-round-large" id="a_especiales" style="display: none">
							<textarea hidden="" class="valor_a_especiales"></textarea>
							<strong class="item_a_especial renombrar_division">1- Renombrar</strong><br>
							<strong class="item_a_especial eliminar_division">2- Eliminar</strong>
						</div>
					</div>
					<div class="w3-section-large" style="display: block;">
						<div class="form-group">
							<div class="btn-group" id="d-head">	
							</div> 
						</div>	
						<div class="form-group w3-section">
							<div id="d-body">
							</div> 	
						</div>
					</div>	
				</div>
				<hr>	
				<div class="form-group" style="margin-top: 50px">
					<h2>Condicionar Nómina <span class="open-condiciones"><i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up" style="display: none"></i></span></h2>
					<div class="group-condiciones table-responsive w-100 w3-section" style="">

					</div>
				</div>
				
			</div>
		</div>
	</div>
	<div class="modal fade" id="bar_formulas">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Repositorio de fórmulas</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			  <input type="text" class="w3-input" id="b_formulas" placeholder="Buscar en el repositorio de fórmulas">
			  
			  <div id="repositorio_f"></div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>
	  </div>
	</div>
	<div class="modal" id="modal_notificacion">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-body notificacion alert alert-success w3-center">
	        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-outline-success" onclick="history.back(1);"><i class="fa fa-arrow-left"></i> ¿Desea Volver?</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>
	  </div>
	</div>
	<div class="modal fade" id="modal_nombre_division">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<h5>Agregar nueva división</h5>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
	        	<label for="nombre_division">Nombre de la división</label>
	        	<input type="text" class="form-control form-control-lg" placeholder="Nombre de la nueva división" id="nombre_division">
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-outline-primary guardar_division"><i class="fa fa-arrow-send"></i> Aceptar</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>
	  </div>
	</div>
</body>
</html>


