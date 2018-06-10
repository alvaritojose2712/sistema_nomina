<?php 
	session_start();
	require "../conexion_bd.php";
	if ($_POST['operacion']=="buscar") {
		$datos = array();
		$sql = (new sql("instituciones","WHERE denominacion LIKE '".$_POST['buscar']."%' OR organo_adscripcion LIKE '".$_POST['buscar']."%' OR codigo_presupuestario LIKE '".$_POST['buscar']."%' OR codigo_institucion LIKE '".$_POST['buscar']."%' OR cuenta_matriz LIKE '".$_POST['buscar']."%'"))->select();

		if ($sql->num_rows==0) {
				array_push($datos,array(
							'id'                => '-',
							'denominacion'            => '-',
							'organo_adscripcion'          => '-',
							'codigo_presupuestario'           => '-',
							'codigo_institucion'             => '-',
							'cuenta_matriz'      => '-'
					
							
						));
		}else{

			while ($row=$sql->fetch_assoc()) {

					array_push($datos,array(
							'id'                => $row['id'],
							'denominacion'            => $row['denominacion'],
							'organo_adscripcion'          => $row['organo_adscripcion'],
							'codigo_presupuestario'           => $row['codigo_presupuestario'],
							'codigo_institucion'             => $row['codigo_institucion'],
							'cuenta_matriz'      => $row['cuenta_matriz']
						
						));
			}
			
			
		}
			echo json_encode($datos);
	}elseif ($_POST['operacion']=="eliminar") {
		
		if ($_POST['clave']!=$_SESSION['denominacion_institucion']) {
			$borrar_insti = (new sql("instituciones","denominacion='".$_POST['clave']."'"))->delete();
			if ($borrar_insti==1) {
				echo "Exito al eliminar";
			}else{
				echo $borrar_insti;
			}
		}else{
			echo 'Usted ha iniciado sesión con esta Institución, no puede eliminarlo!';
		}
	}elseif ($_POST['operacion']=="actualizar_datos") {
		
		$actualizar = (new sql("instituciones","WHERE denominacion='".$_POST['clave']."'"," denominacion='".$_POST['denominacion_edit_val']."',organo_adscripcion='".$_POST['organo_adscripcion_edit_val']."',codigo_presupuestario='".$_POST['codigo_presupuestario_edit_val']."',codigo_institucion='".$_POST['codigo_institucion_edit_val']."',cuenta_matriz='".$_POST['cuenta_matriz_edit_val']."'
			"))->update();
		
		if ($actualizar==1) {
			
			echo json_encode(array("estado"=>"exito"));
			
		}
		else{
			echo json_encode(array("estado"=>"error: ".$actualizar));
			
		}
		

	}elseif ($_POST['operacion']=="agregar") {
	
		$values = "'".$_POST['denominacion']."','".$_POST['organo_adscripcion']."','".$_POST['codigo_presupuestario']."','".$_POST['codigo_institucion']."','".$_POST['cuenta_matriz']."'";
		$campos = "denominacion,organo_adscripcion,codigo_presupuestario,codigo_institucion,cuenta_matriz";
		$consulta_autenticar = (new sql("instituciones",$values,$campos))->insert();
		
		if ($consulta_autenticar==1) {
			
			echo json_encode(array("estado"=>"exito"));
		}
		else{
			echo $consulta_autenticar;
			
		}
		

	}
 ?>

 