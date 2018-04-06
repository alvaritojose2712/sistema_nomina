<?php
	include '../conexion_bd.php';
	if ($_POST['operacion']=='agregar') {
		$sql = (new sql("personal_upt"))->select()->fetch_assoc();

		$values = "";
		$campos = "";
		foreach ($sql as $key => $value) {
			if ($key!="id") {
				$campos.=$key.",";
				$values.="'".$_POST[$key]."',";
			}
		}
		$values = substr($values, 0, -1);
		$campos = substr($campos, 0, -1);

		$insert = (new sql("personal_upt",$values,$campos))->insert();
			
			if ($insert==1) {
				echo "Exito al guardar";
				(new sql("hijos_personal",$_POST['insert_hijos'],'nombre,apellido,cedula_representante,fecha_nacimiento,estudia,discapacidad'))->insert();

			}else{
				echo $insert;
			}
	}elseif ($_POST['operacion']=='buscar') {
		$sql = (new sql("personal_upt","WHERE nombre LIKE '".$_POST['buscar']."%' OR apellido LIKE '".$_POST['buscar']."%' OR cedula LIKE '".$_POST['buscar']."%'"))->select();
		
		$datos = array();
		if ($sql->num_rows==0) {
						array_push($datos,array(
									 'Id' => '-',                     
									 'Estado' => '-',                
									 'Nombres' => '-',                 
									 'Apellidos' => '-',               
									 'Cédula' => '-',                 
									 'Nacionalidad' => '-',           
									 'Genero' => '-',                 
									 'Fecha nacimiento' => '-',       
									 'Teléfono 1' => '-',             
									 'Teléfono 2' => '-',             
									 'Correo electrónico' => '-', 
									 'Profesión' => '-',                
									 'Departamento adscrito' => '-',                
									 'Cargo desempeñado en el departamento' => '-',                  
									 'Estatus' => '-',                
									 'Fecha de ingreso' => '-',          
									 'Grado de instrucción' => '-',      
									 'Categoría' => '-',              
									 'Dedicación' => '-',             
									 'Caja de ahorro' => '-',            
									 'Cargo' => '-',                  
									 'Cuenta bancaria' => '-',        
									 'Antiguedad en otros IEU' => '-',   
									 'Horas extras nocturnas' => '-',          
									 'Horas extras feriadas' => '-',           
									 'Horas extras diurnas' => '-',            
									 'Horas extras feriadas-nocturnas' => '-',
									 'hijos' => '-'
	
								));
		}else{

			while ($row=$sql->fetch_assoc()) {
				$datos_hijos = array();
				$sql_hijos = (new sql("hijos_personal","WHERE cedula_representante=".$row['cedula']))->select();
				
				if ($sql_hijos->num_rows!=0) {
					while ($row_hijos=$sql_hijos->fetch_assoc()) {
						array_push($datos_hijos, array(
							 'Id' => $row_hijos['id'],                 
							 'Nombre' => $row_hijos['nombre'],                 
							 'Apellido' => $row_hijos['apellido'],               
							 'Fecha de nacimiento' => $row_hijos['fecha_nacimiento'],               
							 'Estudia' => $row_hijos['estudia'],  
							 'Discapacidad' => $row_hijos['discapacidad'] 
						));
					}
				}
				$datos[$row['cedula']] = array(
									 'Id' => $row['id'],                     
									 'Estado' => $row['estado'],                
									 'Nombres' => $row['nombre'],                 
									 'Apellidos' => $row['apellido'],               
									 'Cédula' => $row['cedula'],                 
									 'Nacionalidad' => $row['nacionalidad'],           
									 'Genero' => $row['genero'],                 
									 'Fecha nacimiento' => $row['fecha_nacimiento'],       
									 'Teléfono 1' => $row['telefono_1'],             
									 'Teléfono 2' => $row['telefono_2'],             
									 'Correo electrónico' => $row['correo'],                 
									 'Estatus' => $row['estatus'],                
									 'Profesión' => $row['profesion'],                
									 'Departamento adscrito' => $row['departamento_adscrito'],                
									 'Cargo desempeñado en el departamento' => $row['cargo_desempeñado_departamento'],                
									 'Fecha de ingreso' => $row['fecha_ingreso'],          
									 'Grado de instrucción' => $row['grado_instruccion'],      
									 'Categoría' => $row['categoria'],              
									 'Dedicación' => $row['dedicacion'],             
									 'Caja de ahorro' => $row['caja_ahorro'],            
									 'Cargo' => $row['cargo'],                  
									 'Cuenta bancaria' => $row['cuenta_bancaria'],        
									 'Antiguedad en otros IEU' => $row['antiguedad_otros_ieu'],   
									 'Horas extras nocturnas' => $row['hrs_nocturnas'],          
									 'Horas extras feriadas' => $row['hrs_feriadas'],           
									 'Horas extras diurnas' => $row['hrs_diurnas'],            
									 'Horas extras feriadas-nocturnas' => $row['hrs_feriadas_nocturnas'],
									 'hijos' => $datos_hijos
															
								
								);
			}
								
		}
		echo json_encode($datos);
	}elseif ($_POST['operacion']=="eliminar") {
		(new sql("hijos_personal","cedula_representante='".$_POST['cedula']."'"))->delete();
		$borrar_user = (new sql("personal_upt","cedula='".$_POST['cedula']."'"))->delete();
			if ($borrar_user==1) {
				echo "Exito al eliminar";
			}else{
				echo $borrar_user;
			}
	}elseif ($_POST['operacion']=='editar') {
		$sql = (new sql("personal_upt"))->select()->fetch_assoc();
		$values = "";
		foreach ($sql as $key => $value) {
			if ($key!="id") {
				$values.=$key."='".$_POST[$key]."',";
			}
		}
		$values = substr($values, 0, -1);

		$actualizar = (new sql("personal_upt",'WHERE id='.$_POST['Id'],$values))->update();
			
			if ($actualizar==1 || $actualizar=="0 registros afectados") {
				echo "Actualizado";
				(new sql("hijos_personal","cedula_representante='".$_POST['cedula']."'"))->delete();
				if (isset($_POST['hijos'])) {
					foreach ($_POST['hijos'] as $clave_sub_array => $sub_array) {
						(new sql("hijos_personal","'".$sub_array['nombre']."','".$sub_array['apellido']."','".$_POST['cedula']."','".$sub_array['fecha_nacimiento']."','".$sub_array['estudia']."','".$sub_array['discapacidad']."'",'nombre,apellido,cedula_representante,fecha_nacimiento,estudia,discapacidad'))->insert();		
					}
				}
			}else{
				echo $actualizar;
			}
	}
?>

