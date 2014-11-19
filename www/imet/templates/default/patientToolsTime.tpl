<h1>Tools details</h1>

<div class="bttnCont">
	<a href="{$backHref}">Back to Patient tool summary page</a>
	<div class="clear"></div>
</div>
			
<div class="summaryHeader">
	{foreach from=$timeDetails item=item}
	
		<p><strong>{$item.type}</strong>: {$item.totalTimeText}</p>
		
	{foreachelse}
	
		<p>No data</p>
	
	{/foreach}
</div><!-- summaryheader -->
