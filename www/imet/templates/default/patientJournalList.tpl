<h1>Journal - {$patient.first_name} {$patient.middle_name} {$patient.last_name}</h1>

<div class="bttnCont">
	<a href="{$backHref}">Back to Patient information page</a>
	<div class="clear"></div>
</div>

<table cellpadding="0" cellspacing="0" class="table">
<thead>
	<tr>
		<th class="odd">Message</th>
		<th class="even" style="width:120px">Doctor</th>
		<th class="odd" style="width:120px">Add date</th>
	</tr>
</thead>
<tbody>
	{foreach from=$journalList item=journal name=journalList}
		<tr class="{cycle values='odd,even'}">
			<td class="odd">{$journal.body}</td>
			<td class="even">{$journal.doctor}</td>
			<td class="odd">{$journal.add_date}</td>
		</tr>
	{foreachelse}
		<tr class="odd">
			<td class="odd" colspan="3">{$lang.brak_wpisow_w_dzienniku}</td>
		</tr>
	{/foreach}
</tbody>
</table>
