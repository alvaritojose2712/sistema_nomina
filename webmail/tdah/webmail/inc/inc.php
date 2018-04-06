<?php
ini_set("display_errors", 1);

// Time Zone fix for php 5.3 and above   
if(function_exists("date_default_timezone_set") and function_exists("date_default_timezone_get"))
@date_default_timezone_set(@date_default_timezone_get());


// error_reporting (E_ALL );
	@set_time_limit(0);
	session_start();
	session_name('sid');
	$sid = session_id();
	
	require("./inc/config/config.uebimiau.php");
	require("inc/class/class.uebimiau.php");
	require("inc/lib.php");
	require_once($SMARTY_DIR."Smarty.class.php");

	$smarty = new Smarty;
	$smarty->security=true;
	$smarty->secure_dir=array("./");
	$smarty->compile_dir = $temporary_directory.'cached_templates';
	$smarty->template_dir =  "themes/";
	$smarty->config_dir = ("langs/");
	$smarty->use_sub_dirs = true;
	
	$SS = New Session();
	$SS->temp_folder = $temporary_directory;
	$SS->sid       = $sid;
	$SS->timeout 	 = $idle_timeout;
	
	$sess = $SS->Load();
	if(!array_key_exists("start",$sess)) $sess["start"] = time();
	$start = $sess["start"];
	$smarty->assign("umLanguageFile",$selected_language.".txt");

// Lo - Add locales for internationalization
	setlocale(LC_ALL, $languages[$lid]['locale']);
	
	$syslib = "./inc/config/config.system.php";
	$smarty->assign("umSyslib",$syslib);
		
// Assign to smarty the paths for included dynamic templates
	include("./inc/config/config.template.php");	
	
	$UM = new UebiMiau();
	
	if(isset($f_pass) && strlen($f_pass) > 0) {
	
		switch(strtoupper($mail_server_type)) {
	
		case "DETECT":
			$f_server 	= strtolower(getenv("HTTP_HOST"));
			$f_server 	= str_replace($mail_detect_remove,"",$f_server);
			$f_server 	= $mail_detect_prefix.$f_server;
	
			if(preg_match("/(.*)@(.*)/",$f_email,$regs)) {
				$f_user = $regs[1];
				$domain = $regs[2];
				if($mail_detect_login_type != "") $f_user = preg_replace("/%user%/i",$f_user,preg_replace("/%domain%/i",$domain,$mail_detect_login_type));
			}
	
			$f_protocol	= $mail_detect_protocol;
			$f_port		= $mail_detect_port;
			$f_prefix	= $mail_detect_folder_prefix;
			$f_profile	= "DETECT";
	
			break;
	
		case "ONE-FOR-EACH": 
			$domain 	= $mail_servers[$six]["domain"];
			$f_email 	= $f_user."@".$domain;
			$f_server 	= $mail_servers[$six]["server"];
			$login_type = $mail_servers[$six]["login_type"];
	
			$f_protocol	= $mail_servers[$six]["protocol"];
			$f_port		= $mail_servers[$six]["port"];
			$f_prefix	= $mail_servers[$six]["folder_prefix"];
			$f_profile	= $mail_servers[$six]["profile"];

			if($login_type != "") $f_user = preg_replace("/%user%/i",$f_user,preg_replace("/%domain%/i",$domain,$login_type));
			break;
	
		case "ONE-FOR-ALL": 
			if(preg_match("/(.*)@(.*)/",$f_email,$regs)) {
				$f_user = $regs[1];
				$domain = $regs[2];
				if($one_for_all_login_type != "") $f_user = preg_replace("/%user%/i",$f_user,preg_replace("/%domain%/i",$domain,$one_for_all_login_type));
			}
			$f_server = $default_mail_server;
	
			$f_protocol	= $default_protocol;
			$f_port		= $default_port;
			$f_prefix	= $default_folder_prefix;
			$f_profile	= "ONE-FOR-ALL";
			break;
		}
	
		$UM->mail_email 	= $sess["email"]  			= stripslashes($f_email);
		$UM->mail_user 		= $sess["user"]   			= stripslashes($f_user);
		$UM->mail_pass 		= $sess["pass"]   			= stripslashes($f_pass); 
		$UM->mail_server 	= $sess["server"] 			= stripslashes($f_server); 
	
		$UM->mail_port 		= $sess["port"] 			= intval($f_port); 
		$UM->mail_protocol	= $sess["protocol"] 		= strtolower($f_protocol); 
		$UM->mail_protocol	= $sess["protocol"] 		= strtolower($f_protocol); 
		$UM->mail_profile	= $sess["profile"] 			= $f_profile; 
		
		$sess['remote_ip'] = $_SERVER['REMOTE_ADDR'];
		
		$refr = 1;
	
	} elseif (
	
		($sess["auth"] && intval((time()-$start)/60) < $idle_timeout)
		&& $require_same_ip && ($sess["remote_ip"] == $_SERVER['REMOTE_ADDR'])
		) {
	
		$UM->mail_user   	= $f_user    	= $sess["user"];
		$UM->mail_pass   	= $f_pass    	= $sess["pass"];
		$UM->mail_server 	= $f_server  	= $sess["server"];
		$UM->mail_email  	= $f_email   	= $sess["email"];
	
		$UM->mail_port 		= $f_port 		= $sess["port"]; 
		$UM->mail_protocol	= $f_protocol	= $sess["protocol"]; 
		$UM->mail_prefix	= $f_prefix 	= $sess["folder_prefix"]; 
		$UM->mail_profile	= $f_profile	= $sess["profile"]; 

	} else {
		redirect("./index.php?lid=$lid&tid=$tid"); 
		exit; 
	}
	$sess["start"] = time();
	
	$SS->Save($sess);
	
	
	$userfolder = $temporary_directory.preg_replace("/[^a-z0-9\._-]/","_",strtolower($f_user))."_".strtolower($f_server)."/";
	
	$UM->debug				= $enable_debug;
	$UM->use_html			= $allow_html;
	
	$UM->user_folder 		= $userfolder;
	$UM->temp_folder		= $temporary_directory;
	$UM->timeout			= $idle_timeout;
	
	
	$prefs = load_prefs();
	
	$UM->timezone			= $prefs["timezone"];
	$UM->charset			= $default_char_set;
	

	/*
	
	Don't remove the following lines, or you will be problems with browser's cache 
	*/
	
	header("cache-Control: no-cache, must-revalidate"); 
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
	
	
	$nocache = "
	<meta http-equiv=\"Cache-Control\" content=\"no-cache\">
	<meta http-equiv=\"Expires\" content=\"-1\">";
	
	// Sort rules
	// Common js included system-wide
	$commonJS = "
	<script type=\"text/javascript\" src=\"./inc/js/prototype.js\"></script>
	<script type=\"text/javascript\" src=\"./inc/js/common.js\"></script>
	<script type=\"text/javascript\" src=\"./inc/js/functions.js\"></script>
	";
	
	// Sort rules
	
	if(!isset($sortby) || !preg_match("/(from|name|subject|date|size)/",$sortby)) {
		if(array_key_exists("sort-by",$prefs) && preg_match("/(from|name|subject|date|size)/",$prefs["sort-by"]))
			$sortby = $prefs["sort-by"];
		else
			$sortby = $default_sortby;
	} else {
		$need_save = true;
		$prefs["sort-by"] = $sortby;
	}
	
	if(!isset($sortorder) || !preg_match("/ASC|DESC/",$sortorder)) {
		if(array_key_exists("sort-order",$prefs) && preg_match("/ASC|DESC/",$prefs["sort-order"]))
			$sortorder = $prefs["sort-order"];
		else
			$sortorder = $default_sortorder;
	} else {
		$need_save = true;
		$prefs["sort-order"] = $sortorder;
	}
	
	if(isset($need_save)) save_prefs($prefs);
	
	if(is_array($sess["sysmap"])) 
		while(list($key, $value) = each($sess["sysmap"]))
			if(strtolower($folder) == $key)
				$folder = $value;
	
	 if(!isset($folder) || $folder == "" || strpos($folder,"..") !== false ) {
	$folder = $sess["sysmap"]["inbox"];
	
	} elseif (!file_exists($userfolder.$folder)) { 
		redirect("./logout.php?lid=$lid&tid=$tid"); 
		exit; 
	}
	
// Add number of addressbook entries
	$myfile = $UM->_read_file($userfolder.DB_ADRESSBOOK);
	if($myfile != "")
			$addressbook = unserialize(base64_decode($myfile));
	$smarty->assign("umAddrEntry",count($addressbook));
	$smarty->assign("umDocType",DOC_TYPE);

// Set SMARTY variables for templates 
	if(!isset($textmode)) $textmode = null;
	$show_advanced = ((!$textmode) && ($prefs["editor-mode"] != "text")) ? ((!$textmode) && ($prefs["editor-mode"] != "html")) ? 2 : 1 : 0 ;
	$smarty->assign("umAdvancedEditor",$show_advanced);

	$smarty->assign("umSid",$sid);						// Session identification
	$smarty->assign("umLid",$lid);						// Selected language
	$smarty->assign("umTid",$tid);						// Selected Theme
	$smarty->assign("umTPath",$selected_theme);			// Selected Theme path
	$smarty->assign("umRPath",$root_path);			// webroot
	$smarty->assign("umSkin", $prefs['skin']);			// Selected skin
	$smarty->assign("umTitle", $title);
	$smarty->assign("umUser",$f_user);					// Set User name
	$smarty->assign("umCompany",$company);				// Set Company name
	if (strtoupper($mail_server_type) == "ONE-FOR-EACH") 
		$smarty->assign("umDomain",$f_profile);			// Set Mail Protocol
	$smarty->assign("umUserEmail",$sess["email"]);		// Set E-mail address

	$forms = "
	<input type=\"hidden\" name=\"lid\" value=\"$lid\">
	<input type=\"hidden\" name=\"sid\" value=\"$sid\">
	<input type=\"hidden\" name=\"tid\" value=\"$tid\">";

?>
