<?php /* Smarty version 2.6.22, created on 2012-04-23 18:59:32
         compiled from patientAdd_step2.tpl */ ?>
<h1>Add new Patient - step 2</h1>

<?php echo $this->_tpl_vars['form']['open']; ?>

	<ul class="newPatientForm smallPadding">
		<li>
			<p class="title2">Personal Information</p>
		</li>
		<li>
			<label class="label">* First Name</label>
			<?php echo $this->_tpl_vars['form']['fields']['firstname']['field']; ?>

			<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['firstname']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['firstname']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<label class="label">Middle Name</label>
			<?php echo $this->_tpl_vars['form']['fields']['middlename']['field']; ?>

			<div class="clear"></div>
		</li>
		<li>
			<label class="label">* Last Name</label>
			<?php echo $this->_tpl_vars['form']['fields']['lastname']['field']; ?>

			<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['lastname']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['lastname']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<label class="label">* Medical Record</label>
			<?php echo $this->_tpl_vars['form']['fields']['medical_record']['field']; ?>

			<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['medical_record']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['medical_record']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<label class="label">* Sex</label>
			<?php echo $this->_tpl_vars['form']['fields']['sex']['field']; ?>

			<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['sex']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['sex']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<label class="label">* Date of Birth</label>
			<?php echo $this->_tpl_vars['form']['fields']['dob']['field']; ?>

			<div class="clear"></div>
			<p class="info">DD / MM / YYYY</p>
			<?php if ($this->_tpl_vars['form']['fields']['dob']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['dob']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<label class="label">* Clinician 1</label>
			<?php echo $this->_tpl_vars['form']['fields']['clinician']['field']; ?>

			<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['clinician']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['clinician']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<label class="label">Clinician 2</label>
			<?php echo $this->_tpl_vars['form']['fields']['clinician2']['field']; ?>

			<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['clinician2']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['clinician2']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<p class="title2">Contact Information</p>
		</li>
		<li>
			<label class="label">* Email</label>
			<?php echo $this->_tpl_vars['form']['fields']['email']['field']; ?>

			<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['email']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['email']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<label class="label">Email</label>
			<?php echo $this->_tpl_vars['form']['fields']['email2']['field']; ?>

		</li>
		<li>
			<label class="label">Home Number</label>
			<?php echo $this->_tpl_vars['form']['fields']['phone']['field']; ?>

			<div class="clear"></div>
		</li>
		<li>
			<label class="label">* Cell</label>
			<?php echo $this->_tpl_vars['form']['fields']['cell']['field']; ?>

			<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['cell']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['cell']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<label class="label">Parent</label>
			<?php echo $this->_tpl_vars['form']['fields']['parent']['field']; ?>

			<div class="clear"></div>
		</li>
		<li>
			<label class="label">Alternate</label>
			<?php echo $this->_tpl_vars['form']['fields']['alternate']['field']; ?>

			<div class="clear"></div>
		</li>
		<li>
			<p class="title3">Address</p>
		</li>
		<li>
			<label class="label">* Address</label>
			<?php echo $this->_tpl_vars['form']['fields']['address_1']['field']; ?>

			<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['address_1']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['address_1']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<label class="label">Apt./Suite</label>
			<?php echo $this->_tpl_vars['form']['fields']['address_2']['field']; ?>

			<div class="clear"></div>
		</li>
		<li>
			<label class="label">* City</label>
			<?php echo $this->_tpl_vars['form']['fields']['city']['field']; ?>

			<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['city']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['city']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<label class="label">* State</label>
			<?php echo $this->_tpl_vars['form']['fields']['state']['field']; ?>

			<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['state']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['state']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<label class="label">* Zip</label>
			<?php echo $this->_tpl_vars['form']['fields']['zip']['field']; ?>

			<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['zip']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['zip']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<br /><?php echo $this->_tpl_vars['lang']['pole_oznaczone_sa_obowiazkowe']; ?>

		</li>
	</ul>
	<ul class="newPatientForm newPatientFormRight2 smallPadding">
		<li>
			<p class="title2">Alternate Contact </p>
		</li>
		<li>
			<label class="label">Name</label>
			<?php echo $this->_tpl_vars['form']['fields']['alternate_name']['field']; ?>

			<div class="clear"></div>
		</li>
		<li>
			<label class="label">Email</label>
			<?php echo $this->_tpl_vars['form']['fields']['alternate_email']['field']; ?>

			<div class="clear"></div>
			<?php if ($this->_tpl_vars['form']['fields']['alternate_email']['errMsg']): ?><p class="error"><?php echo $this->_tpl_vars['form']['fields']['alternate_email']['errMsg']; ?>
</p><?php endif; ?>
		</li>
		<li>
			<label class="label">Phone</label>
			<?php echo $this->_tpl_vars['form']['fields']['alternate_phone']['field']; ?>

			<div class="clear"></div>
		</li>
		<li>
			<p class="title3">Address</p>
		</li>
		<li>
			<label class="label">Address</label>
			<?php echo $this->_tpl_vars['form']['fields']['alternate_address_1']['field']; ?>

			<div class="clear"></div>
		</li>
		<li>
			<label class="label">Apt./Suite</label>
			<?php echo $this->_tpl_vars['form']['fields']['alternate_address_2']['field']; ?>

			<div class="clear"></div>
		</li>
		<li>
			<label class="label">City</label>
			<?php echo $this->_tpl_vars['form']['fields']['alternate_city']['field']; ?>

			<div class="clear"></div>
		</li>
		<li>
			<label class="label">State</label>
			<?php echo $this->_tpl_vars['form']['fields']['alternate_state']['field']; ?>

			<div class="clear"></div>
		</li>
		<li>
			<label class="label">Zip</label>
			<?php echo $this->_tpl_vars['form']['fields']['alternate_zip']['field']; ?>

			<div class="clear"></div>
		</li>
		<li>
			<p class="title2">Site</p>
		</li>
		<?php if (count ( $this->_tpl_vars['doctorsSites'] )): ?>
			<li>
				<label class="label">* PCP Doctor</label>
				<select class="select2" name="pcpDoctor" id="pcpDoctor"<?php if ($this->_tpl_vars['doctorsSitesError']): ?> style="border:1px solid red;"<?php endif; ?>>
					<?php $_from = $this->_tpl_vars['doctorsSites']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['doctorsSites'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['doctorsSites']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['idDoctor'] => $this->_tpl_vars['doctor']):
        $this->_foreach['doctorsSites']['iteration']++;
?>
						<option value="<?php echo $this->_tpl_vars['idDoctor']; ?>
"><?php echo $this->_tpl_vars['doctor']['fullname']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
				<div class="clear"></div>
				<?php if ($this->_tpl_vars['doctorsSitesError']): ?><p class="error">This is a required field.</p><?php endif; ?>
			</li>
			<li id="pcpSiteName">
				<label class="label">* Site name</label>
			</li>
		<?php else: ?>
			<li>
				<label class="label">* Site name</label>
				<?php echo $this->_tpl_vars['form']['fields']['site']['field']; ?>

				<div class="clear"></div>
			</li>
		<?php endif; ?>
	</ul>
	<div class="clear"></div>
	<div>
		<br />
		<a class="newPatientBack" href="<?php echo $this->_tpl_vars['backHref']; ?>
">back</a>
		<input type="submit" name="nextStep" value="next" class="newPatientFormSubmit" />
		<div class="clear"></div>
	</div>
<?php echo $this->_tpl_vars['form']['close']; ?>


<script type="text/javascript">

	var pcpDoctorSites = new Array();
	var pcpActive = 0;
	var siteActive = 0;
	
	<?php $_from = $this->_tpl_vars['doctorsSites']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['doctorsSites'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['doctorsSites']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['idDoctor'] => $this->_tpl_vars['doctor']):
        $this->_foreach['doctorsSites']['iteration']++;
?>

		<?php if ($this->_tpl_vars['doctor']['active']): ?>pcpActive=<?php echo $this->_tpl_vars['idDoctor']; ?>
;<?php endif; ?>
	
		pcpDoctorSites[<?php echo $this->_tpl_vars['idDoctor']; ?>
] = new Array();
		<?php $_from = $this->_tpl_vars['doctor']['sites']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			pcpDoctorSites[<?php echo $this->_tpl_vars['idDoctor']; ?>
][<?php echo $this->_tpl_vars['item']['id']; ?>
] = "<?php echo $this->_tpl_vars['item']['name']; ?>
";

			<?php if ($this->_tpl_vars['item']['active']): ?>siteActive=<?php echo $this->_tpl_vars['item']['id']; ?>
;<?php endif; ?>
			
		<?php endforeach; endif; unset($_from); ?>
	<?php endforeach; endif; unset($_from); ?>

<?php echo '
	function getDoctorSites()
	{
		var id_doctor = parseInt($("#pcpDoctor").val());

		if(id_doctor)
		{
			if(pcpDoctorSites[id_doctor])
			{
				var innerHTML = \'<select class="select2" name="pcpSite" id="pcpSite">\';
				for(i in pcpDoctorSites[id_doctor])
				{
					if(parseInt(i))
					{
						selected = \'\';
						if(siteActive == i)
						{
							selected=\'selected="selected"\';
						}
						innerHTML += \'<option \' + selected + \' value="\' + i + \'">\' + pcpDoctorSites[id_doctor][i] + \'</option>\';
					}
				}

				innerHTML += \'</select>\';
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

'; ?>

</script>