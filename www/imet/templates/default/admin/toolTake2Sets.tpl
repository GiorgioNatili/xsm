{if $singleCard}

	<h1>Take 2 - Sets</h1>
		
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
		
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	{$form.close}

{else}

	<h1>Take 2 - Sets</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Set</th>
			<th class="even">Info</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$sets item=item name=coupons}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$item.href}');">
				<td class="odd">{$item.set}</td>
				<td class="even">{$item.info}</td>
			</tr>
		{/foreach}
	</tbody>
	</table>

{/if}