<?php


// Add common.js, funtions.js and prototype.js
//	$jssource = $commonJS;

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
		plugin_insertdate_dateFormat : '".preg_replace("#'#","\\'",$tiny_mce_date)."', 
		plugin_insertdate_timeFormat : '".preg_replace("#'#","\\'",$tiny_mce_time)."',

		
	plugins : 'contextmenu,paste,safari,advhr,emotions,preview,print,paste,spellchecker,directionality,fullscreen',

		skin : 'o2k7',
		skin_variant : 'silver',
		theme_advanced_buttons1 : 'fontselect,fontsizeselect,bold,italic,underline,separator,undo,redo,separator,spellchecker,separator,charmap,outdent,indent,blockquote,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,separator,forecolor,backcolor,separator,emotions,hr,advhr,code,fullscreen',
		theme_advanced_buttons2 : '',
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
	
	function toggleEditor(id) { 
if (!tinyMCE.get(id)) 
tinyMCE.execCommand('mceAddControl', false, id); 
else 
tinyMCE.execCommand('mceRemoveControl', false, id); 
} 
	
	
	</script>";
	$smarty->assign("umJS",$jssource);			// JS call and variables

?>