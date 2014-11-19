<?php /* Smarty version 2.6.22, created on 2012-04-23 19:00:06
         compiled from patientAdd_step3.tpl */ ?>
<h1>Add new Patient - step 3</h1>

<form method="post" action="">
	<div id="preTlfb">
	
		<?php $_from = $this->_tpl_vars['form']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['stimulants'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['stimulants']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['stimulantID'] => $this->_tpl_vars['stimulant']):
        $this->_foreach['stimulants']['iteration']++;
?>

			<?php $_from = $this->_tpl_vars['stimulant']['questions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['questions'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['questions']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['question']):
        $this->_foreach['questions']['iteration']++;
?>
				
				<div class="preTlfbBox <?php if ($this->_foreach['stimulants']['iteration']%2 == 0): ?>preTlfbBoxOdd<?php endif; ?> <?php if (( ($this->_foreach['stimulants']['iteration'] <= 1) && ($this->_foreach['questions']['iteration'] <= 1) ) || $this->_tpl_vars['question']['show']): ?><?php else: ?>preTlfbBoxHide<?php endif; ?>">
					<p class="question">
						<strong><?php echo $this->_foreach['questions']['iteration']; ?>
.</strong> <?php echo $this->_tpl_vars['question']['text']; ?>

					</p>
					<div class="answers">
						<input <?php if ($this->_tpl_vars['question']['selected'] == 1): ?>checked="checked"<?php endif; ?> type="radio" name="question_<?php echo $this->_tpl_vars['stimulantID']; ?>
_<?php echo $this->_tpl_vars['question']['id']; ?>
" value="1" id="question_<?php echo $this->_tpl_vars['question']['id']; ?>
_a" /><label for="question_<?php echo $this->_tpl_vars['question']['id']; ?>
_a">Yes</label>
						<input <?php if ($this->_tpl_vars['question']['selected'] == 2): ?>checked="checked"<?php endif; ?> type="radio" name="question_<?php echo $this->_tpl_vars['stimulantID']; ?>
_<?php echo $this->_tpl_vars['question']['id']; ?>
" value="2" id="question_<?php echo $this->_tpl_vars['question']['id']; ?>
_b" /><label for="question_<?php echo $this->_tpl_vars['question']['id']; ?>
_b">No</label>
					</div>
				</div>
				
			<?php endforeach; endif; unset($_from); ?>
			
		<?php endforeach; endif; unset($_from); ?>

	</div><!--preTlfb-->
	
	<div>
		<br />
		<a class="newPatientBack" href="<?php echo $this->_tpl_vars['backHref']; ?>
">back</a>
		<input type="submit" name="nextStep" value="next" class="newPatientFormSubmit" style="display:none" />
		<div class="clear"></div>
	</div>
</form>