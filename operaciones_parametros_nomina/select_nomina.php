<?php include '../conexion_bd.php'; ?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
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
		<title> Seleccionar nómina</title>
		<script type="text/javascript">
			function confirm_borrar(id) {
				if (window.confirm("¿Desea realmente eliminar la nómina " + id + "?")) {
					$(document).ready(function() {
						$.ajax({
							url:'borrar_nomina.php',
							type:"post",
							data:{
								'id':id
							},
							success:function(data){
								alert(data);
								location.reload();
							}
						});
					});
					
				}
			}
		</script>
	</head>
	<body>
		<center><header class="header w3-header"><h1>Seleccionar nómina</h1></header></center>

		<table class="w3-table table-bordered table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Denominación</th>
				<th>Período de pago</th>
				<th>Fecha de creación</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$consulta_parametros_nomina = (new sql("parametros_nomina"))->select();
				while ($row=$consulta_parametros_nomina->fetch_assoc()) {
					if ($row['engine']=="aporte patronal") {
						$motor = 'aporte_patronal/';
					}else{
						$motor = 'busqueda_personal.php';

					}
					echo"<tr>
							<td>".$row['id']."</td>
							<td>
								<a href='../".$motor."?id=".$row['id']."'>".$row['denominacion']."
								</a>
							</td>
							<td>".$row['tipo_periodo']."</td>
							<td>".$row['fecha']."</td>
							<td><div class='row'>
								<a href='index.php?id=".$row['id']."' class='col w3-button w3-blue'><i class='fa fa-cog' aria-hidden='true'></i></a>
								<button class='w3-button w3-red col' onclick=confirm_borrar(".$row['id'].")><i class='fa fa-trash-o' aria-hidden='true'></i></button>
							</div></td>
						</tr>";
				}
			 ?>
		</tbody>
	</table>
	
	</body>
	</html>