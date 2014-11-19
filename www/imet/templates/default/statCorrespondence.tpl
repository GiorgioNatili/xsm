{if $status}
	<h1>Correspondence Page - {$status.name}</h1>
	
	<div class="bttnCont">
		<a href="{$backHref}">Back to Correspondence Page</a>
		<div class="clear"></div>
	</div>
	
	<table cellpadding="0" cellspacing="0" class="table" id="summaryTable">
	<thead>
		<tr>
			<th class="odd">Study ID</th>
			<th class="even">Last Name</th>
			<th class="odd">First Name</th>
			<th class="even">Site Name</th>
			<th class="odd">Provider Name</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$list item=item name=patientsList}
			<tr class="{cycle values='odd,even'}" onclick="redirect('{$item.href}')">
				<td class="odd">{$item.study_id}</td>
				<td class="even">{$item.last_name}</td>
				<td class="odd">{$item.first_name}</td>
				<td class="even">{$item.site}</td>
				<td class="odd">{$item.provider}</td>
			</tr>
		{foreachelse}
			<tr class="odd"><td class="odd" colspan="6">No patients</td></tr>
		{/foreach}
	</tbody>
	</table>
{else}
	<h1>Correspondence Page</h1>
	
	<table cellpadding="0" cellspacing="0" class="table" id="summaryTable">
	<thead>
		<tr>
			<th class="odd">Number</th>
			<th class="even">Status</th>
			<th class="odd">Status Description</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$list item=item}
			<tr class="{cycle values='odd,even'}"{if $item.href} onclick="redirect('{$item.href}')"{/if}>
				<td class="odd">{$item.quantity}</td>
				<td class="even">{$item.name}</td>
				<td class="odd">{$item.desc}</td>
			</tr>
		{foreachelse}
			<tr class="odd"><td class="odd" colspan="3">No patients</td></tr>
		{/foreach}
	</tbody>
	</table>
{/if}
