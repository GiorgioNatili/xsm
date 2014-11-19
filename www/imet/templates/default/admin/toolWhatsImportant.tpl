{* VIEW and EDIT *}

{if !$addNew}

	{if $edit}
	
		<h1>What's important to me? - edit card</h1>
		
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
			<div style="float:left;">
				<p><strong>Background:</strong></p>
				{$form.fields.background.field}<br />
				{if $form.fields.background.errMsg}<p class="adminError">{$form.fields.background.errMsg}</p>{/if}
			</div>
			<div class="clear"></div><br />
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>Label:</strong></p>
				{$form.fields.label1.field}<br />
				{if $form.fields.label1.errMsg}<p class="adminError">{$form.fields.label1.errMsg}</p>{/if}
			</div>
			<div style="float:left;padding:0 20px 0 0" id="label2">
				<p><strong>Second side label:</strong></p>
				{$form.fields.label2.field}<br />
			</div>
			<div class="clear"></div><br />
			
			<p class="adminBackToList">
				{if $edit}<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />{/if}
				<input type="submit" name="submit" value="save" class="save" />
			</p>
			
		</fieldset>
		{$form.close}
		
		<script type="text/javascript">
		{literal}
			$(document).ready(function(){
			
				if($('#typeSelect').val() == '1') $('#label2').hide();
			
				$('#typeSelect').change(function(){
					if($(this).val() == '1')
					{
						$('#label2').hide();
					}
					else
					{
						$('#label2').show();
					}
				});
				
				$('#background').ColorPicker({
									onSubmit: function(hsb, hex, rgb, el) {
										$(el).val(hex);
										$(el).ColorPickerHide();
									},
									onBeforeShow: function () {
										$(this).ColorPickerSetColor(this.value);
									}
				});
				
			});
		{/literal}
		</script>
		
	{else}
	
		<h1>What's important to me?</h1>
		
		{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
		
		<div class="bttnCont">
			<a href="{$newHref}">Add new</a>
			<div class="clear"></div>
		</div>
		
		<table cellpadding="0" cellspacing="0" class="table">
		<thead>
			<tr>
				<th class="odd">Label</th>
				<th class="even">Type</th>
				<th class="odd">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$cards item=card name=cardsList}
				<tr class="{cycle values='odd,even'}" onclick="redirect('{$card.href}');">
					<td class="odd">{$card.label}</td>
					<td class="even">{$card.type}</td>
					<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="{$card.delHref}" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
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

	<h1>What's important to me? - new card</h1>
		
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
		<div style="float:left;">
			<p><strong>Background:</strong></p>
			{$form.fields.background.field}<br />
			{if $form.fields.background.errMsg}<p class="adminError">{$form.fields.background.errMsg}</p>{/if}
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Label:</strong></p>
			{$form.fields.label1.field}<br />
			{if $form.fields.label1.errMsg}<p class="adminError">{$form.fields.label1.errMsg}</p>{/if}
		</div>
		<div style="float:left;padding:0 20px 0 0" id="label2">
			<p><strong>Second side label:</strong></p>
			{$form.fields.label2.field}<br />
		</div>
		<div class="clear"></div><br />
		
		<p class="adminBackToList">
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	{$form.close}
	
	<script type="text/javascript">
	{literal}
		$(document).ready(function(){
		
			if($('#typeSelect').val() == '1') $('#label2').hide();
		
			$('#typeSelect').change(function(){
				if($(this).val() == '1')
				{
					$('#label2').hide();
				}
				else
				{
					$('#label2').show();
				}
			});
			
			$('#background').ColorPicker({
								onSubmit: function(hsb, hex, rgb, el) {
									$(el).val(hex);
									$(el).ColorPickerHide();
								}
			});
			
		});
	{/literal}
	</script>

{/if}
