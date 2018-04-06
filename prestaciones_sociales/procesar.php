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
		echo "<table class='table table-striped'>
				<tr>
					<th>
						Nombre y apellido
					</th>
					<th>
						Sueldo básico
					</th>
					<th>
						Sueldo normal
					</th>
					<th>
						Sueldo integral
					</th>
					<th>
						Antiguedad
					</th>
					<th>
						Prestaciones Sociales
					</th>
				</tr>";
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

				$inicio = new DateTime($fecha_inicio);
				$fecha_ingreso = new DateTime($row['fecha_ingreso']);
				if ($inicio<$fecha_ingreso) {
					$inicio = $fecha_ingreso;
				}

	            $final = new DateTime($fecha_cierre);
	            $diferencia = $inicio->diff($final);
	            if ($diferencia->d>28) {
	            	$diferencia->d=30;
	            }
	            $meses = (($diferencia->d)/30)+$diferencia->m;
	            $trimestre = $meses/3;
	            //¿Cuántos días le corresponden por concepto de garantía a un trabajador que laboró 5 meses?

				// Por los primeros tres meses le corresponden 15 días.
				// Por los siguientes dos meses también le corresponden 15 días. ¿Por qué? Porque el derecho al depósito se adquiere al iniciar el trimestre, sin importar que el trabajador preste los servicios durante todo el trimestre. 
	            $dias_correspon = ceil($trimestre)*15;

	   			//Si la relación de trabajo termina antes de los tres primeros meses, el
				// pago que le corresponde al trabajador o trabajadora por concepto de
				// prestaciones sociales será de cinco días de salario por mes trabajado
				// o fracción.
	            if (floor($trimestre)==0) {
	            	$dias_correspon=$meses*5;
	            }

				//Si la relación de trabajo termina con una antigüedad en el trabajo mayor de 6 meses, se considerará equivalente a un año. Por ejemplo: si la relación de trabajo termina cuando el trabajador tenía un antigüedad de 1 año y 7 meses se considerará que laboró 2 años
	            if ($fecha_antiguedad->m>=6) {
					$años_antiguedad++;
				}	


				// Que al cumplir los 2 años se generan los 2 días adicionales, al cumplir tres años se ganarán 4 días adicionales, al cumplir 3 años serán 6 días y así sucesivamente hasta acumular 30 días. 
				 
				$dias_adicionales = ($años_antiguedad-1)*2;
				// Al acumular los 30 días, es decir a los 16 años de servicios, los años siguientes se seguirán generando 30 días
				if ($dias_adicionales>30) {
					$dias_adicionales=30;
				}

	            $integral_diario = $sueldo_integral/30;

	            $prestaciones = $integral_diario*($dias_correspon+(($dias_adicionales/4)*$trimestre));
				echo "
						<tr>
							<td>".$row['nombre']." ".$row['apellido']."</td>
							<td>".number_format($sueldo_tabla, 2, ',', '.')."</td>
							<td>".number_format($sueldo_normal, 2, ',', '.')."<br>".$base_calculo_sueldo_normal."</td>
							<td>".number_format($sueldo_integral, 2, ',', '.')."<br>".$base_calculo_sueldo_integral."</td>
							<td>Fecha de ingreso=".$row['fecha_ingreso']."<hr>Años=".$años_antiguedad." <hr>Meses=".$fecha_antiguedad->m."</td>
							<td>".number_format($prestaciones, 2, ',', '.')."<hr>
								Integral diario = ".$integral_diario."<hr>Dias de prestaciones = ".$dias_correspon."<hr>
								Días adicionales /trimestre = ".($dias_adicionales/4)."<hr>
								Nº de trimestres = ".$trimestre."
							</td>
						</tr>
					";
				
		    	
		      }//Termina iteración de una persona		
		      echo "</table>";
	}

	
 ?>

