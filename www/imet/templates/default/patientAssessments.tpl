<h1>Assessments</h1>

<div class="bttnCont">
	<a href="{$backHref}">Back to Patient information page</a>
	<div class="clear"></div>
</div>

<div>
	{foreach from=$links item=item name=links}
		<p><b>{$item.table}</b> - <a href="{$item.link}">CLICK HERE</a></p>
		<br />
	{/foreach}
	
	<div class="clear"></div>
	
</div>
