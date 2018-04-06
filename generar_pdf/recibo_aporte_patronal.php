<?php 

require_once '../clases/mpdf/mpdf.php';

$mpdf = new mPDF();
$mpdf->showImageErrors = true;
$mpdf->Bookmark('Start of the document');
$stylesheet = file_get_contents('../css/bootstrap/dist/css/bootstrap.min.css'); 
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML('<img src="../image/cintillo.jpg" alt="" style="width: 100%"><hr>'.$_POST['data_recibo_aporte_patronal']);

$mpdf->Output("Recibo ".date("d-m-Y").".pdf","I");


 ?>
