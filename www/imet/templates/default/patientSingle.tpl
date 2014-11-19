<script type="text/javascript" src="templates/default/scripts/jquery.simplemodal.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.ui.core.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.ui.datepicker.js"></script>

<h1>Patient Information page</h1>

<div class="bttnCont">
	{foreach from=$patientMenu item=menu}
		<a href="{$menu.href}">{$menu.name}</a>
	{/foreach}
	<div class="clear"></div>
</div>

<div class="patientInfo">
	<ul>
		<li>
			<label>Study ID</label><span>{$patient.study_id}</span><div class="clear"></div>
		</li>
		<li class="even">
			<label>Name</label><span>{$patient.first_name} {$patient.middle_name} {$patient.last_name}</span><div class="clear"></div>
		</li>
		<li>
			<label>Home number</label><span>{$patient.phone}</span><div class="clear"></div>
		</li>
		<li class="even">
			<label>E-mail</label><span>{$patient.email}</span><div class="clear"></div>
		</li>
		<li>
			<label>Address</label><span>{$patient.address} {$patient.address2} {$patient.city}</span><div class="clear"></div>
		</li>
		<li class="even">
			<label>Site</label><span>{$patient.site}</span><div class="clear"></div>
		</li>
		<li>
			<label>Provider</label><span>{$patient.provider}</span><div class="clear"></div>
		</li>
		<li class="even">
			<label>DOB</label><span>{$patient.dob}</span><div class="clear"></div>
		</li>
		<li>
			<label>Added</label><span>{$patient.add_date}</span><div class="clear"></div>
		</li>
	</ul>
</div><!-- patientInfo -->

{if $journalShow}
	<div class="journal">
		{$journalForm.open}
		<fieldset>
			<p><strong>Journal</strong>{if $journalAdded} - <span style="color:green">{$journalAdded}</span>{/if}</p>
			{$journalForm.fields.body.field}
			<input type="submit" class="submit" value="save" />
		</fieldset>
		{$journalForm.close}
	</div><!-- journal -->
{/if}
<div class="clear"></div>

<br />
<table cellpadding="0" cellspacing="0" class="table">
<thead>
	<tr>
		<th class="odd">Event</th>
		<th class="even">Status</th>
		<th class="odd">Schedule</th>
	</tr>
</thead>
<tbody>
	{foreach from=$studyManager.items item=item name=studyManager}
		<tr class="{cycle values='odd,even'}">
			<td class="odd">
				{if $item.url}
					<a href="{$item.url}" {if $item.email}class="sendEmail"{else}onclick="this.target='_blank'"{/if}>{$item.event}</a>
				{else}
					{$item.event}
				{/if}
			</td>
			<td class="even">{$item.status}</td>
			<td class="odd">
				{if $item.scheduleEdit}
					<input type="text" class="date {if $item.scheduleErr}studyDateErr{/if} studyDate" name="date_{$item.id}" readonly="readonly" value="{$item.schedule}" />
				{else}
					{$item.schedule}
				{/if}
			</td>
		</tr>
	{/foreach}
</tbody>
</table>

{if $studyManager.sendEmail}
	<div id="addForm">
		<form method="post" action="" id="emailForm">
			<fieldset>
				<p style="padding:0 0 5px 0">Subject:</p>
				<p><input type="text" class="subject" style="" value="" name="teSubject" /></p>
				<p class="errMsg subjectError" style="display:none">This is a required field.</p>
				<br />
				<p style="padding:0 0 5px 0">Message:</p>
				<p><textarea class="calendarComment" rows="1" cols="1" name="teMessage"></textarea></p>
				<p class="errMsg msgError" style="display:none">This is a required field.</p>
				<br />
				<a href="#" class="cancel">cancel</a>
				<input type="hidden" class="editID" name="edit_id" value="" />
				<input type="button" name="sendTeEmail" value="save" class="submit" />
				<div class="clear"></div>
			</fieldset>
		</form>
	</div>
	
	<script type="text/javascript">
	{literal}
		$(".sendEmail").click(function(){
			$("#addForm").modal({
				overlayClose:true,
				overlayId:'tlfbCalendarOverlay',
				closeClass:'cancel'
			});
			return false;
		});
		$('#addForm input[name="sendTeEmail"]').click(function(){
			var editError = 0;
			if(!$("#addForm .subject").val())
			{
				$("#addForm .subjectError").show();
				editError = 1;
			}
			else
			{
				$("#addForm .subjectError").hide();
			}
			if(!$("#addForm .calendarComment").val())
			{
				$("#addForm .msgError").show();
				editError = 1;
			}
			else
			{
				$("#addForm .msgError").hide();
			}
			if(!editError)
			{
				$("#emailForm").submit();
			}
		});
	{/literal}
	</script>
{/if}

<script type="text/javascript">
{literal}
	$(function() {
		$(".studyDate").datepicker({
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
						url: "{/literal}{$studyMangerDateHref}{literal}",
						data: "id="+id+"&date="+dateText,
						success: function(msg){
							if(msg)
							{
								inputDate.removeClass('studyDateErr');
								alert(msg);
							}
						}
					});
				}
			}
		});
	});
{/literal}
</script>