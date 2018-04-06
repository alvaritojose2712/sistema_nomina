/* **********************************************************************
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
	- File:			webmail.js
	- Developer: 	Todd Henderson / Mods by Laurent (Adnovea)
	- Date:			November 9th, 2008
	- version:		3.2.2 (1.0)
	- Description:  Javascript functions devoted to templates with toolbar,
					menus , chat etc.

************************************************************************ */
  
  
//-- Login page select language function --//
	function selectLanguage() {
		sSix		= '';
		sUser		= '';
		sEmail		= '';
		sLanguage	= '';
		sTheme		= '';
		
		try {
			frm = document.forms[0];
			if(frm.six && frm.six.options)
				sSix = frm.six.options[frm.six.selectedIndex].value;
			if(frm.f_user)
				sUser = frm.f_user.value;
			if(frm.f_email)
				sEmail = frm.f_email.value;
			if(frm.tem)
				sTheme = frm.tem.options[frm.tem.selectedIndex].value;
			if(frm.lng)
				sLanguage = frm.lng.options[frm.lng.selectedIndex].value;
			sLocation = 'index.php?lid='+sLanguage + '&tid='+sTheme + '&f_user='+escape(sUser) + '&six='+sSix + '&f_email='+sEmail;
			location.replace(sLocation);
		} catch(err) {
			alert('Your brownser do not support JS');
		}
	}


//-- Mouse over effects --//

	function mOvr(src,clrOver) {
		if (!src.contains(event.fromElement)) {
			src.style.cursor = 'hand';
			src.bgColor = clrOver;
		}
	}
	function mOut(src,clrIn) {
		if (!src.contains(event.toElement)) {
			src.style.cursor = 'default';
			src.bgColor = clrIn;
		}
	}
	function mClk(src) {
		if(event.srcElement.tagName=='TD'){
			src.children.tags('A')[0].click();
		}
	}


//-- Tabs In Preferences and Addressbook --//
	function switchPrefsTab(tab) {
		// hide all
		document.getElementById('info').className='tab_hidden';
		document.getElementById('messages').className='tab_hidden';
		document.getElementById('signature').className='tab_hidden';
		document.getElementById('trash').className='tab_hidden';
		document.getElementById('skin').className='tab_hidden';
		document.getElementById('filters').className='tab_hidden';
		
		document.getElementById('tab_info').className='tab_info_hidden';
		document.getElementById('tab_messages').className='tab_info_hidden';
		document.getElementById('tab_signature').className='tab_info_hidden';
		document.getElementById('tab_trash').className='tab_info_hidden';
		document.getElementById('tab_skin').className='tab_info_hidden';
		document.getElementById('tab_filters').className='tab_info_hidden';
		
		// show needed
		document.getElementById('tab_'+tab).className='tab_info_visible';
		document.getElementById(tab).className='tab_visible';
	}
	
	function switchAddressTab(tab) {
		// hide all
		document.getElementById('home').className='tab_hidden';
		document.getElementById('work').className='tab_hidden';
		document.getElementById('extra').className='tab_hidden';
		document.getElementById('picture').className='tab_hidden';
		document.getElementById('notes').className='tab_hidden';
		
		document.getElementById('tab_home').className='tab_info_hidden';
		document.getElementById('tab_work').className='tab_info_hidden';
		document.getElementById('tab_extra').className='tab_info_hidden';
		document.getElementById('tab_picture').className='tab_info_hidden';
		document.getElementById('tab_notes').className='tab_info_hidden';
		
		// show needed
		document.getElementById('tab_'+tab).className='tab_info_visible';
		document.getElementById(tab).className='tab_visible';
	}


//-- Drop Downs --//
	var timeout         = 500;
	var closetimer		= 0;
	var ddmenuitem      = 0;


//-- open hidden layer --//
	function mopen(id) {	
		// cancel close timer
		mcancelclosetime();
	
		// close old layer
		if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
	
		// get new layer and show it
		ddmenuitem = document.getElementById(id);
		ddmenuitem.style.visibility = 'visible';
	
	}


//-- close showed layer --//
	function mclose() {
		if (ddmenuitem) ddmenuitem.style.visibility = 'hidden';
	}


//-- go close timer --//
	function mclosetime() {
		closetimer = window.setTimeout(mclose, timeout);
	}


//-- cancel close timer --//
	function mcancelclosetime() {
		if(closetimer)
		{
			window.clearTimeout(closetimer);
			closetimer = null;
		}
	}


//-- Return the height of the element without the unit (px) --//
	function get_Height(id_txt) { return (document.getElementById(id_txt).offsetHeight); }

//-- Return window width/height
	function inner_size() {
		var xSize = new Array();
		if( typeof( window.innerWidth ) == 'number' ) {
		//Non-IE
			xSize[0] = window.innerWidth;
			xSize[1] = window.innerHeight;
		} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		//IE 6+ in 'standards compliant mode'
			xSize[0]  = document.documentElement.clientWidth;
			xSize[1]  = document.documentElement.clientHeight;
		} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		//IE 4 compatible
			xSize[0]  = document.body.clientWidth;
			xSize[1]  = document.body.clientHeight;
		}
		return xSize;
	}


//-- Resize such as WYSISWYG editor windows or Admin iFrame --//
// ---------------------------------------------------
	function reSizeElementHeight(id_txt,offset) { document.getElementById(id_txt).style.height = inner_size()[1] - offset + "px"; }


//-- Resize IFRAME windows and Chat room elements --//
// ---------------------------------------------------
	function iframeResize(i_id) {
	
	// Get window height
		var xSize = new Array();
		xSize = inner_size();
		if ( (!xSize[1]  && document.getElementById(i_id).style.height == "") ) {
			document.getElementById(i_id).style.height = "550px";	// Cannot be adjusted dynamically
			return;
		} else {
			var containerWidth  = xSize[0];
			var containerHeight = xSize[1];
		}

	// Set IFRAME dimensions (required at startup even if it seems to be duplicated in the iframe (eg. chat-box)
		if (containerHeight != 0) {
			containerHeight -= 140;				// Webmail Banner and Toolbar heights
			document.getElementById(i_id).style.height = containerHeight + "px";
			
			// Resize chat-box elements
			if ( (i_id == "i_chat") ) {			// Avoid to access none existing element at login/logout
				if ( window.frames[0].document.getElementById('result') == null) return;
				ChatHeight = containerHeight-(53+24);			// Chat box banner, tabs and sender heights
				window.frames[0].document.getElementById('result').style.height = ChatHeight + "px";
				ChatHeight -= 11;			// Div alignement
				window.frames[0].document.getElementById('users').style.height = (ChatHeight*0.7) + "px";
				window.frames[0].document.getElementById('files').style.height = (ChatHeight*0.3)+ "px";
				window.frames[0].document.getElementById('smileys').style.top = (ChatHeight-20)+ "px";

				if (containerWidth != 0) {
					ChatWidth = containerWidth - 180; 	// Left panel width
					window.frames[0].document.getElementById('upfiles').style.left = (ChatWidth-295) + "px";
					ChatWidth -= 360; 					// Send button and Status width
					window.frames[0].document.getElementById('msg').style.width = ChatWidth + "px";
				}
			}
			
		}
	}


//-- Admin register users --//
// ---------------------------------------------------
	function admin_config(id) {
		if (id) {
			document.getElementById('ad_newuser').style.display='none'; 
			document.getElementById('ad_password1').style.display='none';
			document.getElementById('ad_password2').style.display='none';
			document.getElementById('ad_add').style.display='none';
			document.getElementById('ad_del').style.display='block';
		} else {
			document.getElementById('ad_newuser').style.display='block'; 
			document.getElementById('ad_password1').style.display='block';
			document.getElementById('ad_password2').style.display='block';
			document.getElementById('ad_add').style.display='block';
			document.getElementById('ad_del').style.display='none';
		}
	}
	


//-- Quick address pop-up functions --//
// ---------------------------------------------------
	function addItem(obj,strText,strValue,blSel,intPos){
		var newOpt,i,ArTemp,selIndex;
		selIndex = (blSel)?intPos:obj.selectedIndex;
		newOpt = new Option(strText,strValue);
		Len = obj.options.length+1
		if (intPos > Len) return
		obj.options.length = Len
		if (intPos != Len) {
			ArTemp = new Array();
			for(i=intPos;i<obj.options.length-1;i++)
				ArTemp[i] = Array(obj.options[i].text,obj.options[i].value);
			for(i=intPos+1;i<Len;i++)
				obj.options[i] = new Option(ArTemp[i-1][0],ArTemp[i-1][1]);
		}
		obj.options[intPos] = newOpt;
		if (selIndex > intPos)
			obj.selectedIndex = selIndex+1;
		else if (selIndex == intPos) 
			obj.selectedIndex = intPos;
	}
	
	function delItem(obj,intPos){
		if(intPos > obj.length) return;
		obj.options[intPos] = null
	}
	
	function Add(sTipo) {
		frm = document.forms[0];
		dest = eval("frm."+sTipo)
		orig = frm.contacts;
		if(orig.selectedIndex == -1) {
			alert(qad_select_address);
			return
		}
		addItem(dest,orig.options[orig.selectedIndex].value,orig.options[orig.selectedIndex].value,false,dest.length)
	}
	
	function Dele(sTipo) {
		frm = document.forms[0];
		orig = eval("frm."+sTipo)
		if(orig.selectedIndex == -1) {
			alert(qad_select_address);
			return
		}
		delItem(orig,orig.selectedIndex)
	}
	
	function AddAndExit() {
		frm = document.forms[0];
		typs = new Array("to","cc","bcc");
		for(i=0;i<typs.length;i++) {
			orig = eval("frm."+typs[i]);
			for(n=0;n<orig.length;n++)
				window.opener.AddAddress(typs[i],orig.options[n].value);
		}
		self.close();
	}
	
	function ns_clean() {
		frm = document.forms[0];
		typs = new Array("to","cc","bcc");
		for(i=0;i<typs.length;i++) {
			orig = eval("frm."+typs[i]);
			orig.selectedIndex = 0;
			Dele(typs[i]);
		}
	}

	// Add extra upload form to upload.php *experimental* 
	function addRow() {
     document.form1.count.value = parseInt(document.form1.count.value) + 1;
     var i = parseInt(document.form1.count.value);
  	 var table;
	   if (document.all)
	   table = document.all.uploadtable;
	   else if (document.getElementById)
	   table = document.getElementById('uploadtable');
	   if (table && table.rows && table.insertRow) {
	   var tr = table.insertRow(table.rows.length);
	   var td = tr.insertCell(tr.cells.length);
     data = '<input type="file" name="upload' + i + '" class="textboxgray"><br>';
	   td.innerHTML = data;
	 }
 }

//-- Help pages tab switcher --//
	function switchHelpTab(tab) {
		// hide all
		document.getElementById('general').className='tab_hidden';
		document.getElementById('inbox').className='tab_hidden';
		document.getElementById('chat').className='tab_hidden';
		document.getElementById('calendar').className='tab_hidden';
		document.getElementById('compose').className='tab_hidden';
		document.getElementById('address').className='tab_hidden';
		document.getElementById('folders').className='tab_hidden';
		document.getElementById('search').className='tab_hidden';
		document.getElementById('preferences').className='tab_hidden';
		document.getElementById('credits').className='tab_hidden';
		
		document.getElementById('tab_general').className='tab_info_hidden';
		document.getElementById('tab_inbox').className='tab_info_hidden';
		document.getElementById('tab_chat').className='tab_info_hidden';
		document.getElementById('tab_calendar').className='tab_info_hidden';
		document.getElementById('tab_compose').className='tab_info_hidden';
		document.getElementById('tab_address').className='tab_info_hidden';
		document.getElementById('tab_folders').className='tab_info_hidden';
		document.getElementById('tab_search').className='tab_info_hidden';
		document.getElementById('tab_preferences').className='tab_info_hidden';
		document.getElementById('tab_credits').className='tab_info_hidden';
		
		// show needed
		document.getElementById('tab_'+tab).className='tab_info_visible';
		document.getElementById(tab).className='tab_visible';
	}

	// Not nice implementation but no time to get something better !!!!
	function help_resize() {
		var h_height = inner_size()[1];
		document.getElementById('general').style.height = h_height-45;
		document.getElementById('chat').style.height = h_height-45;
		document.getElementById('calendar').style.height = h_height-45;
		document.getElementById('inbox').style.height = h_height-45;
		document.getElementById('compose').style.height = h_height-45;
		document.getElementById('address').style.height = h_height-45;
		document.getElementById('folders').style.height = h_height-45;
		document.getElementById('search').style.height = h_height-45;
		document.getElementById('preferences').style.height = h_height-45;
		document.getElementById('credits').style.height = h_height-45;
	}



<!-- *** -->




function ShowHideTable(w, i, changeimg) {
	// w is the <table> classname
	// i is the <img> classname
	// changeimg is true or false
	if (document.getElementById(w).className == 'tablehide') {
		document.getElementById(w).className = 'tableshow';
		if (changeimg) 
			document.getElementById(i).src = 'themes/default/images/toolbar/minus.gif';
	} else {
		document.getElementById(w).className = 'tablehide';
		if (changeimg)
			document.getElementById(i).src = 'themes/default/images/toolbar/plus.gif';
	};
}


// *****

var dhtmlgoodies_slideSpeed = 10;	// Higher value = faster
var dhtmlgoodies_timer = 10;	// Lower value = faster

var objectIdToSlideDown = false;
var dhtmlgoodies_activeId = false;
var dhtmlgoodies_slideInProgress = false;

function showHideContent(e,inputId)
{
	if(dhtmlgoodies_slideInProgress)return;
	dhtmlgoodies_slideInProgress = true;
	if(!inputId)inputId = this.id;
	inputId = inputId + '';
	var numericId = inputId.replace(/[^0-9]/g,'');
	var answerDiv = document.getElementById('dhtmlgoodies_a' + numericId);

	objectIdToSlideDown = false;
	
	if(!answerDiv.style.display || answerDiv.style.display=='none'){		
		if(dhtmlgoodies_activeId &&  dhtmlgoodies_activeId!=numericId){			
			objectIdToSlideDown = numericId;
			slideContent(dhtmlgoodies_activeId,(dhtmlgoodies_slideSpeed*-1));
		}else{
			
			answerDiv.style.display='block';
			answerDiv.style.visibility = 'visible';
			
			slideContent(numericId,dhtmlgoodies_slideSpeed);
			document.getElementById('attachimg').src = 'themes/default/images/toolbar/minus.gif';
}
	}else{
		slideContent(numericId,(dhtmlgoodies_slideSpeed*-1));
		dhtmlgoodies_activeId = false;
		document.getElementById('attachimg').src = 'themes/default/images/toolbar/plus.gif';
	}	

}

function slideContent(inputId,direction)
{
	
	var obj =document.getElementById('dhtmlgoodies_a' + inputId);
	var contentObj = document.getElementById('dhtmlgoodies_ac' + inputId);
	height = obj.clientHeight;
	if(height==0)height = obj.offsetHeight;
	height = height + direction;
	rerunFunction = true;
	if(height>contentObj.offsetHeight){
		height = contentObj.offsetHeight;
		rerunFunction = false;
	}
	if(height<=1){
		height = 1;
		rerunFunction = false;
	}

	obj.style.height = height + 'px';
	var topPos = height - contentObj.offsetHeight;
	if(topPos>0)topPos=0;
	contentObj.style.top = topPos + 'px';
	if(rerunFunction){
		setTimeout('slideContent(' + inputId + ',' + direction + ')',dhtmlgoodies_timer);
	}else{
		if(height<=1){
			obj.style.display='none'; 
			if(objectIdToSlideDown && objectIdToSlideDown!=inputId){
				document.getElementById('dhtmlgoodies_a' + objectIdToSlideDown).style.display='block';
				document.getElementById('dhtmlgoodies_a' + objectIdToSlideDown).style.visibility='visible';
				slideContent(objectIdToSlideDown,dhtmlgoodies_slideSpeed);				
			}else{
				dhtmlgoodies_slideInProgress = false;
			}
		}else{
			dhtmlgoodies_activeId = inputId;
			dhtmlgoodies_slideInProgress = false;
		}
	}
}



function initShowHideDivs()
{
	var divs = document.getElementsByTagName('DIV');
	var divCounter = 1;
	for(var no=0;no<divs.length;no++){
		if(divs[no].className=='dhtmlgoodies_question'){
			divs[no].onclick = showHideContent;
			divs[no].id = 'dhtmlgoodies_q'+divCounter;
			var answer = divs[no].nextSibling;
			while(answer && answer.tagName!='DIV'){
				answer = answer.nextSibling;
			}
			answer.id = 'dhtmlgoodies_a'+divCounter;	
			contentDiv = answer.getElementsByTagName('DIV')[0];
			contentDiv.style.top = 0 - contentDiv.offsetHeight + 'px'; 	
			contentDiv.className='dhtmlgoodies_answer_content';
			contentDiv.id = 'dhtmlgoodies_ac' + divCounter;
			answer.style.display='none';
			answer.style.height='1px';
			divCounter++;
		}		
	}	
}
window.onload = initShowHideDivs;



function delayer(){
				parent.document.location.href = 'addressbook.php?lid=' + js_lid + '&tid=' + js_tid; }



	
