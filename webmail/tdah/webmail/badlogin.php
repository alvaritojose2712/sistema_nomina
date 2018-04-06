<?php
ini_set("display_errors", 1);
// Time Zone fix for php 5.3 and above   
if(function_exists("date_default_timezone_set") and function_exists("date_default_timezone_get"))
@date_default_timezone_set(@date_default_timezone_get());
// load the configurations

	require("inc/config/config.uebimiau.php");
	require("inc/lib.php");
	
	require_once($SMARTY_DIR."Smarty.class.php");
	
	$smarty = new Smarty;
	
	$smarty->security=true;
	$smarty->secure_dir=array("./");
	$smarty->compile_dir = $temporary_directory."cached_templates";
	$smarty->template_dir =  './themes';
	$smarty->config_dir = substr("langs/",0,-1);
	$smarty->use_sub_dirs = true;


	$smarty->assign("umLanguageFile",$selected_language.".txt");
	$smarty->assign("umCompany",$company);
	$smarty->assign("umEmail",$f_email);
	
	$error = preg_replace("/\[\]/", "", $error);

// Log report	
	$blf = ($temporary_directory."system_admin/log.ucf");
	$date = date("F j, Y, H:i ");
	$line = "<span class=\"log_date\">$date</span><span class=\"log_bad\">$f_user from $company had a log in error.</span><br>\n";
	$file = fopen($blf, 'a+');
	fwrite($file, $line);
	fclose($file);
	
// Set SMARTY variables for templates and display
	$smarty->assign("umDocType",'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">');
	$smarty->assign("umServerResponse",$error);
	$smarty->assign("umLid",$lid);
	$smarty->assign("umTid",$selected_theme);
	$smarty->assign("umTPath",$selected_theme);			// Selected Theme path
	$smarty->assign("umSkin","default");				// No skin because not yet logged!
	
	$smarty->display("$selected_theme/"."bad-login.htm");
	

?>