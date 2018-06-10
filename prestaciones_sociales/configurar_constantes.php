<?php 
	include '../conexion_bd.php';
	if ($_POST['accion']=="consultar") {
		$sql = (new sql("prestaciones_sociales","WHERE id=1"))->select();
		echo json_encode($sql->fetch_assoc());
	}elseif($_POST['accion']=="editar"){
		$DIAS_TRABAJADOS_literal_b = $_POST['DIAS_TRABAJADOS_literal_b'];
		$DIAS_DE_PRESTACIONES_literal_b = $_POST['DIAS_DE_PRESTACIONES_literal_b'];
		$MAX_DIAS_ADICIONALES_literal_b = $_POST['MAX_DIAS_ADICIONALES_literal_b'];
		$DIAS_ADICIONALES_literal_b = $_POST['DIAS_ADICIONALES_literal_b'];
		$DIAS_x_AÑO_literal_c = $_POST['DIAS_x_AÑO_literal_c'];
		
		$sql = (new sql("prestaciones_sociales","WHERE id=1","
			DIAS_TRABAJADOS_literal_b = $DIAS_TRABAJADOS_literal_b,
			DIAS_DE_PRESTACIONES_literal_b = $DIAS_DE_PRESTACIONES_literal_b,
			MAX_DIAS_ADICIONALES_literal_b = $MAX_DIAS_ADICIONALES_literal_b,
			DIAS_ADICIONALES_literal_b = $DIAS_ADICIONALES_literal_b,
			DIAS_x_AÑO_literal_c = $DIAS_x_AÑO_literal_c"))->update();

		if ($sql==1) {
			echo "Exito al actualizar";
		}
	}
 ?>