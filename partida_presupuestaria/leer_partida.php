<?php 
	$fp = fopen("partidas.txt","r");
	$partida = "";
	while(!feof($fp)) {
		$linea = fgets($fp);
		$partida.=$linea;
	}
	fclose($fp);
echo $partida;
