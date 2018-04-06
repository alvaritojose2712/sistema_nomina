{* **********************************************************************
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
	Version 3.2.0 Upgrades and templates

	- File:			toolbar.tpl
	- Developer: 	Laurent (AdNovea)
	- Date:			November 4, 2008
	- version:		(3.2.0) 1.0
	- Description:  Code to manage all the toolbars

	Item selection is done with:
					
	where "constants" are:
	umTLB_NONE			No toolbar
	umTLB_LOGOFF		Logout right button
	umTLB_FOLDERS		Folder header
	umTLB_REFRESH		Check for incoming mail
	umTLB_COMPOSE		Compose new message
	umTLB_DEL_SELECT	Delete selected message
	umTLB_DELETE		Delete
	umTLB_SPAM			Set SPAM messages
	umTLB_SPAM_SELECT	Spam selected message
	umTLB_MOVE			Move messages to folder
	umTLB_SEND			Send message
	umTLB_ATTACH		Attach document
	umTLB_MARK_FLAG		Mark or flag messages
	umTLB_ACTION		Forward / Reply on message
	umTLB_UP_DOWN		Access next or previous message

************************************************************************* *}

	<!--"start top bar" --> 		       
	{if !$umTLB_NONE}
	<tr height="28">
		<td class="bar" height="28" width="100%">
		
			<table class="tablecollapsed">
			<tr>
			<td><ul id="topleft">
			{if $umTLB_FOLDERS}
				<li><a><img src="themes/{$umTPath}/images/toolbar/clear.gif" alt="" border="0" align="middle"><b>{$umFolderNb}&nbsp;{#folders_mnu#} {if $umMsgNb gt 0}[{$umMsgNb}]{/if}</b></a></li>
				{if $umTLB_FOLDERS eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle">&nbsp;</a></li>
				{/if}
			{/if}
	
			{if $umTLB_REFRESH}
				<li><a href="javascript:refreshlist();" title="{#refresh_mnu#}">
					<img src="themes/{$umTPath}/images/toolbar/check.gif" alt="" border="0" align="middle">&nbsp;{#refresh_mnu#}</a></li>
				{if $umTLB_REFRESH eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				{/if}		
			{/if}		
	
			{if $umTLB_COMPOSE}
				<li><a href="javascript:newmsg();" title="{#compose_mnu#}">
					<img src="themes/{$umTPath}/images/toolbar/new.gif" alt="" border="0" align="middle">&nbsp;{#compose_mnu#}</a> </li>
				{if $umTLB_COMPOSE eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				{/if}		
			{/if}		
	
			{if $umTLB_DEL_SELECT}
				<li><a href="javascript:deletemsg();" title="{#delete_selected_mnu#}">
					<img src="themes/{$umTPath}/images/toolbar/delete.gif" alt="" border="0" align="middle">&nbsp;{#delete_selected_mnu#}</a> </li>
				{if $umTLB_DEL_SELECT eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>	   
				{/if}	
			{/if}	
		{if $umTLB_SPAM_SELECT}
				<li><a href="javascript:spammsg();" title="{#spam_selected_mnu#}">
					<img src="themes/{$umTPath}/images/toolbar/spam.gif" alt="" border="0" align="middle">&nbsp;{#spam_selected_mnu#}</a> </li>
				{if $umTLB_SPAM_SELECT eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>	   
				{/if}	
			{/if}
			{if $umTLB_DELETE}
				<li><a href="javascript:deletemsg();" title="{#delete_mnu#}">
					<img src="themes/{$umTPath}/images/toolbar/delete.gif" alt="" border="0" align="middle">&nbsp;{#delete_mnu#}</a> </li>
				{if $umTLB_DELETE eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				{/if}	
			{/if}	
	
			{if $umTLB_SPAM}
				<li><a href="javascript:spam_addresses();" title="{#spam_message_mnu#}">
					<img src="themes/{$umTPath}/images/toolbar/spam.gif" alt="{#spam_message_mnu#}" border="0" align="middle">&nbsp;{#spam_mnu#}</a> </li>
				{if $umTLB_SPAM eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				{/if}	
			{/if}	
	
			{if $umTLB_MOVE}
				<li><a href="#" onmouseover="javascript:mopen('m4');" onmouseout="javascript:mclosetime();" title="{#move_mnu#}">
					<img src="themes/{$umTPath}/images/toolbar/move.gif" alt="" border="0" align="middle">&nbsp;&nbsp;{#move_mnu#}</a><br>
				<div id="m4" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
					{section name=i loop=$umAvalFolders}
						<a href='#' onclick='javascript:document.form1.aval_folders.value="{$umAvalFolders[i].path|escape:"html"}"; movemsg();'>
						<img src="themes/{$umTPath}/images/toolbar/folder.gif" border="0" align="middle" alt="{#move_selected_mnu#}">
						&nbsp;&nbsp;{$umAvalFolders[i].display|escape:"html"}</a>
					{/section}		
				</div></li>
				{if $umTLB_MOVE eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				{/if}		
			{/if}		
	
			{if $umTLB_SEND}
				<li><a href="javascript:sendmsg();" title="{#send_text#}">
					<img src="themes/{$umTPath}/images/toolbar/send.gif" alt="" border="0" align="middle">&nbsp;{#send_text#}</a> </li>
				{if $umTLB_SEND eq 1}
					<li class="separator"><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				{/if}		
			{/if}		
	
			{if $umTLB_ATTACH}
				<li><a href="javascript:upwin();" title="{#attch_add_new#}">
					<img src="themes/{$umTPath}/images/toolbar/clip.gif" alt="" border="0" align="middle">&nbsp;{#attch_add_new#}</a> </li>
				{if $umTLB_ATTACH eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				{/if}		
			{/if}		
	
			{if $umTLB_MARK_FLAG}
			<li><a href="#" onmouseover="javascript:mopen('m3');" onmouseout="javascript:mclosetime();" title="{#actions_mnu#}">
				<img src="themes/{$umTPath}/images/toolbar/marked.gif" alt="" border="0" align="middle">&nbsp;{#actions_mnu#}</a><br>
				<div id="m3" onmouseover="javascript:mcancelclosetime();" onmouseout="javascript:mclosetime();">
					<a href="javascript:markmsg();"><img src="themes/{$umTPath}/images/toolbar/read.gif" alt="" border="0" align="middle">&nbsp;&nbsp;{#mark_selected_mnu#}</a>
					<a href="javascript:unmarkmsg();"><img src="themes/{$umTPath}/images/toolbar/msg.gif" alt="" border="0" align="middle">&nbsp;&nbsp;{#unmark_selected_mnu#}</a>
					<a href="javascript:flagmsg();"><img src="themes/{$umTPath}/images/toolbar/flagged.gif" alt="" border="0" align="middle">&nbsp;&nbsp;{#flag_selected_mnu#}</a>
					<a href="javascript:deflagmsg();"><img src="themes/{$umTPath}/images/toolbar/deflagged.gif" alt="" border="0" align="middle">&nbsp;&nbsp;{#deflag_selected_mnu#}</a>
				</div></li>
				{if $umTLB_MARK_FLAG eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				{/if}		
			{/if}		
	
			{if $umTLB_ACTION}
				<li><a href="#" onmouseover="javascript:mopen('m3');" onmouseout="javascript:mclosetime();" title="{#actions_mnu#}">
					<img src="themes/{$umTPath}/images/toolbar/marked.gif" alt="" border="0" align="middle">&nbsp;{#actions_mnu#}</a><br>
				<div id="m3" onmouseover="javascript:mcancelclosetime();" onmouseout="javascript:mclosetime();">
					<a href="javascript:reply();"><img src="themes/{$umTPath}/images/toolbar/reply_mail.gif" alt="" border="0" align="middle">&nbsp;&nbsp;{#reply_mnu#}</a>
					<a href="javascript:replyall();"><img src="themes/{$umTPath}/images/toolbar/replyall_mail.gif" alt="" border="0" align="middle">&nbsp;&nbsp;{#reply_all_mnu#}</a>
					<a href="javascript:forward();"><img src="themes/{$umTPath}/images/toolbar/forward_mail.gif" alt="" border="0" align="middle">&nbsp;&nbsp;{#forward_mnu#}</a>
					<a href="#"><img src="themes/{$umTPath}/images/toolbar/hdivide.gif" alt="" border="0" align="middle"></a>
					<a href="javascript:catch_addresses();"><img src="themes/{$umTPath}/images/toolbar/contacts.gif" alt="" border="0" align="middle">&nbsp;&nbsp;{#catch_address#}</a>
					<a href="javascript:headers();"><img src="themes/{$umTPath}/images/toolbar/header.gif" alt="" border="0" align="middle">&nbsp;&nbsp;{#headers_mnu#}</a>
					<a href="javascript:printit();"><img src="themes/{$umTPath}/images/toolbar/print.gif" alt="" border="0" align="middle">&nbsp;&nbsp;{#print_mnu#}</a>
					<a href="javascript:block_addresses();"><img src="themes/{$umTPath}/images/toolbar/block.gif" alt="" border="0" align="middle">&nbsp;&nbsp;{#block_address#}</a>
				</div></li>        
				{if $umTLB_ACTION eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				{/if}		
			{/if}		
	
			{if $umTLB_NEW_ENTRY}
				<li><a href="javascript:add_address();" title="{#adr_new_entry#}">
				<img src="themes/{$umTPath}/images/toolbar/cont.gif" border="0" align="middle" alt="">&nbsp;{#adr_new_entry#}</a></li>
				{if $umTLB_NEW_ENTRY eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				{/if}
			{/if}
			{if $umTLB_MAIN eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				{/if}
				{if $umTLB_MAIN}
				<li><a href="javascript:main();" title="{#main_mnu#}">
				<img src="themes/{$umTPath}/images/toolbar/home.gif" border="0" align="middle" alt="">&nbsp;{#main_mnu#}</a></li>
				{if $umTLB_MAIN eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				{/if}
			{/if}

			{if $umTLB_UP_DOWN}
				{if $umHavePrevious eq 1}
					<li><a href="{$umPreviousLink}" title="{$umPreviousSubject}"><img src="themes/{$umTPath}/images/toolbar/prev_mail.gif" alt="" border="0" align="middle"></a> </li>
				{else}
					<li><a><img src="themes/{$umTPath}/images/toolbar/prev_mail_2.gif" border="0" align="middle" alt=""></a></li>
				{/if}
				{if $umHaveNext eq 1}    	
					<li><a href="{$umNextLink}" title="{$umNextSubject}"><img src="themes/{$umTPath}/images/toolbar/next_mail.gif" alt="" border="0" align="middle"></a> </li>
				{else}
					<li><a><img src="themes/{$umTPath}/images/toolbar/next_mail_2.gif" border="0" align="middle"></a></li>	
				{/if}
				{if $umTLB_UP_DOWN eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				{/if}	
			{/if}	
	
			</ul></td>
	
			<td><ul id="topright">
		{if $umTLB_LOGOFF}
				<li><a href="javascript:goend();" title="{#logoff_mnu#}">
					<img src="themes/{$umTPath}/images/toolbar/logoff.gif" alt="" border="0" align="middle">&nbsp;{#logoff_mnu#}</a></li>
			{if $umTLB_LOGOFF eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
			{/if}
		{/if}
		{if $umTLB_HELP}
				<li><a href="javascript:help();" title="{#help_mnu#}">
					<img src="themes/{$umTPath}/images/toolbar/help.gif" alt="" border="0" align="middle">&nbsp;{#help_mnu#}</a></li>
			{if $umTLB_HELP eq 1}
					<li><a class="separator"><img src="themes/{$umTPath}/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
			{/if}
		{/if}
			</ul></td>
	
			</tr>
			</table>
			
		</td>
	</tr>
{*	
	<script language="javascript" type="text/javascript">
	<!--
		// Close dropdown menu when clicked outside (does not seems to be required !!!) document.onclick = mclose(); 
	//-->
	</script>
*}
	{/if}
	<!--"end top bar" -->
