{if $umNumAddress gt 0}
				<table class="tablecollapsed">
				<tr height="25">
					<td class="menu bar" width="2%"><p align="center"><b>&nbsp;</b></td>
					<td class="menu bar" width="12%"><p align="left"><b>{#adr_name_hea#}</b></td>
					<td class="menu bar" width="12%"><p align="left"><b>{#adr_email_hea#}</b></td>
					<td class="menu bar" width="10%"><p align="center"><b>{#adr_city_hea#}</b></td>
					<td class="menu bar" width="5%"><p align="center"><b>{#adr_state_hea#}</b></td>
					<td class="menu bar" width="6%"><p align="center"><b>{#adr_zip_hea#}</b></td>
					<td class="menu bar" width="9%"><p align="center"><b>{#adr_phone_hea#}</b></td>
					<td class="menu bar" width="4%"><p align="center"><b>{#adr_edit_hea#}</b></td>
					<td class="menu bar" width="4%"><p align="center"><b>{#adr_dele_hea#}</b></td>
				</tr>
				</table>
	
				<!-- Data -->
				<table class="page_color under_line" width="100%" cellspacing="0">
				{section name=i loop=$umAddressList} 
					<tr onmouseover="this.className='hover_color';" onmouseout="this.className='';">
						<td width="2%"><p align="left">&nbsp;<img src="themes/{$umTPath}/images/card.gif" alt=""></td>
						<td width="12%"><p align="left"><a class="menu" href="{$umAddressList[i].viewlink}">{$umAddressList[i].name}</a></td>
						<td width="15%"><p align="left">&nbsp;<a class="menu" href="{$umAddressList[i].composelink}">{$umAddressList[i].email}</a></td>
						<td width="10%"><p align="center">&nbsp;<a class="menu" href="{$umAddressList[i].viewlink}"><font color="#334F88">{$umAddressList[i].city}</font></a></td>
						<td width="5%"><p align="center">&nbsp;<a class="menu" href="{$umAddressList[i].viewlink}"><font color="#334F88">{$umAddressList[i].state}</font></a></td>
						<td width="6%"><p align="center">&nbsp;<a class="menu" href="{$umAddressList[i].viewlink}"><font color="#334F88">{$umAddressList[i].zip}</font></a></td>
						<td width="9%"><p align="center">&nbsp;<a class="menu" href="{$umAddressList[i].viewlink}"><font color="#334F88">{$umAddressList[i].phone}</font></a></td>
						<td width="4%"><p align="center">&nbsp;<a class="menu" href="{$umAddressList[i].editlink}"><img src="themes/{$umTPath}/images/editcontact.gif" border="0" alt="{#adr_detail#}"></a></td>
						<td width="4%"><p align="center">&nbsp;<a class="menu" href="javascript: if (window.confirm('{#adr_delete_validate#}\n{$umAddressList[i].name}')) window.location='{$umAddressList[i].dellink}';"><img src="themes/{$umTPath}/images/cross.gif" border="0" alt="{#adr_delete#}"></a></td>
					</tr>
				{/section}
				</table>
			
				<center class="upper_line navbar"><br>
				{if $umPreviousLink}
					<a href="{$umPreviousLink}">{#previous_text#}</a> &nbsp;
				{/if}
				{#pages#} {$umNavBar}
				{if $umNextLink}
					&nbsp;<a href="{$umNextLink}">{#next_text#}</a>
				{/if}</center>
					
			{else}
				<table class="tablecollapsed">
				<tr>
					<td align="center"><br>{#adr_no_contact#}</td>
				</tr>
				</table>
			{/if}
