<?php 
if ($_FILES['archivo1']['type']==="application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
	if (move_uploaded_file($_FILES['archivo1']['tmp_name'], '../plantillas/'.$_FILES['archivo1']['name'])) {
		echo "Exito al subir";
	}
}else{
	echo 'Archivo no permitido!. Seleccione un documento .docx';	
}
 ?>