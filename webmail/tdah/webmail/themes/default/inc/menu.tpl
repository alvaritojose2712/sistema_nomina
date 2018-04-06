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

	- File:			menu.tp
	- Developer: 	Laurent (AdNovea)
	- Date:			November 4, 2008
	- version:		(3.2.0) 1.0
	- Description:  Code for the left panel menu

************************************************************************* *}

	<!--"start menu" --> 
					<table class="tablecollapsed menus" cellpadding="0">
					<tr>   
						<td>
							<!-- Title -->
					
	<table class="tablecollapsed">
						<tr >
							<td ></td>
						</tr>
						</table>



						<!-- Title -->
						<table class="tablecollapsed">
						<tr height="19">
							<td class="lmbar title" height="19">&nbsp;{#menu_mnu#}</td>
						</tr>
						</table>

						<!-- Menu -->
						<table class="tablecollapsed" style="white-space: nowrap;">
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:goinbox()">&nbsp;
									<img src="themes/{$umTPath}/images/menu/inbox.gif" alt="" border="0" align="middle">
									&nbsp;&nbsp;{#messages_mnu#}</a></li>
							</ul>
							</td>      
						</tr>	
						  
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:newmsg()">&nbsp;
								<img src="themes/{$umTPath}/images/menu/write.gif" alt="" border="0" align="middle">
								&nbsp;&nbsp;{#compose_mnu#}</a></li>
							</ul>
							</td>      
						</tr>	
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:calendar()">&nbsp;
								<img src="themes/{$umTPath}/images/menu/calendar.gif" alt="" border="0" align="middle">
								&nbsp;&nbsp;{#calendar_mnu#}</a></li>
							</ul>
							</td>      
						</tr>
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:addresses()">&nbsp;
								<img src="themes/{$umTPath}/images/menu/contacts.gif" alt="" border="0" align="middle">
								&nbsp;&nbsp;{#address_mnu#}&nbsp;{if $umAddrEntry neq 0}[{$umAddrEntry}]{/if}</a></li>
							</ul>
							</td>      
						</tr>	
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:folderlist()">&nbsp;
								<img src="themes/{$umTPath}/images/menu/folder.gif" alt="" border="0" align="middle">
								&nbsp;&nbsp;{#folders_mnu#}</a></li>
							</ul>
							</td>      
						</tr>	
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:search()">&nbsp;
								<img src="themes/{$umTPath}/images/menu/search.gif" alt="" border="0" align="middle">
								&nbsp;&nbsp;{#search_mnu#}</a></li>
							</ul>
							</td>      
						</tr>		
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:prefs()">&nbsp;
								<img src="themes/{$umTPath}/images/menu/options.gif" alt="" border="0" align="middle">
								&nbsp;&nbsp;{#prefs_mnu#}</a></li>
							</ul>
							</td>
						</tr>      
						</table>
						
						</td>
					</tr>
					</table>
	<!--"end menu" -->
