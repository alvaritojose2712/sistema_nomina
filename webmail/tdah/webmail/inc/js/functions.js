/************************************************************************
	UebiMiau is a GPL'ed software developed by 
	 - Aldoir Ventura - aldoir@users.sourceforge.net
	 - http://uebimiau.sourceforge.net São Paulo - Brasil
   		
	***********************************************************************
	Version 3.2.0 Upgrades and templates developed by
	 - Todd Henderson - Lead Developer - http://tdah.us 
	 - Dave Rodgers - Developer - http://www.manvel.net 
	 - Laurent (AdNovea) - Developer - http://adnovea.free.fr
	 
	***********************************************************************
	 - Special thanks to the developers at 
	codeworxtech.com, tinymce.moxiecode.com
	telaen.org, phptoys.com, winged.info, ngcoders.com
	without help this project wouldn't be possible 
	
	***********************************************************************
	- File:			functions.js
	- Developer: 	Created by Laurent (AdNovea)
	- Date:			November 4, 2008
	- version:		(3.2.0) 1.0
	- Description:  All common javascript functions (eg. toolbar)
		PHP->JS variable passing is managed into functions.php

************************************************************************ */


// FUNCTIONS USED BY MESSAGES, FOLDERS and ALL TEMPLATES
// ===================================================

// Menu functions
	function refreshlist() { window.location.href  = 'process.php?lid=' + js_lid + '&tid=' + js_tid + '&refr=true&folder=' + js_encode_folder + '&pag=' + js_pag; }
	function goinbox() 	{ window.location.href  = 'messages.php?tid=' + js_tid + '&lid=' + js_lid + '&folder=inbox'; }
	function chat() 		{ window.location.href  = 'chat.php?lid=' + js_lid + '&tid=' + js_tid; }
	function newmsg() 		{ window.location.href  = 'newmsg.php?lid=' + js_lid + '&tid=' + js_tid + '&pag=' + js_pag + '&folder=' + js_encode_folder; }
	function calendar()   	{ window.location.href  = 'calendar.php?lid=' + js_lid + '&tid=' + js_tid; }
	function addresses() 	{ window.location.href  = 'addressbook.php?lid=' + js_lid + '&tid=' + js_tid; }
	function folderlist() 	{ window.location.href  = 'folders.php?lid=' + js_lid + '&tid=' + js_tid + '&folder=' + js_encode_folder; }
	function search() 		{ window.location.href  = 'search.php?lid=' + js_lid + '&tid=' + js_tid; }
	function prefs() 		{ window.location.href  = 'preferences.php?lid=' + js_lid + '&tid=' + js_tid; }
	function goend() 		{ window.location.href  = 'logout.php?lid=' + js_lid + '&tid=' + js_tid; }
	function help()		{ window.open('help.php?lid=' + js_lid + '&tid=' + js_tid,'Help','width=635, height=500, top=200, left=200, directories=no, toolbar=no, status=no, scrollbars=no, resizable=yes'); }
	function main() 	{ window.location.href  = 'main.php?tid=' + js_tid + '&lid=' + js_lid + '&folder=inbox'; }



// Submenu: messages flag/mark functions
	function flagmsg() 	{ with (document.form1) { decision.value = 'flagmsg'; submit(); } }
	function deflagmsg()  	{ with (document.form1) { decision.value = 'deflagmsg'; submit(); } }
	function markmsg() 	{ with (document.form1) { decision.value = 'mark'; submit(); } }
	function unmarkmsg() 	{ with (document.form1) { decision.value = 'unmark'; submit(); } }



// Submenu: Action functions
	function reply() 		{ document.msg.submit(); }
	function replyall() 	{ with (document.msg) { rtype.value = 'replyall'; submit(); } }
	function forward() 	{ with (document.msg) { rtype.value = 'forward'; submit(); } }
	function headers() 	{ mywin = window.open('headers.php?lid=' + js_lid + '&tid=' + js_tid + '&folder=' + js_encode_folder + '&ix=' + js_ix ,'Headers','width=550, top=200, left=200, height=320,directories=no,toolbar=no,status=no,scrollbars=yes,resizable=yes'); }
	function printit() 	{ window.open('printmsg.php?lid=' + js_lid + '&folder=' + js_encode_folder + '&ix=' + js_ix,'PrintView','resizable=1,top=100,left=100,width=700,height=500,scrollbars=1,status=0'); }


// Empty functions
//	function emptytrash() 	{ window.location.href  = 'folders.php?empty=trash&folder=' + js_encode_folder + '&goback=true';}
	function emptytrash() 	{ window.location.href  = 'folders.php?tid=' + js_tid + '&lid=' + js_lid + '&empty=' + js_sysmap_trash + '&folder=' + js_encode_folder + '&goback=true';}
	function emptyspam() 	{ window.location.href  = 'folders.php?tid=' + js_tid + '&lid=' + js_lid + '&empty=' + js_sysmap_spam + '&folder=' + js_encode_folder + '&goback=true';}


// Address management (Address book and block)
	function catch_addresses()	{ window.open('catch_address.php?lid=' + js_lid + '&tid=' + js_tid + '&folder=' + js_encode_folder + '&ix=' + js_ix,'Catch','width=550, top=200, left=200, height=200,directories=no,toolbar=no,status=no,scrollbars=yes'); }
	function block_addresses()	{ window.open('block_address.php?lid=' + js_lid + '&tid=' + js_tid + '&folder=' + js_encode_folder + '&ix=' + js_ix,'Block','width=400, top=250, left=250, height=200,directories=no,toolbar=no,status=no,scrollbars=yes'); }
	function spam_addresses() 	{ window.open('spam_address.php?lid=' + js_lid + '&tid=' + js_tid + '&folder=' + js_encode_folder + '&ix=' + js_ix,'Spam','width=400, top=250, left=250, height=200,directories=no,toolbar=no,status=no,scrollbars=yes'); }
	function add_address() 	{ window.location.href  = 'addressbook.php?lid=' + js_lid + '&tid=' + js_tid + '&opt=new'; }


// Read message either from message list or search	
	function readmsg(ix,read,folder) {
		if ( folder === undefined ) var folder = js_encode_folder;
	 window.location.href  = 'readmsg.php?lid=' + js_lid + '&tid=' + js_tid + '&folder=' + folder + '&pag=' + js_pag + '&ix='+ ix; 
	}
	
	function viewmsg(ix,read) {
	if(!read && no_quota)
		alert(quota_msg)
	else
  	document.getElementById('inline').src = 'viewmsg.php?folder=".urlencode($folder)."&pag=$pag&ix='+ix+'&tid=$tid&lid=$lid'; 
}
  
  function initIFrame () {document.getElementById('inline').src = 'iframe.php?tid=$itd&lid=$lid'; }
	

// Delete currently read message or multiple selected  messages from a folder
	function deletemsg() 	{ if (confirm(js_confirm_delete)) with (document.form1) { decision.value = 'delete'; submit(); } }

// Send to spam currently multiple selected  messages from a inbox
	function spammsg() 	{ if (confirm(js_confirm_spam)) with (document.form1) { decision.value = 'spam'; submit(); } }
	
//	function movemsg() { document.move.submit(); }
	function movemsg() { 
		 {
			with (document.form1) { decision.value = 'move'; submit(); } 
		}
	}

	
// Check/uncheck all items
	function sel() {
		with (document.form1) {
			for (i=0;i<elements.length;i++) {
				thiselm = elements[i];
				if (thiselm.name.substring(0,3) == 'msg') thiselm.checked = !thiselm.checked
			}
		}
	}


// Sort column ASC/DESC
	function sortby(col) {
		if(col == sort_colum) ord = (sort_order == 'ASC')?'DESC':'ASC';
		else ord = 'ASC';
		window.location.href  = 'process.php?lid=' + js_lid + '&tid=' + js_tid + '&folder=' + js_folder + '&pag=' + js_pag + '&sortby='+col + '&sortorder='+ord;
	}


// Open attached document dialog box
	function openmessage(attach) 	{ 
		window.open('readmsg.php?lid=' + js_lid + '&tid=' + js_tid + '&folder=' + js_encode_folder + '&pag=' + js_pag + '&ix=' + js_ix +
		 '&attachment='+attach,'','resizable=1,top=200,left=200,width=700,height=250,scrollbars=1,status=0'); 
	}


// MISCELLANEOUS FUNCTIONS
// ===================================================
	function admin() 				{ window.location.href  = 'admin.php?lid=' + js_lid + '&tid=' + js_tid; }
	
// Check folders names
// ---------------------------------------------------
	function create_form() {
		strPat = /[^A-Za-z0-9\s\-]/;
		frm = document.forms[0];
		strName = frm.newfolder.value
		mathArray = strName.match(strPat)
		if(mathArray != null) {
			alert(js_error_invalid_name)
			return false;
		} else {
			frm.submit();
		}
	}


// Enable selected stylesheet
// ---------------------------------------------------
	function setActiveStyleSheet(title) {
		
		var i, a, main;
		for (i=0; (a = document.getElementsByTagName("link")[i]); i++) {
			if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
				a.disabled = true;
				if(a.getAttribute("title") == title) a.disabled = false;
			}
		}
		document.getElementById('selskin').value = title;
	}


// Address book card's photo
// ---------------------------------------------------
	function Add_Photo(photo_id) {
	
		if (window.document.getElementById('email').value == "1") {
			alert(photo_msg);
			return;
		} else
			window.open('uploadphoto.php?lid=' + js_lid + '&tid=' + js_tid + '&id=' + photo_id + "&email=" + document.getElementById('email').value,'mywindow','width=350,height=125,left=200,top=200,screenX=0,screenY=100,scrollbars=0,menubar=0,status=0');
	}

	function remove_Photo() {
		window.document.getElementById('id_photo').src= '';
		window.document.form1.picturepath.value = '';
	}
	


// SPECIFIC FUNCTIONS FOR NEW MESSAGES
// ===================================================
// Add signature to message
	function addsig() {
		with (document.composeForm) {
			if(bsig_added || sig.value == '') return false;
			if(cksig.checked) {
				if(bIs_html) {					
					body.value +='<br><br>----<br>'+sig.value;
				} else
					body.value += '\\r\\n\\r\\n----\\r\\n'+sig.value;
			}
			cksig.disabled = true;
			bsig_added = true;
		}
		return true;
	}
	
// Attach document to message
	function upwin(rem) { 
		mywin = 'upload.php?lid=' + js_lid  + '&tid=' + js_tid;
		if (rem != null) mywin += '&rem='+rem ;
		else mywin += '';
		window.open(mywin,'Upload','width=400,height=100,left=200,top=200,scrollbars=0,resizable=0,menubar=0,status=0'); 
	}
	
	function doupload() {
		document.composeForm.tipo.value = 'edit';
		document.composeForm.submit();
	}
	

	function textmode() {
		with (document.composeForm) {
			textmode.value = 1;
			tipo.value = 'edit';
			submit();
		}
	}
	
// Send new message
	function sendmsg() {
		error_msg = new Array();
		frm = document.composeForm;
		check_mail(frm.to.value);
		check_mail(frm.cc.value);
		check_mail(frm.bcc.value);
		errors = error_msg.length;
	
		if(frm.to.value == '' && frm.cc.value == '' && frm.bcc.value == '')
			alert(js_error_no_recipients);
	
		else if (errors > 0) {
	
			if (errors == 1) errmsg = js_error_compose_invalid_mail1_s;
			else  errmsg = js_error_compose_invalid_mail1_p;
	
			for(i=0;i<errors;i++)
				errmsg += error_msg[i] + '\\r';
	
			if (errors == 1) errmsg += js_error_compose_invalid_mail2_s;
			else  errmsg += js_error_compose_invalid_mail2_p;
	
			alert(errmsg)
	
		} else {
			frm.tipo.value = 'send';
			frm.submit();
		}
	}
		
// Get address from address book
	function addrpopup(where) {
		url = 'quick_address.php?lid=' + js_lid + '&tid=' + js_tid + '&where=' + where;
		mywin = window.open(url,'AddressBook','width=420,height=350,top=200,left=200,scrollbars=0,menubar=0,status=0');
	}
	
// Add addresses into the address book
	function AddAddress(strType,strAddress) {
		obj = eval('document.composeForm.'+strType);
		if(obj.value == '') obj.value = strAddress
		else  obj.value = obj.value + ', ' + strAddress
	}
	
	function check_mail(strmail) {
		if(strmail == '') return;
		chartosplit = ',;';
		protectchar = '\"';
		temp = '';
		armail = new Array();
		inthechar = false; 
		lt = '<';
		gt = '>'; 
		isclosed = true;
	
		for(i=0;i<strmail.length;i++) {
			thischar = strmail.charAt(i);
			if(thischar == lt && isclosed) isclosed = false;
			if(thischar == gt && !isclosed) isclosed = true;
			if(thischar == protectchar) inthechar = (inthechar)?0:1;
			if(chartosplit.indexOf(thischar) != -1 && !inthechar && isclosed) {
				armail[armail.length] = temp; temp = '';
			} else temp += thischar;
		}
	
		armail[armail.length] = temp; 
	
		for(i=0;i<armail.length;i++) {
			thismail = armail[i]; strPat = /(.*)<(.*)>/;
			matchArray = thismail.match(strPat); 
			if (matchArray != null) strEmail = matchArray[2];
			else {
				strPat = /([-a-zA-Z0-9_$+.]+@[-a-zA-Z0-9_.]+[-a-zA-Z0-9_]+)((.*))/; matchArray = thismail.match(strPat); 
				if (matchArray != null) strEmail = matchArray[1];
				else strEmail = thismail;
			}
			if(strEmail.charAt(0) == '\"' && strEmail.charAt(strEmail.length-1) == '\"') strEmail = strEmail.substring(1,strEmail.length-1)
			if(strEmail.charAt(0) == '<' && strEmail.charAt(strEmail.length-1) == '>') strEmail = strEmail.substring(1,strEmail.length-1)
	
			strPat = /([-a-zA-Z0-9_$+.]+@[-a-zA-Z0-9_.]+[-a-zA-Z0-9_]+)((.*))/;
			matchArray = strEmail.match(strPat); 
			if(matchArray == null)
				error_msg[error_msg.length] = strEmail;
		}
	}
	

// Used in new message
	function set_newmsg_timeout() {
		window.setInterval(function() {
				new Ajax.Request('./inc/auth.php', {
						method: 'post',
						parameters: {action: 'pingSession'}
				});
		}, 100000);
	}
	

// Used in read message
	function sendReceipt(subj, msg) {
		new Ajax.Request('./inc/auth.php', {
			method: 'post',
			parameters: {action: 'sendReceipt', recipient: '" . $email["receipt-to"] . "', receipt_subj: subj, receipt_msg: msg}
		}); 
	}
	
	
	/////////////////////////////////
// clock
var timerID = null;
var timerRunning = false;
function stopclock (){
if(timerRunning)
	clearTimeout(timerID);
	timerRunning = false;
}
function showtime () {
	var now = new Date();
	var hours = now.getHours();
	var minutes = now.getMinutes();
	var seconds = now.getSeconds();
	var timeValue = "" + ((hours >12) ? hours -12 :hours)
	if (timeValue == "0"){timeValue = 12;}
	timeValue += ((minutes < 10) ? ":0" : ":") + minutes
	timeValue += ((seconds < 10) ? ":0" : ":") + seconds
	timeValue += (hours >= 12) ? " PM" : " AM"
	document.getElementById('clock').innerHTML = timeValue;

	// catch midnight rollover and refresh date
	if(timeValue == '0:00:01 AM'){makeDate();}

	timerID = setTimeout("showtime()",1000);
	timerRunning = true;
}

function startclock() {
	stopclock();
	showtime();
	makeDate();
}

function makeDate(){
	var mydate=new Date();
	var year=mydate.getYear();
	if(year < 1000){year+=1900;}
	var day=mydate.getDay();
	var month=mydate.getMonth();
	var daym=mydate.getDate();
	if (daym<10){daym="0"+daym;}
	var dayarray=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December");
	var datexx = dayarray[day]+", "+montharray[month]+" "+daym+", "+year;
	document.getElementById('dfield').innerHTML = datexx;
}

	
	
	
	
	
	

function calculate_time_zone() {
	var rightNow = new Date();
	var jan1 = new Date(rightNow.getFullYear(), 0, 1, 0, 0, 0, 0);  // jan 1st
	var june1 = new Date(rightNow.getFullYear(), 6, 1, 0, 0, 0, 0); // june 1st
	var temp = jan1.toGMTString();
	var jan2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
	temp = june1.toGMTString();
	var june2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
	var std_time_offset = (jan1 - jan2) / (1000 * 60 * 60);
	var daylight_time_offset = (june1 - june2) / (1000 * 60 * 60);
	var dst;
	if (std_time_offset == daylight_time_offset) {
		dst = "0"; // daylight savings time is NOT observed
	} else {
		// positive is southern, negative is northern hemisphere
		var hemisphere = std_time_offset - daylight_time_offset;
		if (hemisphere >= 0)
			std_time_offset = daylight_time_offset;
		dst = "1"; // daylight savings time is observed
	}
	var i;
	// check just to avoid error messages
	if (document.getElementById('timezone')) {
		for (i = 0; i < document.getElementById('timezone').options.length; i++) {
			if (document.getElementById('timezone').options[i].value == convert(std_time_offset)+","+dst) {
				document.getElementById('timezone').selectedIndex = i;
				break;
			}
		}
	}
}

function convert(value) {
	var hours = parseInt(value);
   	value -= parseInt(value);
	value *= 60;
	var mins = parseInt(value);
   	value -= parseInt(value);
	value *= 60;
	var secs = parseInt(value);
	var display_hours = hours;
	// handle GMT case (00:00)
	if (hours == 0) {
		display_hours = "00";
	} else if (hours > 0) {
		// add a plus sign and perhaps an extra 0
		display_hours = (hours < 10) ? "+0"+hours : "+"+hours;
	} else {
		// add an extra 0 if needed 
		display_hours = (hours > -10) ? "-0"+Math.abs(hours) : hours;
	}
	
	mins = (mins < 10) ? "0"+mins : mins;
	return display_hours+":"+mins;
}



