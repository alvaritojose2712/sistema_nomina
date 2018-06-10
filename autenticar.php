<?php 
	session_start();
	include 'conexion_bd.php';
	$usuario_introducido = $_POST['usuario'];
	$clave_introducido = $_POST['clave'];
	$institucion_seleccionada = $_POST['institucion_seleccionada'];
	
	$consulta_autenticar = (new sql("autenticar","WHERE usuario='".$usuario_introducido."' AND clave=PASSWORD('".$clave_introducido."') LIMIT 1"))->select();
	$consulta_institucion = (new sql("instituciones","WHERE id='".$institucion_seleccionada."'"))->select()->fetch_assoc();
	if ($consulta_autenticar->num_rows==1) {
		$valores_obtenidos = $consulta_autenticar->fetch_assoc();
		$_SESSION['usuario'] = $usuario_introducido;
		$_SESSION['nombre'] = $valores_obtenidos['nombre'];
		$_SESSION['apellido'] = $valores_obtenidos['apellido'];
		$_SESSION['permiso'] = $valores_obtenidos['permiso'];
		$_SESSION['departamento'] = $valores_obtenidos['departamento'];
		$_SESSION['id'] = $valores_obtenidos['id'];

		$_SESSION['id_institucion'] = $consulta_institucion['id'];
		$_SESSION['denominacion_institucion'] = $consulta_institucion['denominacion'];
		$_SESSION['organo_adscripcion_institucion'] = $consulta_institucion['organo_adscripcion'];
		$_SESSION['codigo_presupuestario_institucion'] = $consulta_institucion['codigo_presupuestario'];
		$_SESSION['codigo_institucion_institucion'] = $consulta_institucion['codigo_institucion'];
		$_SESSION['cuenta_matriz_institucion'] = $consulta_institucion['cuenta_matriz'];

		setcookie("nombre",$_SESSION['nombre']);
		setcookie("apellido",$_SESSION['apellido']);
		setcookie("usuario",$_SESSION['usuario']);
		setcookie("departamento",$_SESSION['departamento']);
		setcookie("permiso",$_SESSION['permiso']);
		setcookie("denominacion_institucion",$_SESSION['denominacion_institucion']);

	}
	else{
		echo "false";
	}
	
	
 ?>