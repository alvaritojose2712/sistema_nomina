<?php
ini_set("display_errors", 1);
 
	require('./inc/inc.php');
	if(!isset($folder) || !isset($ix)) die("Expected parameters");
	
	// with ie4+/mozilla/ns6+ use iframe for display body  

	$body = $sess["currentbody"];
	$meta_charset = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=" . $default_char_set . "\">";
	echo($nocache);
	echo($meta_charset);
	echo($body);

?>
