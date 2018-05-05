<?php 
	if ($_POST['accion']=="ver") {
		$fp = fopen("partidas.txt","r");
		$partida = "";
		while(!feof($fp)) {
			$linea = fgets($fp);
			$partida.=$linea;
		}
		fclose($fp);
		echo $partida;
	}else if($_POST['accion']=="guardar"){
		$fp = fopen("partidas.txt","w");
		fwrite( $fp , $_POST['json'] );
		fclose($fp);
	}
		
