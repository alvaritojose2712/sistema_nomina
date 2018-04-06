<?php
ini_set("display_errors", 1);
 
require('./inc/inc.php');
	
	if(!isset($folder) || !isset($ix)) die("Expected parameters");
	
	$mail_info = $sess["headers"][base64_encode($folder)][$ix];
	
// Set SMARTY variables for templates and display
	$smarty->assign("umPageTitle",$mail_info["subject"]);
	$smarty->assign("umHeaders",preg_replace("/\t/","&nbsp;&nbsp;&nbsp;&nbsp;",nl2br(htmlspecialchars($mail_info["header"]))));
	
	$smarty->display("$selected_theme/"."headers-window.htm");

?>
