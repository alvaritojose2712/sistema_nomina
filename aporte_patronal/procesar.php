<?php 

	include '../conexion_bd.php';

	function filtro($parametro1,$operador,$parametro2)
	{
		if ($operador=="cualquiera" || $parametro1=="cualquiera" || $parametro2=="cualquiera") {
			return "Verdadero";
		}
		else if ($operador == "igual") {
			if ($parametro1==$parametro2) {
				return "Verdadero";
			}else{
				return "Falso";
			}
		}
		else if ($operador == "diferente") {
			if ($parametro1!=$parametro2) {
				return "Verdadero";
			}else{
				return "Falso";
			}
		}
		else if ($operador == "menor") {
			if ($parametro1<$parametro2) {
				return "Verdadero";
			}else{
				return "Falso";
			}
		}
		else if ($operador == "mayor") {
			if ($parametro1>$parametro2) {
				return "Verdadero";
			}else{
				return "Falso";
			}
		}
		else if ($operador == "menor o igual") {
			if ($parametro1<=$parametro2) {
				return "Verdadero";
			}else{
				return "Falso";
			}
		}
		else if ($operador == "mayor o igual") {
			if ($parametro1>=$parametro2) {
				return "Verdadero";
			}else{
				return "Falso";
			}
		}
		else{
			return "Entrada no válida";
		}	
	}
	function lunes_mes()
    {
        $fecha_datetime = new DateTime();
        $dias_semana = ["0"=>"domingo","1"=>"lunes","2"=>"martes","3"=>"miercoles","4"=>"jueves","5"=>"viernes","6"=>"sabado"];


        $fecha_datetime->modify('last day of this month');
        $lunes_del_mes = 4;
        if ($fecha_datetime->format('d/m/Y')==28) {
            $lunes_del_mes = 4; 
        }else if ($fecha_datetime->format('d/m/Y')==30) {
            switch ($dias_semana[$fecha_datetime->format('w')]) {
                case 'martes':
                    $lunes_del_mes++;
                    break;
                case 'lunes':
                    $lunes_del_mes++;
                    break;
            }
        }else if ($fecha_datetime->format('d/m/Y')==31) {
            switch ($dias_semana[$fecha_datetime->format('w')]) {
                case 'miercoles':
                    $lunes_del_mes++;                  
                    break;
                case 'martes':
                    $lunes_del_mes++;
                    break;                 
                case 'lunes':
                    $lunes_del_mes++;
                    break;
            }
        }
        else if ($fecha_datetime->format('d/m/Y')==29) {
            switch ($dias_semana[$fecha_datetime->format('w')]) {                
                case 'lunes':
                    $lunes_del_mes++;
                    break;
            }
        }
        return $lunes_del_mes;
    }
	function sumar($operacion,$asignacion_deduccion,$descripcion,$tipo_concepto,$tipo_sueldo,$id,$periodo_pago,$operacion_recibo_aportes,$value_correspon){
		global $array_formulas_a_pagar,$suma_total_trabajador,$unidad_tributaria,$sueldo_tabla,$años_antiguedad,$prima_hijos,$lunes_del_mes,$recibo_asignaciones,$recibo_aporte_patronal,$recibo_deducciones,$sueldo_normal,$hrs_nocturnas,$hrs_feriadas,$hrs_diurnas,$hrs_feriadas_nocturnas;
		
		$realizar_operacion = eval('return '. $operacion .';');
		$realizar_operacion*=$value_correspon;
		if ($tipo_concepto=="prima salarial" OR ($periodo_pago=="mensual" && $tipo_concepto=="bono salarial")) {
				
			$sueldo_normal+=$realizar_operacion;	
		}
		if (array_key_exists($id, $array_formulas_a_pagar)) {
			if ($asignacion_deduccion=="aporte_patronal") {
				$operacion_aportes = eval('return '. $operacion_recibo_aportes .';');
				if (isset($recibo_aporte_patronal[$id])) {
					$valor_actual_aporte = $recibo_aporte_patronal[$id]['aporte'];
					$valor_actual_deduccion = $recibo_aporte_patronal[$id]['deduccion'];
					$valor_actual_total = $recibo_aporte_patronal[$id]['total'];
					$t = $operacion_aportes+$realizar_operacion;
					$recibo_aporte_patronal[$id] = array(
						'descripcion' => $descripcion, 
						'aporte'      => $realizar_operacion+=$valor_actual_aporte, 
						'deduccion'   => $operacion_aportes+=$valor_actual_deduccion,
						'total'       => $t+=$valor_actual_total
					);
				}else{
					$recibo_aporte_patronal[$id] = array(
						'descripcion' => $descripcion, 
						'aporte'      => $realizar_operacion, 
						'deduccion'   => $operacion_aportes,
						'total'       => $operacion_aportes+$realizar_operacion				
					);
				}
				
			}
		}
	}
	

		if ($_POST['ordenar'][0]!="") {
			$ordenar = "order by ".$_POST['ordenar'][0]." ".$_POST['ordenar'][1];
		}else{
			$ordenar = " order by id asc";
		}//ordenar resultados de acuerdo a las necesidades del usuario
		
		$consulta_por_categoria="";
		if (isset($_POST['categoria'])) {
			$consulta_por_categoria.=" AND ";
			foreach ($_POST['categoria'] as $key_categoria => $value_categoria) {
			 $consulta_por_categoria .= " categoria = '".$value_categoria."' OR ";
			}
			$consulta_por_categoria = substr($consulta_por_categoria,0,-3);
		}

	//Identifica la nómina elegida
	$id_nomina = (new sql("parametros_nomina","WHERE id='".$_POST['id_nomina']."'"))->select()->fetch_assoc();
	$array_formulas_a_pagar = json_decode($id_nomina['formulas_a_pagar'],true);
	$json_divisiones = json_decode($id_nomina['divisiones'],true);

	$fecha_formato = array();
	//$fecha_inicio = "2017-09-10";
	//$fecha_cierre = "2018-02-15";

	$fecha_inicio = $_POST['fecha_inicio'];
	$fecha_cierre = $_POST['fecha_cierre'];
	$sql_fechas_sueldos = (new sql("sueldos","WHERE fecha>='".$fecha_inicio."' AND fecha<='".$fecha_cierre."' order by fecha asc","distinct(fecha)"))->select();
	    $fechas = array(0=>$fecha_inicio);
	    while ($row=$sql_fechas_sueldos->fetch_assoc()) {
	    	if ($row['fecha']!=$fecha_inicio) {
	    		array_push($fechas, $row['fecha']);	    		
	    	}    
	    }
	    array_push($fechas, $fecha_cierre);
	   	    		

	    foreach ($fechas as $key => $value) {
	       $key++;
	        if ($key<count($fechas)) {                  
	            $inicio = new DateTime($value);
	            $final = new DateTime($fechas[$key]);
	            $diferencia = $inicio->diff($final);
	            $dias = (($diferencia->m)*30)+$diferencia->d;
	            $opera_dias = $dias/30;
	            
	        	array_push($fecha_formato, array($value,$opera_dias));                    
	        }
	    }
		//print_r($fecha_formato);
	
	$consulta = (new sql("personal_upt","
		WHERE (cedula LIKE '".$_POST['busqueda']."%'
		OR nombre   LIKE '".$_POST['busqueda']."%' 
		OR apellido LIKE '".$_POST['busqueda']."%' 
		OR dedicacion LIKE '".$_POST['busqueda']."%' 
		OR cargo LIKE '".$_POST['busqueda']."%' 
		) 
		AND genero LIKE '".$_POST['genero']."%' 
		AND estatus LIKE '".$_POST['estatus']."%'
		$consulta_por_categoria
		$ordenar"))->select(); 
		
		
	$array_all = array();
	if ($consulta->num_rows>0) {
		while ($row = $consulta->fetch_assoc()) {
			

				$recibo_asignaciones=array();
				$recibo_deducciones=array();
				$recibo_aporte_patronal=array();				
				$suma_total_trabajador = 0;	
			foreach ($fecha_formato as $array_fecha_value) {

				$fecha_correspon = $array_fecha_value[0];
				$value_correspon = $array_fecha_value[1];

				$consulta_sueldo = (new sql("sueldos","WHERE fecha<='".$fecha_correspon."' AND dedicacion='".$row['dedicacion']."' AND categoria='".$row['categoria']."' AND cargo='".$row['cargo']."' order by fecha desc limit 1","salario"))->select();

		        $unidad_tributaria = (new sql("unidad_tributaria","WHERE fecha_inicio_vigencia<='".$fecha_correspon."' order by fecha_inicio_vigencia desc limit 1","valor"))->select()->fetch_assoc()['valor'];//Unidad tributaria

		        $sueldo_tabla = $consulta_sueldo->fetch_assoc()['salario'];
		        $sueldo_normal = 0; //sueldo tabla + primas salariales
		        $sueldo_integral = 0; //sueldo tabla + primas salariales + 10 caja de ahorro
				$sueldo_normal+=$sueldo_tabla;
				
				$hrs_nocturnas = $row['hrs_nocturnas'];
				$hrs_feriadas = $row['hrs_feriadas'];
				$hrs_diurnas = $row['hrs_diurnas'];
				$hrs_feriadas_nocturnas = $row['hrs_feriadas_nocturnas'];

				$consulta_formulas = (new sql("formulas","WHERE fecha<='".$fecha_correspon."' order by tipo_concepto='prima salarial' AND tipo_sueldo='sueldo basico' desc"))->select();


				$consulta_hijos = (new sql("hijos_personal","WHERE cedula_representante='".$row['cedula']."'"))->select();

		        $numero_de_hijos_personal = $consulta_hijos->num_rows;
		        //Calcular años de antiguedad
		        $fecha1_ingreso = new DateTime("".$row['fecha_ingreso']."");
				$fecha2_actual = new DateTime("".date("y-m-d")."");
				$fecha_antiguedad = $fecha1_ingreso->diff($fecha2_actual);
				$años_antiguedad = $fecha_antiguedad->y;

					while ($row_formulas = $consulta_formulas->fetch_assoc()) {

							$json_decode_condiciones = json_decode($row_formulas['condiciones'], true);
							$json_decode_operaciones = json_decode($row_formulas['operaciones'], true);			
						
							if (key($json_decode_condiciones)=="numero_hijos" && $json_decode_condiciones['numero_hijos']!="") {
									$sentencia="";
									foreach ($json_decode_condiciones['numero_hijos'] as $parametro1_hijos => $operador_parametro2) {
										
										
										$parametro2_hijos = key($operador_parametro2);
										$operador_hijos = $operador_parametro2[$parametro2_hijos];

										if ($parametro1_hijos=="edad" && !isset($_COOKIE['edad_actualizada'])) {
											actualizar_edad_hijos();
										} //Actualizar edad de los hijos del personal
										$sentencia .= "$parametro1_hijos$operador_hijos'$parametro2_hijos'";
										
										$prima_hijos = (new sql("hijos_personal","WHERE cedula_representante='".$row['cedula']."' AND $sentencia"))->select()->num_rows;
										$sentencia .= " AND ";
									}
									foreach ($json_decode_operaciones as $nombre_operacion => $valor_operacion) {
										if ($nombre_operacion=="aporte_patronal") {
											sumar($valor_operacion,$nombre_operacion,$row_formulas['descripcion'],"","",$row_formulas['id'],"",$json_decode_operaciones['deduccion'],$value_correspon);
										}																	
									}
							}else if(key($json_decode_condiciones)=="numero_hijos" && $json_decode_condiciones['numero_hijos']==""){
									$prima_hijos = $consulta_hijos->num_rows;
									foreach ($json_decode_operaciones as $nombre_operacion => $valor_operacion) {								
										if ($nombre_operacion=="aporte_patronal") {
											sumar($valor_operacion,$nombre_operacion,$row_formulas['descripcion'],"","",$row_formulas['id'],"",$json_decode_operaciones['deduccion'],$value_correspon);
										}				
									}
							}
							else if (key($json_decode_condiciones)=="cualquiera") {
								//json_operacion/{ "operacion" : "$sueldo_tabla*($años_antiguedad*0.015)" }
								foreach ($json_decode_operaciones as $nombre_operacion => $valor_operacion){
									if ($nombre_operacion=="aporte_patronal") {
										sumar($valor_operacion,$nombre_operacion,$row_formulas['descripcion'],"","",$row_formulas['id'],"",$json_decode_operaciones['deduccion'],$value_correspon);
									}
								}
							}else{
								$positivo=0;
								$negativo=0;
								foreach ($json_decode_condiciones as $campo_condiciones => $subarray_valor_operador) {	
									//{"estatus":{"EMPLEADO FIJO":"igual","ALTO NIVEL":"igual","CONTRATADO":"igual"}}
									
									if ($campo_condiciones!="numero_hijos") {
										foreach ($subarray_valor_operador as $valor_condiciones => $operador_condiciones){
											$filtro_1 = filtro($row[$campo_condiciones] , $operador_condiciones , $valor_condiciones);
											if ($filtro_1=="Verdadero") {
												break;
											}									
										}
										if ($filtro_1=="Falso") {
											$negativo++;	
										}else {
											$positivo++;
										}
		                            }else if ($campo_condiciones=="numero_hijos" && $negativo==0) {
										//{"estatus":{"ALTO NIVEL":"igual"},"numero_hijos":{"estudia":{"=":"si"}}}
										$sentencia="";
										foreach ($json_decode_condiciones['numero_hijos'] as $parametro1_hijos => $operador_parametro2) {
											
										
										$parametro2_hijos = key($operador_parametro2);
										$operador_hijos = $operador_parametro2[$parametro2_hijos];

											if ($parametro1_hijos=="edad" && !isset($_COOKIE['edad_actualizada'])) {
												actualizar_edad_hijos();
											} //Actualizar edad de los hijos del personal
											$sentencia .= "$parametro1_hijos$operador_hijos'$parametro2_hijos'";
											
											$prima_hijos = (new sql("hijos_personal","WHERE cedula_representante='".$row['cedula']."' AND $sentencia"))->select()->num_rows;
											$sentencia .= " AND ";
									    }
								    }
								}	
								if ($negativo==0) {
									foreach ($json_decode_operaciones as $nombre_operacion => $valor_operacion) {									
										if ($nombre_operacion=="aporte_patronal") {
											sumar($valor_operacion,$nombre_operacion,$row_formulas['descripcion'],"","",$row_formulas['id'],"",$json_decode_operaciones['deduccion'],$value_correspon);
										}	
									}

								}
							}		
		
					}	
					
			}	
				$array_persona = array();
				
				
				foreach ($json_divisiones as $num_division => $array_denomi_porcen) {
				//Crear una división. Ejemplo: 1era quincena
					$recibo_aportes_dividido = array();
					
					foreach ($array_denomi_porcen as $denominacion => $porcentaje) {
						if (array_key_exists($denominacion, $recibo_aporte_patronal)) {
							
							$recibo_aportes_dividido[$denominacion] = Array ( 
								'descripcion' => $recibo_aporte_patronal[$denominacion]['descripcion'],
								'aporte' 	  => $recibo_aporte_patronal[$denominacion]['aporte']*($porcentaje/100),
								'deduccion'   => $recibo_aporte_patronal[$denominacion]['deduccion']*($porcentaje/100),
								'total'       => $recibo_aporte_patronal[$denominacion]['total']*($porcentaje/100)
							);
							$arr_apors[$denominacion]=$recibo_aporte_patronal[$denominacion]['descripcion'];
						}
					}
										
					$array_persona[$num_division] = $recibo_aportes_dividido;

				//Termina de crear UNA división
				}
				
				$array_persona["Total_periodo"] =  array(
				      			"id" 	        	  =>  $row['id'],
								"nombre" 	    	  =>  $row['nombre'],
								"apellido" 	    	  =>  $row['apellido'],
								"cedula" 	    	  =>  $row['cedula'],
				      			"recibo_aporte_patronal" =>  $recibo_aporte_patronal,
				      			"fecha" 			  =>  date("d/m/Y"),
				      			"hora"  			  =>  date("H:i:s")


				      		);


		      	array_push(
		      		$array_all, 
		      		$array_persona
		       	);		
		    	
		      }//Termina iteración de una persona		
	}


	$array_divisones = array();
	foreach ($json_divisiones as $key=>$value) {
		array_push($array_divisones, $key);
	}
	array_push($array_divisones, "Total_periodo");
	
	

	$array_all['data_general'] = array('num_resultados' => $consulta->num_rows,"array_divisiones"=>$array_divisones,"arr_apors"=>$arr_apors);

	echo json_encode($array_all);
	
 ?>

