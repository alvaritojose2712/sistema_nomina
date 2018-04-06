<?php
ini_set("display_errors", 1);

//defines
 
require('./inc/functions.php');

	if(!isset($ix) || !isset($pag)) redirect_and_exit("index.php?err=3", true);

	//$folderkey = base64_encode(strtolower($folder));
	$folderkey = base64_encode($folder);

	$mysess 		= $sess["headers"][$folderkey];
	$mail_info 		= $mysess[$ix];
	$arAttachment 	= Array();
	
	if(isset($attachment)) {
	
		$is_attached = true;
		$arAttachment 	= explode(",",$attachment);
	
		$UM->current_level = $arAttachment;
	
		$root = $mail_info;
		foreach($arAttachment as $item )
			if(is_numeric($item))
				$root = &$root["attachments"][$item];
	
		if( !is_array($root) || 
			!file_exists($root["filename"])) redirect_and_exit("index.php?err=3");
	
		$result = $UM->_read_file($root["filename"]);
	
	} else {
		$is_attached = false;
		$arAttachment = Array();
		if(!$UM->mail_connect()) {
			redirect_and_exit("index.php?err=1", true);
		}
		if(!$UM->mail_auth()) { redirect_and_exit("index.php?err=0"); }
	
		if(!($result = $UM->mail_retr_msg($mail_info,1))) { redirect_and_exit("messages.php?err=2&folder=".urlencode($folder)."&pag=$pag&refr=true"); }
		if($UM->mail_set_flag($mail_info,"\\SEEN","+")) {
			$sess["headers"][$folderkey][$ix] = $mail_info;
		}
	
		$UM->mail_disconnect(); 
	
	}

	// metas assigned to smarty
	$smarty->assign("pageMetas", $nocache);
	$UM->block_external_images = $prefs["block-images"];
	$UM->displayimages = $prefs["display-images"];
	$UM->sanitize = ($sanitize_html || !$allow_scripts);
	
	$email = $UM->Decode($result);
	
	if($ix > 0) {
	
		$umHavePrevious 	= 1;
		$umPreviousSubject 	= $mysess[($ix-1)]["subject"];
		$umPreviousLink 	= "readmsg.php?lid=$lid&tid=$tid&folder=".urlencode($folder)."&pag=$pag&ix=".($ix-1)."";
	
		$smarty->assign("umHavePrevious",$umHavePrevious);
		$smarty->assign("umPreviousSubject",$umPreviousSubject);
		$smarty->assign("umPreviousLink",$umPreviousLink);
	
	}
	
	if($ix < (count($mysess)-1)) {
		$umHaveNext 	= 1;
		$umNextSubject 	= $mysess[($ix+1)]["subject"];
		$umNextLink 	= "readmsg.php?lid=$lid&tid=$tid&folder=".urlencode($folder)."&pag=$pag&ix=".($ix+1)."";
		$smarty->assign("umHaveNext",$umHaveNext);
		$smarty->assign("umNextSubject",$umNextSubject);
		$smarty->assign("umNextLink",$umNextLink);
	}
	
	// message download link
	$smarty->assign("downloadLink", "download.php?folder=".urlencode($folder)."&ix=".$ix);
	
	$body	= 	$email["body"];
		
	if($UM->block_external_images) 
	$body = preg_replace("/(src|background)=([\"]?)(http[s]?:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_-]+)([\"]?)/i","\\1=\\2images/trans.gif\\4 original_url=\"\\3\"",$body);
	
	$redir_path = "link.php";	// why not just relative?? Now is relative (due to problems on https servers)! 

	
	
	
	$body = preg_replace("#target=[\"]?[a-zA-Z_]+[\"]?#i","target=\"blank\"",$body);
	$body = preg_replace("#href=\"http([s]?)://#i","target=\"_blank\" href=\"$redir_path?http\\1://",$body);
	$body = preg_replace("#href=\"mailto:#i","target=\"_top\" href=\"newmsg.php?to=",$body);
	
	// looking for browser type    --Todd's note: add check for safari??
	$uagent = 	$_SERVER["HTTP_USER_AGENT"];
	
	$ns4    = 	(preg_match("#Mozilla/4#",$uagent) && !preg_match("#MSIE#",$uagent) && !preg_match("#Opera#",$uagent) && !preg_match("#Chrome#",$uagent) && !preg_match("#Safari#",$uagent)&& !preg_match("#Gecko#",$uagent));
	$ns6moz = 	preg_match("#Gecko#",$uagent);
	$Opera = 	preg_match("#Opera#",$uagent);
	$ie4up  = 	preg_match("#MSIE (4|5|6|7|8|9)#",$uagent);
	$Safari = 	preg_match("#Safari#",$uagent);
	$Chrome = 	preg_match("#Chrome#",$uagent);
	
	$other	= 	(!$ns4 && !$ns6moz && !$ie4up && !$Opera && !$Safari && !$Chrome);
	
	
	// with no recognized browser display inline on the page
	if ($other) {
		
	
		if(preg_match("#<[ ]*body.*background[ ]*=[ ]*[\"']?([A-Za-z0-9._&?=:/{}%+-]+)[\"']?.*>#i",$body,$regs))
		$backimg = 	" background=\"".$regs[1]."\"";
		$smarty->assign("umBackImg",$backimg);
		if(preg_match("#<[ ]*body[A-Z0-9._&?=:/\"' -]*bgcolor=[\"']?([A-Z0-9#]+)[\"']?[A-Z0-9._&?=:/\"' -]*>#i",$body,$regs))
		$backcolor = " bgcolor=\"".$regs[1]."\"";
		$smarty->assign("umBackColor",$backcolor);
		$body = preg_replace("#a:(link|visited|hover)#",".".uniqid(""),$body);
		$body = preg_replace("#(body)[ ]?\\{#",".".uniqid(""),$body);
	
	}
	 

	// with ie4+/mozilla/ns6+/opera use iframe for display body  
	elseif($ie4up || $ns6moz|| $Opera|| $Safari) {
		$sess["currentbody"] = $body;;
		$body = "<iframe src=\"show_body.php?folder=".htmlspecialchars($folder)."&ix=$ix\" width=\"100%\" height=\"100%\" frameborder=\"0\"></iframe>";
	
	} 
	// with ns4 use ilayer
	elseif($ns4) {
		$sess["currentbody"] = $body;;
		$body = "<ilayer width=\"100%\" left=\"0\" top=\"0\">$body</ilayer>";
	}
	
	$smarty->assign("umMessageBody",$body);
	
	// look if the msg needs a receipt
	if ($email["receipt-to"]) {
		$smarty->assign("receiptRequired", true);
	}
	
	$ARFrom = $email["from"];
	$useremail = $sess["email"];
	
	// from
	$name = $ARFrom[0]["name"];
	$thismail = $ARFrom[0]["mail"];
	$ARFrom[0]["link"] = "newmsg.php?nameto=".urlencode($name)."&mailto=$thismail";
	$ARFrom[0]["title"] = "$name <$thismail>";
	
	$smarty->assign("umFromList",$ARFrom);
	
	// To
	$ARTo = $email["to"];
	
	for($i=0;$i<count($ARTo);$i++) {
		$name = $ARTo[$i]["name"];
		$thismail = $ARTo[$i]["mail"];
		$link = "newmsg.php?nameto=".urlencode($name)."&mailto=$thismail";
		$ARTo[$i]["link"] = $link;
		$ARTo[$i]["title"] = "$name <$thismail>";
		$smarty->assign("umTOList",$ARTo);
	}
	
	// CC
	$ARCC = $email["cc"];
	if(count($ARCC) > 0) {
		$smarty->assign("umHaveCC",1);
		for($i=0;$i<count($ARCC);$i++) {
			$name = $ARCC[$i]["name"];
			$thismail = $ARCC[$i]["mail"];
			$link = "newmsg.php?nameto=".urlencode($name)."&mailto=$thismail";
			$ARCC[$i]["link"] = $link;
			$ARCC[$i]["title"] = "$name <$thismail>";
		}
		$smarty->assign("umCCList",$ARCC);
	}
	
	$smarty->assign("umPageTitle",$email["subject"]);
	
	$umDeleteForm = "<input type=\"hidden\" name=\"decision\" value=\"move\">
	<input type=\"hidden\" name=\"folder\" value=\"".htmlspecialchars($folder)."\">
	<input type=\"hidden\" name=\"pag\" value=\"$pag\">
	<input type=\"hidden\" name=\"start_pos\" value=\"$ix\">
	<input type=\"hidden\" name=\"end_pos\" value=\"".($ix+1)."\">
	<input type=\"hidden\" name=\"msg_$ix\" value=\"X\">
	<input type=\"hidden\" name=\"back\" value=\"true\">";
	
	$umReplyForm = "
	<form name=\"msg\" action=\"newmsg.php\" method=\"post\">$forms
	<input type=\"hidden\" name=\"rtype\" value=\"reply\">
	<input type=\"hidden\" name=\"folder\" value=\"".htmlspecialchars($folder)."\">
	<input type=\"hidden\" name=\"ix\" value=\"$ix\">
	</form>";	// $forms inserts the standard inputs (lid, tid and sid)
	
	$smarty->assign("umDeleteForm",$umDeleteForm);
	$smarty->assign("umSpamForm",$umSpamForm);
	$smarty->assign("umReplyForm",$umReplyForm);
	$smarty->assign("umJS",$jssource);
	
	$smarty->assign("umSubject",$email["subject"]);
	$smarty->assign("umDate",$email["date"]);
	
$anexos = $email["attachments"];
$haveattachs = (count($anexos) > 0)?1:0;

if(count($anexos) > 0) {
	$root = &$mail_info["attachments"];

	foreach($arAttachment as $item ) {
		if(is_numeric($item)) {
			$root = &$root[$item]["attachments"];
		}
	}

	$root = $email["attachments"];
	$sess["headers"][$folderkey][$ix] = $mail_info;

	$nIndex = count($arAttachment);
	$attachAr = Array();

	for($i=0;$i<count($anexos);$i++) {

		$arAttachment[$nIndex] 	= $i;
		$link1 = "download.php?folder=$folder&ix=$ix&attach=".join(",",$arAttachment)."&tid=$tid&lid=$lid";
		$link2 = "$link1&down=1";

		if(!$anexos[$i]["temp"]) {
			if($anexos[$i]["content-type"] == "message/rfc822") 
				$anexos[$i]["normlink"]	= "<a href=\"javascript:openmessage('".join(",",$arAttachment)."')\">";
			else
				$anexos[$i]["normlink"] = "<a href=\"$link1\" target=\"_new\">";

			$anexos[$i]["downlink"] = "<a href=\"$link2\" target=\"_new\">";
			$anexos[$i]["size"] = ceil($anexos[$i]["size"]/1024);
			$anexos[$i]["type"] = $anexos[$i]["content-type"];
			$attachAr[] = $anexos[$i];
		}
	}
	$smarty->assign("umHaveAttachments",(count($attachAr) > 0));
	$smarty->assign("umAttachList",$attachAr);
	$smarty->assign("umNumAttach", count($attachAr));
}
	
	$SS->Save($sess);
	
	
	$avalfolders = Array();
	$d = dir($userfolder);
	while($entry=$d->read()) {
		if(	is_dir($userfolder.$entry) && 
			$entry != ".." && 
			$entry != "." && 
			substr($entry,0,1) != "_" && 
			$entry != $folder &&
			($UM->mail_protocol == "imap" || ($entry != "inbox"))) {
			$entry = $UM->fix_prefix($entry,0);
			switch(strtolower($entry)) {
			case "inbox":
				$display = $inbox_extended;
				break;
			case "spam":
				$display = $spam_extended;
				break;
			case "sent":
				$display = $sent_extended;
				break;
			case "trash":
				$display = $trash_extended;
				break;
			default:
				$display = $entry;
			}
			$avalfolders[] = Array("path" => $entry, "display" => $display);
	
		}
	}
	$d->close();
	unset($UM);
	
// Set SMARTY variables for templates and display
	$smarty->assign("umAvalFolders",$avalfolders);
	$smarty->assign("umFolder",$folder);
	$smarty->assign("umForms",$forms);
	
	if($is_attached)
		$smarty->display("$selected_theme/"."readmsg-popup.htm");
	else
		$smarty->display("$selected_theme/"."readmsg.htm");

?>
