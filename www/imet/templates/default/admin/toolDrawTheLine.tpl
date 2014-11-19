{if $singleQuestion}

	<h1>Draw the line - answers</h1>
		
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<p><strong>Question:</strong></p>
		{$form.fields.question.field}<br />
		{if $form.fields.question.errMsg}<p class="adminError">{$form.fields.question.errMsg}</p>{/if}<br />
		
		<p><strong>Doctor feedback:</strong></p>
		{$form.fields.doctor.field}<br />
		{if $form.fields.doctor.errMsg}<p class="adminError">{$form.fields.doctor.errMsg}</p>{/if}<br />
		
		<p><strong>Digits:</strong></p>
		{$form.fields.digits.field}<br />
		{if $form.fields.digits.errMsg}<p class="adminError">{$form.fields.digits.errMsg}</p>{/if}<br />
		
		<div class="bttnCont">
			<a href="{$newHref}">Add new</a>
			<div class="clear"></div>
		</div>

		<table cellpadding="0" cellspacing="0" class="table">
		<thead>
			<tr>
				<th class="odd">Answer</th>
				<th class="even">Type</th>
				<th class="odd">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$answers item=item name=answers}
				<tr class="{cycle values='odd,even'}" onclick="redirect('{$item.href}');">
					<td class="odd">{$item.answer|strip_tags:false|truncate:50:"&hellip;"}</td>
					<td class="even">{$item.type}</td>
					<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="{$item.delHref}" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="4">{$lang.no_types}</td>
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
		
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	{$form.close}
	
{elseif $singleAnswer}

	<h1>Draw the line - single answer</h1>
		
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<p><strong>Answer:</strong></p>
		{$form.fields.answer.field}<br />
		{if $form.fields.answer.errMsg}<p class="adminError">{$form.fields.answer.errMsg}</p>{/if}<br />
		
		<p><strong>Type:</strong></p>
		{$form.fields.type.field}<br />
		{if $form.fields.type.errMsg}<p class="adminError">{$form.fields.type.errMsg}</p>{/if}<br />
		
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	{$form.close}

{else}

	<h1>Draw the line - questions</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Question</th>
			<th class="even">State</th>
			<th class="even">Digits</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$questions item=item name=questions}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$item.href}');">
				<td class="odd">{$item.question}</td>
				<td class="even">{$item.state}</td>
				<td class="odd">{$item.digits}</td>
			</tr>
		{/foreach}
	</tbody>
	</table>

{/if}