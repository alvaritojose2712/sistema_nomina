<?php
ini_set("display_errors", 1);

	require("inc/functions.php");
	require("editors/preferences_editor.php");
  define("PATH_PHOTO",$userfolder."_addressbook_photos/"); 
	// Add/Modify contact's photo
	function add_photo() {

		global $id, $f_user, $f_server, $addressbook, $picturepath;
		
		define("PATH_PHOTO",$userfolder."_addressbook_photos/"); 
		 
		$uploadfolder = PATH_PHOTO;
		
		$photoname = preg_replace("/[^a-z0-9\._-]/","_",strtolower($addressbook[$id]["email"]));
		
		$photoextension = $picturepath;
		
		
		if (!file_exists($uploadfolder)) return;	// No photo directory yet created for this account
		
	// Add or remove photo
		if ( (file_exists($uploadfolder."TEMP.$photoextension")) || ($picturepath == "") ) {

		// Delete previous contact photos
			$dp = opendir($uploadfolder);
			while ( $fileimage = readdir($dp) ) { 
				if ( basename($fileimage, end(explode('.',basename($fileimage)))) == $photoname."." )
					  unlink($uploadfolder.$fileimage); 
			}
			
		// Add (Rename temporary) contact's photo uploaded file
			if (!$picturepath == "") {
				$picturepath = "$uploadfolder$photoname.$photoextension";
				rename($uploadfolder."TEMP.$photoextension", $picturepath);
			}
			$addressbook[$id]["picturepath"] = $picturepath;
		}
		
	// Clean-up file cache - any TEMP.* files
		$dp = opendir($uploadfolder);
		while ( $fileimage = readdir($dp) ) { 
			if ( basename($fileimage, end(explode('.',basename($fileimage)))) == "TEMP." )
				  unlink($uploadfolder.$fileimage); 
		}
		
	}
	
	
	$filename = $userfolder."_infos/addressbook.ucf";
	$myfile = $UM->_read_file($filename);
	if($myfile != "")
			$addressbook = unserialize(base64_decode($myfile));
	array_qsort2($addressbook,"name");

	// Remove spaces before and after, reformat note from html editors
	$name = trim($name);
	$email = trim($email);
	$cell = trim($cell);
	$phone = trim($phone);
	$street = trim($street);
	$apt = trim($apt);
	$city = trim($city);
	$state = trim($state);
	$zip = trim($zip);
	$country = trim($country);
	$work = trim($work);
	$wemail = trim($wemail);
	$wphone = trim($wphone);
	$wfax = trim($wfax);
	$wstreet = trim($wstreet);
	$wcity = trim($wcity);
	$wstate = trim($wstate);
	$wzip = trim($wzip);
	$aemail = trim($aemail);
	$bday = trim($bday);
	$anniv = trim($anniv);
	$aim = trim($aim);
	$icq = trim($icq);
	$msn = trim($msn);
	$yahoo = trim($yahoo);
	$jabber = trim($jabber);
	$google = trim($google);
	$website = trim($website);
	$picturename = trim($picturename);
	$textnotes = str_replace("\\\"","\"",$textnotes);

	switch($opt) {
		// save an edited contact
		case "save":
		
			// category Home
			$addressbook[$id]["name"] = $name;
			$addressbook[$id]["email"] = $email;
			$addressbook[$id]["cell"] = $cell;
			$addressbook[$id]["phone"] = $phone;
			$addressbook[$id]["street"] = $street;
			$addressbook[$id]["apt"] = $apt;
			$addressbook[$id]["city"] = $city;
			$addressbook[$id]["state"] = $state;
			$addressbook[$id]["zip"] = $zip;
			$addressbook[$id]["country"] = $country;
			
			// category Work
			$addressbook[$id]["work"] = $work;
			$addressbook[$id]["wemail"] = $wemail;
			$addressbook[$id]["wphone"] = $wphone;
			$addressbook[$id]["wfax"] = $wfax;
			$addressbook[$id]["wstreet"] = $wstreet;
			$addressbook[$id]["wcity"] = $wcity;
			$addressbook[$id]["wstate"] = $wstate;
			$addressbook[$id]["wzip"] = $wzip;
			
			// category Extra
			$addressbook[$id]["aemail"] = $aemail;
			$addressbook[$id]["bday"] = $bday;
			$addressbook[$id]["anniv"] = $anniv;
			$addressbook[$id]["aim"] = $aim;
			$addressbook[$id]["icq"] = $icq;
			$addressbook[$id]["msn"] = $msn;
			$addressbook[$id]["yahoo"] = $yahoo;
			$addressbook[$id]["jabber"] = $jabber;
			$addressbook[$id]["google"] = $google;
			$addressbook[$id]["website"] = $website;
			
			// category Picture
			$addressbook[$id]["picturename"] = $picturename;
			add_photo();
		//	 $addressbook[$id]["picturepath"] = $picturepath;
			
			// category Notes
			$addressbook[$id]["textnotes"] = $textnotes;
			
			$UM->_save_file($filename,base64_encode(serialize($addressbook)));
		
			$smarty->assign("umDuplicateAddr",$addressbook[$id]["name"]);
			$smarty->assign("umOpt",1);
			$templatename = "address-results.htm";
		
			break;
	
		// add a new contact
		case "add":
		
		// Check if contact's name or e-mail is empty
			if ( ($name == "") || ($email == "") )
				$addr_error = 5;
	
		// Check if contact's e-mail already exists
			for($i=0;$i<count($addressbook);$i++) {
				if ( strtolower(trim($addressbook[$i]["email"])) == strtolower(trim($email)) ) {
					$smarty->assign("umDuplicateAddr",$addressbook[$i]["name"]);
					$addr_error = 4;
				}
			}
			
		// Abort new contact
			if (isset($addr_error)) {
				$smarty->assign("umOpt",$addr_error);
				$templatename = "address-results.htm";
				break;
			}
	
			$id = count($addressbook);
			
			$addressbook[$id]["name"] = $name;
			$addressbook[$id]["email"] = $email;
			$addressbook[$id]["phone"] = $phone;
			$addressbook[$id]["cell"] = $cell;
			$addressbook[$id]["street"] = $street;
			$addressbook[$id]["apt"] = $apt;
			$addressbook[$id]["city"] = $city;
			$addressbook[$id]["state"] = $state;
			$addressbook[$id]["zip"] = $zip;
			$addressbook[$id]["country"] = $country;
			
			// category Work
			$addressbook[$id]["work"] = $work;
			$addressbook[$id]["wemail"] = $wemail;
			$addressbook[$id]["wfax"] = $wfax;
			$addressbook[$id]["wstreet"] = $wstreet;
			$addressbook[$id]["wcity"] = $wcity;
			$addressbook[$id]["wstate"] = $wstate;
			$addressbook[$id]["wzip"] = $wzip;
			
			// category Extra
			$addressbook[$id]["aemail"] = $aemail;
			$addressbook[$id]["bday"] = $bday;
			$addressbook[$id]["anniv"] = $anniv;
			$addressbook[$id]["aim"] = $aim;
			$addressbook[$id]["icq"] = $icq;
			$addressbook[$id]["msn"] = $msn;
			$addressbook[$id]["yahoo"] = $yahoo;
			$addressbook[$id]["jabber"] = $jabber;
			$addressbook[$id]["google"] = $google;
			$addressbook[$id]["website"] = $website;
			$addressbook[$id]["textnotes"] = $textnotes;
			
			// category Picture
			$addressbook[$id]["picturename"] = $picturename;
			add_photo();
			//$addressbook[$id]["picturepath"] = $picturepath;
			
			// category Notes
			$addressbook[$id]["textnotes"] = $textnotes;
			
			$UM->_save_file($filename,base64_encode(serialize($addressbook)));
			
			$smarty->assign("umDuplicateAddr",$addressbook[$id]["name"]);
			$smarty->assign("umOpt",2);
			$templatename = "address-results.htm";
			
			break;
		
		//delete an existing contact
		case "delete":
	
			// Delete contact photos
			$uploadfolder = PATH_PHOTO;
	//		$userdir = preg_replace("/[^a-z0-9\._-]/","_",strtolower($f_user))."_".strtolower($f_server)."/";
			$photoname = preg_replace("/[^a-z0-9\._-]/","_",strtolower($addressbook[$id]["email"]));
			if (file_exists($uploadfolder)) {
				$dp = opendir($uploadfolder);
				while ( $fileimage = readdir($dp) ) { 
					if ( basename($fileimage, end(explode('.',basename($fileimage)))) == $photoname."." )
						  unlink($uploadfolder.$fileimage); 
				}
			}
	
			$smarty->assign("umDuplicateAddr",$addressbook[$id]["name"]);
			unset($addressbook[$id]);
			$newaddr = Array();
			while(list($l,$value) = each($addressbook))
					$newaddr[] = $value;
			$addressbook = $newaddr;
			$UM->_save_file($filename,base64_encode(serialize($addressbook)));
			
			$smarty->assign("umOpt",3);
			$templatename = "address-results.htm";
			
		break;
		
		// show the form to edit
		case "edit":
		
			// category Home
			$smarty->assign("umAddrName",$addressbook[$id]["name"]);
			$smarty->assign("umAddrEmail",$addressbook[$id]["email"]);
			$smarty->assign("umAddrPhone",$addressbook[$id]["phone"]);
			$smarty->assign("umAddrCell",$addressbook[$id]["cell"]);
			$smarty->assign("umAddrStreet",$addressbook[$id]["street"]);
			$smarty->assign("umAddrApt",$addressbook[$id]["apt"]);
			$smarty->assign("umAddrCity",$addressbook[$id]["city"]);
			$smarty->assign("umAddrState",$addressbook[$id]["state"]);
			$smarty->assign("umAddrZip",$addressbook[$id]["zip"]);
			$smarty->assign("umAddrCountry",$addressbook[$id]["country"]);
			
			// category Work
			$smarty->assign("umAddrWork",$addressbook[$id]["work"]);
			$smarty->assign("umAddrWemail",$addressbook[$id]["wemail"]);
			$smarty->assign("umAddrWphone",$addressbook[$id]["wphone"]);
			$smarty->assign("umAddrWfax",$addressbook[$id]["wfax"]);
			$smarty->assign("umAddrWstreet",$addressbook[$id]["wstreet"]);	
			$smarty->assign("umAddrWcity",$addressbook[$id]["wcity"]);	
			$smarty->assign("umAddrWstate",$addressbook[$id]["wstate"]);
			$smarty->assign("umAddrWzip",$addressbook[$id]["wzip"]);
			
			// category Extra
			$smarty->assign("umAddrAemail",$addressbook[$id]["aemail"]);
			$smarty->assign("umAddrBday",$addressbook[$id]["bday"]);
			$smarty->assign("umAddrAnniv",$addressbook[$id]["anniv"]);
			$smarty->assign("umAddrAim",$addressbook[$id]["aim"]);
			$smarty->assign("umAddrIcq",$addressbook[$id]["icq"]);
			$smarty->assign("umAddrMsn",$addressbook[$id]["msn"]);
			$smarty->assign("umAddrYahoo",$addressbook[$id]["yahoo"]);
			$smarty->assign("umAddrJabber",$addressbook[$id]["jabber"]);
			$smarty->assign("umAddrGoogle",$addressbook[$id]["google"]);
			$smarty->assign("umAddrWebsite",$addressbook[$id]["website"]);
			
			// category Notes
			$smarty->assign("umAddrNotes",$addressbook[$id]["textnotes"]);
			
			// category Picures
			$smarty->assign("umAddrPicturename",$addressbook[$id]["picturename"]);
			$smarty->assign("umAddrPicturepath",$addressbook[$id]["picturepath"]);
			
			$smarty->assign("umOpt","save");
			$smarty->assign("umAddrID",$id);
			$templatename = "address-form.htm";
		
			break;
	
		// display the details for an especified contact
		case "display":
		
			// category Home
			$smarty->assign("umAddrName",$addressbook[$id]["name"]);
			$smarty->assign("umAddrEmail",$addressbook[$id]["email"]);
			$smarty->assign("umAddrPhone",$addressbook[$id]["phone"]);
			$smarty->assign("umAddrCell",$addressbook[$id]["cell"]);
			$smarty->assign("umAddrStreet",$addressbook[$id]["street"]);
			$smarty->assign("umAddrApt",$addressbook[$id]["apt"]);
			$smarty->assign("umAddrCity",$addressbook[$id]["city"]);
			$smarty->assign("umAddrState",$addressbook[$id]["state"]);
			$smarty->assign("umAddrZip",$addressbook[$id]["zip"]);
			$smarty->assign("umAddrCountry",$addressbook[$id]["country"]);
			
			// category Work
			$smarty->assign("umAddrWork",$addressbook[$id]["work"]);
			$smarty->assign("umAddrWemail",$addressbook[$id]["wemail"]);
			$smarty->assign("umAddrWphone",$addressbook[$id]["wphone"]);
			$smarty->assign("umAddrWfax",$addressbook[$id]["wfax"]);
			$smarty->assign("umAddrWstreet",$addressbook[$id]["wstreet"]);	
			$smarty->assign("umAddrWcity",$addressbook[$id]["wcity"]);	
			$smarty->assign("umAddrWstate",$addressbook[$id]["wstate"]);
			$smarty->assign("umAddrWzip",$addressbook[$id]["wzip"]);
			
			// category Extra
			$smarty->assign("umAddrAemail",$addressbook[$id]["aemail"]);
			$smarty->assign("umAddrBday",$addressbook[$id]["bday"]);
			$smarty->assign("umAddrAnniv",$addressbook[$id]["anniv"]);
			$smarty->assign("umAddrAim",$addressbook[$id]["aim"]);
			$smarty->assign("umAddrIcq",$addressbook[$id]["icq"]);
			$smarty->assign("umAddrMsn",$addressbook[$id]["msn"]);
			$smarty->assign("umAddrYahoo",$addressbook[$id]["yahoo"]);
			$smarty->assign("umAddrJabber",$addressbook[$id]["jabber"]);
			$smarty->assign("umAddrGoogle",$addressbook[$id]["google"]);
			$smarty->assign("umAddrWebsite",$addressbook[$id]["website"]);
			
			// category Notes
			$smarty->assign("umAddrNotes",$addressbook[$id]["textnotes"]);
			
			// category Picures
			$smarty->assign("umAddrPicturename",$addressbook[$id]["picturename"]);
			$smarty->assign("umAddrPicturepath",$addressbook[$id]["picturepath"]);
			
			$smarty->assign("umAddrID",$id);
			$templatename = "address-display.htm";
		
			break;
		
		// show the form to a new contact
		case "new":
		
			$templatename = "address-form.htm";
	
			$smarty->assign("umOpt","add");
		//	$smarty->assign("umAddrID","N");
	
			break;
		
		        // export a contact

        case "expo":
            require("./inc/lib.export.php");
            export2ou($addressbook[$id]);
            break;

        case "file":
            switch ($fact) {
                case 'export':
                    switch ($expfmt) {
                        case 'xml':
                            export2xml($addressbook);
                            break;
                        case 'text':
                            export2txt($addressbook);
                            break;
                        case 'mscsv':
                            export2mscsv($addressbook);
                            break;
                    }
                    break;
                case 'import':
                    die("Not implemented yet");
                    break;
            }
            break;
	
		// default is list of contacts
		default:
		
			$addresslist = Array();
			
			// Prepare page of contacts
			$numcontact = count($addressbook);
			if(!isset($pag) || !is_numeric(trim($pag))) $pag = 1;
			
			$reg_pp    = $prefs["rpp"];
			$start_pos = ($pag-1)*$reg_pp;
			$end_pos   = (($start_pos+$reg_pp) > $numcontact) ? $numcontact : $start_pos + $reg_pp;
			
			if(($start_pos >= $end_pos) && ($pag != 1)) 
				redirect("addressbook.php?lid=$lid&tid=$tid&pag=".($pag-1)."\r\n");

			if($numcontact > 0) {
				if($pag > 1) $smarty->assign("umPreviousLink","addressbook.php?lid=$lid&tid=$tid&pag=".($pag-1));
				for($i=1;$i<=ceil($numcontact / $reg_pp);$i++) 
					if($pag == $i) $navigation .= "<b>$i</b> ";
					else $navigation .= "<a href=\"addressbook.php?lid=$lid&tid=$tid&&pag=$i\" class=\"navigation\">$i</a> ";
				if($end_pos < $numcontact) $smarty->assign("umNextLink","addressbook.php?lid=$lid&tid=$tid&pag=".($pag+1));
				$navigation .= " ($pag/".ceil($numcontact / $reg_pp).")";
			}
			$smarty->assign("umNavBar",$navigation);

			$form .= "
	<input type=\"hidden\" name=\"pag\" value=\"$pag\">
	<input type=\"hidden\" name=\"start_pos\" value=\"$start_pos\">
	<input type=\"hidden\" name=\"end_pos\" value=\"$end_pos\">";

			for($i=$start_pos;$i<$end_pos;$i++) {
			//for($i=0;$i<count($addressbook);$i++) {
				$ind = count($addresslist);
				$addresslist[$ind]["viewlink"] = "addressbook.php?lid=$lid&tid=$tid&opt=display&id=$i";
				$addresslist[$ind]["composelink"] = "newmsg.php?lid=$lid&tid=$tid&nameto=".htmlspecialchars($addressbook[$i]["name"])."&mailto=".htmlspecialchars($addressbook[$i]["email"]);
				$addresslist[$ind]["composelink2"] = "newmsg.php?lid=$lid&tid=$tid&nameto=".htmlspecialchars($addressbook[$i]["name"])."&mailto=".htmlspecialchars($addressbook[$i]["email2"]);
				$addresslist[$ind]["composelink3"] = "newmsg.php?lid=$lid&tid=$tid&nameto=".htmlspecialchars($addressbook[$i]["name"])."&mailto=".htmlspecialchars($addressbook[$i]["email3"]);
				$addresslist[$ind]["editlink"] = "addressbook.php?lid=$lid&tid=$tid&opt=edit&id=$i";
				$addresslist[$ind]["dellink"] = "addressbook.php?lid=$lid&tid=$tid&opt=delete&id=$i";
				
				
				// category Home
				$addresslist[$ind]["name"] = $addressbook[$i]["name"];
				$addresslist[$ind]["email"] = $addressbook[$i]["email"];
				$addresslist[$ind]["cell"] = $addressbook[$i]["cell"];
				$addresslist[$ind]["phone"] = $addressbook[$i]["phone"];
				$addresslist[$ind]["street"] = $addressbook[$i]["street"];
				$addresslist[$ind]["apt"] = $addressbook[$i]["apt"];
				$addresslist[$ind]["city"] = $addressbook[$i]["city"];
				$addresslist[$ind]["state"] = $addressbook[$i]["state"];
				$addresslist[$ind]["zip"] = $addressbook[$i]["zip"];
				$addresslist[$ind]["country"] = $addressbook[$i]["country"];
				
				// category Work
				$addresslist[$ind]["work"] = $addressbook[$i]["work"];
				$addresslist[$ind]["wemail"] = $addressbook[$i]["wemail"];
				$addresslist[$ind]["wphone"] = $addressbook[$i]["wphone"];
				$addresslist[$ind]["wfax"] = $addressbook[$i]["wfax"];
				$addresslist[$ind]["wstreet"] = $addressbook[$i]["wstreet"];
				$addresslist[$ind]["wcity"] = $addressbook[$i]["wcity"];
				$addresslist[$ind]["wstate"] = $addressbook[$i]["wstate"];
				
				// category Extra
				$addresslist[$ind]["aemail"] = $addressbook[$i]["aemail"];
				$addresslist[$ind]["bday"] = $addressbook[$i]["bday"];
				$addresslist[$ind]["anniv"] = $addressbook[$i]["anniv"];
				$addresslist[$ind]["aim"] = $addressbook[$i]["aim"];
				$addresslist[$ind]["icq"] = $addressbook[$i]["icq"];
				$addresslist[$ind]["msn"] = $addressbook[$i]["msn"];
				$addresslist[$ind]["yahoo"] = $addressbook[$i]["yahoo"];
				$addresslist[$ind]["jabber"] = $addressbook[$i]["jabber"];
				$addresslist[$ind]["google"] = $addressbook[$i]["google"];
				$addresslist[$ind]["website"] = $addressbook[$i]["website"];
				
				// category Extra
				$addresslist[$ind]["textnotes"] = $addressbook[$i]["textnotes"];
				
				// category Picture
				$addresslist[$ind]["picturename"] = $addressbook[$i]["picturename"];
				$addresslist[$ind]["picturepath"] = $addressbook[$i]["picturepath"];
			
			}
			$templatename = "address-list.htm";
			$smarty->assign("umAddressList",$addresslist);
			$smarty->assign("umNumAddress",count($addressbook));
	}
	
	$smarty->assign("umTemporary_directory",$temporary_directory);
	$smarty->assign("pageMetas",$nocache);
	$smarty->assign("umForms",$forms);
	$smarty->assign("umGoBack","addressbook.php?lid=$lid&tid=$tid");
	
	$smarty->display("$selected_theme/$templatename");
	
?>