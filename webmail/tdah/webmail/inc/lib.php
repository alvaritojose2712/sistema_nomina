<?php
ini_set("display_errors", 1);

	
	class ErrorHandler {
	
		var $_errorflags = null;
		var $_handlerflags = null;
	
		function ErrorHandler() {
			$this->_errorflags = E_ALL & ~E_NOTICE;
			$this->_handlerflags = E_ALL & ~E_ERROR;
		}
	
		function setHandlerFlags($Flags) {
			$this->_handlerflags = $Flags;
		}
		
		function setErrorFlags($Flags) {
			$this->_errorflags = $Flags;
		}
	
		function _FatalErrorHandler ($buffer) {
			if (preg_match("/(error<\/b>:)(.+)(<br)/i", $buffer, $regs) ) {
				$err = preg_replace("/<.*?>/","",$regs[2]);
				preg_match('/^(.+) in (.+) on line ([0-9]+)/', $err, $regs);
				$errno = E_ERROR; $errstr = $regs[1]; 
				$errfile = $regs[2]; $errline = $regs[3];
	
				return '<hr size=\"1\">FATAL ('.$errno.'): '.$errstr.' ('.str_replace($_SERVER['DOCUMENT_ROOT'],'',$errfile).':'.$errline.')'.'<hr size=1>';
			}
			return $buffer;
		}
	
		function _NormalErrorHandler ($errno, $errstr, $errfile, $errline) {
			if(error_reporting() == 0) return false;
			if($errno & $this->_errorflags ) {
				@ob_end_flush();
				echo '<hr size=\"1\">ERROR ('.$errno.'): '.$errstr.' ('.str_replace($_SERVER['DOCUMENT_ROOT'],'',$errfile).':'.$errline.')'.'<hr size=1>';
				exit(0);
			}
		}
	
		function Listen() {
			if ($this->_handlerflags & E_ERROR) 
				ob_start(array(&$this, '_FatalErrorHandler'));
			if ($this->_handlerflags & E_WARNING)
				set_error_handler(array(&$this, '_NormalErrorHandler'));
			error_reporting($this->_errorflags);
		}
	}
	
	/*
	flags that will be HANDLED, otherwise will be raised to output
	handling E_ERROR causes a bit of cpu usage, if you think your 
	enviroment is stable, disable it to gain performance
	*/
	$handler_flags = E_ALL & ~E_ERROR & ~E_NOTICE; 
	/*
	flags that will be raised by the PHP engine
	*/
	$error_flags = E_ALL & ~E_NOTICE; 
	
	$Err = new ErrorHandler();
	$Err->setHandlerFlags($handler_flags);
	$Err->setErrorFlags($error_flags);
	$Err->Listen();
	
	$phpver = phpversion();
	$phpver = doubleval($phpver[0].".".$phpver[2]);
	
	if($phpver >= 4.1) {
		extract($_POST,EXTR_SKIP);
		extract($_GET,EXTR_SKIP);
		extract($_SERVER,EXTR_SKIP);
		extract($_FILES);
		$ENV_SESSION = $_SESSION;
	} else {
		function array_key_exists($key,&$array) {
			reset($array);
			while(list($k,$v) = each($array)) {
				if($k == $key) {
					reset($array);
					return true;
				}
			}
			reset($array);
			return false;
		}
		$ENV_SESSION = $HTTP_SESSION_VARS;
	}
	
	if(isset($f_pass) && strlen($f_pass) > 0) {
	
		if($allow_user_change_theme) {
			if($tem != "") $tid = $tem;
			else { $tid = $default_theme; }
		} else
			$tid = $default_theme;
	
		if($allow_user_change_language) {
			if($lng != "") $lid = $lng;
			else { $lid = $default_language; }
		} else
			$lid = $default_language;
	}
	
	if(!$themes[$tid]) $tid = $default_theme;
	if(!$languages[$lid]) $lid = $default_language;
	
	
	$selected_theme 	= $themes[$tid]["path"];
	if (!$selected_theme) 
		die("<br><br><br><div align=\"center\"><h3>Invalid theme, configure your \$default_theme in -config.php-<br>Please run <a href=\"admin/install/index.php?lid=$lid\">Install</a></h3></div>");
	$selected_language 	= $languages[$lid]["path"];
	if (!$selected_language) 
		die("<br><br><br><div align=\"center\"><h3>Invalid language, configure your \$default_language in -config.php-<br>Please run <a href=\"admin/install/index.php?lid=$lid\">Install</a></h3></div>");
		
	function simpleoutput($p1) { printf($p1); }
	
	$func = strrev("tuptuoelpmis");
	
	function get_usage_graphic($used,$aval) {
		
		global $selected_theme;
		
		if($used >= $aval) {
			$redsize = 100;
			$graph = "<img src=\"themes/$selected_theme/images/red.gif\" height=\"10\" width=\"$redsize\">";
		} elseif($used == 0) {
			$greesize = 100;
			$graph = "<img src=\"themes/$selected_theme/images/green.gif\" height=\"10\" width=\"$greesize\">";
		} else  {
			$usedperc = $used*100/$aval;
			$redsize = ceil($usedperc);
			$greesize = ceil(100-$redsize);
			$red = "<img src=\"themes/$selected_theme/images/red.gif\" height=\"10\" width=\"$redsize\">";
			$green = "<img src=\"themes/$selected_theme/images/green.gif\" height=\"10\" width=\"$greesize\">";
			$graph = $red.$green;
		}
		return $graph;
	}
	
	function redirect($location) {
		global $enable_debug;
	
		if($enable_debug) {
			echo("<hr><br><strong><font color=\"red\">Debug enabled:</font></strong> <br><br><h3>".
				 "Click here to display the page <a href='$location/'>$location</a></h3><br><br><br><br>");
			exit;
		} else {
			Header("Location: $location");
		}
	}
	
	function redirect_and_exit($location) { 
		redirect($location); 
	}
	
	function array_qsort2 (&$array, $column=0, $order="ASC") {
		$oper = ($order == "ASC")?">":"<";
		if(!is_array($array)) return;
		usort($array, create_function('$a,$b',"return (\$a['$column'] $oper \$b['$column']);")); 
		reset($array);
	}
	
	function dump($str) {
		echo '<pre>'.htmlspecialchars(print_r($str, true)).'</pre>';
		flush();
	}
	
	class Session {
	
		var $temp_folder;
		var $sid;
		var $timeout = 0;
		var $_sess = null;
		
		function Session() {
			global $phpver;
			if($phpver >= 4.1) {
				$this->_sess =& $_SESSION;
			} else {
				$this->_sess =& $HTTP_SESSION_VARS;
			}
		}
		function Load() {
			if(!is_array($this->_sess['um_session_data']))
				$this->_sess['um_session_data'] = Array();
			return $this->_sess['um_session_data'];
		}
	
		function Save(&$array2save) {
			$this->_sess['um_session_data']	= $array2save;
		}
		function Kill() {
			@session_destroy();
			$_SESSION = Array();
		}
	}
	
	
	function load_prefs() {
	
		global 	$userfolder,
				$sess,
				$default_preferences;
	
		extract($default_preferences);
	
		$pref_file = $userfolder."_infos/prefs.upf";
	
		if(!file_exists($pref_file)) {
			$prefs["real-name"]     = UCFirst(substr($sess["email"],0,strpos($sess["email"],"@")));
			$prefs["reply-to"]      = $sess["email"];
			$prefs["save-to-trash"] = $send_to_trash_default;
			$prefs["save-to-spam"]  = $send_to_spam_default;
			$prefs["st-only-read"]  = $st_only_ready_default;
			$prefs["empty-trash"]   = $empty_trash_default;
			$prefs["save-to-sent"]  = $save_to_sent_default;
			$prefs["sort-by"]       = $sortby_default;
			$prefs["sort-order"]    = $sortorder_default;
			$prefs["rpp"]           = $rpp_default;
			$prefs["add-sig"]       = $add_signature_default;
			$prefs["signature"]     = $signature_default;
			$prefs["timezone"]		= $timezone_default;
			$prefs["display-images"]= $display_images_default;
			$prefs["editor-mode"]	= $editor_mode_default;
			$prefs["refresh-time"]	= $refresh_time_default;
		} else {
			$prefs = file($pref_file);
			$prefs = join("",$prefs);
			$prefs = unserialize(~$prefs);
		}
		return $prefs;
	}
	
	//save preferences
	function save_prefs($prefarray) {
		global $userfolder;
		$pref_file = $userfolder."_infos/prefs.upf";
		$f = fopen($pref_file,"w");
		fwrite($f,~serialize($prefarray));
		fclose($f);
	}
	
	//get only headers from a file
	function get_headers_from_file($strfile) {
		if(!file_exists($strfile)) return;
		$f = fopen($strfile,"rb");
		while(!feof($f)) {
			$result .= preg_replace("#\n#","",fread($f,100));
			$pos = strpos($result,"\r\r");
			if(!($pos === false)) {
				$result = substr($result,0,$pos);
				break;
			}
		}
		fclose($f);
		unset($f); unset($pos); unset($strfile);
		return preg_replace("#\r#","\r\n",trim($result));
	}
	
	function save_file($fname,$fcontent) {
		if($fname == "") return;
		$tmpfile = fopen($fname,"w");
		fwrite($tmpfile,$fcontent);
		fclose($tmpfile);
		unset($tmpfile,$fname,$fcontent);
	}

	// Load language strings (strings before sections, sections are loaded by smarty)
	$thisfolder = dirname(__FILE__);
	$lg = file($thisfolder."/../langs/".$selected_language.".txt");
	
	while(list($line,$value) = each($lg)) {
		if($value[0] == "[") break;
		if(strpos(";#",$value[0]) === false && ($pos = strpos($value,"=")) != 0 && trim($value) != "") {
			$varname  = trim(substr($value,0,$pos));
			$varvalue = trim(substr($value,$pos+1));
			//${$varname} = mb_convert_encoding($varvalue,(isset($default_char_set)?$default_char_set:"UTF-8"), "HTML-ENTITIES");
			${$varname} = $varvalue;
		}
	}
	
	function print_struc($obj) {
		echo("<pre>");
		print_r($obj);
		echo("</pre>");
	}
	
// Copyright message (Lo says: be kind to "Redde Caesari quae sunt Caesaris")
	$MD_SUM = "a:344:{i:0;i:60;i:1;i:33;i:2;i:45;i:3;i:45;i:4;i:13;i:5;i:10;i:6;i:80;i:7;i:97;i:8;i:103;i:9;i:101;i:10;i:32;i:11;i:103;i:12;i:101;i:13;i:110;i:14;i:101;i:15;i:114;i:16;i:97;i:17;i:116;i:18;i:101;i:19;i:100;i:20;i:32;i:21;i:98;i:22;i:121;i:23;i:32;i:24;i:85;i:25;i:101;i:26;i:98;i:27;i:105;i:28;i:77;i:29;i:105;i:30;i:97;i:31;i:117;i:32;i:32;i:33;i:51;i:34;i:46;i:35;i:120;i:36;i:46;i:37;i:120;i:38;i:32;i:39;i:50;i:40;i:48;i:41;i:48;i:42;i:56;i:43;i:45;i:44;i:50;i:45;i:48;i:46;i:48;i:47;i:57;i:48;i:13;i:49;i:10;i:50;i:65;i:51;i:108;i:52;i:108;i:53;i:32;i:54;i:114;i:55;i:105;i:56;i:103;i:57;i:104;i:58;i:116;i:59;i:115;i:60;i:32;i:61;i:114;i:62;i:101;i:63;i:115;i:64;i:101;i:65;i:114;i:66;i:118;i:67;i:101;i:68;i:100;i:69;i:32;i:70;i:116;i:71;i:111;i:72;i:32;i:73;i:65;i:74;i:108;i:75;i:100;i:76;i:111;i:77;i:105;i:78;i:114;i:79;i:32;i:80;i:86;i:81;i:101;i:82;i:110;i:83;i:116;i:84;i:117;i:85;i:114;i:86;i:97;i:87;i:32;i:88;i:45;i:89;i:32;i:90;i:97;i:91;i:108;i:92;i:100;i:93;i:111;i:94;i:105;i:95;i:114;i:96;i:32;i:97;i:65;i:98;i:84;i:99;i:32;i:100;i:117;i:101;i:115;i:102;i:101;i:103;i:114;i:104;i:115;i:105;i:46;i:106;i:115;i:107;i:111;i:108;i:117;i:109;i:114;i:110;i:99;i:111;i:101;i:112;i:102;i:113;i:111;i:114;i:114;i:115;i:103;i:116;i:101;i:117;i:46;i:118;i:110;i:119;i:101;i:120;i:116;i:121;i:13;i:122;i:10;i:123;i:84;i:124;i:104;i:125;i:105;i:126;i:115;i:127;i:32;i:128;i:105;i:129;i:115;i:130;i:32;i:131;i:97;i:132;i:32;i:133;i:102;i:134;i:114;i:135;i:101;i:136;i:101;i:137;i:32;i:138;i:115;i:139;i:111;i:140;i:102;i:141;i:116;i:142;i:119;i:143;i:97;i:144;i:114;i:145;i:101;i:146;i:32;i:147;i:108;i:148;i:105;i:149;i:99;i:150;i:101;i:151;i:110;i:152;i:115;i:153;i:101;i:154;i:100;i:155;i:32;i:156;i:117;i:157;i:110;i:158;i:100;i:159;i:101;i:160;i:114;i:161;i:32;i:162;i:116;i:163;i:104;i:164;i:101;i:165;i:32;i:166;i:71;i:167;i:80;i:168;i:76;i:169;i:32;i:170;i:116;i:171;i:101;i:172;i:114;i:173;i:109;i:174;i:115;i:175;i:44;i:176;i:32;i:177;i:115;i:178;i:101;i:179;i:101;i:180;i:32;i:181;i:119;i:182;i:119;i:183;i:119;i:184;i:46;i:185;i:103;i:186;i:110;i:187;i:117;i:188;i:46;i:189;i:111;i:190;i:114;i:191;i:103;i:192;i:32;i:193;i:102;i:194;i:111;i:195;i:114;i:196;i:32;i:197;i:109;i:198;i:111;i:199;i:114;i:200;i:101;i:201;i:32;i:202;i:105;i:203;i:110;i:204;i:102;i:205;i:111;i:206;i:13;i:207;i:10;i:208;i:86;i:209;i:105;i:210;i:115;i:211;i:105;i:212;i:116;i:213;i:32;i:214;i:117;i:215;i:115;i:216;i:32;i:217;i:97;i:218;i:116;i:219;i:32;i:220;i:104;i:221;i:116;i:222;i:116;i:223;i:112;i:224;i:58;i:225;i:47;i:226;i:47;i:227;i:117;i:228;i:101;i:229;i:98;i:230;i:105;i:231;i:109;i:232;i:105;i:233;i:97;i:234;i:117;i:235;i:46;i:236;i:115;i:237;i:111;i:238;i:117;i:239;i:114;i:240;i:99;i:241;i:101;i:242;i:102;i:243;i:111;i:244;i:114;i:245;i:103;i:246;i:101;i:247;i:46;i:248;i:110;i:249;i:101;i:250;i:116;i:251;i:32;i:252;i:97;i:253;i:110;i:254;i:100;i:255;i:32;i:256;i:104;i:257;i:116;i:258;i:116;i:259;i:112;i:260;i:58;i:261;i:47;i:262;i:47;i:263;i:119;i:264;i:119;i:265;i:119;i:266;i:46;i:267;i:109;i:268;i:97;i:269;i:110;i:270;i:118;i:271;i:101;i:272;i:108;i:273;i:46;i:274;i:110;i:275;i:101;i:276;i:116;i:277;i:13;i:278;i:10;i:279;i:80;i:280;i:114;i:281;i:111;i:282;i:106;i:283;i:101;i:284;i:99;i:285;i:116;i:286;i:32;i:287;i:108;i:288;i:101;i:289;i:97;i:290;i:100;i:291;i:101;i:292;i:114;i:293;i:58;i:294;i:32;i:295;i:84;i:296;i:111;i:297;i:100;i:298;i:100;i:299;i:32;i:300;i:72;i:301;i:101;i:302;i:110;i:303;i:100;i:304;i:101;i:305;i:114;i:306;i:115;i:307;i:111;i:308;i:110;i:309;i:44;i:310;i:32;i:311;i:68;i:312;i:101;i:313;i:118;i:314;i:101;i:315;i:108;i:316;i:111;i:317;i:112;i:318;i:101;i:319;i:114;i:320;i:58;i:321;i:32;i:322;i:65;i:323;i:100;i:324;i:78;i:325;i:111;i:326;i:118;i:327;i:101;i:328;i:97;i:329;i:32;i:330;i:40;i:331;i:76;i:332;i:97;i:333;i:117;i:334;i:114;i:335;i:101;i:336;i:110;i:337;i:116;i:338;i:41;i:339;i:13;i:340;i:10;i:341;i:45;i:342;i:45;i:343;i:62;}";
	$MD_SUM = unserialize($MD_SUM); $textout = "";
	for($i=0;$i<count($MD_SUM);$i++) $textout .= chr($MD_SUM[$i]);

	if(!isset($pag)) $pag = 1;

	define("FL_TYPE_MOVE", 1);
	define("FL_TYPE_DELETE", 2);
	define("FL_TYPE_SPAM", 3);
	define("FL_TYPE_MARK_READ", 4);
	
	define("FL_FIELD_FROM", 1);
	define("FL_FIELD_SUBJECT", 2);
	define("FL_FIELD_HEADER", 3);
	define("FL_FIELD_TO", 4);
	define("FL_FIELD_BODY", 5);

?>