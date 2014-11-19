<?php /* Smarty version 2.6.22, created on 2012-04-23 19:01:43
         compiled from patientAdd_step4.tpl */ ?>
<h1><?php echo $this->_tpl_vars['page']->title; ?>
</h1>

<div class="patientInformationPage">
	<div class="cont">
		<?php echo $this->_tpl_vars['page']->body; ?>

		<div>
			<br />
			<a class="newPatientBack" href="<?php echo $this->_tpl_vars['backHref']; ?>
">back</a>
			<form method="post" action=""><ins><input type="submit" name="nextStep" value="next" class="newPatientFormSubmit" /></ins></form>
			<div class="clear"></div>
		</div>
	</div>
</div><!--patientInformationPage-->