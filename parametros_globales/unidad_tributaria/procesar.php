<?php 
	session_start();
require "../../conexion_bd.php";
	if ($_POST['operacion']=="buscar") {
		$datos = array();
		$sql = (new sql("unidad_tributaria","WHERE fecha_inicio_vigencia LIKE '".$_POST['buscar']."%' OR fecha_decreto LIKE '".$_POST['buscar']."%' OR gaceta_oficial LIKE '".$_POST['buscar']."%' OR valor LIKE '".$_POST['buscar']."%'"))->select();
		if ($sql->num_rows==0) {
			array_push($datos,array(
						'id'                     => '-',
						'fecha_inicio_vigencia'  => '-',
						'fecha_decreto'          => '-',
						'gaceta_oficial'         => '-',
						'valor'                  => '-'			
						
					));
		}else{
			while ($row=$sql->fetch_assoc()) {

				array_push($datos,array(
						'id'                     => $row['id'],
						'fecha_inicio_vigencia'  => $row['fecha_inicio_vigencia'],
						'fecha_decreto'          => $row['fecha_decreto'],
						'gaceta_oficial'         => $row['gaceta_oficial'],
						'valor'                  => $row['valor']
					));
			}
		}
			echo json_encode($datos);
	}elseif ($_POST['operacion']=="eliminar") {

		$borrar_user = (new sql("unidad_tributaria","id='".$_POST['id']."'"))->delete();
		if ($borrar_user==1) {
			echo "Exito al eliminar";
		}else{
			echo $borrar_user;
		}
		
	}elseif ($_POST['operacion']=="actualizar_datos") {
	
		$campos  = "fecha_inicio_vigencia='".$_POST['fecha_inicio_vigencia']."',";
		$campos .= "fecha_decreto='".$_POST['fecha_decreto']."',";
		$campos .= "gaceta_oficial='".$_POST['gaceta_oficial']."',";
		$campos .= "valor='".$_POST['valor']."'";
		
		$actualizar = (new sql( "unidad_tributaria" , "WHERE id='".$_POST['id_user']."'", $campos ))->update();
		
		if ($actualizar==1) {
			
			echo json_encode(array("estado"=>"exito"));
		}
		else{
			echo json_encode(array("estado"=>"error: ".$actualizar));
			
		}
		
	}elseif ($_POST['operacion']=="agregar") {
	
		$values = "'".$_POST['fecha_inicio_vigencia_nuevo']."','".$_POST['fecha_decreto_nuevo']."','".$_POST['gaceta_oficial_nuevo']."','".$_POST['valor_nuevo']."'";
		
		$campos = "fecha_inicio_vigencia,fecha_decreto,gaceta_oficial,valor";
		$consulta_autenticar = (new sql("unidad_tributaria",$values,$campos))->insert();
		
		if ($consulta_autenticar==1) {
			
			echo json_encode(array("estado"=>"exito"));
		}
		else{
			echo json_encode(array("estado"=>$consulta_autenticar));
			
		}
		

	}elseif ($_POST['operacion']=="reponer") {
		$sql = (new sql("unidad_tributaria","WHERE id='".$_POST['id_user']."'"))->select()->fetch_assoc();
		echo json_encode($sql);
		
	}
 ?>

 