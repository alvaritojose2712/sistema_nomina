<?php 
	include '../conexion_bd.php';
	if ($_POST['accion']=="buscar") {
		$estatus_filtro = "";
		if ($_POST['estatus_filtro']!="") {
			$estatus_filtro = "AND (estatus LIKE '".$_POST['estatus_filtro']."')";
		}
		$estado_filtro = "";
		if ($_POST['estado_filtro']!="") {
			$estado_filtro = "AND (estado LIKE '".$_POST['estado_filtro']."')";
		}
		

		$sql = (new sql("personal_upt","WHERE 
			(nombre LIKE '".$_POST['buscar']."%' 
			OR apellido LIKE '".$_POST['buscar']."%' 
			OR estatus LIKE '".$_POST['buscar']."%' 
			OR estado LIKE '".$_POST['buscar']."%' 
			OR cedula LIKE '".$_POST['buscar']."%')
			$estatus_filtro
			$estado_filtro
			ORDER BY ".$_POST["ordenar"][0]." ".$_POST["ordenar"][1]."
			"))->select();
		
		$datos = array("personal"=>array(),"estatus"=>array());
		if ($sql->num_rows==0) {
			echo "<div class='w3-center section-large'><h1><i class='fa fa-exclamation-triangle'></i> No se encontraron resultados</h1></div>'";
			exit();
		}else{
			$todos_estatus = array();
			while ($row=$sql->fetch_assoc()) {
				$fecha_actual = new DateTime("".date("y-m-d")."");
				
				$fecha_nacimiento = new DateTime("".$row['fecha_nacimiento']."");
				$edad = $fecha_nacimiento->diff($fecha_actual)->y;

				$fecha_ingreso = new DateTime("".$row['fecha_ingreso']."");
				$edad_ingreso = $fecha_ingreso->diff($fecha_actual)->y;
				
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
							 'edad' => (new DateTime("".$row_hijos['fecha_nacimiento'].""))->diff($fecha_actual)->y,  
							 'Discapacidad' => $row_hijos['discapacidad'] 
						));
					}
				}
				array_push($datos['personal'], array(
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
									 'hijos' => $datos_hijos,
									 'num_hijos' => $sql_hijos->num_rows,
									 'edad' => $edad,
									 "años-fecha-ingreso-show" => $edad_ingreso
				));
				if (array_key_exists($row['estatus'], $todos_estatus)) {
					$todos_estatus[$row['estatus']]++;
				}else{
					$todos_estatus[$row['estatus']]=1;
				}
			}
			$todos_estatus["Todos"]=$sql->num_rows;
			$datos['todos_estatus'] = $todos_estatus;
								
		}
		echo json_encode($datos);
	}elseif ($_POST['accion']=="agregar") {
		$agregar = (new sql("personal_upt",$_POST["valores"],$_POST['campos']))->insert();
		if ($agregar==1) {
			echo json_encode(array("estado"=>"<h1>Éxito al guardar los datos <i class='fa fa-check'></i></h1>"));
		 	if (isset($_POST['valores_hijos'])) {
		 		foreach ($_POST['valores_hijos'] as $key => $value) {
		 			(new sql("hijos_personal",$value,'id,nombre,apellido,cedula_representante,fecha_nacimiento,estudia,discapacidad'))->insert();
		 		}
		 	}
		}else{
			echo $agregar;
		}
	}elseif ($_POST['accion']=="eliminar") {
		(new sql("hijos_personal","cedula_representante='".$_POST['cedula']."'"))->delete();
		$borrar_user = (new sql("personal_upt","cedula='".$_POST['cedula']."'"))->delete();
		if ($borrar_user==1) {
			echo "Éxito al eliminar";
		}else{
			echo $borrar_user;
		}
	}elseif ($_POST['accion']=='editar') {

		$arr_valores = explode(",", $_POST['valores']);
		$str_edit = "";
		foreach (explode(",", $_POST['campos']) as $key => $valor_campo) {
			$str_edit .= $valor_campo."=".$arr_valores[$key].",";
		}
		$str_edit = substr($str_edit, 0,-1);
		$id = $_POST['editando'];
		//echo $str_edit;
		$actualizar = (new sql("personal_upt","WHERE cedula='$id'",$str_edit))->update();
			
		if ($actualizar==1 || $actualizar=="0 registros afectados") {
			echo json_encode(array("estado"=>"Actualizado con éxito"));
			(new sql("hijos_personal","cedula_representante='$id'"))->delete();
			if (isset($_POST['valores_hijos'])) {
		 		foreach ($_POST['valores_hijos'] as $key => $value) {
		 			(new sql("hijos_personal",$value,'id,nombre,apellido,cedula_representante,fecha_nacimiento,estudia,discapacidad'))->insert();
		 		}
		 	}
		}else{
			echo json_encode(array("estado"=>$actualizar));
		}
		
	}
 ?>