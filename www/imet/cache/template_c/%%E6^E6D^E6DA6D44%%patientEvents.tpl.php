<?php /* Smarty version 2.6.22, created on 2012-08-02 12:47:40
         compiled from patientEvents.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'patientEvents.tpl', 17, false),)), $this); ?>
<h1>Events - <?php echo $this->_tpl_vars['patient']['first_name']; ?>
 <?php echo $this->_tpl_vars['patient']['middle_name']; ?>
 <?php echo $this->_tpl_vars['patient']['last_name']; ?>
</h1>

<div class="bttnCont">
	<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back to Patient information page</a>
	<div class="clear"></div>
</div>

<table cellpadding="0" cellspacing="0" class="table">
<thead>
	<tr>
		<th class="odd">Date</th>
		<th class="even">Event</th>
	</tr>
</thead>
<tbody>
	<?php $_from = $this->_tpl_vars['events']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['journalList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['journalList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['event']):
        $this->_foreach['journalList']['iteration']++;
?>
		<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
">
			<td class="odd"><?php echo $this->_tpl_vars['event']['date']; ?>
</td>
			<td class="even"><?php echo $this->_tpl_vars['event']['text']; ?>
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