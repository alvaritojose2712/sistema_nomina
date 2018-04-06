<?php
ini_set("display_errors", 1);

require('./inc/inc.php');

	$filename = $userfolder."_infos/addressbook.ucf";
	$myfile = $UM->_read_file($filename);
	
	if($myfile != "") 
		$addressbook = unserialize(base64_decode($myfile));
		
	array_qsort2($addressbook,"name");
	$listbox = "<select name='contacts' class='quicklist' size='8' onDblClick=\"Add('to')\">\r\n";
	
	for($i=0;$i<count($addressbook);$i++) {
		$line = $addressbook[$i];
		$name = htmlspecialchars(trim($line["name"]));;
		$email = htmlspecialchars(trim($line["email"]));
		//$listbox .= "<option value=\"&quot;$name&quot; &lt;$email&gt;\"> &quot;$name&quot; &lt;$email&gt;";
		$listbox .= "<option value=\"&quot;$name&quot; &lt;$email&gt;\"> $name &lt;$email&gt;";
	}
	
	$listbox .= "</select>";
	
// Set SMARTY variables for templates and display
	$smarty->assign("umContacts",$listbox);

	$smarty->display("$selected_theme/"."quick_address.htm");

?>