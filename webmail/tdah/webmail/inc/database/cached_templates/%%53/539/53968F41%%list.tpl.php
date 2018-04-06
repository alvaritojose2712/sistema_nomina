<?php /* Smarty version 2.6.24, created on 2011-03-26 15:21:18
         compiled from default/inc/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'default/inc/list.tpl', 29, false),array('modifier', 'default', 'default/inc/list.tpl', 29, false),array('modifier', 'truncate', 'default/inc/list.tpl', 30, false),array('modifier', 'date_format', 'default/inc/list.tpl', 39, false),)), $this); ?>
<?php if ($this->_tpl_vars['umNumMessages'] > 0): ?>
				<?php if ($this->_tpl_vars['umErrorMessage'] != ""): ?>	<?php endif; ?>
					<table class="tablecollapsed page_color">
					<tr height="20">
						<td width="20" class="bar"><input type="checkbox" name="chkall" onclick="sel();"></td>
						<td width="15" class="bar"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/deflagged.gif" alt=""></td>
						<td width="6" class="bar"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/prior_high.gif" alt=""></td>
						<td width="7" class="bar"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/attach.gif" alt=""></td>
						<td width="16" class="bar"></td>
						<?php if ($this->_tpl_vars['umFolder'] == 'sent'): ?>
							<td width="200" class="bar" ><b><a href="javascript:sortby('toname')" title="<?php echo $this->_config[0]['vars']['msg_sort']; ?>
"><?php echo $this->_config[0]['vars']['to_hea']; ?>
 <?php echo $this->_tpl_vars['umToArrow']; ?>
</a></b></td>
						<?php else: ?>
							<td width="200" class="bar" ><b><a href="javascript:sortby('fromname')" title="<?php echo $this->_config[0]['vars']['msg_sort']; ?>
"><?php echo $this->_config[0]['vars']['from_hea']; ?>
&nbsp; <?php echo $this->_tpl_vars['umFromArrow']; ?>
</a></b></td>
						<?php endif; ?>
						
						<td class="bar"><b><a href="javascript:sortby('subject')" title="<?php echo $this->_config[0]['vars']['msg_sort']; ?>
"><?php echo $this->_config[0]['vars']['subject_hea']; ?>
 <?php echo $this->_tpl_vars['umSubjectArrow']; ?>
</a></b></td>
						<td width="150" class="bar"><b><a href="javascript:sortby('date')" title="<?php echo $this->_config[0]['vars']['msg_sort']; ?>
"><?php echo $this->_config[0]['vars']['date_hea']; ?>
<?php echo $this->_tpl_vars['umDateArrow']; ?>
</a></b></td>
						<td width="50" class="bar"><b><a href="javascript:sortby('size')" title="<?php echo $this->_config[0]['vars']['msg_sort']; ?>
"><?php echo $this->_config[0]['vars']['size_hea']; ?>
<?php echo $this->_tpl_vars['umSizeArrow']; ?>
</a></b>&nbsp;</td>
					</tr>
						
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['umMessageList']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<tr onmouseover="this.className='hover_color';" onmouseout="this.className='';">
							<td><?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['checkbox']; ?>
</td>
							<td><?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['flaggedimg']; ?>
</td>
							<td><?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['priorimg']; ?>
</td>
							<td><?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['attachimg']; ?>
</td>
							<td><?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['statusimg']; ?>
</td>
						<?php if ($this->_tpl_vars['umFolder'] == 'sent'): ?>
							<td><acronym title="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['to'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_config[0]['vars']['no_recipient_text']) : smarty_modifier_default($_tmp, @$this->_config[0]['vars']['no_recipient_text'])); ?>
">
								<a href="<?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['composelinksent']; ?>
" class="menu"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['to'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 40, "...", true) : smarty_modifier_truncate($_tmp, 40, "...", true)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_config[0]['vars']['no_recipient_text']) : smarty_modifier_default($_tmp, @$this->_config[0]['vars']['no_recipient_text'])); ?>
</a></acronym></td>
						<?php else: ?>
							<td><p align="left"><acronym title="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['from'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_config[0]['vars']['no_recipient_text']) : smarty_modifier_default($_tmp, @$this->_config[0]['vars']['no_recipient_text'])); ?>
">
								<a href="<?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['readlink']; ?>
" class="menu"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['from'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30, "...", true) : smarty_modifier_truncate($_tmp, 30, "...", true)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_config[0]['vars']['no_subject_text']) : smarty_modifier_default($_tmp, @$this->_config[0]['vars']['no_subject_text'])); ?>
</a></acronym></td>
						<?php endif; ?>
						<td><p align="left"><acronym title="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['subject'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_config[0]['vars']['no_subject_text']) : smarty_modifier_default($_tmp, @$this->_config[0]['vars']['no_subject_text'])); ?>
">
							<?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == 'false'): ?><b><?php endif; ?><a href="<?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['readlink']; ?>
" class="menu">
							<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['subject'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 50, "...", true) : smarty_modifier_truncate($_tmp, 50, "...", true)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_config[0]['vars']['no_subject_text']) : smarty_modifier_default($_tmp, @$this->_config[0]['vars']['no_subject_text'])); ?>
</a>
							<?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == 'false'): ?></b><?php endif; ?></acronym></td>
						<td nowrap ><?php echo ((is_array($_tmp=$this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['date_format']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['date_format'])); ?>
</td>
						<td nowrap ><font color="gray"><?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['size']; ?>
 <?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['unit']; ?>
<?php echo $this->_config[0]['vars']['bytes']; ?>
 &nbsp;</font></td>
					</tr>
					<?php endfor; endif; ?>
					</table>
			
				<center class="upper_line navbar"><br>
				<?php if ($this->_tpl_vars['umPreviousLink']): ?>
					<a href="<?php echo $this->_tpl_vars['umPreviousLink']; ?>
"><?php echo $this->_config[0]['vars']['previous_text']; ?>
</a> &nbsp;
				<?php endif; ?>
				<?php echo $this->_config[0]['vars']['pages']; ?>
 <?php echo $this->_tpl_vars['umNavBar']; ?>

				<?php if ($this->_tpl_vars['umNextLink']): ?>
					&nbsp;<a href="<?php echo $this->_tpl_vars['umNextLink']; ?>
"><?php echo $this->_config[0]['vars']['next_text']; ?>
</a>
				<?php endif; ?></center>
					
			<?php else: ?>
				<table class="tablecollapsed">
				<tr>
					<td align="center"><br><?php echo $this->_config[0]['vars']['no_messages']; ?>
 <b><?php echo ((is_array($_tmp=$this->_tpl_vars['umBoxName'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
 <?php echo $this->_config[0]['vars']['folder']; ?>
</b></td>
				</tr>
				</table>
			<?php endif; ?>
	