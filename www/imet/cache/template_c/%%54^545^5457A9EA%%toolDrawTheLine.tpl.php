<?php /* Smarty version 2.6.22, created on 2012-04-25 17:54:01
         compiled from admin/toolDrawTheLine.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolDrawTheLine.tpl', 41, false),array('modifier', 'strip_tags', 'admin/toolDrawTheLine.tpl', 42, false),array('modifier', 'truncate', 'admin/toolDrawTheLine.tpl', 42, false),)), $this); ?>
<?php if ($this->_tpl_vars['singleQuestion']): ?>

	<h1>Draw the line - answers</h1>
		
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
		<p><strong>Question:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['question']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['question']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['question']['errMsg']; ?>
</p><?php endif; ?><br />
		
		<p><strong>Doctor feedback:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['doctor']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['doctor']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['doctor']['errMsg']; ?>
</p><?php endif; ?><br />
		
		<p><strong>Digits:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['digits']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['digits']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['digits']['errMsg']; ?>
</p><?php endif; ?><br />
		
		<div class="bttnCont">
			<a href="<?php echo $this->_tpl_vars['newHref']; ?>
">Add new</a>
			<div class="clear"></div>
		</div>

		<table cellpadding="0" cellspacing="0" class="table">
		<thead>
			<tr>
				<th class="odd">Answer</th>
				<th class="even">Type</th>
				<th class="odd">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php $_from = $this->_tpl_vars['answers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['answers'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['answers']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['answers']['iteration']++;
?>
				<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
');">
					<td class="odd"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['answer'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp, false) : smarty_modifier_strip_tags($_tmp, false)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 50, "&hellip;") : smarty_modifier_truncate($_tmp, 50, "&hellip;")); ?>
</td>
					<td class="even"><?php echo $this->_tpl_vars['item']['type']; ?>
</td>
					<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="<?php echo $this->_tpl_vars['item']['delHref']; ?>
" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
				</tr>
			<?php endforeach; else: ?>
				<tr>
					<td colspan="4"><?php echo $this->_tpl_vars['lang']['no_types']; ?>
</td>
				</tr>
			<?php endif; unset($_from); ?>
		</tbody>
		</table>
		
		<script type="text/javascript">
		<?php echo '
			$(document).ready(function(){
				$(\'.table .delete\').click(function(){
					if(confirm("'; ?>
<?php echo $this->_tpl_vars['lang']['delete_confirm']; ?>
<?php echo '"))
					{
						location.href=$(this).attr(\'rel\');
					}
					return false;
				});
			});
		'; ?>

		</script>
		
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>

	
<?php elseif ($this->_tpl_vars['singleAnswer']): ?>

	<h1>Draw the line - single answer</h1>
		
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
		<p><strong>Answer:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['answer']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['answer']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['answer']['errMsg']; ?>
</p><?php endif; ?><br />
		
		<p><strong>Type:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['type']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['type']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['type']['errMsg']; ?>
</p><?php endif; ?><br />
		
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>


<?php else: ?>

	<h1>Draw the line - questions</h1>
	
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Question</th>
			<th class="even">State</th>
			<th class="even">Digits</th>
		</tr>
	</thead>
	<tbody>
		<?php $_from = $this->_tpl_vars['questions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['questions'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['questions']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['questions']['iteration']++;
?>
			<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
');">
				<td class="odd"><?php echo $this->_tpl_vars['item']['question']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['item']['state']; ?>
</td>
				<td class="odd"><?php echo $this->_tpl_vars['item']['digits']; ?>
</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	</tbody>
	</table>

<?php endif; ?>