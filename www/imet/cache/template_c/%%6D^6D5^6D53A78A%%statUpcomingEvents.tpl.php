<?php /* Smarty version 2.6.22, created on 2012-08-07 19:17:23
         compiled from statUpcomingEvents.tpl */ ?>
<script type="text/javascript" src="templates/default/scripts/jquery.simplemodal.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.ui.core.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.ui.datepicker.js"></script>

<h1>Upcoming Events Page (<?php echo $this->_tpl_vars['statusName']; ?>
)</h1>

<div class="bttnCont">
	<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back to Summary Page</a>
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
	<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['patientsList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['patientsList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['patientsList']['iteration']++;
?>
		<tr>
			<td onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
')" class="odd"><?php echo $this->_tpl_vars['item']['study_id']; ?>
</td>
			<td onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
')" class="even"><?php echo $this->_tpl_vars['item']['last_name']; ?>
</td>
			<td onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
')" class="odd"><?php echo $this->_tpl_vars['item']['first_name']; ?>
</td>
			<td onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
')" class="even"><?php echo $this->_tpl_vars['item']['site']; ?>
</td>
			<td onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
')" class="odd"><?php echo $this->_tpl_vars['item']['provider']; ?>
</td>
			<td class="even">
				<input type="text" class="date <?php if ($this->_tpl_vars['item']['scheduleErr']): ?>studyDateErr<?php endif; ?> schedule" name="date_<?php echo $this->_tpl_vars['item']['id_patient']; ?>
" readonly="readonly" value="<?php echo $this->_tpl_vars['item']['schedule']; ?>
" />
			</td>
		</tr>
	<?php endforeach; else: ?>
		<tr><td colspan="6">No patients</td></tr>
	<?php endif; unset($_from); ?>
</tbody>
</table>

<script type="text/javascript">
<?php echo '
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
						url: "'; ?>
<?php echo $this->_tpl_vars['upcomingDateHref']; ?>
<?php echo '&token=date",
						data: "id_patient="+id+"&date="+dateText,
						success: function(msg){
							/*
							if(msg)
							{
								inputDate.removeClass(\'studyDateErr\');
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
'; ?>

</script>