<?php
session_start();

require_once '../clases/phpword/vendor/autoload.php';
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$obj = json_decode($_POST['obj'],true);

$doc = new \PhpOffice\PhpWord\TemplateProcessor("plantillas/".$_POST['temple_use']);

$doc->setValue('nombre', $obj['nombre']);
$doc->setValue('apellido', $obj['apellido']);
$doc->setValue('cedula', $obj['cedula']);
$doc->setValue('nacionalidad', $obj['nacionalidad']);
$doc->setValue('fecha_ingreso', $obj['fecha_ingreso']);
$doc->setValue('categoria', $obj['categoria']);
$doc->setValue('cargo', $obj['cargo']);
$doc->setValue('dedicacion', $obj['dedicacion']);
$doc->setValue('departamento_adscrito', $obj['departamento_adscrito']);
$doc->setValue('profesion', $obj['profesion']);
$doc->setValue('estatus', $obj['estatus']);
$doc->setValue('sueldo_basico', $obj['salario']);
$doc->setValue('usuario_nombre', $_SESSION['nombre']." ".$_SESSION['apellido']);

$doc->setValue('genero', $obj['genero']);
$doc->setValue('cuenta_bancaria', $obj['cuenta_bancaria']);
$doc->setValue('numero_hijos', $obj['numero_hijos']);
$doc->setValue('telefono_1', $obj['telefono_1']);
$doc->setValue('telefono_2', $obj['telefono_2']);
$doc->setValue('correo', $obj['correo']);
$doc->setValue('caja_ahorro', $obj['caja_ahorro']);
$doc->setValue('antiguedad_otros_ieu', $obj['antiguedad_otros_ieu']);
$doc->setValue('años_servicio', $obj['años_servicio']);

$doc->setValue('fecha', date('d/m/Y'));

$nombre_archivo = str_replace('.docx', '', $_POST['temple_use']).'_'.utf8_decode($obj['nombre'])." ".utf8_decode($obj['apellido']).'_'.$obj['cedula'].' '.date('(d-m-Y)').'.docx';

header('Content-Type: application/msword');
header('Content-Disposition: attachment;filename="'. $nombre_archivo .'"');
header('Cache-Control: max-age=0');
$doc->saveAs('php://output');
?>