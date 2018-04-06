<?php /* Smarty version 2.6.24, created on 2011-03-26 15:20:52
         compiled from default/preferences.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'default/preferences.htm', 27, false),)), $this); ?>

<?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['umLanguageFile'],'section' => 'Preferences'), $this);?>
 
<?php echo $this->_tpl_vars['umDocType']; ?>

<html>
<head>
	<?php echo $this->_tpl_vars['pageMetas']; ?>

	<!--"HEADER" --> 		       
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath'])."/inc/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php echo $this->_tpl_vars['umJS']; ?>

	<?php if ($this->_tpl_vars['umAdvancedEditor'] == 2): ?>
	<script language="javascript" type="text/javascript">
		 WYSIWYG.attach('htmleditor',full);
	</script>
	<?php endif; ?>
	<title><?php echo $this->_tpl_vars['umUserEmail']; ?>
 - <?php echo $this->_tpl_vars['umCompany']; ?>
</title>
</head>

<body class="bodypage preferences"onLoad="startclock();calculate_time_zone();" > 

	<!--"start outer table" -->
	<table class="tablecollapsed" cellpadding="0" height="99%">

	<!--"BANNER" -->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath'])."/inc/banner.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<!--"TOOLBAR" --> 		       
	<?php $this->assign('umTLB_HELP', 2); ?>
	<?php $this->assign('umTLB_LOGOFF', 1); ?>
	<?php $this->assign('umTLB_FOLDERS', 1); ?>
	<?php $this->assign('umTLB_REFRESH', 1); ?>
	<?php $this->assign('umTLB_COMPOSE', 1); ?>
	<?php $this->assign('umTLB_NEW_ENTRY', 2); ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath'])."/inc/toolbar.tpl", 'smarty_include_vars' => array()));
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
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath'])."/inc/panel.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
			<!--"start center content" -->
			<td valign="top" class="content">
			
			<div class="pagetitle">
				<div class="title"><?php echo $this->_config[0]['vars']['prf_title']; ?>
</div>
				<div class="image"><img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/prefs.gif" alt=""></div>
			</div>
			
			<!-- Content title -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['umTPath'])."/inc/prefs.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				
			</td><!--"end center content" -->		
		</tr>
		</table><!--"end content table" -->	
			
		</td>		
	</tr><!--"end inner content" -->
	</table><!--"end outer content" -->

</body>
</html>