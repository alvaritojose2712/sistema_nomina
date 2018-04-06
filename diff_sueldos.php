<?php 
	include 'conexion_bd.php';
	$sueldo_anterior = conectar()->query("SELECT * FROM sueldos where cargo='TITULAR' AND categoria='Docente' and dedicacion='Medio Tiempo' and fecha < (SELECT fecha FROM sueldos where cargo='TITULAR' AND categoria='Docente' and dedicacion='Medio Tiempo' ORDER BY fecha desc limit 1) ORDER BY fecha desc limit 1")->fetch_assoc()['salario'];
	echo $sueldo_anterior."<br>";
	
	$sueldo_nuevo = conectar()->query("SELECT * FROM sueldos where cargo='TITULAR' AND categoria='Docente' and dedicacion='Medio Tiempo' ORDER BY fecha desc limit 1")->fetch_assoc()['salario'];
	echo $sueldo_nuevo."<br>";	
	
 ?>