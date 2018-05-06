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
    function actualizar_edad_hijos(){
    	//$consulta_hijos_actualizar=conectar()->query("SELECT fecha_nacimiento FROM hijos_personal");
    	$consulta_hijos_actualizar=(new sql("hijos_personal","","fecha_nacimiento"))->select();
		while ($row_hijos = $consulta_hijos_actualizar->fetch_assoc()) {
			$fech = $row_hijos['fecha_nacimiento'];
			$fecha1 = new DateTime("".$fech."");
			$fecha2 = new DateTime("".date("y-m-d")."");
			$fecha = $fecha1->diff($fecha2);
			$año = $fecha->y;
			//conectar()->query("UPDATE hijos_personal SET edad='".$año."' WHERE fecha_nacimiento='".$fech."'");

			(new sql("hijos_personal","WHERE fecha_nacimiento='".$fech."'","edad='".$año."'"))->update();
		}
		setcookie("edad_actualizada", "listo", time()+86400);  /* expira en un dia */
    }
	function sumar($operacion,$asignacion_deduccion,$descripcion,$tipo_concepto,$tipo_sueldo,$id,$periodo_pago){
		global $array_formulas_a_pagar,$suma_total_trabajador,$unidad_tributaria,$sueldo_tabla,$años_antiguedad,$prima_hijos,$lunes_del_mes,$recibo_asignaciones,$recibo_deducciones,$sueldo_normal,$sueldo_integral,$base_calculo_sueldo_normal,$base_calculo_sueldo_integral;
		
		$realizar_operacion = eval('return '. $operacion .';');
		

		if (($asignacion_deduccion=="asignacion" && $tipo_concepto=="prima salarial") OR ($periodo_pago=="mensual" && $tipo_concepto=="bono salarial")) {
			$sueldo_normal+=$realizar_operacion;
			$base_calculo_sueldo_normal.="<hr>".$descripcion." = ".number_format($realizar_operacion, 2, ',', '.');	
		}
		if ($periodo_pago=="anual" && $tipo_concepto=="bono salarial" && $tipo_sueldo=="sueldo normal" && $asignacion_deduccion=="asignacion") {
			$sueldo_integral+=$realizar_operacion/12;
			$base_calculo_sueldo_integral.="<hr>".$descripcion." = ".number_format($realizar_operacion, 2, ',', '.');	
		}
		
	}
	
	$lunes_del_mes = lunes_mes();

		// if ($_POST['ordenar'][0]!="") {
		// 	$ordenar = "order by ".$_POST['ordenar'][0]." ".$_POST['ordenar'][1];
		// }else{
		// 	$ordenar = " order by id asc";
		// }//ordenar resultados de acuerdo a las necesidades del usuario
		
		// $consulta_por_categoria="";
		// if (isset($_POST['categoria'])) {
		// 	$consulta_por_categoria.=" AND ";
		// 	foreach ($_POST['categoria'] as $key_categoria => $value_categoria) {
		// 	 $consulta_por_categoria .= " categoria = '".$value_categoria."' OR ";
		// 	}
		// 	$consulta_por_categoria = substr($consulta_por_categoria,0,-3);
		// }

	$fecha_formato = array();
	// $fecha_inicio = "2018-01-01";
	// $fecha_cierre = "2018-02-01";

	$fecha_inicio = $_POST['fecha_inicio'];
	$fecha_cierre = $_POST['fecha_cierre'];
	
	    
	$consulta = (new sql("personal_upt","
	 	WHERE cedula LIKE '".$_POST['busqueda']."%'
	 	OR nombre   LIKE '".$_POST['busqueda']."%' 
	 	OR apellido LIKE '".$_POST['busqueda']."%' 
	 	OR dedicacion LIKE '".$_POST['busqueda']."%' 
	 	OR cargo LIKE '".$_POST['busqueda']."%' 
	 	"))->select(); 

	// $consulta = (new sql("personal_upt","
	// 	WHERE (cedula LIKE '".$_POST['busqueda']."%'
	// 	OR nombre   LIKE '".$_POST['busqueda']."%' 
	// 	OR apellido LIKE '".$_POST['busqueda']."%' 
	// 	OR dedicacion LIKE '".$_POST['busqueda']."%' 
	// 	OR cargo LIKE '".$_POST['busqueda']."%' 
	// 	) 
	// 	AND genero LIKE '".$_POST['genero']."%' 
	// 	AND estatus LIKE '".$_POST['estatus']."%'
	// 	$consulta_por_categoria
	// 	$ordenar"))->select(); 
		
		
	$array_all = array();
	if ($consulta->num_rows>0) {
		while ($row = $consulta->fetch_assoc()) {

				$consulta_sueldo = (new sql("sueldos","WHERE fecha<='".$fecha_cierre."' AND dedicacion='".$row['dedicacion']."' AND categoria='".$row['categoria']."' AND cargo='".$row['cargo']."' order by fecha desc limit 1","salario"))->select();

		        $unidad_tributaria = (new sql("unidad_tributaria","WHERE fecha_inicio_vigencia<='".$fecha_cierre."' order by fecha_inicio_vigencia desc limit 1","valor"))->select()->fetch_assoc()['valor'];//Unidad tributaria

		        $sueldo_tabla = $consulta_sueldo->fetch_assoc()['salario'];
		        $sueldo_normal = 0; //sueldo tabla + primas salariales
		        $sueldo_integral = 0; //sueldo tabla + primas salariales + 10 caja de ahorro
				$sueldo_normal+=$sueldo_tabla;
				
				$base_calculo_sueldo_normal = "";
				$base_calculo_sueldo_integral = "";
				
				$hrs_nocturnas = $row['hrs_nocturnas'];
				$hrs_feriadas = $row['hrs_feriadas'];
				$hrs_diurnas = $row['hrs_diurnas'];
				$hrs_feriadas_nocturnas = $row['hrs_feriadas_nocturnas'];

				$consulta_formulas = (new sql("formulas","WHERE fecha<='".$fecha_cierre."' order by tipo_concepto='prima salarial' AND tipo_sueldo='sueldo basico' desc"))->select();


				$consulta_hijos = (new sql("hijos_personal","WHERE cedula_representante='".$row['cedula']."'"))->select();

		        $numero_de_hijos_personal = $consulta_hijos->num_rows;


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
										if($nombre_operacion=="operacion"){
											sumar($valor_operacion,$row_formulas['asignacion_deduccion'],$row_formulas['descripcion'],$row_formulas['tipo_concepto'],$row_formulas['tipo_sueldo'],$row_formulas['id'],$row_formulas['periodo_pago']);
										}																	
									}
							}else if(key($json_decode_condiciones)=="numero_hijos" && $json_decode_condiciones['numero_hijos']==""){
									$prima_hijos = $consulta_hijos->num_rows;
									foreach ($json_decode_operaciones as $nombre_operacion => $valor_operacion) {								
										if($nombre_operacion=="operacion"){
											sumar($valor_operacion,$row_formulas['asignacion_deduccion'],$row_formulas['descripcion'],$row_formulas['tipo_concepto'],$row_formulas['tipo_sueldo'],$row_formulas['id'],$row_formulas['periodo_pago']);
										}				
									}
							}
							else if (key($json_decode_condiciones)=="cualquiera") {
								//json_operacion/{ "operacion" : "$sueldo_tabla*($años_antiguedad*0.015)" }
								foreach ($json_decode_operaciones as $nombre_operacion => $valor_operacion){
									if($nombre_operacion=="operacion"){
										sumar($valor_operacion,$row_formulas['asignacion_deduccion'],$row_formulas['descripcion'],$row_formulas['tipo_concepto'],$row_formulas['tipo_sueldo'],$row_formulas['id'],$row_formulas['periodo_pago']);
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
										if($nombre_operacion=="operacion"){
											sumar($valor_operacion,$row_formulas['asignacion_deduccion'],$row_formulas['descripcion'],$row_formulas['tipo_concepto'],$row_formulas['tipo_sueldo'],$row_formulas['id'],$row_formulas['periodo_pago']);
										}	
									}

								}
							}		
		
					}
									//Mas el aporte de caja de ahorro
				$sueldo_integral+=$sueldo_normal+$sueldo_tabla*0.1;	
				$integral_diario = $sueldo_integral/30;
				
					//Literal b
	//15 días de prestaciones por 90 días trabajados
	define("DIAS_TRABAJADOS",90);
	define("DIAS_DE_PRESTACIONES",15);

	//Literal c
	//30 dias por año
	define("DIAS_x_AÑO_c",30);

	//días adicionales 
	define("DIAS_ADICIONALES",2);


	define("DIAS_DEL_AÑO",360);
	define("MESES_DEL_AÑO",12);
	define("DIAS_DEL_MES",30);
	$ingreso = new DateTime($_POST['ingreso']);
	$egreso = new DateTime($_POST['egreso']);

	//Literal B
	$sueldos = json_decode($_POST['sueldos'],true);
	// $sueldos = array(
	// 	"2014-02-05"=>"8340",
	// 	"2014-10-01"=>"10300",
	// 	"2015-05-01"=>"14800",
	// 	"2015-11-01"=>"18300",
	// 	"2016-05-01"=>"21000",
	// 	"2017-05-01"=>"25000",
	// 	"2017-07-01"=>"30000",
	// 	"2017-11-01"=>"34000",
	// 	"2018-01-01"=>"40000",
	// 	"2018-04-01"=>"55000"
	// 	);
	krsort($sueldos);
	$apodos_periodo = array(
		"90"=>"I",
		"180"=>"II",
		"270"=>"III",
		"360"=>"IV"
	);
	krsort($apodos_periodo);
	$total = 0;
	$data = array("b"=>array(),"c"=>array());
   	function prestaciones($fecha,$dias_trabajados,$inter,$dias_adicionales,$tiempo){
   		global $sueldos,$total,$apodos_periodo,$data;
   		$fecha = date_format(date_create($fecha), 'Y-m-d');
   		foreach ($sueldos as $fecha_sueldo => $monto_sueldo) {
   			$fecha_sueldo = date_format(date_create($fecha_sueldo), 'Y-m-d');
			if($fecha_sueldo <= $fecha){
				$sueldo_diario = $monto_sueldo/DIAS_DEL_MES;
				$dias_tramo = $dias_trabajados/DIAS_TRABAJADOS;
				$apodo = $inter;
				$dias_prestaciones = $dias_tramo*DIAS_DE_PRESTACIONES;
				$total_dias = $dias_prestaciones+$dias_adicionales;
				$monto = $total_dias*$sueldo_diario;
				$total+=$monto;
				
				foreach ($apodos_periodo as $num => $val) {
					if ($num <= $inter) {
						$apodo = $val;
						break;
					}
				}

					array_push($data['b'], array(
						"tiempo"=>$tiempo,
						"fecha"=>$fecha,
						"apodo"=>$apodo,
						"dias_trabajados"=>$dias_trabajados,
						"sueldo"=>$monto_sueldo,
						"sueldo_diario"=>$sueldo_diario,
						"dias_prestaciones"=>round($dias_prestaciones,3),
						"dias_adicionales"=>round($dias_adicionales,3),
						"total_dias"=>round($total_dias,3),
						"monto"=>$monto,
						"total"=>$total
					));
				break;
			}
		}
   	}

				$a = intval($ingreso->format("Y"));
				$m = intval($ingreso->format("m"));
				if ($m>MESES_DEL_AÑO) {$m=MESES_DEL_AÑO;}
				$d = intval($ingreso->format("d"));
				if ($d>DIAS_DEL_MES) {$d=DIAS_DEL_MES;}
				
				$a_end = intval($egreso->format("Y"));
				$m_end = intval($egreso->format("m"));
				if ($m_end>MESES_DEL_AÑO) {$m_end=MESES_DEL_AÑO;}
				$d_end = intval($egreso->format("d"));
				if ($d_end>DIAS_DEL_MES) {$d_end=DIAS_DEL_MES;}

				$intervalos = DIAS_DEL_AÑO/DIAS_TRABAJADOS;
				$arr_cortes = array();
				$count = 0;
				for ($i=0; $i < $intervalos ; $i++) { 
					array_push($arr_cortes, $count+=DIAS_TRABAJADOS);
				}
				
				$count = 0;
				while (true) {
					$fecha_actual = new DateTime($a."-".$m."-".$d);
					$diff_actual = $ingreso->diff($fecha_actual);
					$año_trabajado = $diff_actual->format("%y");

					$tiempo = array("año"=>$año_trabajado,"meses"=>$diff_actual->format("%m"),"dias"=>$diff_actual->format("%d"));
					if ($año_trabajado>1) {
						if ($año_trabajado>16) {
							$año_trabajado=16;
						}
						$dias_adicionales = (($año_trabajado-1)*DIAS_ADICIONALES)/$intervalos;
					}else{
						$dias_adicionales=0;
					}
					
					$dia_del_año = (($m-1)*DIAS_DEL_MES)+$d;
					
					foreach ($arr_cortes as $inter) {
						if ($dia_del_año==$inter) {
							prestaciones($a."-".$m."-".$d,$count,$inter,$dias_adicionales,$tiempo);
							$count = 0;
							$select_inter = $inter;
							break;
						}
					}
					if ($d<DIAS_DEL_MES) {
						$d++;
					}else{
						$d=1;
						if ($m<MESES_DEL_AÑO) {
							$m++;
						}else {
							$m=1;
							$a++;
						}
					}
					$count++;
					if ($a==$a_end && $m==$m_end && $d==$d_end) {
						foreach ($arr_cortes as $inter) {
							if ($dia_del_año<$inter && $dia_del_año!=0) {
								prestaciones($a."-".$m."-".$d,$count,$inter,$dias_adicionales,$tiempo);
								$count = 0;
								$select_inter = $inter;
								break;
							}
						}
						break;
					}
				}
				// Literal C
				$total_meses = $ingreso->diff($egreso)->format("%m");
				$total_años = $ingreso->diff($egreso)->format("%y");
				$total_dias = $ingreso->diff($egreso)->format("%d");
				$acumu_años = 0;
				$acumu_años += $total_años;
				if ($total_meses>6) {
					$acumu_años += $total_meses/MESES_DEL_AÑO;
				}
				$sueldo_maximo = max($sueldos); 
				$data['c']['monto'] = ($acumu_años*DIAS_x_AÑO_c)*($sueldo_maximo/DIAS_DEL_MES);
				$data['c']['tiempo_trabajado'] = $total_años." años ".$total_meses." meses y ".$total_dias." días";
				$data['c']['años'] = $acumu_años;
				$data['c']['dias_x_año'] = DIAS_x_AÑO_c;
				$data['c']['sueldo_devengado'] = $sueldo_maximo;
				$data['c']['sueldo_devengado_x_dia'] = $sueldo_maximo/DIAS_DEL_MES;
				$data['c']['formula_utilizada'] = "( AÑOS_TRABAJADOS * ".DIAS_x_AÑO_c." ) * SUELDO_DIARIO ";

				echo json_encode($data);
		    	
		      }//Termina iteración de una persona		
		      
	}

	
 ?>

