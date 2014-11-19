<h1>{$page->title}</h1>

<div class="patientInformationPage">
	<div class="cont">
		{$page->body}
		<div>
			<br />
			<a class="newPatientBack" href="{$backHref}">back</a>
			<form method="post" action=""><ins><input type="submit" name="nextStep" value="next" class="newPatientFormSubmit" /></ins></form>
			<div class="clear"></div>
		</div>
	</div>
</div><!--patientInformationPage-->
