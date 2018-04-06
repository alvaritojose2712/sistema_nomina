<?php
/************************************************************************
	- File:			en_US.php
	- Developer: 	Laurent (AdNovea)
	- Date:			November, 2008
	- version:		(3.2.0) 1.9
	- Description:  Language
*************************************************************************/

	$chat_date_format 	= "F j, Y, G:i";			// May be set to "j F Y G:i" for french
	$chat_time_format 	= "g:i a";					// May be set to "G:i" for french

/* 	defines constants for Chat room messages
	------------------------------------------------------------ */
	
	define("CHAT_UNNAMED","Unnamed");
	define("CHAT_HIDDEN","Hidden");
	define("CHAT_BACK","Back");
	define("CHAT_JOIN","Has Joined the room");
	define("CHAT_LEFT","Has left the room.");
	define("CHAT_NICK_CHANGED","is now .");
	define("CHAT_CHANGENICKNAME","is now known as");
	define("CHAT_LOGOUT","has logged out of chat.");
	define("CHAT_LOGGING","Logging in...");
	define("CHAT_CANNOT_OPENFILE","Cannot open file");
	define("CHAT_CANNOT_WRITEFILE","Cannot write to file");
	define("CHAT_CANNOT_OPENUSER","Error: Cannot open user file, you may need to sign up (again).");
	define("CHAT_CLEARED","Chat data cleared by");
	define("CHAT_CLEARED_BY","Chat data cleared successfully by");
	define("CHAT_SEND","has uploaded the file ");
	define("CHAT_FILE_MISSING","<b>WARNING</b>: File does not exist or cannot be loaded!");
	define("CHAT_FILE_INVALID","<b>WARNING</b>: Invalid file name!");
	define("CHAT_FILE_UPLOADED","Uploaded with success!");
	define("CHAT_FILE_NOT_UPLOAD","<b>WARNING</b>: Upload failure!");
	define("CHAT_FILE_SIZE","<b>WARNING</b>: File size exceed limit set to (MB): ");
	define("CHAT_TEXT_SIZE","Maximum file size (MB): ");
	define("CHAT_ISNOW","is now:");
	define("CHAT_ONLINE","On line");
	define("CHAT_BUSY","Busy");
	define("CHAT_BRB","Be right back");
	define("CHAT_AWAY","Away");
	define("CHAT_CLICK2PM","Click for Private Messages");
	$smiley_code = Array();
	$smiley_code[0] = ":-)";
	$smiley_code[1] = ":)";
	$smiley_code[2] = ":-))";
	$smiley_code[3] = ":-D";
	$smiley_code[4] = ":-(";
	$smiley_code[5] = ":->";
	$smiley_code[6] = ">;->";
	$smiley_code[7] = ":-o";
	$smiley_code[8] = "B-)";
	$smiley_code[9] = ";-)";
	$smiley_code[10] = "--)";
	$smiley_code[11] = ":-/";
	$smiley_code[12] = ":-O";
	$smiley_code[13] = ":))";
	$smiley_code[14] = "lol";
	$smiley_code[15] = ":-((";
	$smiley_code[16] = "|)";
	$smiley_code[17] = ":-8";
	$smiley_code[18] = "==>";
	$smiley_code[19] = "!!!";
	$smiley_code[20] = "?!";
	$smiley_code[21] = "???";



/* 	Defines constants for Installation
	------------------------------------------------------------ */

// Common
	define("_STG5_FRONT1"," Start Over");
	define("_STG5_FRONT"," Log In Here");
	define("_STG5_ADMIN","Edit Files");
	define("_STG_OR","or");
	define("_STG_CONTINUE","Click here to continue...");
	define("_STG_GO_BACK","Back to previous page ");
	define("_STG_ERROR","There were some errors !!!");
	define("_DROPDOWN_YES","yes");
	define("_DROPDOWN_NO","no");
	define("_POP_FILE","config.mail.php");


// Index.php
	define("_STG","Installer");
	define("_STG_LICENSE","Uebimiau Webmail is Free Software released under the GNU/GPL License.");
	define("_STG_LOG_NOTVALID","Admin name or password is invalid!");
	define("_STG_COPYRIGHT","<a href=\"http://www.tdah.us\" class=\"slink\">Uebimiau Webmail</a> 2007 - 2008");
	define("_STG_VISIT","Visit us at<a href=\"http://www.tdah.us\" target=\"_blank\" class=\"slink\"> www.tdah.us</a>");


// precheck.php
	define("_STG_PRECHECK_WELCOME","Welcome to Uebimiau");
	define("_STG_REINSTALL","You are about to re-install Uebimiau Webmail on you system.<br>Thanks to log with your UebiMiau Admin ID and password to continue.");
	define("_STG_PRECHECK_STG","You are about to install Uebimiau Webmail on you system.<br> In case of problem and questions please give us a visit and let us know.");
	define("_STG_LINK","http://www.tdah.us");
	define("_STG_PRECHECK_TEAM","The Uebimiau Team");
	define("_STG_USERNAME","Username:");
	define("_STG_PASSWORD","Password:");
	define("_STG_MOD","Modify current configuration:");
	define("_STG_RESTORE","Restore previous configuration:");
	define("_STG_RESET","Reset to default parameters:");
	define("_STG_PRECHECK_STEPS","This installation script will guide you through the install process of Uebimiau and should have you up and running in 5 minutes <font color=\"#FF0000\">...<b>THE INSTALL FOLDER NEEDS TO BE WRITABLE</b>...</font>or it will fail.");


// restore.php
	define("_STG_RESTORED","Previous configuration :");
	define("_STG_RESTORED_SUCCESS","Restored successfully!");
	define("_STG_RESTORED_ERROR","Cannot be restored!");


// install0.php
	define("_STG0_TITLE_GPL","GNU General Public License");
	define("_STG0_GNU_AGREE"," I agree to the GNU General Public License.");
	define("_STG0_GNU_CHECKHERE"," You must agree to the GNU/GPL Public License to continue Installation.");


// install1.php
	define("_STG1_WARNING","Warning!!!!");
	define("_STG1_ERROR_MSG","
		Directories created by the
		Uebimiau Installer are <font color=\"#FF0000\">NOT WRITABLE</font>.
		
		1. Please make them writable.
		2. Installation of this webmail will be a problem.
		3. Uebimiau will not be functioning normally.");
	define("_STG1_ERROR_MSG2","If any of these items are highlighted in <font color=\"#FF0000\"><b>RED</b></font>, Uebimiau may not be functioning as expected");
	define("_STG1_TITLE","Check directives used with your system");
	define("_STG1_DIRECTIVES","Directives");
	define("_STG1_RECOMMENDED","Recommended");
	define("_STG1_ACTUAL","Actual");
	define("_ST1_ON","ON");
	define("_ST1_OFF","OFF");
	define("_STG_GO_GNU","Back to GNU page ");


// install2.php
	define("_STG2_PATH","Directory Path checks");
	define("_STG2_PATH_EXP","The following files and directories should all be writable for Uebimiau to function properly. If something is not writable, please change the Permissions for these files.");
	define("_STG0_WRITE","Writable");
	define("_STG0_NWRITE","UnWritable");
	define("_STG2_SMARTY","SMARTY");


// install3.php
	define("_DROPDOWN_DATE","date");
	define("_DROPDOWN_SUBJECT","subject");
	define("_DROPDOWN_FROM","from");
	define("_DROPDOWN_SIZE","size");
	define("_DROPDOWN_NAME","name");
	define("_DROPDOWN_DESC","DESC");
	define("_DROPDOWN_ASC","ASC");
	define("_STG3_MINUTES","minutes");

	define("_STG3_MAIN","- Main Setup 1 -");
	define("_STG3_POP","POP3/IMAP Setup 2");
	define("_STG3_POPM","- Multiple POP3/IMAP -");
	define("_STG3_SMTP","- Smtp Setup 3 -");
	define("_STG3_DEFAULTS","- Defaults Setup 4 -");
	define("_STG3_EXTRAS","- Security setup 5 -");
	define("_STG3__LOAD_ERROR","If you get error while loading configuration files, restart the installation and choose <b>default parametres</b>");
	
	// Tab 1
	define("_STG3_PATHS","These are paths to your site, these will be written in the config for informational purposes only, do not change anything here this will have no effect. This is useful when your on another server and you need the path to make folders writable");
	define("_STG3_URL","Webmail URL ( including the root path )");
	define("_STG3_ABS","Absolute Path ( The absolute file path of the webmail)");
	define("_STG3_TEMP2","Path to your Temporary Directory ( either from root, C:\ or ./  (Example: /var/www/webmail/database/ or ./database/ this is the default)");
	
	define("_STG2_smarty","Path to your Smarty Directory ( either from root, C:\ or ./  (Example: /var/www/webmail/database/ or ./libs/ this is the default)");
	define("_STG2_path","Path to your Smarty Directory ");
	define("_STG3_TEMP","Path to your Temporary Directory ");
	define("_STG3_QUOTA_EXP","You may want to limit or not (set to 0) the mailboxes quota. The quota is the same for all the mail accounts and will prevent to do any further operations on messages as the quota is reached. Users will be prompted to delete some message to continue.");
	define("_STG3_QUOTA","Mailboxes quota");
	define("_STG3_QUOTA_UNIT","kB");
	define("_STG3_MAIN3_EXP","This is the title that shows up on the login and the header of the webmail, this should be your domain name, company name etc. You can edit this under company in the config.php");
	define("_STG3_TITLE","Company Name");
	define("_STG3_add_signaturec","Allow default signatures in emails");
	define("_STG3_add_signature","Add a default signature");
	define("_STG3_main_message","Express Install");
	define("_STG3_main_messagec","If your webmail is located on a server that has pop and smtp installed, Uebimiau should run without changing any settings using localhost and user@domain name but it is advised that you check all tabs at the top and fill out the pages according to your preferences before you click continue ");
	define("_STG_GO_LASTTAB","Goto last tab to continue ");
	
	// Tab 2
	define("_STG3_POP_TYPE"," Uebimiau mail client configuration section ");
	define("_STG3_TYPE_ONE_FOR_ALL","One domain");
	define("_STG3_TYPE_DETECT","Auto Detect");
	define("_STG3_TYPE_ONE_FOR_EACH","Multiple domains");
	define("_STG3_TITLE_DETECT"," Auto Detect");
	define("_STG3_DETECT","If you use this option Uebimiau will guess the POP3 server. The script will use by default \"mail.company.com\" as your server. You can set the \"PREFIX\" in the var \$mail_detect_prefix. Also, the var \$mail_detect_remove is set to \"www.\", then the script gets rid of the \"www\" and puts the prefix.");
	define("_STG3_POPSERVER2","Default Mail server prefix");
	define("_STG3_POPPORT","Mail server port (default is 110)");
	define("_STG3_POPPORT2","Mail Server type / Port (default is pop3 / 110)");
	define("_STG3_TITLE_ONE_FOR_ALL"," One domain (One for All)");
	define("_STG3_ONE_FOR_ALL","To be selected when a single mail domain is used. With this option, your users must supply the	full email address as username (e.g. username@company.com). The script will load from the \$default_mail_server in config.php");
	define("_STG3_POPSERVER","Mail server (mail.yourserver.com, server name or ip address)");
	define("_STG3_TITLE_ONE_FOR_EACH"," Multiple domains (One for Each)");
	define("_STG3_ONE_FOR_EACH","Each domain must have its own mail server. When selecting this option, a new blank section is displayed that allows defining each mail server. Click add to load a new server form then save after each form added, click on defaults to show the default settings used. The script will load from the config.mail.php file");
	
	// Tab 3
	define("_STG3_ONE_FOR_EACH2","Choosing \"Multiple POP3/IMAP\" will enable the script to load the list of domains/servers from the "._POP_FILE." file. You may create several profiles for each domain having its own mail server.");
	define("_STG3_POP_MSERVER","Profile #: ");
	define("_STG3_DOMAIN_EXP3","This is the domain name to access the mail server.");
	define("_STG3_DOMAIN","Domain Name (yourserver.com)");  
  
  define("_STG3_CLIENT_CONFIG","  
 Here you will select if you’re using local host for your server or multiple domains, you can use the multiple domain protocol with local host and it is usually preferred.  if you select the  one domain protocol  you will need to fill out the one  domain section on the pop3/imap set up in the next tab, if Multiple domains are selected you will need to fill out the Multiple domains (One for Each) section by clicking the - add then save - for each server you add,");	
	
	define("_STG3_POPSERVER_EXP3","This is the server to be used with this profile.");
	define("_STG3_POPLOGINTYPE_EXP3","This is the type of login string used to connect to the mail server. If your mail server requires just the user name to log in; you would use (%user%), if user@domain (%user%@%domain%) ");
	define("_STG3_POPLOGINTYPE","Type of login string to connect (default is %user%@%domain%)");
	define("_STG3_POPPROTOCOL_EXP3","This is the protocol to use with this server for both (POP3 or IMAP).");
	define("_STG3_POPPROTOCOL","Mail protocol to be used: POP3 or IMAP (default is POP3)");
	define("_STG3_POPPORT_EXP3","This is the port used for the mail server (default is POP3=110 and IMAP=143).");
	define("_STG3_POP_ADD","&nbsp; Add &nbsp;");
	define("_STG3_POP_REMOVE","Remove");
	define("_STG3_POP_REMOVE_OK","Are you sure to remove this profile?");
	define("_STG3_POP_SAVE","Save");
	define("_STG3_POP_SAVE_OK","Your modifications have been saved");
	define("_STG3_POP_DEFAULT","show defaults");
	define("_STG3_POP_SAVE_REMIND","Save you modifications otherwise they will be lost!");
	
	// Tab 4
	define("_STG3_SMTP_TYPEc","<p><b>smtp</b> - To use an external SMTP Server specified in \$smtp_server<br>
	<b>sendmail</b> - To servers sendmail-compatible MTA. If you need to change the 
	path, look into /inc/class.phpmailer.php and search for var \$Sendmail = 
	&quot;/usr/sbin/sendmail&quot;;<br>	<b>mail</b> - To use default PHPs mail() function</p>");
	define("_STG3_SMTP_TYPE"," Type of outgoing mail process");
	define("_STG3_TYPE_SMTP","smtp");
	define("_STG3_TYPE_SENDMAIL","sendmail");
	define("_STG3_TYPE_PHPMAIL","mail");
	define("_STG3_SMTPSERVER","Smtp Server (smtp.yourserver.com) or ip address)");
	define("_STG3__SMTPPORT","Smtp Port (default is 25, ssl is 465 )");
	define("_STG3_SMTPAUTH","- Smtp Authentication -");
	define("_STG3_ADMIN_EXP2","If your server requires authentication for each username yes or no.");
	define("_STG3_AUTHENTICATION","Smtp Authentication (   does your server require authentication )");
	define("_STG3__SMTPSECURE","Smtp Secure SSL (This server requires a secure connection)");
	define("_STG3__SMTPSECURE_SSL","ssl");
	define("_STG3__SMTPSECURE_TLC","tlc");
	define("_STG3_ADMIN_EXP3","Is your server requiring authentication for one username system wide? Note: the above has to be yes also.");
	define("_STG3_STATICAUTHENTICATION","Server Wide Authentication (one user name for the whole server)");
	define("_STG3_AUTH_NAME","Authentication user name  (user@dmain.com)");
	define("_STG3_AUTH_PASSWORD","Smtp Password (password for the authenticated name)");
	
	// Tab 5
	define("_STG3_DEFAULT_CHARSET","Default Charset used");
	define("_STG3_allow_user_change_languagec","Allow Users to change the language, shows up on the login page as a drop down");
	define("_STG3_allow_user_change_language","Allow Users to change Languages");
	define("_STG3_DEFAULT_LANGUAGEc","This is the default Language that shows up on the log in page and the time zone for your location.");
	define("_STG3_DEFAULT_LANGUAGE","This is the default Language and your time zone");
	define("_STG3_allow_user_change_themec","Allow Users to change the themes, shows up on the login page as a drop down");
	define("_STG3_allow_user_change_theme","Allow users to change Themes");
	define("_STG3_default_themec","This is the default Theme that shows up on the log in page ");
	define("_STG3_default_theme","Default Theme used");
	define("_STG3_check_first_loginc","Redirect new users to the preferences page at first login");
	define("_STG3_check_first_login","Check first Log in");
	define("_STG3_use_topc","In some POP3 servers, if you send a \"RETR\" command, your message will be automatically deleted This option prevents this inconvenience");
	define("_STG3_use_top","Use Mail Top");
	define("_STG3_default_sortbyc","The default column to sort by, the default is date");
	define("_STG3_default_sortby","Default sort by ");
	define("_STG3_default_sortorderc","Default sort order allowed are Ascending or Descending the default is Descending");
	define("_STG3_enable_debugc","Enable debug no - disabled 1 or yes -> enabled with full results 2 -> enable with servers communications only, this is used to check server logging problems");
	define("_STG3_enable_debug","Enable debugging");
	
	// Tab 6
	define("_STG3_allow_htmlc","Enable visualization of HTML messages. This option effects only incoming messages, the  HTML editor for new messages compose page is automatically activated when the clients browser supports IE5 or higher");
	define("_STG3_allow_html","Allow html");
	define("_STG3_allow_modified_fromc","Turn this option to yes if you want allow users send messages using they Reply to preferences option as your From header, otherwise the From field will be the email which the users log in");
	define("_STG3_allow_modified_from","Allow modified from");
	define("_STG3_allow_scriptsc","FILTER javascript (and others scripts) from incoming messages");
	define("_STG3_allow_scripts","Allow scripts");
	define("_STG3_allow_filtersc","You should enable this option, this allows you to set filters in the preferences page");
	define("_STG3_allow_filters","Allow filters");
	define("_STG3_block_external_imagesc","If an HTML message have external images, it will be blocked. This feature is to prevent spam tracking");
	define("_STG3_block_external_images","Block external images");
	define("_STG3_require_same_ipc","Session is valid only for the same ip address. If different, will be logged off");
	define("_STG3_require_same_ip","Require The same IP");
	define("_STG3_idle_timeoutc","Session timeout for inactivity in minutes");
	define("_STG3_idle_timeout","Idle Timeout");
	define("_STG3_admin_account","<font color=\"#FF0000\"><b>MANDATORY:</b></font> Create an Admin account to manage UebiMiau. Additional Admin accounts could be added later on.");
	define("_STG3_CONFIRM","Confirm password:");
	define("_STG3_PWD_NOTVALID","Admin name, password or confirmed password is invalid!");


// install4.php
	define("_STG5_CONFIG_EXP","These are the main configuration files in case you need to edit something. You can also edit the settings directly using the edit files link below to get to the Administration.");
	define("_STG5_CONFIG_WRITE","Writing configuration file");
	define("_STG5_SUCCESS","Successfull");
	define("_STG5_CONFIG_ERROR","Unwriteable - Create config.php from text which appears below");
	define("_STG5_CONFIG_CONTENT","If there was an error paste the following settings into ");
	define("_STG5_CONFIG_ERROR2","Unwriteable - Create "._POP_FILE." from text which appears below");
	define("_STG5_CONFIG_ERROR3","Unwriteable - Admin password file cannot be saved! INSTALLATION FAILED...");
	define("_STG5_PATH_ERROR1","The path cannot be saved! Default path will be used...");

?>