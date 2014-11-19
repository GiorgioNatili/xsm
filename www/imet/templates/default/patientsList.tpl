<h1>Patients list</h1>

{if $addNewPatientHref}
	<div class="bttnCont">
		<a href="{$addNewPatientHref}">Add new Patient</a>
		<div class="clear"></div>
	</div>
{/if}

<table cellpadding="0" cellspacing="0" class="table">
<thead>
	<tr>
		<th class="odd">Study ID</th>
		<th class="even">Last name</th>
		<th class="odd">First name</th>
		<th class="even">Group name</th>
		<th class="odd">Agreement</th>
	</tr>
</thead>
<tbody>
	{foreach from=$patientsList item=patient name=patientsList}
		<tr class="{cycle values='odd,even'}" onclick="redirect('{$patient.href}');">
			<td class="odd">{$patient.study_id}</td>
			<td class="even">{if $patient.last_name}{$patient.last_name}{else}-{/if}</td>
			<td class="odd">{if $patient.first_name}{$patient.first_name}{else}-{/if}</td>
			<td class="even">{$patient.group}</td>
			<td class="odd">{if $patient.agreement}Yes{else}No{/if}</td>
		</tr>
	{foreachelse}	
		<tr class="odd">
			<td class="odd" colspan="4">{$lang.no_patients}</td>
		</tr>
	{/foreach}
</tbody>
</table>
