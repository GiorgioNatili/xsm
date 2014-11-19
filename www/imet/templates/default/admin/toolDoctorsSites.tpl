{if !$singleSite}

	<h1>Sites</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$newHref}">Add new</a>
		<div class="clear"></div>
	</div>
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Name</th>
			<th class="even">Code</th>
			<th class="odd">Doctors</th>
			<th class="even">Patients</th>
			<th class="odd">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$list item=item name=sites}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$item.href}');">
				<td class="odd">{$item.name}</td>
				<td class="even">{$item.code}</td>
				<td class="odd">{$item.quantityDoctors}</td>
				<td class="even">{$item.quantityPatients}</td>
				<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="{$item.delHref}" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
			</tr>
		{foreachelse}
			<tr>
				<td colspan="2">No items</td>
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
	
{else}

	<h1>Sites - {if $edit} edit{else}add new{/if}</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
		<fieldset>
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>Name:</strong></p>
				{$form.fields.name.field}<br />
				{if $form.fields.name.errMsg}<p class="adminError">{$form.fields.name.errMsg}</p>{/if}
			</div>
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>Code:</strong></p>
				{$form.fields.code.field}<br />
				{if $form.fields.code.errMsg}<p class="adminError">{$form.fields.code.errMsg}</p>{/if}
			</div>
			<div class="clear"></div><br />
			
			<p class="adminBackToList">
				{if $edit}<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />{/if}
				<input type="submit" name="submit" value="{if $edit}Save{else}Add{/if}" class="save" />
			</p>
		</fieldset>
	{$form.close}
	
	<script type="text/javascript">
	{literal}
		$(document).ready(function(){
			$('.doctorIco').click(function(){
				if($(this).hasClass('doctorActiveIco'))
				{
					$(this).removeClass('doctorActiveIco');
					$("#doctorIcoId").val('');
				}
				else
				{
					$('.doctorIco').removeClass('doctorActiveIco');
					$(this).addClass('doctorActiveIco');
					$("#doctorIcoId").val($(this).attr('rel'));
				}
			});
		});
	{/literal}
	</script>

{/if}