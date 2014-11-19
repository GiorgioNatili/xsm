<ul>

	{foreach from=$tool.answers item=answer}
	
		<li>{$answer}</li>
	
	{/foreach}
	
</ul>

{if $tool.extra}
	<br />
	<p><b>Is there anything you'd like to add?</b></p>
	<p>{$tool.extra}</p>
{/if}