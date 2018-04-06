<?php 
	require "../../conexion_bd.php";

		$campos  = "cat_car_dedic='".$_POST['categoria']."',";
		$campos .= "grado_instruccion='".$_POST['grado_instruccion']."',";
		$campos .= "estado='".$_POST['estado']."',";
		$campos .= "estatus='".$_POST['estatus']."'";
		
		$actualizar = (new sql( "valores_globales" , "WHERE id='1'", $campos ))->update();
		
		if ($actualizar==1) {
			
			echo json_encode(array("estado"=>"exito"));

			if ($_POST['vieja']!="") {
				
				$campo = "";
				switch ($_POST['campo']) {
					case 'Estatus':
						$campo = "estatus";
						break;
					
					case 'Estado':
						$campo = "estado";
						
						break;
					
					case 'Grado de instrucción':
						$campo = "grado_instruccion";
						
						break;
					default:
						$campo=$_POST['campo'];
						break;
					
				}

				(new sql("personal_upt", "WHERE ".$campo."='".$_POST['vieja']."'", $campo."='".$_POST['nueva']."'"))->update();

				(new sql("sueldos","WHERE ".$campo."='".$_POST['vieja']."'",$campo."='".$_POST['nueva']."'"))->update();
				$sql_formulas = (new sql("formulas"))->select();

				while ($row = $sql_formulas->fetch_assoc()) {
					
					(new sql( "formulas" , "WHERE id='".$row['id']."'", "condiciones='".str_replace($_POST['vieja'], $_POST['nueva'], $row['condiciones'])."'" ))->update();
					
				}
								
			}
		}
		else{
			echo json_encode(array("estado"=>"error: ".$actualizar));
			
		}

	

	
 ?>