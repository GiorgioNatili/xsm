{if $textsList}

	<h1>Short texts</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">ID</th>
			<th class="even">Code</th>
			<th class="odd">Text</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$textsList item=text name=textsList}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$text.href}');">
				<td class="odd">{$smarty.foreach.textsList.iteration}</td>
				<td class="even">{$text.code}</td>
				<td class="odd">{$text.text}</td>
			</tr>
		{/foreach}
	</tbody>
	</table>
	
{elseif $singleText}

	<h1>Short texts - {$singleText.code}</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<p><strong>Text:</strong></p>
		{$form.fields.text.field}<br />
		{if $form.fields.text.errMsg}<p class="adminError">{$form.fields.text.errMsg}</p>{/if}<br />
			
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	{$form.close}

{/if}
