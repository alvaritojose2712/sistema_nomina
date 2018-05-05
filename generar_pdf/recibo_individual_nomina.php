<?php 

require_once '../clases/mpdf/mpdf.php';
$mpdf = new mPDF();
$mpdf->showImageErrors = true;
$mpdf->Bookmark('Start of the document');
$stylesheet = file_get_contents('../css/w3.css'); 
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML(str_replace("image/cintillo.jpg", "../image/cintillo.jpg", $_POST['g-recibo-data']));
$mpdf->Output("Recibo ".date("d-m-Y").".pdf","I");

?>
