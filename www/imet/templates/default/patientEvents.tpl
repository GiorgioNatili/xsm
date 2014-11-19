<h1>Events - {$patient.first_name} {$patient.middle_name} {$patient.last_name}</h1>

<div class="bttnCont">
	<a href="{$backHref}">Back to Patient information page</a>
	<div class="clear"></div>
</div>

<table cellpadding="0" cellspacing="0" class="table">
<thead>
	<tr>
		<th class="odd">Date</th>
		<th class="even">Event</th>
	</tr>
</thead>
<tbody>
	{foreach from=$events item=event name=journalList}
		<tr class="{cycle values='odd,even'}">
			<td class="odd">{$event.date}</td>
			<td class="even">{$event.text}</td>
		</tr>
	{foreachelse}
		<tr class="odd">
			<td class="odd" colspan="2">{$lang.brak_wpisow_w_dzienniku}</td>
		</tr>
	{/foreach}
</tbody>
</table>
