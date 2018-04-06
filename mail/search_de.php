<?php 
include '../conexion_bd.php';
	$sql = (new sql("mail"))->select();
	echo "<table class=\"w3-table w3-table-bordered\">";
	while ($row = $sql->fetch_assoc()) {
		echo "<tr>
			<td class=\"col\">".$row['nombre']."</td>
			<td class=\"col\">".$row['cuenta']."</td>
			<td class=\"col-2\"><input type=\"radio\" value=\"".$row['cuenta']."\" class=\"w3-radio\" name=\"select_de\"/></td></tr>
		";
	}
	echo "</table>";
 ?>