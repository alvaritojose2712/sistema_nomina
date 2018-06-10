<?php 

	include '../conexion_bd.php';

	function filtro($parametro1,$operador,$parametro2){
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
	function lunes_mes(){
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
		global $array_formulas_a_pagar,$suma_total_trabajador,$unidad_tributaria,$sueldo_tabla,$años_antiguedad,$prima_hijos,$lunes_del_mes,$recibo_asignaciones,$recibo_deducciones,$sueldo_normal,$sueldo_integral,$suma_primas,$suma_bonos_anuales,$primas_detalles,$bonos_anuales_detalles;
		
		$realizar_operacion = eval('return '. $operacion .';');
		

		if (($asignacion_deduccion=="asignacion" && $tipo_concepto=="prima salarial") OR ($periodo_pago=="mensual" && $tipo_concepto=="bono salarial")) {
			$suma_primas+=$realizar_operacion;
			$sueldo_normal+=$realizar_operacion;
			$primas_detalles[$id] = array("descripcion"=>$descripcion,"monto"=>$realizar_operacion,"sueldo_normal"=>$sueldo_normal,"años_antiguedad"=>$años_antiguedad);

		}
		if ($periodo_pago=="anual" && $tipo_concepto=="bono salarial" && $tipo_sueldo=="sueldo normal" && $asignacion_deduccion=="asignacion") {
			$suma_bonos_anuales+=$realizar_operacion/12;
			$bonos_anuales_detalles[$id] = array("descripcion"=>$descripcion,"monto"=>$realizar_operacion);

		}	
	}
   	function prestaciones($fecha,$dias_trabajados,$inter,$dias_adicionales,$tiempo){
   		global $sueldos,$total,$apodos_periodo,$data;
   		$fecha = date_format(date_create($fecha), 'Y-m-d');
   		$val = false;
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
						"fecha"=>date_format(date_create($fecha), 'd-m-Y'),
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
				$val = true; 
				break;
			}
		}
		if (!$val) {
			array_push($data['b'], array(
				"tiempo"=>"0",
				"fecha"=>"0",
				"apodo"=>"0",
				"dias_trabajados"=>"0",
				"sueldo"=>"0",
				"sueldo_diario"=>"0",
				"dias_prestaciones"=>"0",
				"dias_adicionales"=>"0",
				"total_dias"=>"0",
				"monto"=>"0",
				"total"=>"0"
			));
		}
   	}

	$consulta = (new sql("personal_upt","
 	WHERE cedula LIKE '".$_POST['busqueda']."%'
 	OR nombre   LIKE '".$_POST['busqueda']."%' 
 	OR apellido LIKE '".$_POST['busqueda']."%' 
 	"))->select(); 

	if ($consulta->num_rows>0) {
		$lunes_del_mes = lunes_mes();

		$inicio_periodo = new DateTime($_POST['fecha_inicio']);
		$cierre_periodo = new DateTime($_POST['fecha_cierre']);
		if ($_POST['fecha_inicio']=="" || $_POST['fecha_cierre']=="" || ($inicio_periodo>=$cierre_periodo)) {
			echo "Fechas Inválidas!!";
			exit;
		}
		
		$tab_prestaciones = (new sql("prestaciones_sociales","WHERE id=1"))->select()->fetch_assoc();
		//Literal b
		//15 días de prestaciones por 90 días trabajados
		define("DIAS_TRABAJADOS",$tab_prestaciones['DIAS_TRABAJADOS_literal_b']);
		define("DIAS_DE_PRESTACIONES",$tab_prestaciones['DIAS_DE_PRESTACIONES_literal_b']);

		//Literal c
		//30 dias por año de antiguedad
		define("DIAS_x_AÑO_literal_c",$tab_prestaciones['DIAS_x_AÑO_literal_c']);
		define("MAX_DIAS_ADICIONALES_literal_b",$tab_prestaciones['MAX_DIAS_ADICIONALES_literal_b']);


		//días adicionales de prestaciones
		define("DIAS_ADICIONALES",$tab_prestaciones['DIAS_ADICIONALES_literal_b']);

		//Información general
		define("DIAS_DEL_AÑO",360);
		define("MESES_DEL_AÑO",12);
		define("DIAS_DEL_MES",30);

		$apodos_periodo = array(
			"90"=>"I",
			"180"=>"II",
			"270"=>"III",
			"360"=>"IV"
		);
		//Ordena los apodos de mayor a menor
		krsort($apodos_periodo);
		$array_all = array();


		while ($row = $consulta->fetch_assoc()) {

				$consulta_sueldo = (new sql("sueldos","WHERE dedicacion='".$row['dedicacion']."' AND categoria='".$row['categoria']."' AND cargo='".$row['cargo']."'"))->select();


		        $sueldo_tabla_ultimo = (new sql("sueldos","WHERE fecha<='".date("Y-m-d")."' AND dedicacion='".$row['dedicacion']."' AND categoria='".$row['categoria']."' AND cargo='".$row['cargo']."'"))->select()->fetch_assoc()['salario'];
				
				$hrs_nocturnas = $row['hrs_nocturnas'];
				$hrs_feriadas = $row['hrs_feriadas'];
				$hrs_diurnas = $row['hrs_diurnas'];
				$hrs_feriadas_nocturnas = $row['hrs_feriadas_nocturnas'];

				$fecha_ingreso_trabajador = new DateTime($row['fecha_ingreso']);

				$consulta_hijos = (new sql("hijos_personal","WHERE cedula_representante='".$row['cedula']."'"))->select();

		        $numero_de_hijos_personal = $consulta_hijos->num_rows;
	
				//Sueldos para las prestaciones trimestrales			
				$sueldos = array();
				$sueldos_details = array();
				while ($row_sueldos = $consulta_sueldo->fetch_assoc()) {
					$sueldo_tabla = $row_sueldos['salario'];
		        	$fecha = $row_sueldos['fecha'];

					$sueldo_normal = 0; //sueldo tabla + primas salariales 
					$sueldo_normal+=$sueldo_tabla;
		       		
		       		$sueldo_integral = 0; //sueldo tabla + primas salariales + 10 caja de ahorro + Bono vacacional + Bono de fin de año
		       		$suma_primas = 0;
		        	$suma_bonos_anuales = 0;
		        	//Detalles
		        	$primas_detalles = array();
		        	$bonos_anuales_detalles = array();

		        	$años_antiguedad = $fecha_ingreso_trabajador->diff((new DateTime($fecha)))->format("%y");

		        	$unidad_tributaria = (new sql("unidad_tributaria","WHERE fecha_inicio_vigencia<='".$fecha."' order by fecha_inicio_vigencia desc limit 1","valor"))->select()->fetch_assoc()['valor'];//Unidad tributaria
		        	$consulta_formulas = (new sql("formulas","WHERE fecha<='".$fecha."' order by tipo_concepto='prima salarial' AND tipo_sueldo='sueldo basico' desc"))->select();

					while ($row_formulas = $consulta_formulas->fetch_assoc()){

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
					
					/////////////////////////////////////
					$sueldos[$row_sueldos['fecha']] = $sueldo_tabla+$suma_primas+$suma_bonos_anuales+($sueldo_tabla*0.1);

					array_push($sueldos_details, array(
						'sueldo_tabla_fecha' => $row_sueldos['fecha'], 
						'sueldo_tabla' => $sueldo_tabla, 
						'primas_salariales' => $primas_detalles, 
						'bonos_anuales' => $bonos_anuales_detalles, 
						'aporte_caja_ahorro' => ($sueldo_tabla*0.1),
						'sueldo_integral' => $sueldos[$row_sueldos['fecha']]
						));
					
					$sueldo_integral = $sueldos[$row_sueldos['fecha']];
				}
				//Ordena los sueldos de mayor a menor
				krsort($sueldos);
				
				$total = 0;
				$data = array("b"=>array(),"c"=>array());
				
				//Literal B
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
				if ($_POST['show']=="LIT_A_B") {
					if ($inicio_periodo>=$fecha_ingreso_trabajador || $cierre_periodo>$fecha_ingreso_trabajador) {
							if ($fecha_ingreso_trabajador>$inicio_periodo) {
								$inicio_periodo = $fecha_ingreso_trabajador;
							}
							$a = intval($inicio_periodo->format("Y"));
							$m = intval($inicio_periodo->format("m"));
							if ($m>MESES_DEL_AÑO) {$m=MESES_DEL_AÑO;}
							$d = intval($inicio_periodo->format("d"));
							if ($d>DIAS_DEL_MES) {$d=DIAS_DEL_MES;}
							///////////////////////////////////////////////////
							$a_end = intval($cierre_periodo->format("Y"));
							$m_end = intval($cierre_periodo->format("m"));
							if ($m_end>MESES_DEL_AÑO) {$m_end=MESES_DEL_AÑO;}
							$d_end = intval($cierre_periodo->format("d"));
							if ($d_end>DIAS_DEL_MES) {$d_end=DIAS_DEL_MES;}

							$intervalos_del_año = DIAS_DEL_AÑO/DIAS_TRABAJADOS;
							
							$arr_cortes = array(); //array(90,180,270,360)
							$contador_intervalos = 0;
							for ($i=0; $i < $intervalos_del_año ; $i++) { 
								array_push($arr_cortes, $contador_intervalos+=DIAS_TRABAJADOS);
							}
							
							$dias_trabajados = 1;
							while (true) {
								//Frena el contador de fechas Si llega a la Fecha de Cierre =>
								$fecha_actual = new DateTime($a."-".$m."-".$d);

								if ($fecha_actual==(new DateTime($a_end."-".$m_end."-".$d_end))) {
									foreach ($arr_cortes as $inter) {
										if ($dia_del_año<=$inter && $dia_del_año!=0) {
											prestaciones($d."-".$m."-".$a, $dias_trabajados, $inter, $dias_adicionales, $tiempo);
											$dias_trabajados = 0;
											break;
										}
									}
									break;
								}

								$dia_del_año = (($m-1)*DIAS_DEL_MES)+$d;
								$diff_actual = $fecha_ingreso_trabajador->diff($fecha_actual);
								$años_trabajados = $diff_actual->format("%y");

								$tiempo = array(
									"año"  => $años_trabajados,
									"meses"=> $diff_actual->format("%m"),
									"dias" => $diff_actual->format("%d")
								);

								//Calcular días Adicionales
								if ($años_trabajados>1){
									$dias_adicionales = (($años_trabajados-1)*DIAS_ADICIONALES)/$intervalos_del_año;
									if ($dias_adicionales>MAX_DIAS_ADICIONALES_literal_b) {
										$dias_adicionales = MAX_DIAS_ADICIONALES_literal_b;
									}
								}else{
									$dias_adicionales=0;
								}
								
								foreach ($arr_cortes as $inter) {
									if ($dia_del_año==$inter) {
										prestaciones($d."-".$m."-".$a, $dias_trabajados, $inter, $dias_adicionales, $tiempo);
										$dias_trabajados = 0;
										break;
									}
								}
								
								//Contador de fechas
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
								$dias_trabajados++;
							}
					}else{
						prestaciones("1999-01-01", "0", "0", "0", "0");
					}
							

				}else if ($_POST['show']=="LIT_C") {// Literal C

					$total_meses = $fecha_ingreso_trabajador->diff($cierre_periodo)->format("%m");
					$total_años = $fecha_ingreso_trabajador->diff($cierre_periodo)->format("%y");
					$total_dias = $fecha_ingreso_trabajador->diff($cierre_periodo)->format("%d");
					$acumu_años = 0;
					$acumu_años += $total_años;
					if ($total_meses>6) {
						$acumu_años += $total_meses/MESES_DEL_AÑO;
					}
					$sueldo_maximo = max($sueldos); 
					if ($fecha_ingreso_trabajador<$cierre_periodo) {
						$sueldo_maximo_diario = $sueldo_maximo/DIAS_DEL_MES;
						$data['c']['monto'] = ($acumu_años*DIAS_x_AÑO_literal_c)*($sueldo_maximo_diario);
						$data['c']['tiempo_trabajado'] = $total_años." años ".$total_meses." meses y ".$total_dias." días";
						$data['c']['años'] = $acumu_años;
						$data['c']['dias_x_año'] = DIAS_x_AÑO_literal_c;
						$data['c']['sueldo_devengado'] = $sueldo_maximo;
						$data['c']['sueldo_devengado_x_dia'] = $sueldo_maximo_diario;
						$data['c']['formula_utilizada'] = "( AÑOS_TRABAJADOS * ".DIAS_x_AÑO_literal_c." ) * SUELDO_DIARIO ";
						$data['c']['dias_totales'] = $acumu_años*DIAS_x_AÑO_literal_c;

					}else{
						$data['c']['monto'] = 0;
						$data['c']['tiempo_trabajado'] = 0;
						$data['c']['años'] = 0;
						$data['c']['dias_x_año'] = 0;
						$data['c']['sueldo_devengado'] = 0;
						$data['c']['sueldo_devengado_x_dia'] = 0;
						$data['c']['formula_utilizada'] = 0;
						$data['c']['dias_totales'] = 0;
					}
					
				}
				
			$data["sueldos"] = $sueldos_details;
			$array_all[$row['cedula']] = array(
				"id" 	        	  =>  $row['id'],
      			"estatus" 	    	  =>  $row['estatus'],
      			"estado" 	    	  =>  $row['estado'],
				"nombre" 	    	  =>  $row['nombre'],
				"apellido" 	    	  =>  $row['apellido'],
				"cedula" 	    	  =>  $row['cedula'],
				"genero" 	    	  =>  $row['genero'],
				"categoria"     	  =>  $row['categoria'],
				"cargo" 	    	  =>  $row['cargo'],
				"dedicacion"    	  =>  $row['dedicacion'],
				"cuenta_bancaria"     =>  $row['cuenta_bancaria'],
				"telefono_1"		  =>  $row['telefono_1'],
				"telefono_2"		  =>  $row['telefono_2'],
				"correo"		 	  =>  $row['correo'],
				"fecha_ingreso"		  =>  $row['fecha_ingreso'],
				"grado_instruccion"	  =>  $row['grado_instruccion'],
				"caja_ahorro"	      =>  $row['caja_ahorro'],
				"antiguedad_otros_ieu"=>  $row['antiguedad_otros_ieu'],
				'data_prestaciones'   =>  $data
			); 
			
		    	
		}//Termina iteración de una persona		
		echo json_encode($array_all);     
	}else{
		echo "No se encontraron resultados!";
	}

	
 ?>

