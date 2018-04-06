{if $umNumMessages gt 0}
				{if $umErrorMessage neq ""}	{/if}
					<table class="tablecollapsed page_color">
					<tr height="20">
						<td width="20" class="bar"><input type="checkbox" name="chkall" onclick="sel();"></td>
						<td width="15" class="bar"><img src="themes/{$umTPath}/images/deflagged.gif" alt=""></td>
						<td width="6" class="bar"><img src="themes/{$umTPath}/images/prior_high.gif" alt=""></td>
						<td width="7" class="bar"><img src="themes/{$umTPath}/images/attach.gif" alt=""></td>
						<td width="16" class="bar"></td>
						{if $umFolder eq "sent"}
							<td width="200" class="bar" ><b><a href="javascript:sortby('toname')" title="{#msg_sort#}">{#to_hea#} {$umToArrow}</a></b></td>
						{else}
							<td width="200" class="bar" ><b><a href="javascript:sortby('fromname')" title="{#msg_sort#}">{#from_hea#}&nbsp; {$umFromArrow}</a></b></td>
						{/if}
						
						<td class="bar"><b><a href="javascript:sortby('subject')" title="{#msg_sort#}">{#subject_hea#} {$umSubjectArrow}</a></b></td>
						<td width="150" class="bar"><b><a href="javascript:sortby('date')" title="{#msg_sort#}">{#date_hea#}{$umDateArrow}</a></b></td>
						<td width="50" class="bar"><b><a href="javascript:sortby('size')" title="{#msg_sort#}">{#size_hea#}{$umSizeArrow}</a></b>&nbsp;</td>
					</tr>
						
					{section name=i loop=$umMessageList} 
						<tr onmouseover="this.className='hover_color';" onmouseout="this.className='';">
							<td>{$umMessageList[i].checkbox}</td>
							<td>{$umMessageList[i].flaggedimg}</td>
							<td>{$umMessageList[i].priorimg}</td>
							<td>{$umMessageList[i].attachimg}</td>
							<td>{$umMessageList[i].statusimg}</td>
						{if $umFolder eq "sent"}
							<td><acronym title="{$umMessageList[i].to|escape:'html'|default:#no_recipient_text#}">
								<a href="{$umMessageList[i].composelinksent}" class="menu">{$umMessageList[i].to|truncate:40:"...":true|escape:'html'|default:#no_recipient_text#}</a></acronym></td>
						{else}
							<td><p align="left"><acronym title="{$umMessageList[i].from|escape:'html'|default:#no_recipient_text#}">
								<a href="{$umMessageList[i].readlink}" class="menu">{$umMessageList[i].from|truncate:30:"...":true|escape:'html'|default:#no_subject_text#}</a></acronym></td>
						{/if}
						<td><p align="left"><acronym title="{$umMessageList[i].subject|escape:'html'|default:#no_subject_text#}">
							{if $umMessageList[i].read eq "false"}<b>{/if}<a href="{$umMessageList[i].readlink}" class="menu">
							{$umMessageList[i].subject|truncate:50:"...":true|escape:'html'|default:#no_subject_text#}</a>
							{if $umMessageList[i].read eq "false"}</b>{/if}</acronym></td>
						<td nowrap >{$umMessageList[i].date|date_format:#date_format#}</td>
						<td nowrap ><font color="gray">{$umMessageList[i].size} {$umMessageList[i].unit}{#bytes#} &nbsp;</font></td>
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
					<td align="center"><br>{#no_messages#} <b>{$umBoxName|escape:'html'} {#folder#}</b></td>
				</tr>
				</table>
			{/if}
	