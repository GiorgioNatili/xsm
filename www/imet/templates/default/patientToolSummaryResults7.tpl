{if count($tool.answers.new)}

	{if count($tool.answers.new) && count($tool.answers.old)}
		<p><strong>NEW ANSWERS</strong><br />&nbsp;</p>
	{/if}

	<ul>
	
		{foreach from=$tool.answers.new item=answers key=question}
		
			<li><strong>{$question}</strong>:
				<ul>
					{foreach from=$answers item=answer}
						<li>{$answer}</li>
					{/foreach}
				</ul>
			</li>
		
		{/foreach}
		
	</ul>
	
	{if count($tool.answers.new) && count($tool.answers.old)}
		<p><br /><strong>OLD ANSWERS</strong><br />&nbsp;</p>
		
		<ul>
	
			{foreach from=$tool.answers.old item=answers key=question}
			
				<li><strong>{$question}</strong>:
					<ul>
						{foreach from=$answers item=answer}
							<li>{$answer}</li>
						{/foreach}
					</ul>
				</li>
			
			{/foreach}
			
		</ul>
	{/if}
	
	{if $tool.extra}
		<br />
		<p><b>Is there anything you'd like to add?</b></p>
		<p>{$tool.extra}</p>
	{/if}
	
{else}

	Empty

{/if}