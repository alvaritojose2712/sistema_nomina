<?php /* Smarty version 2.6.24, created on 2011-03-26 15:20:52
         compiled from default/inc/panel.tpl */ ?>

				<td valign="top" class="panel"> 
					<!--"start left pane" -->
					<table class="tablecollapsed" cellpadding="0" height="100%">
					<tr>
						<td valign="top">
						<!--"TREE" --> 		       
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath']).($this->_tpl_vars['TPL_TREE']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						</td>
					<tr> 
					
						<td valign="bottom"> 
						
<!--"MENU" --> 		       
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath']).($this->_tpl_vars['TPL_MENU']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						</td>
					</tr>
					</table>
				</td>
						
				<!-- Vertical separator -->
				<td class="v_separaror" rowspan="2">&nbsp;</td>