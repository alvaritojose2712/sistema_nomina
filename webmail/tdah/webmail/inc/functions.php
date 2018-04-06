<?php
ini_set("display_errors", 1);
 	
	
	require("./inc/inc.php");
	
	require("inc/folder_list.php");
 
	$jsquota = (!$quota_limit) ? "false" : ((ceil($totalused/1024) >= $quota_limit) ? "true" : "false");

// Add common.js, funtions.js and prototype.js
	$jssource = $commonJS;

// Set the JS variables for functions.js
	$jssource .= "
	<script type=\"text/javascript\" language=\"javascript\">
	//<![CDATA[
		var js_pag = '$pag';
		var js_tid = '$tid';
		var js_lid = '$lid';
		var js_ix = '$ix';
		var js_folder = '$folder';
		var js_encode_folder = '".urlencode($folder)."';
		var sort_colum = '$sortby';
		var sort_order = '$sortorder';
		var no_quota  = $jsquota;
		var js_sysmap_trash = '".$sess["sysmap"]["trash"]."';
		var js_sysmap_spam = '".$sess["sysmap"]["spam"]."';
		var js_confirm_delete = '".preg_replace("/'/","\\'",$confirm_delete)."';
		var js_confirm_spam = '".preg_replace("/'/","\\'",$confirm_spam)."';
		var js_confirm_delfilter = '".preg_replace("/'/","\\'",$prf_delfilter)."';
		var js_error_invalid_name = '".preg_replace("/'/","\\'",$error_invalid_name)."';
		var quota_msg = '".preg_replace("/'/","\\'",$quota_exceeded)."';
		var photo_msg = '".preg_replace("/'/","\\'",$adr_photo_msg)."';
	";
	// JS variables specific for New message
	$jssource .= "
		var bsig_added = false;
		var bIs_html = '$js_advanced';
		var js_error_no_recipients = '".preg_replace("/'/","\\'",$error_no_recipients)."';
		var js_error_compose_invalid_mail1_s = '".preg_replace("/'/","\\'",$error_compose_invalid_mail1_s)."';
		var js_error_compose_invalid_mail2_s = '\\r".preg_replace("/'/","\\'",$error_compose_invalid_mail2_s)."';
		var js_error_compose_invalid_mail1_p = '".preg_replace("/'/","\\'",$error_compose_invalid_mail1_p)."';
		var js_error_compose_invalid_mail2_p = '\\r".preg_replace("/'/","\\'",$error_compose_invalid_mail2_p)."';
	//]]>
	</script>";


// Convert bytes size into Bytes/KBytes/MBytes/GBytes (return an Array)
// Use ISO convetion that are: k=kilo, M=mega, G=giga
	function convert_BKMG($flt_size) {
		$data = Array();
		if ( $flt_size > 1024) {
			$flt_size /=1024;
				if ( $flt_size > 1024) {
					$flt_size /=1024;
					if ( $flt_size > 1024) {
						$flt_size /=1024;
						if ($flt_size < 10) $data["size"] = round($flt_size, 1);
							else $data["size"] = ceil($flt_size);
						$data["unit"] = "G";
					} else {
						if ($flt_size < 10) $data["size"] = round($flt_size, 1);
							else $data["size"] = ceil($flt_size);
						$data["unit"] = "M";
					}
				} else {
					if ($flt_size < 10) $data["size"] = round($flt_size, 1);
						else $data["size"] = ceil($flt_size);
					$data["unit"] = "k";
				}
		} else {
			$data["size"] = ceil($flt_size);
			$data["unit"] = "";
		}
		return $data;
	}

	$smarty->assign("umJS",$jssource);			// JS call and variables

	// Number of users on the Chat
	//$smarty->assign("umLines",(file_exists($temporary_directory.DB_CHAT_ONLINE) && (filesize ($temporary_directory.DB_CHAT_ONLINE) > 0) ? count(file($temporary_directory.DB_CHAT_ONLINE)) : 0));

?>
