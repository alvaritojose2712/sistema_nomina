<?php 
include '../../conexion_bd.php';

$consulta = (new sql("valores_globales","WHERE id=1"))->select()->fetch_assoc();

$v = json_decode($consulta['cat_car_dedic'],true);
$filtrado = array();
if ($_FILES['cargar_txt']['type']=="text/plain") {
	$fp = fopen($_FILES['cargar_txt']['tmp_name'], "r");
	$err = 0;
	$line_to_line = array();
	while(!feof($fp)) {

		$linea = fgets($fp);
		if ($linea!="\t") {
			
			if ($linea!="\n") {
				array_push($line_to_line, $linea);
				$linea = str_replace("\n", "", $linea);

				$trozo = explode("\t", $linea);

				if( count($trozo)!=count(array_unique($trozo)) ){
					$err++;
				}else{
					if (count(array_unique($trozo))==5) {
						array_push($filtrado, $trozo);
					}
					
				}
			}
		}
		
		//print_r($trozo);
		

	}
	fclose($fp);
	//print_r($filtrado);
	if ($err!=0) {
		//echo json_encode($line_to_line);
		//print_r($filtrado);
		echo "El archivo de texto no esta bien formateado, elimine espacios en blanco o corrija campos duplicados.";
	}else{
		$arreglado = array();
		//echo json_encode($line_to_line);
		foreach ($filtrado as $key => $one_line) {
			
			$cat =  utf8_encode(trim($one_line[0]));//cat
			$car =  utf8_encode(trim($one_line[1]));//car
			$dedic =  utf8_encode(trim($one_line[2]));//dedic
			$fecha =  utf8_encode(trim($one_line[3]));//fecha
			$salario =  utf8_encode(trim($one_line[4]));//salario
			
			$date = new DateTime($fecha);

			$arreglado[$key] = array('categoria'=>$cat ,'cargo'=>$car ,'dedicacion'=>$dedic ,'fecha'=>$date->format('Y-m-d') ,'salario'=>$salario );


		}
		//print_r($arreglado);
		echo json_encode($arreglado);
	}

}else{
	echo "Archivo no permitido. Solo se admiten .txt";
}

 ?>