<?php
ini_set("display_errors", 1);

// load session management

	require('./inc/functions.php');
	
	 if(!isset($_SESSION["um_session_data"]))
{
echo '<font color="red">You are not authorized to view this page </font>';
return;
}
	
// Check and create a new folder
	$newfolder = trim($newfolder);
	
	if ($newfolder != "" && 	preg_match("/[A-Za-z0-9 -]/",$newfolder) ) {
		if (!file_exists($userfolder.$newfolder)) 
			$fld_tmp = $UM->mail_create_box($newfolder);

		$smarty->assign("umOpt",$fld_tmp);
		$templatename = "folders-results.htm";
		$require_update = true;
		
	} else {
		$templatename = "folders.htm";
		$require_update = false;
	}
	
	
// Check and delete the especified folder: system folders can not be deleted
	if(	$delfolder != "" && 
		$delfolder != $sess["sysmap"]["inbox"] && 
		$delfolder != $sess["sysmap"]["sent"] && 
		$delfolder != $sess["sysmap"]["trash"] && 
		$delfolder != $sess["sysmap"]["spam"] && 
		preg_match("/[A-Za-z0-9 -]/",$delfolder) &&
		(strpos($delfolder,"..") === false)) {
	
	// Remove filters that direct messages to this deleted folder
		$filters = array();
		$newFilters = array();
		$deleted_filters = 0;
		$filename = $userfolder."_infos/filters.ucf";
		$myfile = $UM->_read_file($filename);
		if ($myfile != "") $filters = unserialize(base64_decode($myfile));

		for ($i=0; $i<count($filters); $i++) {
			if ( $filters[$i]["moveto"] != $delfolder) array_push($newFilters, $filters[$i]);
			else $deleted_filters++;
		} 
		$content = base64_encode(serialize($newFilters));
		$UM->_save_file($filename, $content);
		$smarty->assign("umNbFilterDel",$deleted_filters);

		if($UM->mail_delete_box($delfolder)) {
			//unset($sess["headers"][base64_encode($delfolder)]);
			$require_update = true;
			$smarty->assign("umOpt",2);
		} else 
			$smarty->assign("umOpt",3);
		$templatename = "folders-results.htm";
	}
	
// Prepare folder page otherwise go to the result page
	if ($templatename != "folders-results.htm") {
	
		if($require_update)	$sess["folders"] = $UM->mail_list_boxes() ;
		
		if(isset($empty)) {
			$headers = $sess["headers"][base64_encode($empty)];
			for($i=0;$i<count($headers);$i++) {
				$UM->mail_delete_msg($headers[$i],$prefs["save-to-trash"],$prefs["st-only-read"]);
				$expunge = true;
			}
			if($expunge) {
				$UM->mail_expunge();
				unset($sess["headers"][base64_encode($empty)]);
				/* ops.. you have sent anything to trash, then you need refresh it */
				if($prefs["save-to-trash"])
					unset($sess["headers"][base64_encode("trash")]);
				$SS->Save($sess);
			}
			// if(isset($goback)) redirect("process.php?folder=".urlencode($folder)."&lid=$lid&tid=$tid"); 	// Return to emptied folder
			if(isset($goback)) redirect("process.php?lid=$lid&tid=$tid&folder=".$sess["sysmap"]["inbox"]);	// Return to Inbox folder
			$require_update = true;
		}
		
		$boxes = $UM->mail_list_boxes();
		
		$scounter = 0;
		$pcounter = 0;
		
		$system = Array();
		$personal = Array();
		
		$totalused = 0;
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
		
			$delete = "";
		
			if(!in_array($entry, $sess["sysfolders"]))
				$delete = "folders.php?lid=$lid&tid=$tid&delfolder=$entry&folder=$folder";
		
			$boxname = $entry;
		
			if($unread != 0) $unread = "<b>$unread</b>";
		
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
				$system[$scounter]["name"]      	= $boxname;
				$system[$scounter]["msgs"]      	= count($thisbox)."/$unread";
				$system[$scounter]["del"]       	= $delete ;
				
				if ($boxsize == 0) {
					$system[$scounter]["boxsize"] 	= "-";
					$system[$scounter]["unit"] 		= "";
				} else {
					$BKMG = convert_BKMG($boxsize);
					$system[$scounter]["boxsize"] 	= $BKMG["size"];
					$system[$scounter]["unit"] 		= $BKMG["unit"];
				}
				$system[$scounter]["chlink"] 		= "process.php?lid=$lid&tid=$tid&empty=".$entry."&folder=".$entry;
				$system[$scounter]["emptylink"]		= "folders.php?lid=$lid&tid=$tid&empty=".$entry."&folder=".$entry;
		
				$scounter++;
			} else {
		
				$personal[$pcounter]["entry"]   	= $entry;
				$personal[$pcounter]["name"]    	= $boxname;
				$personal[$pcounter]["msgs"]    	= count($thisbox)."/$unread";
				$personal[$pcounter]["del"]    		= $delete ;
				
				if ($boxsize == 0) {
					$personal[$pcounter]["boxsize"] = "-";
					$personal[$pcounter]["unit"] 	= "";
				} else {
					$BKMG = convert_BKMG($boxsize);
					$personal[$pcounter]["boxsize"] = $BKMG["size"];
					$personal[$pcounter]["unit"] 	= $BKMG["unit"];
				}
				
				$personal[$pcounter]["chlink"]  	= "process.php?lid=$lid&tid=$tid&folder=".urlencode($entry);
				$personal[$pcounter]["emptylink"]	= "folders.php?lid=$lid&tid=$tid&empty=".urlencode($entry)."&folder=".urlencode($entry);
		
				$pcounter++;
			}
			$totalused += $boxsize;
		}
		
		$SS->Save($sess);
		$UM->mail_disconnect();
		unset($SS,$UM);
		array_qsort2 ($system,"name");
		
		if(!is_array($personal)) $personal = Array();
		
		$umFolderList = array_merge($system, $personal);
		$quota_enabled = ($quota_limit)?1:0;
		$smarty->assign("umQuotaEnabled",$quota_enabled);
		$usageGraph = get_usage_graphic(($totalused/1024),$quota_limit);
		$smarty->assign("umUsageGraph",$usageGraph);
		$noquota = (($totalused/1024) > $quota_limit)?1:0;
		$smarty->assign("umNoQuota",$noquota);
		
		$BKMG = convert_BKMG($quota_limit*1024);
		$smarty->assign("umQuotaLimit",$BKMG["size"]);
		$smarty->assign("umQuotaUnit",$BKMG["unit"]);
	
	} // end of folder page preparation
	
// Set SMARTY variables for templates and display
	$smarty->assign("pageMetas",$nocache);
	$smarty->assign("umForms",$forms);

	$smarty->assign("umFolderList",$umFolderList);
	$smarty->assign("umPersonal",$personal);
	
	$BKMG = convert_BKMG($totalused);
	$smarty->assign("umTotalUsed",$BKMG["size"]);
	$smarty->assign("umTotalUnit",$BKMG["unit"]);

	$smarty->display("$selected_theme/$templatename");

	
?>
