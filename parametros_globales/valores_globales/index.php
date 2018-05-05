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
		<title> .: Valores globales:.</title>
		<link rel="stylesheet" type="text/css" href="../../css/w3.css">
		<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
		<script type="text/javascript" src="../../js/formato_moneda.js"></script>
		<script type="text/javascript" src="../../js/jquery.js"></script>
		<script src="../../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../../css/bootstrap/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var cat_car_dedic = <?php echo $valores['cat_car_dedic']; ?>;
			var estatus = <?php echo $valores['estatus']; ?>;
			var estado = <?php echo $valores['estado']; ?>;
			var grado_instruccion = <?php echo $valores['grado_instruccion']; ?>;

			var all_valores = {
				"Categoría": cat_car_dedic,
				"Estatus": estatus,
				"Estado": estado,
				"Grado de instrucción": grado_instruccion
			}

			$(document).ready(function(){
				rutas();
				arbol();
				$(document).on('click','.rama_arbol',function () {
					if ($(this).hasClass('collapsed')) {
						$(this).children("span")
						.empty()
						.append("✘")
					}else{
						$(this).children("span")
						.empty()
						.append("✔")
					}
				})
				$("#barra_direcciones").keyup(rutas)
				$("#barra_direcciones").keyup(function () {
					if ($(this).val().indexOf("//")!=-1) {
						$(this).val($(this).val().replace(/\/\//g,"/"))
					}
				})


				$(document).on('click',".li_redirec",function() {
					
					var val = $("#barra_direcciones").val()
					if (val.indexOf("/"+$(this).html())==-1) {
						$("#barra_direcciones").val((val+="/"+$(this).html()).replace(/\/\//g,"/"))
						rutas()
					}
					
				})

				$(document).on('click',"#atras_rutas",atras_redirec)
				
				

				$(document).on('click',"#add_nuevo",function () {
					
					if ($("#documentos").html()=="No se encontró resultados") {
						
						alert("Imposible crear. Ubicación no permitida!")
						
					}else{
						
						try{
							var li = $("#documentos ul li")
						
							if ((li[0].innerHTML=="cargo" && li[1].innerHTML=="dedicacion" && li.length==2) || (li[0].innerHTML=="Categoría" && li[1].innerHTML=="Estatus" && li[2].innerHTML=="Estado" && li[3].innerHTML=="Grado de instrucción" && li.length==4)) {

								alert("Imposible crear. Ubicación no permitida!")
							}else{
								
								$("#documentos ul").append("\
									<li class='row'>\
										<div class='col-4'><input type='text' placeholder='Nuevo nombre...' class='form-control'/></div>\
										<div class='col'><a href='#' id='listo_renombrar' class='btn btn-success'><i class='fa fa-check'></i></a></div>\
									</li>")
							}
						}catch(err){
							$("#documentos").append("\
							<ul class='w3-ul'><li class='row'>\
								<div class='col-4'><input type='text' placeholder='Nuevo nombre...' class='form-control'/></div>\
								<div class='col'><a href='#' id='listo_renombrar' class='btn btn-success'><i class='fa fa-check'></i></a></div>\
							</li></ul>")
						}

					}
				})

				$(document).on('click',"#listo_renombrar",function () {
					var val = $(this).parents('li').find("input").val()
					if (val!="") {
						var path = $("#barra_direcciones").val()
						if (path[0]!="/") {
							path = "/"+path
						} 
						if(path[path.length-1]=="/"){
							path = path.slice(0,path.length-1)
						}
						
						if (path=="/Categoría") {
							
							if (all_valores['Categoría'][val]!=undefined) {
								alert('Categoría ya existe!')
							}else{
								all_valores['Categoría'][val]={cargo:{},dedicacion:{}}
								guardar(function () {
									arbol()
									rutas()
								})
							}
							
							
						}else{

							var json = parser()

							for(i in json){

								if(json[parseInt(i)+1]==undefined){
									json[parseInt(i)+1] = val
									guardar(function () {
										arbol()
										rutas()
									})
									
									break;
								}
							}
							if (Object.keys(json)==0) {
								json[0] = val
								guardar(function () {
									arbol()
									rutas()
								})
								
							}
							
						}
					}else{
						$(this).parents('li').remove()
					}
				})

				$(this).bind("contextmenu", function(e) {
	            	e.preventDefault();
	            });

				$("#especiales_eliminar").on('click',function () {
					if (confirm("¿Seguro que quiere eilminar?")) {
						var json = parser()
						var index = $(this).parent().siblings('#save_index').val()

						delete json[index]

						guardar(function () {
							arbol()
							rutas()
							hide_espec()
						})
					}
				})
				$("#especiales_editar").on('click',function () {
					$("#modal_renombar").modal()
					var index = $("#especiales_editar").parents("#especiales").find("#save_index").val()
					var json = parser()
					var has = $("#especiales_editar").parents("#especiales").find("#body_val_i").val()
					if (has=="true") {
						$("#name_renombrar").val(json[index])
					}else{
						$("#name_renombrar").val(index)
					}
					

				})
				$("#save_new_name").on('click',function 	() {
					var nuevo = $("#name_renombrar").val()
					if (nuevo!=null) {
						if (nuevo!="") {
							
							var has = $("#especiales_editar").parents("#especiales").find("#body_val_i").val()
							var index = $("#especiales_editar").parents("#especiales").find("#save_index").val()
							var json = parser()

							if (has=="true") {
								var name_viejo = json[index]
								json[index]=nuevo
								var reem = JSON.stringify(all_valores)

								reem = reem.replace(new RegExp(name_viejo, 'g'),nuevo)

								all_valores = JSON.parse(reem)
								cat_car_dedic = all_valores['Categoría']
								estatus = all_valores['Estatus']
								estado = all_valores['Estado']
								grado_instruccion = all_valores['Grado de instrucción']
								var barra = $("#barra_direcciones").val()
								for (var i = barra.length - 1; i >= 0; i--) {
									if(barra[i]=="/"){

										var campo = barra.replace(barra.slice(0,i),"").replace(/\//g,"")
										
										break;
									}
								}
								guardar(function () {
									arbol()
									rutas()
									hide_espec()
								},name_viejo,nuevo,campo)
							}else if(has=="false"){
								var save_json = json[index]
								delete json[index]
								json[nuevo]=save_json
								guardar(function () {
									arbol()
									rutas()
									hide_espec()
								},index,nuevo,"categoria")
							}

						}else{
							hide_espec()
						}
					}else{
						hide_espec()
					}
				})
					
			})
			$(document).on("mousedown","#documentos li",function (e) {
				var li = $(this).parent()
				
				if((li.find("li:eq(0)").html()=="cargo" && li.find("li:eq(1)").html()=="dedicacion" && li.find('li').length==2) || (li.find("li:eq(0)").html()=="Categoría" && li.find("li:eq(1)").html()=="Estatus" && li.find("li:eq(2)").html()=="Estado" && li.find("li:eq(3)").html()=="Grado de instrucción" && li.find('li').length==4)){
					
				}else{

					if(e.which == 3) {
						var espec = $("#especiales")
						espec.css({
							'top': e.pageY,
							'left': e.pageX,
							'display': 'block'

						})		
						espec.find("#save_index").val($(this).prop('title'))
						espec.find("#body_val_i").val($(this).hasClass('body_val'))

					}
				}
			})

			$(document).on('click',hide_espec)
			$(document).on('click',"#especiales",function (e) {
				e.stopPropagation();
			})

			function rutas() {
				var doc = $("#documentos")
				var val = $("#barra_direcciones").val()
				
				try{
					
					var json = parser()
					doc.empty()
					if (json==undefined) {
						doc.append("No se encontró resultados")
					}else{
						if (val.indexOf("cargo")!=-1 || val.indexOf("dedicacion")!=-1 || val.indexOf("Estatus")!=-1 || val.indexOf("Estado")!=-1 || val.indexOf("instrucción")!=-1) {
							var html = '<ul class="w3-ul">'
							for(i in Object.keys(json)){
								html+='<li title="'+Object.keys(json)[i]+'" class="body_val">'+Object.values(json)[i]+'</li>'
								
							}
							html+="</ul>"
							doc.append(html)
						}else{
							var html = '<ul class="w3-ul">'
							for(i in Object.keys(json)){
								html+='<li title="'+Object.keys(json)[i]+'" class="li_redirec">'+Object.keys(json)[i]+'</li>'
								
							}
							html+="</ul>"
							doc.append(html)
						}
					}
				}catch(err){
					doc.empty()
					.append("No se encontró resultados")
					alert(err)
					
				}	
			}
			
			function atras_redirec() {
				var val = $("#barra_direcciones").val()
				for (var i = val.length - 1; i >= 0; i--) {
					if(val[i]=="/"){

						$("#barra_direcciones").val(val.slice(0,i))
						rutas()
						break;
					}
				}
			}
			function redirec_arbol(this_all) {
				$("#barra_direcciones").val(this_all.title)
				rutas()
			}	
			function arbol() {
				$("#arbol #cat_car_dedic")
				.empty()
				for(i_1 in cat_car_dedic){
					var html = ""

					html += '<div class="font-weight-bold rama_arbol" style="margin-left:20px" data-toggle="collapse" href="#'+i_1+'">\
								|- &nbsp;&nbsp;&nbsp<span>✘</span> <label onclick="redirec_arbol(this)" title="/Categoría/'+i_1+'">'+i_1+' </label>\
							</div>\
							<div class="collapse" style="margin-left:20px" id="'+i_1+'">'
					
					var cat = cat_car_dedic[i_1]

					for(car_dedic in cat){
						html += '<div class="font-weight-bold rama_arbol" style="margin-left:35px" data-toggle="collapse" href="#'+i_1+car_dedic+'">\
								|- &nbsp;&nbsp;&nbsp<span>✘</span> <label onclick="redirec_arbol(this)" title="/Categoría/'+i_1+'/'+car_dedic+'">'+car_dedic+'</label>\
							</div>\
							<div class="collapse" style="margin-left:35px" id="'+i_1+car_dedic+'"><ul style="margin-left:50px">'
							
							for(i_3 in cat[car_dedic]){
								html += "<li>"+cat[car_dedic][i_3]+"</li>"
							}

							html += "</ul></div>"

					}

					html += "</div>"

					$("#arbol #cat_car_dedic")
					.append(html)
					
				}
					$("#li_estatus")
					.empty()
				for(i in estatus){
					var html = "<li>"+estatus[i]+"</li>"					
					
					$("#li_estatus")
					.append(html)
				}
					
					$("#li_estado")
					.empty()
				for(i in estado){
					var html = "<li>"+estado[i]+"</li>"					
					
					$("#li_estado")
					.append(html)
				}	
					$("#li_grado_instruccion")
					.empty()
				for(i in grado_instruccion){
					var html = "<li>"+grado_instruccion[i]+"</li>"					
					$("#li_grado_instruccion")
					.append(html)
				}
			}

			function guardar(callback,vieja="",nueva="",campo="") {

				$.ajax({
					url:"procesar.php",
					type:"post",
					datatype:"json",
					data:{
						"categoria":JSON.stringify(cat_car_dedic),
						"estatus":JSON.stringify(estatus),
						"estado":JSON.stringify(estado),
						"grado_instruccion":JSON.stringify(grado_instruccion),
						"nueva":nueva,
						"campo":campo,
						"vieja":vieja
					},
					beforeSend:function () {
						$("body").append('<div class="cargando w3-display-topmiddle w3-white" style="z-index:100"><i class="fa fa-spinner fa-pulse fa-1x fa-fw fa-5x"></i><span class="sr-only">Loading...</span></div>')
					},
					success:function (res) {
						$(".cargando").remove()
						var obj = JSON.parse(res)
						if (obj.estado=="exito") {
							callback()	
						}else{
							alert(obj.estado)
						}
						
						
					}
				})
			}
			function hide_espec() {
				$("#especiales").css({
					'display': 'none'

				})
			}
			
			function parser() {
				var barra = $("#barra_direcciones").val()
				var string  = ""
				if (barra!="") {
					for(i in barra.split("/")){
						string += "[\""+barra.split("/")[i]+"\"]"
					}
				}
				string = string.replace(/\[\"\"\]/g,"")
				var json = eval("all_valores"+string)
				return json
			}
		</script>
		<style type="text/css">
			@font-face {
			  font-family: 'Open Sans';
			  font-style: italic;
			  src: url(../../fonts/OpenSans-Light.ttf);
			}
			html,body{
				font-family: 'Open Sans', sans-serif;
				height: 100%;
				width: 100%;
			}
			body{
				overflow-y: scroll;
			}
			.rama_arbol,label{
				cursor: pointer;
				margin-bottom: 10px; 
			}.rama_arbol:hover{
				color: blue;
			}
			.li_redirec{
				cursor: pointer;
			}.li_redirec:hover{
				color: orange;
			}
			li{
				cursor: pointer;
			}#documentos li:hover{
				color: orange
			}
			.w3-panel{
				background-color: #f2f2f2;
			}
		</style>
</head>						
<body>
	<div class="container-fluid">
		
		<div class="row rounded">
			<header class="w3-margin w3-round-xlarge w3-panel w3-border w3-hover-border-blue col">
				<center>
					<h1>Configurar <strong>valores globales</strong></h1>
				</center>
			</header>	
		</div>
		

		<div class="row panels">	
			<aside class="w3-margin w3-round-xlarge w3-panel w3-border w3-hover-border-blue col-3">
				<center><header class="w3-margin"><h4>Árbol de datos</h4></header></center>	<hr>
				<div id="arbol">
					<div class="font-weight-bold rama_arbol" data-toggle="collapse" href="#cat_car_dedic">
						<span>✘</span> <label class='li_redirec' title="/Categoría" onclick="redirec_arbol(this)">Categoría</label>		    
					</div>
					<div class="collapse" id="cat_car_dedic">					 
					</div>

					<div class="font-weight-bold rama_arbol" data-toggle="collapse" href="#estatus">
						<span>✘</span> <label onclick="redirec_arbol(this)" title="/Estatus">Estatus</label>	    
					</div>
					<div class="collapse" id="estatus">	
						<ul id="li_estatus">
							
						</ul>				 
					</div>
					
					<div class="font-weight-bold rama_arbol" data-toggle="collapse" href="#estado">
						<span>✘</span> 	<label onclick="redirec_arbol(this)" title="/Estado">Estado</label>	    
					</div>
					<div class="collapse" id="estado">	
						<ul id="li_estado">
							
						</ul>				 
					</div>

					<div class="font-weight-bold rama_arbol" data-toggle="collapse" href="#grado_instruccion">
						<span>✘</span> 	<label onclick="redirec_arbol(this)" title="/Grado de instrucción">Grado de instrucción</label>		    
					</div>
					<div class="collapse" id="grado_instruccion">	
						<ul id="li_grado_instruccion">
							
						</ul>				 
					</div>
				</div>
			</aside>				
			<aside class="w3-margin w3-round-xlarge w3-panel w3-border w3-hover-border-blue col">
				<center><header class="w3-margin"><h4>Explorador</h4></header></center>	<hr>
				<div class="row">
					<div class="col-1 w3-border w3-round-xlarge w3-margin" id="atras_rutas"><i class="fa fa-arrow-left"></i></div>
					
					<input type="text" class="col w3-border w3-round-xlarge w3-margin" disabled="" id="barra_direcciones">
					
				</div>
				<div class="row">
					<a href="#" class="btn btn-outline-info w3-margin" id="add_nuevo">Nuevo</a>
				</div>
				<div class="row">
					<div class="col w3-border w3-round-xlarge w3-margin" id="documentos">
						
					</div>
				</div>
			</aside>
		</div>

	</div>

	<div id="especiales" class="w3-round-xlarge w3-card-4 w3-light-grey" style="display: none;position: absolute;z-index: 100;">
		<ul class="w3-ul" >
			<li class="" id="especiales_editar">Renombrar</li>
			<li class="" id="especiales_eliminar">Eliminar</li>
		</ul>
		<input type="text" hidden="" id="save_index">
		<input type="text" hidden="" id="body_val_i">
	</div>

	
	<div class="modal modal-wide" id="modal_renombar"> 
		<div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Renombrar</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <p><input type="text" class="w3-input" placeholder="Escriba el nuevo nombre..." id="name_renombrar"></p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary" data-dismiss="modal" id="save_new_name">Listo!</button>
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		</div>
	</div>

</body>
</html>
