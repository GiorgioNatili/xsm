<h1>Stimulants list - {$patient.first_name} {$patient.middle_name} {$patient.last_name}</h1>

<div class="bttnCont">
	<a href="{$backHref}">Back to Patient information page</a>
	<div class="clear"></div>
</div>

{if count($stimulants) > 0}

	<ol class="questionnaire">
		{foreach from=$stimulants item=stimulant name=stimulants}
			<li>
				<p>{$stimulant.name}</p>
				{if count($stimulant.dates)}
					<br />
					<table cellpadding="0" cellspacing="0" class="table">
					<thead>
						<tr>
							<th class="odd">Date</th>
							<th class="even">Quantity</th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$stimulant.dates item=item name=dates}
							<tr class="{cycle values='odd,even'}">
								<td class="odd">{$item.dayName}</td>
								<td class="even">{$item.quantity}</td>
							</tr>
						{foreachelse}
							<tr class="odd">
								<td class="odd" colspan="2">{$lang.brak_wpisow_w_dzienniku}</td>
							</tr>
						{/foreach}
					</tbody>
					</table>
				{/if}
			</li>
		{/foreach}
	</ol>

{/if}