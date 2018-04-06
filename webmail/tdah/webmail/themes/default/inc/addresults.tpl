			{if $umOpt eq 1}{#addr_saved#}<br> - <b>{$umDuplicateAddr}</b> -
			{elseif $umOpt eq 2}{#addr_added#}<br> - <b>{$umDuplicateAddr}</b> -
			{elseif $umOpt eq 3}{#addr_deleted#}<br> - <b>{$umDuplicateAddr}</b> -
			{elseif $umOpt eq 4}<font color="#FF0000">{#adr_alreadyexists#}</font><br> - <b>{$umDuplicateAddr}</b> -
			{elseif $umOpt eq 5}<font color="#FF0000">{#adr_nameneeded#}</font>
			{/if}
			{if $umOpt gt 3}
				<br><br>
				<input type="button" onClick="javascript:history.go(-1)" value="{#adr_back#}" class="button">
			{else}
				<br><br>
				<input type="button" onClick="javascript:location = '{$umGoBack}'" value="{#adr_back#}" class="button">
			{/if}