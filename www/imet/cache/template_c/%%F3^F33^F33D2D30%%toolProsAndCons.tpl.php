<?php /* Smarty version 2.6.22, created on 2012-04-25 17:11:59
         compiled from admin/toolProsAndCons.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolProsAndCons.tpl', 62, false),)), $this); ?>
<?php if ($this->_tpl_vars['form']): ?>

	<h1>Pros And Cons - single card</h1>
	
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>

	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
		<div style="float:left;padding:0 20px 0 0;">
			<p><strong>Label:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['label']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['label']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['label']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div style="float:left;padding:0 20px 0 0;">
			<p><strong>Category:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['category']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['category']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['category']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div style="float:left;">
			<p><strong>Stimulant:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['stimulant']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['stimulant']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['stimulant']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div class="clear"></div>
		<br />
		
		<p class="adminBackToList">
			<?php if ($this->_tpl_vars['edit']): ?><input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br /><?php endif; ?>
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>


<?php else: ?>

	<h1>Pros And Cons - cards</h1>
	
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['newHref']; ?>
">Add new</a>
		<div class="clear"></div>
	</div>
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Label</th>
			<th class="even">Category</th>
			<th class="odd">Stimulant</th>
			<th class="even"></th>
		</tr>
	</thead>
	<tbody>
		<?php $_from = $this->_tpl_vars['cards']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cards'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cards']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['card']):
        $this->_foreach['cards']['iteration']++;
?>
			<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['card']['href']; ?>
');">
				<td class="odd"><?php echo $this->_tpl_vars['card']['label']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['card']['category']; ?>
</td>
				<td class="odd"><?php echo $this->_tpl_vars['card']['stimulant']; ?>
</td>
				<td class="even" style="text-align:center;width:40px;"><a class="delete" rel="<?php echo $this->_tpl_vars['card']['delHref']; ?>
" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
			</tr>
		<?php endforeach; else: ?>
			<tr>
				<td colspan="3"><?php echo $this->_tpl_vars['lang']['no_cards']; ?>
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

<?php endif; ?>