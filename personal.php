<?php 
	include 'conexion_bd.php';

	function filtro($parametro1,$operador,$parametro2)
	{
		if ($operador=="cualquiera" || $parametro1=="cualquiera" || $parametro2=="cualquiera") {
			return true;
		}
		else if ($operador == "igual") {
			if ($parametro1==$parametro2) {
				return true;
			}else{
				return false;
			}
		}
		else if ($operador == "diferente") {
			if ($parametro1!=$parametro2) {
				return true;
			}else{
				return false;
			}
		}
		else if ($operador == "menor") {
			if ($parametro1<$parametro2) {
				return true;
			}else{
				return false;
			}
		}
		else if ($operador == "mayor") {
			if ($parametro1>$parametro2) {
				return true;
			}else{
				return false;
			}
		}
		else if ($operador == "menor o igual") {
			if ($parametro1<=$parametro2) {
				return true;
			}else{
				return false;
			}
		}
		else if ($operador == "mayor o igual") {
			if ($parametro1>=$parametro2) {
				return true;
			}else{
				return false;
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
    	$consulta_hijos_actualizar=(new sql("hijos_personal","","fecha_nacimiento"))->select();
		while ($row_hijos = $consulta_hijos_actualizar->fetch_assoc()) {
			$fech = $row_hijos['fecha_nacimiento'];
			$fecha1 = new DateTime("".$fech."");
			$fecha2 = new DateTime("".date("y-m-d")."");
			$fecha = $fecha1->diff($fecha2);
			$año = $fecha->y;
			(new sql("hijos_personal","WHERE fecha_nacimiento='".$fech."'","edad='".$año."'"))->update();
		}
		setcookie("edad_actualizada", "listo", time()+86400);  /* expira en un dia */
    }
	function sumar($operacion,$asignacion_deduccion,$descripcion,$tipo_concepto,$tipo_sueldo,$id,$periodo_pago,$value_correspon){
		global $array_formulas_a_pagar,$suma_total_trabajador,$unidad_tributaria,$sueldo_tabla,$años_antiguedad,$prima_hijos,$lunes_del_mes,$recibo_asignaciones,$recibo_deducciones,$sueldo_normal,$sueldo_integral,$hrs_nocturnas,$hrs_feriadas,$hrs_diurnas,$hrs_feriadas_nocturnas,$fecha_formato;
		
		
		$realizar_operacion = eval('return '. $operacion .';');
		
		//Sueldo normal
		if (($asignacion_deduccion=="asignacion" && $tipo_concepto=="prima salarial") OR ($periodo_pago=="mensual" && $tipo_concepto=="bono salarial")) {
			$sueldo_normal+=$realizar_operacion;	
		}
		//Sueldo integral
		if ($periodo_pago=="anual" && $tipo_concepto=="bono salarial" && $tipo_sueldo=="sueldo normal" && $asignacion_deduccion=="asignacion") {
			$sueldo_integral+=$realizar_operacion/12;
		}
		//Retroactivo
		if (isset($fecha_formato[4001]) && $value_correspon<0) {
			$realizar_operacion*=($value_correspon*(-1));
			//Recibos
			if (array_key_exists($id, $array_formulas_a_pagar)) {
				if ($realizar_operacion!=0) {
					if ($asignacion_deduccion=="asignacion") {
						$suma_total_trabajador -= $realizar_operacion;
						if (!isset($recibo_asignaciones[$id])) {
							$recibo_asignaciones[$id] = array($descripcion=>$realizar_operacion);
						}else{
							$valor_actual = $recibo_asignaciones[$id][$descripcion];
							$recibo_asignaciones[$id] = array($descripcion=>$realizar_operacion-=$valor_actual);
						}
					}else if($asignacion_deduccion=="deduccion"){
						$suma_total_trabajador -= $realizar_operacion;
						if (!isset($recibo_deducciones[$id])) {
							$recibo_deducciones[$id] = array($descripcion=>$realizar_operacion);
						}else{
							$valor_actual = $recibo_deducciones[$id][$descripcion];
							$recibo_deducciones[$id] = array($descripcion=>$realizar_operacion-=$valor_actual);
						}
					}
				}
			}
		}
		//Procesar recibo normal
		else{
			$realizar_operacion*=$value_correspon;
			//Recibos
			if (array_key_exists($id, $array_formulas_a_pagar)) {
				if ($realizar_operacion!=0) {
					if ($asignacion_deduccion=="asignacion") {
						$suma_total_trabajador += $realizar_operacion;
						if (!isset($recibo_asignaciones[$id])) {
							$recibo_asignaciones[$id] = array($descripcion=>$realizar_operacion);
						}else{
							$valor_actual = $recibo_asignaciones[$id][$descripcion];
							$recibo_asignaciones[$id] = array($descripcion=>$realizar_operacion+=$valor_actual);
						}
					}else if($asignacion_deduccion=="deduccion"){
						$suma_total_trabajador -= $realizar_operacion;
						if (!isset($recibo_deducciones[$id])) {
							$recibo_deducciones[$id] = array($descripcion=>$realizar_operacion);
						}else{
							$valor_actual = $recibo_deducciones[$id][$descripcion];
							$recibo_deducciones[$id] = array($descripcion=>$realizar_operacion+=$valor_actual);
						}
					}
				}
			}
		}
		
	}
	function partida($operacion,$value_correspon,$num_partida,$nom_partida,$levels){
		global $partidas,$resultados_partida,$unidad_tributaria,$sueldo_tabla,$años_antiguedad,$prima_hijos,$lunes_del_mes,$sueldo_normal,$sueldo_integral,$hrs_nocturnas,$hrs_feriadas,$hrs_diurnas,$hrs_feriadas_nocturnas;
		
		$realizar_operacion = eval('return '. $operacion .';')*$value_correspon;

		$level = count($levels);
		if ($level>=5) {
			$resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['hijos'][$levels[2][0]]['hijos'][$levels[3][0]]['hijos'][$levels[4][0]]['nombre'] = $levels[4][1];
			if (isset($resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['hijos'][$levels[2][0]]['hijos'][$levels[3][0]]['hijos'][$levels[4][0]]['monto'])) {
				$resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['hijos'][$levels[2][0]]['hijos'][$levels[3][0]]['hijos'][$levels[4][0]]['monto'] += $realizar_operacion;
			}else{
				$resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['hijos'][$levels[2][0]]['hijos'][$levels[3][0]]['hijos'][$levels[4][0]]['monto'] = $realizar_operacion;
			}
			
		}
		if ($level>=4) {
			$resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['hijos'][$levels[2][0]]['hijos'][$levels[3][0]]['nombre'] = $levels[3][1];

			if (isset($resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['hijos'][$levels[2][0]]['hijos'][$levels[3][0]]['monto'])) {
				$resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['hijos'][$levels[2][0]]['hijos'][$levels[3][0]]['monto'] += $realizar_operacion;
			}else{
				$resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['hijos'][$levels[2][0]]['hijos'][$levels[3][0]]['monto'] = $realizar_operacion;
			}
		}
		if ($level>=3) {
			$resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['hijos'][$levels[2][0]]['nombre'] = $levels[2][1];
			
			if (isset($resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['hijos'][$levels[2][0]]['monto'])) {
				$resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['hijos'][$levels[2][0]]['monto'] += $realizar_operacion;
			}else{
				$resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['hijos'][$levels[2][0]]['monto'] = $realizar_operacion;
			}
		}
		if ($level>=2) {
			$resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['nombre'] = $levels[1][1];

			if (isset($resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['monto'])) {
				$resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['monto'] += $realizar_operacion;
			}else{
				$resultados_partida[$levels[0][0]]['hijos'][$levels[1][0]]['monto'] = $realizar_operacion;
			}
		}
		if ($level>=1) {
			$resultados_partida[$levels[0][0]]['nombre'] = $levels[0][1];

			if (isset($resultados_partida[$levels[0][0]]['monto'])) {
				$resultados_partida[$levels[0][0]]['monto'] += $realizar_operacion;
			}else{
				$resultados_partida[$levels[0][0]]['monto'] = $realizar_operacion;
			}
		}
		
	}
	function is_valid($arr,$row)
	{
		$cumple = true;
		foreach ($arr as $entidad => $arr_val_entidad) {
			$err = 0;
			foreach ($arr_val_entidad as $val_entidad => $val_empty) {
				if ($row[$entidad]==$val_entidad) {
					break;
				}else{
					$err++;
				}
			}
			if ($err==count($arr_val_entidad)) {
				$cumple = false;
				break;
			}
		}
		return $cumple;
	}
	//Leer partidas
		$fp = fopen("partida_presupuestaria/partidas.txt","r");
		$partida_txt = "";
		while(!feof($fp)) {
			$linea = fgets($fp);
			$partida_txt.=$linea;
		}
		fclose($fp);
		

	$conceptos = array();

	$lunes_del_mes = lunes_mes();

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
		$consulta_por_estatus="";
		if (isset($_POST['estatus'])) {
			$consulta_por_estatus.=" AND ";
			foreach ($_POST['estatus'] as $key_estatus => $value_estatus) {
			 $consulta_por_estatus .= " estatus = '".$value_estatus."' OR ";
			}
			$consulta_por_estatus = substr($consulta_por_estatus,0,-3);
		}
	//Identifica la nómina elegida
	$id_nomina = (new sql("parametros_nomina","WHERE id='".$_POST['id_nomina']."'"))->select()->fetch_assoc();
	$array_formulas_a_pagar = json_decode($id_nomina['formulas_a_pagar'],true);
	$json_divisiones = json_decode($id_nomina['divisiones'],true);
	$json_filtros = json_decode($id_nomina['filtros'],true);
	$filtros = ""; 
	if (count($filtros)>0) {

		foreach ($json_filtros as $campo => $sub_array) {
			$filtros.=" AND ";
			foreach ($sub_array as $valor => $vacio) {
				$filtros.=" $campo LIKE '$valor' OR ";
			}
			$filtros = substr($filtros,0,-3);
		}
	}

	$recibo_casos_especiales = array();
	$casos_especiales_array = json_decode($id_nomina['incl_excl'],true);
	$caso = "";
	foreach ($casos_especiales_array as $clave_caso => $valor_caso) {
		if ($clave_caso=="incluir" && count($valor_caso)>0) {
			$caso="AND (";
			foreach ($valor_caso as $cedula_incluir => $valor_vacio) {
				$caso .= "cedula = '$cedula_incluir' OR ";
			}
			$caso = substr($caso,0,-3);
			$caso .= ")";
		}else if($clave_caso=="excluir"){
			$caso="AND (";
			foreach ($valor_caso as $cedula_incluir => $valor_vacio) {
				$caso .= "cedula != '$cedula_incluir' AND ";
			}
			$caso = substr($caso,0,-4);
			$caso .= ")";
		}
	}
	$opera_especiales_array = json_decode('{"operaciones":'.$id_nomina['opera_espec'].'}',true);
	

	$fecha_formato = array();
	// $fecha_inicio = "2017-05-01";
	// $fecha_cierre = "2018-02-01";


	//Crear período
	$fecha_inicio = $_POST['fecha_inicio'];
	$fecha_cierre = $_POST['fecha_cierre'];

	if ($_POST['fecha_inicio']=="" || $_POST['fecha_cierre']=="" || ( new DateTime($_POST['fecha_inicio'])>= new DateTime($_POST['fecha_cierre']))) {
		echo "Fechas Inválidas!!";
		exit;
	}
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
	            $di = ($diferencia->d<28)?$diferencia->d:30;
	            $dias = (($diferencia->m)*30)+$di;
	            $opera_dias = round($dias/30,1);
	        	array_push($fecha_formato, array($value,$opera_dias));  
	        }
	    }
		//Pago de retroactivo
		$retroactivo = $_POST['confirm_retroactivo'];
		if ($retroactivo=="true") {
			$inicio = new DateTime($fecha_inicio);
	            $final = new DateTime($fecha_cierre);
	            $diferencia = $inicio->diff($final);
	            $di = ($diferencia->d<28)?$diferencia->d:30;
	            $dias = (($diferencia->m)*30)+$di;
	            $opera_dias = (round($dias/30,1))*(-1);
	            $fecha_formato[4001] = array($_POST['fecha_retroactivo'],$opera_dias);
		}
		//print_r($fecha_formato);

	//Partida Presupuestaria

	$partidas = json_decode($partida_txt,true);
	$resultados_partida = array();
	
	$consulta = (new sql("personal_upt","
		WHERE (cedula LIKE '".$_POST['busqueda']."%'
		OR nombre   LIKE '".$_POST['busqueda']."%' 
		OR apellido LIKE '".$_POST['busqueda']."%' 
		OR dedicacion LIKE '".$_POST['busqueda']."%' 
		OR cargo LIKE '".$_POST['busqueda']."%' 
		) $caso
		  $filtros
		"))->select(); 
		
	$array_all = array();
	if ($consulta->num_rows>0) {
		while ($row = $consulta->fetch_assoc()) {
			
				$recibo_asignaciones=array();
				$recibo_deducciones=array();
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
								if($nombre_operacion=="operacion"){
									sumar($valor_operacion,$row_formulas['asignacion_deduccion'],$row_formulas['descripcion'],$row_formulas['tipo_concepto'],$row_formulas['tipo_sueldo'],$row_formulas['id'],$row_formulas['periodo_pago'],$value_correspon);
								}																	
							}
					}else if(key($json_decode_condiciones)=="numero_hijos" && $json_decode_condiciones['numero_hijos']==""){
						$prima_hijos = $consulta_hijos->num_rows;
						foreach ($json_decode_operaciones as $nombre_operacion => $valor_operacion) {								
							if($nombre_operacion=="operacion"){
								sumar($valor_operacion,$row_formulas['asignacion_deduccion'],$row_formulas['descripcion'],$row_formulas['tipo_concepto'],$row_formulas['tipo_sueldo'],$row_formulas['id'],$row_formulas['periodo_pago'],$value_correspon);
							}				
						}
					}
					else if (key($json_decode_condiciones)=="cualquiera") {
						//json_operacion/{ "operacion" : "$sueldo_tabla*($años_antiguedad*0.015)" }
						foreach ($json_decode_operaciones as $nombre_operacion => $valor_operacion){
							if($nombre_operacion=="operacion"){
								sumar($valor_operacion,$row_formulas['asignacion_deduccion'],$row_formulas['descripcion'],$row_formulas['tipo_concepto'],$row_formulas['tipo_sueldo'],$row_formulas['id'],$row_formulas['periodo_pago'],$value_correspon);
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
									if ($filtro_1) {
										break;
									}									
								}
								if ($filtro_1) {
									$positivo++;	
								}else {
									$negativo++;
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
									sumar($valor_operacion,$row_formulas['asignacion_deduccion'],$row_formulas['descripcion'],$row_formulas['tipo_concepto'],$row_formulas['tipo_sueldo'],$row_formulas['id'],$row_formulas['periodo_pago'],$value_correspon);
								}	
							}
						}
					}	


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////7
					foreach ($partidas as $num_global => $arr_global) {
						if (is_valid($arr_global['condiciones'],$row)) {
							if (count($arr_global['conceptos'])>0) {
								if (array_key_exists($row_formulas['id'], $arr_global['conceptos'])) {
									foreach ($json_decode_operaciones as $nombre_operacion => $valor_operacion) {
										if($nombre_operacion=="operacion"){
											partida($valor_operacion,$value_correspon,$num_global,$arr_global['nombre'],array(array($num_global,$arr_global['nombre'])));
										}																	
									}
								}
							}else{
								foreach ($arr_global['hijos'] as $num_partida => $arr_partida) {
									if (is_valid($arr_partida['condiciones'],$row)) {
										if (count($arr_partida['conceptos'])>0) {
											if (array_key_exists($row_formulas['id'], $arr_partida['conceptos'])) {
												foreach ($json_decode_operaciones as $nombre_operacion => $valor_operacion) {
													if($nombre_operacion=="operacion"){
														partida($valor_operacion,$value_correspon,$num_partida,$arr_partida['nombre'],array(array($num_global,$arr_global['nombre']),array($num_partida,$arr_partida['nombre'])));
													}																	
												}
											}
										}else{
											foreach ($arr_partida['hijos'] as $num_generico => $arr_generico) {
												if (is_valid($arr_generico['condiciones'],$row)) {
													if (count($arr_generico['conceptos'])>0) {
														if (array_key_exists($row_formulas['id'], $arr_generico['conceptos'])) {
															foreach ($json_decode_operaciones as $nombre_operacion => $valor_operacion) {
																if($nombre_operacion=="operacion"){
																	partida($valor_operacion,$value_correspon,$num_generico,$arr_generico['nombre'],array(array($num_global,$arr_global['nombre']),array($num_partida,$arr_partida['nombre']),array($num_generico,$arr_generico['nombre'])));
																}																	
															}
														}
													}else{
														foreach ($arr_generico['hijos'] as $num_especifico => $arr_especifico) {
															if (is_valid($arr_especifico['condiciones'],$row)) {
																if (count($arr_especifico['conceptos'])>0) {
																	if (array_key_exists($row_formulas['id'], $arr_especifico['conceptos'])) {
																		foreach ($json_decode_operaciones as $nombre_operacion => $valor_operacion) {
																			if($nombre_operacion=="operacion"){
																				partida($valor_operacion,$value_correspon,$num_especifico,$arr_especifico['nombre'],array(array($num_global,$arr_global['nombre']),array($num_partida,$arr_partida['nombre']),array($num_generico,$arr_generico['nombre']),array($num_especifico,$arr_especifico['nombre'])));
																			}																	
																		}
																	}
																}else{
																	foreach ($arr_especifico['hijos'] as $num_sub_especifico => $arr_sub_especifico) {
																		if (is_valid($arr_sub_especifico['condiciones'],$row)) {
																			if (count($arr_sub_especifico['conceptos'])>0) {
																				if (array_key_exists($row_formulas['id'], $arr_sub_especifico['conceptos'])) {
																					foreach ($json_decode_operaciones as $nombre_operacion => $valor_operacion) {
																						if($nombre_operacion=="operacion"){
																							partida($valor_operacion,$value_correspon,$num_sub_especifico,$arr_sub_especifico['nombre'],array(array($num_global,$arr_global['nombre']),array($num_partida,$arr_partida['nombre']),array($num_generico,$arr_generico['nombre']),array($num_especifico,$arr_especifico['nombre']),array($num_sub_especifico,$arr_sub_especifico['nombre'])));
																						}																	
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////7



				}	
				$sueldo_integral+=$sueldo_normal+$sueldo_tabla*0.1;	
			}	
				$array_persona = array();
				//Crear divisiones			
				foreach ($json_divisiones as $num_division => $array_denomi_porcen) {
					//Crear una división. Ejemplo: 1era quincena
					$suma_total_trabajador_dividido = 0;

					$recibo_asignaciones_dividido = array();
					$recibo_deducciones_dividido = array();
					foreach ($array_denomi_porcen as $denominacion => $porcentaje) {
						if (array_key_exists($denominacion, $recibo_asignaciones)) {
							
							foreach ($recibo_asignaciones[$denominacion] as $descr => $valor_asignacion) {
								
								$recibo_asignaciones_dividido[$denominacion] = array($descr => $valor_asignacion*($porcentaje/100));
								
								$suma_total_trabajador_dividido+=$valor_asignacion*($porcentaje/100);
							}

						}else if(array_key_exists($denominacion, $recibo_deducciones)){
							
							foreach ($recibo_deducciones[$denominacion] as $descr => $valor_deduccion) {
								
								$recibo_deducciones_dividido[$denominacion] = array($descr => $valor_deduccion*($porcentaje/100));
								$suma_total_trabajador_dividido-=$valor_deduccion*($porcentaje/100);
							}	
						}
					}
					$division = array(
				      			"total"         	  =>  $suma_total_trabajador_dividido,
				      			"recibo_asignaciones" =>  $recibo_asignaciones_dividido,
				      			"recibo_deducciones"  =>  $recibo_deducciones_dividido
				      		);					
					$array_persona[$num_division] = $division;
				}
				$array_persona["Total_periodo"] =  array(
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
								"numero_hijos"        =>  $numero_de_hijos_personal,
								"telefono_1"		  =>  $row['telefono_1'],
								"telefono_2"		  =>  $row['telefono_2'],
								"correo"		 	  =>  $row['correo'],
								"fecha_ingreso"		  =>  $row['fecha_ingreso'],
								"grado_instruccion"	  =>  $row['grado_instruccion'],
								"caja_ahorro"	      =>  $row['caja_ahorro'],
								"antiguedad_otros_ieu"=>  $row['antiguedad_otros_ieu'],
								"años_servicio" 	  =>  ($años_antiguedad+$row['antiguedad_otros_ieu']),
								"salario"       	  =>  $sueldo_tabla,
								"salario_normal"      =>  $sueldo_normal,
								"salario_integral"    =>  $sueldo_integral,
				      			"total"         	  =>  $suma_total_trabajador,
				      			"recibo_asignaciones" =>  $recibo_asignaciones,
				      			"recibo_deducciones"  =>  $recibo_deducciones,
				      			"fecha" 			  =>  date("d/m/Y"),
				      			"hora"  			  =>  date("H:i:s")
				      		);
				//Operaciones especiales
				if (isset($opera_especiales_array['operaciones'][$row['cedula']])) {
					foreach ($opera_especiales_array['operaciones'][$row['cedula']] as $clave_numerica => $asig_o_deduc_y_divi) {
						
						if (isset($asig_o_deduc_y_divi['divisiones'])) {
							foreach ($asig_o_deduc_y_divi['divisiones'] as $name_divi => $porcen) {
								
								if (isset($asig_o_deduc_y_divi['deduccion'])) {
									$o = (eval("return ".$asig_o_deduc_y_divi['deduccion']['monto'].";")*$porcen)/100;
									$array_persona[$name_divi]['total']-=$o;
									$array_persona[$name_divi]['recibo_deducciones']["Especial"] =	array($asig_o_deduc_y_divi['deduccion']['motivo']=>$o);
								}
								if (isset($asig_o_deduc_y_divi['asignacion'])) {
									$o = (eval("return ".$asig_o_deduc_y_divi['asignacion']['monto'].";")*$porcen)/100;
									$array_persona[$name_divi]['total']+=$o;
									$array_persona[$name_divi]['recibo_asignaciones']["Especial"] = array($asig_o_deduc_y_divi['asignacion']['motivo']=>$o);
								}
							}
						}
					}
				}
		       	$array_all[$row['cedula']] = $array_persona;
				//array_push($array_all, $array_persona);
		    	
		      }//Termina iteración de una persona		
	}
	$array_divisones = array()	;
	foreach ($json_divisiones as $key=>$value) {
		array_push($array_divisones, $key);
	}
	array_push($array_divisones, "Total_periodo");
	
	
	$array_all['data_general'] = array(
		"num_resultados"  		 => $consulta->num_rows,
		"array_divisiones"		 => $array_divisones,
		"partida_presupuestaria" => $resultados_partida,
		"operaciones_especiales" => $id_nomina['opera_espec'],
		"casos_especiales"		 => $id_nomina['incl_excl'],
		"filtros"		         => $id_nomina['filtros'],
		"fecha"			         => date("d/m/Y"),
		"hora"  				 => date("H:i:s")
	);
	echo json_encode($array_all);


 ?>

