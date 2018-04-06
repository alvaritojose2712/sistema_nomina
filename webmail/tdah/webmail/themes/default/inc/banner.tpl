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

	- File:			banner.tpl
	- Developer: 	Laurent (AdNovea)
	- Date:			November 4, 2008
	- version:		(3.2.0) 1.0
	- Description:  All the top banner elements

************************************************************************* *}

	<!--"start header" -->        
	<tr>
		<td height="44" colspan="2">
		<table class="tablecollapsed" cellpadding="0" height="44">
		<tr>
			<td class="header" width="75">&nbsp;<img border="0" src="themes/{$umTPath}/images/skins/default/logo.gif" alt=""></td>
			<td class="header"><b>{$umCompany}{if $umDomain neq ""} - {$umDomain}{/if}</b></td>
		
			<td class="header"><p class="date" align="right">
			<span class="login_time" id="dfield">&nbsp;</span><br>
			<span class="login_time" id="clock">&nbsp;</span>
			</td>
				
		</tr>
		</table>
		</td>
	</tr>
	<!--"end header" -->             

{* Intialize toolbar variables before calling the toolbar.tpl *}

	{assign var='umTLB_NONE' value=$umTLB_NONE|default:0}
	
	{assign var='umTLB_LOGOFF' value=$umTLB_LOGOFF|default:0}
	{assign var='umTLB_HELP' value=$umTLB_HELP|default:0}
	{assign var='umTLB_FOLDERS' value=$umTLB_FOLDERS|default:0}
	{assign var='umTLB_REFRESH' value=$umTLB_REFRESH|default:0}
	{assign var='umTLB_COMPOSE' value=$umTLB_COMPOSE|default:0}
	{assign var='umTLB_NEW_ENTRY' value=$umTLB_NEW_ENTRY|default:0}
	{assign var='umTLB_MAIN' value=$umTLB_MAIN|default:0}
	{assign var='umTLB_DEL_SELECT' value=$umTLB_DEL_SELECT|default:0}
	{assign var='umTLB_DELETE' value=$umTLB_DELETE|default:0}
	{assign var='umTLB_SPAM' value=$umTLB_SPAM|default:0}
	{assign var='umTLB_MOVE' value=$umTLB_MOVE|default:0}
	{assign var='umTLB_SEND' value=$umTLB_SEND|default:0}
	{assign var='umTLB_ATTACH' value=$umTLB_ATTACH|default:0}
	{assign var='umTLB_MARK_FLAG' value=$umTLB_MARK_FLAG|default:0}
	{assign var='umTLB_ACTION' value=$umTLB_ACTION|default:0}
	{assign var='umTLB_UP_DOWN' value=$umTLB_UP_DOWN|default:0}
