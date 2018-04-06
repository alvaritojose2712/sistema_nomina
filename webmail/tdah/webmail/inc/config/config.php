<?php


#_Default_Server_Settings_#

  $company = 'T-dah Webmail';
	$allow_user_change_language = no;
	$default_language = 'English';
	$allow_user_change_theme = no;
	$default_theme = 'default';
	$check_first_login = yes;
	$mail_use_top = yes;
	$add_signature = no;
	$default_sortby = 'date';
	$default_sortorder = 'DESC';
	$enable_debug = 0;
	$default_char_set = 'UTF-8';
	$server_timezone_offset = "-0000";

#_Mail_Settings_#

	$mail_server_type = 'ONE-FOR-EACH';
	
	#_One-for-each see config.mail.php for extra servers_#
	
	#_One-for-All_#
	$default_mail_server = '';
        $one_for_all_login_type	= '%user%@%domain%';
	$default_protocol= 'pop3';
	$default_port = 110;
	

#_Security_Settings_#

	$quota_limit = 0;
	$allow_html = yes;
	$allow_modified_from = yes;
	$allow_scripts = no;
	$allow_filters = yes;
	$block_external_images = no;
	$require_same_ip = yes;
	$idle_timeout = 30;

#_Default_User_Preferences_#

	$default_preferences = Array(
	'send_to_trash_default'=> yes,		
	'st_only_ready_default'=> no,	
	'save_to_sent_default'=> yes,		
	'empty_trash_default'=> no,		
	'rpp_default'=> 22,		
	'add_signature_default'=> no,		
	'signature_default'=> '',		
	'timezone_default'=> '-0500',	
	'display_images_default'=> yes,		
	'editor_mode_default'=> 'html',	
	'refresh_time_default'=> 1
	);



?>