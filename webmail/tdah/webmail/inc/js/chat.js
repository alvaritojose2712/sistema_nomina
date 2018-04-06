// CHAT FUNCTIONs
// ===================================================
	var httpObject = null;
	var link = "";
	var timerID = 0;
	var js_lang = "";
	var js_nickName = "";

	var CHAT_SOUND_PLAYER 	= "inc/addons/dewplayer.swf";
	var CHAT_SOUND_PATH 	= "chat/sound/";
	var js_chatsound 		=  new Array();
	js_chatsound[0] 		= "alert.mp3";
	js_chatsound[1] 		= "login.mp3";
	js_chatsound[2] 		= "logout.mp3";
	js_chatsound[3] 		= "receive.mp3";
	js_chatsound[4] 		= "send.mp3";

	function clearchat() 	{ window.location.href  = './clearchat.php?lid=' + js_lid + '&tid=' + js_tid; }
	function endchat() 	{ window.location.href  = './logoutchat.php?lid=' + js_lid + '&tid=' + js_tid; }
	function updatechat() 	{ window.location.href  = './chat.php?lid=' + js_lid + '&tid=' + js_tid; }
	function loginchat() 	{ window.location.href  = './startchat.php?lid=' + js_lid + '&tid=' + js_tid; }
	
	
	

	function chat_beep(id) {
		var js_sound = CHAT_SOUND_PLAYER+"?mp3="+CHAT_SOUND_PATH+js_chatsound[id]+"&autostart=1";
		document.getElementById("chat_sound").data = js_sound; 
		document.getElementById("chat_audio").src = CHAT_SOUND_PATH+js_chatsound[id];
	}
	
	// TO BE DONE : Check if something has changed to output sound - USE THIS TO REFRESH USER AND FILES LIST
	// **************************************************************************
	function chat_check_change() {
		if (js_msg_size > js_msg_size_new) chat_beep(3);	// New message arrives
		if (js_msg_size < js_msg_size_new) chat_beep(0);	// Chat room has been cleared
		if (js_send_size > js_send_size_new) chat_beep(4);	// New file uploaded
		if (js_usr_size > js_usr_size_new) chat_beep(1);	// Someone has joined
		if (js_usr_size < js_usr_size_new) chat_beep(2);	// Someone has left
	// update file size values with new values
		js_msg_size = js_msg_size_new;
		js_send_size = js_send_size_new;
		js_usr_size = js_usr_size_new;
	}
	

	// Get the HTTP Object
	function getHTTPObject(){
		if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
		else if (window.XMLHttpRequest) return new XMLHttpRequest();
		else {
			alert("Your browser does not support AJAX.");
			return null;
		}
	}   
	
	// Change the value of the outputText field
	function setOutput(){
		if(httpObject.readyState == 4){
			var response = httpObject.responseText;
			var randomnumber=Math.floor(Math.random()*10000);
			var objDiv = document.getElementById("result");
			objDiv.innerHTML += response;
			objDiv.scrollTop = objDiv.scrollHeight;
			var inpObj = document.getElementById("msg");
			inpObj.value = "";
			inpObj.focus();
		}
	}
	
	// Change the value of the outputText field
	var chat_lastupdate;
	var chat_status;
	function setAll() {
		if(httpObject.readyState == 4){
			var response = httpObject.responseText;
			var randomnumber=Math.floor(Math.random()*10000);
			var objDiv = document.getElementById("result");
			var prev_length = objDiv.innerHTML.length;

			// Check for users/Files lists update
			update = response.split(':');					// Get timestamp and remove it
			chat_timestamp = update[0];
			if (chat_timestamp!=null && !isNaN(chat_timestamp)) {
				if (chat_lastupdate == undefined) chat_lastupdate = update[0];
				if (chat_timestamp != chat_lastupdate) { 
				// Force refresh ONLY if the chatter is NOT writing something (otherwise it erased the message and upset)
					if (document.getElementById('msg').value == "") {
						chat_lastupdate = chat_timestamp;		// If timestamp has changed, update users/file lists
						 window.location="chat.php?lid=" + js_lid + "&tid=" + js_tid;
					}
				}
				response = response.substring(chat_timestamp.length+1,response.length);
			} 
			update = response.split(':');					// Get status and remove it
			chat_status = update[0];
			if (chat_status!=null && !isNaN(chat_status)) {
				response = response.substring(chat_status.length+1,response.length);
				document.getElementById('status').value = chat_status;
			}
			objDiv.innerHTML = response;					// Display content

			// Generate sounds only when status is online
			if (chat_status < 2) {
				var cur_length = objDiv.innerHTML.length;		
				if (cur_length > prev_length) chat_beep(3);
				if (cur_length < prev_length) chat_beep(0);
			}
			// Scroll to the bottom of the discussion
			objDiv.scrollTop = objDiv.scrollHeight;
		}
	}
	
	// Encode the string into number to become insensitive to entities
	function encode_msg(stt) {
		var result = "";
		for (var i=0; i < stt.length; i++) result += ":"+stt.charCodeAt(i);
		return result;
	}

	// Implement business logic    
	function doWork(){    
		httpObject = getHTTPObject();
		if (httpObject != null) {
			var msg = encode_msg(document.getElementById('msg').value);
			link = "./message.php?nick=" + js_nickName+"&msg=" + msg + "&lid=" + js_lid + "&tid=" + js_tid;
			httpObject.open("GET", link , true);
			httpObject.onreadystatechange = setOutput;
			httpObject.send(null);
		}
	}
	
	// Implement business logic    
	function doReload(){    
		httpObject = getHTTPObject();
		var randomnumber=Math.floor(Math.random()*10000);
		if (httpObject != null) {
			link = "./message.php?all=1&rnd=" + randomnumber + "&lid=" + js_lid + "&tid=" + js_tid;
			httpObject.open("GET", link , true);
			httpObject.onreadystatechange = setAll;
			httpObject.send(null);
		}
	}
	
	// Setup time for page refresh
	function UpdateTimer() {
		doReload();   
		timerID = setTimeout("UpdateTimer()", 2000);
	}
	
	// On key pressed, process line user entry
	function keypressed(e){
		if(e.keyCode=='13'){
			doWork();
		}
	}
	

//-- Needed to resize on user Update request --//
	function chatroom_resize() {
		var BoxHeight = parent.document.body.clientHeight;
		var BoxWidth = parent.document.body.clientWidth;
		
		if (BoxHeight != "") {
			BoxHeight -= 140;	// Webmail Banner and Toolbar heights
			BoxHeight -= 53+24;	// Chat box banner, tabs and sender heights
			document.getElementById('result').style.height = BoxHeight + 'px';
			BoxHeight -= 11;	// Div alignement
			document.getElementById('users').style.height = (BoxHeight*0.7) + "px";
			document.getElementById('files').style.height = (BoxHeight*0.3)+ "px";
			document.getElementById('smileys').style.top = (BoxHeight-20)+ "px";
		}
		if (BoxWidth != "") {
			BoxWidth -= 180; // Left panel width
			document.getElementById('upfiles').style.left = (BoxWidth-295) + "px";
			BoxWidth -= 360; // Send button and Status width
			document.getElementById('msg').style.width = BoxWidth+ "px";
		}
	}

	function show_smileys() {
		if (document.getElementById('smileys').style.display == 'block')
			document.getElementById('smileys').style.display = 'none';
		else 
			document.getElementById('smileys').style.display = 'block';
	}
	
	function add_smiley(id) {
		document.getElementById('smileys').style.display = 'none';
		document.getElementById('msg').value += " "+smiley_code[id]+" ";
		document.getElementById('msg').focus();
	}
	
			
//-- Needed to resize on user Update request --//
	function admin_resize() {
		var BoxHeight = parent.document.body.clientHeight;
		var BoxWidth = parent.document.body.clientWidth;
		
		if (BoxHeight != "") {
			BoxHeight -= 140;	// Webmail Banner and Toolbar heights
			BoxHeight -= 53+24;	// Chat box banner, tabs and sender heights
			document.getElementById('result').style.height = BoxHeight + 'px';
			BoxHeight -= 11;	// Div alignement
			document.getElementById('users').style.height = (BoxHeight*0.7) + "px";
			document.getElementById('files').style.height = (BoxHeight*0.3)+ "px";
			document.getElementById('smileys').style.top = (BoxHeight-20)+ "px";
		}
		if (BoxWidth != "") {
			BoxWidth -= 180; // Left panel width
			document.getElementById('upfiles').style.left = (BoxWidth-295) + "px";
			BoxWidth -= 360; // Send button and Status width
			document.getElementById('msg').style.width = BoxWidth+ "px";
		}
	}