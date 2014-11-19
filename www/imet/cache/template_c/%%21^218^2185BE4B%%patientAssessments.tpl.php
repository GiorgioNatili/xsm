<?php /* Smarty version 2.6.22, created on 2012-05-15 13:32:08
         compiled from patientAssessments.tpl */ ?>
<h1>Assessments</h1>

<div class="bttnCont">
	<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back to Patient information page</a>
	<div class="clear"></div>
</div>

<div>
	<?php $_from = $this->_tpl_vars['links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['links'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['links']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['links']['iteration']++;
?>
		<p><b><?php echo $this->_tpl_vars['item']['table']; ?>
</b> - <a href="<?php echo $this->_tpl_vars['item']['link']; ?>
">CLICK HERE</a></p>
		<br />
	<?php endforeach; endif; unset($_from); ?>
	
	<div class="clear"></div>
	
</div>