<?php /* Smarty version 2.6.22, created on 2012-08-02 12:47:43
         compiled from patientStimulants.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'patientStimulants.tpl', 25, false),)), $this); ?>
<h1>Stimulants list - <?php echo $this->_tpl_vars['patient']['first_name']; ?>
 <?php echo $this->_tpl_vars['patient']['middle_name']; ?>
 <?php echo $this->_tpl_vars['patient']['last_name']; ?>
</h1>

<div class="bttnCont">
	<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back to Patient information page</a>
	<div class="clear"></div>
</div>

<?php if (count ( $this->_tpl_vars['stimulants'] ) > 0): ?>

	<ol class="questionnaire">
		<?php $_from = $this->_tpl_vars['stimulants']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['stimulants'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['stimulants']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['stimulant']):
        $this->_foreach['stimulants']['iteration']++;
?>
			<li>
				<p><?php echo $this->_tpl_vars['stimulant']['name']; ?>
</p>
				<?php if (count ( $this->_tpl_vars['stimulant']['dates'] )): ?>
					<br />
					<table cellpadding="0" cellspacing="0" class="table">
					<thead>
						<tr>
							<th class="odd">Date</th>
							<th class="even">Quantity</th>
						</tr>
					</thead>
					<tbody>
						<?php $_from = $this->_tpl_vars['stimulant']['dates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['dates'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['dates']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['dates']['iteration']++;
?>
							<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
								<td class="odd"><?php echo $this->_tpl_vars['item']['dayName']; ?>
</td>
								<td class="even"><?php echo $this->_tpl_vars['item']['quantity']; ?>
</td>
							</tr>
						<?php endforeach; else: ?>
							<tr class="odd">
								<td class="odd" colspan="2"><?php echo $this->_tpl_vars['lang']['brak_wpisow_w_dzienniku']; ?>
</td>
							</tr>
						<?php endif; unset($_from); ?>
					</tbody>
					</table>
				<?php endif; ?>
			</li>
		<?php endforeach; endif; unset($_from); ?>
	</ol>

<?php endif; ?>