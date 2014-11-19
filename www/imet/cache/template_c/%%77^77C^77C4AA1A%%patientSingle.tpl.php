<?php /* Smarty version 2.6.22, created on 2012-05-15 13:31:57
         compiled from patientSingle.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'patientSingle.tpl', 70, false),)), $this); ?>
<script type="text/javascript" src="templates/default/scripts/jquery.simplemodal.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.ui.core.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.ui.datepicker.js"></script>

<h1>Patient Information page</h1>

<div class="bttnCont">
	<?php $_from = $this->_tpl_vars['patientMenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menu']):
?>
		<a href="<?php echo $this->_tpl_vars['menu']['href']; ?>
"><?php echo $this->_tpl_vars['menu']['name']; ?>
</a>
	<?php endforeach; endif; unset($_from); ?>
	<div class="clear"></div>
</div>

<div class="patientInfo">
	<ul>
		<li>
			<label>Study ID</label><span><?php echo $this->_tpl_vars['patient']['study_id']; ?>
</span><div class="clear"></div>
		</li>
		<li class="even">
			<label>Name</label><span><?php echo $this->_tpl_vars['patient']['first_name']; ?>
 <?php echo $this->_tpl_vars['patient']['middle_name']; ?>
 <?php echo $this->_tpl_vars['patient']['last_name']; ?>
</span><div class="clear"></div>
		</li>
		<li>
			<label>Home number</label><span><?php echo $this->_tpl_vars['patient']['phone']; ?>
</span><div class="clear"></div>
		</li>
		<li class="even">
			<label>E-mail</label><span><?php echo $this->_tpl_vars['patient']['email']; ?>
</span><div class="clear"></div>
		</li>
		<li>
			<label>Address</label><span><?php echo $this->_tpl_vars['patient']['address']; ?>
 <?php echo $this->_tpl_vars['patient']['address2']; ?>
 <?php echo $this->_tpl_vars['patient']['city']; ?>
</span><div class="clear"></div>
		</li>
		<li class="even">
			<label>Site</label><span><?php echo $this->_tpl_vars['patient']['site']; ?>
</span><div class="clear"></div>
		</li>
		<li>
			<label>Provider</label><span><?php echo $this->_tpl_vars['patient']['provider']; ?>
</span><div class="clear"></div>
		</li>
		<li class="even">
			<label>DOB</label><span><?php echo $this->_tpl_vars['patient']['dob']; ?>
</span><div class="clear"></div>
		</li>
		<li>
			<label>Added</label><span><?php echo $this->_tpl_vars['patient']['add_date']; ?>
</span><div class="clear"></div>
		</li>
	</ul>
</div><!-- patientInfo -->

<?php if ($this->_tpl_vars['journalShow']): ?>
	<div class="journal">
		<?php echo $this->_tpl_vars['journalForm']['open']; ?>

		<fieldset>
			<p><strong>Journal</strong><?php if ($this->_tpl_vars['journalAdded']): ?> - <span style="color:green"><?php echo $this->_tpl_vars['journalAdded']; ?>
</span><?php endif; ?></p>
			<?php echo $this->_tpl_vars['journalForm']['fields']['body']['field']; ?>

			<input type="submit" class="submit" value="save" />
		</fieldset>
		<?php echo $this->_tpl_vars['journalForm']['close']; ?>

	</div><!-- journal -->
<?php endif; ?>
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
	<?php $_from = $this->_tpl_vars['studyManager']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['studyManager'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['studyManager']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['studyManager']['iteration']++;
?>
		<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
			<td class="odd">
				<?php if ($this->_tpl_vars['item']['url']): ?>
					<a href="<?php echo $this->_tpl_vars['item']['url']; ?>
" <?php if ($this->_tpl_vars['item']['email']): ?>class="sendEmail"<?php else: ?>onclick="this.target='_blank'"<?php endif; ?>><?php echo $this->_tpl_vars['item']['event']; ?>
</a>
				<?php else: ?>
					<?php echo $this->_tpl_vars['item']['event']; ?>

				<?php endif; ?>
			</td>
			<td class="even"><?php echo $this->_tpl_vars['item']['status']; ?>
</td>
			<td class="odd">
				<?php if ($this->_tpl_vars['item']['scheduleEdit']): ?>
					<input type="text" class="date <?php if ($this->_tpl_vars['item']['scheduleErr']): ?>studyDateErr<?php endif; ?> studyDate" name="date_<?php echo $this->_tpl_vars['item']['id']; ?>
" readonly="readonly" value="<?php echo $this->_tpl_vars['item']['schedule']; ?>
" />
				<?php else: ?>
					<?php echo $this->_tpl_vars['item']['schedule']; ?>

				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>
</tbody>
</table>

<?php if ($this->_tpl_vars['studyManager']['sendEmail']): ?>
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
	<?php echo '
		$(".sendEmail").click(function(){
			$("#addForm").modal({
				overlayClose:true,
				overlayId:\'tlfbCalendarOverlay\',
				closeClass:\'cancel\'
			});
			return false;
		});
		$(\'#addForm input[name="sendTeEmail"]\').click(function(){
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
	'; ?>

	</script>
<?php endif; ?>

<script type="text/javascript">
<?php echo '
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
						url: "'; ?>
<?php echo $this->_tpl_vars['studyMangerDateHref']; ?>
<?php echo '",
						data: "id="+id+"&date="+dateText,
						success: function(msg){
							if(msg)
							{
								inputDate.removeClass(\'studyDateErr\');
								alert(msg);
							}
						}
					});
				}
			}
		});
	});
'; ?>

</script>