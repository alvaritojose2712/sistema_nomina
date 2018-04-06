
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Creador de Fórmulas</title>
	<script type="text/javascript" src="../js/jquery.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/w3.css">
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
		<script src="../css/bootstrap/dist/js/tether.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap/dist/css/bootstrap.min.css">
		<script src="../css/bootstrap/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/jquery.cookie.js"></script>

	<script type="text/javascript">
		var json = {};
		
		function pagina_actual(pag='condiciones.php'){
			$.ajax({
				url:pag,
				type:"post",
				success:function(data){
					$("body").html(data);
				}
			});	
		}
	</script>
	<style type="text/css">
		@font-face {
		  font-family: 'Open Sans';
		  font-weight: 400;
		  src: url(../fonts/OpenSans-Light.ttf);
		}
		body{
			font-family: 'Open Sans', sans-serif;
			background-color: #F7F9F9;
		}
		#items{
			width: 100%;

		}
		.izquierdo{
			width: 45%;float: left;
		}
		.derecho{
			width: 45%;float: right;
		}
		.operador_condicion_boton{
			margin-left: 10px
		}
	</style>
</head>
<body onload="pagina_actual()">
	
</body>
</html>
			
