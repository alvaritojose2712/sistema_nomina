<?php /* Smarty version 2.6.24, created on 2011-03-26 15:20:52
         compiled from default/inc/tree.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'default/inc/tree.tpl', 33, false),array('modifier', 'escape', 'default/inc/tree.tpl', 33, false),)), $this); ?>

	<!--"start tree" -->
					<table class="tablecollapsed trees" cellpadding="0" style="white-space: nowrap;">
						<!-- Title -->
						<tr>
							<td class="mbar title" colspan="2" title="<?php echo $this->_tpl_vars['umUser']; ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['umUser'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 17, "..", true) : smarty_modifier_truncate($_tmp, 17, "..", true)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</td>
						</tr>
						<!-- Spacer -->
						<tr height="5px">
							<td></td>	 
						</tr>
						<!-- Tree -->
						<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['umSystemFolders']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<tr class="tree_item" >
								<td onclick="javascript:window.location='<?php echo $this->_tpl_vars['umSystemFolders'][$this->_sections['i']['index']]['link']; ?>
';" onmouseover="javascript:this.className='tree_hover';" onmouseout="javascript:this.className='';" width="94%">
									<p title="<?php echo $this->_tpl_vars['umSystemFolders'][$this->_sections['i']['index']]['name']; ?>
">
									&nbsp; <img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tree/icon_mail.gif" alt="<?php echo $this->_tpl_vars['umSystemFolders'][$this->_sections['i']['index']]['name']; ?>
" border="0" align="middle">
									&nbsp; <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['umSystemFolders'][$this->_sections['i']['index']]['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10, "..", true) : smarty_modifier_truncate($_tmp, 10, "..", true)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['umSystemFolders'][$this->_sections['i']['index']]['msgs']; ?>
</p>
								</td>
								<td class="tree_empty" width="6%">
									<a href="javascript: if (window.confirm('<?php echo $this->_config[0]['vars']['fld_empty_validate']; ?>
\n<?php echo $this->_tpl_vars['umSystemFolders'][$this->_sections['i']['index']]['name']; ?>
')) window.location='<?php echo $this->_tpl_vars['umFolderList'][$this->_sections['i']['index']]['emptylink']; ?>
&goback=true';" title="<?php echo $this->_config[0]['vars']['empty_folder']; ?>
: <?php echo $this->_tpl_vars['umSystemFolders'][$this->_sections['i']['index']]['name']; ?>
">
									<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tree/empty.gif" border="0" align="middle" alt=""></a>
								</td>
							</tr>
						<?php endfor; endif; ?>
						
						<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['umPersonalFolders']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<tr class="tree_item">
								 <td onclick="javascript:window.location='<?php echo $this->_tpl_vars['umPersonalFolders'][$this->_sections['i']['index']]['link']; ?>
';" onmouseover="javascript:this.className='tree_hover';" onmouseout="javascript:this.className='';">
									<p title="<?php echo $this->_tpl_vars['umPersonalFolders'][$this->_sections['i']['index']]['name']; ?>
">
									&nbsp; <img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tree/folderopen.gif" alt="<?php echo $this->_tpl_vars['umPersonalFolders'][$this->_sections['i']['index']]['name']; ?>
" border="0" align="middle">
									&nbsp; <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['umPersonalFolders'][$this->_sections['i']['index']]['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10, "..", true) : smarty_modifier_truncate($_tmp, 10, "..", true)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['umPersonalFolders'][$this->_sections['i']['index']]['msgs']; ?>
</p>
								</td>
								<td class="tree_empty">
									<a href="javascript: if (window.confirm('<?php echo $this->_config[0]['vars']['fld_empty_validate']; ?>
\n<?php echo $this->_tpl_vars['umPersonalFolders'][$this->_sections['i']['index']]['name']; ?>
')) window.location='<?php echo $this->_tpl_vars['umPersonalFolders'][$this->_sections['i']['index']]['emptylink']; ?>
&goback=true';"  title="<?php echo $this->_config[0]['vars']['empty_folder']; ?>
: <?php echo $this->_tpl_vars['umPersonalFolders'][$this->_sections['i']['index']]['name']; ?>
">
									<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/tree/empty.gif" border="0" align="middle" alt=""></a>
								</td>
							</tr>
						<?php endfor; endif; ?>
							
					</table>
	<!--"end tree" -->