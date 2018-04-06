<?php
ini_set("display_errors", 1);
// Time Zone fix for php 5.3 and above   
if(function_exists("date_default_timezone_set") and function_exists("date_default_timezone_get"))
@date_default_timezone_set(@date_default_timezone_get());
// Bootstrap for install
 
  require_once("./inc/config/config.paths.php");
	require("inc/config/config.uebimiau.php");
	 
// Time Zone fix for php 5.3 and above   
if(function_exists("date_default_timezone_set") and function_exists("date_default_timezone_get"))
@date_default_timezone_set(@date_default_timezone_get());
	


// Standard start
	require("inc/lib.php");
	require_once($SMARTY_DIR."Smarty.class.php");
	
	$smarty = new Smarty;
	$smarty->security=false;
	$smarty->secure_dir=array("./");
	$smarty->compile_dir = $temporary_directory.'cached_templates';
	$smarty->template_dir =  "themes/";
	$smarty->config_dir = substr("langs/",0,-1);
	$smarty->use_sub_dirs = false;
	$smarty->assign("umLanguageFile",$selected_language.".txt");
	$smarty->assign("umCompany",$company);
	$smarty->assign("umEmail",$f_email);
	$smarty->debugging = $enable_debug;
	$smarty->assign("umServerType",strtoupper($mail_server_type));
	
	$syslib = "./inc/config/config.system.php";
	$smarty->assign("umSyslib",$syslib);
	
// Assign to smarty the paths for included dynamic templates
	include("./inc/config/config.template.php");	
	


  if (!file_exists($temporary_directory."cached_templates")) mkdir($temporary_directory."cached_templates");
 	
	
	switch(strtoupper($mail_server_type)) {
		case "DETECT": 
			break;

		case "ONE-FOR-EACH":
	
			$aval_servers = count($mail_servers);
			$smarty->assign("umAvailableServers",$aval_servers);
			
			if(!$aval_servers) die("<br><br><br><div align=\"center\"><h3>$atleastserver</h3>"._GO_ADMIN."</div>");
			if ($aval_servers == 1) {
				$strServers = "@".$mail_servers[0]["domain"]." <input type=\"hidden\" name=\"six\" value=\"0\">";
			} else {
				$strServers = "<select class=\"textbox\" name=\"six\">\r";
				for($i=0;$i<$aval_servers;$i++) {
					$sel = ($i == $six)?" selected":"";
					$strServers .= "<option value=\"$i\" $sel>@".$mail_servers[$i]["profile"]."\r";
				}
				$strServers .= "</select>\r";
			}
	
			$smarty->assign("umServer",$strServers);
			break;
		
		case "ONE-FOR-ALL":	
			break;

		default:
			die("<br><br><br><div align=\"center\"><h3>$modeserverunknow</h3>"._GO_ADMIN."</div>");
	}

	$jssource = "
	<script type=\"text/javascript\" language=\"javascript\">
	if (parent.document.location != document.location) parent.document.location.reload();
	</script>";
	
	$smarty->assign("umUser",$f_user);
	$smarty->assign("umPass",$f_pass);
	$smarty->assign("umJS",$jssource);
	
	$avallangs = count($languages);
	if($avallangs == 0) die("<br><br><br><div align=\"center\"><h3>$atleastlanguage</h3>"._GO_ADMIN."</div>");
	
	
	$avalthemes = count($themes);
	if($avalthemes == 0) die("<br><br><br><div align=\"center\"><h3>$atleasttheme</h3>"._GO_ADMIN."</div>");
	
	$smarty->assign("umAllowSelectLanguage",$allow_user_change_language); 
	$func($textout);
	
	// Prepare droplist for languages
	if ($allow_user_change_language) {
		$def_lng = (is_numeric($lid)) ? $lid : $default_language;
		$langsel = "<select class=\"textbox\" name=\"lng\" onChange=\"selectLanguage();\">\r";
		foreach($languages as $key => $lang) {
			$selected = ($lid == $key)?" selected":"";
			$langsel .= "<option value=\"$key\"$selected>".$lang["name"]."\r";
		}
		$langsel .= "</select>\r";
		$smarty->assign("umLanguages",$langsel);
	}
	
	$smarty->assign("umAllowSelectTheme",$allow_user_change_theme);
	
	
	// Prepare droplist for themes
	if($allow_user_change_theme) {
		$def_tem = (is_numeric($tid))?$tid:$default_theme;
		$themsel = "<select name=\"tem\" onChange=\"selectLanguage();\">\r";
		foreach($themes as $key => $theme) {
			$selected = ($tid == $key)?" selected":"";
			$themsel .= "<option value=\"$key\"$selected>".$theme["name"]."\r";
		}
		$themsel .= "</select>\r";
		$smarty->assign("umThemes", $themsel);
	}
	

// Set SMARTY variables for templates and display
	$smarty->assign("umLid",$lid);						// Selected language
	$smarty->assign("umTid",$tid);						// Selected Theme
	$smarty->assign("umTPath",$selected_theme);			// Selected Theme path
	$smarty->assign("umSid",$sid);						// Session identification
	$smarty->assign("umSkin","default");				// No skin because not yet logged!

	$smarty->assign("umVersion",SW_VERSION);
	$smarty->assign("umDocType",DOC_TYPE);

	$smarty->display("$selected_theme/"."login.htm");
 
?>