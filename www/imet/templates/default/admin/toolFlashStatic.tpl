{if $pagesList}

	<h1>Static pages</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">ID</th>
			<th class="even">Title</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$pagesList item=page name=pagesList}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$page.href}');">
				<td class="odd">{$smarty.foreach.pagesList.iteration}</td>
				<td class="even">{$page.title}</td>
			</tr>
		{/foreach}
	</tbody>
	</table>
	
{elseif $singlePage}

	<script type="text/javascript" src="lib/ckeditor/ckeditor.js"></script>

	<h1>Static pages - {$singlePage.title}</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<p><strong>{$lang.title}:</strong></p>
		{$form.fields.title.field}<br />
		{if $form.fields.title.errMsg}<p class="adminError">{$form.fields.title.errMsg}</p>{/if}<br />
	
		<p><strong>{$lang.text}:</strong></p>
		<div class="{if $form.fields.body.errMsg}textAreaError{/if}">{$form.fields.body.field}</div>
		{if $form.fields.body.errMsg}<p class="adminError">{$form.fields.body.errMsg}</p>{/if}
		<script type="text/javascript">
		{literal}
			$(document).ready(function(){
				CKEDITOR.replace( 'editor1', { toolbar: 'Full' } );
			});
		{/literal}
		</script>
		
		{if $form.fields.body2.field}
			<p>&nbsp;</p>
			<p><strong>{$lang.text} 2:</strong></p>
			<div class="{if $form.fields.body2.errMsg}textAreaError{/if}">{$form.fields.body2.field}</div>
			{if $form.fields.body2.errMsg}<p class="adminError">{$form.fields.body2.errMsg}</p>{/if}
			<script type="text/javascript">
			{literal}
				$(document).ready(function(){
					CKEDITOR.replace( 'editor2', { toolbar: 'Full' } );
				});
			{/literal}
			</script>
		{/if}
		
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList">{$lang.back_to_list}</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	{$form.close}

{/if}
