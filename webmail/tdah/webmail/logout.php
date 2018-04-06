<?php
ini_set("display_errors", 1);
 
	require('./inc/inc.php');
//	require("langs/"."$chat_language.php");
	
		// Log report	
	$blf = $temporary_directory."system_admin/log.ucf";
	$date = date(LOG_DATE);
	$line = "<span class=\"log_date\">$date</span><span class=\"logout\">$f_user from $company just logged out.</span><br>\n";
	$file = fopen($blf, 'a+');
	fwrite($file, $line);
	fclose($file);

// Logout the chat application if user is still logged
	if (isset($_SESSION['nickname'])) {
		$nick = ($_SESSION['nickname']);
		$date = date($chat_date_format);
		$line = "<p><span class=\"main\">$nick</span> <span class=\"logout\">".CHAT_LEFT."</span><span class=\"date\"> - $date</span></p>";
		$file = fopen($temporary_directory."chat/chatdata.ucf", 'a+');
		fwrite($file, $line);
		fclose($file);
	
		//session_start();
	
	// End the session (remove user from the users list)
		if (file_exists($temporary_directory."chat/online.ucf")) {
			$f_text = file($temporary_directory."chat/online.ucf");
			$file_handle = fopen($temporary_directory."chat/online.ucf","w");
			foreach( $f_text as $line ) {
				 if ( !strstr($line, $nick) )
					   fputs($file_handle, $line);
			}
			fclose($file_handle);
		}
		unset($_SESSION['nickname']);
	}


// Logout the mail application
	if(is_array($sess["headers"]) && file_exists($userfolder)) {
	
		$inboxdir = $userfolder."inbox/";
		$d = dir($userfolder."_attachments/");
		while($entry=$d->read()) {
			if($entry != "." && $entry != "..") 
				unlink($userfolder."_attachments/$entry");
		}
		$d->close();
	
		if(is_array($sess["folders"])) {
			$boxes = $sess["folders"];
	
			for($n=0;$n<count($boxes);$n++) {
	
				$entry = $boxes[$n]["name"];
				$file_list = Array();
	
				if(is_array($curfolder = $sess["headers"][base64_encode($entry)])) {
	
					for($j=0;$j<count($curfolder);$j++) 
						$file_list[] = $curfolder[$j]["localname"];
	
					// clean-up before leaving (check folders because some may have been deleted !!!)
					if (file_exists($userfolder."$entry/")) {
						$d = dir($userfolder."$entry/");
						while($curfile=$d->read()) {
							if($curfile != "." && $curfile != "..") {
								$curfile = $userfolder."$entry/$curfile";
								if(!in_array($curfile,$file_list)) 
									@unlink($curfile);
							}
						}
						$d->close();
					}
				}
			}
		}
	
		if($prefs["empty-trash"]) {
			if(!$UM->mail_connect()) { redirect("error.php?err=1&lid=$lid&tid=$tid"); exit; }
			if(!$UM->mail_auth()) { redirect("badlogin.php?lid=$lid&tid=$tid&error=".urlencode($UM->mail_error_msg)); exit; }
			$trash = $sysmap["trash"];
			if(!is_array($sess["headers"][base64_encode($trash)])) $sess["headers"][base64_encode($trash)] = $UM->mail_list_msgs($trash);
			$trash = $sess["headers"][base64_encode($trash)];
	
			if(count($trash) > 0) {
				for($j=0;$j<count($trash);$j++) {
					$UM->mail_delete_msg($trash[$j],false);
				}
				$UM->mail_expunge();
			}
	
			$UM->mail_disconnect();
		}
		$SS->Kill();
	}	
	
	redirect("./index.php?lid=$lid&tid=$tid");

?> 