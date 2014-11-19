{if $new}

	<h1>Holidays - add new</h1>
		
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<div style="float:left;width:150px;">
			<p><strong>Day:</strong></p>
			{$form.fields.day.field}<br />
			{if $form.fields.day.errMsg}<p class="adminError">{$form.fields.day.errMsg}</p>{/if}<br />
		</div>
		<div style="float:left;padding:0 0 0 50px;">
			<p><strong>Month:</strong></p>
			{$form.fields.month.field}<br />
			{if $form.fields.month.errMsg}<p class="adminError">{$form.fields.month.errMsg}</p>{/if}<br />
		</div>
		<div class="clear"></div>
		
		<p><strong>Text:</strong></p>
		{$form.fields.name.field}<br />
		{if $form.fields.name.errMsg}<p class="adminError">{$form.fields.name.errMsg}</p>{/if}<br />
			
		<p class="adminBackToList">
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	{$form.close}

{else}
	{if $textsList}
	
		<h1>Holidays <a href="{$addNewHref}" class="addNew">Add new</a></h1>
		
		{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
		
		<table cellpadding="0" cellspacing="0" class="table">
		<thead>
			<tr>
				<th class="odd">ID</th>
				<th class="even">Date</th>
				<th class="odd">Text</th>
				<th class="even">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$textsList item=text name=textsList}
				<tr class="{cycle values='odd,even'}" onclick="redirect('{$text.href}');">
					<td class="odd">{$smarty.foreach.textsList.iteration}</td>
					<td class="even">{$text.date}</td>
					<td class="odd">{$text.text}</td>
					<td class="even" style="text-align:center;width:40px;"><a class="delete" rel="{$text.delHref}" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
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
		
	{elseif $singleText}
	
		<h1>Holidays - {$singleText.date}</h1>
		
		{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
		
		<div class="bttnCont">
			<a href="{$backHref}">Back</a>
			<div class="clear"></div>
		</div>
		
		{$form.open}
		<fieldset>
			<div style="float:left;width:150px;">
				<p><strong>Day:</strong></p>
				{$form.fields.day.field}<br />
				{if $form.fields.day.errMsg}<p class="adminError">{$form.fields.day.errMsg}</p>{/if}<br />
			</div>
			<div style="float:left;padding:0 0 0 50px;">
				<p><strong>Month:</strong></p>
				{$form.fields.month.field}<br />
				{if $form.fields.month.errMsg}<p class="adminError">{$form.fields.month.errMsg}</p>{/if}<br />
			</div>
			<div class="clear"></div>
			
			<p><strong>Text:</strong></p>
			{$form.fields.name.field}<br />
			{if $form.fields.name.errMsg}<p class="adminError">{$form.fields.name.errMsg}</p>{/if}<br />
				
			<p class="adminBackToList">
				<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />
				<input type="submit" name="submit" value="save" class="save" />
			</p>
			
		</fieldset>
		{$form.close}
	
	{/if}
{/if}
