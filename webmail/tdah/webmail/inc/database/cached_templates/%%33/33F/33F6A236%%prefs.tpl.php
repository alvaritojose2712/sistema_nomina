<?php /* Smarty version 2.6.24, created on 2011-03-26 15:20:52
         compiled from default/inc/prefs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'default/inc/prefs.tpl', 95, false),array('modifier', 'count', 'default/inc/prefs.tpl', 370, false),array('function', 'html_options', 'default/inc/prefs.tpl', 109, false),)), $this); ?>
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
									<td><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_left.gif" alt=""></td>
									<td style="background-image: url('themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_middle.gif');" onclick="switchPrefsTab('info')">
									<nobr>&nbsp;<?php echo $this->_config[0]['vars']['prf_general_title']; ?>
&nbsp;</nobr></td>
									<td><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_right.gif" alt=""></td>
								</tr>
								</table>
							</td>
	
							<td id="tab_messages" class="tab_info_hidden">
								<table class="tablecollapsed" cellpadding="0">
								<tr>
									<td><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_left.gif" alt=""></td>
									<td style="background-image: url('themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_middle.gif');" onclick="switchPrefsTab('messages')">
									<nobr>&nbsp;<?php echo $this->_config[0]['vars']['prf_messages_title']; ?>
&nbsp;</nobr></td>
									<td><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_right.gif" alt=""></td>
								</tr>
								</table>
							</td>
							
							<td id="tab_signature" class="tab_info_hidden">
								<table class="tablecollapsed" cellpadding="0">
								<tr>
									<td><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_left.gif" alt=""></td>
									<td style="background-image: url('themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_middle.gif');" onclick="switchPrefsTab('signature')">
									<nobr>&nbsp;<?php echo $this->_config[0]['vars']['prf_signature_title']; ?>
&nbsp;</nobr></td>
									<td><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_right.gif" alt=""></td>
								</tr>
								</table>
							</td>
							
							<td id="tab_trash" class="tab_info_hidden">
								<table  class="tablecollapsed" cellpadding="0">
								<tr>
									<td><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_left.gif" alt=""></td>
									<td style="background-image: url('themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_middle.gif');" onclick="switchPrefsTab('trash')">
									<nobr>&nbsp;<?php echo $this->_config[0]['vars']['prf_trash_title']; ?>
&nbsp;</td>
									<td><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_right.gif" alt=""></td>
								</tr>
								</table>
							</td>
	
							<td id="tab_skin" class="tab_info_hidden">
								<table class="tablecollapsed" cellpadding="0">
								<tr>
									<td><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_left.gif" alt=""></td>
									<td style="background-image: url('themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_middle.gif');" onclick="switchPrefsTab('skin')">
									<nobr>&nbsp;<?php echo $this->_config[0]['vars']['skin_title']; ?>
&nbsp;</nobr></td>
									<td><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_right.gif" alt=""></td>
								</tr>
								</table>
							</td>
	
							<td id="tab_filters" class="tab_info_hidden">
								<table class="tablecollapsed" cellpadding="0">
								<tr>
									<td><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_left.gif" alt=""></td>
									<td style="background-image: url('themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_middle.gif');" onclick="switchPrefsTab('filters')">
									<nobr>&nbsp;<?php echo $this->_config[0]['vars']['filter_title']; ?>
&nbsp;</nobr></td>
									<td><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tab_right.gif" alt=""></td>
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
						<?php echo $this->_tpl_vars['umForms']; ?>

	
		<!-- first tab - General -->
						<div id="info" class="tab_visible">
						<fieldset>
							<legend><?php echo $this->_config[0]['vars']['prf_general_title']; ?>
</legend>
							<table width='100%' cellpadding='2' cellspacing='0'>
							<tr>
								<td class="label" width="200"><?php echo $this->_config[0]['vars']['prf_name']; ?>
</td>
								<td><input type="text" name="real_name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['realName'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" class="textbox"></td>
							</tr>
							<tr>
								<td class="label"><?php echo $this->_config[0]['vars']['prf_nickname']; ?>
</td>
								<td><input type="text" name="nick_name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['nickName'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" class="textbox"></td>
							</tr>
							<tr>
								<td class="label"><?php echo $this->_config[0]['vars']['prf_reply_to']; ?>
</td>
								<td><input type="text" name="reply_to" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['replyTo'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" class="textbox"></td>
							</tr>
								 	<tr>
								<td class="label"><?php echo $this->_config[0]['vars']['prf_time_zone']; ?>
</td>
								<td>
								<select name="timezone" id='timezone'>
									<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['timezoneVals'],'selected' => $this->_tpl_vars['timezones']), $this);?>

								
								<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['timezoneVals'],'selected' => $this->_tpl_vars['timezone']), $this);?>

								
								</select>
								
								
								
								
								</td>
							</tr>
							<tr>
								<td class="label"><?php echo $this->_config[0]['vars']['prf_default_editor_mode']; ?>
</td>
								<td>
								<select name="editor_mode">
									<option value="text"<?php if ($this->_tpl_vars['editorMode'] == 'text'): ?> selected<?php endif; ?>><?php echo $this->_config[0]['vars']['prf_default_editor_mode_text']; ?>

									<option value="html"<?php if ($this->_tpl_vars['editorMode'] == 'html'): ?> selected<?php endif; ?>><?php echo $this->_config[0]['vars']['prf_default_editor_mode_html']; ?>

								<!--	<option value="wyswyg"<?php if ($this->_tpl_vars['editorMode'] == 'wyswyg'): ?> selected<?php endif; ?>><?php echo $this->_config[0]['vars']['prf_default_editor_mode_wyswyg']; ?>
 -->
								</select>
								</td>
							</tr>
							
							</table>
							<div class="info"><?php echo $this->_config[0]['vars']['sw_name']; ?>
 v<?php echo $this->_tpl_vars['umVersion']; ?>
</div>				
						</fieldset>
						<table>
						<tr>
							<td><input class="button" type="submit" value="<?php echo $this->_config[0]['vars']['prf_save_button']; ?>
"></td>
						</tr>
						</table>
						</div>

		<!-- second tab - Messages -->
						<div id="messages" class="tab_hidden">
						<fieldset>
							<legend><?php echo $this->_config[0]['vars']['prf_messages_title']; ?>
</legend>
							<table width='100%' cellpadding='2' cellspacing='0'>
							<tr>
								<td class="label"><?php echo $this->_config[0]['vars']['prf_page_limit']; ?>
</td>
								<td>
									<select name="rpp">
									<?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['msgPerPageVals'],'output' => $this->_tpl_vars['msgPerPageVals'],'selected' => $this->_tpl_vars['msgPerPage']), $this);?>

									</select>
								</td>
							</tr>
							<tr>
								<td class="label"><?php echo $this->_config[0]['vars']['prf_time_to_refesh']; ?>
</td>
								<td>
									<select name="refresh_time">
									<?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['refreshTimeVals'],'output' => $this->_tpl_vars['refreshTimeVals'],'selected' => $this->_tpl_vars['refreshTime']), $this);?>

									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<input type="checkbox" name="block_images" value="1"<?php if ($this->_tpl_vars['blockImages'] == true): ?> checked="checked"<?php endif; ?>>
									<?php echo $this->_config[0]['vars']['prf_block_images']; ?>
<br>
									<input type="checkbox" name="display_images" value="1"<?php if ($this->_tpl_vars['displayImages'] == true): ?> checked="checked"<?php endif; ?>>
									<?php echo $this->_config[0]['vars']['prf_display_images']; ?>
<br>
									<input type="checkbox" name="require_receipt" value="1"<?php if ($this->_tpl_vars['requireReceipt'] == true): ?> checked="checked"<?php endif; ?>>
									<?php echo $this->_config[0]['vars']['prf_auto_require_receipt']; ?>
<br>
									<input type="checkbox" name="unmark_read_on_exit" value="1" <?php if ($this->_tpl_vars['unmarkReadOnExit'] == true): ?> checked="checked"<?php endif; ?>>
									<?php echo $this->_config[0]['vars']['prf_unmark_read_on_exit']; ?>

								</td>
	
							</tr>
							</table>
						</fieldset>
						<br>
						<fieldset><legend><?php echo $this->_config[0]['vars']['prf_sent_title']; ?>
</legend>
							<table width='100%' cellpadding='2' cellspacing='0'>
							<tr>
								<td><input type="checkbox" name="save_sent" value="1"<?php if ($this->_tpl_vars['saveSent'] == true): ?> checked="checked"<?php endif; ?>>
								<?php echo $this->_config[0]['vars']['prf_save_sent']; ?>
 "<b><?php echo $this->_config[0]['vars']['sent_extended']; ?>
</b>"</td>
							</tr>
							</table>
						</fieldset>
						<br>
						<table>
						<tr>
							<td><input type="submit" value="<?php echo $this->_config[0]['vars']['prf_save_button']; ?>
" class="button"></td>
						</tr>
						</table>
						</div>
						
		<!-- third tab - Signature -->
						<div id="signature" class="tab_hidden">
						<fieldset><legend><?php echo $this->_config[0]['vars']['prf_signature_title']; ?>
</legend>
							<table width='100%' cellpadding='2' cellspacing='0'>
							<tr>
								<td class="label"><?php echo $this->_config[0]['vars']['prf_signature']; ?>
</td>
							</tr>
							<tr>
								<td>
									<textarea class="textbox" name="sig" id="htmleditor" rows="10" cols="80" style="width: 570px; height: 200px;"><?php echo $this->_tpl_vars['signature']; ?>
</textarea>
								</td>
							</tr>
							<tr>
								<td colspan="2"><input type="checkbox" name="add_sig" value="1"<?php if ($this->_tpl_vars['addSignature'] == true): ?> checked="checked"<?php endif; ?>>
								<?php echo $this->_config[0]['vars']['prf_auto_add_sign']; ?>
</td>
							</tr>
							</table>
						</fieldset>
						<table>
						<tr>
							<td><input type="submit" value="<?php echo $this->_config[0]['vars']['prf_save_button']; ?>
" class="button"></td>
						</tr>
						</table>
						</div>
	
		<!-- fourth tab - Trash -->
						<div id="trash" class="tab_hidden">
						<fieldset>
							<legend><?php echo $this->_config[0]['vars']['prf_trash_title']; ?>
</legend>
							<table width="100%" cellpadding="2" cellspacing="0">
							<tr>
								<td>
									<input type="checkbox" name="save_trash" onClick="dis()" value="1"<?php if ($this->_tpl_vars['saveTrash'] == true): ?> checked="checked"<?php endif; ?>>
									<?php echo $this->_config[0]['vars']['prf_save_to_trash']; ?>
 "<b><?php echo $this->_config[0]['vars']['trash_extended']; ?>
</b>"
								</td>
							</tr>
							
							<tr>
								<td>
									<input type="checkbox" name="save_spam" onClick="dis()" value="1"<?php if ($this->_tpl_vars['saveSpam'] == true): ?> checked="checked"<?php endif; ?>>
									<?php echo $this->_config[0]['vars']['prf_save_to_spam']; ?>
 "<b><?php echo $this->_config[0]['vars']['spam_extended']; ?>
</b>"
								</td>
							</tr>
									
							<tr>
								<td>
									<input type="checkbox" name="st_only_read" value="1"<?php if ($this->_tpl_vars['saveTrashOnlyRead'] == true): ?> checked="checked"<?php endif; ?>>
									<?php echo $this->_config[0]['vars']['prf_save_only_read']; ?>
 "<b><?php echo $this->_config[0]['vars']['trash_extended']; ?>
</b>"
								</td>
							</tr>
							<tr>
								<td>
									<input type="checkbox" name="empty_trash_on_exit" value="1"<?php if ($this->_tpl_vars['emptyTrashOnExit'] == true): ?> checked="checked"<?php endif; ?>>
									<?php echo $this->_config[0]['vars']['prf_empty_on_exit']; ?>

								</td>
							</tr>
							
							</table>
						</fieldset>
						<table>
						<tr>
							<td><input type="submit" value="<?php echo $this->_config[0]['vars']['prf_save_button']; ?>
" class="button"></td>
						</tr>
						</table>
	
						</div>
						
		<!-- fifth tab - Skin -->
						<div id="skin" class="tab_hidden">
						<input type="hidden" id="selskin" name="skin" value="<?php echo $this->_tpl_vars['umSkin']; ?>
">
						<fieldset>
							<legend><?php echo $this->_config[0]['vars']['skin_title']; ?>
</legend>
							<table class="tablecollapsed">
							<tr>
								<td>
								<ul class="menu">
									<li><a href="#" onclick="setActiveStyleSheet('default'); return false;"> &nbsp; &nbsp; <img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/skins/default/swatch.gif" border="0" align="middle" alt=""> &nbsp; <?php echo $this->_config[0]['vars']['prf_skin_default']; ?>
</a></li>
										
										<li><a href="#" onclick="setActiveStyleSheet('black_lime'); return false;"> &nbsp; &nbsp; <img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/skins/black_lime/swatch.gif" border="0" align="middle" alt=""> &nbsp; <?php echo $this->_config[0]['vars']['prf_skin_black2']; ?>
</a></li>								
									<li><a href="#" onclick="setActiveStyleSheet('css_blue'); return false;"> &nbsp; &nbsp; <img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/skins/css_blue/swatch.gif" border="0" align="middle" alt=""> &nbsp; <?php echo $this->_config[0]['vars']['prf_skin_blue']; ?>
</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('css_red'); return false;"> &nbsp; &nbsp; <img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/skins/css_red/swatch.gif" border="0" align="middle" alt=""> &nbsp; <?php echo $this->_config[0]['vars']['prf_skin_red']; ?>
</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('css_pastel_blue'); return false;"> &nbsp; &nbsp; <img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/skins/css_pastel_blue/swatch.gif" border="0" align="middle" alt=""> &nbsp; <?php echo $this->_config[0]['vars']['prf_skin_pastel_blue']; ?>
</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('gold_2_tone'); return false;"> &nbsp; &nbsp; <img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/skins/gold_2_tone/swatch.gif" border="0" align="middle" alt=""> &nbsp; <?php echo $this->_config[0]['vars']['prf_skin_gold2']; ?>
</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('lime_2_tone'); return false;"> &nbsp; &nbsp; <img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/skins/lime_2_tone/swatch.gif" border="0" align="middle" alt=""> &nbsp; <?php echo $this->_config[0]['vars']['prf_skin_lime2']; ?>
</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('purple_2_tone'); return false;"> &nbsp; &nbsp; <img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/skins/purple_2_tone/swatch.gif" border="0" align="middle" alt=""> &nbsp; <?php echo $this->_config[0]['vars']['prf_skin_purple2']; ?>
</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('red_2_tone'); return false;"> &nbsp; &nbsp; <img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/skins/red_2_tone/swatch.gif" border="0" align="middle" alt=""> &nbsp; <?php echo $this->_config[0]['vars']['prf_skin_red2']; ?>
</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('xp_blue'); return false;"> &nbsp; &nbsp; <img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/skins/xp_blue/swatch.gif" border="0" align="middle" alt=""> &nbsp; <?php echo $this->_config[0]['vars']['prf_skin_xp_blue']; ?>
</a></li>
									<li><a href="#" onclick="setActiveStyleSheet('black_mesh'); return false;"> &nbsp; &nbsp; <img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/skins/black_mesh/swatch.gif" border="0" align="middle" alt=""> &nbsp; <?php echo $this->_config[0]['vars']['prf_skin_black']; ?>
</a></li>
									
									
								</ul>
								</td>
							</tr>
							</table>
						</fieldset>
						<table>
						<tr>
							<td><input type="submit" value="<?php echo $this->_config[0]['vars']['prf_save_button']; ?>
" class="button"></td>
						</tr>
						</table>
						</div>
					</form><!--"end of prefs_form" -->

		<!-- sixth tab - Filters -->
						<div id="filters" class="tab_hidden">
						<form action="preferences.php" method="post">
							<input type="hidden" name="action" value="addFilter">
							<?php echo $this->_tpl_vars['umForms']; ?>

							
							<fieldset>
								<legend><?php echo $this->_config[0]['vars']['filter_new']; ?>
</legend>	
								<table width="100%" cellpadding="2" cellspacing="0">
									<tr>
										<td class="label"width="200"><?php echo $this->_config[0]['vars']['filter_field']; ?>
</td>
										<td>
											<select name="filter_field" size="1">
												<option value="1"><?php echo $this->_config[0]['vars']['filter_field_from']; ?>
</option>
												<option value="2"><?php echo $this->_config[0]['vars']['filter_field_subject']; ?>
</option>
												<option value="4"><?php echo $this->_config[0]['vars']['filter_field_to']; ?>
</option>
												<option value="3"><?php echo $this->_config[0]['vars']['filter_field_header']; ?>
</option>
												<option value="5"><?php echo $this->_config[0]['vars']['filter_field_strbody']; ?>
</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label"><?php echo $this->_config[0]['vars']['filter_match']; ?>
</td>
										<td>
											 <input type="text" class="textbox" name="filter_match">
										</td>
									</tr>
									<tr>
										<td class="label">
											<?php echo $this->_config[0]['vars']['filter_type']; ?>

										</td>
										<td>
											<select name="filter_type" onchange="checkMove();">
												<option value="1"><?php echo $this->_config[0]['vars']['filter_type_move']; ?>
</option>
												<option value="2"><?php echo $this->_config[0]['vars']['filter_type_delete']; ?>
</option>
												<option value="4"><?php echo $this->_config[0]['vars']['filter_type_mark']; ?>
</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label">
											<?php echo $this->_config[0]['vars']['filter_folder']; ?>

										</td>
										<td>
											<select name="filter_folder" size="1">
												<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['umAvalFolders']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
													<option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['umAvalFolders'][$this->_sections['i']['index']]['path'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['umAvalFolders'][$this->_sections['i']['index']]['display'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

												<?php endfor; endif; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="default" align="center" colspan="2">
											<input type="submit" class="button" value="<?php echo $this->_config[0]['vars']['filter_add']; ?>
">
										</td>
									</tr>
								</table>
						</fieldset>
						</form><!--"end of noname" -->
						
						<!-- Available filters -->
						<form id="filters_form" name="filters_form" action="preferences.php" method="post">
							<input type="hidden" name="action" value="delFilter">
							<?php echo $this->_tpl_vars['umForms']; ?>


							<fieldset>
								<legend><?php echo $this->_config[0]['vars']['filter_list']; ?>
</legend>
									<table cellspacing="2" cellpadding="0" width="100%">
										<tr>
											<td class='messages' valign=top >
											<table class="tablecollapsed" bgcolor="white">
											 <tr>
												<td class="bar" width="20" style="font-weight: bold">
													<input type="checkbox" name="toggle" id="toggle" onclick="selectAll('filters_form', <?php echo count($this->_tpl_vars['filterList']); ?>
)">
												</td>
												<td class="bar" style="font-weight: bold"><?php echo $this->_config[0]['vars']['filter_field']; ?>
</td>
												<td class="bar" style="font-weight: bold"><?php echo $this->_config[0]['vars']['filter_match']; ?>
</td>
												<td class="bar" style="font-weight: bold"><?php echo $this->_config[0]['vars']['filter_type']; ?>
</td>
												<td class="bar" style="font-weight: bold"><?php echo $this->_config[0]['vars']['filter_folder']; ?>
</td>
												<td class="bar" style="font-weight: bold">&nbsp;</td>
											</tr>
										<?php unset($this->_sections['filter']);
$this->_sections['filter']['name'] = 'filter';
$this->_sections['filter']['loop'] = is_array($_loop=$this->_tpl_vars['filterList']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['filter']['show'] = true;
$this->_sections['filter']['max'] = $this->_sections['filter']['loop'];
$this->_sections['filter']['step'] = 1;
$this->_sections['filter']['start'] = $this->_sections['filter']['step'] > 0 ? 0 : $this->_sections['filter']['loop']-1;
if ($this->_sections['filter']['show']) {
    $this->_sections['filter']['total'] = $this->_sections['filter']['loop'];
    if ($this->_sections['filter']['total'] == 0)
        $this->_sections['filter']['show'] = false;
} else
    $this->_sections['filter']['total'] = 0;
if ($this->_sections['filter']['show']):

            for ($this->_sections['filter']['index'] = $this->_sections['filter']['start'], $this->_sections['filter']['iteration'] = 1;
                 $this->_sections['filter']['iteration'] <= $this->_sections['filter']['total'];
                 $this->_sections['filter']['index'] += $this->_sections['filter']['step'], $this->_sections['filter']['iteration']++):
$this->_sections['filter']['rownum'] = $this->_sections['filter']['iteration'];
$this->_sections['filter']['index_prev'] = $this->_sections['filter']['index'] - $this->_sections['filter']['step'];
$this->_sections['filter']['index_next'] = $this->_sections['filter']['index'] + $this->_sections['filter']['step'];
$this->_sections['filter']['first']      = ($this->_sections['filter']['iteration'] == 1);
$this->_sections['filter']['last']       = ($this->_sections['filter']['iteration'] == $this->_sections['filter']['total']);
?>
											<tr>
												<td width="18" align="center">
													<input type="checkbox" id="cb<?php echo $this->_sections['filter']['index']; ?>
" name="filters_array[]" value="<?php echo $this->_sections['filter']['index']; ?>
">
												</td>
												<td class="label">
												<?php if ($this->_tpl_vars['filterList'][$this->_sections['filter']['index']]['field'] == 1): ?><?php echo $this->_config[0]['vars']['filter_field_from']; ?>

												<?php elseif ($this->_tpl_vars['filterList'][$this->_sections['filter']['index']]['field'] == 2): ?><?php echo $this->_config[0]['vars']['filter_field_subject']; ?>

												<?php elseif ($this->_tpl_vars['filterList'][$this->_sections['filter']['index']]['field'] == 4): ?><?php echo $this->_config[0]['vars']['filter_field_to']; ?>

												<?php elseif ($this->_tpl_vars['filterList'][$this->_sections['filter']['index']]['field'] == 3): ?><?php echo $this->_config[0]['vars']['filter_field_header']; ?>

												<?php elseif ($this->_tpl_vars['filterList'][$this->_sections['filter']['index']]['field'] == 5): ?><?php echo $this->_config[0]['vars']['filter_field_strbody']; ?>

												
												<?php endif; ?>
												
												</td>
												<td class="label"><?php echo $this->_tpl_vars['filterList'][$this->_sections['filter']['index']]['match']; ?>
</td>
												<td class="label">
												<?php if ($this->_tpl_vars['filterList'][$this->_sections['filter']['index']]['type'] == 1): ?><?php echo $this->_config[0]['vars']['filter_type_move']; ?>

												<?php elseif ($this->_tpl_vars['filterList'][$this->_sections['filter']['index']]['type'] == 2): ?><?php echo $this->_config[0]['vars']['filter_type_delete']; ?>

												<?php elseif ($this->_tpl_vars['filterList'][$this->_sections['filter']['index']]['type'] == 3): ?><?php echo $this->_config[0]['vars']['filter_type_spam']; ?>

												<?php elseif ($this->_tpl_vars['filterList'][$this->_sections['filter']['index']]['type'] == 4): ?><?php echo $this->_config[0]['vars']['filter_type_mark']; ?>
<?php endif; ?>
												</td>
												<td class="label"><?php echo $this->_tpl_vars['filterList'][$this->_sections['filter']['index']]['moveto']; ?>
</td>
												<td align="center">
													<a href="#" onclick="javascript:if (confirm(js_confirm_delfilter)) selectAndSubmit('filters_form',<?php echo $this->_sections['filter']['index']; ?>
);return false;"><acronym title="<?php echo $this->_config[0]['vars']['filter_delete']; ?>
">
													<img src='themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/cross.gif' border="0" alt=""></acronym></a>
												</td>
											</tr>
										<?php endfor; else: ?>
											<tr>
												<td class="label" align="center" colspan="6"><br><?php echo $this->_config[0]['vars']['filter_msg_nofilters']; ?>
<br><br></td>
											</tr>
										<?php endif; ?>
											</table>
											</td>
										</tr>
										<?php if ($this->_tpl_vars['filterList']): ?>
											<tr>
												<td colspan="2" style="text-align: center; padding-top: 4px;">
													<input type="button" class="button" value="<?php echo $this->_config[0]['vars']['filter_delete_selected']; ?>
" onclick="javascript:if (confirm(js_confirm_delfilter)) submitForm('filters_form');return false;">
												</td>
											</tr>
										<?php endif; ?>
									</table>
							</fieldset>
						</form><!--"end of filters_form" -->
					</div>
						
					</td>
				</tr>
				</table>
			</center>
			