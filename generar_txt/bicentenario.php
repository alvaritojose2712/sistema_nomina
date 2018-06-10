<?php 
	session_start();
	//Cabezera
	define('CUENTA_MATRIZ_cabezera',20);
	define('FECHA_cabezera',8);
	define('MONTO_cabezera',17);
	define('REGISTROS_cabezera',4);

	//Cuerpo
	define('EMPRESA_cuerpo',4);
	define('MONTO_cuerpo',12);
	define('CUENTA_cuerpo',20);
	define('CEDULA_cuerpo',10);
	define('FILLER_1_cuerpo',5);
	define('TIPO_cuerpo',1);
	define('FILLER_2_cuerpo',2);

	$data_ = json_decode($_POST['data_generar_txt'],true);

	$codigo_presupuestario_institucion = $_SESSION['codigo_presupuestario_institucion'];
	
	$codigo_institucion_institucion = $_SESSION['codigo_institucion_institucion'];
	$cuenta_matriz_institucion = $_SESSION['cuenta_matriz_institucion'];

	$total_nomina = 0;
	
	$cuerpo = array();
	foreach ($data_ as $key => $arr) {

	  	$cuerpo[$key] = array(
	  	'EMPRESA_cuerpo' => $codigo_institucion_institucion,
		'MONTO_cuerpo' => $arr['MONTO_cuerpo'],
		'CUENTA_cuerpo' => $arr['CUENTA_cuerpo'],
		'CEDULA_cuerpo' => $arr['CEDULA_cuerpo'],
		'FILLER_1_cuerpo' => "00000",
		'TIPO_cuerpo' => "0",
		'FILLER_2_cuerpo' => "00");

		$total_nomina += $arr['MONTO_cuerpo'];
	}
	$cabezera = array(
		"CUENTA_MATRIZ_cabezera" => $cuenta_matriz_institucion,
		"FECHA_cabezera" => date("Ymd"),
		"MONTO_cabezera" => $total_nomina,
		"REGISTROS_cabezera" => count($data_)
	);
	// $cuerpo = array(
	// 		'0' => array(
	// 			"EMPRESA_cuerpo" => "0513",
	// 			"MONTO_cuerpo" => "000000018801",
	// 			"CUENTA_cuerpo" => "00070068140010001925",
	// 			"CEDULA_cuerpo" => "0003240080",
	// 			"FILLER_1_cuerpo" => "00000",
	// 			"TIPO_cuerpo" => "0",
	// 			"FILLER_2_cuerpo" => "00")
	// 	);
	

	$f = fopen("pago.txt", "w") or die("Error al crear el Archivo");

	$str_cabezera = "";
	$str_cuerpo = "";

	$err = true;
	foreach ($cabezera as $campo => $valor) {
		$const = eval("return ".$campo.";");

		if (strlen($valor)<$const) {
			$diff = $const-strlen($valor);
			for ($i=0; $i < $diff ; $i++) { 
				$valor = "0".$valor;
			}
		}
		
		if (strlen($valor)==$const) {
			$str_cabezera.=$valor;
		}else{
			$err = false;
			break; 
		}
		
	}
	$str_cabezera.="\n";

	foreach ($cuerpo as $key => $arr) {
		foreach ($arr as $campo => $valor) {
			$const = eval("return ".$campo.";");
			
			if (strlen($valor)<$const) {
				$diff = $const-strlen($valor);
				for ($i=0; $i < $diff ; $i++) { 
					$valor = "0".$valor;
				}
			}
			if (strlen($valor)==$const) {
				$str_cuerpo.=$valor;
			}else{
				$err = false;
				break; 
			}
		}
		if (count($cuerpo)-1!=$key) {
			$str_cuerpo.="\n";
		}
		
	}
	
	if ($err) {
		fwrite($f, $str_cabezera);
		fwrite($f, $str_cuerpo);
		fclose($f);

		header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename='.basename('pago.txt'));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize('pago.txt'));
	    readfile('pago.txt');
	    exit;
	}else{
		echo "\nError en la estructura de los Datos";
	}
	
 ?>
