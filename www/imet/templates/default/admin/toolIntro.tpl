<script type="text/javascript" src="lib/ckeditor/ckeditor.js"></script>

{* VIEW and EDIT *}

{if !$addNew}

	{if $edit}
	
		<h1>Intro - edit</h1>
		
		{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
		
		<div class="bttnCont">
			<a href="{$backHref}">Back</a>
			<div class="clear"></div>
		</div>
		
		{$form.open}
		<fieldset>
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>Type:</strong></p>
				{$form.fields.type.field}<br />
				{if $form.fields.type.errMsg}<p class="adminError">{$form.fields.type.errMsg}</p>{/if}
			</div>
			<div class="clear"></div><br />
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>UID:</strong></p>
				{$form.fields.uid.field}<br />
				{if $form.fields.uid.errMsg}<p class="adminError">{$form.fields.uid.errMsg}</p>{/if}
			</div>
			<div class="clear"></div><br />
			<p><strong>Text:</strong></p>
			{$form.fields.text.field}<br />
			{if $form.fields.text.errMsg}<p class="adminError">{$form.fields.text.errMsg}</p>{/if}
			<div class="clear"></div><br />
			
			<script type="text/javascript">
			{literal}
				$(document).ready(function(){
					CKEDITOR.replace( 'editor1', { toolbar: 'Full' } );
				});
			{/literal}
			</script>
			
			<p class="adminBackToList">
				{if $edit}<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />{/if}
				<input type="submit" name="submit" value="save" class="save" />
			</p>
		</fieldset>
		{$form.close}
		
	{else}
	
		<h1>Intro</h1>
		
		{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
		
		<div class="bttnCont">
			<a href="{$newHref}">Add new</a>
			<div class="clear"></div>
		</div>
		
		<table cellpadding="0" cellspacing="0" class="table">
		<thead>
			<tr>
				<th class="odd">Type</th>
				<th class="even">Uid</th>
				<th class="odd">Text</th>
				<th class="even">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$cards item=card name=cardsList}
				<tr class="{cycle values='odd,even'}" onclick="redirect('{$card.href}');">
					<td class="odd">{$card.type}</td>
					<td class="even">{$card.uid}</td>
					<td class="odd">{$card.text}</td>
					<td class="even" style="text-align:center;width:40px;"><a class="delete" rel="{$card.delHref}" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="2">{$lang.no_cards}</td>
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
				<p><strong>Type:</strong></p>
				{$form.fields.type.field}<br />
				{if $form.fields.type.errMsg}<p class="adminError">{$form.fields.type.errMsg}</p>{/if}
			</div>
			<div class="clear"></div><br />
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>UID:</strong></p>
				{$form.fields.uid.field}<br />
				{if $form.fields.uid.errMsg}<p class="adminError">{$form.fields.uid.errMsg}</p>{/if}
			</div>
			<div class="clear"></div><br />
			<div style="float:left;padding:0 20px 0 0" id="label2">
				<p><strong>Text:</strong></p>
				{$form.fields.text.field}<br />
				{if $form.fields.text.errMsg}<p class="adminError">{$form.fields.text.errMsg}</p>{/if}
			</div>
			<div class="clear"></div><br />
			
			<script type="text/javascript">
			{literal}
				$(document).ready(function(){
					CKEDITOR.replace( 'editor1', { toolbar: 'Full' } );
				});
			{/literal}
			</script>
			
			<p class="adminBackToList">
				<input type="submit" name="submit" value="save" class="save" />
			</p>
		</fieldset>
		{$form.close}
	
{/if}
