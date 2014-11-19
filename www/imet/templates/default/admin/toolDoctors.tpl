{if !$singleDoctor}

	<h1>Doctors</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$newHref}">Add new</a>
		<div class="clear"></div>
	</div>
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Login</th>
			<th class="even">First name</th>
			<th class="odd">Last name</th>
			<th class="even">Role</th>
			<th class="odd">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$doctors item=item name=doctors}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$item.href}');">
				<td class="odd">{$item.login}</td>
				<td class="even">{$item.name}</td>
				<td class="odd">{$item.surname}</td>
				<td class="even">{$item.role}</td>
				<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="{$item.delHref}" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
			</tr>
		{foreachelse}
			<tr>
				<td colspan="5">No items</td>
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

	<h1>Doctors - {if $addNew} add new{else}edit{/if}</h1>
	
	{if $toolSaved}<p class="toolSaved">{$toolSaved}</p>{/if}
	
	<div class="bttnCont">
		<a href="{$backHref}">Back</a>
		<div class="clear"></div>
	</div>
	
	{$form.open}
	<fieldset>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Login:</strong></p>
			{$form.fields.login.field}<br />
			{if $form.fields.login.errMsg}<p class="adminError">{$form.fields.login.errMsg}</p>{/if}
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>{if $edit}New password{else}Password{/if}:</strong></p>
			{$form.fields.pass1.field}<br />
			{if $form.fields.pass1.errMsg}<p class="adminError">{$form.fields.pass1.errMsg}</p>{/if}
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Re-password:</strong></p>
			{$form.fields.pass2.field}<br />
			{if $form.fields.pass2.errMsg}<p class="adminError">{$form.fields.pass2.errMsg}</p>{/if}
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Password hint:</strong></p>
			{$form.fields.passhint.field}<br />
			{if $form.fields.passhint.errMsg}<p class="adminError">{$form.fields.passhint.errMsg}</p>{/if}
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Name:</strong></p>
			{$form.fields.name.field}<br />
			{if $form.fields.name.errMsg}<p class="adminError">{$form.fields.name.errMsg}</p>{/if}
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Surname:</strong></p>
			{$form.fields.surname.field}<br />
			{if $form.fields.surname.errMsg}<p class="adminError">{$form.fields.surname.errMsg}</p>{/if}
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Email:</strong></p>
			{$form.fields.email.field}<br />
			{if $form.fields.email.errMsg}<p class="adminError">{$form.fields.email.errMsg}</p>{/if}
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Email 2:</strong></p>
			{$form.fields.email2.field}<br />
			{if $form.fields.email2.errMsg}<p class="adminError">{$form.fields.email2.errMsg}</p>{/if}
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Organization:</strong></p>
			{$form.fields.organization.field}<br />
			{if $form.fields.organization.errMsg}<p class="adminError">{$form.fields.organization.errMsg}</p>{/if}
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Telephone 1:</strong></p>
			{$form.fields.phone1.field}<br />
			{if $form.fields.phone1.errMsg}<p class="adminError">{$form.fields.phone1.errMsg}</p>{/if}
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Telephone 2:</strong></p>
			{$form.fields.phone2.field}<br />
			{if $form.fields.phone2.errMsg}<p class="adminError">{$form.fields.phone2.errMsg}</p>{/if}
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Role:</strong></p>
			{if $edit}
				{$doctorType}
			{else}
				{$form.fields.type.field}<br />
				{if $form.fields.type.errMsg}<p class="adminError">{$form.fields.type.errMsg}</p>{/if}
			{/if}
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Notes:</strong></p>
			{$form.fields.notes.field}<br />
			{if $form.fields.notes.errMsg}<p class="adminError">{$form.fields.notes.errMsg}</p>{/if}
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			{$form.fields.disabled.field} &nbsp; <label for="disabled">Disabled</label>
		</div>
		<div class="clear"></div><br />
		
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Site:</strong></p>
			{$form.fields.site.field}<br />
			{if $form.fields.site.errMsg}<p class="adminError">{$form.fields.site.errMsg}</p>{/if}
		</div>
		<div class="clear"></div><br />
		
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Choose icon:</strong></p>
		</div>
		<div class="clear"></div><br />
		
		
		
		{foreach from=$icons item=item name=icons}
			<div class="doctorIco{if $item.selected} doctorActiveIco{/if}" style="background-image:url({$item.img});" rel="{$item.id}"></div>
		{foreachelse}
			<p>No icons</p>
		{/foreach}
		<div class="clear"></div>
		{$form.fields.ico.field}
		
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Access to:</strong></p>
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="1" id="patient_information" {if $roles[1].checked}checked="checked"{/if} /> &nbsp; <label for="patient_information">Patient information</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="2" id="events" {if $roles[2].checked}checked="checked"{/if} /> &nbsp; <label for="events">Events</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="3" id="substance_list" {if $roles[3].checked}checked="checked"{/if} /> &nbsp; <label for="substance_list">Substance list</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="4" id="eligibility_results" {if $roles[4].checked}checked="checked"{/if} /> &nbsp; <label for="eligibility_results">Eligibility results</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="5" id="journal" {if $roles[5].checked}checked="checked"{/if} /> &nbsp; <label for="journal">Journal</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="6" id="tools_summary" {if $roles[6].checked}checked="checked"{/if} /> &nbsp; <label for="tools_summary">Tools summary</label>
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="7" id="mail" {if $roles[7].checked}checked="checked"{/if} /> &nbsp; <label for="mail">Mail</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="8" id="doctors" {if $roles[8].checked}checked="checked"{/if} /> &nbsp; <label for="doctors">Doctors</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="9" id="assessments" {if $roles[9].checked}checked="checked"{/if} /> &nbsp; <label for="assessments">Assessments</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="10" id="add_new_patient" {if $roles[10].checked}checked="checked"{/if} /> &nbsp; <label for="add_new_patient">Add new patients</label>
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