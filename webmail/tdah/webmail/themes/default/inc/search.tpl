			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>   
					<td class="background" height="15" >
					<table width="100%" border="0" cellspacing="3" cellpadding="0">
					<tr>
						<td>
						<table width="100%" border="0" cellspacing="3" cellpadding="0">
						<tr> 
							<td width="12%" align="right">{#sch_from_hea#}:</td>
							<td width="87%"><input type="text" name="srcFrom" value="{$umInputFrom|escape:'html'}" maxlength="40" class="textbox"></td>
						</tr>
						<tr> 
							<td width="12%" align="right">{#sch_subject_hea#}:</td>
							<td width="87%"><input type="text" name="srcSubject" value="{$umInputSubject|escape:'html'}" maxlength="40" class="textbox"></td>
						</tr>
						<tr> 
							<td width="12%" align="right">{#sch_body_hea#}:</td>
							<td width="87%"><input type="text" name="srcBody" value="{$umInputBody|escape:'html'}" maxlength="40" class="textbox"></td>
						</tr>
						<tr> 
							<td width="12%" align="right"><img src="themes/{$umTPath}/images/menu/search.gif"alt="{#sch_button_text#}" border="0" align="middle"></td>
							<td width="87%"><input type="submit" value="{#sch_button_text#}" class="button">
							</td>
						</tr>
						</table>
						</td>
					</tr>
					</table>
				</td>
				</tr>
			</table>

			<table class="page_color under_line" width="100%" border="0" cellspacing="0">
				<tr height="25">
					<td width="10" class="bar" align="center">&nbsp;<img src="themes/{$umTPath}/images/prior_high.gif" alt=""></td>
					<td width="10" class="bar" align="center">&nbsp;<img src="themes/{$umTPath}/images/attach.gif" alt=""></td>
					<td width="20" class="bar">&nbsp;</td>
					<td width="200"class="bar"><b>{#sch_from_hea#}</b></td>
					<td class="bar"><b>{#sch_subject_hea#}</b></nobr></td>
					<td width="150" class="bar" ><b>{#sch_folder_hea#}</b></td>
					<td width="150" class="bar"><b>{#sch_date_hea#}</b></td>
					<td width="50" class="bar"><b>{#sch_size_hea#}</b></td>
				</tr>

			{section name=i loop=$umMessageList}
				<tr onmouseover="this.className='hover_color';" onmouseout="this.className='';">
					<td align="center">{$umMessageList[i].priorimg}</td>
					<td align="center">{$umMessageList[i].attachimg}</td>
					<td align="center">{$umMessageList[i].statusimg}</td>
					<td><a href="{$umMessageList[i].composelink}" class="menu">{$umMessageList[i].from|truncate:30:"...":true|escape:"html"|default:#no_subject_text#}</a></td>
					<td>{if $umMessageList[i].read eq "false"}<b>{/if}<a href="{$umMessageList[i].readlink}" class="menu">{$umMessageList[i].subject|truncate:30:"...":true|escape:"html"|default:#no_subject_text#}</a>{if $umMessageList[i].read eq "false"}</b>{/if}</td>
					<td><a href="{$umMessageList[i].folderlink}" class="menu">{$umMessageList[i].foldername|escape:"html"}</a></td>
					<td>{$umMessageList[i].date|date_format:#date_format#}</td>
					<td nowrap ><font color="gray">{$umMessageList[i].size} {$umMessageList[i].unit}{#bytes#} &nbsp;</font></td>
				</tr>
			{sectionelse}
			</table>
				<table class="tablecollapsed">
				<tr>
					<td align="center"><br>{#sch_no_results#}</td>
				</tr>
				</table>
			{/section}