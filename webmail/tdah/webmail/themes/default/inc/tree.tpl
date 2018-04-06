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

	- File:			tree.tpl
	- Developer: 	Laurent (AdNovea)
	- Date:			November 4, 2008
	- version:		(3.2.0) 1.0
	- Description:  Message folder tree on the left panel

************************************************************************* *}

	<!--"start tree" -->
					<table class="tablecollapsed trees" cellpadding="0" style="white-space: nowrap;">
						<!-- Title -->
						<tr>
							<td class="mbar title" colspan="2" title="{$umUser}">{$umUser|truncate:17:"..":true|escape:"html"}</td>
						</tr>
						<!-- Spacer -->
						<tr height="5px">
							<td></td>	 
						</tr>
						<!-- Tree -->
						{section name=i loop=$umSystemFolders}
							<tr class="tree_item" >
								<td onclick="javascript:window.location='{$umSystemFolders[i].link}';" onmouseover="javascript:this.className='tree_hover';" onmouseout="javascript:this.className='';" width="94%">
									<p title="{$umSystemFolders[i].name}">
									&nbsp; <img src="themes/{$umTPath}/images/tree/icon_mail.gif" alt="{$umSystemFolders[i].name}" border="0" align="middle">
									&nbsp; {$umSystemFolders[i].name|truncate:10:"..":true|escape:"html"}&nbsp;&nbsp;{$umSystemFolders[i].msgs}</p>
								</td>
								<td class="tree_empty" width="6%">
									<a href="javascript: if (window.confirm('{#fld_empty_validate#}\n{$umSystemFolders[i].name}')) window.location='{$umFolderList[i].emptylink}&goback=true';" title="{#empty_folder#}: {$umSystemFolders[i].name}">
									<img src="themes/{$umTPath}/images/tree/empty.gif" border="0" align="middle" alt=""></a>
								</td>
							</tr>
						{/section}
						
						{section name=i loop=$umPersonalFolders}
							<tr class="tree_item">
								 <td onclick="javascript:window.location='{$umPersonalFolders[i].link}';" onmouseover="javascript:this.className='tree_hover';" onmouseout="javascript:this.className='';">
									<p title="{$umPersonalFolders[i].name}">
									&nbsp; <img src="themes/{$umTPath}/images/tree/folderopen.gif" alt="{$umPersonalFolders[i].name}" border="0" align="middle">
									&nbsp; {$umPersonalFolders[i].name|truncate:10:"..":true|escape:"html"}&nbsp;&nbsp;{$umPersonalFolders[i].msgs}</p>
								</td>
								<td class="tree_empty">
									<a href="javascript: if (window.confirm('{#fld_empty_validate#}\n{$umPersonalFolders[i].name}')) window.location='{$umPersonalFolders[i].emptylink}&goback=true';"  title="{#empty_folder#}: {$umPersonalFolders[i].name}">
									<img src="themes/{$umTPath}/images/tree/empty.gif" border="0" align="middle" alt=""></a>
								</td>
							</tr>
						{/section}
							
					</table>
	<!--"end tree" -->
