<script type="text/javascript" src="templates/default/scripts/jquery.simplemodal.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.ui.core.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.ui.datepicker.js"></script>

<h1>Upcoming Events Page ({$statusName})</h1>

<div class="bttnCont">
	<a href="{$backHref}">Back to Summary Page</a>
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
		<th class="even">Schedule</th>
	</tr>
</thead>
<tbody>
	{foreach from=$list item=item name=patientsList}
		<tr>
			<td onclick="redirect('{$item.href}')" class="odd">{$item.study_id}</td>
			<td onclick="redirect('{$item.href}')" class="even">{$item.last_name}</td>
			<td onclick="redirect('{$item.href}')" class="odd">{$item.first_name}</td>
			<td onclick="redirect('{$item.href}')" class="even">{$item.site}</td>
			<td onclick="redirect('{$item.href}')" class="odd">{$item.provider}</td>
			<td class="even">
				<input type="text" class="date {if $item.scheduleErr}studyDateErr{/if} schedule" name="date_{$item.id_patient}" readonly="readonly" value="{$item.schedule}" />
			</td>
		</tr>
	{foreachelse}
		<tr><td colspan="6">No patients</td></tr>
	{/foreach}
</tbody>
</table>

<script type="text/javascript">
{literal}
	$(function() {
		$(".schedule").datepicker({
			showOn: "both",
			buttonImage: "templates/default/images/edit.png",
			buttonImageOnly: true,
			minDate: 0,
			dateFormat: "yy-mm-dd",
			onSelect: function(dateText, inst) {
				var id = $(this).attr("name");
				var inputDate = $(this);
				id = id.split("_");
				if(id[1])
				{
					id = id[1];
					$.ajax({
						type: "POST",
						url: "{/literal}{$upcomingDateHref}{literal}&token=date",
						data: "id_patient="+id+"&date="+dateText,
						success: function(msg){
							/*
							if(msg)
							{
								inputDate.removeClass('studyDateErr');
								alert(msg);
							}
							*/
							alert(msg);
						}
					});
				}
			}
		});
	});
{/literal}
</script>