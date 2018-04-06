<?php
ini_set("display_errors", 1);

session_name('Uebimiau');
session_start();

require("inc/lib.php");


// common session check, exit if no auth
$SS = new Session();
$sess = $SS->Load();

if(!$sess["auth"]) {
	echo "error: your session seems expired";
	die();
}

// cheking for main param
if(isset($_POST['action'])) {
	
	// config
	require("inc/config/config.uebimiau.php");

	$prefs = load_prefs();
		
	$action = $_POST['action'];
	switch($action) {
	
		// send a read receipt
		case "sendReceipt":
			if(!isset($_POST['recipient']))
				break;

			$recipient = $_POST['recipient'];			
			$receiptSubj = $_POST['receipt_subj'];
			$receiptMsg = $_POST['receipt_msg'];
			
			require("inc/class/class.uebimiau.php");
			$UM = new Uebimiau();

			require("inc/class/class.phpmailer.php");
		    require("inc/class/class.phpmailer_extra.php");

			// init mailer
		        $mail = new PHPMailer_extra;
		       	$mail->PluginDir = "inc/inc.php";
			$mail->SetLanguage("en","langs/");
			$mail->CharSet = $default_char_set;
			$mail->Hostname = getenv("SERVER_NAME");
			$mail->Host = $smtp_server;
			$mail->WordWrap = 76;
			$mail->Priority = 3;
			$mail->SMTPDebug = false;
			$mail->Mailer = $mailer_type;
			if ($phpmailer_sendmail != "") {
				$mail->Sendmail = $phpmailer_sendmail;
			}
			if ($phpmailer_timeout != 0) {
				$mail->Timeout = $phpmailer_timeout;
        		}

			// for password authenticated servers
			$mail->SMTPAuth = $use_password_for_smtp;
			$mail->Username = $sess["user"];
			$mail->Password = $sess["pass"];
                  
                 
			// build the email
			$mail->From = ($allow_modified_from && !empty($prefs["reply-to"]))?$prefs["reply-to"]:$sess["email"];
			$mail->FromName = $UM->mime_encode_headers($prefs["real-name"]);
			$mail->AddReplyTo($prefs["reply-to"], $UM->mime_encode_headers($prefs["real-name"]));			
			$mail->AddAddress($recipient);
			
			$mail->Subject = $UM->mime_encode_headers(stripslashes($receiptSubj));
			$mail->Body = stripslashes($receiptText);

			// send
			if($mail->Send() === true) {
				echo "success: receipt sent";
			}			
			else {
				echo "error: " . $mail->ErrorInfo;
			}

			break;

		// just refresh the session timeout
		case "pingSession":
			// refresh time
		        $sess["start"] = time();
		        // save
		        $SS->Save($sess);

		        echo "success: session refreshed";
		
			break;
		
		default:
			echo "error: this action does not exist";
	}

} else {
	// no action, no fun
	echo "error: no action specified";
}

?>
