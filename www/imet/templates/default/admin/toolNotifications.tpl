{if $textsList}

	<h1>Notifications</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Text</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$textsList item=item name=textsList}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$item.href}');">
				<td class="odd">{$item.text}</td>
			</tr>
		{/foreach}
	</tbody>
	</table>
	
{elseif $singleText}

	<script type="text/javascript" src="lib/ckeditor/ckeditor.js"></script>

	<h1>Notification</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<p><strong>Notification:</strong></p>
		<div class="{if $form.fields.body.errMsg}textAreaError{/if}">{$form.fields.body.field}</div>
		{if $form.fields.body.errMsg}<p class="adminError">{$form.fields.body.errMsg}</p>{/if}

		<script type="text/javascript">
		{literal}
			$(document).ready(function(){
				CKEDITOR.replace( 'editor1', { toolbar: 'Full' } );
			});
		{/literal}
		</script>
			
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	{$form.close}

{/if}
