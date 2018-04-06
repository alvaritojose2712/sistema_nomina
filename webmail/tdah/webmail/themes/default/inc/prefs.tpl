<center><br>
				<!-- Tabs -->
				<table class="tab_table" cellpadding="0">
				<tr>
					<td height="30" valign="bottom">
						<table class="tablecollapsed" cellpadding="0">
						<tr>
							<td id="tab_info" class="tab_info_visible">
								<table  class="tablecollapsed"  cellpadding="0">
								<tr>
									<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
									<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchPrefsTab('info')">
									<nobr>&nbsp;{#prf_general_title#}&nbsp;</nobr></td>
									<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
								</tr>
								</table>
							</td>
	
							<td id="tab_messages" class="tab_info_hidden">
								<table class="tablecollapsed" cellpadding="0">
								<tr>
									<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
									<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchPrefsTab('messages')">
									<nobr>&nbsp;{#prf_messages_title#}&nbsp;</nobr></td>
									<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
								</tr>
								</table>
							</td>
							
							<td id="tab_signature" class="tab_info_hidden">
								<table class="tablecollapsed" cellpadding="0">
								<tr>
									<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
									<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchPrefsTab('signature')">
									<nobr>&nbsp;{#prf_signature_title#}&nbsp;</nobr></td>
									<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
								</tr>
								</table>
							</td>
							
							<td id="tab_trash" class="tab_info_hidden">
								<table  class="tablecollapsed" cellpadding="0">
								<tr>
									<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
									<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchPrefsTab('trash')">
									<nobr>&nbsp;{#prf_trash_title#}&nbsp;</td>
									<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
								</tr>
								</table>
							</td>
	
							<td id="tab_skin" class="tab_info_hidden">
								<table class="tablecollapsed" cellpadding="0">
								<tr>
									<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
									<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchPrefsTab('skin')">
									<nobr>&nbsp;{#skin_title#}&nbsp;</nobr></td>
									<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
								</tr>
								</table>
							</td>
	
							<td id="tab_filters" class="tab_info_hidden">
								<table class="tablecollapsed" cellpadding="0">
								<tr>
									<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
									<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchPrefsTab('filters')">
									<nobr>&nbsp;{#filter_title#}&nbsp;</nobr></td>
									<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
								</tr>
								</table>
							</td>
	
							<td width='100%'>&nbsp;</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
				
				<table class="tab" cellpadding="15px">
				<tr>
					<td width='100%' valign='top' >
					<form name="prefs_form" id="prefs_form" action="preferences.php" method="post">
						<input type="hidden" name="action" value="savePrefs">
						{$umForms}
	
		<!-- first tab - General -->
						<div id="info" class="tab_visible">
						<fieldset>
							<legend>{#prf_general_title#}</legend>
							<table width='100%' cellpadding='2' cellspacing='0'>
							<tr>
								<td class="label" width="200">{#prf_name#}</td>
								<td><input type="text" name="real_name" value="{$realName|escape:'html'}" class="textbox"></td>
							</tr>
							<tr>
								<td class="label">{#prf_nickname#}</td>
								<td><input type="text" name="nick_name" value="{$nickName|escape:'html'}" class="textbox"></td>
							</tr>
							<tr>
								<td class="label">{#prf_reply_to#}</td>
								<td><input type="text" name="reply_to" value="{$replyTo|escape:'html'}" class="textbox"></td>
							</tr>
								 	<tr>
								<td class="label">{#prf_time_zone#}</td>
								<td>
								<select name="timezone" id='timezone'>
									{html_options options=$timezoneVals selected=$timezones}
								
								{html_options options=$timezoneVals selected=$timezone}
								
								</select>
								
								
								
								
								</td>
							</tr>
							<tr>
								<td class="label">{#prf_default_editor_mode#}</td>
								<td>
								<select name="editor_mode">
									<option value="text"{if $editorMode eq "text"} selected{/if}>{#prf_default_editor_mode_text#}
									<option value="html"{if $editorMode eq "html"} selected{/if}>{#prf_default_editor_mode_html#}
								<!--	<option value="wyswyg"{if $editorMode eq "wyswyg"} selected{/if}>{#prf_default_editor_mode_wyswyg#} -->
								</select>
								</td>
							</tr>
							
							</table>
							<div class="info">{#sw_name#} v{$umVersion}</div>				
						</fieldset>
						<table>
						<tr>
							<td><input class="button" type="submit" value="{#prf_save_button#}"></td>
						</tr>
						</table>
						</div>

		<!-- second tab - Messages -->
						<div id="messages" class="tab_hidden">
						<fieldset>
							<legend>{#prf_messages_title#}</legend>
							<table width='100%' cellpadding='2' cellspacing='0'>
							<tr>
								<td class="label">{#prf_page_limit#}</td>
								<td>
									<select name="rpp">
									{html_options values=$msgPerPageVals output=$msgPerPageVals selected=$msgPerPage}
									</select>
								</td>
							</tr>
							<tr>
								<td class="label">{#prf_time_to_refesh#}</td>
								<td>
									<select name="refresh_time">
									{html_options values=$refreshTimeVals output=$refreshTimeVals selected=$refreshTime}
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<input type="checkbox" name="block_images" value="1"{if $blockImages eq true} checked="checked"{/if}>
									{#prf_block_images#}<br>
									<input type="checkbox" name="display_images" value="1"{if $displayImages eq true} checked="checked"{/if}>
									{#prf_display_images#}<br>
									<input type="checkbox" name="require_receipt" value="1"{if $requireReceipt eq true} checked="checked"{/if}>
									{#prf_auto_require_receipt#}<br>
									<input type="checkbox" name="unmark_read_on_exit" value="1" {if $unmarkReadOnExit eq true} checked="checked"{/if}>
									{#prf_unmark_read_on_exit#}
								</td>
	
							</tr>
							</table>
						</fieldset>
						<br>
						<fieldset><legend>{#prf_sent_title#}</legend>
							<table width='100%' cellpadding='2' cellspacing='0'>
							<tr>
								<td><input type="checkbox" name="save_sent" value="1"{if $saveSent eq true} checked="checked"{/if}>
								{#prf_save_sent#} "<b>{#sent_extended#}</b>"</td>
							</tr>
							</table>
						</fieldset>
						<br>
						<table>
						<tr>
							<td><input type="submit" value="{#prf_save_button#}" class="button"></td>
						</tr>
						</table>
						</div>
						
		<!-- third tab - Signature -->
						<div id="signature" class="tab_hidden">
						<fieldset><legend>{#prf_signature_title#}</legend>
							<table width='100%' cellpadding='2' cellspacing='0'>
							<tr>
								<td class="label">{#prf_signature#}</td>
							</tr>
							<tr>
								<td>
									<textarea class="textbox" name="sig" id="htmleditor" rows="10" cols="80" style="width: 570px; height: 200px;">{$signature}</textarea>
								</td>
							</tr>
							<tr>
								<td colspan="2"><input type="checkbox" name="add_sig" value="1"{if $addSignature eq true} checked="checked"{/if}>
								{#prf_auto_add_sign#}</td>
							</tr>
							</table>
						</fieldset>
						<table>
						<tr>
							<td><input type="submit" value="{#prf_save_button#}" class="button"></td>
						</tr>
						</table>
						</div>
	
		<!-- fourth tab - Trash -->
						<div id="trash" class="tab_hidden">
						<fieldset>
							<legend>{#prf_trash_title#}</legend>
							<table width="100%" cellpadding="2" cellspacing="0">
							<tr>
								<td>
									<input type="checkbox" name="save_trash" onClick="dis()" value="1"{if $saveTrash eq true} checked="checked"{/if}>
									{#prf_save_to_trash#} "<b>{#trash_extended#}</b>"
								</td>
							</tr>
							
							<tr>
								<td>
									<input type="checkbox" name="save_spam" onClick="dis()" value="1"{if $saveSpam eq true} checked="checked"{/if}>
									{#prf_save_to_spam#} "<b>{#spam_extended#}</b>"
								</td>
							</tr>
									
							<tr>
								<td>
									<input type="checkbox" name="st_only_read" value="1"{if $saveTrashOnlyRead eq true} checked="checked"{/if}>
									{#prf_save_only_read#} "<b>{#trash_extended#}</b>"
								</td>
							</tr>
							<tr>
								<td>
									<input type="checkbox" name="empty_trash_on_exit" value="1"{if $emptyTrashOnExit eq true} checked="checked"{/if}>
									{#prf_empty_on_exit#}
								</td>
							</tr>
							
							</table>
						</fieldset>
						<table>
						<tr>
							<td><input type="submit" value="{#prf_save_button#}" class="button"></td>
						</tr>
						</table>
	
						</div>
						
		<!-- fifth tab - Skin -->
						<div id="skin" class="tab_hidden">
						<input type="hidden" id="selskin" name="skin" value="{$umSkin}">
						<fieldset>
							<legend>{#skin_title#}</legend>
							<table class="tablecollapsed">
							<tr>
								<td>
								<ul class="menu">
									<li><a href="#" onclick="setActiveStyleSheet('default'); return false;"> &nbsp; &nbsp; <img src="themes/{$umTPath}/images/skins/default/swatch.gif" border="0" align="middle" alt=""> &nbsp; {#prf_skin_default#}</a></li>
										
										<li><a href="#" onclick="setActiveStyleSheet('black_lime'); return false;"> &nbsp; &nbsp; <img src="themes/{$umTPath}/images/skins/black_lime/swatch.gif" border="0" align="middle" alt=""> &nbsp; {#prf_skin_black2#}</a></li>								
									<li><a href="#" onclick="setActiveStyleSheet('css_blue'); return false;"> &nbsp; &nbsp; <img src="themes/{$umTPath}/images/skins/css_blue/swatch.gif" border="0" align="middle" alt=""> &nbsp; {#prf_skin_blue#}</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('css_red'); return false;"> &nbsp; &nbsp; <img src="themes/{$umTPath}/images/skins/css_red/swatch.gif" border="0" align="middle" alt=""> &nbsp; {#prf_skin_red#}</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('css_pastel_blue'); return false;"> &nbsp; &nbsp; <img src="themes/{$umTPath}/images/skins/css_pastel_blue/swatch.gif" border="0" align="middle" alt=""> &nbsp; {#prf_skin_pastel_blue#}</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('gold_2_tone'); return false;"> &nbsp; &nbsp; <img src="themes/{$umTPath}/images/skins/gold_2_tone/swatch.gif" border="0" align="middle" alt=""> &nbsp; {#prf_skin_gold2#}</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('lime_2_tone'); return false;"> &nbsp; &nbsp; <img src="themes/{$umTPath}/images/skins/lime_2_tone/swatch.gif" border="0" align="middle" alt=""> &nbsp; {#prf_skin_lime2#}</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('purple_2_tone'); return false;"> &nbsp; &nbsp; <img src="themes/{$umTPath}/images/skins/purple_2_tone/swatch.gif" border="0" align="middle" alt=""> &nbsp; {#prf_skin_purple2#}</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('red_2_tone'); return false;"> &nbsp; &nbsp; <img src="themes/{$umTPath}/images/skins/red_2_tone/swatch.gif" border="0" align="middle" alt=""> &nbsp; {#prf_skin_red2#}</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('xp_blue'); return false;"> &nbsp; &nbsp; <img src="themes/{$umTPath}/images/skins/xp_blue/swatch.gif" border="0" align="middle" alt=""> &nbsp; {#prf_skin_xp_blue#}</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('black_mesh'); return false;"> &nbsp; &nbsp; <img src="themes/{$umTPath}/images/skins/black_mesh/swatch.gif" border="0" align="middle" alt=""> &nbsp; {#prf_skin_black#}</a></li>
									
									
								</ul>
								</td>
							</tr>
							</table>
						</fieldset>
						<table>
						<tr>
							<td><input type="submit" value="{#prf_save_button#}" class="button"></td>
						</tr>
						</table>
						</div>
					</form><!--"end of prefs_form" -->

		<!-- sixth tab - Filters -->
						<div id="filters" class="tab_hidden">
						<form action="preferences.php" method="post">
							<input type="hidden" name="action" value="addFilter">
							{$umForms}
							
							<fieldset>
								<legend>{#filter_new#}</legend>	
								<table width="100%" cellpadding="2" cellspacing="0">
									<tr>
										<td class="label"width="200">{#filter_field#}</td>
										<td>
											<select name="filter_field" size="1">
												<option value="1">{#filter_field_from#}</option>
												<option value="2">{#filter_field_subject#}</option>
												<option value="4">{#filter_field_to#}</option>
												<option value="3">{#filter_field_header#}</option>
												<option value="5">{#filter_field_strbody#}</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label">{#filter_match#}</td>
										<td>
											 <input type="text" class="textbox" name="filter_match">
										</td>
									</tr>
									<tr>
										<td class="label">
											{#filter_type#}
										</td>
										<td>
											<select name="filter_type" onchange="checkMove();">
												<option value="1">{#filter_type_move#}</option>
												<option value="2">{#filter_type_delete#}</option>
												<option value="4">{#filter_type_mark#}</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label">
											{#filter_folder#}
										</td>
										<td>
											<select name="filter_folder" size="1">
												{section name=i loop=$umAvalFolders}
													<option value="{$umAvalFolders[i].path|escape:'html'}">{$umAvalFolders[i].display|escape:'html'}
												{/section}
											</select>
										</td>
									</tr>
									<tr>
										<td class="default" align="center" colspan="2">
											<input type="submit" class="button" value="{#filter_add#}">
										</td>
									</tr>
								</table>
						</fieldset>
						</form><!--"end of noname" -->
						
						<!-- Available filters -->
						<form id="filters_form" name="filters_form" action="preferences.php" method="post">
							<input type="hidden" name="action" value="delFilter">
							{$umForms}

							<fieldset>
								<legend>{#filter_list#}</legend>
									<table cellspacing="2" cellpadding="0" width="100%">
										<tr>
											<td class='messages' valign=top >
											<table class="tablecollapsed" bgcolor="white">
											 <tr>
												<td class="bar" width="20" style="font-weight: bold">
													<input type="checkbox" name="toggle" id="toggle" onclick="selectAll('filters_form', {$filterList|@count})">
												</td>
												<td class="bar" style="font-weight: bold">{#filter_field#}</td>
												<td class="bar" style="font-weight: bold">{#filter_match#}</td>
												<td class="bar" style="font-weight: bold">{#filter_type#}</td>
												<td class="bar" style="font-weight: bold">{#filter_folder#}</td>
												<td class="bar" style="font-weight: bold">&nbsp;</td>
											</tr>
										{section name=filter loop=$filterList}
											<tr>
												<td width="18" align="center">
													<input type="checkbox" id="cb{$smarty.section.filter.index}" name="filters_array[]" value="{$smarty.section.filter.index}">
												</td>
												<td class="label">
												{if $filterList[filter].field eq 1}{#filter_field_from#}
												{elseif $filterList[filter].field eq 2}{#filter_field_subject#}
												{elseif $filterList[filter].field eq 4}{#filter_field_to#}
												{elseif $filterList[filter].field eq 3}{#filter_field_header#}
												{elseif $filterList[filter].field eq 5}{#filter_field_strbody#}
												
												{/if}
												
												</td>
												<td class="label">{$filterList[filter].match}</td>
												<td class="label">
												{if $filterList[filter].type eq 1}{#filter_type_move#}
												{elseif $filterList[filter].type eq 2}{#filter_type_delete#}
												{elseif $filterList[filter].type eq 3}{#filter_type_spam#}
												{elseif $filterList[filter].type eq 4}{#filter_type_mark#}{/if}
												</td>
												<td class="label">{$filterList[filter].moveto}</td>
												<td align="center">
													<a href="#" onclick="javascript:if (confirm(js_confirm_delfilter)) selectAndSubmit('filters_form',{$smarty.section.filter.index});return false;"><acronym title="{#filter_delete#}">
													<img src='themes/{$umTPath}/images/cross.gif' border="0" alt=""></acronym></a>
												</td>
											</tr>
										{sectionelse}
											<tr>
												<td class="label" align="center" colspan="6"><br>{#filter_msg_nofilters#}<br><br></td>
											</tr>
										{/section}
											</table>
											</td>
										</tr>
										{if $filterList}
											<tr>
												<td colspan="2" style="text-align: center; padding-top: 4px;">
													<input type="button" class="button" value="{#filter_delete_selected#}" onclick="javascript:if (confirm(js_confirm_delfilter)) submitForm('filters_form');return false;">
												</td>
											</tr>
										{/if}
									</table>
							</fieldset>
						</form><!--"end of filters_form" -->
					</div>
						
					</td>
				</tr>
				</table>
			</center>
			