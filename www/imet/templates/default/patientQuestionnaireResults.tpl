<h1>Questionnaire results - {$patient.first_name} {$patient.middle_name} {$patient.last_name}</h1>

<div class="bttnCont">
	<a href="{$backHref}">Back to Patient information page</a>
	<div class="clear"></div>
</div>

{if count($results) > 0}

	<ol class="questionnaire">
		{foreach from=$results item=item name=results}
			<li>
				<strong>{$item.question}</strong>
				<ul>
					{foreach from=$item.answers item=answer}
						<li>{$answer}</li>
					{/foreach}
				</ul>
			</li>
		{/foreach}
	</ol>

{else}

	<p>{$lang.no_questionnaire}</p>

{/if}