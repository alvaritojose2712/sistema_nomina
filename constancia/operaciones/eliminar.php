<?php 
if (unlink('../plantillas/'.$_POST['name'])) {
	echo 'Exito al eliminar';
}else{
	echo "Error al eliminar";
}

 ?>