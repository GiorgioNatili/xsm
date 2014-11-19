{if $form}

	<h1>Pros And Cons - single card</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}

	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<div style="float:left;padding:0 20px 0 0;">
			<p><strong>Label:</strong></p>
			{$form.fields.label.field}<br />
			{if $form.fields.label.errMsg}<p class="adminError">{$form.fields.label.errMsg}</p>{/if}
		</div>
		<div style="float:left;padding:0 20px 0 0;">
			<p><strong>Category:</strong></p>
			{$form.fields.category.field}<br />
			{if $form.fields.category.errMsg}<p class="adminError">{$form.fields.category.errMsg}</p>{/if}
		</div>
		<div style="float:left;">
			<p><strong>Stimulant:</strong></p>
			{$form.fields.stimulant.field}<br />
			{if $form.fields.stimulant.errMsg}<p class="adminError">{$form.fields.stimulant.errMsg}</p>{/if}
		</div>
		<div class="clear"></div>
		<br />
		
		<p class="adminBackToList">
			{if $edit}<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />{/if}
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	{$form.close}

{else}

	<h1>Pros And Cons - cards</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$newHref}">Add new</a>
		<div class="clear"></div>
	</div>
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Label</th>
			<th class="even">Category</th>
			<th class="odd">Stimulant</th>
			<th class="even"></th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$cards item=card name=cards}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$card.href}');">
				<td class="odd">{$card.label}</td>
				<td class="even">{$card.category}</td>
				<td class="odd">{$card.stimulant}</td>
				<td class="even" style="text-align:center;width:40px;"><a class="delete" rel="{$card.delHref}" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
			</tr>
		{foreachelse}
			<tr>
				<td colspan="3">{$lang.no_cards}</td>
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