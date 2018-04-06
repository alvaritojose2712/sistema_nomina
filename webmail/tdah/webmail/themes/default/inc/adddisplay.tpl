<center>
			<!-- Tabs -->
			<table width='620px' cellpadding='0' cellspacing='0' >
			<tr>
				<td height="30" valign="bottom">
					<table width='100%' cellpadding='0' cellspacing='0'>
					<tr>
						<td id="tab_home" class="tab_info_visible">
							<table cellpadding="0" cellspacing="0">
							<tr>
								<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
								<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchAddressTab('home')">
									<nobr>&nbsp;{#adr_home_title#}&nbsp;</nobr>
								</td>
								<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
							</tr>
							</table>
						</td>
	
						<td id="tab_work" class="tab_info_hidden">
							<table cellpadding="0" cellspacing="0">
							<tr>
								<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
								<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchAddressTab('work')">
									<nobr>&nbsp;{#adr_work_title#}&nbsp;</nobr>
								</td>
								<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
							</tr>
							</table>
						</td>
	
						<td id="tab_extra" class="tab_info_hidden">
							<table cellpadding="0" cellspacing="0">
							<tr>
								<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
								<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchAddressTab('extra')">
									<nobr>&nbsp;{#adr_extra_title#}&nbsp;</nobr>
								</td>
								<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
							</tr>
							</table>
						</td>
	
						<td id="tab_picture" class="tab_info_hidden">
							<table cellpadding="0" cellspacing="0" >
							<tr>
								<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
								<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchAddressTab('picture')">
									<nobr>&nbsp;{#adr_picture_title#}&nbsp</nobr>
									</td>
								<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
							</tr>
							</table>
						</td>
	
						<td id="tab_notes" class="tab_info_hidden">
							<table cellpadding="0" cellspacing="0" >
							<tr>
								<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
								<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchAddressTab('notes')">
									<nobr>&nbsp;{#adr_notes_title#}&nbsp;</nobr>
								</td>
								<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
							</tr>
							</table>
						</td>
						<td class="tab_blank" width='100%'>&nbsp;</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>

			<table width='620px'cellpadding='15' cellspacing='0' class="tab" height="200" style="border: solid 1px #808080;">
			<tr>
				<td width='100%' valign='top'>

			<!-- first tab - General -->
				<div id="home" class="tab_visible">
					
					<fieldset><legend><b>{#adr_home_title#}</b></legend>
						<table width='100%' cellpadding='2' cellspacing='0'>
						<tr>
							<td class="label" align="center" width="31%"><p align="left">&nbsp;</td>
							<td align="left" width="68%" colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td width="31%" align="right"><b>{#adr_name#} </b>:</td>
							<td>&nbsp;{$umAddrName|escape:"html"}</td>
							<td rowspan="7" align="right"><img src="{$umAddrPicturepath|escape:"html"}" border="0") onerror="this.src='themes/{$umTPath}/images/example.gif';" alt="">
						</tr>
						<tr>
							<td class='label' align="center" width="31%" height="25">
							<p align="right"><b>{#adr_email#} </b>:</td>
							<td align="left" height="25">&nbsp;<a href="newmsg.php?pag=1&folder=inbox&tid={$umTid}&lid={$umLid}&nameto={$umAddrName}&mailto={$umAddrEmail}">{$umAddrEmail|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="31%"><p align="right">{#adr_cell#}:</td>
							<td>&nbsp;{$umAddrCell|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="31%"><p align="right">{#adr_phone#}:</td>
							<td width="41%">&nbsp;{$umAddrPhone|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="31%"><p align="right">{#adr_street#}:</td>
							<td>&nbsp;<a href="http://www.mapquest.com/maps/map.adp?address={$umAddrStreet}&city={$umAddrCity}&state={$umAddrState}&zipcode={$umAddrZip}"target="_blank">{$umAddrStreet|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="31%"><p align="right">{#adr_city#}:</td>
							<td>&nbsp;{$umAddrCity|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="31%"><p align="right">{#adr_state#}:</td>
							<td>&nbsp;{$umAddrState|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="31%"><p align="right">{#adr_zip#}:</td>
							<td colspan="2">&nbsp;{$umAddrZip|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="31%">&nbsp;</td>
							<td colspan="2">&nbsp;</td>
						</tr>
						</table>
					</fieldset>

				</div>
					
			<!-- Second tab - Prof addresses -->
				<div id="work" class="tab_hidden">
					<fieldset><legend><b>{#adr_work_title#}</b></legend>
						<table width='100%' cellpadding='2' cellspacing='0'>
						<tr>
							<td class="label" align="center" width="154"><p align="left">&nbsp;</td>
							<td align="left">&nbsp;</td>
						</tr>
						<tr>
							<td class="label" align="center" width="154"><p align="right">{#adr_work#}:</td>
							<td align="left">&nbsp;{$umAddrWork|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' align="center" width="154"><p align="right">{#adr_wemail#}:</td>
							<td align="left">&nbsp;<a href="newmsg.php?pag=1&folder=inbox&tid={$umTid}&lid={$umLid}&nameto={$umAddrName}&mailto={$umAddrWemail}">{$umAddrWemail|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="154"><p align="right">{#adr_wphone#}:</td>
							<td>&nbsp;{$umAddrWphone|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="154"><p align="right">{#adr_wfax#}:</td>
							<td>&nbsp;{$umAddrWfax|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="154"><p align="right">{#adr_wstreet#}:</td>
							<td>&nbsp;{$umAddrWstreet|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="154"><p align="right">{#adr_wcity#}:</td>
							<td>&nbsp;{$umAddrWcity|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="154"><p align="right">{#adr_wstate#}:</td>
							<td>&nbsp;{$umAddrWstate|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="154"><p align="right">{#adr_wzip#}:</td>
							<td>&nbsp;{$umAddrWzip|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="154">&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						</table>
					</fieldset>
				</div>					

			<!-- third tab - Other addresses -->
				<div id="extra" class="tab_hidden">
					<fieldset><legend><b>{#adr_extra_title#}</b></legend>
						<table width='100%' cellpadding='2' cellspacing='0'>
						<tr>
							<td class="label" align="center" width="154"><p align="left">&nbsp;</td>
							<td align="left">&nbsp;</td>
						</tr>
						<tr>
							<td class="label" align="left" width="154"><p align="right">{#adr_aemail#}:</td>
							<td align="left">&nbsp;<a href="newmsg.php?pag=1&folder=inbox&tid={$umTid}&lid={$umLid}&nameto={$umAddrName}&mailto={$umAddrAemail}">{$umAddrAemail|escape:"html"}</td>
						</tr>
						<tr>
							<td class="label" align="center" width="154"><p align="right">{#adr_bday#}:</td>
							<td align="left">&nbsp;{$umAddrBday|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' align="center" width="154"><p align="right">{#adr_anniv#}:</td>
							<td align="left">&nbsp;{$umAddrAnniv|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="154"><p align="right">{#adr_aim#}:</td>
							<td>&nbsp;{$umAddrAim|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="154"><p align="right">{#adr_icq#}:</td>
							<td>&nbsp;{$umAddrIcq|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="154"><p align="right">{#adr_msn#}:</td>
							<td>&nbsp;{$umAddrMsn|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="154"><p align="right">{#adr_yahoo#}:</td>
							<td>&nbsp;{$umAddrYahoo|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="154"><p align="right">{#adr_google#}:</td>
							<td>&nbsp;{$umAddrGoogle|escape:"html"}</td>
						</tr>
						<tr>
							<td class='label' width="154"><p align="right">{#adr_website#}:</td>
							<td>&nbsp;<a href="http://{$umAddrWebsite|escape:"html"}" target="_blank">{$umAddrWebsite|escape:"html"}</a></td>
						</tr>
						<tr>
							<td class='label' width="154">&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						</table>
					</fieldset>
				</div>

			<!-- Fourth tab - Photo -->
				<div id="picture" class="tab_hidden">
					<fieldset><legend><b>{#adr_picture_title#}</b></legend>
						<table width='100%' cellpadding='2' cellspacing='0'>
						<tr>
							<td width="154">&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="label" align="left" valign="bottom" width="154">{#adr_picturename#}</td>
							<td align="center">
								<img src="{$umAddrPicturepath|escape:"html"}" border="0") onerror="this.src='themes/{$umTPath}/images/example.gif';" alt=""><br><br>
								<b>{$umAddrPicturename|escape:"html"}<b>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						</table>
					</fieldset>
				</div>
					
			<!-- Fifth tab - Notes -->
				<div id="notes" class="tab_hidden">
					<fieldset><legend><b>{#adr_notes_title#}</b></legend>
						<table width='100%' cellpadding='2' cellspacing='0'>
						<tr>
							<td class="label" align="left"colspan="2">{$umAddrNotes}</td>
						</tr>
						<tr>
							<td class='label' width="154">&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						</table>
					</fieldset>
				</div>					

				<table width="319">
				<tr>
					<td>
						<input type="button" onClick="location = 'addressbook.php?lid={$umLid}&tid={$umTid}&opt=edit&id={$umAddrID}'" value="{#adr_edit#}" class="button">&nbsp; 
						<input type="button" onClick="location = '{$umGoBack}'" value="{#adr_back#}" class="button">
					</td>
				</tr>
				</table>
				<p>&nbsp;</p>
				</td>
			</tr>
			</table>
			<!-- End tabs-->
			</center>
