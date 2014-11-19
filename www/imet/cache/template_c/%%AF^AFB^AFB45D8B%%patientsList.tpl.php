<?php /* Smarty version 2.6.22, created on 2012-04-23 18:59:03
         compiled from patientsList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'patientsList.tpl', 22, false),)), $this); ?>
<h1>Patients list</h1>

<?php if ($this->_tpl_vars['addNewPatientHref']): ?>
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['addNewPatientHref']; ?>
">Add new Patient</a>
		<div class="clear"></div>
	</div>
<?php endif; ?>

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
	<?php $_from = $this->_tpl_vars['patientsList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['patientsList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['patientsList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['patient']):
        $this->_foreach['patientsList']['iteration']++;
?>
		<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['patient']['href']; ?>
');">
			<td class="odd"><?php echo $this->_tpl_vars['patient']['study_id']; ?>
</td>
			<td class="even"><?php if ($this->_tpl_vars['patient']['last_name']): ?><?php echo $this->_tpl_vars['patient']['last_name']; ?>
<?php else: ?>-<?php endif; ?></td>
			<td class="odd"><?php if ($this->_tpl_vars['patient']['first_name']): ?><?php echo $this->_tpl_vars['patient']['first_name']; ?>
<?php else: ?>-<?php endif; ?></td>
			<td class="even"><?php echo $this->_tpl_vars['patient']['group']; ?>
</td>
			<td class="odd"><?php if ($this->_tpl_vars['patient']['agreement']): ?>Yes<?php else: ?>No<?php endif; ?></td>
		</tr>
	<?php endforeach; else: ?>	
		<tr class="odd">
			<td class="odd" colspan="4"><?php echo $this->_tpl_vars['lang']['no_patients']; ?>
</td>
		</tr>
	<?php endif; unset($_from); ?>
</tbody>
</table>