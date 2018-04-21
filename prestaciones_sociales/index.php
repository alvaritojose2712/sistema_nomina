
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
		
		function buscar (){
		    $(document).ready(function () {
			   $.ajax({
			        url:"procesar.php",
			        data:{
						"fecha_inicio" : $("#fecha_inicio").val(), 
						"fecha_cierre" : $("#fecha_cierre").val(), 
						"busqueda" : $("#busqueda").val()
						
			   		},
			        type:"post",
			        datatype:"json",
			        beforeSend:function (x) {
			        	$("#result").append('<center><div><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div></center>')
			        },
			        success:function(response)
			        {	//document.write(response)
			        	$("#result")
			        	.empty()
			        	.append(response)
			        			
			        }			  
			   })
		    })
	    }
		$(document).ready(function () {
			buscar()
			$("#fecha_inicio,#fecha_cierre").keyup(buscar)
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
				buscar()
				
			})
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
			zoom: 0.90;
			height: 100%;
			width: 100%;
		}	

	</style>
</head>
<body>
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
	       		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
        	<input type="text" class="form-control mr-sm-2" placeholder="Buscar por Nombre, Apellido, Cédula, Cargo o Dedicación" id="busqueda" onkeyup="buscar()">
       		<button class="btn btn-outline-info my-2 my-sm-0" onclick="buscar()" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
     	</ul>
	  </div>
	</nav>
	<hr>
	<aside class="col" id="calculos">
		<div class=" table-responsive" id="result" style="margin:0px">
		</div>
	</aside>
	
</body>
</html>
