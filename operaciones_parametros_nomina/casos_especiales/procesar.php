<?php 
	include '../../conexion_bd.php';
	if (isset($_POST['incl_excl'])) {
		$values = "incl_excl='".$_POST['incl_excl']."'";

		$actualizar = (new sql("parametros_nomina",'WHERE id='.$_POST['id'],$values))->update();
		if ($actualizar==1) {
				echo "Actualizado";
		}else{
			echo $actualizar;
		}
	}elseif (isset($_POST['operaciones_especiales_json'])) {
		$values = "opera_espec='".$_POST['operaciones_especiales_json']."'";

		$actualizar = (new sql("parametros_nomina",'WHERE id='.$_POST['id'],$values))->update();
		if ($actualizar==1) {
				echo "Actualizado";
		}else{
			echo $actualizar;
		}
	}elseif (isset($_POST['json_filtros'])) {
		$values = "filtros='".$_POST['json_filtros']."'";

		$actualizar = (new sql("parametros_nomina",'WHERE id='.$_POST['id'],$values))->update();
		if ($actualizar==1) {
				echo "Actualizado";
		}else{
			echo $actualizar;
		}
	}
 ?>