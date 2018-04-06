	{if $umOpt eq ''}
				<font color="#FF0000">{#fld_notcreated#}</font>
			{elseif $umOpt eq 1}
				{#fld_created#}
			{elseif $umOpt eq 2}
				{#fld_deleted#}
			{elseif $umOpt eq 3}
				<font color="#FF0000">{#fld_error#}</font>
			{elseif $umOpt eq 4}
				<font color="#FF0000">{#error_invalid_name#}</font>
			{/if}
			{if $umNbFilterDel gt 0}<br>{#fld_filter_delete#} {$umNbFilterDel}{/if}
