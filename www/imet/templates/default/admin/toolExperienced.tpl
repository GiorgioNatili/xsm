{* VIEW and EDIT *}

{if !$addNew}

	{if $edit}
	
		<h1>What Have I Experienced - edit</h1>
		
		{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
		
		<div class="bttnCont">
			<a href="{$backHref}">Back</a>
			<div class="clear"></div>
		</div>
		
		{$form.open}
		<fieldset>
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>Question:</strong></p>
				{$form.fields.question.field}<br />
				{if $form.fields.question.errMsg}<p class="adminError">{$form.fields.question.errMsg}</p>{/if}
			</div>
			<div class="clear"></div><br />
			
			<p class="adminBackToList">
				{if $edit}<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />{/if}
				<input type="submit" name="submit" value="save" class="save" />
			</p>
		</fieldset>
		{$form.close}
		
	{else}
	
		<h1>What Have I Experienced</h1>
		
		{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
		
		{*
		<div class="bttnCont">
			<a href="{$newHref}">Add new</a>
			<div class="clear"></div>
		</div>
		*}
		
		<table cellpadding="0" cellspacing="0" class="table">
		<thead>
			<tr>
				<th class="odd">ID</th>
				<th class="even">Question</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$cards item=card name=cardsList}
				<tr class="{cycle values='odd,even'}" onclick="redirect('{$card.href}');">
					<td class="odd">{$card.id}</td>
					<td class="even">{$card.question}</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="2">{$lang.no_cards}</td>
				</tr>
			{/foreach}
		</tbody>
		</table>
		
		{*
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
		*}
	
	{/if}

{* ADDING NEW ROWS *}	
{elseif $addNew}

	<h1>Comments - new</h1>
		
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
		<fieldset>
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>Tool:</strong></p>
				{$form.fields.tool.field}<br />
				{if $form.fields.tool.errMsg}<p class="adminError">{$form.fields.tool.errMsg}</p>{/if}
			</div>
			<div class="clear"></div><br />
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>Name:</strong></p>
				{$form.fields.name.field}<br />
				{if $form.fields.name.errMsg}<p class="adminError">{$form.fields.name.errMsg}</p>{/if}
			</div>
			<div class="clear"></div><br />
			<div style="float:left;padding:0 20px 0 0" id="label2">
				<p><strong>Value:</strong></p>
				{$form.fields.value.field}<br />
				{if $form.fields.value.errMsg}<p class="adminError">{$form.fields.value.errMsg}</p>{/if}
			</div>
			<div class="clear"></div><br />
			
			<p class="adminBackToList">
				<input type="submit" name="submit" value="save" class="save" />
			</p>
		</fieldset>
		{$form.close}
	
{/if}
