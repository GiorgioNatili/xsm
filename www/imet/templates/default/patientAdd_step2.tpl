<h1>Add new Patient - step 2</h1>

{$form.open}
	<ul class="newPatientForm smallPadding">
		<li>
			<p class="title2">Personal Information</p>
		</li>
		<li>
			<label class="label">* First Name</label>
			{$form.fields.firstname.field}
			<div class="clear"></div>
			{if $form.fields.firstname.errMsg}<p class="error">{$form.fields.firstname.errMsg}</p>{/if}
		</li>
		<li>
			<label class="label">Middle Name</label>
			{$form.fields.middlename.field}
			<div class="clear"></div>
		</li>
		<li>
			<label class="label">* Last Name</label>
			{$form.fields.lastname.field}
			<div class="clear"></div>
			{if $form.fields.lastname.errMsg}<p class="error">{$form.fields.lastname.errMsg}</p>{/if}
		</li>
		<li>
			<label class="label">* Medical Record</label>
			{$form.fields.medical_record.field}
			<div class="clear"></div>
			{if $form.fields.medical_record.errMsg}<p class="error">{$form.fields.medical_record.errMsg}</p>{/if}
		</li>
		<li>
			<label class="label">* Sex</label>
			{$form.fields.sex.field}
			<div class="clear"></div>
			{if $form.fields.sex.errMsg}<p class="error">{$form.fields.sex.errMsg}</p>{/if}
		</li>
		<li>
			<label class="label">* Date of Birth</label>
			{$form.fields.dob.field}
			<div class="clear"></div>
			<p class="info">DD / MM / YYYY</p>
			{if $form.fields.dob.errMsg}<p class="error">{$form.fields.dob.errMsg}</p>{/if}
		</li>
		<li>
			<label class="label">* Clinician 1</label>
			{$form.fields.clinician.field}
			<div class="clear"></div>
			{if $form.fields.clinician.errMsg}<p class="error">{$form.fields.clinician.errMsg}</p>{/if}
		</li>
		<li>
			<label class="label">Clinician 2</label>
			{$form.fields.clinician2.field}
			<div class="clear"></div>
			{if $form.fields.clinician2.errMsg}<p class="error">{$form.fields.clinician2.errMsg}</p>{/if}
		</li>
		<li>
			<p class="title2">Contact Information</p>
		</li>
		<li>
			<label class="label">* Email</label>
			{$form.fields.email.field}
			<div class="clear"></div>
			{if $form.fields.email.errMsg}<p class="error">{$form.fields.email.errMsg}</p>{/if}
		</li>
		<li>
			<label class="label">Email</label>
			{$form.fields.email2.field}
		</li>
		<li>
			<label class="label">Home Number</label>
			{$form.fields.phone.field}
			<div class="clear"></div>
		</li>
		<li>
			<label class="label">* Cell</label>
			{$form.fields.cell.field}
			<div class="clear"></div>
			{if $form.fields.cell.errMsg}<p class="error">{$form.fields.cell.errMsg}</p>{/if}
		</li>
		<li>
			<label class="label">Parent</label>
			{$form.fields.parent.field}
			<div class="clear"></div>
		</li>
		<li>
			<label class="label">Alternate</label>
			{$form.fields.alternate.field}
			<div class="clear"></div>
		</li>
		<li>
			<p class="title3">Address</p>
		</li>
		<li>
			<label class="label">* Address</label>
			{$form.fields.address_1.field}
			<div class="clear"></div>
			{if $form.fields.address_1.errMsg}<p class="error">{$form.fields.address_1.errMsg}</p>{/if}
		</li>
		<li>
			<label class="label">Apt./Suite</label>
			{$form.fields.address_2.field}
			<div class="clear"></div>
		</li>
		<li>
			<label class="label">* City</label>
			{$form.fields.city.field}
			<div class="clear"></div>
			{if $form.fields.city.errMsg}<p class="error">{$form.fields.city.errMsg}</p>{/if}
		</li>
		<li>
			<label class="label">* State</label>
			{$form.fields.state.field}
			<div class="clear"></div>
			{if $form.fields.state.errMsg}<p class="error">{$form.fields.state.errMsg}</p>{/if}
		</li>
		<li>
			<label class="label">* Zip</label>
			{$form.fields.zip.field}
			<div class="clear"></div>
			{if $form.fields.zip.errMsg}<p class="error">{$form.fields.zip.errMsg}</p>{/if}
		</li>
		<li>
			<br />{$lang.pole_oznaczone_sa_obowiazkowe}
		</li>
	</ul>
	<ul class="newPatientForm newPatientFormRight2 smallPadding">
		<li>
			<p class="title2">Alternate Contact </p>
		</li>
		<li>
			<label class="label">Name</label>
			{$form.fields.alternate_name.field}
			<div class="clear"></div>
		</li>
		<li>
			<label class="label">Email</label>
			{$form.fields.alternate_email.field}
			<div class="clear"></div>
			{if $form.fields.alternate_email.errMsg}<p class="error">{$form.fields.alternate_email.errMsg}</p>{/if}
		</li>
		<li>
			<label class="label">Phone</label>
			{$form.fields.alternate_phone.field}
			<div class="clear"></div>
		</li>
		<li>
			<p class="title3">Address</p>
		</li>
		<li>
			<label class="label">Address</label>
			{$form.fields.alternate_address_1.field}
			<div class="clear"></div>
		</li>
		<li>
			<label class="label">Apt./Suite</label>
			{$form.fields.alternate_address_2.field}
			<div class="clear"></div>
		</li>
		<li>
			<label class="label">City</label>
			{$form.fields.alternate_city.field}
			<div class="clear"></div>
		</li>
		<li>
			<label class="label">State</label>
			{$form.fields.alternate_state.field}
			<div class="clear"></div>
		</li>
		<li>
			<label class="label">Zip</label>
			{$form.fields.alternate_zip.field}
			<div class="clear"></div>
		</li>
		<li>
			<p class="title2">Site</p>
		</li>
		{if count($doctorsSites)}
			<li>
				<label class="label">* PCP Doctor</label>
				<select class="select2" name="pcpDoctor" id="pcpDoctor"{if $doctorsSitesError} style="border:1px solid red;"{/if}>
					{foreach from=$doctorsSites item=doctor key=idDoctor name=doctorsSites}
						<option value="{$idDoctor}">{$doctor.fullname}</option>
					{/foreach}
				</select>
				<div class="clear"></div>
				{if $doctorsSitesError}<p class="error">This is a required field.</p>{/if}
			</li>
			<li id="pcpSiteName">
				<label class="label">* Site name</label>
			</li>
		{else}
			<li>
				<label class="label">* Site name</label>
				{$form.fields.site.field}
				<div class="clear"></div>
			</li>
		{/if}
	</ul>
	<div class="clear"></div>
	<div>
		<br />
		<a class="newPatientBack" href="{$backHref}">back</a>
		<input type="submit" name="nextStep" value="next" class="newPatientFormSubmit" />
		<div class="clear"></div>
	</div>
{$form.close}

<script type="text/javascript">

	var pcpDoctorSites = new Array();
	var pcpActive = 0;
	var siteActive = 0;
	
	{foreach from=$doctorsSites item=doctor key=idDoctor name=doctorsSites}

		{if $doctor.active}pcpActive={$idDoctor};{/if}
	
		pcpDoctorSites[{$idDoctor}] = new Array();
		{foreach from=$doctor.sites item=item}
			pcpDoctorSites[{$idDoctor}][{$item.id}] = "{$item.name}";

			{if $item.active}siteActive={$item.id};{/if}
			
		{/foreach}
	{/foreach}

{literal}
	function getDoctorSites()
	{
		var id_doctor = parseInt($("#pcpDoctor").val());

		if(id_doctor)
		{
			if(pcpDoctorSites[id_doctor])
			{
				var innerHTML = '<select class="select2" name="pcpSite" id="pcpSite">';
				for(i in pcpDoctorSites[id_doctor])
				{
					if(parseInt(i))
					{
						selected = '';
						if(siteActive == i)
						{
							selected='selected="selected"';
						}
						innerHTML += '<option ' + selected + ' value="' + i + '">' + pcpDoctorSites[id_doctor][i] + '</option>';
					}
				}

				innerHTML += '</select>';
				$("#pcpSiteName").append(innerHTML).show();
			}
		}
		else
		{
			$("#pcpSiteName").hide();
			$("#pcpSite").remove();
		}
	}

	$(document).ready(function(){

		if(pcpActive)
		{
			$("#pcpDoctor").val(pcpActive);
		}
		
		getDoctorSites();
		$("#pcpDoctor").change(function(){
			getDoctorSites();
		});
	});

{/literal}
</script>
