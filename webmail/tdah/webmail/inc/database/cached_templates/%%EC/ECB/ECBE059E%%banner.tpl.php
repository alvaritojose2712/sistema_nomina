<?php /* Smarty version 2.6.24, created on 2011-03-26 15:20:52
         compiled from default/inc/banner.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'default/inc/banner.tpl', 50, false),)), $this); ?>

	<!--"start header" -->        
	<tr>
		<td height="44" colspan="2">
		<table class="tablecollapsed" cellpadding="0" height="44">
		<tr>
			<td class="header" width="75">&nbsp;<img border="0" src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/skins/default/logo.gif" alt=""></td>
			<td class="header"><b><?php echo $this->_tpl_vars['umCompany']; ?>
<?php if ($this->_tpl_vars['umDomain'] != ""): ?> - <?php echo $this->_tpl_vars['umDomain']; ?>
<?php endif; ?></b></td>
		
			<td class="header"><p class="date" align="right">
			<span class="login_time" id="dfield">&nbsp;</span><br>
			<span class="login_time" id="clock">&nbsp;</span>
			</td>
				
		</tr>
		</table>
		</td>
	</tr>
	<!--"end header" -->             


	<?php $this->assign('umTLB_NONE', ((is_array($_tmp=@$this->_tpl_vars['umTLB_NONE'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	
	<?php $this->assign('umTLB_LOGOFF', ((is_array($_tmp=@$this->_tpl_vars['umTLB_LOGOFF'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_HELP', ((is_array($_tmp=@$this->_tpl_vars['umTLB_HELP'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_FOLDERS', ((is_array($_tmp=@$this->_tpl_vars['umTLB_FOLDERS'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_REFRESH', ((is_array($_tmp=@$this->_tpl_vars['umTLB_REFRESH'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_COMPOSE', ((is_array($_tmp=@$this->_tpl_vars['umTLB_COMPOSE'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_NEW_ENTRY', ((is_array($_tmp=@$this->_tpl_vars['umTLB_NEW_ENTRY'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_MAIN', ((is_array($_tmp=@$this->_tpl_vars['umTLB_MAIN'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_DEL_SELECT', ((is_array($_tmp=@$this->_tpl_vars['umTLB_DEL_SELECT'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_DELETE', ((is_array($_tmp=@$this->_tpl_vars['umTLB_DELETE'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_SPAM', ((is_array($_tmp=@$this->_tpl_vars['umTLB_SPAM'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_MOVE', ((is_array($_tmp=@$this->_tpl_vars['umTLB_MOVE'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_SEND', ((is_array($_tmp=@$this->_tpl_vars['umTLB_SEND'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_ATTACH', ((is_array($_tmp=@$this->_tpl_vars['umTLB_ATTACH'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_MARK_FLAG', ((is_array($_tmp=@$this->_tpl_vars['umTLB_MARK_FLAG'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_ACTION', ((is_array($_tmp=@$this->_tpl_vars['umTLB_ACTION'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>
	<?php $this->assign('umTLB_UP_DOWN', ((is_array($_tmp=@$this->_tpl_vars['umTLB_UP_DOWN'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))); ?>