<?php 
	include '../conexion_bd.php';
	if ($_POST['operacion']=="buscar") {
		$b = " LIKE '%".$_POST['b']."%'";
		$busqueda = "tipo_concepto ".$b." OR tipo_sueldo".$b." OR periodo_pago".$b." OR asignacion_deduccion".$b." OR descripcion".$b;
		
		$f_dispo = array();
		$consulta_formulas = (new sql("formulas","WHERE ".$busqueda." order by tipo_concepto, tipo_sueldo desc"))->select();
		while ($row=$consulta_formulas->fetch_assoc()) {
			array_push($f_dispo,array(
				"id" => $row["id"],
				"descripcion" => $row["descripcion"],
				"condiciones" => $row["condiciones"],
				"operaciones" => $row["operaciones"],
				"tipo_concepto" => $row["tipo_concepto"],
				"tipo_sueldo" => $row["tipo_sueldo"],
				"asignacion_deduccion" => $row["asignacion_deduccion"],
				"periodo_pago" => $row["periodo_pago"],
				"fecha" => $row["fecha"]
			));
		}
		echo json_encode($f_dispo);
	}elseif ($_POST['operacion']=="update") {
		$update = (new sql("formulas"))->select()->fetch_assoc();
		$values = "";
		foreach ($update as $key => $value) {
			if ($key!="id") {
				$values.=$key."='".$_POST[$key]."',";
			}
		}
		$values = substr($values, 0, -1);
		$actualizar = (new sql("formulas",'WHERE id='.$_POST['id'],$values))->update();
		if ($actualizar==1) {
			echo "Exito al actualizar";
		}else{
			echo $actualizar;
		}
	}elseif ($_POST['operacion']=="insert") {
		$insert = (new sql("formulas","'".$_POST['condiciones']."','".$_POST['operaciones']."','".$_POST['tipo_concepto']."','".$_POST['tipo_sueldo']."','".$_POST['asignacion_deduccion']."','".$_POST['periodo_pago']."','".$_POST['descripcion']."','".$_POST['fecha']."'","condiciones, operaciones, tipo_concepto, tipo_sueldo, asignacion_deduccion, periodo_pago, descripcion, fecha"))->insert();
	
		if ($insert==1) {
			echo "Exito al guardar";
		}else{
			echo $insert;
		}
	}elseif ($_POST['operacion']=="delete") {
		$borrar_formula = (new sql("formulas","id='".$_POST['id']."'"))->delete();
			if ($borrar_formula==1) {
				echo "Exito al eliminar";
			}else{
				echo $borrar_formula;
			}
	}
?>