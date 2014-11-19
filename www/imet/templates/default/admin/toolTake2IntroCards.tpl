{if $singleCard}

	<h1>Take 2 - Single card</h1>
		
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<p><strong>Card class:</strong></p>
		{$form.fields.card.field}<br />
		{if $form.fields.card.errMsg}<p class="adminError">{$form.fields.card.errMsg}</p>{/if}<br />
		
		<p><strong>Info:</strong></p>
		{$form.fields.info.field}<br />
		{if $form.fields.info.errMsg}<p class="adminError">{$form.fields.info.errMsg}</p>{/if}<br />
		
		<p><strong>Comment:</strong></p>
		{$form.fields.comment.field}<br />
		{if $form.fields.comment.errMsg}<p class="adminError">{$form.fields.comment.errMsg}</p>{/if}<br />
		
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	{$form.close}

{else}

	<h1>Take 2 - Intro Cards</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Name</th>
			<th class="even">Info</th>
			<th class="odd">Session</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$cards item=item name=coupons}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$item.href}');">
				<td class="odd">{$item.name}</td>
				<td class="even">{$item.info}</td>
				<td class="odd">{$item.session}</td>
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