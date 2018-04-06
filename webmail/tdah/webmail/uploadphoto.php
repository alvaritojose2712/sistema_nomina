<?php
ini_set("display_errors", 1);
	require("./inc/inc.php");

	define("PATH_PHOTO",$userfolder."_addressbook_photos/"); 
	$smarty->assign("pageMetas",$nocache);
	
	$filename = $userfolder."_infos/addressbook.ucf";
	$myfile = $UM->_read_file($filename);
	
	if($myfile != "")
			$addressbook = unserialize(base64_decode($myfile));
	array_qsort2($addressbook,"name");

	$id = isset($id) ? $_GET['id'] : $id;
	$email = ($id == "N") ? $_GET['email'] : $addressbook[$id]["email"];

// Uload button has been depressed
	if (isset($_POST['submitBtn'])) {
		$error = 0;
	// Check for valid image formats
		if (strpos($_FILES[upfile]['type'], "image")===FALSE) $error = 1;
		
	// Check photo directories
		$uploadfolder = PATH_PHOTO;
		//$userdir = preg_replace("/[^a-z0-9\._-]/","_",strtolower($f_user))."_".strtolower($f_server)."/";
		$photoname = preg_replace("/[^a-z0-9\._-]/","_",strtolower($email));
	
		if ( ($error == 0) && (!file_exists($uploadfolder)) )
		if (!mkdir (dirname(__FILE__)."/$uploadfolder")) $error = 2;
			
	// Delete previous temporary photo
		if ($error == 0) {
			$dp = opendir($uploadfolder);
			while ( $fileimage = readdir($dp) ) { 
				if ( basename($fileimage, end(explode('.',basename($fileimage)))) == "TEMP." )
					  unlink($uploadfolder.$fileimage); 
			}

		// Upload fileas TEMP with image file extension and update picture displayed in contact form
			$target_ext = end(explode('.',basename( $_FILES['upfile']['name'])));
			$target_path = $uploadfolder . "TEMP.$target_ext";			
			
			if (move_uploaded_file($_FILES['upfile']['tmp_name'], $target_path)) {

			// Check image size
				$size = GetImageSize($target_path);
				list ($foo, $width, $bar, $height) = explode('"',$size[3]);
				if ( ($width > $image_max_width) || ($height > $image_max_height) ) 
					$error = 4;
				else {
					echo("
					<script language=\"javascript\" type=\"text/javascript\">\n
						window.opener.document.form1.picturepath.value = '$target_ext';
						window.opener.document.form1.id_photo.src = '$target_path';
						setTimeout('self.close()',500);\n
					</script>\n
					");
					exit;
				}
			} else
				$error = 3;
		} 
	}

// Set SMARTY variables for templates and display
	$error = preg_replace("#\[\]#", "", $error);
	$smarty->assign("umServerResponse",$error);
	$smarty->assign("umTemporary_directory",$temporary_directory);
	$smarty->assign("umUserfolder",$userfolder);
	$smarty->assign("umPhotoEmail",$email);
	$smarty->assign("umAddrPicturepath",$addressbook[$id]["picturepath"]);
	$smarty->assign("umOpt","save");
	$smarty->assign("umAddrID",$id);
	$smarty->assign("umForms",$forms);
	
	$smarty->display("$selected_theme/"."upload-photo.htm");
	
?>
 
				  