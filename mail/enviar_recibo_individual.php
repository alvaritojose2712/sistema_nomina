<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once '../clases/mpdf/mpdf.php';
require '../clases/phpmailer/vendor/autoload.php';
include '../conexion_bd.php';



    $sql = (new sql("mail","WHERE cuenta='".$_POST['de']."'"))->select()->fetch_assoc();
    $destinatarios = json_decode($_POST['desti'],true);


$mail = new PHPMailer(true);   
try {
    $mpdf = new mPDF();
    $mpdf->showImageErrors = true;
    $mpdf->Bookmark('Start of the document');
    $stylesheet = file_get_contents('../css/w3.css'); 
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML(str_replace("image/cintillo.jpg", "../image/cintillo.jpg", $_POST['adjunto']));

    $file_name = "temp/Recibo ".date("d-m-Y").".pdf";
    $mpdf->Output($file_name,"F");

    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $sql['servidor_smtp'];  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $sql['cuenta'];                 // SMTP username
    $mail->Password = $sql['clave'];                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
	$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
		)
	);
    //De
    $mail->setFrom($sql['cuenta'], $sql['nombre']);
    //Para
   
    foreach ($destinatarios as $key => $value) {
       $mail->addAddress($value, '');    
  
    }    
    //Adjunto
    $mail->addAttachment($file_name, "Recibo ".date("d-m-Y").".pdf");    

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $_POST['asunto'];
    $mail->Body    = $_POST['msj'];
  
    $mail->send();
    echo 'Mensaje enviado';
    unlink($file_name);
} catch (Exception $e) {
    echo 'Mensaje no pudo ser enviado. Mailer Error: ', $mail->ErrorInfo;
}