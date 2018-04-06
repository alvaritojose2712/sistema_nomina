<?php
ini_set("display_errors", 1);
	require('./inc/functions.php');

// Reset all Smarty and restarts to avoid click on dead links.
	require_once(SMARTY_DIR."Smarty.class.php");
	
	$smarty = new Smarty;
	
	$smarty->security=true;
	$smarty->secure_dir=array("./");
	$smarty->compile_dir = $temporary_directory."cached_templates";
	$smarty->template_dir =  "themes/";
	$smarty->config_dir = substr("langs/",0,-1);
	$smarty->use_sub_dirs = true;
	
	$smarty->assign("umLanguageFile",$selected_language.".txt");
	$smarty->assign("umCompany",$company);
	$smarty->assign("umEmail",$f_email);	

// Log report	
	$blf = $temporary_directory."system_admin/log.ucf";
	$date = date("F j, Y, H:i ");
	$line = "<span class=\"log_date\">$date</span><span class=\"log_bad\">$f_user from $company had an error.</span><br>\n";
	$file = fopen($blf, 'a+');
	fwrite($file, $line);
	fclose($file);
	
	$phpver = phpversion();
	$phpver = doubleval($phpver[0].".".$phpver[2]);
	
	if($phpver >= 4.1) {
		extract($_GET);
	}
	
// Set SMARTY variables for templates and display
	$smarty->assign("umDocType",DOC_TYPE);
	$smarty->assign("umLid",$lid);
	$smarty->assign("umTid",$selected_theme);
	$smarty->assign("umTPath",$selected_theme);
	$smarty->assign("umSid",$sid);

	$prefs = load_prefs();
	$smarty->assign("umSkin", $prefs["skin"]);

	$smarty->assign("umJS",$jssource);
	$smarty->assign("umErrorCode",$err);
	
	$smarty->display("$selected_theme/"."error.htm");
	
?>