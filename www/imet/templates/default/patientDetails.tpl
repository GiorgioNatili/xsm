<h1>Patient details - {$patient.first_name} {$patient.middle_name} {$patient.last_name}</h1>

<div class="bttnCont">
	<a href="{$backHref}">Back to Patient information page</a>
	<div class="clear"></div>
</div>

<ul class="newPatientForm smallPadding">
	<li>
		<p class="title2">Personal Information</p>
	</li>
	<li>
		<label class="label">First Name</label>
		<p class="field">{$patient.first_name}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Middle Name</label>
		<p class="field">{$patient.middle_name}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Last Name</label>
		<p class="field">{$patient.last_name}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Medical Record</label>
		<p class="field">{$patient.medical_record}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Sex</label>
		<p class="field">{$patient.sex}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Date of Birth</label>
		<p class="field">{$patient.dob}</p>
		<div class="clear"></div>
	</li>
	<li>
		<p class="title2">Contact Information</p>
	</li>
	<li>
		<label class="label">Email</label>
		<p class="field">{$patient.email}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Home Number</label>
		<p class="field">{$patient.phone}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Cell</label>
		<p class="field">{$patient.cell}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Home</label>
		<p class="field">{$patient.home}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Parent</label>
		<p class="field">{$patient.parent}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Alternate</label>
		<p class="field">{$patient.alternate}</p>
		<div class="clear"></div>
	</li>
	<li>
		<p class="title3">Address</p>
	</li>
	<li>
		<label class="label">Street</label>
		<p class="field">{$patient.address}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">City</label>
		<p class="field">{$patient.city}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">State</label>
		<p class="field">{$patient.state}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Zip</label>
		<p class="field">{$patient.zip}</p>
		<div class="clear"></div>
	</li>
</ul>
<ul class="newPatientForm newPatientFormRight2 smallPadding">
	<li>
		<p class="title2">Alternate Contact </p>
	</li>
	<li>
		<label class="label">Name</label>
		<p class="field">{$patient.alternate_name}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Email</label>
		<p class="field">{$patient.alternate_email}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Phone</label>
		<p class="field">{$patient.alternate_phone}</p>
		<div class="clear"></div>
	</li>
	<li>
		<p class="title3">Address</p>
	</li>
	<li>
		<label class="label">Street 1</label>
		<p class="field">{$patient.alternate_address}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">City</label>
		<p class="field">{$patient.alternate_city}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">State</label>
		<p class="field">{$patient.alternate_state}</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Zip</label>
		<p class="field">{$patient.alternate_zip}</p>
		<div class="clear"></div>
	</li>
</ul>
