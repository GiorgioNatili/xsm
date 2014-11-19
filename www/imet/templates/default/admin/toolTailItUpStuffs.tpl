{if $stuffs}

	<h1>Tail It Up! - Things</h1>
			
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$newHref}">Add new</a>
		<div class="clear"></div>
	</div>
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Text</th>
			<th class="even">Value</th>
			<th class="odd">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$stuffs item=stuff name=stuffs}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$stuff.href}');">
				<td class="odd">{$stuff.text}</td>
				<td class="even">{$stuff.value}</td>
				<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="{$stuff.delHref}" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
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
	
{elseif $form}

	<h1>Tail It Up! - Things</h1>
			
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Text:</strong></p>
			{$form.fields.text.field}<br />
			{if $form.fields.text.errMsg}<p class="adminError">{$form.fields.text.errMsg}</p>{/if}
		</div>
		<div style="float:left">
			<p><strong>Value:</strong></p>
			{$form.fields.value.field}<br />
			{if $form.fields.value.errMsg}<p class="adminError">{$form.fields.value.errMsg}</p>{/if}
		</div>
		<div class="clear"></div>
		<br />
		<p class="adminBackToList">
			{if $edit}<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />{/if}
			<input type="submit" name="submit" value="save" class="save" />
		</p>
	</fieldset>
	{$form.close}

{/if}
