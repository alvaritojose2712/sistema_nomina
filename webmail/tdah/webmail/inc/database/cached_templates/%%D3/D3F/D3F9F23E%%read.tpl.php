<?php /* Smarty version 2.6.24, created on 2011-03-26 15:27:12
         compiled from default/inc/read.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'default/inc/read.tpl', 11, false),array('modifier', 'truncate', 'default/inc/read.tpl', 12, false),array('modifier', 'default', 'default/inc/read.tpl', 50, false),array('modifier', 'date_format', 'default/inc/read.tpl', 52, false),)), $this); ?>
<table class="tablecollapsed" height="100%">
		<tr height="10%">
			<td class="background">
			
			<!-- Message header -->
			<table class="tablecollapsed" cellpadding="5">
			<tr>
				<td><b><?php echo $this->_config[0]['vars']['from_hea']; ?>
</b></td>
				<td class="msg_links">
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['umFromList']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<a href="<?php echo $this->_tpl_vars['umFromList'][$this->_sections['i']['index']]['link']; ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['umFromList'][$this->_sections['i']['index']]['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
">
						<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['umFromList'][$this->_sections['i']['index']]['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 70, $this->_config[0]['vars']['no_sender_text']) : smarty_modifier_truncate($_tmp, 70, $this->_config[0]['vars']['no_sender_text'])))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
					<?php endfor; endif; ?>
				</td>
				<td><b><?php echo $this->_config[0]['vars']['to_hea']; ?>
</b></td>
				<td class="msg_links">
				<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['umTOList']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
					<?php if (! $this->_sections['i']['first']): ?> ; <?php endif; ?>
					<a href="<?php echo $this->_tpl_vars['umTOList'][$this->_sections['i']['index']]['link']; ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['umTOList'][$this->_sections['i']['index']]['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
">
					<?php echo ((is_array($_tmp=$this->_tpl_vars['umTOList'][$this->_sections['i']['index']]['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30, 'escape', 'html') : smarty_modifier_truncate($_tmp, 30, 'escape', 'html')); ?>
</a>
					<?php $this->assign('firstto', 'no'); ?>
				<?php endfor; else: ?>
					&nbsp;<?php echo $this->_config[0]['vars']['no_recipient_text']; ?>

				<?php endif; ?>
				</td>
			</tr>

				<tr>
			<?php if ($this->_tpl_vars['umHaveCC']): ?>
					<td><b><?php echo $this->_config[0]['vars']['cc_hea']; ?>
</b></td>
					<td class="msg_links">
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['umTOList']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<?php if (! $this->_sections['i']['first']): ?> ; <?php endif; ?>
						<a href="<?php echo $this->_tpl_vars['umTOList'][$this->_sections['i']['index']]['link']; ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['umTOList'][$this->_sections['i']['index']]['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
">
						<?php echo ((is_array($_tmp=$this->_tpl_vars['umTOList'][$this->_sections['i']['index']]['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30, 'escape', 'html') : smarty_modifier_truncate($_tmp, 30, 'escape', 'html')); ?>
</a>
						<?php $this->assign('firstto', 'no'); ?>
					<?php endfor; else: ?>
						&nbsp;<?php echo $this->_config[0]['vars']['no_recipient_text']; ?>

					<?php endif; ?>
					</td>
			<?php else: ?>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
			<?php endif; ?>
					<td><b><?php echo $this->_config[0]['vars']['msg_folder']; ?>
</b></td>
					<td><?php echo $this->_tpl_vars['umFolder']; ?>
</td>
				</tr>
			<tr>
				<td width="65"><b><?php echo $this->_config[0]['vars']['subject_hea']; ?>
</b></td>
				<td><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['umSubject'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_config[0]['vars']['no_subject_text']) : smarty_modifier_default($_tmp, @$this->_config[0]['vars']['no_subject_text'])))) ? $this->_run_mod_handler('truncate', true, $_tmp, 70, "...", true) : smarty_modifier_truncate($_tmp, 70, "...", true)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</td>
				<td width="65"><b><?php echo $this->_config[0]['vars']['date_hea']; ?>
</b></td>
				<td width="26%"class="menu"><?php echo ((is_array($_tmp=$this->_tpl_vars['umDate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['date_format']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['date_format'])); ?>
</td>
			</tr>
			</table>
		 
		 			<?php if ($this->_tpl_vars['umHaveAttachments']): ?>
			<div class="dhtmlgoodies_question">
				<img img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/plus.gif"id="attachimg">&nbsp;&nbsp;<b><?php echo $this->_config[0]['vars']['attach_hea']; ?>
 (<?php echo $this->_tpl_vars['umNumAttach']; ?>
)</b>
			</div>
			<div class="dhtmlgoodies_answer"><div>
			
		  <table  width="100%" border="0" cellspacing="0" cellpadding="3">
   			
		  <table id="attach" class="tablehide" width="100%" border="0" cellspacing="0" cellpadding="3"> 
			<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['umAttachList']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			
      <tr>
        <td class="msg_links" width="50%">
					&nbsp; <?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['downlink']; ?>
<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/download.gif" border="0" alt=""></a>
					&nbsp; &nbsp;<?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['normlink']; ?>
<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 50, "...", true) : smarty_modifier_truncate($_tmp, 50, "...", true)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
				</td>
				        
				<td width="25%"><?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['size']; ?>
 <?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['unit']; ?>
<?php echo $this->_config[0]['vars']['bytes']; ?>
</td>
				<td width="25%"><?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['type']; ?>
</td>
      </tr>

      <?php endfor; endif; ?>
      </table>
			</div></div>

			<?php endif; ?>
		 
			</td>
		</tr>
		<!-- Body -->
		<tr>
			<td>
			<table height="100%" class="text_body upper_line">
			<tr>
				<td><?php echo $this->_tpl_vars['umMessageBody']; ?>
</td>
			</tr>
			</table>
		</tr>
		</table>