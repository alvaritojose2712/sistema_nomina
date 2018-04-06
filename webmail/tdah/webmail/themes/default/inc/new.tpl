<!-- Addresses and Subject -->
			<table class="tablecollapsed" height="99%">
			<tr>
				<td class="pagetitle" height="25px" >
				<table width="100%" border="0" cellspacing="3" cellpadding="0" height="69" >
				<tr>
					<td width="*" align="left" rowspan="2"><p class="title">{#new_title#}</p></td>
					<td width="60" align="left" height="30"><p align="right"><nobr>{#to_hea#}&nbsp;
						<a href="javascript:addrpopup()" title="{#adr_title#}">
						<img src="themes/{$umTPath}/images/bookmark_it.gif" border="0" alt="{#address_tip#}"></a></p></td>
					<td align="left" height="30">{$umTo}</nobr></td>
					<td width="60" height="30"><p align="right"><nobr>{#cc_hea#} &nbsp;
						<a href="javascript:addrpopup()" title="{#adr_title#}"><img src="themes/{$umTPath}/images/bookmark_it.gif" border="0" alt="{#address_tip#}"></a></p></td>
					<td height="30"><p align="left">{$umCc}</nobr></td>
					<td width="50" height="60" rowspan="2" align="right"><img class="image" src="themes/{$umTPath}/images/send.gif" border="0" align="right" alt=""></td>
				</tr>
				<tr><td align="right" height="30"><nobr>{#subject_hea#}</td><td align="left" height="30">{$umSubject}</nobr></td>
					<td height="30"><p align="right"><nobr>{#bcc_hea#} &nbsp;
						<a href="javascript:addrpopup()" title="{#adr_title#}"><img src="themes/{$umTPath}/images/bookmark_it.gif" border="0" alt="{#address_tip#}"></a></p></td>
					<td height="30"><p align="left">{$umBcc}</nobr></td>
				</tr>
				</table>
				</td>
			</tr>

			<!-- Priority, Signature and Attachements -->
			<tr>
				<td class="background">
				<table width="100%" border="0" cellspacing="3" cellpadding="0">
				<tr>
					<td class="headerright">&nbsp;</td>
					<td class="menu"><img src="themes/{$umTPath}/images/toolbar/imp.gif"alt="" border="0" align="middle">
						<b>{#priority_text#}</b> <select name="priority">
						<option value="1"{if $umPriority eq 1} selected{/if}>{#priority_high#}
						<option value="3"{if $umPriority eq 3} selected{/if}>{#priority_normal#}
						<option value="5"{if $umPriority eq 5} selected{/if}>{#priority_low#}</select>
						&nbsp;&nbsp; {#add_signature#}
						<input type="checkbox" name="cksig" onClick="return addsig()"{if $umAddSignature eq 1} checked disabled{/if}>
						{if !$umAddSignature && $umHaveSignature} {/if}
						&nbsp; {#require_receipt#}
						<input type="checkbox" name="requireReceipt" {$umRReceipt}>
					</td>
				</tr>
				<tr>
					<td align="center" width="109">&nbsp;</td>
					<td align="center">
					<table class="tablecollapsed" style="border: solid 1px #CCCCCC;" id="id_attach">
					<tr height="20">
						<td class="bar" width="30%" align="left"><b>&nbsp; {#attch_name_hea#}</b></td>
						<td class="bar" width="27%" align="center"><b>{#attch_size#}</b></td>
						<td class="bar" width="25%" align="center"><b>{#attch_type_hea#}</b></td>
						<td class="bar" width="15%" align="center"><b>{#attch_dele_hea#}</b></td>
					</tr>
					{if $umHaveAttachs eq 1} 
						{section name=i loop=$umAttachList} 
						<tr class="page_color">
							<td width="30%" class="msg_links" align="left">
								&nbsp; <a href="{$umAttachList[i].downlink}"><img src="themes/{$umTPath}/images/download.gif" border="0" alt="{#up_download#}"></a>
								&nbsp; <a href="{$umAttachList[i].normlink}" target="_new">{$umAttachList[i].name|truncate:30:"...":true|escape:'html'}</a> 
							</td>
							<td width="27%" align="center">{$umAttachList[i].size}Kb&nbsp;</td>
							<td width="25%" align="center" title="{$umAttachList[i].type}">&nbsp;{$umAttachList[i].type|truncate:23:"...":true}</td>
							<td width="15%" align="center">
								&nbsp;<a href="javascript: if (window.confirm('{#attach_delete#}\n{$umAttachList[i].name}')) {$umAttachList[i].link};" title="{#att_delete#}"><img src="themes/{$umTPath}/images/cross.gif" border="0" alt="{#att_delete#}"></a>
							</td>
						</tr>
						{/section}
					{else}
						<tr>
							<td class="page_color" colspan="4"><i>&nbsp;{#attch_no_hea#}</i></td>
						</tr>
					{/if}
					</table>
					</td>
				</tr>
				</table>
				</td>
			</tr>

			<!-- Body -->
			<tr>
				<td valign="top" width="100%" height="100%" align="center">
					<textarea class="textbox" name="body" id="htmleditor" rows="10" cols="80" style="width: 100%; height: 200px;">{$umBody|escape:"html"}</textarea>
					<script language="javascript" type="text/javascript">
						{if $umAdvancedEditor eq 2}WYSIWYG.attach('htmleditor',full);{/if} 
						{if $umAdvancedEditor eq 1}reSizeElementHeight('htmleditor',get_Height('id_attach')+js_offset);{/if}
					</script>
				</td>
			</tr>
			</table>