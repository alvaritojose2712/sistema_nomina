<center><br>
				<!-- Tabs -->
				<table class="tab_table" cellpadding="0">
				<tr>
					<td height="30" valign="bottom">
					<table class="tablecollapsed" cellpadding="0">
					<tr>
						<td id="tab_home" class="tab_info_visible">
							<table class="tablecollapsed" cellpadding="0">
							<tr>
								<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
								<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchAddressTab('home')"><nobr>&nbsp;{#adr_home_title#}&nbsp;</nobr></td>
								<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
							</tr>
							</table>
						</td>
						
						<td id="tab_work" class="tab_info_hidden">
							<table class="tablecollapsed" cellpadding="0">
							<tr>
								<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
								<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchAddressTab('work')"><nobr>&nbsp;{#adr_work_title#}&nbsp;</nobr></td>
								<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
							</tr>
							</table>
						</td>
						
						<td id="tab_extra" class="tab_info_hidden">
							<table class="tablecollapsed" cellpadding="0">
							<tr>
								<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
								<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchAddressTab('extra')"><nobr>&nbsp;{#adr_extra_title#}&nbsp;</nobr></td>
								<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
							</tr>
							</table>
						</td>
						
						<td id="tab_picture" class="tab_info_hidden">
							<table class="tablecollapsed" cellpadding="0">
							<tr>
								<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
								<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gi');f" onclick="switchAddressTab('picture')"><nobr>&nbsp;{#adr_picture_title#}&nbsp;</nobr></td>
								<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
							</tr>
							</table>
						</td>

						<td id="tab_notes" class="tab_info_hidden">
							<table class="tablecollapsed" cellpadding="0">
							<tr>
								<td><img src="themes/{$umTPath}/images/tab_left.gif" alt=""></td>
								<td style="background-image: url('themes/{$umTPath}/images/tab_middle.gif');" onclick="switchAddressTab('notes')"><nobr>&nbsp;{#adr_notes_title#}&nbsp;</nobr></td>
								<td><img src="themes/{$umTPath}/images/tab_right.gif" alt=""></td>
							</tr>
							</table>
						</td>

						<td width='100%'>&nbsp;</td>
					</tr>
					</table>
					</td>
				</tr>
				</table>
	
				<table class="tab" cellpadding="15">
				<tr>
				<td width='100%' valign='top'>
			<!-- first tab - Home -->
				<div id="home" class="tab_visible">
					<fieldset>
						<legend>{#adr_home_title#}</legend>
						<table width='100%' cellpadding='2' cellspacing='0'>
						<tr>
							<td class="label" align="center" width="137"><p align="left">&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="label" align="center" width="137"><p align="left"><b>{#adr_name#}</b></td>
							<td><input type="text" name="name" value="{$umAddrName|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' align="center" width="137"><p align="left"><b>{#adr_email#}</b></td>
							<td><input type="text" name="email" id="email" value="{$umAddrEmail|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_cell#}</td>
							<td><input type="text" name="cell" value="{$umAddrCell|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_phone#}</td>
							<td><input type="text" name="phone" value="{$umAddrPhone|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_street#}</td>
							<td><input type="text" name="street" value="{$umAddrStreet|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_apt#}</td>
							<td><input type="text" name="apt" value="{$umAddrApt|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_city#}</td>
							<td><input type="text" name="city" value="{$umAddrCity|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_state#}</td>
							<td><input type="text" name="state" value="{$umAddrState|escape:'html'}" class="textbox" maxlength="2"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_zip#}</td>
							<td><input type="text" name="zip" value="{$umAddrZip|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_country#}<br>&nbsp;</td>
							<td><input type="text" name="country" value="{$umAddrCountry|escape:'html'}" class="textbox"><br>&nbsp;</td>
						</tr>
						</table>
					</fieldset>
				</div>
						
			<!-- second tab - Work -->
				<div id="work" class="tab_hidden">
					<fieldset>
						<legend>{#adr_work_title#}</legend>
						<table width='100%' cellpadding='2' cellspacing='0'>
						<tr>
							<td class="label" align="center" width="137"><p align="left">&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="label" align="center" width="137"><p align="left">{#adr_work#}</td>
							<td><input type="text" name="work" value="{$umAddrWork|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' align="center" width="137"><p align="left">{#adr_wemail#}</td>
							<td><input type="text" name="wemail" value="{$umAddrWemail|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' align="center" width="137"><p align="left">{#adr_wphone#}</td>
							<td><input type="text" name="wphone" value="{$umAddrWphone|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' align="center" width="137"><p align="left">{#adr_wfax#}</td>
							<td><input type="text" name="wfax" value="{$umAddrWfax|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' align="center" width="137"><p align="left">{#adr_wstreet#}</td>
							<td><input type="text" name="wstreet" value="{$umAddrWstreet|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' align="center" width="137"><p align="left">{#adr_wcity#}</td>
							<td><input type="text" name="wcity" value="{$umAddrWcity|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' align="center" width="137"><p align="left">{#adr_wstate#}</td>
							<td><input type="text" name="wstate" value="{$umAddrWstate|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' align="center" width="137"><p align="left">{#adr_wzip#}<br>&nbsp;</td>
							<td><input type="text" name="wzip" value="{$umAddrWzip|escape:'html'}" class="textbox"><br>&nbsp;</td>
						</tr>
						</table>
					</fieldset>
				</div>					

			<!-- third tab - Extra -->
				<div id="extra" class="tab_hidden">
					<fieldset>
						<legend>{#adr_extra_title#}</legend>
						<table width='100%' cellpadding='2' cellspacing='0'>
						<tr>
							<td class="label" align="center" width="137"><p align="left">&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="label" align="left" width="137">{#adr_aemail#}</td>
							<td><input type="text" name="aemail" value="{$umAddrAemail|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class="label" align="center" width="137"><p align="left">{#adr_bday#}</td>
							<td><input type="text" name="bday" value="{$umAddrBday|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' align="center" width="137"><p align="left">{#adr_anniv#}</td>
							<td><input type="text" name="anniv" value="{$umAddrAnniv|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_aim#}</td>
							<td><input type="text" name="aim" value="{$umAddrAim|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_icq#}</td>
							<td><input type="text" name="icq" value="{$umAddrIcq|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_msn#}</td>
							<td><input type="text" name="msn" value="{$umAddrMsn|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_yahoo#}</td>
							<td><input type="text" name="yahoo" value="{$umAddrYahoo|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_google#}</td>
							<td><input type="text" name="google" value="{$umAddrGoogle|escape:'html'}" class="textbox"></td>
						</tr>
						<tr>
							<td class='label' width="137">{#adr_website#}<br>&nbsp;</td>
							<td><input type="text" name="website" value="{$umAddrWebsite|escape:'html'}" class="textbox"><br>&nbsp;</td>
						</tr>
						</table>
					</fieldset>
				</div>
						
			<!-- fourth tab - Picture -->					
				<div id="picture" class="tab_hidden">
					<fieldset>
						<legend>{#adr_picture_title#}</legend>
						<table width='100%' cellpadding='2' cellspacing='0'>
						<tr>
							<td width="137">&nbsp;</td>
							<td width="137">&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="label" align="left">{#adr_picturename#}</td>
							<td colspan="2"><input type="text" name="picturename" value="{$umAddrPicturename|escape:'html'}" class="textbox"></td>
						</tr>
 						<tr style="display: none;">
							<td class="label" align="left" >{#adr_picturepath#}</td>
							<td colspan="2"><input type="text" readonly name="picturepath" value="{$umAddrPicturepath|escape:'html'}" class="textbox"/></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td class="label" align="left" colspan="2"><span style="vertical-align: text-bottom"><i>{#adr_picturesize#}</i></span></td>
						</tr>
						<tr>
							<td align="center">{if $umAddrID neq 'N'}
								<input class="button" type="button" value="{#adr_upload#}" onClick="Add_Photo({$umAddrID});"><br><br>
								<input type="button" value="{#up_deleteimage#}" class="button" onClick="javascript:remove_Photo();"><br>&nbsp;
								{else}
									<input class="button" type="button" value="{#adr_upload#}" onClick="Add_Photo({$umAddrID});"><br><br>
								<input type="button" value="{#up_deleteimage#}" class="button" onClick="javascript:remove_Photo();"><br>&nbsp;
								{/if}
							</td>
							<td>&nbsp;</td>
							<td align="right">
								<img id="id_photo" src="{$umAddrPicturepath|escape:'html'}" border="0" onerror="this.src='themes/{$umTPath}/images/example.gif';" alt=""></td>							
						</tr>
						</table>
					</fieldset>
				</div>	
						
			<!-- fifth tab - Notes -->				
				<div id="notes" class="tab_hidden">
					<fieldset>
						<legend>{#adr_notes_title#}</legend>
						<table width='100%' cellpadding='2' cellspacing='0'>
						<tr>
							<td colspan="2">
								<textarea class="textarea" name="textnotes" id="htmleditor" rows="10" cols="80"  style="width: 100%; height: 235px;">{$umAddrNotes|escape:'html'}</textarea>
							</td>
						</tr>
						</table>
					</fieldset>
				</div>

			<!-- Save or Return -->
				<table width="319">
				<tr>
					<td><input type="submit" value="{#adr_save#}" class="button">&nbsp;
					<input type="button" onClick="location = '{$umGoBack}'" value="{#adr_back#}" class="button"></td>
				</tr>
				</table>
			
				</td>
			</tr>
			</table>
			</center>
			