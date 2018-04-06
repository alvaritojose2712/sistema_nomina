<?php
ini_set("display_errors", 1);
 
require('./inc/functions.php');
	
// Set SMARTY variables for templates and display
	$smarty->assign("pageMetas",$nocache);
	
	$smarty->assign("umUebimiauVersion",SW_VERSION." (<i>".SW_DATE."</i>)");
	$smarty->assign("umUebimiauLink",SW_LINK);
	$smarty->assign("umSmartyVersion",SMARTY_VERSION);
	$smarty->assign("umSmartyLink",SMARTY_LINK);
	$smarty->assign("umTinyMceVersion",TINYMCE_VERSION);
	$smarty->assign("umTinyMceLink",TINYMCE_LINK);
	//$smarty->assign("umWYSIWYGVersion",WYSIWYG_VERSION);
	$smarty->assign("umWYSIWYGLink",WYSIWYG_LINK);
	
	$smarty->assign("umLanguageHelp",$selected_language."-help.txt");

	$smarty->display("$selected_theme/"."help.htm");
	
	
?>
