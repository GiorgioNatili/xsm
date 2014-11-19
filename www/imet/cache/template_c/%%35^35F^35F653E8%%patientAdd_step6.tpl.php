<?php /* Smarty version 2.6.22, created on 2012-04-23 19:01:49
         compiled from patientAdd_step6.tpl */ ?>
<script type="text/javascript" src="templates/default/scripts/jquery.tooltip.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.simplemodal.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.ui.core.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.ui.datepicker.js"></script>

<h1><?php echo $this->_tpl_vars['page']->title; ?>
</h1>

<form method="post" action="">
	<div id="tlfbCalendar" class="step6Calendar">
	
		<?php echo $this->_tpl_vars['page']->body; ?>

		<?php echo $this->_tpl_vars['question']; ?>

		<br />
		
		<ul class="months">
			<?php $_from = $this->_tpl_vars['calendar']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['calendar'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['calendar']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['date']):
        $this->_foreach['calendar']['iteration']++;
?>
				<li id="month<?php echo $this->_tpl_vars['date']['id']; ?>
" class="<?php if (($this->_foreach['calendar']['iteration'] <= 1)): ?>active<?php endif; ?> <?php if (($this->_foreach['calendar']['iteration'] == $this->_foreach['calendar']['total'])): ?>last<?php endif; ?>">
					<?php echo $this->_tpl_vars['date']['month']; ?>
 <?php echo $this->_tpl_vars['date']['year']; ?>

				</li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
		<div class="clear"></div>
		
		<?php $_from = $this->_tpl_vars['calendar']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['calendar'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['calendar']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['date']):
        $this->_foreach['calendar']['iteration']++;
?>
			<div id="month<?php echo $this->_foreach['calendar']['iteration']; ?>
Box" class="monthBox" <?php if (! ($this->_foreach['calendar']['iteration'] <= 1)): ?>style="display:none"<?php endif; ?>>
				<div class="cont">
					<table cellpadding="0" cellspacing="0">
					<tr>
						<th>Sun</th>
						<th class="odd">Mon</th>
						<th>Tue</th>
						<th class="odd">Wen</th>
						<th>Thu</th>
						<th class="odd">Fri</th>
						<th>Sat</th>
					</tr>
					<?php $_from = $this->_tpl_vars['date']['days']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['days'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['days']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['day']):
        $this->_foreach['days']['iteration']++;
?>
						<?php if (($this->_foreach['days']['iteration'] <= 1)): ?>
							<tr>
						<?php endif; ?>
						<?php if (($this->_foreach['days']['iteration']-1)%7 == 0 && ! ($this->_foreach['days']['iteration'] <= 1)): ?>
							</tr>
							<tr>
								<td colspan="7" class="spacer"></td>
							</tr>
							<tr>
						<?php endif; ?>

						<td class="<?php if ($this->_foreach['days']['iteration']%2 == 0): ?>odd<?php endif; ?> <?php if ($this->_foreach['days']['iteration']%2 == 0 && ! $this->_tpl_vars['day']['day']): ?>emptyOdd<?php elseif (! $this->_tpl_vars['day']['day']): ?>empty<?php endif; ?> <?php if ($this->_tpl_vars['day']['options']): ?>holiday<?php endif; ?>">
							<?php if ($this->_tpl_vars['day']['day']): ?>
								<strong><?php echo $this->_tpl_vars['day']['day']; ?>
</strong>
																<?php if ($this->_tpl_vars['day']['options']): ?>
									<div class="options">
										<?php $_from = $this->_tpl_vars['day']['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['optionID'] => $this->_tpl_vars['option']):
?>
											<span class="option_<?php echo $this->_tpl_vars['optionID']; ?>
"><?php echo $this->_tpl_vars['option']; ?>
</span>
										<?php endforeach; endif; unset($_from); ?>
									</div>
								<?php endif; ?>
							<?php else: ?>
								&nbsp;
							<?php endif; ?>
							<input type="hidden" name="date" value="<?php echo $this->_tpl_vars['day']['year']; ?>
-<?php echo $this->_tpl_vars['day']['month']; ?>
-<?php echo $this->_tpl_vars['day']['day']; ?>
" title="<?php echo $this->_tpl_vars['day']['dayName']; ?>
" />
						</td>
						
						<?php if (($this->_foreach['days']['iteration'] == $this->_foreach['days']['total'])): ?>
							</tr>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					</table>
				</div>
			</div>
		<?php endforeach; endif; unset($_from); ?>

	</div><!--tlfbCalendar-->
	
	<div>
		<br />
		
		<a class="newPatientBack" href="<?php echo $this->_tpl_vars['backHref']; ?>
">back</a>
		<input type="submit" name="nextStep" value="<?php if ($this->_tpl_vars['save']): ?>submit<?php else: ?>next question<?php endif; ?>" class="newPatientFormSubmit<?php if (! $this->_tpl_vars['save']): ?>2<?php endif; ?>" />
		<?php if ($this->_tpl_vars['backQuestion']): ?>
			<input type="submit" name="prevQuestion" value="prev question" class="newPatientFormSubmit3" />
		<?php endif; ?>
		<div class="clear"></div>
	</div>
</form>

<div id="addForm">
	<form method="post" action="">
		<fieldset>
			<p class="currentDate"></p>
			<ul class="stimulants">
				<?php $_from = $this->_tpl_vars['stimulants']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['stimulants'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['stimulants']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['stimulant']):
        $this->_foreach['stimulants']['iteration']++;
?>
					<li>
						<label><?php echo $this->_tpl_vars['stimulant']['name']; ?>
</label>
						<input type="text" id="stimulant_<?php echo $this->_tpl_vars['stimulant']['id']; ?>
" class="stimulant" name="stimulant_<?php echo $this->_tpl_vars['stimulant']['id']; ?>
" value="" />
						<input type="button" class="repeat" value="repeat" rel="<?php echo $this->_tpl_vars['stimulant']['id']; ?>
" />
						<input type="submit" class="delete" name="stimulantdel_<?php echo $this->_tpl_vars['stimulant']['id']; ?>
" value="1" title="Remove this value" />
						<div class="clear"></div>
						<div class="repeatBox repeatBox_<?php echo $this->_tpl_vars['stimulant']['id']; ?>
">
							<ul class="dates">
								<li>Start date: <input type="text" class="datepicker1" readonly="readonly" name="dateFrom_<?php echo $this->_tpl_vars['stimulant']['id']; ?>
" value= "" /></li>
								<li>End date: <input type="text" class="datepicker2" readonly="readonly" name="dateTo_<?php echo $this->_tpl_vars['stimulant']['id']; ?>
" value= "" /></li>
							</ul>
							<div class="clear"></div>
							<p style="padding:10px 0 5px 5px;font-weight:bold">Repeat Daily:</p>
							<div class="repeatOptions">
								<select name="stimulantoptions_<?php echo $this->_tpl_vars['stimulant']['id']; ?>
">
									<option value="0">Choose one</option>
									<option value="1">Include all days</option>
									<option value="2">Include week days only</option>
									<option value="3">Include week-end days only</option>
									<option value="4">Include school days only</option>
									<option value="5">Include non-school days only</option>
									<option value="6">Include Fridays and Saturdays only</option>
									<option value="7">Include Sundays through Thursdays only</option>
								</select>
							</div>
						</div>
					</li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
			<a href="#" class="cancel">cancel</a>
			<input type="submit" name="addTLFB" value="add" class="submit" />
			<input type="hidden" id="addDate" name="addDate" value="" />
			<div class="clear"></div>
		</fieldset>
	</form>
</div>

<script type="text/javascript">
<?php echo '
$(document).ready(function(){

	$(\'#addForm .stimulants .repeat\').click(function(){
		if($(this).val()==\'repeat\')
		{
			$(\'#addForm .stimulants .repeatBox\').hide();
			$(\'#addForm .stimulants .repeat\').val(\'repeat\');
			$(this).val(\'hide\');
		}
		else $(this).val(\'repeat\');
		$(this).parent().children(\'.repeatBox\').toggle();
		
		var dateFromTo = "#addForm .repeatBox_"+$(this).attr(\'rel\')+" .datepicker1, #addForm .repeatBox_"+$(this).attr(\'rel\')+" .datepicker2";

		var dates = $(dateFromTo).datepicker({
			changeMonth: false,
			dateFormat: \'yy-mm-dd\',
			minDate: "-'; ?>
<?php echo $this->_tpl_vars['dayLimit']; ?>
<?php echo 'D",
			maxDate: 0,
			onSelect: function( selectedDate ) {
				//var option = this.id == "from" ? "minDate" : "maxDate",
				var option = $(this).attr(\'class\') == "datepicker1 hasDatepicker" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	
	});	
	
});
'; ?>

</script>