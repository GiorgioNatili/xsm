<?php /* Smarty version 2.6.22, created on 2012-08-02 12:47:50
         compiled from patientQuestionnaireResults.tpl */ ?>
<h1>Questionnaire results - <?php echo $this->_tpl_vars['patient']['first_name']; ?>
 <?php echo $this->_tpl_vars['patient']['middle_name']; ?>
 <?php echo $this->_tpl_vars['patient']['last_name']; ?>
</h1>

<div class="bttnCont">
	<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back to Patient information page</a>
	<div class="clear"></div>
</div>

<?php if (count ( $this->_tpl_vars['results'] ) > 0): ?>

	<ol class="questionnaire">
		<?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['results'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['results']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['results']['iteration']++;
?>
			<li>
				<strong><?php echo $this->_tpl_vars['item']['question']; ?>
</strong>
				<ul>
					<?php $_from = $this->_tpl_vars['item']['answers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['answer']):
?>
						<li><?php echo $this->_tpl_vars['answer']; ?>
</li>
					<?php endforeach; endif; unset($_from); ?>
				</ul>
			</li>
		<?php endforeach; endif; unset($_from); ?>
	</ol>

<?php else: ?>

	<p><?php echo $this->_tpl_vars['lang']['no_questionnaire']; ?>
</p>

<?php endif; ?>