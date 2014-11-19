<?php /* Smarty version 2.6.22, created on 2012-05-15 13:32:18
         compiled from patientDetails.tpl */ ?>
<h1>Patient details - <?php echo $this->_tpl_vars['patient']['first_name']; ?>
 <?php echo $this->_tpl_vars['patient']['middle_name']; ?>
 <?php echo $this->_tpl_vars['patient']['last_name']; ?>
</h1>

<div class="bttnCont">
	<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back to Patient information page</a>
	<div class="clear"></div>
</div>

<ul class="newPatientForm smallPadding">
	<li>
		<p class="title2">Personal Information</p>
	</li>
	<li>
		<label class="label">First Name</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['first_name']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Middle Name</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['middle_name']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Last Name</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['last_name']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Medical Record</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['medical_record']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Sex</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['sex']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Date of Birth</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['dob']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<p class="title2">Contact Information</p>
	</li>
	<li>
		<label class="label">Email</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['email']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Home Number</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['phone']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Cell</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['cell']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Home</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['home']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Parent</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['parent']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Alternate</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['alternate']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<p class="title3">Address</p>
	</li>
	<li>
		<label class="label">Street</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['address']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">City</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['city']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">State</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['state']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Zip</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['zip']; ?>
</p>
		<div class="clear"></div>
	</li>
</ul>
<ul class="newPatientForm newPatientFormRight2 smallPadding">
	<li>
		<p class="title2">Alternate Contact </p>
	</li>
	<li>
		<label class="label">Name</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['alternate_name']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Email</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['alternate_email']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Phone</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['alternate_phone']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<p class="title3">Address</p>
	</li>
	<li>
		<label class="label">Street 1</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['alternate_address']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">City</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['alternate_city']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">State</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['alternate_state']; ?>
</p>
		<div class="clear"></div>
	</li>
	<li>
		<label class="label">Zip</label>
		<p class="field"><?php echo $this->_tpl_vars['patient']['alternate_zip']; ?>
</p>
		<div class="clear"></div>
	</li>
</ul>