<?php
/************************************************************************
	UebiMiau is a GPL'ed software developed by 
	
	 - Aldoir Ventura - aldoir@users.sourceforge.net
	 - http://uebimiau.sourceforge.net
	
	Fell free to contact, send donations or anything to me :-)
	São Paulo - Brasil
	
	**********************************************
	Version 3.2.0 Upgrades and templates developed by
	 
	 - Todd Henderson - Lead Developer
	 - http://tdah.us
	 - Email: todd@tdah.us
	 
	 - Dave Rodgers - Project Consultant
	 - http://www.manvel.net 
	 - Email: Davenmanvel@inbox.com
	
	Feel free to contact us, send donations or anything to me as well...
	
	Special thanks to the developers at telaen.org, codeworxtech.com, tinymce.moxiecode.com
	without help this project wouldn't be possible 

	**********************************************
	- File:			functions.php
	- Developer: 	Rewrited by Laurent (AdNovea)
	- Date:			November 4, 2008
	- version:		(3.2.0) 1.0
	- Description:  All common javascript functions and PHP->JS variable passing

*************************************************************************/

// Add Javascript for Tiny-MCE if required
	if ($show_advanced == 1) 
		$jssource .= "<script type=\"text/javascript\" src=\"".TINYMCE_PATH."/tiny_mce.js\"></script>";

// Add Javascript Tiny-MCE variables if required
	if ($show_advanced == 1) 
		$jssource .= "
	<script type=\"text/javascript\" language=\"javascript\">
	tinyMCE.init({
		mode : 'textareas',
		theme : 'advanced',
		language : '".$languages[$lid]['tiny_mce']."', 
		plugin_insertdate_dateFormat : '".preg_replace("/'/","\\'",$tiny_mce_date)."', 
		plugin_insertdate_timeFormat : '".preg_replace("/'/","\\'",$tiny_mce_time)."',

		//plugins : 'contextmenu,paste',
	plugins : 'safari,advhr,emotions,preview,print,paste,spellchecker,directionality,fullscreen',

		skin : 'o2k7',
		skin_variant : 'silver',
		theme_advanced_buttons1 : 'print,preview,|,search,replace,|,cut,copy,paste,|,removeformat,cleanup,|,undo,redo,|,link,unlink,|,charmap,emotions,|,hr,advhr,|,backcolor,forecolor,|,code,|,fullscreen',
		theme_advanced_buttons2 : 'fontselect,fontsizeselect,spellchecker,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,numlist,bullist,|,outdent,indent,blockquote',
		theme_advanced_buttons3 : '',
		theme_advanced_buttons4 : '',
		theme_advanced_toolbar_location : 'top',
		theme_advanced_toolbar_align : 'left',
		theme_advanced_statusbar_location : 'bottom',
//		auto_resize : true,	// DOES NOT WORK WITH IE
		
		cleanup : true,
		doctype: '".DOC_TYPE."',
		content_css : 'editors/tiny_mce/mycontent.css',
		entities : '39,#39',

		force_br_newlines: true,
		extended_valid_elements : 'hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]',

		file_browser_callback : 'fileBrowserCallBack',
		apply_source_formatting : true
	});
	</script>";

	

	$smarty->assign("umJS",$jssource);			// JS call and variables


?>
