{if $umSendIt eq 1}
					<input type="hidden" name="opt" value='{$umOpt}'>
					<input type="hidden" name="lines" value='{$umLines}'>
					<input type="hidden" name="body" value='{$umBody}'>
					<input type="hidden" name="to" value='{$umTo}'>
					<input type="hidden" name="cc" value='{$umCc}'>
					<input type="hidden" name="bcc" value='{$umBcc}'>
					<input type="hidden" name="subject" value='{$umSubject}'>
					<input type="hidden" name="txtarea" value='{$umTextEditor}'>
					<input type="hidden" name="priority" value='{$umPriority}'>
					<input type="hidden" name="requireReceipt" value='{$umRReceipt}'>
					<input type="hidden" name="haveSig" value='{$umHaveSignature}'>
					<input type="hidden" name="addSignature" value='{$umAddSignature}'>
					<input type="hidden" name="signature" value='{$umSig}'>
					<input type="hidden" name="folder" value='{$umFolder}'>
					<input type="hidden" name="textmode" value='{$umTextMode}'>
					<input type="hidden" name="is_html" value='{$umIsHTML}'>
					<input type="hidden" name="attachlist" value='{$umAttachList}'>
					<input type="hidden" name="tipo" value='{$umTipo}'>
					<input type="hidden" name="send_it" value="1">
					{#msg_sending#}
					<p><img src="themes/{$umTPath}/images/sending.gif" alt="" border="0" align="middle"></p>
					<div class="sendbutton">
						<input type="button" onClick="javascript:document.composeForm.submit();" value="{#bt_resend#}" class="button">
						<input type="button" onClick="javascript:history.go(-1);" value="{#nav_back#}" class="button"><br>
						<br>As long as there is no wait to interrupt the transmission
						<br>These buttons must only be visible for debug!
						<br>Please hide them in the common.css (class:sendbutton)
					</div>
			{else}
				{if $umMailSent}<p></p>{#result_success#}</p>
					<input type="button" onClick="javascript:window.location='messages.php?sid={$umSid}&tid={$umTid}&lid={$umLid}';" value="{#bt_continue#}" class="button">
				{else}
					<p>{#result_error#}</p>
					<p><font color="#FF0000">{$umErrorMessage}</font></p>
					<input type="button" onClick="javascript:history.go(-2);" value="{#nav_back#}" class="button">
				{/if}
			{/if}