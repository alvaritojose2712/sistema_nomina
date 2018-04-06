<?php 
    $dir = "../plantillas/"; 
    $directorio = opendir($dir); 
    $result = array();
    while ($buscar1 = readdir($directorio)) 
    { 
    	if ($buscar1!='.') {
    		if ($buscar1!='..') {
    			array_push($result, $buscar1);
    		}
    		
    	}	
    } 
    closedir($directorio); 

if (isset($_POST['buscar'])){ 
	
	echo json_encode($result);
} 


?>