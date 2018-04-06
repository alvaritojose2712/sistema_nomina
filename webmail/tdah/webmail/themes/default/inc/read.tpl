<table class="tablecollapsed" height="100%">
		<tr height="10%">
			<td class="background">
			
			<!-- Message header -->
			<table class="tablecollapsed" cellpadding="5">
			<tr>
				<td><b>{#from_hea#}</b></td>
				<td class="msg_links">
					{section name=i loop=$umFromList}
						<a href="{$umFromList[i].link}" title="{$umFromList[i].title|escape:'html'}">
						{$umFromList[i].name|truncate:70:#no_sender_text#|escape:'html'}</a>
					{/section}
				</td>
				<td><b>{#to_hea#}</b></td>
				<td class="msg_links">
				{section name=i loop=$umTOList}
					{if !$smarty.section.i.first} ; {/if}
					<a href="{$umTOList[i].link}" title="{$umTOList[i].title|escape:'html'}">
					{$umTOList[i].name|truncate:30:escape:'html'}</a>
					{assign var="firstto" value="no"}
				{sectionelse}
					&nbsp;{#no_recipient_text#}
				{/section}
				</td>
			</tr>

				<tr>
			{if $umHaveCC}
					<td><b>{#cc_hea#}</b></td>
					<td class="msg_links">
					{section name=i loop=$umTOList}
						{if !$smarty.section.i.first} ; {/if}
						<a href="{$umTOList[i].link}" title="{$umTOList[i].title|escape:'html'}">
						{$umTOList[i].name|truncate:30:escape:'html'}</a>
						{assign var="firstto" value="no"}
					{sectionelse}
						&nbsp;{#no_recipient_text#}
					{/section}
					</td>
			{else}
					<td>&nbsp;</td>
					<td>&nbsp;</td>
			{/if}
					<td><b>{#msg_folder#}</b></td>
					<td>{$umFolder}</td>
				</tr>
			<tr>
				<td width="65"><b>{#subject_hea#}</b></td>
				<td>{$umSubject|default:#no_subject_text#|truncate:70:"...":true|escape:'html'}</td>
				<td width="65"><b>{#date_hea#}</b></td>
				<td width="26%"class="menu">{$umDate|date_format:#date_format#}</td>
			</tr>
			</table>
		 
		 			{if $umHaveAttachments}
			<div class="dhtmlgoodies_question">
				<img img src="themes/{$umTPath}/images/toolbar/plus.gif"id="attachimg">&nbsp;&nbsp;<b>{#attach_hea#} ({$umNumAttach})</b>
			</div>
			<div class="dhtmlgoodies_answer"><div>
			
		  <table  width="100%" border="0" cellspacing="0" cellpadding="3">
   			
		  <table id="attach" class="tablehide" width="100%" border="0" cellspacing="0" cellpadding="3"> 
			{section name=i loop=$umAttachList}
			
      <tr>
        <td class="msg_links" width="50%">
					&nbsp; {$umAttachList[i].downlink}<img src="themes/{$umTPath}/images/download.gif" border="0" alt=""></a>
					&nbsp; &nbsp;{$umAttachList[i].normlink}{$umAttachList[i].name|truncate:50:"...":true|escape:'html'}</a>
				</td>
				        
				<td width="25%">{$umAttachList[i].size} {$umAttachList[i].unit}{#bytes#}</td>
				<td width="25%">{$umAttachList[i].type}</td>
      </tr>

      {/section}
      </table>
			</div></div>

			{/if}
		 
			</td>
		</tr>
		<!-- Body -->
		<tr>
			<td>
			<table height="100%" class="text_body upper_line">
			<tr>
				<td>{$umMessageBody}</td>
			</tr>
			</table>
		</tr>
		</table>