{if $textsList}

	<h1>Summary Page</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Event</th>
			<th class="even">Description</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$textsList item=item name=textsList}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$item.href}');">
				<td class="odd">{$item.event}</td>
				<td class="even">{$item.description}</td>
			</tr>
		{/foreach}
	</tbody>
	</table>
	
{elseif $singleText}

	<h1>Summary Page</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<p><strong>Event:</strong></p>
		{$form.fields.event.field}<br />
		{if $form.fields.event.errMsg}<p class="adminError">{$form.fields.event.errMsg}</p>{/if}<br />
		
		<p><strong>Description:</strong></p>
		{$form.fields.description.field}<br />
		{if $form.fields.description.errMsg}<p class="adminError">{$form.fields.description.errMsg}</p>{/if}<br />
			
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	{$form.close}

{/if}
