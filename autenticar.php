<?php 
	session_start();
	/*CREATE TABLE `autenticar` (
	  `id` bigint(5) UNSIGNED NOT NULL,
	  `nombre` varchar(50) CHARACTER SET latin1 NOT NULL,
	  `apellido` varchar(50) CHARACTER SET latin1 NOT NULL,
	  `usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
	  `clave` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
	  `departamento` varchar(30) CHARACTER SET latin1 NOT NULL,
	  UNIQUE(usuario)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
	INSERT INTO autenticar (nombre,apellido,usuario,clave,departamento) VALUES ('Alvaro','Ospino','alvaritojose2712',PASSWORD('26767116'),'Recursos humanos');
	*/
	include 'conexion_bd.php';
	$usuario_introducido = $_POST['usuario'];
	$clave_introducido = $_POST['clave'];
	
	$consulta_autenticar = (new sql("autenticar","WHERE usuario='".$usuario_introducido."' AND clave=PASSWORD('".$clave_introducido."') LIMIT 1"))->select();
	if ($consulta_autenticar->num_rows==1) {
		$valores_obtenidos = $consulta_autenticar->fetch_assoc();
		$_SESSION['usuario'] = $usuario_introducido;
		$_SESSION['nombre'] = $valores_obtenidos['nombre'];
		$_SESSION['apellido'] = $valores_obtenidos['apellido'];
		$_SESSION['permiso'] = $valores_obtenidos['permiso'];
		$_SESSION['departamento'] = $valores_obtenidos['departamento'];
		$_SESSION['id'] = $valores_obtenidos['id'];
	}
	else{
		echo "false";
	}
	
	
 ?>