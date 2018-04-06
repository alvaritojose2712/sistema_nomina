<?php
	
		// Templates, used in conjunction with config.template.php


	define("HTML_ADMIN","admin.htm");  						// Admin login page
	define("HTML_ADMIN_ACTIONS","admin-actions.htm");  		// Admin menu
	define("HTML_ADMIN_LOGIN","admin-login.htm");  			// Admin login process

	define("HTML_ERROR","error.htm");            			// System error
	
	define("HTML_FOLDERS_RESULT","folders-results.htm");  	// Result of folder actions
	define("HTML_HEADERS_WINDOW","headers-window.htm");   	// Display the mail headers

	define("HTML_LOGIN","login.htm");            			// Inital page (Login)

	define("HTML_NEWMSG_RESULT","newmsg-results.htm");    	// Result about sent messages

	define("HTML_PRINT_MESSAGE","print-message.htm");    	// Print friendly version

	define("HTML_QUICK_ADDRESS","quick_address.htm");    	// Pop-Up for quick address list
	define("HTML_READMSG","readmsg.htm");          			// Read a messgae
	define("HTML_READMSG_POPUP","readmsg-popup.htm");  		// Pop-up for attached message

	define("HTML_SPAM_ADDRESS","spam-address.htm");    		// Pop for spam
	define("HTML_UPLOAD_ATTACH","upload-attach.htm");    	// Pop-up to attach document
	define("HTML_UPLOAD_PHOTO","upload-photo.htm");  		// Pop-up a contact's photo
	
	
	define("HTML_CALBOX","themes/default/calendar-box.htm"); // Calendar Frame page (because its not defined in smarty yet) 
	
	
	// Template Sections. includes template path 
	define("TPL_PANEL","/inc/panel.tpl");	
	define("TPL_TREE","/inc/tree.tpl");	
	define("TPL_TOOLBAR","/inc/toolbar.tpl");	
	define("TPL_MENU","/inc/menu.tpl");	
	define("TPL_HEADER","/inc/header.tpl");	
	define("TPL_BANNER","/inc/banner.tpl");
	define("TPL_LIST","/inc/list.tpl");	
	define("TPL_VIEW","/inc/view.tpl");	
	define("TPL_SEARCH","/inc/search.tpl");	
	define("TPL_READ","/inc/read.tpl");
	define("TPL_MESSAGES","/inc/messages.tpl");
	define("TPL_CALENDAR","/inc/calendar.tpl");
	define("TPL_NEW","/inc/new.tpl");	
	define("TPL_NEWRESULTS","/inc/newresults.tpl");	
	define("TPL_FOLDERS","/inc/folders.tpl");
	define("TPL_FOLDRESULTS","/inc/foldresults.tpl");
	define("TPL_ADDDISPLAY","/inc/adddisplay.tpl");	
	define("TPL_ADDLIST","/inc/addlist.tpl");	
	define("TPL_ADDFORM","/inc/addform.tpl");	
	define("TPL_ADDRESULTs","/inc/addresults.tpl");	
	define("TPL_PREFS","/inc/prefs.tpl");
	
	// Assign to smarty the paths for included dynamic templates
	$tpl_panel = TPL_PANEL; 
	$tpl_tree = TPL_TREE;
	$tpl_toolbar = TPL_TOOLBAR;
	$tpl_menu = TPL_MENU;
	$tpl_header = TPL_HEADER; 
	$tpl_banner = TPL_BANNER;
	$tpl_list = TPL_LIST; 
	$tpl_search = TPL_SEARCH;
	$tpl_read = TPL_READ;
	$tpl_chat = TPL_CHAT;
	$tpl_calendar = TPL_CALENDAR;
	$tpl_new = TPL_NEW;
	$tpl_newresults = TPL_NEWRESULTS; 
	$tpl_folders = TPL_FOLDERS;
	$tpl_foldresults = TPL_FOLDRESULTS;
	$tpl_adddisplay = TPL_ADDDISPLAY;
	$tpl_addlist = TPL_ADDRLIST;
	$tpl_addform = TPL_ADDFORM;
	$tpl_addresults = TPL_ADDRESULTs;
	$tpl_messages = TPL_MESSAGES;
	
		    
	$smarty->assign("TPL_MESSAGES", $tpl_messages );
	$smarty->assign("TPL_PANEL", $tpl_panel );
	$smarty->assign("TPL_TREE", $tpl_tree );
	$smarty->assign("TPL_TOOLBAR", $tpl_toolbar );
	$smarty->assign("TPL_MENU", $tpl_menu );
	$smarty->assign("TPL_HEADER", $tpl_header );
	$smarty->assign("TPL_BANNER", $tpl_banner );
	$smarty->assign("TPL_LIST", $tpl_list );
	$smarty->assign("TPL_SEARCH", $tpl_search );
	$smarty->assign("TPL_READ", $tpl_read );
	$smarty->assign("TPL_CHAT", $tpl_chat );
	$smarty->assign("TPL_CALENDAR", $tpl_calendar );
	$smarty->assign("TPL_NEW", $tpl_new );
	$smarty->assign("TPL_NEWRESULTS", $tpl_newresults );
	$smarty->assign("TPL_FOLDERS", $tpl_folders );
	$smarty->assign("TPL_FOLDRESULTS", $tpl_foldresults );
	$smarty->assign("TPL_ADDDISPLAY", $tpl_adddisplay );
	$smarty->assign("TPL_ADDFORM", $tpl_addform );
	$smarty->assign("TPL_ADDLIST", $tpl_addlist );
	$smarty->assign("TPL_ADDRESULTS", $tpl_addresults );
?>