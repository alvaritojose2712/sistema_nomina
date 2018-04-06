<?php /* Smarty version 2.6.24, created on 2011-03-26 15:20:42
         compiled from default/login.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'default/login.htm', 27, false),)), $this); ?>

<?php echo smarty_function_config_load(array('file' => $this->_tpl_vars['umLanguageFile'],'section' => 'Login'), $this);?>

<?php echo $this->_tpl_vars['umsyslib']; ?>

<?php echo $this->_tpl_vars['umDocType']; ?>

<html>
<head>
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

<body class="login_body" OnLoad="document.forms[0].elements[0].focus();">
	
	<form name="form1" action="process.php?lid=<?php echo $this->_tpl_vars['umLid']; ?>
&tid=<?php echo $this->_tpl_vars['umTid']; ?>
" method="post">
	<table height="100%" class="tablecollapsed">
	<tr>
		<td width="100%" height="100%">
		<div align="center">
		
			<table border="0" cellpadding="0" cellspacing="0" >
			<tr>
				<td>
				<table class="container">
				<tr>
					<td>
							<table class="box">
							<tr>
								<td colspan="2" class="title"><?php echo $this->_tpl_vars['umCompany']; ?>
</td>
							</tr>
								<?php if ($this->_tpl_vars['umServerType'] != "ONE-FOR-EACH"): ?>
									<tr>
										<td width="40%" align="right" nowrap><b><?php echo $this->_config[0]['vars']['lng_user_email']; ?>
:</b>&nbsp;</td>
										<td><input type=text size=5 name="f_email" value="<?php echo $this->_tpl_vars['umEmail']; ?>
" class="textbox"></td>
									</tr>
								<?php else: ?>
									<tr>
										<td width="40%" align="right" valign="middle" nowrap>
										<b><?php echo $this->_config[0]['vars']['lng_user_name']; ?>
:</b>&nbsp;</td>
										<td><input type=text size=5 name="f_user" value="<?php echo $this->_tpl_vars['umUser']; ?>
" class="textbox">
										<?php if ($this->_tpl_vars['umAvailableServers'] != 0): ?>
											<tr><td></td><td><font class="server"><?php echo $this->_tpl_vars['umServer']; ?>
</font></td></tr>
										<?php endif; ?>
										</td>
									</tr>
								<?php endif; ?>
								<tr>
									<td align="right" width="40%"><b><?php echo $this->_config[0]['vars']['lng_user_pwd']; ?>
:</b>&nbsp;</td>
									<td><input type=password size=5 name="f_pass" value="" class="textbox"></td>
								</tr>
								<?php if ($this->_tpl_vars['umAllowSelectLanguage']): ?>
									<tr>
										<td align="right"><b><?php echo $this->_config[0]['vars']['lng_language']; ?>
:</b>&nbsp;</td>
										<td><?php echo $this->_tpl_vars['umLanguages']; ?>
</td>
									</tr>
								<?php endif; ?>
								
								<?php if ($this->_tpl_vars['umAllowSelectTheme']): ?>
									<tr>
										<td align="right"><b><?php echo $this->_config[0]['vars']['lng_theme']; ?>
:</b>&nbsp;</td>
										<td><?php echo $this->_tpl_vars['umThemes']; ?>
</td>
									</tr>
									
								<?php endif; ?>
							<tr>
								<td>&nbsp;</td><td>
								<input type="submit" name="submit" value="<?php echo $this->_config[0]['vars']['lng_login_btn']; ?>
"></td>
							</tr>
							</table>
					</td>
				<tr>
					<td class="info"><?php echo $this->_config[0]['vars']['sw_name']; ?>
 v<?php echo $this->_tpl_vars['umVersion']; ?>
</td>
				</tr>
				</table><!--"end container table"-->
				</td>
			</tr>
			</table>
		</div>
		</td>  
	</tr>  
	</table>
	</form>
	
</body>
</html>