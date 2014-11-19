<h1>Icons</h1>

{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}


{foreach from=$icons item=item name=icons}
	<div class="doctorIco" style="background-image:url({$item.img});">
		<a href="#" class="del" title="Delete" rel="{$item.delHref}">X</a> 
	</div>
{foreachelse}
	<p>No icons</p>
{/foreach}
<div class="clear"></div>

<div class="adminBackToList" style="text-align:left">
	{$form.open}
		<label>Add new icon</label>
		{$form.fields.icon.field}
		<input type="submit" name="submit" class="save" value="Add" /><br />
		{if $form.fields.icon.errMsg}<p style="color:red">{$form.fields.icon.errMsg}</p>{/if}
	{$form.close}
</div>

<script type="text/javascript">
{literal}
	$(document).ready(function(){
		$('.doctorIco .del').click(function(){
			if(confirm("{/literal}{$lang.delete_confirm}{literal}"))
			{
				location.href=$(this).attr('rel');
			}
			return false;
		});
	});
{/literal}
</script>
