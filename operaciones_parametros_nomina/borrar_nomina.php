<?php 
	include '../conexion_bd.php';
	$borrar_nomina = (new sql("parametros_nomina","id='".$_POST['id']."'"))->delete();
	if ($borrar_nomina==1) {
		echo "Exito al borrar";
	}else{
		echo $borrar_nomina;
	}
 ?>