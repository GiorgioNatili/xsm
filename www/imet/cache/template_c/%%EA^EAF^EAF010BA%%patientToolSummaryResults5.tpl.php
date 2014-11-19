<?php /* Smarty version 2.6.22, created on 2012-06-19 17:33:08
         compiled from patientToolSummaryResults5.tpl */ ?>
<ul>

	<?php $_from = $this->_tpl_vars['tool']['answers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['answer']):
?>
	
		<li><?php echo $this->_tpl_vars['answer']; ?>
</li>
	
	<?php endforeach; endif; unset($_from); ?>
	
</ul>

<?php if ($this->_tpl_vars['tool']['extra']): ?>
	<br />
	<p><b>Is there anything you'd like to add?</b></p>
	<p><?php echo $this->_tpl_vars['tool']['extra']; ?>
</p>
<?php endif; ?>