<?php 
	include '../../conexion_bd.php';
	if ($_POST['operacion']=='buscar') {
		
		$consulta = (new sql("sueldos","WHERE categoria LIKE '".$_POST['busqueda']."%' OR cargo LIKE '".$_POST['busqueda']."%' OR dedicacion LIKE '".$_POST['busqueda']."%'","DISTINCTROW categoria, cargo, dedicacion"))->select();
		$resultados = array();

		while ($row = $consulta->fetch_assoc()) {
			$cat = $row['categoria'];
			$car = $row['cargo'];
			$dedic = $row['dedicacion'];

			$subconsulta = (new sql("sueldos","WHERE dedicacion='".$dedic."' AND categoria='".$cat."' AND cargo='".$car."' order by fecha asc"))->select();

			$salarios = array();

			while ($subrow=$subconsulta->fetch_assoc()) {
				$salarios[$subrow['fecha']] = $subrow['salario'];
			}

			array_push($resultados,array('categoria' => $row['categoria'],'cargo' => $row['cargo'],'dedicacion' => $row['dedicacion'],'salario' => $salarios));
			
		}

		echo json_encode($resultados);
		 
	}elseif($_POST['operacion']=="add_sueldo"){

		if (is_numeric($_POST['salario'])) {
			$values = "'".$_POST['categoria']."','".$_POST['cargo']."','".$_POST['dedicacion']."','".$_POST['salario']."','".$_POST['fecha_vigencia']."'";
			$campos = "categoria,cargo,dedicacion,salario,fecha";

			$insert = (new sql("sueldos",$values,$campos))->insert();
				
			if ($insert==1) {echo "Exito al guardar";}else{echo $insert;}
		}else{
			echo "El valor introducido no es numérico";
		}
		
		
	}elseif($_POST['operacion']=="add_aumento"){
		
			if ($_POST['values']!="") {
				$campos = "categoria,cargo,dedicacion,salario,fecha";
				$insert = (new sql("sueldos",$_POST['values'],$campos))->insert();
					
				if ($insert==1) {
					echo "Exito al guardar";
				}
				else{
					echo $insert;
				}
			}else{
				echo "Campos vacíos";
			}
	
	}elseif ($_POST['operacion']=="editar") {
		$json = json_decode($_POST['values'],true);
		$cat = $_POST['categoria'];
		$car = $_POST['cargo'];
		$dedic = $_POST['dedicacion'];

		$estatus = array();
		foreach ($json as $key => $sub_array) {
			$where = "categoria='".$cat."' AND ";
			$where .= "cargo='".$car."' AND ";
			$where .= "fecha='".$sub_array['fecha_reference']."' AND ";
			$where .= "salario='".$sub_array['monto_reference']."' AND ";
			$where .= "dedicacion='".$dedic."'";
			
			$values = "fecha='".$sub_array['fecha_new']."',";
			$values .= "salario='".$sub_array['monto_new']."'";
			
			
			if (is_numeric($sub_array['monto_new'])):
				$actualizar_sueldo = (new sql("sueldos",'WHERE '.$where,$values))->update();
				
				if ($actualizar_sueldo==1):
					$estatus[$key] = "<i class=\"fa fa-check-circle\" aria-hidden=\"true\"></i> Actualizado";

				elseif($actualizar_sueldo=="0 registros afectados"):

					$estatus[$key] = "<i class=\"fa fa-question-circle\" aria-hidden=\"true\"></i> Sin modificaciones";

				else:

					$estatus[$key] = $actualizar_sueldo;
				endif;

			else:
				$estatus[$key] = "<i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i> Valor no numérico";
			endif;

		}
		echo json_encode($estatus);	

	}elseif ($_POST['operacion']=="eliminar") {

		$vals = json_decode($_POST['values'],true);
		$where = "categoria='".$_POST['categoria']."' AND ";
		$where .= "cargo='".$_POST['cargo']."' AND ";
		$where .= "dedicacion='".$_POST['dedicacion']."'";
			
		if ($vals['modo']=="borrar_todos") {
			
			$delete = (new sql("sueldos",$where))->delete();
			if ($delete==1) {
				
				echo json_encode(array('todos'=>"Exito al eliminar"));
			}else{
				echo json_encode(array('todos'=>$delete));

			}
		}else{
		$estatus = array();

			foreach ($vals['modo'] as $key => $arr) {
				$where_ = " AND fecha='".$arr['fecha']."' AND ";
				$where_ .= "salario='".$arr['salario']."'";

				$delete = (new sql("sueldos",$where.$where_))->delete();
				if ($delete==1) {
					$estatus[$key] = array('indiv'=>array($arr['fecha']=>$arr['salario']));
					
				}else{
					$estatus[$key] = array('err'=>$delete);	
				}
			}
		echo json_encode($estatus);


		}
	}
 ?>