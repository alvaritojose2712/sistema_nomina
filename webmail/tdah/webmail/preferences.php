<?php
ini_set("display_errors", 1);

	require('./inc/functions.php');
	require("editors/preferences_editor.php");
// load filters
	$filename = $userfolder."_infos/filters.ucf";
	$myfile = $UM->_read_file($filename);
	$filters = array();
	
	if($myfile != "")  
			$filters = unserialize(base64_decode($myfile));

// we have to do something...
	if(isset($_POST['action'])) {
		$action = $_POST['action'];
		switch ($action) {
				
		case "savePrefs":
		// pick the new settings and save	
			$myprefs["skin"]                = $_POST['skin'];	
			$myprefs["real-name"]           = $_POST['real_name'];
			$myprefs["nick-name"]           = $_POST['nick_name'];
			$myprefs["reply-to"]            = $_POST['reply_to'];
			$myprefs["save-to-trash"]       = $_POST['save_trash'];
			$myprefs["save-to-spam"]        = $_POST['save_spam'];
			$myprefs["st-only-read"]        = $_POST['st_only_read'];
			$myprefs["empty-trash"]         = $_POST['empty_trash_on_exit'];
			$myprefs["unmark-read"]         = $_POST['unmark_read_on_exit'];
			$myprefs["save-to-sent"]        = $_POST['save_sent'];
			$myprefs["rpp"]                 = $_POST['rpp'];
			$myprefs["add-sig"]             = $_POST['add_sig'];
			$myprefs["signature"]           = str_replace("\\\"","\"",$_POST['sig']); //$_POST['sig'];
			$myprefs["timezone"]            = $_POST['timezone'];
			$myprefs["block-images"]        = $_POST['block_images'];
			$myprefs["display-images"]      = $_POST['display_images'];
			$myprefs["editor-mode"]         = $_POST['editor_mode'];
			$myprefs["refresh-time"]        = $_POST['refresh_time'];
			$myprefs["first-login"]         = 1;
			$myprefs["spamlevel"]           = $_POST['spamlevel'];
			$myprefs["require-receipt"]		= $_POST['require_receipt'];
			$myprefs["version"]             = $appversion;
			save_prefs($myprefs);
			unset($myprefs);
			$smarty->assign("message", "1");
		break;

		case "addFilter":
		// check for params
			if(!isset($_POST['filter_type']) ||
					!isset($_POST['filter_field']) ||
					!isset($_POST['filter_match']) ||
					!isset($_POST['filter_folder']))
					break;

		// set the folder only for move
			$destFolder = "";
			if(intval($_POST['filter_type']) == FL_TYPE_MOVE) {
				$destFolder = trim($_POST['filter_folder']);
			// Check if the user entered a valid folder
				if(!file_exists($userfolder.$destFolder))
				break;
			}
			
		// the matching string must not be empty
			$match = trim($_POST['filter_match']);
			if($match == "")
				break;

		// add the filter
			$newFilter =  array(
				"type"          => intval($_POST['filter_type']),
				"field"         => intval($_POST['filter_field']),
				"match"         => $match,
				"moveto"        => $destFolder
			);
			array_push($filters, $newFilter);

		// save the file
			$content = base64_encode(serialize($filters));
			$UM->_save_file($filename, $content);
		
			$smarty->assign("message", "4");
	
		break;

		case "delFilter":

			if (!isset($_POST['filters_array'])) {
				// nothing to delete
				break;
			}
			
			$delArray = $_POST['filters_array'];			
			
			$newFilters = array();
			for($i=0; $i<count($filters); $i++) {
				if(!in_array(strval($i), $delArray)) {
					array_push($newFilters, $filters[$i]);
				}	
			} 
			
			$filters = $newFilters;			
			
			// save the file
						$content = base64_encode(serialize($filters));
						$UM->_save_file($filename, $content);

			$smarty->assign("message", "5");			

						break;
		}
	}
	

	$smarty->assign("filterList", $filters);
	

// load prefs
	$prefs = load_prefs();
	
// name & reply to
	$smarty->assign("realName", $prefs["real-name"]);
	$smarty->assign("nickName", $prefs["nick-name"]);
	$smarty->assign("replyTo", $prefs["reply-to"]);
	$smarty->assign("umInputBody",$srcBody);
	

$sel_refreshtime = "<select name=f_refresh_time>\r";
for($i=5;$i<30;$i=$i+5) {
	$selected = ($prefs["refresh-time"] == $i)?" selected":"";
	$sel_refreshtime .= "<option value=".$i.$selected.">".$i."\r";
}
$sel_refreshtime .= "</select>";

// NEW Timezone list
 $gmttime = time()-date("Z");
	$tmp = explode("|",$timezone_city); $tz=0; $j=0;
	$timeVals = array(); foreach ($tmp as $data) $cities[$tz++] = $data;
	for($i=0; $i<$tz; $i=$i+3) {
		$nowgmt = $gmttime + $cities[$i]*3600;
		$operator = ($cities[$i] < 0)?"-":"+";
		$z = abs($cities[$i]);
		$diff = $operator . sprintf("%02d",intval($z)) . sprintf("%02d",($z-intval($z))*60);
		$timeVals[$diff] = "GMT " .$diff. " (" .date($date_timeformat,$nowgmt). ") ".substr($cities[$i+1],0,40);
		if (strlen($cities[$i+1]) > 50) $timeVals[$diff] .= "...";
		$tm_cities[$diff] = $cities[$i+2];
	}
	
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
	
	$smarty->assign("umAvalFolders",$avalfolders);
	
// Needed to take into account the recent changes (Skin, textmode)
	$smarty->assign("umSkin", $prefs["skin"]);
	
	$prevshow_advanced = $show_advanced;
	$show_advanced = ($prefs["editor-mode"] != "text") ? ($prefs["editor-mode"] != "html") ? 2 : 1 : 0 ;
	if ($prevshow_advanced != $show_advanced) { redirect("preferences.php?&lid=$lid&tid=$tid"); exit; }	// We have changed textmode -> reload
	
	$smarty->assign("timezone", $prefs["timezone"]);
	$smarty->assign("timezoneVals", $timeVals);
	
	// editor mode
	$smarty->assign("editorMode", $prefs["editor-mode"]);
	
	// records per page
	$smarty->assign("msgPerPage", $prefs["rpp"]);
	$smarty->assign("msgPerPageVals", array(10,15,20,21,22,23,24,25,26,27,28,29,30,40,50,100,200));
	
	// refresh time
	$smarty->assign("refreshTime", $prefs["refresh-time"]); 
	$smarty->assign("refreshTimeVals", array(1,2,3,4,5,10,15,20,25,30,60));
	
	// signature 
	$status = ($prefs["add-sig"])? true:false;
	$smarty->assign("addSignature",$status);
	
	$txtsignature = htmlspecialchars($prefs["signature"]);
	$smarty->assign("signature", $txtsignature);
	
	// misc
	$status = ($prefs["save-to-trash"])? true:false;
	$smarty->assign("saveTrash",$status);
	
	$status = ($prefs["save-to-spam"])? true:false;
	$smarty->assign("saveSpam",$status);
	
	$status = ($prefs["st-only-read"])? true:false;
	$smarty->assign("saveTrashOnlyRead",$status);
	
	$status = ($prefs["empty-trash"])? true:false;
	$smarty->assign("emptyTrashOnExit",$status);
	
	$status = ($prefs["unmark-read"])? true:false;
	$smarty->assign("unmarkReadOnExit",$status);
	
	$status = ($prefs["save-to-sent"])? true:false;
	$smarty->assign("saveSent",$status);
	
	$status = ($prefs["block-images"])? true:false;
	$smarty->assign("blockImages",$status);
	
	
	$status = ($prefs["display-images"])? true:false;
	$smarty->assign("displayImages",$status);
	
	$status = ($prefs["require-receipt"])? true:false;
	$smarty->assign("requireReceipt",$status);
	
	// Set SMARTY variables for templates and display
	$smarty->assign("umForms",$forms);
	
	$smarty->assign("umVersion",SW_VERSION);
	$smarty->display("$selected_theme/"."preferences.htm");

?>
