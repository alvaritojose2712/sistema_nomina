<?php
ini_set("display_errors", 1);
	require('./inc/inc.php');


	function mail_connect() {
	
		global $UM,$sid,$tid,$lid;
		
		if(!$UM->mail_connect()) { 
			redirect("error.php?lid=$lid&tid=$tid&err=1\r\n"); 
			exit; 
		}
	
		if(!$UM->mail_auth(true)) { 
			redirect("badlogin.php?lid=$lid&tid=$tid&error=".urlencode($UM->mail_error_msg)."\r\n"); 
			exit; 
		}
	}
	
	
	$headers = null;
	$folder_key = base64_encode($folder);
	if(!array_key_exists("headers",$sess)) $sess["headers"] = array();
		
	if(array_key_exists($folder_key,$sess["headers"]))
		$headers = $sess["headers"][$folder_key];
	
	if( !is_array($headers) 
		|| isset($decision)
		|| isset($refr)) {
	
		mail_connect();
	
		$sysmap = $UM->get_system_folders();
		$sysfolders = Array();
		while(list($key,$value) = each($sysmap))
			$sysfolders[] = $value;
	
		$sess["sysmap"] = $sysmap;
		$sess["sysfolders"] = $sysfolders;
		$sess["auth"] = true;
	
		if(!isset($folder) || $folder == "" || strpos($folder,"..") !== false ) {
			$folder = $sess["sysmap"]["inbox"];
			$folder_key = base64_encode($folder);
		}
		
		if(isset($start_pos) && isset($end_pos)) {
	
			for($i=$start_pos;$i<$end_pos;$i++) {

				if(isset(${"msg_$i"})) {
					if ($decision == "delete") {
						$UM->mail_delete_msg($headers[$i],$prefs["save-to-trash"],$prefs["st-only-read"]);
					} elseif ($decision == "spam") {
						$UM->mail_spam_msg($headers[$i],$prefs["save-to-spam"]);	
					} elseif ($decision == "mark") {
						$UM->mail_set_flag($headers[$i],"\\SEEN","+");
					} elseif ($decision == "unmark") {
						$UM->mail_set_flag($headers[$i],"\\SEEN","-");
					} elseif ($decision == "flagmsg") {
						$UM->mail_set_flag($headers[$i],"\\FLAGMSG","+");
					} elseif ($decision == "deflagmsg") {
						$UM->mail_set_flag($headers[$i],"\\FLAGMSG","-");
					} elseif ($decision == "move") {
						$UM->mail_move_msg($headers[$i],$aval_folders);
					} else {
						// Do nothing
					}
					$expunge = true;
				}
			}
	
			if($expunge) {
	
				if ($prefs["save-to-trash"])
					unset($sess["headers"][base64_encode($sess["sysmap"]["trash"])]);
				if ($decision == "move")
					unset($sess["headers"][base64_encode($aval_folders)]);
					
					if ($prefs["save-to-spam"])
					unset($sess["headers"][base64_encode($sess["sysmap"]["spam"])]);
				if ($decision == "move")
					unset($sess["headers"][base64_encode($aval_folders)]);
			  
	
				//some servers, don't hide deleted messages until you don't disconnect
				$SS->Save($sess);
			
				if ($back) {
					$back_to = $start_pos;
				}
			}
	
			unset($sess["headers"][$folder_key]);
	
		} elseif (isset($refr) && array_key_exists("headers",$sess)) {
			unset($sess["headers"][$folder_key]);
		}
		
		$boxes = $UM->mail_list_boxes();
	
		$sess["folders"] = $boxes;
		
	
	
	if(!$expunge || !$is_inbox_or_spam || $mlist) {
		require("./get_message_list.php");
		require("./apply_filters.php");
	}
	
	
	
	if($require_update) {
		$UM->mail_disconnect();
		mail_connect();
		require("./get_message_list.php");
	}

	$UM->mail_disconnect();
	}
	
		
	if(!is_array($headers = $sess["headers"][$folder_key])) { 
		redirect("messages.php?lid=$lid&tid=$tid&folder=$folder&pag=$pag\r\n"); 
	} 
	
	
	
	if (!$is_inbox_or_spam || $UM->mail_protocol == "imap") {
	if ($sortby == "date" || $sortby == "size") {
		array_qsort2($headers,$sortby,$sortorder);
	} else {
		array_qsort2ic($headers,$sortby,$sortorder);
	}
}



	$sess["headers"][$folder_key] = $headers;
	$SS->Save($sess);
	
	if($check_first_login && !$prefs["first-login"]) {
		$prefs["first-login"] = 1;
		save_prefs($prefs);
		redirect("preferences.php?lid=$lid&tid=$tid&folder=".urlencode($folder));
		exit;
	}
	
	if(!isset($pag) || !is_numeric(trim($pag))) $pag = 1;
	$refreshurl = "messages.php?lid=$lid&tid=$tid&folder=".urlencode($folder)."&pag=$pag";
	
	if (isset($back_to)) {
		if (count($headers) > $back_to) {
			redirect("readmsg.php?lid=$lid&tid=$tid&folder=".urlencode($folder)."&pag=$pag&ix=$back_to");
			exit;
		}
	}
	
	redirect($refreshurl);
	
?>
