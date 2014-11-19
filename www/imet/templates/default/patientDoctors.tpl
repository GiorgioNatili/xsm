<h1>Doctors</h1>

{if $saved}<p class="toolSaved">{$saved}</p>{/if}

<div class="bttnCont">
	<a href="{$backHref}">Back to Patient information page</a>
	<div class="clear"></div>
</div>

{$form.open}
	<div>
		{foreach from=$doctors item=item name=doctors}
			<input type="checkbox" name="doctors[]" value="{$item.id}" id="doctor{$item.id}" {if $item.checked}checked="checked"{/if} />
			<label for="doctor{$item.id}" style="vertical-align:top;padding:0 10px 10px 0;">{$item.fullname}</label>
		{/foreach}
		
		{if $formError}
			<p style="color:red">{$formError}</p>
		{/if}
		
		<br /><br />
		<input type="submit" class="newPatientFormSubmit" value="Save" name="doctorsSave" />
		<div class="clear"></div>
		
	</div>
{$form.close}
