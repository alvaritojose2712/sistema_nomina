<?php
ini_set("display_errors", 1);
	header("cache-Control: no-cache, must-revalidate");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
	
	
include("class.calendar.php");

$calendar = new WingedCalendar();
$calendar->show_calendar(PREVIOUS, NEXT);


?>
	
	


