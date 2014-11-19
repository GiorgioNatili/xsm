<?php /* Smarty version 2.6.22, created on 2012-05-15 13:31:34
         compiled from statCorrespondence.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'statCorrespondence.tpl', 21, false),)), $this); ?>
<?php if ($this->_tpl_vars['status']): ?>
	<h1>Correspondence Page - <?php echo $this->_tpl_vars['status']['name']; ?>
</h1>
	
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back to Correspondence Page</a>
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
		<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['patientsList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['patientsList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['patientsList']['iteration']++;
?>
			<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
')">
				<td class="odd"><?php echo $this->_tpl_vars['item']['study_id']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['item']['last_name']; ?>
</td>
				<td class="odd"><?php echo $this->_tpl_vars['item']['first_name']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['item']['site']; ?>
</td>
				<td class="odd"><?php echo $this->_tpl_vars['item']['provider']; ?>
</td>
			</tr>
		<?php endforeach; else: ?>
			<tr class="odd"><td class="odd" colspan="6">No patients</td></tr>
		<?php endif; unset($_from); ?>
	</tbody>
	</table>
<?php else: ?>
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
		<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
"<?php if ($this->_tpl_vars['item']['href']): ?> onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
')"<?php endif; ?>>
				<td class="odd"><?php echo $this->_tpl_vars['item']['quantity']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
				<td class="odd"><?php echo $this->_tpl_vars['item']['desc']; ?>
</td>
			</tr>
		<?php endforeach; else: ?>
			<tr class="odd"><td class="odd" colspan="3">No patients</td></tr>
		<?php endif; unset($_from); ?>
	</tbody>
	</table>
<?php endif; ?>