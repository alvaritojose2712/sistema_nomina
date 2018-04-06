<?php
ini_set("display_errors", 1);

	$thisfolder = dirname(__FILE__)."/../../";				    // Absolute path to Root
	
	require($thisfolder."inc/config/config.system.php");	// Include config.system.php
	require($thisfolder."inc/config/config.languages.php");						        // Include config.languages.php
	require($thisfolder."inc/config/config.themes.php");						          // Include config.themes.php
	require($thisfolder."inc/config/config.mail.php");							          // Include config.mail.php
	require($thisfolder."inc/config/config.php");						          // Include config.php
	//require($thisfolder."inc/config/config.chat.php");		                    // Include config.chat.php
	require($thisfolder."inc/config/config.paths.php");		                    // Include config.paths.php

?>