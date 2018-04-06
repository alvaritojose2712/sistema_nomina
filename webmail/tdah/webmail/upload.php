<?php
ini_set("display_errors", 1);
	
	require('./inc/inc.php');
		 

	
	if (isset($rem) && $rem != "") {
	
		$attchs = $sess["attachments"];
		@unlink($attchs[$rem]["localname"]);
		unset($attchs[$rem]);
		$c = 0;
		$newlist = Array();
		while(list($key,$value) =  each($attchs)) {
			$newlist[$c] = $value; $c++;
		}
		$sess["attachments"] = $newlist;
		$SS->Save($sess);
		echo('
		<script language="javascript" type="text/javascript">
			if(window.opener) window.opener.doupload();
			setTimeout("self.close()",500);
		</script>
			<center><img src="themes/default/images/loading.gif" border="0"></center>
		');
	
	} elseif (
		isset($userfile) && 
		((!is_array($userfile) && is_uploaded_file($userfile)) || 
		is_uploaded_file($userfile["tmp_name"]))) {
		
		if ( filesize($userfile["tmp_name"]) == 0) {
			$smarty->assign("umError",1);
			$smarty->display("$selected_theme/"."upload-attach.htm");
		} else {
	
			//if(file_exists($userfile["tmp_name"])) {
		
			if($phpver >= 4.1) {
				$userfile_name  = $userfile["name"];
				$userfile_type	= $userfile["type"];
				$userfile_size	= $userfile["size"];
				$userfile		= $userfile["tmp_name"];
			}
		
			if(!is_array($sess["attachments"])) $ind = 0;
			else $ind = count($sess["attachments"]);
		
			$filename = $userfolder."_attachments/".md5(uniqid("")).$userfile_name;
		
			move_uploaded_file($userfile, $filename);
		
			$sess["attachments"][$ind]["localname"] = $filename;
			$sess["attachments"][$ind]["name"] = $userfile_name;
			$sess["attachments"][$ind]["type"] = $userfile_type;
			$sess["attachments"][$ind]["size"] = $userfile_size;
		
			$SS->Save($sess);
		
			echo('
			<script language="javascript" type="text/javascript">
				if(window.opener) window.opener.doupload();
				setTimeout("self.close()",500);
					</script>
							<center><img src="themes/default/images/loading.gif" border="0"></center>
			');
		}
	
	} else {
	
// Set SMARTY variables for templates and display
		$smarty->assign("pageMetas",$nocache);
		$smarty->assign("umError",0);
		$smarty->assign("umForms",$forms);

		$smarty->display("$selected_theme/"."upload-attach.htm");
	
	}
	
?>

