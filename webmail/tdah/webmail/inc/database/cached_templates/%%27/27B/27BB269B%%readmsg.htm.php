<?php /* Smarty version 2.6.24, created on 2011-03-26 15:27:12
         compiled from default/readmsg.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'default/readmsg.htm', 27, false),)), $this); ?>

<?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['umLanguageFile'],'section' => 'Readmsg'), $this);?>

<?php echo $this->_tpl_vars['umsyslib']; ?>
 
<?php echo $this->_tpl_vars['umDocType']; ?>

<html>
<head>

	<?php echo $this->_tpl_vars['pageMetas']; ?>

	<!--"HEADER" --> 		       
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath']).($this->_tpl_vars['TPL_HEADER']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php echo $this->_tpl_vars['umJS']; ?>
 
	<title><?php echo $this->_tpl_vars['umUserEmail']; ?>
 - <?php echo $this->_tpl_vars['umCompany']; ?>
</title>
</head>

<body class="bodypage readmsg" onLoad="startclock();initShowHideDivs();"> 

	<!--"Insert for form reply" -->
	<?php echo $this->_tpl_vars['umReplyForm']; ?>

	
	<!--"Action form" -->
	<form name="form1" action="process.php" method="POST">
	<input type="hidden" name="aval_folders" value="">
	<?php echo $this->_tpl_vars['umForms']; ?>

	<?php echo $this->_tpl_vars['umDeleteForm']; ?>


	<!--"start outer table" -->
	<table class="tablecollapsed" cellpadding="0" height="99%">

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
	<?php $this->assign('umTLB_DELETE', 1); ?>
	<?php $this->assign('umTLB_SPAM', 1); ?>
	<?php $this->assign('umTLB_MOVE', 1); ?>
	<?php $this->assign('umTLB_ACTION', 1); ?>
	<?php $this->assign('umTLB_UP_DOWN', 2); ?>
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

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath']).($this->_tpl_vars['TPL_READ']), 'smarty_include_vars' => array()));
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