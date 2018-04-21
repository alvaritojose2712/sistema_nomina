<?php 

require_once '../clases/mpdf/mpdf.php';

$mpdf = new mPDF();
$mpdf->showImageErrors = true;
$mpdf->Bookmark('Start of the document');
$stylesheet = file_get_contents('../css/bootstrap/dist/css/bootstrap.min.css'); 
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML('<img src="../image/cintillo.jpg" alt="" style="width: 100%"><hr>');

$mpdf->WriteHTML('<table class="table table-bordered">
						<tr>
							<th><span class="">Código presupuestario</span></th>
							<td>'.$_POST['cod_presu'].'</td>
						</tr>
						<tr>
							<th><span>Denominación del IEU</span></th>
							<td>'.$_POST['denomi_ieu'].'</td>
						</tr>
						<tr>
							<th><span>Órgano de adscripción</span></th>
							<td>'.$_POST['organo_abs'].'</td>
						</tr>
						<tr>
							<th><span>Mes requerido</span></th>
							<td>'.$_POST['mes_req'].'</td>
						</tr>
					</table>');
$mpdf->WriteHTML($_POST['data_partidas_to_excel_or_pdf']);


$mpdf->Output("Partida_presupuestaria ".date("d-m-Y").".pdf","I");


 ?>
