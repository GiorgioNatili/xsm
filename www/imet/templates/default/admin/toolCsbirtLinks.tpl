{* VIEW and EDIT *}

{if $edit}

	<h1>cSbirt Link - edit</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Link:</strong></p>
			{$form.fields.link.field}<br />
			{if $form.fields.link.errMsg}<p class="adminError">{$form.fields.link.errMsg}</p>{/if}
		</div>
		<div class="clear"></div><br />
		
		<p class="adminBackToList">
			{if $edit}<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />{/if}
			<input type="submit" name="submit" value="save" class="save" />
		</p>
	</fieldset>
	{$form.close}
	
{else}

	<h1>cSbirt Link</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Link</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$cards item=card name=cardsList}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$card.href}');">
				<td class="even">{$card.link}</td>
			</tr>
		{/foreach}
	</tbody>
	</table>
	
	<script type="text/javascript">
	{literal}
		$(document).ready(function(){
			$('.table .delete').click(function(){
				if(confirm("{/literal}{$lang.delete_confirm}{literal}"))
				{
					location.href=$(this).attr('rel');
				}
				return false;
			});
		});
	{/literal}
	</script>

{/if}
