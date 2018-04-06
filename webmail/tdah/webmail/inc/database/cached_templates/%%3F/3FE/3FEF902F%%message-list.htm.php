<?php /* Smarty version 2.6.24, created on 2011-03-26 15:21:18
         compiled from default/message-list.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'default/message-list.htm', 26, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['umLanguageFile'],'section' => 'MessageList'), $this);?>

<?php echo $this->_tpl_vars['umDocType']; ?>

<?php echo $this->_tpl_vars['umsyslib']; ?>

<html>
<head>
  
	<?php echo $this->_tpl_vars['pageMetas']; ?>

	<?php echo $this->_tpl_vars['umRefresh']; ?>

	<!--"HEADER" -->	       
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath']).($this->_tpl_vars['TPL_HEADER']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php echo $this->_tpl_vars['umJS']; ?>
 

	<title><?php echo $this->_tpl_vars['umBoxName']; ?>
 - <?php echo $this->_tpl_vars['umNumUnread']; ?>
 New - <?php echo $this->_tpl_vars['umUserEmail']; ?>
 - <?php echo $this->_tpl_vars['umCompany']; ?>
</title>
</head>

<body class="bodypage messagelist" onLoad="startclock();">

	<form name="form1" action="process.php" method="post"> 
	<input type="hidden" name="aval_folders" value="">
	<?php echo $this->_tpl_vars['umForms']; ?>

	<?php echo $this->_tpl_vars['umSpamForm']; ?>

	<!--"start outer table" -->
	
	<table class="tablecollapsed" cellpadding="0" height="99%">

	<!--"Action form" -->
	
	<!--"BANNER" -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath']).($this->_tpl_vars['TPL_BANNER']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<!--"TOOLBAR" --> 		       
	<?php $this->assign('umTLB_HELP', 2); ?>
	<?php $this->assign('umTLB_LOGOFF', 1); ?>
	<?php $this->assign('umTLB_FOLDERS', 1); ?>
	<?php $this->assign('umTLB_REFRESH', 1); ?>
	<?php $this->assign('umTLB_COMPOSE', 1); ?>
	<?php $this->assign('umTLB_DEL_SELECT', 1); ?>
	<?php $this->assign('umTLB_SPAM_SELECT', 1); ?>
	<?php $this->assign('umTLB_MOVE', 1); ?>
	<?php $this->assign('umTLB_MARK_FLAG', 1); ?>
	<?php $this->assign('umTLB_NEW_ENTRY', 2); ?>
	
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath']).($this->_tpl_vars['TPL_TOOLBAR']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<!--"start inner content" -->
	<tr>
		<td valign="top">
		 
		<!--"start content table" -->
		<table class="innercontent" cellpadding="0" height="100%">
		<tr> 
			<!--"LEFT PANEL" --> 		       
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath']).($this->_tpl_vars['TPL_PANEL']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
			<!--"start center content" -->
			<td valign="top" class="content">

			<div class="pagetitle">
				<div class="title"><?php echo $this->_tpl_vars['umBoxName']; ?>
</div>
				<div class="image"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/inbox.gif" alt=""></div>
			</div>
			

			
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath']).($this->_tpl_vars['TPL_LIST']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			

			</td><!--"end center content" -->		
		</tr>
		</table><!--"end content table" -->	
			
		</td>		
	</tr><!--"end inner content" -->

	</table><!--"end outer content" -->
	
	</form><!--"close form" -->

</body>
</html>