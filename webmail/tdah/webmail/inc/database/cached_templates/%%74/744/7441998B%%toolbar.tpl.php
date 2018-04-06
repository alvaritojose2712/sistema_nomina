<?php /* Smarty version 2.6.24, created on 2011-03-26 15:20:52
         compiled from default/inc/toolbar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'default/inc/toolbar.tpl', 114, false),)), $this); ?>

	<!--"start top bar" --> 		       
	<?php if (! $this->_tpl_vars['umTLB_NONE']): ?>
	<tr height="28">
		<td class="bar" height="28" width="100%">
		
			<table class="tablecollapsed">
			<tr>
			<td><ul id="topleft">
			<?php if ($this->_tpl_vars['umTLB_FOLDERS']): ?>
				<li><a><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/clear.gif" alt="" border="0" align="middle"><b><?php echo $this->_tpl_vars['umFolderNb']; ?>
&nbsp;<?php echo $this->_config[0]['vars']['folders_mnu']; ?>
 <?php if ($this->_tpl_vars['umMsgNb'] > 0): ?>[<?php echo $this->_tpl_vars['umMsgNb']; ?>
]<?php endif; ?></b></a></li>
				<?php if ($this->_tpl_vars['umTLB_FOLDERS'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle">&nbsp;</a></li>
				<?php endif; ?>
			<?php endif; ?>
	
			<?php if ($this->_tpl_vars['umTLB_REFRESH']): ?>
				<li><a href="javascript:refreshlist();" title="<?php echo $this->_config[0]['vars']['refresh_mnu']; ?>
">
					<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/check.gif" alt="" border="0" align="middle">&nbsp;<?php echo $this->_config[0]['vars']['refresh_mnu']; ?>
</a></li>
				<?php if ($this->_tpl_vars['umTLB_REFRESH'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				<?php endif; ?>		
			<?php endif; ?>		
	
			<?php if ($this->_tpl_vars['umTLB_COMPOSE']): ?>
				<li><a href="javascript:newmsg();" title="<?php echo $this->_config[0]['vars']['compose_mnu']; ?>
">
					<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/new.gif" alt="" border="0" align="middle">&nbsp;<?php echo $this->_config[0]['vars']['compose_mnu']; ?>
</a> </li>
				<?php if ($this->_tpl_vars['umTLB_COMPOSE'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				<?php endif; ?>		
			<?php endif; ?>		
	
			<?php if ($this->_tpl_vars['umTLB_DEL_SELECT']): ?>
				<li><a href="javascript:deletemsg();" title="<?php echo $this->_config[0]['vars']['delete_selected_mnu']; ?>
">
					<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/delete.gif" alt="" border="0" align="middle">&nbsp;<?php echo $this->_config[0]['vars']['delete_selected_mnu']; ?>
</a> </li>
				<?php if ($this->_tpl_vars['umTLB_DEL_SELECT'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>	   
				<?php endif; ?>	
			<?php endif; ?>	
		<?php if ($this->_tpl_vars['umTLB_SPAM_SELECT']): ?>
				<li><a href="javascript:spammsg();" title="<?php echo $this->_config[0]['vars']['spam_selected_mnu']; ?>
">
					<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/spam.gif" alt="" border="0" align="middle">&nbsp;<?php echo $this->_config[0]['vars']['spam_selected_mnu']; ?>
</a> </li>
				<?php if ($this->_tpl_vars['umTLB_SPAM_SELECT'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>	   
				<?php endif; ?>	
			<?php endif; ?>
			<?php if ($this->_tpl_vars['umTLB_DELETE']): ?>
				<li><a href="javascript:deletemsg();" title="<?php echo $this->_config[0]['vars']['delete_mnu']; ?>
">
					<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/delete.gif" alt="" border="0" align="middle">&nbsp;<?php echo $this->_config[0]['vars']['delete_mnu']; ?>
</a> </li>
				<?php if ($this->_tpl_vars['umTLB_DELETE'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				<?php endif; ?>	
			<?php endif; ?>	
	
			<?php if ($this->_tpl_vars['umTLB_SPAM']): ?>
				<li><a href="javascript:spam_addresses();" title="<?php echo $this->_config[0]['vars']['spam_message_mnu']; ?>
">
					<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/spam.gif" alt="<?php echo $this->_config[0]['vars']['spam_message_mnu']; ?>
" border="0" align="middle">&nbsp;<?php echo $this->_config[0]['vars']['spam_mnu']; ?>
</a> </li>
				<?php if ($this->_tpl_vars['umTLB_SPAM'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				<?php endif; ?>	
			<?php endif; ?>	
	
			<?php if ($this->_tpl_vars['umTLB_MOVE']): ?>
				<li><a href="#" onmouseover="javascript:mopen('m4');" onmouseout="javascript:mclosetime();" title="<?php echo $this->_config[0]['vars']['move_mnu']; ?>
">
					<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/move.gif" alt="" border="0" align="middle">&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['move_mnu']; ?>
</a><br>
				<div id="m4" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
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
						<a href='#' onclick='javascript:document.form1.aval_folders.value="<?php echo ((is_array($_tmp=$this->_tpl_vars['umAvalFolders'][$this->_sections['i']['index']]['path'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"; movemsg();'>
						<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/folder.gif" border="0" align="middle" alt="<?php echo $this->_config[0]['vars']['move_selected_mnu']; ?>
">
						&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['umAvalFolders'][$this->_sections['i']['index']]['display'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
					<?php endfor; endif; ?>		
				</div></li>
				<?php if ($this->_tpl_vars['umTLB_MOVE'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				<?php endif; ?>		
			<?php endif; ?>		
	
			<?php if ($this->_tpl_vars['umTLB_SEND']): ?>
				<li><a href="javascript:sendmsg();" title="<?php echo $this->_config[0]['vars']['send_text']; ?>
">
					<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/send.gif" alt="" border="0" align="middle">&nbsp;<?php echo $this->_config[0]['vars']['send_text']; ?>
</a> </li>
				<?php if ($this->_tpl_vars['umTLB_SEND'] == 1): ?>
					<li class="separator"><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				<?php endif; ?>		
			<?php endif; ?>		
	
			<?php if ($this->_tpl_vars['umTLB_ATTACH']): ?>
				<li><a href="javascript:upwin();" title="<?php echo $this->_config[0]['vars']['attch_add_new']; ?>
">
					<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/clip.gif" alt="" border="0" align="middle">&nbsp;<?php echo $this->_config[0]['vars']['attch_add_new']; ?>
</a> </li>
				<?php if ($this->_tpl_vars['umTLB_ATTACH'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				<?php endif; ?>		
			<?php endif; ?>		
	
			<?php if ($this->_tpl_vars['umTLB_MARK_FLAG']): ?>
			<li><a href="#" onmouseover="javascript:mopen('m3');" onmouseout="javascript:mclosetime();" title="<?php echo $this->_config[0]['vars']['actions_mnu']; ?>
">
				<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/marked.gif" alt="" border="0" align="middle">&nbsp;<?php echo $this->_config[0]['vars']['actions_mnu']; ?>
</a><br>
				<div id="m3" onmouseover="javascript:mcancelclosetime();" onmouseout="javascript:mclosetime();">
					<a href="javascript:markmsg();"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/read.gif" alt="" border="0" align="middle">&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['mark_selected_mnu']; ?>
</a>
					<a href="javascript:unmarkmsg();"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/msg.gif" alt="" border="0" align="middle">&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['unmark_selected_mnu']; ?>
</a>
					<a href="javascript:flagmsg();"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/flagged.gif" alt="" border="0" align="middle">&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['flag_selected_mnu']; ?>
</a>
					<a href="javascript:deflagmsg();"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/deflagged.gif" alt="" border="0" align="middle">&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['deflag_selected_mnu']; ?>
</a>
				</div></li>
				<?php if ($this->_tpl_vars['umTLB_MARK_FLAG'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				<?php endif; ?>		
			<?php endif; ?>		
	
			<?php if ($this->_tpl_vars['umTLB_ACTION']): ?>
				<li><a href="#" onmouseover="javascript:mopen('m3');" onmouseout="javascript:mclosetime();" title="<?php echo $this->_config[0]['vars']['actions_mnu']; ?>
">
					<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/marked.gif" alt="" border="0" align="middle">&nbsp;<?php echo $this->_config[0]['vars']['actions_mnu']; ?>
</a><br>
				<div id="m3" onmouseover="javascript:mcancelclosetime();" onmouseout="javascript:mclosetime();">
					<a href="javascript:reply();"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/reply_mail.gif" alt="" border="0" align="middle">&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['reply_mnu']; ?>
</a>
					<a href="javascript:replyall();"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/replyall_mail.gif" alt="" border="0" align="middle">&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['reply_all_mnu']; ?>
</a>
					<a href="javascript:forward();"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/forward_mail.gif" alt="" border="0" align="middle">&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['forward_mnu']; ?>
</a>
					<a href="#"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/hdivide.gif" alt="" border="0" align="middle"></a>
					<a href="javascript:catch_addresses();"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/contacts.gif" alt="" border="0" align="middle">&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['catch_address']; ?>
</a>
					<a href="javascript:headers();"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/header.gif" alt="" border="0" align="middle">&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['headers_mnu']; ?>
</a>
					<a href="javascript:printit();"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/print.gif" alt="" border="0" align="middle">&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['print_mnu']; ?>
</a>
					<a href="javascript:block_addresses();"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/block.gif" alt="" border="0" align="middle">&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['block_address']; ?>
</a>
				</div></li>        
				<?php if ($this->_tpl_vars['umTLB_ACTION'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				<?php endif; ?>		
			<?php endif; ?>		
	
			<?php if ($this->_tpl_vars['umTLB_NEW_ENTRY']): ?>
				<li><a href="javascript:add_address();" title="<?php echo $this->_config[0]['vars']['adr_new_entry']; ?>
">
				<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/cont.gif" border="0" align="middle" alt="">&nbsp;<?php echo $this->_config[0]['vars']['adr_new_entry']; ?>
</a></li>
				<?php if ($this->_tpl_vars['umTLB_NEW_ENTRY'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['umTLB_MAIN'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['umTLB_MAIN']): ?>
				<li><a href="javascript:main();" title="<?php echo $this->_config[0]['vars']['main_mnu']; ?>
">
				<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/home.gif" border="0" align="middle" alt="">&nbsp;<?php echo $this->_config[0]['vars']['main_mnu']; ?>
</a></li>
				<?php if ($this->_tpl_vars['umTLB_MAIN'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ($this->_tpl_vars['umTLB_UP_DOWN']): ?>
				<?php if ($this->_tpl_vars['umHavePrevious'] == 1): ?>
					<li><a href="<?php echo $this->_tpl_vars['umPreviousLink']; ?>
" title="<?php echo $this->_tpl_vars['umPreviousSubject']; ?>
"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/prev_mail.gif" alt="" border="0" align="middle"></a> </li>
				<?php else: ?>
					<li><a><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/prev_mail_2.gif" border="0" align="middle" alt=""></a></li>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['umHaveNext'] == 1): ?>    	
					<li><a href="<?php echo $this->_tpl_vars['umNextLink']; ?>
" title="<?php echo $this->_tpl_vars['umNextSubject']; ?>
"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/next_mail.gif" alt="" border="0" align="middle"></a> </li>
				<?php else: ?>
					<li><a><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/next_mail_2.gif" border="0" align="middle"></a></li>	
				<?php endif; ?>
				<?php if ($this->_tpl_vars['umTLB_UP_DOWN'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
				<?php endif; ?>	
			<?php endif; ?>	
	
			</ul></td>
	
			<td><ul id="topright">
		<?php if ($this->_tpl_vars['umTLB_LOGOFF']): ?>
				<li><a href="javascript:goend();" title="<?php echo $this->_config[0]['vars']['logoff_mnu']; ?>
">
					<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/logoff.gif" alt="" border="0" align="middle">&nbsp;<?php echo $this->_config[0]['vars']['logoff_mnu']; ?>
</a></li>
			<?php if ($this->_tpl_vars['umTLB_LOGOFF'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
			<?php endif; ?>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['umTLB_HELP']): ?>
				<li><a href="javascript:help();" title="<?php echo $this->_config[0]['vars']['help_mnu']; ?>
">
					<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/help.gif" alt="" border="0" align="middle">&nbsp;<?php echo $this->_config[0]['vars']['help_mnu']; ?>
</a></li>
			<?php if ($this->_tpl_vars['umTLB_HELP'] == 1): ?>
					<li><a class="separator"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/toolbar/divider.gif" alt="" border="0" align="middle"></a></li>
			<?php endif; ?>
		<?php endif; ?>
			</ul></td>
	
			</tr>
			</table>
			
		</td>
	</tr>
	<?php endif; ?>
	<!--"end top bar" -->