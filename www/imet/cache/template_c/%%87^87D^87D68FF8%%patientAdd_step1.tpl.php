<?php /* Smarty version 2.6.22, created on 2012-04-23 18:59:05
         compiled from patientAdd_step1.tpl */ ?>
<h1>Add new Patient - step 1</h1>

<form method="post" action="">
	<ul class="newPatientForm">
		<li>
			<p class="titleStrong"><?php echo $this->_tpl_vars['questions'][1]; ?>
</p>
			<input type="radio" id="check1" name="gender" value="Male" class="checkbox" <?php if ($this->_tpl_vars['values']['gender'] == 'Male'): ?>checked="checked"<?php endif; ?> />
			<label for="check1">Male</label>
			<input type="radio" id="check2" name="gender" value="Female" class="checkbox" <?php if ($this->_tpl_vars['values']['gender'] == 'Female'): ?>checked="checked"<?php endif; ?> />
			<label for="check2">Female</label>
			<div class="clear"></div>
			<?php if ($this->_tpl_vars['errors']['gender']): ?><p class="errorShort"><?php echo $this->_tpl_vars['errors']['gender']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<p class="titleStrong"><?php echo $this->_tpl_vars['questions'][2]; ?>
</p>
			<input type="text" name="age" value="<?php if ($this->_tpl_vars['values']['age']): ?><?php echo $this->_tpl_vars['values']['age']; ?>
<?php endif; ?>" class="textShort" /> (years)
			<div class="clear"></div>
			<?php if ($this->_tpl_vars['errors']['age']): ?><p class="errorShort"><?php echo $this->_tpl_vars['errors']['age']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<p class="titleStrong" style="padding-bottom:10px"><?php echo $this->_tpl_vars['questions'][3]; ?>
</p><div class="clear"></div>
			<input type="checkbox" id="check3" name="requirements[1]" value="Able to speak English" class="checkbox" <?php if ($this->_tpl_vars['values']['requirements'][1]): ?>checked="checked"<?php endif; ?> />
			<label for="check3">Able to speak English</label>
			<div class="clear"></div>
			<input type="checkbox" id="check4" name="requirements[2]" value="Non-emergency visit" class="checkbox" <?php if ($this->_tpl_vars['values']['requirements'][2]): ?>checked="checked"<?php endif; ?> />
			<label for="check4">Non-emergency visit</label>
			<div class="clear"></div>
			<input type="checkbox" id="check5" name="requirements[3]" value="Medically Stable" class="checkbox" <?php if ($this->_tpl_vars['values']['requirements'][3]): ?>checked="checked"<?php endif; ?> />
			<label for="check5">Medically Stable</label>
			<div class="clear"></div>
			<input type="checkbox" id="check6" name="requirements[4]" value="Emotionally/Psychologically Stable" class="checkbox" <?php if ($this->_tpl_vars['values']['requirements'][4]): ?>checked="checked"<?php endif; ?> />
			<label for="check6">Emotionally/Psychologically Stable</label>
			<div class="clear"></div>
			<input type="checkbox" id="check7" name="requirements[5]" value="Available for post-tests" class="checkbox" <?php if ($this->_tpl_vars['values']['requirements'][5]): ?>checked="checked"<?php endif; ?> />
			<label for="check7">Available for post-tests</label>
			<div class="clear"></div>
			<input type="checkbox" id="check7a" name="requirements[6]" value="None of the Above" class="checkbox" <?php if ($this->_tpl_vars['values']['requirements'][6]): ?>checked="checked"<?php endif; ?> />
			<label for="check7a">None of the Above</label>
			<div class="clear"></div>
			<?php if ($this->_tpl_vars['errors']['requirements']): ?><p class="errorShort"><?php echo $this->_tpl_vars['errors']['requirements']; ?>
</p><?php endif; ?>
		</li>
		<li id="agreement">
			<p class="titleStrong" style="padding-bottom:10px"><?php echo $this->_tpl_vars['questions'][4]; ?>
</p><div class="clear"></div>
			<input type="radio" id="agree_yes" name="agreement" value="Yes" class="checkbox" <?php if ($this->_tpl_vars['values']['agreement'] == 'Yes'): ?>checked="checked"<?php endif; ?> />
			<label for="agree_yes">Yes</label>
			<input type="radio" id="agree_no" name="agreement" value="No" class="checkbox" <?php if ($this->_tpl_vars['values']['agreement'] == 'No'): ?>checked="checked"<?php endif; ?> />
			<label for="agree_no">No</label>
			<div class="clear"></div>
			<?php if ($this->_tpl_vars['errors']['agreement']): ?><p class="errorShort"><?php echo $this->_tpl_vars['errors']['agreement']; ?>
</p><?php endif; ?>
		</li>
		
		
		<li id="refusal"<?php if ($this->_tpl_vars['showRefusal']): ?> style="display:block"<?php endif; ?>>
			<p class="titleStrong" style="padding-bottom:10px"><?php echo $this->_tpl_vars['questions'][5]; ?>
</p><div class="clear"></div>
			<input type="radio" id="check8" name="refusal" value="No time" class="checkbox" <?php if ($this->_tpl_vars['values']['refusal'] == 'No time'): ?>checked="checked"<?php endif; ?> />
			<label for="check8">No time</label>
			<div class="clear"></div>
			<input type="radio" id="check9" name="refusal" value="Not interested" class="checkbox" <?php if ($this->_tpl_vars['values']['refusal'] == 'Not interested'): ?>checked="checked"<?php endif; ?> />
			<label for="check9">Not interested</label>
			<div class="clear"></div>
			<input type="radio" id="check10" name="refusal" value="Not feeling well" class="checkbox" <?php if ($this->_tpl_vars['values']['refusal'] == 'Not feeling well'): ?>checked="checked"<?php endif; ?> />
			<label for="check10">Not feeling well</label>
			<div class="clear"></div>
			<input type="radio" id="check11" name="refusal" value="Parent refused" class="checkbox" <?php if ($this->_tpl_vars['values']['refusal'] == 'Parent refused'): ?>checked="checked"<?php endif; ?> />
			<label for="check11">Parent refused</label>
			<div class="clear"></div>
			<input type="radio" id="check12" name="refusal" value="Other" class="checkbox" <?php if ($this->_tpl_vars['values']['refusal'] == 'Other'): ?>checked="checked"<?php endif; ?> />
			<label for="check12">Other</label>
			<input type="text" name="refusal_other" value="<?php if ($this->_tpl_vars['values']['refusal_txt']): ?><?php echo $this->_tpl_vars['values']['refusal_txt']; ?>
<?php endif; ?>" class="text" />
			<div class="clear"></div>
			<input type="radio" id="check13" name="refusal" value="No reason given" class="checkbox" <?php if ($this->_tpl_vars['values']['refusal'] == 'No reason given'): ?>checked="checked"<?php endif; ?> />
			<label for="check13">No reason given</label>
			<div class="clear"></div>
			<?php if ($this->_tpl_vars['errors']['refusal']): ?><p class="errorShort"><?php echo $this->_tpl_vars['errors']['refusal']; ?>
</p><?php endif; ?>
		</li>
		
		
		<li>
			<p class="titleStrong" style="padding-bottom:10px"><?php echo $this->_tpl_vars['questions'][13]; ?>
</p><div class="clear"></div>
			<input type="radio" name="assent" id="assent_yes" value="Yes" class="checkbox" <?php if ($this->_tpl_vars['values']['assent'] == 'Yes'): ?>checked="checked"<?php endif; ?> />
			<label for="assent_yes">Yes</label>
			<input type="radio" name="assent" id="assent_no" value="No" class="checkbox" <?php if ($this->_tpl_vars['values']['assent'] == 'No'): ?>checked="checked"<?php endif; ?> />
			<label for="assent_no">No</label>
			<div class="clear"></div>
			<?php if ($this->_tpl_vars['errors']['assent']): ?><p class="errorShort"><?php echo $this->_tpl_vars['errors']['assent']; ?>
</p><?php endif; ?>
		</li>
		
		
	</ul>
	<ul class="newPatientForm newPatientFormRight">
		<li>
			<p class="title"><strong>1.</strong> <?php echo $this->_tpl_vars['questions'][6]; ?>
</p>
			<input type="radio" id="check14" name="attend_school" value="Yes" class="checkbox" <?php if ($this->_tpl_vars['values']['attend_school'] == 'Yes'): ?>checked="checked"<?php endif; ?> />
			<label for="check14">Yes</label>
			<input type="radio" id="check15" name="attend_school" value="No" class="checkbox" <?php if ($this->_tpl_vars['values']['attend_school'] == 'No'): ?>checked="checked"<?php endif; ?> />
			<label for="check15">No</label>
			<input type="radio" id="check15a" name="attend_school" value="Unknown" class="checkbox" <?php if ($this->_tpl_vars['values']['attend_school'] == 'Unknown'): ?>checked="checked"<?php endif; ?> />
			<label for="check15a">Unknown</label>
			<div class="clear"></div>
			<?php if ($this->_tpl_vars['errors']['attend_school']): ?><p class="errorShort"><?php echo $this->_tpl_vars['errors']['attend_school']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<p class="title"><strong>2.</strong> <?php echo $this->_tpl_vars['questions'][7]; ?>
</p>
			<input type="radio" id="check16" name="school_grade" value="5th grade" class="checkbox" <?php if ($this->_tpl_vars['values']['school_grade'] == '5th grade'): ?>checked="checked"<?php endif; ?> />
			<label for="check16">5th grade</label>
			<input type="radio" id="check17" name="school_grade" value="9th grade" class="checkbox" <?php if ($this->_tpl_vars['values']['school_grade'] == '9th grade'): ?>checked="checked"<?php endif; ?> />
			<label for="check17">9th grade</label>
			<div class="clear"></div>
			<input type="radio" id="check18" name="school_grade" value="6th grade" class="checkbox" <?php if ($this->_tpl_vars['values']['school_grade'] == '6th grade'): ?>checked="checked"<?php endif; ?> />
			<label for="check18">6th grade</label>
			<input type="radio" id="check19" name="school_grade" value="10th grade" class="checkbox" <?php if ($this->_tpl_vars['values']['school_grade'] == '10th grade'): ?>checked="checked"<?php endif; ?> />
			<label for="check19">10th grade</label>
			<div class="clear"></div>
			<input type="radio" id="check20" name="school_grade" value="7th grade" class="checkbox" <?php if ($this->_tpl_vars['values']['school_grade'] == '7th grade'): ?>checked="checked"<?php endif; ?> />
			<label for="check20">7th grade</label>
			<input type="radio" id="check21" name="school_grade" value="11th grade" class="checkbox" <?php if ($this->_tpl_vars['values']['school_grade'] == '11th grade'): ?>checked="checked"<?php endif; ?> />
			<label for="check21">11th grade</label>
			<div class="clear"></div>
			<input type="radio" id="check22" name="school_grade" value="8th grade" class="checkbox" <?php if ($this->_tpl_vars['values']['school_grade'] == '8th grade'): ?>checked="checked"<?php endif; ?> />
			<label for="check22">8th grade</label>
			<input type="radio" id="check23" name="school_grade" value="12th grade" class="checkbox" <?php if ($this->_tpl_vars['values']['school_grade'] == '12th grade'): ?>checked="checked"<?php endif; ?> />
			<label for="check23">12th grade</label>
			<div class="clear"></div>
			<input type="radio" id="check24" name="school_grade" value="College or trade program" class="checkbox" <?php if ($this->_tpl_vars['values']['school_grade'] == 'College or trade program'): ?>checked="checked"<?php endif; ?> />
			<label for="check24">College or trade program</label>
			<div class="clear"></div>
			<input type="radio" id="check25" name="school_grade" value="Ungraded program" class="checkbox" <?php if ($this->_tpl_vars['values']['school_grade'] == 'Ungraded program'): ?>checked="checked"<?php endif; ?> />
			<label for="check25">Ungraded program</label>
			<div class="clear"></div>
			<input type="radio" id="check25a" name="school_grade" value="Unknown" class="checkbox" <?php if ($this->_tpl_vars['values']['school_grade'] == 'Unknown'): ?>checked="checked"<?php endif; ?> />
			<label for="check25a">Unknown</label>
			<div class="clear"></div>
			<?php if ($this->_tpl_vars['errors']['school_grade']): ?><p class="errorShort"><?php echo $this->_tpl_vars['errors']['school_grade']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<p class="title"><strong>3.</strong> <?php echo $this->_tpl_vars['questions'][8]; ?>
</p>
			<input type="radio" id="check26" name="parents" value="One" class="checkbox" <?php if ($this->_tpl_vars['values']['parents'] == 'One'): ?>checked="checked"<?php endif; ?> />
			<label for="check26">One</label>
			<input type="radio" id="check27" name="parents" value="Two (or more)" class="checkbox" <?php if ($this->_tpl_vars['values']['parents'] == 'Two (or more)'): ?>checked="checked"<?php endif; ?> />
			<label for="check27">Two (or more)</label>
			<input type="radio" id="check28" name="parents" value="None/foster care" class="checkbox" <?php if ($this->_tpl_vars['values']['parents'] == 'None/foster care'): ?>checked="checked"<?php endif; ?> />
			<label for="check28">None/foster care</label>
			<div class="clear"></div>
			<input type="radio" id="check28a" name="parents" value="Unknown" class="checkbox" <?php if ($this->_tpl_vars['values']['parents'] == 'Unknown'): ?>checked="checked"<?php endif; ?> />
			<label for="check28a">Unknown</label>
			<div class="clear"></div>
			<?php if ($this->_tpl_vars['errors']['parents']): ?><p class="errorShort"><?php echo $this->_tpl_vars['errors']['parents']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<p class="title"><strong>4.</strong> <?php echo $this->_tpl_vars['questions'][9]; ?>
</p>
			<input type="radio" id="check29" name="parents_level" value="High school graduate or GED, but no college." class="checkbox" <?php if ($this->_tpl_vars['values']['parents_level'] == 'High school graduate or GED, but no college.'): ?>checked="checked"<?php endif; ?> />
			<label for="check29">High school graduate or GED, but no college.</label>
			<div class="clear"></div>
			<input type="radio" id="check30" name="parents_level" value="Some college, but did not graduate" class="checkbox" <?php if ($this->_tpl_vars['values']['parents_level'] == 'Some college, but did not graduate'): ?>checked="checked"<?php endif; ?> />
			<label for="check30">Some college, but did not graduate</label>
			<div class="clear"></div>
			<input type="radio" id="check31" name="parents_level" value="Graduated college or university" class="checkbox" <?php if ($this->_tpl_vars['values']['parents_level'] == 'Graduated college or university'): ?>checked="checked"<?php endif; ?> />
			<label for="check31">Graduated college or university</label>
			<div class="clear"></div>
			<input type="radio" id="check32" name="parents_level" value="Professional degree beyond four year college" class="checkbox" <?php if ($this->_tpl_vars['values']['parents_level'] == 'Professional degree beyond four year college'): ?>checked="checked"<?php endif; ?> />
			<label for="check32">Professional degree beyond four year college</label>
			<div class="clear"></div>
			<input type="radio" id="check33" name="parents_level" value="Don't know" class="checkbox" <?php if ($this->_tpl_vars['values']['parents_level'] == "Don\'t know"): ?>checked="checked"<?php endif; ?> />
			<label for="check33">Don't know</label>
			<div class="clear"></div>
			<input type="radio" id="check33a" name="parents_level" value="Unknown" class="checkbox" <?php if ($this->_tpl_vars['values']['parents_level'] == 'Unknown'): ?>checked="checked"<?php endif; ?> />
			<label for="check33a">Unknown</label>
			<div class="clear"></div>
			<?php if ($this->_tpl_vars['errors']['parents_level']): ?><p class="errorShort"><?php echo $this->_tpl_vars['errors']['parents_level']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<p class="title"><strong>5.</strong> <?php echo $this->_tpl_vars['questions'][10]; ?>
</p>
			<input type="radio" id="check34" name="latino" value="Yes" class="checkbox" <?php if ($this->_tpl_vars['values']['latino'] == 'Yes'): ?>checked="checked"<?php endif; ?> />
			<label for="check34">Yes</label>
			<input type="radio" id="check35" name="latino" value="No" class="checkbox" <?php if ($this->_tpl_vars['values']['latino'] == 'No'): ?>checked="checked"<?php endif; ?> />
			<label for="check35">No</label>
			<input type="radio" id="check35a" name="latino" value="Unknown" class="checkbox" <?php if ($this->_tpl_vars['values']['latino'] == 'Unknown'): ?>checked="checked"<?php endif; ?> />
			<label for="check35a">Unknown</label>
			<div class="clear"></div>
			<?php if ($this->_tpl_vars['errors']['latino']): ?><p class="errorShort"><?php echo $this->_tpl_vars['errors']['latino']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<p class="title"><strong>6.</strong> <?php echo $this->_tpl_vars['questions'][11]; ?>
</p>
			<input type="checkbox" id="check36" name="race[1]" value="American Indian or Alaska Native" class="checkbox" <?php if ($this->_tpl_vars['values']['race'][1]): ?>checked="checked"<?php endif; ?> />
			<label for="check36">American Indian or Alaska Native</label>
			<div class="clear"></div>
			<input type="checkbox" id="check37" name="race[2]" value="Asian" class="checkbox" <?php if ($this->_tpl_vars['values']['race'][2]): ?>checked="checked"<?php endif; ?> />
			<label for="check37">Asian</label>
			<div class="clear"></div>
			<input type="checkbox" id="check38" name="race[3]" value="Black or African American" class="checkbox" <?php if ($this->_tpl_vars['values']['race'][3]): ?>checked="checked"<?php endif; ?> />
			<label for="check38">Black or African American</label>
			<div class="clear"></div>
			<input type="checkbox" id="check39" name="race[4]" value="Native Hawaiian or Other Pacific Islander" class="checkbox" <?php if ($this->_tpl_vars['values']['race'][4]): ?>checked="checked"<?php endif; ?> />
			<label for="check39">Native Hawaiian or Other Pacific Islander</label>
			<div class="clear"></div>
			<input type="checkbox" id="check40" name="race[5]" value="White" class="checkbox" <?php if ($this->_tpl_vars['values']['race'][5]): ?>checked="checked"<?php endif; ?> />
			<label for="check40">White</label>
			<div class="clear"></div>
			<input type="checkbox" id="check41" name="race[6]" value="Other" class="checkbox" <?php if ($this->_tpl_vars['values']['race'][6]): ?>checked="checked"<?php endif; ?> />
			<label for="check41">Other</label>
			<div class="clear"></div>
			<input type="checkbox" id="check41a" name="race[7]" value="Unknown" class="checkbox" <?php if ($this->_tpl_vars['values']['race'][7]): ?>checked="checked"<?php endif; ?> />
			<label for="check41a">Unknown</label>
			<div class="clear"></div>
			<?php if ($this->_tpl_vars['errors']['race']): ?><p class="errorShort"><?php echo $this->_tpl_vars['errors']['race']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<p class="title"><strong>7.</strong> <?php echo $this->_tpl_vars['questions'][12]; ?>
</p>
			<input type="radio" id="check42" name="may_use" value="Yes" class="checkbox" <?php if ($this->_tpl_vars['values']['may_use'] == 'Yes'): ?>checked="checked"<?php endif; ?> />
			<label for="check42">Yes</label>
			<input type="radio" id="check43" name="may_use" value="No" class="checkbox" <?php if ($this->_tpl_vars['values']['may_use'] == 'No'): ?>checked="checked"<?php endif; ?> />
			<label for="check43">No</label>
			<input type="radio" id="check43a" name="may_use" value="Unknown" class="checkbox" <?php if ($this->_tpl_vars['values']['may_use'] == 'Unknown'): ?>checked="checked"<?php endif; ?> />
			<label for="check43a">Unknown</label>
			<div class="clear"></div>
			<?php if ($this->_tpl_vars['errors']['may_use']): ?><p class="errorShort"><?php echo $this->_tpl_vars['errors']['may_use']; ?>
</p><?php endif; ?>
		</li>
	</ul>
	<div class="clear"></div>
	<div>
		<br />
		<a class="newPatientBack" href="<?php echo $this->_tpl_vars['backHref']; ?>
">back</a>
		<input type="submit" name="nextStep" value="next" class="newPatientFormSubmit" />
		<div class="clear"></div>
	</div>
</form>