<?php 
require "../conexion_bd.php";
$datos = array();
//$sql = conectar()->query("SELECT * FROM personal_upt
 //WHERE estatus LIKE '".$_POST['buscar']."%' OR nombre LIKE '".$_POST['buscar']."%' OR apellido LIKE '".$_POST['buscar']."%' OR cedula LIKE '".$_POST['buscar']."%'");
$sql = (new sql("personal_upt","WHERE estatus LIKE '".$_POST['buscar']."%' OR nombre LIKE '".$_POST['buscar']."%' OR apellido LIKE '".$_POST['buscar']."%' OR cedula LIKE '".$_POST['buscar']."%'"))->select();
if ($sql->num_rows==0) {
		array_push($datos,array(
					'id'                => 'No se encontró información',
					'nombre'            => 'No se encontró información',
					'cedula'            => 'No se encontró información',
					'apellido'          => 'No se encontró información',
					'cargo'             => 'No se encontró información',
					'dedicacion'        => 'No se encontró información',
					'estatus'           => 'No se encontró información',
					'categoria'         => 'No se encontró información',
					'fecha_ingreso'     => 'No se encontró información',
					'grado_instruccion' => 'No se encontró información',
					'salario'      	    => 'No se encontró información'		
				));
}else{

	while ($row=$sql->fetch_assoc()) {
		$consulta_sueldo = (new sql("sueldos","WHERE dedicacion='".$row['dedicacion']."' AND categoria='".$row['categoria']."' AND cargo='".$row['cargo']."' ORDER BY fecha desc limit 1","salario"))->select();
	    $sueldo_tabla = $consulta_sueldo->fetch_assoc()['salario'];
		
		$fecha1_ingreso = new DateTime("".$row['fecha_ingreso']."");
		$fecha2_actual = new DateTime("".date("y-m-d")."");
		$fecha_antiguedad = $fecha1_ingreso->diff($fecha2_actual);
		$años_antiguedad = $fecha_antiguedad->y;

		$consulta_hijos = (new sql("hijos_personal","WHERE cedula_representante='".$row['cedula']."'"))->select();

		$numero_de_hijos_personal = $consulta_hijos->num_rows;

			array_push($datos,array(
					'id'                => $row['id'],
					'nombre'            => $row['nombre'],
					'cedula'            => $row['cedula'],
					'apellido'          => $row['apellido'],
					'cargo'             => $row['cargo'],
					'dedicacion'        => $row['dedicacion'],
					'estatus'           => $row['estatus'],
					'categoria'         => $row['categoria'],
					'fecha_ingreso'     => $row['fecha_ingreso'],
					'nacionalidad'      => $row['nacionalidad'],
					'grado_instruccion' => $row['grado_instruccion'],
					'profesion' 		=> $row['profesion'],
					'departamento_adscrito' => $row['departamento_adscrito'],
					'salario'      	      => $sueldo_tabla,
					"genero" 	    	  =>  $row['genero'],
					"cuenta_bancaria"     =>  $row['cuenta_bancaria'],
					"numero_hijos"        =>  $numero_de_hijos_personal,
					"telefono_1"		  =>  $row['telefono_1'],
					"telefono_2"		  =>  $row['telefono_2'],
					"correo"		 	  =>  $row['correo'],
					"caja_ahorro"	      =>  $row['caja_ahorro'],
					"antiguedad_otros_ieu"=>  $row['antiguedad_otros_ieu'],
					"años_servicio" 	  =>  $años_antiguedad			
				));
	}
	
	
}
	echo json_encode($datos);
 ?>
