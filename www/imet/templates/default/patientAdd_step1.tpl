<h1>Add new Patient - step 1</h1>

<form method="post" action="">
	<ul class="newPatientForm">
		<li>
			<p class="titleStrong">{$questions[1]}</p>
			<input type="radio" id="check1" name="gender" value="Male" class="checkbox" {if $values.gender == 'Male'}checked="checked"{/if} />
			<label for="check1">Male</label>
			<input type="radio" id="check2" name="gender" value="Female" class="checkbox" {if $values.gender == 'Female'}checked="checked"{/if} />
			<label for="check2">Female</label>
			<div class="clear"></div>
			{if $errors.gender}<p class="errorShort">{$errors.gender}</p>{/if}
		</li>
		<li>
			<p class="titleStrong">{$questions[2]}</p>
			<input type="text" name="age" value="{if $values.age}{$values.age}{/if}" class="textShort" /> (years)
			<div class="clear"></div>
			{if $errors.age}<p class="errorShort">{$errors.age}</p>{/if}
		</li>
		<li>
			<p class="titleStrong" style="padding-bottom:10px">{$questions[3]}</p><div class="clear"></div>
			<input type="checkbox" id="check3" name="requirements[1]" value="Able to speak English" class="checkbox" {if $values.requirements[1]}checked="checked"{/if} />
			<label for="check3">Able to speak English</label>
			<div class="clear"></div>
			<input type="checkbox" id="check4" name="requirements[2]" value="Non-emergency visit" class="checkbox" {if $values.requirements[2]}checked="checked"{/if} />
			<label for="check4">Non-emergency visit</label>
			<div class="clear"></div>
			<input type="checkbox" id="check5" name="requirements[3]" value="Medically Stable" class="checkbox" {if $values.requirements[3]}checked="checked"{/if} />
			<label for="check5">Medically Stable</label>
			<div class="clear"></div>
			<input type="checkbox" id="check6" name="requirements[4]" value="Emotionally/Psychologically Stable" class="checkbox" {if $values.requirements[4]}checked="checked"{/if} />
			<label for="check6">Emotionally/Psychologically Stable</label>
			<div class="clear"></div>
			<input type="checkbox" id="check7" name="requirements[5]" value="Available for post-tests" class="checkbox" {if $values.requirements[5]}checked="checked"{/if} />
			<label for="check7">Available for post-tests</label>
			<div class="clear"></div>
			<input type="checkbox" id="check7a" name="requirements[6]" value="None of the Above" class="checkbox" {if $values.requirements[6]}checked="checked"{/if} />
			<label for="check7a">None of the Above</label>
			<div class="clear"></div>
			{if $errors.requirements}<p class="errorShort">{$errors.requirements}</p>{/if}
		</li>
		<li id="agreement">
			<p class="titleStrong" style="padding-bottom:10px">{$questions[4]}</p><div class="clear"></div>
			<input type="radio" id="agree_yes" name="agreement" value="Yes" class="checkbox" {if $values.agreement == 'Yes'}checked="checked"{/if} />
			<label for="agree_yes">Yes</label>
			<input type="radio" id="agree_no" name="agreement" value="No" class="checkbox" {if $values.agreement == 'No'}checked="checked"{/if} />
			<label for="agree_no">No</label>
			<div class="clear"></div>
			{if $errors.agreement}<p class="errorShort">{$errors.agreement}</p>{/if}
		</li>
		
		
		<li id="refusal"{if $showRefusal} style="display:block"{/if}>
			<p class="titleStrong" style="padding-bottom:10px">{$questions[5]}</p><div class="clear"></div>
			<input type="radio" id="check8" name="refusal" value="No time" class="checkbox" {if $values.refusal == 'No time'}checked="checked"{/if} />
			<label for="check8">No time</label>
			<div class="clear"></div>
			<input type="radio" id="check9" name="refusal" value="Not interested" class="checkbox" {if $values.refusal == 'Not interested'}checked="checked"{/if} />
			<label for="check9">Not interested</label>
			<div class="clear"></div>
			<input type="radio" id="check10" name="refusal" value="Not feeling well" class="checkbox" {if $values.refusal == 'Not feeling well'}checked="checked"{/if} />
			<label for="check10">Not feeling well</label>
			<div class="clear"></div>
			<input type="radio" id="check11" name="refusal" value="Parent refused" class="checkbox" {if $values.refusal == 'Parent refused'}checked="checked"{/if} />
			<label for="check11">Parent refused</label>
			<div class="clear"></div>
			<input type="radio" id="check12" name="refusal" value="Other" class="checkbox" {if $values.refusal == 'Other'}checked="checked"{/if} />
			<label for="check12">Other</label>
			<input type="text" name="refusal_other" value="{if $values.refusal_txt}{$values.refusal_txt}{/if}" class="text" />
			<div class="clear"></div>
			<input type="radio" id="check13" name="refusal" value="No reason given" class="checkbox" {if $values.refusal == 'No reason given'}checked="checked"{/if} />
			<label for="check13">No reason given</label>
			<div class="clear"></div>
			{if $errors.refusal}<p class="errorShort">{$errors.refusal}</p>{/if}
		</li>
		
		
		<li>
			<p class="titleStrong" style="padding-bottom:10px">{$questions[13]}</p><div class="clear"></div>
			<input type="radio" name="assent" id="assent_yes" value="Yes" class="checkbox" {if $values.assent == 'Yes'}checked="checked"{/if} />
			<label for="assent_yes">Yes</label>
			<input type="radio" name="assent" id="assent_no" value="No" class="checkbox" {if $values.assent == 'No'}checked="checked"{/if} />
			<label for="assent_no">No</label>
			<div class="clear"></div>
			{if $errors.assent}<p class="errorShort">{$errors.assent}</p>{/if}
		</li>
		
		
	</ul>
	<ul class="newPatientForm newPatientFormRight">
		<li>
			<p class="title"><strong>1.</strong> {$questions[6]}</p>
			<input type="radio" id="check14" name="attend_school" value="Yes" class="checkbox" {if $values.attend_school == 'Yes'}checked="checked"{/if} />
			<label for="check14">Yes</label>
			<input type="radio" id="check15" name="attend_school" value="No" class="checkbox" {if $values.attend_school == 'No'}checked="checked"{/if} />
			<label for="check15">No</label>
			<input type="radio" id="check15a" name="attend_school" value="Unknown" class="checkbox" {if $values.attend_school == 'Unknown'}checked="checked"{/if} />
			<label for="check15a">Unknown</label>
			<div class="clear"></div>
			{if $errors.attend_school}<p class="errorShort">{$errors.attend_school}</p>{/if}
		</li>
		<li>
			<p class="title"><strong>2.</strong> {$questions[7]}</p>
			<input type="radio" id="check16" name="school_grade" value="5th grade" class="checkbox" {if $values.school_grade == '5th grade'}checked="checked"{/if} />
			<label for="check16">5th grade</label>
			<input type="radio" id="check17" name="school_grade" value="9th grade" class="checkbox" {if $values.school_grade == '9th grade'}checked="checked"{/if} />
			<label for="check17">9th grade</label>
			<div class="clear"></div>
			<input type="radio" id="check18" name="school_grade" value="6th grade" class="checkbox" {if $values.school_grade == '6th grade'}checked="checked"{/if} />
			<label for="check18">6th grade</label>
			<input type="radio" id="check19" name="school_grade" value="10th grade" class="checkbox" {if $values.school_grade == '10th grade'}checked="checked"{/if} />
			<label for="check19">10th grade</label>
			<div class="clear"></div>
			<input type="radio" id="check20" name="school_grade" value="7th grade" class="checkbox" {if $values.school_grade == '7th grade'}checked="checked"{/if} />
			<label for="check20">7th grade</label>
			<input type="radio" id="check21" name="school_grade" value="11th grade" class="checkbox" {if $values.school_grade == '11th grade'}checked="checked"{/if} />
			<label for="check21">11th grade</label>
			<div class="clear"></div>
			<input type="radio" id="check22" name="school_grade" value="8th grade" class="checkbox" {if $values.school_grade == '8th grade'}checked="checked"{/if} />
			<label for="check22">8th grade</label>
			<input type="radio" id="check23" name="school_grade" value="12th grade" class="checkbox" {if $values.school_grade == '12th grade'}checked="checked"{/if} />
			<label for="check23">12th grade</label>
			<div class="clear"></div>
			<input type="radio" id="check24" name="school_grade" value="College or trade program" class="checkbox" {if $values.school_grade == 'College or trade program'}checked="checked"{/if} />
			<label for="check24">College or trade program</label>
			<div class="clear"></div>
			<input type="radio" id="check25" name="school_grade" value="Ungraded program" class="checkbox" {if $values.school_grade == 'Ungraded program'}checked="checked"{/if} />
			<label for="check25">Ungraded program</label>
			<div class="clear"></div>
			<input type="radio" id="check25a" name="school_grade" value="Unknown" class="checkbox" {if $values.school_grade == 'Unknown'}checked="checked"{/if} />
			<label for="check25a">Unknown</label>
			<div class="clear"></div>
			{if $errors.school_grade}<p class="errorShort">{$errors.school_grade}</p>{/if}
		</li>
		<li>
			<p class="title"><strong>3.</strong> {$questions[8]}</p>
			<input type="radio" id="check26" name="parents" value="One" class="checkbox" {if $values.parents == 'One'}checked="checked"{/if} />
			<label for="check26">One</label>
			<input type="radio" id="check27" name="parents" value="Two (or more)" class="checkbox" {if $values.parents == 'Two (or more)'}checked="checked"{/if} />
			<label for="check27">Two (or more)</label>
			<input type="radio" id="check28" name="parents" value="None/foster care" class="checkbox" {if $values.parents == 'None/foster care'}checked="checked"{/if} />
			<label for="check28">None/foster care</label>
			<div class="clear"></div>
			<input type="radio" id="check28a" name="parents" value="Unknown" class="checkbox" {if $values.parents == 'Unknown'}checked="checked"{/if} />
			<label for="check28a">Unknown</label>
			<div class="clear"></div>
			{if $errors.parents}<p class="errorShort">{$errors.parents}</p>{/if}
		</li>
		<li>
			<p class="title"><strong>4.</strong> {$questions[9]}</p>
			<input type="radio" id="check29" name="parents_level" value="High school graduate or GED, but no college." class="checkbox" {if $values.parents_level == 'High school graduate or GED, but no college.'}checked="checked"{/if} />
			<label for="check29">High school graduate or GED, but no college.</label>
			<div class="clear"></div>
			<input type="radio" id="check30" name="parents_level" value="Some college, but did not graduate" class="checkbox" {if $values.parents_level == 'Some college, but did not graduate'}checked="checked"{/if} />
			<label for="check30">Some college, but did not graduate</label>
			<div class="clear"></div>
			<input type="radio" id="check31" name="parents_level" value="Graduated college or university" class="checkbox" {if $values.parents_level == 'Graduated college or university'}checked="checked"{/if} />
			<label for="check31">Graduated college or university</label>
			<div class="clear"></div>
			<input type="radio" id="check32" name="parents_level" value="Professional degree beyond four year college" class="checkbox" {if $values.parents_level == 'Professional degree beyond four year college'}checked="checked"{/if} />
			<label for="check32">Professional degree beyond four year college</label>
			<div class="clear"></div>
			<input type="radio" id="check33" name="parents_level" value="Don't know" class="checkbox" {if $values.parents_level == "Don\'t know"}checked="checked"{/if} />
			<label for="check33">Don't know</label>
			<div class="clear"></div>
			<input type="radio" id="check33a" name="parents_level" value="Unknown" class="checkbox" {if $values.parents_level == "Unknown"}checked="checked"{/if} />
			<label for="check33a">Unknown</label>
			<div class="clear"></div>
			{if $errors.parents_level}<p class="errorShort">{$errors.parents_level}</p>{/if}
		</li>
		<li>
			<p class="title"><strong>5.</strong> {$questions[10]}</p>
			<input type="radio" id="check34" name="latino" value="Yes" class="checkbox" {if $values.latino == 'Yes'}checked="checked"{/if} />
			<label for="check34">Yes</label>
			<input type="radio" id="check35" name="latino" value="No" class="checkbox" {if $values.latino == 'No'}checked="checked"{/if} />
			<label for="check35">No</label>
			<input type="radio" id="check35a" name="latino" value="Unknown" class="checkbox" {if $values.latino == 'Unknown'}checked="checked"{/if} />
			<label for="check35a">Unknown</label>
			<div class="clear"></div>
			{if $errors.latino}<p class="errorShort">{$errors.latino}</p>{/if}
		</li>
		<li>
			<p class="title"><strong>6.</strong> {$questions[11]}</p>
			<input type="checkbox" id="check36" name="race[1]" value="American Indian or Alaska Native" class="checkbox" {if $values.race[1]}checked="checked"{/if} />
			<label for="check36">American Indian or Alaska Native</label>
			<div class="clear"></div>
			<input type="checkbox" id="check37" name="race[2]" value="Asian" class="checkbox" {if $values.race[2]}checked="checked"{/if} />
			<label for="check37">Asian</label>
			<div class="clear"></div>
			<input type="checkbox" id="check38" name="race[3]" value="Black or African American" class="checkbox" {if $values.race[3]}checked="checked"{/if} />
			<label for="check38">Black or African American</label>
			<div class="clear"></div>
			<input type="checkbox" id="check39" name="race[4]" value="Native Hawaiian or Other Pacific Islander" class="checkbox" {if $values.race[4]}checked="checked"{/if} />
			<label for="check39">Native Hawaiian or Other Pacific Islander</label>
			<div class="clear"></div>
			<input type="checkbox" id="check40" name="race[5]" value="White" class="checkbox" {if $values.race[5]}checked="checked"{/if} />
			<label for="check40">White</label>
			<div class="clear"></div>
			<input type="checkbox" id="check41" name="race[6]" value="Other" class="checkbox" {if $values.race[6]}checked="checked"{/if} />
			<label for="check41">Other</label>
			<div class="clear"></div>
			<input type="checkbox" id="check41a" name="race[7]" value="Unknown" class="checkbox" {if $values.race[7]}checked="checked"{/if} />
			<label for="check41a">Unknown</label>
			<div class="clear"></div>
			{if $errors.race}<p class="errorShort">{$errors.race}</p>{/if}
		</li>
		<li>
			<p class="title"><strong>7.</strong> {$questions[12]}</p>
			<input type="radio" id="check42" name="may_use" value="Yes" class="checkbox" {if $values.may_use == 'Yes'}checked="checked"{/if} />
			<label for="check42">Yes</label>
			<input type="radio" id="check43" name="may_use" value="No" class="checkbox" {if $values.may_use == 'No'}checked="checked"{/if} />
			<label for="check43">No</label>
			<input type="radio" id="check43a" name="may_use" value="Unknown" class="checkbox" {if $values.may_use == 'Unknown'}checked="checked"{/if} />
			<label for="check43a">Unknown</label>
			<div class="clear"></div>
			{if $errors.may_use}<p class="errorShort">{$errors.may_use}</p>{/if}
		</li>
	</ul>
	<div class="clear"></div>
	<div>
		<br />
		<a class="newPatientBack" href="{$backHref}">back</a>
		<input type="submit" name="nextStep" value="next" class="newPatientFormSubmit" />
		<div class="clear"></div>
	</div>
</form>
