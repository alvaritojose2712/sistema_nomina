<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title> .: Búsqueda | Nómina :.</title>
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
	<style type="text/css">
		#editor{
			height: 300px;
			width: 600px;
			border: 1px solid;
			padding: 20px;
			font-size: 40px;
			overflow-y: auto;
		}
		.valores button{
			cursor: pointer;
		}
	</style>
	<script type="text/javascript">
		// const valores = {
		// 	"1" : "$sueldo_tabla", 
		// 	"2" : "$unidad_tributaria", 
		// 	"3" : "$prima_hijos",
		// 	"4" : "pow(x,y)",
		// 	"5" : "sqrt(x)"
		// }
		// const operadores = {
		// 	"1" : "+", 
		// 	"2" : "-", 
		// 	"3" : "*",
		// 	"4" : "/",
		// 	"5" : "**"
		// }
		// function validar(this_all,event) {
		// 	if(event.keyCode!=8){
				
		// 		var word_now = $(this_all).text()
		// 		$(".coincidencias").empty()
		// 		let err = 0
		// 		let varias = []
		// 		for(i in valores){
		// 			let palabra = valores[i]
		// 			if (palabra.slice(0, word_now.length) == word_now) {
		// 				$(".coincidencias").append("<li>"+palabra+"</li>")
		// 				if (varias.indexOf(word_now)==-1) {
		// 					varias.push(word_now)
		// 				}
		// 				err++
		// 			}
		// 		}
		// 		// if (err==0) {

		// 		// 	//return false

		// 		// 	$(this_all).text(word_now.substr(0, word_now.length-1))
		// 		// 	var mainDiv = this_all;
		// 		// 	var startNode = mainDiv.firstChild;
		// 		// 	var endNode = mainDiv.childNodes[0];

		// 		// 	var range = document.createRange();
		// 		// 	range.setStart(startNode, word_now.length-1);
		// 		// 	range.setEnd(endNode, word_now.length-1); 
		// 		// 	var sel = window.getSelection();
		// 		// 	sel.removeAllRanges();
		// 		// 	sel.addRange(range);
		// 		// }
		// 		//Patron: (Variable || Constante || Función)(+ || - || * || /)
		// 	}
		// }
		$(document).on("click",".boton_formula",function() {
			let editor = $("#editor")
			// var mainDiv = document.getElementById('editor')
			// var word_now = mainDiv.innerText.length-1
			// var startNode = mainDiv.firstChild;
			// var endNode = mainDiv.childNodes[0];

			//var range = document.createRange();
			//range.setStart(startNode, word_now);
			// range.setEnd(endNode, word_now); 
			var sel = window.getSelection().anchorOffset;
			// sel.removeAllRanges();
			// sel.addRange(range);
			
			let first_mitad = editor.text().substr(0,sel) 
			let second_mitad = editor.text().substr(sel,editor.text().length) 
			if ($(this).hasClass('operador')){
				insert("<span class='text-warning'>"+$(this).text()+"</span>")
			}else{
				insert("<span class='text-info'>"+$(this).text()+"</span>")
			}
			
			//console.log(document.getSelection())
		})
		function insert(html) {
			    var sel, range, expandedSelRange, node;
			    if (window.getSelection) {
			        sel = window.getSelection();
			        if (sel.getRangeAt && sel.rangeCount) {
			            range = window.getSelection().getRangeAt(0);
			            range.collapse(false);
			            var el = document.createElement("div");
			            el.innerHTML = html;
			            var frag = document.createDocumentFragment(), node, lastNode;
			            while ( (node = el.firstChild) ) {
			                lastNode = frag.appendChild(node);
			            }
			            range.insertNode(frag);
			        }
			    } else if (document.selection && document.selection.createRange) {
			        range = document.selection.createRange();
			        expandedSelRange = range.duplicate();
			        range.collapse(false);
			        range.pasteHTML(html);
			        expandedSelRange.setEndPoint("EndToEnd", range);
			        expandedSelRange.select();
			    }
		}	
	</script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-auto valores">
				
				<div class="btn-group-vertical">
					<button class="btn btn-warning boton_formula operador">+</button>
					<button class="btn btn-warning boton_formula operador">-</button>
					<button class="btn btn-warning boton_formula operador">*</button>
					<button class="btn btn-warning boton_formula operador">/</button>
					<button class="btn btn-warning boton_formula operador">**</button>
				</div>
				<div class="btn-group-vertical">
					<button class="btn btn-info boton_formula variable">$sueldo_tabla</button>
					<button class="btn btn-info boton_formula variable">$unidad_tributaria</button>
					<button class="btn btn-info boton_formula variable">$prima_hijos</button>
					<button class="btn btn-info boton_formula variable">$sueldo_tabla</button>
					<button class="btn btn-info boton_formula variable">$unidad_tributaria</button>
				</div>
			</div>
			<div class="col">
				<div id="editor" class="" contenteditable="true" onkeydown="return false"></div>
			</div>
		</div>
	</div>
	
</body>
</html>