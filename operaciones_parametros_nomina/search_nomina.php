<?php 
	include '../conexion_bd.php';
	$consulta_parametros_nomina = (new sql("parametros_nomina","WHERE denominacion LIKE '".$_POST['buscar']."%'"))->select();
	$arr = array();
	while ($row=$consulta_parametros_nomina->fetch_assoc()) {
		if ($row['engine']=="aporte patronal") {
			$motor = 'aporte_patronal/';
		}else{
			$motor = 'busqueda_personal.php';

		}
		// echo"<tr>
		// 		<td>".$row['id']."</td>
		// 		<td>
		// 			<a href='../".$motor."?id=".$row['id']."&denominacion=".$row['denominacion']."'>".$row['denominacion']."
		// 			</a>
		// 		</td>
		// 		<td>".$row['tipo_periodo']."</td>
		// 		<td>".$row['fecha']."</td>
		// 		<td><div class='row'>
		// 			<a href='index.php?id=".$row['id']."' class='col w3-button w3-blue'><i class='fa fa-cog' aria-hidden='true'></i></a>
		// 			<button class='w3-button w3-red col' onclick=confirm_borrar(".$row['id'].")><i class='fa fa-trash-o' aria-hidden='true'></i></button>
		// 		</div></td>
		// 	</tr>";
			$arr[$row['id']]=array("motor"=>$motor,"denominacion"=>$row['denominacion'],"tipo_periodo"=>$row['tipo_periodo'],"fecha"=>$row['fecha'],"divisiones"=>$row['divisiones'],"formulas"=>$row['formulas_a_pagar']);
	}
	echo json_encode($arr);
 ?>