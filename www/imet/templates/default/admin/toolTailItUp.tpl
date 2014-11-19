{* VIEW and EDIT *}

{if !$addNew}

	{if $stimulants}
	
		<h1>Tail It Up!</h1>
		
		{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
		
		<table cellpadding="0" cellspacing="0" class="table">
		<thead>
			<tr>
				<th class="odd">Stimulant</th>
				<th class="even">Box Label</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$stimulants item=stimulant name=stimulants}
				<tr class="{cycle values='odd,even'}" onclick="redirect('{$stimulant.href}');">
					<td class="odd">{$stimulant.name}</td>
					<td class="even">{$stimulant.label}</td>
				</tr>
			{/foreach}
		</tbody>
		</table>
		
	{elseif $stimulant}
	
		<h1>Tail It Up! - {$stimulant.stimulant}</h1>
		
		{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
		
		<div class="bttnCont">
			<a href="{$backHref}">Back</a>
			<div class="clear"></div>
		</div>
		
		{$form.open}
		<fieldset>
			<p><strong>Box label:</strong></p>
			{$form.fields.label.field}<br />
			{if $form.fields.label.errMsg}<p class="adminError">{$form.fields.label.errMsg}</p>{/if}<br />
			
			<div class="bttnCont">
				<a href="{$newHref}">Add new</a>
				<div class="clear"></div>
			</div>
	
			<table cellpadding="0" cellspacing="0" class="table">
			<thead>
				<tr>
					<th class="odd">Calculator Info Text</th>
					<th class="even">Stuff Info Text</th>
					<th class="odd">Type</th>
					<th class="even">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$types item=type name=types}
					<tr class="{cycle values='odd,even'}" onclick="redirect('{$type.href}');">
						<td class="odd">{$type.calculator_info|strip_tags:false|truncate:50:"&hellip;"}</td>
						<td class="even">{$type.stuff_info|strip_tags:false|truncate:50:"&hellip;"}</td>
						<td class="odd">{$type.type}</td>
						<td class="even" style="text-align:center;width:40px;"><a class="delete" rel="{$type.delHref}" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
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
			
			<p class="adminBackToList">
				<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />
				<input type="submit" name="submit" value="save" class="save" />
			</p>
			
		</fieldset>
		{$form.close}
		
	{elseif $stimulantName && $isTypes}
	
		<h1>Tail It Up! - {$stimulantName} - {$typeName}</h1>
		
		{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
		
		<div class="bttnCont">
			<a href="{$backHref}">Back</a>
			<div class="clear"></div>
		</div>
		
		{$form.open}
		<fieldset>
		
			<p><strong>Calculator Info Text:</strong></p>
			{$form.fields.info1.field}<br />
			{if $form.fields.info1.errMsg}<p class="adminError">{$form.fields.info1.errMsg}</p>{/if}<br />
			
			<p><strong>Stuff Info Text:</strong></p>
			{$form.fields.info2.field}<br />
			{if $form.fields.info2.errMsg}<p class="adminError">{$form.fields.info2.errMsg}</p>{/if}<br />
			
			<p><strong>Type:</strong></p>
			{$form.fields.type.field}<br />
			{if $form.fields.type.errMsg}<p class="adminError">{$form.fields.type.errMsg}</p>{/if}<br />
			
			
			
			
			<div id="optionList">
				<p><strong>Stuffs:</strong></p>
				<ul>
					{foreach from=$stuffs item=item name=stuffs}
						<li style="float:left; padding-right:20px;line-height:18px;">
							{$item.name}
							<a href="{$item.delHref}" class="delete" title="Delete"><img src="templates/default/images/delete.png" alt="" style="vertical-align:top;" /></a>
						</li>
					{/foreach}
					<li style="float:left;width:90px;">
						<a href="{$newStuffHref}" style="color:#000;font-weight:bold;">Add new</a>
					</li>
				</ul>
				<div class="clear"></div>
			</div>
			
			
			
			
			
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
				{foreach from=$types item=type name=types}
					<tr class="{cycle values='odd,even'}" onclick="redirect('{$type.href}');">
						<td class="odd">{$type.label}</td>
						<td class="even">{$type.type}</td>
						<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="{$type.delHref}" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
					</tr>
				{foreachelse}
					<tr>
						<td colspan="3">{$lang.no_types}</td>
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
			
			<p class="adminBackToList">
				<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />
				<input type="submit" name="submit" value="save" class="save" />
			</p>
			
		</fieldset>
		{$form.close}
	
	{elseif $stimulantName && $calOption}
	
		<h1>Tail It Up! - {$stimulantName} - {$typeName} - options</h1>
		
		{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
		
		<div class="bttnCont">
			<a href="{$backHref}">Back</a>
			<div class="clear"></div>
		</div>
		
		{$form.open}
		<fieldset>
		
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>Label:</strong></p>
				{$form.fields.label.field}<br />
				{if $form.fields.label.errMsg}<p class="adminError">{$form.fields.label.errMsg}</p>{/if}
			</div>
			<div style="float:left">
				<p><strong>Type:</strong></p>
				{$form.fields.type.field}<br />
				{if $form.fields.type.errMsg}<p class="adminError">{$form.fields.type.errMsg}</p>{/if}
			</div>
			<div class="clear"></div><br />
			
			
			<div id="optionList"{if $calOption.type == 'input'} style="display:none"{/if}>
				<ul>
					{foreach from=$values item=value name=values}
						<li>
							Label: <input class="adminInput" style="width:150px;margin-right:20px;" type="text" name="label_{$smarty.foreach.values.iteration}" value="{$value.label}" />
							Data:  <input class="adminInput" style="width:80px;margin-right:20px;" type="text" name="data_{$smarty.foreach.values.iteration}" value="{$value.data}" />
							<a href="#" onclick="return deleteRow(this);" class="delete" title="Delete"><img src="templates/default/images/delete.png" alt="" style="vertical-align:middle;" /></a>
						</li>
					{/foreach}
				</ul>
				<a href="#" class="addNew">Add new</a>
			</div>
			
			
			<script type="text/javascript">
			{literal}
				$(document).ready(function(){
					$("#optionsType").change(function(){
						if($(this).val() == 1)
						{
							$("#optionList").hide();
						}
						else if($(this).val() == 2)
						{
							$("#optionList").show();
						}
					});
					
					$("#optionList .addNew").click(function(){
						var id=1;
						$("#optionList ul li").each(function(i){
							id++;
						});
						var html = '<li>';
							html += 'Label: <input class="adminInput" style="width:150px;margin-right:20px;" type="text" name="label_' + id + '" value="" /> ';
							html += 'Data:  <input class="adminInput" style="width:80px;margin-right:20px;" type="text" name="data_' + id + '" value="" /> ';
							html += '<a href="#" onclick="return deleteRow(this);" class="delete" title="Delete"><img src="templates/default/images/delete.png" alt="" style="vertical-align:middle;" /></a>';
							html += '</li>';
						$("#optionList ul").append(html);
						return false;
					});
				});
				
				function deleteRow(row)
				{
					$(row).parent().remove();
					return false;
				}
			{/literal}
			</script>
			
			<p class="adminBackToList">
				<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />
				<input type="submit" name="submit" value="save" class="save" />
			</p>
			
		</fieldset>
		{$form.close}
	
	{/if}

{* ADDING NEW ROWS *}	
{elseif $addNew == 1}
	
	<h1>Tail It Up! - {$stimulant.stimulant} - new type</h1>
		
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
	
		<p><strong>Calculator Info Text:</strong></p>
		{$form.fields.info1.field}<br />
		{if $form.fields.info1.errMsg}<p class="adminError">{$form.fields.info1.errMsg}</p>{/if}<br />
		
		<p><strong>Stuff Info Text:</strong></p>
		{$form.fields.info2.field}<br />
		{if $form.fields.info2.errMsg}<p class="adminError">{$form.fields.info2.errMsg}</p>{/if}<br />
		
		<p><strong>Type:</strong></p>
		{$form.fields.type.field}<br />
		{if $form.fields.type.errMsg}<p class="adminError">{$form.fields.type.errMsg}</p>{/if}<br />
		
		<p class="adminBackToList">
			<input type="submit" name="submit" value="add" class="save" />
		</p>
		
	</fieldset>
	{$form.close}
	
{elseif $addNew == 2}

	<h1>Tail It Up! - {$stimulant.stimulant} - {$typeName} - new type</h1>
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
	
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Label:</strong></p>
			{$form.fields.label.field}<br />
			{if $form.fields.label.errMsg}<p class="adminError">{$form.fields.label.errMsg}</p>{/if}
		</div>
		<div style="float:left">
			<p><strong>Type:</strong></p>
			{$form.fields.type.field}<br />
			{if $form.fields.type.errMsg}<p class="adminError">{$form.fields.type.errMsg}</p>{/if}
		</div>
		<div class="clear"></div>
		<br />
	
		<p class="adminBackToList">
			<input type="submit" name="submit" value="add" class="save" />
		</p>
	
	</fieldset>
	{$form.close}

{elseif $addNew == 3}

	<h1>Tail It Up! - {$stimulant.stimulant} - {$typeName} - new stuff</h1>
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
	
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Stuff list:</strong></p>
			{$form.fields.stuff.field}<br />
			{if $form.fields.stuff.errMsg}<p class="adminError">{$form.fields.stuff.errMsg}</p>{/if}
		</div>
		<div class="clear"></div>
		<br />
	
		<p class="adminBackToList">
			<input type="submit" name="submit" value="add" class="save" />
		</p>
	
	</fieldset>
	{$form.close}

{/if}