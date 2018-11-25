<?php 
require_once '../clases/mpdf/mpdf.php';

$mpdf = new mPDF();
$mpdf->showImageErrors = true;
$stylesheet = file_get_contents('../css/w3.css'); 
$mpdf->WriteHTML($stylesheet,1);
//$html = '<img src="../image/cintillo.jpg" alt="" style="width: 100%"><hr>';
$html = "<table color='black' border='2'>
<thead>
	<tr>
		<th>Nº</th>
		<th>Estado</th>
		<th>Apellidos y Nombres</th>
		<th>Cédula</th>
		<th>Estatus</th>
		<th>Categoría</th>
		<th>Cargo</th>
		<th>Dedicación</th>
	</tr>
</thead><tbody>
";
foreach (json_decode($_POST['data_reporte_general_ficha'],true) as $key => $value) {
	$key++;
	$html .= "
	<tr>
		<td>".$key."</td>
		<td>".$value['Estado']."</td>
		<td>".$value['Apellidos'].", ".$value['Nombres']."</td>
		<td>".$value['Cédula']."</td>
		<td>".$value['Estatus']."</td>
		<td>".$value['Categoría']."</td>
		<td>".$value['Cargo']."</td>
		<td>".$value['Dedicación']."</td>
	</tr>";
}
$html .= "</tbody><table>";

$mpdf->WriteHTML($html);
$mpdf->Output("Reporte ".date("d-m-Y").".pdf","I");

 ?>