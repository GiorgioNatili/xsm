<?php /* Smarty version 2.6.22, created on 2012-06-19 17:33:11
         compiled from patientToolsTime.tpl */ ?>
<h1>Tools details</h1>

<div class="bttnCont">
	<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back to Patient tool summary page</a>
	<div class="clear"></div>
</div>
			
<div class="summaryHeader">
	<?php $_from = $this->_tpl_vars['timeDetails']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
	
		<p><strong><?php echo $this->_tpl_vars['item']['type']; ?>
</strong>: <?php echo $this->_tpl_vars['item']['totalTimeText']; ?>
</p>
		
	<?php endforeach; else: ?>
	
		<p>No data</p>
	
	<?php endif; unset($_from); ?>
</div><!-- summaryheader -->