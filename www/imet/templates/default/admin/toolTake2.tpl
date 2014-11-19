{if $singleCoupon}

	<h1>Take 2 - answers</h1>
		
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<p><strong>Fan:</strong></p>
		{$form.fields.coupon.field}<br />
		{if $form.fields.coupon.errMsg}<p class="adminError">{$form.fields.coupon.errMsg}</p>{/if}<br />
		
		<div style="float:left;padding:0 15px 0 0;">
			<p><strong>Substance:</strong></p>
			{$form.fields.type.field}<br />
			{if $form.fields.type.errMsg}<p class="adminError">{$form.fields.type.errMsg}</p>{/if}<br />
		</div>
		<div style="float:left">
			<p><strong>Set:</strong></p>
			{$form.fields.set.field}<br />
			{if $form.fields.set.errMsg}<p class="adminError">{$form.fields.set.errMsg}</p>{/if}<br />
		</div>
		
		{if !$addSingleCoupon}
		
			<div class="bttnCont">
				<a href="{$newHref}">Add new</a>
				<div class="clear"></div>
			</div>
	
			<table cellpadding="0" cellspacing="0" class="table">
			<thead>
				<tr>
					<th class="odd">Answer</th>
					<th class="even">Input mode</th>
					<th class="odd">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$answers item=item name=answers}
					<tr class="{cycle values='odd,even'}" onclick="redirect('{$item.href}');">
						<td class="odd">{$item.answer}</td>
						<td class="even">{$item.input}</td>
						<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="{$item.delHref}" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
					</tr>
				{foreachelse}
					<tr>
						<td colspan="4">{$lang.no_types}</td>
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
		
		<p class="adminBackToList">
			{if !$addSingleCoupon}<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />{/if}
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	{$form.close}
	
{elseif $singleAnswer}

	<h1>Take2 - single answer</h1>
		
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<p><strong>Answer:</strong></p>
		{$form.fields.text.field}<br />
		{if $form.fields.text.errMsg}<p class="adminError">{$form.fields.text.errMsg}</p>{/if}<br />
		
		<p style="padding:0 0 5px 0"><strong>Input mode:</strong></p>
		{$form.fields.inputmode.field}<label for="inputmode" style="padding:0 0 0 10px;vertical-align:top;">Yes</label><br />
		
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	{$form.close}

{else}

	<h1>Take 2 - fan</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$newHref}">Add new</a>
		<div class="clear"></div>
	</div>
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Fan</th>
			<th class="even">Substance</th>
			<th class="even">Set</th>
			<th class="odd">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$coupons item=item name=coupons}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$item.href}');">
				<td class="odd">{$item.text}</td>
				<td class="even">{$item.substance}</td>
				<td class="odd">{$item.set}</td>
				<td class="even" style="text-align:center;width:40px;"><a class="delete" rel="{$item.delHref}" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
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