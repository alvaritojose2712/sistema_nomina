<?php 
	session_start();
require "../../conexion_bd.php";
	if ($_POST['operacion']=="buscar") {
		$datos = array();
		$sql = (new sql("mail"))->select();
		if ($sql->num_rows==0) {
			array_push($datos,array(
						'id'     		 => '-',
						'nombre' 		 => '-',
						'cuenta'         => '-',
						'clave'          => '-',
						'servidor_smtp'  => '-'			
						
					));
		}else{
			while ($row=$sql->fetch_assoc()) {

				array_push($datos,array(
						'id'            => $row['id'],
						'nombre'  		=> $row['nombre'],
						'cuenta'        => $row['cuenta'],
						'clave'         => $row['clave'],
						'servidor_smtp' => $row['servidor_smtp']
					));
			}
		}
			echo json_encode($datos);
	}elseif ($_POST['operacion']=="eliminar") {

		$borrar_user = (new sql("mail","id='".$_POST['id']."'"))->delete();
		if ($borrar_user==1) {
			echo "Exito al eliminar";
		}else{
			echo $borrar_user;
		}
		
	}elseif ($_POST['operacion']=="actualizar_datos") {
	
		$campos  = "nombre='".$_POST['remitente']."',";
		$campos .= "cuenta='".$_POST['cuenta']."',";
		$campos .= "clave='".$_POST['clave']."',";
		$campos .= "servidor_smtp='".$_POST['servidor']."'";
		
		$actualizar = (new sql( "mail" , "WHERE id='".$_POST['id_user']."'", $campos ))->update();
		
		if ($actualizar==1) {
			
			echo json_encode(array("estado"=>"exito"));
		}
		else{
			echo json_encode(array("estado"=>"error: ".$actualizar));
			
		}
		
	}elseif ($_POST['operacion']=="agregar") {
	
		$values = "'".$_POST['remitente']."','".$_POST['cuenta']."','".$_POST['clave']."','".$_POST['servidor']."'";
		
		$campos = "nombre,cuenta,clave,servidor_smtp";
		$consulta_autenticar = (new sql("mail",$values,$campos))->insert();
		
		if ($consulta_autenticar==1) {
			
			echo json_encode(array("estado"=>"exito"));
		}
		else{
			echo json_encode(array("estado"=>$consulta_autenticar));
			
		}
		

	}
 ?>

