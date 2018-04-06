<?php
ini_set("display_errors", 1);


	require("inc/functions.php");
	
	if($srcFrom != "" || $srcSubject != "" || $srcBody != "") {
	
		$boxes = $sess["folders"];
	
		for($n=0;$n<count($boxes);$n++) {
			$entry = $boxes[$n]["name"];
			if(!is_array($sess["headers"][base64_encode($entry)])) {
				if(!$UM->mail_connected()) {
					if(!$UM->mail_connect()) redirect("error.php?err=1&lid=$lid&tid=$tid");
					if(!$UM->mail_auth()) { redirect("badlogin.php?lid=$lid&tid=$tid&error=".urlencode($UM->mail_error_msg)); exit; }
				}
				$thisbox = $UM->mail_list_msgs($entry);
				$sess["headers"][base64_encode($entry)] = $thisbox;
			} else 
				$thisbox = $sess["headers"][base64_encode($entry)];
		}
		if($UM->mail_connected()) {
			$UM->mail_disconnect(); 
			$SS->Save($sess);
		}
	
	
		$boxlist = $sess["headers"];
	
		function build_regex($strSearch) {
			$strSearch = trim($strSearch);
			if($strSearch != "") {
				$strSearch = quotemeta($strSearch);
				$arSearch = explode(" ",$strSearch);
				unset($strSearch);
				for($n=0;$n<count($arSearch);$n++)
					if($strSearch) $strSearch .= "|(".$arSearch[$n].")";
					else $strSearch .= "(".$arSearch[$n].")";
			}
			return $strSearch;
		}
	
	
		if(trim($srcBody) != "") $get_body = 1;
		$search_results = Array();
		//$start = $smarty->_get_microtime();
		$UM->use_html = false;
	
		if($srcFrom != "") $srcFrom = build_regex($srcFrom);
		if($srcSubject != "") $srcSubject = build_regex($srcSubject);
		if($srcBody != "") $srcBody = build_regex($srcBody);
	
		while(list($current_folder,$messages) = each($boxlist)) {
			$current_folder = base64_decode($current_folder);
	
			for($z=0;$z<count($messages);$z++) {
				$email = $messages[$z];
				$localname = $email["localname"];
	
				if($get_body && file_exists($localname)) {
					$thisfile = $UM->_read_file($localname);
					$email = $UM->Decode($thisfile);
					unset($thisfile);
				}
	
				$found = false;
	
				if($srcFrom != "") {
					$from = $email["from"];
					$srcString = $from[0]["name"]." ".$from[0]["mail"];
					if(preg_match('/'.$srcFrom.'/i',$srcString)) $found = true;
				}
	
				if($srcSubject != "" && !$found) {
					$srcString = $email["subject"];
					if(preg_match('/'.$srcSubject.'/i',$srcString)) $found = true;
				}
	
				if($srcBody != "" && !$found) {
					$srcString = strip_tags($email["body"]);
					if(preg_match('/'.$srcBody.'/i',$srcString)) $found = true;
				}
	
				if($found) {
					$messages[$z]["ix"] = $z;
					$headers[] = $messages[$z];
				}
			}
	
		}
		
		$messagelist = Array();
	
		for($i=0;$i<count($headers);$i++) {
			$mnum = $headers[$i]["id"]; 
			$read = (preg_match("#\\SEEN#i",$headers[$i]["flags"]))?"true":"false";
	
			$readlink = "javascript:readmsg(".$headers[$i]["ix"].",$read,'".urlencode($headers[$i]["folder"])."')";
			$composelink = "newmsg.php?folder=$folder&nameto=".htmlspecialchars($headers[$i]["from"][0]["name"])."&mailto=".htmlspecialchars($headers[$i]["from"][0]["mail"])."&lid=$lid&tid=$tid";
			$composelinksent = "newmsg.php?folder=$folder&nameto=".htmlspecialchars($headers[$i]["to"][0]["name"])."&mailto=".htmlspecialchars($headers[$i]["to"][0]["name"])."&lid=$lid&tid=$tid";
			$folderlink = "messages.php?folder=".urlencode($headers[$i]["folder"])."&lid=$lid&tid=$tid";
			
			$from = $headers[$i]["from"][0]["name"];
			$to = $headers[$i]["to"][0]["name"];
			$subject = $headers[$i]["subject"];
			
			if(!preg_match("#\\SEEN#i",$headers[$i]["flags"])) {
				$msg_img = "themes/$selected_theme/images/msg_unread.gif";
			} elseif (preg_match("#\\ANSWERED#i",$headers[$i]["flags"])) {
				$msg_img = "themes/$selected_theme/images/msg_answered.gif";
			} else {
				$msg_img = "themes/$selected_theme/images/msg_read.gif";
			}
			
			$prior = $headers[$i]["priority"];
			if($prior == 4 || $prior == 5)
				$img_prior = "&nbsp;<img src=\"themes/$selected_theme/images/prior_low.gif\" width=5 height=11 border=0 alt=\"\">";
			elseif($prior == 1 || $prior == 2)
				$img_prior = "&nbsp;<img src=\"themes/$selected_theme/images/prior_high.gif\" width=5 height=11 border=0 alt=\"\">";
			else
				$img_prior = "";
			$msg_img = "&nbsp;<img src=\"$msg_img\" width=14 height=14 border=0 alt=\"\">";
			$checkbox = "<input type=\"checkbox\" name=\"msg_$i\" value=1>";
			$attachimg = ($headers[$i]["attach"])?"&nbsp;<img src=\"themes/$selected_theme/images/attach.gif\" border=\"0\" alt=\"\">":"";
			$date = $headers[$i]["date"];
			
			$index = count($messagelist);
			
			switch($headers[$i]["folder"]) {
				case $sess["sysmap"]["inbox"]:
					$boxname = $inbox_extended;
					break;
				case $sess["sysmap"]["sent"]:
					$boxname = $sent_extended;
					break;
				case $sess["sysmap"]["trash"]:
					$boxname = $trash_extended;
					break;
				default:
					$boxname = $headers[$i]["folder"];
			}
			
			$BKMG = convert_BKMG($headers[$i]["size"]);
			$messagelist[$index]["size"] = $BKMG['size'];
			$messagelist[$index]["unit"] = $BKMG['unit'];
			$messagelist[$index]["read"] = $read;
			$messagelist[$index]["readlink"] = $readlink;
			$messagelist[$index]["composelink"] = $composelink;
			$messagelist[$index]["composelinksent"] = $composelinksent;
			$messagelist[$index]["folderlink"] = $folderlink;
			$messagelist[$index]["from"] = $from;
			$messagelist[$index]["to"] = $to;
			$messagelist[$index]["subject"] = $subject;
			$messagelist[$index]["date"] = $date;
			$messagelist[$index]["statusimg"] = $msg_img;
			$messagelist[$index]["checkbox"] = $checkbox;
			$messagelist[$index]["attachimg"] = $attachimg;
			$messagelist[$index]["priorimg"] = $img_prior;
			$messagelist[$index]["folder"] = $headers[$i]["folder"];
			$messagelist[$index]["foldername"] = $boxname;
		}
		$smarty->assign("umMessageList",$messagelist);
		unset($headers);
		$smarty->assign("umDoSearch",1);
	} else {
		$smarty->assign("umDoSearch",0);
	}

// Set SMARTY variables for templates and display
	$smarty->assign("umForms",$forms);
	
	$smarty->display("$selected_theme/"."search.htm");

?>
