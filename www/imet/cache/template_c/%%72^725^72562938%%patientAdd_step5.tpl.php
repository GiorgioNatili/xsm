<?php /* Smarty version 2.6.22, created on 2012-04-23 19:01:46
         compiled from patientAdd_step5.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip_tags', 'patientAdd_step5.tpl', 50, false),array('modifier', 'truncate', 'patientAdd_step5.tpl', 50, false),)), $this); ?>
<script type="text/javascript" src="templates/default/scripts/jquery.tooltip.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.simplemodal.js"></script>

<h1><?php echo $this->_tpl_vars['page']->title; ?>
</h1>

<form method="post" action="">
	<div id="tlfbCalendar" class="step5Calendar">
		
		<?php echo $this->_tpl_vars['page']->body; ?>

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

						<td class="<?php if ($this->_foreach['days']['iteration']%2 == 0): ?>odd<?php endif; ?> <?php if ($this->_foreach['days']['iteration']%2 == 0 && ! $this->_tpl_vars['day']['day']): ?>emptyOdd<?php elseif (! $this->_tpl_vars['day']['day']): ?>empty<?php endif; ?> <?php if ($this->_tpl_vars['day']['holiday']): ?>holiday<?php endif; ?>">
							<?php if ($this->_tpl_vars['day']['day']): ?>
								<strong><?php echo $this->_tpl_vars['day']['day']; ?>
</strong>
								<?php if ($this->_tpl_vars['day']['text'] || $this->_tpl_vars['day']['holiday']): ?>
									<p><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['day']['text'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp, false) : smarty_modifier_strip_tags($_tmp, false)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 40, "&hellip;") : smarty_modifier_truncate($_tmp, 40, "&hellip;")); ?>
</p>
									<span><?php echo $this->_tpl_vars['day']['text']; ?>
<?php if ($this->_tpl_vars['day']['holiday']): ?><strong><?php if ($this->_tpl_vars['day']['text']): ?><br /><br /><?php endif; ?><?php echo $this->_tpl_vars['day']['holiday']; ?>
</strong><?php endif; ?></span>
								<?php endif; ?>
							<?php else: ?>
								&nbsp;
							<?php endif; ?>
							<input type="hidden" name="date" value="<?php echo $this->_tpl_vars['day']['year']; ?>
-<?php echo $this->_tpl_vars['day']['month']; ?>
-<?php echo $this->_tpl_vars['day']['day']; ?>
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
		<input type="submit" name="nextStep" value="next" class="newPatientFormSubmit" />
		<div class="clear"></div>
	</div>
</form>

<div id="addForm">
	<form method="post" action="">
		<fieldset>
			<p style="padding:0 0 5px 0">ADD COMMENT:</p>
			<p><textarea rows="1" cols="1" name="calendarComment"></textarea></p><br />
			<a href="#" class="cancel">cancel</a>
			<input type="submit" name="addComment" value="add" class="submit" />
			<input type="hidden" id="addDate" name="addDate" value="" />
			<div class="clear"></div>
		</fieldset>
	</form>
</div>