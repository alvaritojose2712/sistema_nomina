<?php
ini_set("display_errors", 1);
  
 require_once('./inc/functions.php');
	
	
	$refreshurl = "process.php?lid=$lid&tid=$tid&folder=".urlencode($folder)."&pag=$pag&refr=true";
	
	if(!is_array($headers = $sess["headers"][base64_encode($folder)])) { redirect("error.php?lid=$lid&tid=$tid&err=3&plus=true"); exit; }
	
	$arrow = ($sortorder == "ASC")?"themes/$selected_theme/images/arrow_up.gif":"themes/$selected_theme/images/arrow_down.gif";
	//<- 	$arrow = "&nbsp;<img src=\"$arrow width=8 height=8\" border='0' alt=''>";
	$arrow = "&nbsp;<img src=\"$arrow\" width=\"8\" height=\"8\" border=\"0\" alt=\"Sort\">";
	
	$attach_arrow  	= "";
	$subject_arrow 	= "";
	$fromname_arrow = "";
	$date_arrow 	= "";
	$size_arrow 	= "";
	
	switch($sortby) {
		case "fromname":
			$fromname_arrow  	= $arrow;
			break;
		case "subject":
			$subject_arrow  	= $arrow;
			break;
		case "date":
			$date_arrow  		= $arrow;
			break;
		case "size":
			$size_arrow   		= $arrow;
			break;
	}
	
	$elapsedtime = (time()-$sess["last-update"])/60;
	$timeleft = ($prefs["refresh-time"]-$elapsedtime);
	
	if($timeleft > 0) {
		$smarty->assign("umRefresh","<meta http-equiv=\"Refresh\" content=\"".(ceil($timeleft)*60)."; URL=$refreshurl\">");
	} elseif ($prefs["refresh-time"]) {
		redirect("$refreshurl");
	}
	
	$BKMG = convert_BKMG($totalused);
	$smarty->assign("umTotalUsed",$BKMG['size']);
	$smarty->assign("umTotalUnit",$BKMG['unit']);
	$quota_enabled = ($quota_limit) ? 1 : 0;
	$smarty->assign("umQuotaEnabled",$quota_enabled);
	$smarty->assign("umQuotaExceeded",($totalused/1024) > $quota_limit);
	
	$BKMG = convert_BKMG($quota_limit*1024);
	$smarty->assign("umQuotaLimit",$BKMG['size']);
	$smarty->assign("umQuotaUnit",$BKMG['unit']);
	$usageGraph = get_usage_graphic(($totalused/1024),$quota_limit);
	$smarty->assign("umUsageGraph",$usageGraph);
	
	
	// sorting arrays..
	
	$smarty->assign("umAttachArrow",$attach_arrow);
	$smarty->assign("umFromArrow",$fromname_arrow);
	$smarty->assign("umSubjectArrow",$subject_arrow);
	$smarty->assign("umDateArrow",$date_arrow);
	$smarty->assign("umSizeArrow",$size_arrow);
	
	
	$nummsg = count($headers);
	if(!isset($pag) || !is_numeric(trim($pag))) $pag = 1;
	
	$reg_pp    = $prefs["rpp"];
	$start_pos = ($pag-1)*$reg_pp;
	$end_pos   = (($start_pos+$reg_pp) > $nummsg)?$nummsg:$start_pos+$reg_pp;
	
	if(($start_pos >= $end_pos) && ($pag != 1)) 
		redirect("messages.php?lid=$lid&tid=$tid&folder=$folder&pag=".($pag-1)."\r\n");
	
	$smarty->assign("pageMetas",$nocache);
	
	if(isset($msg))
		$smarty->assign("umErrorMessage",$msg);
	$forms .= "
	<input type=\"hidden\" name=\"decision\" value=\"\">
	<input type=\"hidden\" name=\"folder\" value=\"".htmlspecialchars($folder)."\">
	<input type=\"hidden\" name=\"pag\" value=\"$pag\">
	<input type=\"hidden\" name=\"start_pos\" value=\"$start_pos\">
	<input type=\"hidden\" name=\"end_pos\" value=\"$end_pos\">";
	
	$smarty->assign("umJS",$jssource);
	$smarty->assign("umForms",$forms);
	$smarty->assign("umFolder",$folder);
	$messagelist = Array();
	$func($textout);
	
	$newmsgs = 0;
	if($nummsg > 0) {
		
		// Debug print the message header
		// print_struc($headers);
		
		for($i=0;$i<count($headers);$i++)
			if(!preg_match("/\\SEEN/i",$headers[$i]["flags"])) $newmsgs++;
	
		for($i=$start_pos;$i<$end_pos;$i++) {
			$mnum = $headers[$i]["id"]; 
	
			$read = (preg_match("/\\SEEN/i",$headers[$i]["flags"]))?"true":"false";
			$readlink = "javascript:readmsg($i,$read)";
			$viewlink = "javascript:viewmsg($i,$read)"; // Added
			$composelink = "newmsg.php?lid=$lid&tid=$tid&folder=$folder&nameto=".htmlspecialchars($headers[$i]["from"][0]["name"])."&mailto=".htmlspecialchars($headers[$i]["from"][0]["mail"]);
			$composelinksent = "newmsg.php?lid=$lid&tid=$tid&folder=$folder&nameto=".htmlspecialchars($headers[$i]["to"][0]["name"])."&mailto=".htmlspecialchars($headers[$i]["to"][0]["name"]);
	
			$from = $headers[$i]["from"][0]["name"];
			$to = $headers[$i]["to"][0]["name"];
			$subject = $headers[$i]["subject"];
		   
		 	if ($read != "true") {
				$msg_img = "themes/$selected_theme/images/msg_unread.gif";
				
			} elseif (stristr($headers[$i]["flags"], '\\ANSWERED')) {
				$msg_img = "themes/$selected_theme/images/msg_answered.gif";
			
			} elseif (stristr($headers[$i]["flags"], '\\FORWARDED')) {	
			   $msg_img = "themes/$selected_theme/images/msg_forwarded.gif";
				
			} else {
				$msg_img = "themes/$selected_theme/images/msg_read.gif";
			}
			
			$prior = $headers[$i]["priority"];
			if($prior == 4 || $prior == 5)
				$img_prior = "<img src=\"themes/$selected_theme/images/prior_low.gif\" width=\"5\" height=\"11\" border=\"0\" alt=\"\">";
			elseif($prior == 1 || $prior == 2)
				$img_prior = "<img src=\"themes/$selected_theme/images/prior_high.gif\" width=\"5\" height=\"11\" border=\"0\" alt=\"\">";
			else
				$img_prior = "";
	
			$msg_img = "<img src=\"$msg_img\" width=\"14\" height=\"14\" border=\"0\" alt=\"\">";
			$checkbox = "<input type=\"checkbox\" name=\"msg_$i\" value=\"1\">";
			$attachimg = ($headers[$i]["attach"])?"<img src=\"themes/$selected_theme/images/attach.gif\" border=\"0\" alt=\"\">":"";
			$flaggedimg = (preg_match("/\\FLAGMSG/i",$headers[$i]["flags"]))?"<img src=\"themes/$selected_theme/images/flagged.gif\" border=\"0\" alt=\"\">":"";
			$date = $headers[$i]["date"];

			$BKMG = convert_BKMG($headers[$i]["size"]);
//			$size = "".ceil($headers[$i]["size"]/1024);
			$index = count($messagelist);
	
			$messagelist[$index]["read"] = $read;
			$messagelist[$index]["readlink"] = $readlink;
			$messagelist[$index]["viewlink"] = $viewlink; // Added
			$messagelist[$index]["composelink"] = $composelink;
			$messagelist[$index]["composelinksent"] = $composelinksent;
			$messagelist[$index]["from"] = $from;
			$messagelist[$index]["to"] = $to;
			$messagelist[$index]["subject"] = $subject;
			$messagelist[$index]["date"] = $date;
			$messagelist[$index]["statusimg"] = $msg_img;
			$messagelist[$index]["checkbox"] = $checkbox;
			$messagelist[$index]["attachimg"] = $attachimg;
			$messagelist[$index]["priorimg"] = $img_prior;
			$messagelist[$index]["flaggedimg"] = $flaggedimg;
			$messagelist[$index]["size"] = $BKMG['size'];
			$messagelist[$index]["unit"] = $BKMG['unit'];
		}
	
	} 
	
	$smarty->assign("umNumMessages",$nummsg);
	$smarty->assign("umNumUnread",$newmsgs);
	$smarty->assign("umMessageList",$messagelist);
	
	
	switch($folder) {
	case $sess["sysmap"]["inbox"]:
		$display = $inbox_extended;
		break;
	case $sess["sysmap"]["sent"]:
		$display = $sent_extended;
		break;
	case $sess["sysmap"]["trash"]:
		$display = $trash_extended;
		break;
	case $sess["sysmap"]["spam"]:
		$display = $spam_extended;
		break;
	default:
		$display = $folder;
	}
	
	$smarty->assign("umBoxName",$display);
	
	if($nummsg > 0) {
		if($pag > 1) $smarty->assign("umPreviousLink","messages.php?lid=$lid&tid=$tid&folder=$folder&pag=".($pag-1));
		for($i=1;$i<=ceil($nummsg / $reg_pp);$i++) 
			if($pag == $i) $navigation .= "<b>$i</b> ";
			else $navigation .= "<a href=\"messages.php?lid=$lid&tid=$tid&folder=$folder&pag=$i\" class=\"navigation\">$i</a> ";
		if($end_pos < $nummsg) $smarty->assign("umNextLink","messages.php?lid=$lid&tid=$tid&folder=$folder&pag=".($pag+1));
		$navigation .= " ($pag/".ceil($nummsg / $reg_pp).")";
	}
	
	$smarty->assign("umNavBar",$navigation);
	
	
	$avalfolders = Array();
	$d = dir($userfolder);
	while($entry=$d->read()) {
		if(	is_dir($userfolder.$entry) && 
			$entry != ".." && 
			$entry != "." && 
			substr($entry,0,1) != "_" && 
			$entry != $folder &&
			($UM->mail_protocol == "imap" || $entry != "inbox")) {
	
			//$entry = $UM->fix_prefix($entry,0);
	
			switch(strtolower($entry)) {
			case strtolower($sess["sysmap"]["inbox"]):
				$display = $inbox_extended;
				break;
			case strtolower($sess["sysmap"]["sent"]):
				$display = $sent_extended;
				break;
			case strtolower($sess["sysmap"]["trash"]):
				$display = $trash_extended;
				break;
			case strtolower($sess["sysmap"]["spam"]):
				$display = $spam_extended;
				break;
			default:
				$display = $entry;
				break;
			}
			$avalfolders[] = Array("path" => $entry, "display" => $display);
		}
	}
	$d->close();
	
	unset($UM);
	
// Set SMARTY variables for templates and display
	$smarty->assign("umAvalFolders",$avalfolders);
	
	
	$smarty->display("$selected_theme/"."message-list.htm");

?>
