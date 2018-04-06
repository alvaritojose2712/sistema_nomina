<?php
ini_set("display_errors", 1);

	// Retreive mails boxes
	if(!$UM->mail_connect()) redirect("error.php?lid=$lid&tid=$tid&err=1\r\n");
	if(!$UM->mail_auth()) { redirect("badlogin.php?lid=$lid&tid=$tid&error=".urlencode($UM->mail_error_msg)."\r\n"); exit; }
	$boxes = $UM->mail_list_boxes();

	$scounter = 0;
	$pcounter = 0;
	$nb_msg = 0;
	$nb_msg_unread = 0;
	
	for($n=0;$n<count($boxes);$n++) {
		$entry = $boxes[$n]["name"];
		$unread = 0;
	
		if(!is_array($sess["headers"][base64_encode($entry)])) {
			$thisbox = $UM->mail_list_msgs($entry);
			$sess["headers"][base64_encode($entry)] = $thisbox;
		} else $thisbox = $sess["headers"][base64_encode($entry)];
	
		$boxsize = 0;
	
		for($i=0;$i<count($thisbox);$i++) {
			if(!preg_match("/\\SEEN/i",$thisbox[$i]["flags"])) $unread++;
			$boxsize += $thisbox[$i]["size"];
		}
		
		$boxname = $entry;
	
		if($unread != 0) $unread = "<b>$unread</b><b>  New</b>";
	
		if(in_array($entry, $sess["sysfolders"])) {
			switch(strtolower($entry)) {
			case strtolower($sess["sysmap"]["inbox"]):
				$boxname = $inbox_extended;
				break;
			case strtolower($sess["sysmap"]["sent"]):
				$boxname = $sent_extended;
				break;
			case strtolower($sess["sysmap"]["trash"]):
				$boxname = $trash_extended;
				break;
			case strtolower($sess["sysmap"]["spam"]):
				$boxname = $spam_extended;
				break;
			}
			$system[$scounter]["entry"]     	= $entry;
			$system[$scounter]["link"] 			= "process.php?lid=$lid&tid=$tid&folder=".$entry;
			$system[$scounter]["name"]      	= $boxname;
			$system[$scounter]["msgs"]      	= count($thisbox)."/$unread";
			$system[$scounter]["chlink"] 		= "process.php?lid=$lid&tid=$tid&folder=".$entry;
			$system[$scounter]["emptylink"]		= "folders.php?lid=$lid&tid=$tid&empty=".$entry."&folder=".$entry;
			$scounter++;
			$nb_msg += count($thisbox);
			$nb_msg_unread += $unread;

		} else {
	
			$personal[$pcounter]["entry"]   	= $entry;
			$personal[$pcounter]["link"] 		= "process.php?lid=$lid&tid=$tid&folder=".$entry;
			$personal[$pcounter]["name"]    	= $boxname;
			$personal[$pcounter]["msgs"]    	= count($thisbox)."/$unread";
			$personal[$pcounter]["chlink"]  	= "process.php?lid=$lid&tid=$tid&folder=".urlencode($entry);
			$personal[$pcounter]["emptylink"]	= "folders.php?lid=$lid&tid=$tid&empty=".urlencode($entry)."&folder=".urlencode($entry);
	
			$pcounter++;
			$nb_msg += count($thisbox);
			$nb_msg_unread += $unread;

		}
		$totalused += $boxsize;
	}
	$UM->mail_disconnect();

	array_qsort2 ($system,"name");
	
	if(!is_array($personal)) $personal = Array();
	
	$umFolderList = array_merge($system, $personal);
	array_qsort2 ($system,"name");
	array_qsort2 ($personal,"name");
	
// Set SMARTY variables for templates
	$smarty->assign("umFolderNb",count($boxes));
	$smarty->assign("umMsgNb",$nb_msg);
	$smarty->assign("umFolderList",$umFolderList);
	$smarty->assign("umSystemFolders",$system);
	$smarty->assign("umPersonalFolders",$personal);
	
	

?>