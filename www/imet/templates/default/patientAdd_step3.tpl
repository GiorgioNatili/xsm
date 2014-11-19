<h1>Add new Patient - step 3</h1>

<form method="post" action="">
	<div id="preTlfb">
	
		{foreach from=$form item=stimulant key=stimulantID name=stimulants}

			{foreach from=$stimulant.questions item=question name=questions}
				
				<div class="preTlfbBox {if $smarty.foreach.stimulants.iteration%2 == 0}preTlfbBoxOdd{/if} {if ($smarty.foreach.stimulants.first && $smarty.foreach.questions.first) || $question.show}{else}preTlfbBoxHide{/if}">
					<p class="question">
						<strong>{$smarty.foreach.questions.iteration}.</strong> {$question.text}
					</p>
					<div class="answers">
						<input {if $question.selected==1}checked="checked"{/if} type="radio" name="question_{$stimulantID}_{$question.id}" value="1" id="question_{$question.id}_a" /><label for="question_{$question.id}_a">Yes</label>
						<input {if $question.selected==2}checked="checked"{/if} type="radio" name="question_{$stimulantID}_{$question.id}" value="2" id="question_{$question.id}_b" /><label for="question_{$question.id}_b">No</label>
					</div>
				</div>
				
			{/foreach}
			
		{/foreach}

	</div><!--preTlfb-->
	
	<div>
		<br />
		<a class="newPatientBack" href="{$backHref}">back</a>
		<input type="submit" name="nextStep" value="next" class="newPatientFormSubmit" style="display:none" />
		<div class="clear"></div>
	</div>
</form>
