<?php 
include '../conexion_bd.php';
	if ($_POST['accion']=='f_disponibles') {

		$f_dispo = array();
		$consulta_formulas = (new sql("formulas","order by tipo_concepto, tipo_sueldo desc"))->select();
		while ($row=$consulta_formulas->fetch_assoc()) {
			array_push($f_dispo,array(
				'id'=>$row['id'],
				'descripcion'=>$row['descripcion'],
				'tipo_concepto'=>$row['tipo_concepto'],
				'asignacion_deduccion'=>$row['asignacion_deduccion'],
				'fecha'=>$row['fecha']));
		}
		echo json_encode($f_dispo);
	}else if ($_POST['accion']=='update') {
		$values = "denominacion='".$_POST['nombre_nomina']."',";
		$values .= "tipo_periodo='".$_POST['tipo_periodo']."',";
		$values .= "formulas_a_pagar='".$_POST['formulas_a_pagar']."',";
		$values .= "divisiones='".$_POST['divisiones']."',";
		$values .= "filtros='".$_POST['filtros']."',";
		$values .= "engine='".$_POST['engine']."'";

		$actualizar = (new sql("parametros_nomina",'WHERE id='.$_POST['id_nomina'],$values))->update();
		if ($actualizar==1) {
				echo "Cambios realizados con éxito!";
		}else{
			echo $actualizar;
		}
		
		
	}else if ($_POST['accion']=='save') {

		//print_r($_POST);
		$val = "'".$_POST['nombre_nomina']."','".$_POST['tipo_periodo']."','".$_POST['formulas_a_pagar']."','".$_POST['divisiones']."','".$_POST['engine']."','{}','{}','".$_POST['filtros']."'";
		$insert = (new sql("parametros_nomina",$val,'denominacion,tipo_periodo,formulas_a_pagar,divisiones,engine,incl_excl,opera_espec,filtros'))->insert(); 
		if ($insert==1) {
			echo "Guardado con éxito!";
		}else{
			echo $insert;
		}

	}else if($_POST['accion']=='buscar'){

		$consulta_parametros_nomina = (new sql("parametros_nomina","WHERE id='".$_POST['id_nomina']."'"))->select()->fetch_assoc();
		echo json_encode($consulta_parametros_nomina);
		
	}
 ?>