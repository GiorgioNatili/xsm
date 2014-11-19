{if $edit}

	<h1>Here - {$toolName}</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Comment:</strong></p>
			{$form.fields.comment.field}<br />
			{if $form.fields.comment.errMsg}<p class="adminError">{$form.fields.comment.errMsg}</p>{/if}
		</div>
		<div class="clear"></div><br />
		
		<p class="adminBackToList">
			{if $edit}<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />{/if}
			<input type="submit" name="submit" value="save" class="save" />
		</p>
	</fieldset>
	{$form.close}
	
{else}

	<h1>Here</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Tool</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$cards item=card name=cardsList}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$card.href}');">
				<td class="odd">{$card.tool}</td>
			</tr>
		{foreachelse}
			<tr>
				<td colspan="2">{$lang.no_cards}</td>
			</tr>
		{/foreach}
	</tbody>
	</table>

{/if}