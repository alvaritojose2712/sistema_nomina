<?php 
	session_start();
require "../conexion_bd.php";
	if ($_POST['operacion']=="buscar") {
		$datos = array();
		$sql = (new sql("autenticar","WHERE nombre LIKE '".$_POST['buscar']."%' OR apellido LIKE '".$_POST['buscar']."%' OR usuario LIKE '".$_POST['buscar']."%' OR departamento LIKE '".$_POST['buscar']."%' OR permiso LIKE '".$_POST['buscar']."%'"))->select();
		if ($sql->num_rows==0) {
				array_push($datos,array(
							'id'                => '-',
							'nombre'            => '-',
							'apellido'          => '-',
							'usuario'           => '-',
							'clave'             => '-',
							'departamento'      => '-',
							'permiso'           => '-'
					
							
						));
		}else{

			while ($row=$sql->fetch_assoc()) {

					array_push($datos,array(
							'id'                => $row['id'],
							'nombre'            => $row['nombre'],
							'apellido'          => $row['apellido'],
							'usuario'           => $row['usuario'],
							'clave'             => $row['clave'],
							'departamento'      => $row['departamento'],
							'permiso'           => $row['permiso']
						
						));
			}
			
			
		}
			echo json_encode($datos);
	}elseif ($_POST['operacion']=="eliminar") {
		
		if ($_POST['id']!=$_SESSION['id']) {
			$borrar_user = (new sql("autenticar","id='".$_POST['id']."'"))->delete();
			if ($borrar_user==1) {
				echo "Exito al eliminar";
			}else{
				echo $borrar_user;
			}
		}else{
			echo 'Usted ha iniciado sesión con este usuario, no puede eliminarlo!';
		}
	}elseif ($_POST['operacion']=="comprobar") {
	

		$usuario_introducido = $_POST['usuario'];
		$clave_introducido = $_POST['clave'];
		
		$consulta_autenticar = (new sql("autenticar","WHERE usuario='".$usuario_introducido."' AND clave=PASSWORD('".$clave_introducido."') LIMIT 1"))->select();
		if ($consulta_autenticar->num_rows==1) {
			
			echo json_encode(array("estado"=>"exito"));
		}
		else{
			echo json_encode(array("estado"=>"error"));
			
		}
		

	}elseif ($_POST['operacion']=="actualizar_datos") {
	

		if ($_POST['clave']=="*") {
			$clave = "";
		}else{
			$clave=",clave=PASSWORD('".$_POST['clave']."')";
		}
		$actualizar = (new sql("autenticar","WHERE id='".$_POST['id_user']."'"," nombre='".$_POST['nombre']."',apellido='".$_POST['apellido']."',usuario='".$_POST['usuario']."'$clave,departamento='".$_POST['departamento']."',permiso='".$_POST['permiso']."'"))->update();
		
		if ($actualizar==1) {
			
			echo json_encode(array("estado"=>"exito"));
		}
		else{
			echo json_encode(array("estado"=>"error: ".$actualizar));
			
		}
		

	}elseif ($_POST['operacion']=="agregar") {
	
		$values = "'".$_POST['nombre_nuevo']."','".$_POST['apellido_nuevo']."','".$_POST['usuario_nuevo']."',PASSWORD('".$_POST['clave_nuevo']."'),'".$_POST['departamento_nuevo']."','".$_POST['permiso_nuevo']."'";
		$campos = "nombre,apellido,usuario,clave,departamento,permiso";
		$consulta_autenticar = (new sql("autenticar",$values,$campos))->insert();
		
		if ($consulta_autenticar==1) {
			
			echo json_encode(array("estado"=>"exito"));
		}
		else{
			echo json_encode(array("estado"=>$consulta_autenticar));
			
		}
		

	}elseif ($_POST['operacion']=="reponer") {
		$sql = (new sql("autenticar","WHERE id='".$_POST['id_user']."'"))->select()->fetch_assoc();
		echo json_encode($sql);
		
	}
 ?>

 