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

	- File:			panel.tpl
	- Developer: 	Laurent (AdNovea)
	- Date:			November 4, 2008
	- version:		(3.2.0) 1.0
	- Description:  Code to host the folder tree and the menu on the left panel

************************************************************************* *}

				<td valign="top" class="panel"> 
					<!--"start left pane" -->
					<table class="tablecollapsed" cellpadding="0" height="100%">
					<tr>
						<td valign="top">
						<!--"TREE" --> 		       
						{include file="$umTPath$TPL_TREE"}
						</td>
					<tr> 
					
						<td valign="bottom"> 
						
<!--"MENU" --> 		       
						{include file="$umTPath$TPL_MENU"}
						</td>
					</tr>
					</table>
				</td>
						
				<!-- Vertical separator -->
				<td class="v_separaror" rowspan="2">&nbsp;</td>
