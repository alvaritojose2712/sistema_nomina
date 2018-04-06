<?php
ini_set("display_errors", 1);

require('./inc/functions.php');


	
	
	$metadata = "<meta http-equiv=\"Cache-Control\" content=\"no-cache\">
	<meta http-equiv=\"Expires\" content=\"-1\">";


	$smarty->display("$selected_theme/"."calendar.htm");

?>
