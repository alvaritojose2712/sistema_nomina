<?php /* Smarty version 2.6.24, created on 2011-03-26 15:20:52
         compiled from default/inc/menu.tpl */ ?>

	<!--"start menu" --> 
					<table class="tablecollapsed menus" cellpadding="0">
					<tr>   
						<td>
							<!-- Title -->
					
	<table class="tablecollapsed">
						<tr >
							<td ></td>
						</tr>
						</table>



						<!-- Title -->
						<table class="tablecollapsed">
						<tr height="19">
							<td class="lmbar title" height="19">&nbsp;<?php echo $this->_config[0]['vars']['menu_mnu']; ?>
</td>
						</tr>
						</table>

						<!-- Menu -->
						<table class="tablecollapsed" style="white-space: nowrap;">
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:goinbox()">&nbsp;
									<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/menu/inbox.gif" alt="" border="0" align="middle">
									&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['messages_mnu']; ?>
</a></li>
							</ul>
							</td>      
						</tr>	
						  
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:newmsg()">&nbsp;
								<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/menu/write.gif" alt="" border="0" align="middle">
								&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['compose_mnu']; ?>
</a></li>
							</ul>
							</td>      
						</tr>	
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:calendar()">&nbsp;
								<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/menu/calendar.gif" alt="" border="0" align="middle">
								&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['calendar_mnu']; ?>
</a></li>
							</ul>
							</td>      
						</tr>
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:addresses()">&nbsp;
								<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/menu/contacts.gif" alt="" border="0" align="middle">
								&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['address_mnu']; ?>
&nbsp;<?php if ($this->_tpl_vars['umAddrEntry'] != 0): ?>[<?php echo $this->_tpl_vars['umAddrEntry']; ?>
]<?php endif; ?></a></li>
							</ul>
							</td>      
						</tr>	
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:folderlist()">&nbsp;
								<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/menu/folder.gif" alt="" border="0" align="middle">
								&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['folders_mnu']; ?>
</a></li>
							</ul>
							</td>      
						</tr>	
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:search()">&nbsp;
								<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/menu/search.gif" alt="" border="0" align="middle">
								&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['search_mnu']; ?>
</a></li>
							</ul>
							</td>      
						</tr>		
						<tr height="27" >
							<td class="bar" height="27" width="100%">
							<ul class="menu">
								<li><a href="javascript:prefs()">&nbsp;
								<img src="themes/<?php echo $this->_tpl_vars['umTPath']; ?>
/images/menu/options.gif" alt="" border="0" align="middle">
								&nbsp;&nbsp;<?php echo $this->_config[0]['vars']['prefs_mnu']; ?>
</a></li>
							</ul>
							</td>
						</tr>      
						</table>
						
						</td>
					</tr>
					</table>
	<!--"end menu" -->