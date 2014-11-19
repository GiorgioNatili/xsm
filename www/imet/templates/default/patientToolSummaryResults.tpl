{if count($tool.answers)}

	<ul>
	
		{foreach from=$tool.answers item=answers key=question}
		
			<li><strong>{$question}</strong>:
				<ul>
					{foreach from=$answers item=answer}
						<li>{$answer}</li>
					{/foreach}
				</ul>
			</li>
		
		{/foreach}
		
	</ul>
	
	{if $tool.extra}
		<br />
		<p><b>Is there anything you'd like to add?</b></p>
		<p>{$tool.extra}</p>
	{/if}
	
{else}

	Empty

{/if}