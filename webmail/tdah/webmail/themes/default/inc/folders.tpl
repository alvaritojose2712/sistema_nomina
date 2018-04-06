<!-- Quota used -->
			{if $umQuotaEnabled eq 1}
			<table class="tablecollapsed background" cellspacing="3">
			<tr>
				<td align="left">{if $umNoQuota}&nbsp;<font color="#FF0000"><b>{#quota_usage_info#}</b> </font>{/if}
				&nbsp;{#quota_usage_used#} <b>{$umTotalUsed}</b> {$umTotalUnit}{#bytes#} {#quota_usage_of#}
				&nbsp;<b>{$umQuotaLimit}</b> {if $umQuotaLimit neq 0}{$umQuotaUnit}{#bytes#}{/if} {#quota_usage_avail#}&nbsp; {$umUsageGraph}</td>
			</tr>
			</table>
			{/if}
			
			<!-- Header line -->
			<table class="tablecollapsed page_color">
			<tr height="25">
				<td width="25%" class="bar"><b>&nbsp; {#fld_name_hea#}</b></td>
				<td width="22%" class="bar" align="right"><b>{#fld_messages_hea#}</b></td>
				<td width="18%" class="bar" align="right"><b>{#fld_size_hea#}</b></td>
				<td width="17%" class="bar" align="center"><b>{#fld_empty_hea#}</b></td>
				<td width="17%" class="bar" align="center"><b>{#fld_delete_hea#}</b></td>
			</tr>
			
			<!-- System folders -->
			{section name=i loop=$umFolderList}
				<tr onmouseover="this.className='hover_color listtable';" onmouseout="this.className='listtable';" class="listtable">
					<td>
						<span style="vertical-align: text-bottom"> &nbsp;<a class="menu" href="{$umPersonalFolders[i].link}">
						<span style="text-decoration: none"><img src="themes/{$umTPath}/images/tree/folderopen.gif" alt="{#messages_mnu#}" border="0" align="middle"></span></a></span>
						&nbsp;<a href="{$umFolderList[i].chlink}" class="menu">&nbsp;{$umFolderList[i].name|escape:"html"}</a></td>
					<td align="right">
						&nbsp;{$umFolderList[i].msgs}</td>
					<td align="right">
						&nbsp;&nbsp;{$umFolderList[i].boxsize} {if $umFolderList[i].boxsize neq 0}{$umFolderList[i].unit}{#bytes#}{/if}</td>
					<td align="center">
						&nbsp;&nbsp;<a href="javascript: if (window.confirm('{#fld_empty_validate#}\n{$umFolderList[i].name}')) window.location='{$umFolderList[i].emptylink}';" title="{#empty_folder#}"><img src="themes/{$umTPath}/images/empty.gif" border="0" alt="{#empty_folder#}"></a></td>
					<td align="center">
						{if $umFolderList[i].del neq ""}
							<a href="javascript: if (window.confirm('{#fld_delete_validate#}\n{$umFolderList[i].name}')) window.location='{$umFolderList[i].del}';"><img src="themes/{$umTPath}/images/cross.gif" border="0" alt="{#fld_delete_hea#}"></a>
						{/if}
					</td>
				</tr>
			{/section}
			</table>
			
			<table class="upper_line" width="100%" cellpadding="3">
			<tr>
				<td width="25%">&nbsp;</td>
				<td width="22%" align="right"><b>&nbsp;{#fld_total#}</b></td>
				<td width="18%" align="right"><b>&nbsp;{$umTotalUsed}</b> {if $umTotalUsed neq 0}{$umTotalUnit}{#bytes#}{/if}</td>
				<td width="17%">&nbsp;</td>
				<td width="17%">&nbsp;</td>
			</tr>
			</table>
			
			