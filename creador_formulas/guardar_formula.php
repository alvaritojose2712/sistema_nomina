<?php
	include '../conexion_bd.php';
	$insert = (new sql("formulas","'".$_POST['condiciones']."','".$_POST['operaciones']."','".$_POST['tipo_concepto']."','".$_POST['tipo_sueldo']."','".$_POST['asignacion_deduccion']."','".$_POST['periodo_pago']."','".$_POST['descripcion']."','".$_POST['vigencia']."'","condiciones, operaciones, tipo_concepto, tipo_sueldo, asignacion_deduccion, periodo_pago, descripcion, fecha"))->insert();
	
	if ($insert==1) {
		echo "Exito al guardar";
	}else{
		echo $insert;
	}
?>