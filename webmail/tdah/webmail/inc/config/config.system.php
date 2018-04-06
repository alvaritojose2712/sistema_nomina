<?php
ini_set("display_errors", 1);

	define('yes', 1);
	define('no', 0);
	
	define('SW_VERSION', 		"3.2.0 PHP-5.3");							// UebiMiau version , release date and website link
	define('SW_DATE', 			"May 2009");
	define('SW_LINK', 			"www.tdah.us");
	
	define('SMARTY_VERSION',	"(<i>May 16th, 2009</i>)");				// Smarty version
	define('SMARTY_LINK', 		"www.smarty.net");
	
	define('TINYMCE_VERSION', 	"3.2.1.1  (<i>Nov 27th, 2008</i>)");	// Tiny MCE version, website link and path
	define('TINYMCE_LINK', 		"tinymce.moxiecode.com");
	define('TINYMCE_PATH', 		"editors/tiny_mce");
	
	define('DOC_TYPE',
					//	'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">');
						'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">');
					//	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">');
	
	
	// Config Files
	define("CFG_APPS","inc/config/config.uebimiau.php");		
	define("CFG_SYSTEM","inc/config/config.system.php");		
	define("CFG_CONFIG","inc/config/config.php");			
	define("CFG_LANGUAGES","inc/config/config.languages.php");	
	define("CFG_THEMES","inc/config/config.themes.php");	
define("CFG_PATHS","inc/config/config.paths.php");	
define("DB_ADMIN","system_admin/admin.ucf");		
define("CFG_BACKUP","admin/backup/config.backup.php");
define("CFG_MAIL","inc/config/config.mail.php");
define("CFG_CALENDAR","inc/config/config.calendar.php");

/*
	// Database Files
  define("DB_FILTERS","_infos/filters.ucf");  			
  define("DB_ADRESSBOOK","_infos/addressbook.ucf");  	
  define("DB_PREFERENCES","_infos/prefs.upf");  			
  define("DB_CALENDAR","_infos/events.upf"); 
   
  define("DB_LOG_FILE","system_admin/log.ucf");
  define("DB_CHAT_DATA","chat/chatdata.ucf");
  define("DB_CHAT_ONLINE","chat/online.ucf");
  define("DB_CHAT_UPLOAD","chat/upload/");
  	
	
	
			
	define("CFG_CHAT","inc/config/config.chat.php");			
				
	  
	define("CFG_TEMPLATES","inc/config/config.templates.php"); 
	
	define("CFG_HELP","docs/admin_help.txt");
	
	define("CFG_FILES","admin/filemanager/admin.php"); // Absolute path to the administrator filemanager
		
	
	define("INCL_FOLDERS","inc/folder_list.php"); 
	define("INCL_FUNCTIONS","inc/functions.php"); 
	
	// System Files 
	define("SYS_FUNCTIONS","inc/functions.php"); 
	define("SYS_LIB","inc/lib.php"); 
	define("SYS_INC","inc/inc.php"); 
	define("SYS_FILTER","inc/htmlfilter.php");  
	define("SYS_AUTH","inc/auth.php"); 
	
	define("CLASS_PHPMAILER","inc/class/class.phpmailer.php");  
	define("CLASS_PHPMAILER_EXTRA","inc/class/class.phpmailer_extra.php");  // Absolute path to phpmailer_extra.php
	define("CLASS_SMTP","inc/class/class.smtp.php");  // Absolute path to class.smtp.php
	define("CLASS_TNEF","inc/class/class.tnef.php");  // Absolute path to class.tnef.php
	define("CLASS_UEBI","inc/class/class.uebimiau.php");  // Absolute path to class.uebimiau.php
	define("CLASS_UEBU_MAIL","inc/class/class.uebimiau_mail.php");  // Absolute path to class.uebimiau_mail.php
	define("CLASS_CALENDAR","class.calendar.php");  // Absolute path to config.calendar.php
*/			
	define("EDIT_NEW","editors/newmsg_editor.php");						// Absolute path to Database directory
	define("EDIT_PREF","editors/preferences_editor.php");
	define("EDIT_ADD","editors/preferences_editor.php");
	
	//define("PATH_DATABASE","./database/");						// Absolute path to Database directory
	define("PATH_ADMIN","admin/");								// Absolute path to Admin directory
	define("PATH_CONFIG","inc/config/");	
	define("FRAME_ADMIN","admin_body.php");								// Absolute path to Admin directory
	define("PATH_INSTALL","admin/install/");
	

//	define("PATH_LANGS","langs/");  							// Absolute path to languages
//	define("PATH_DOCS","docs/");  							// Absolute path to documentation
//	define("PATH_THEMES","themes/");
	define("PATH_LANG_PHPMAILER","langs/");  					// Absolute path to languages for phpMailer
	define("PATH_APPLY_FILTERS","apply_filters.php");  					// Absolute path to languages for phpMailer
//	define("PATH_GET_MESSAGES","get_message_list.php");  					// Absolute path to languages for phpMailer
	define("PATH_mail_PluginDir","./"); 
	define("PATH_BACKUP","admin/backup/backup.php");  
	define("PATH_VIEWBACKUPS","admin/backup/filemanager.php"); 
	define("PATH_BACKUP_DIR","admin/backup/backup_files/"); 
	
	define("LOG_DATE","F j, Y, H:i ");  					// Log events date format

	
	#_Contact_Photo_#
	$image_max_width = 200;									// Set maximum contact's photo size in pixels,
	$image_max_height = 200;								// if changed, please update langs files messages accordingly
	
	
	
	
?>