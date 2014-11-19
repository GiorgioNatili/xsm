<?php /* Smarty version 2.6.22, created on 2012-06-01 16:14:14
         compiled from admin/toolCsbirtLinks.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolCsbirtLinks.tpl', 44, false),)), $this); ?>

<?php if ($this->_tpl_vars['edit']): ?>

	<h1>cSbirt Link - edit</h1>
	
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Link:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['link']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['link']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['link']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div class="clear"></div><br />
		
		<p class="adminBackToList">
			<?php if ($this->_tpl_vars['edit']): ?><input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br /><?php endif; ?>
			<input type="submit" name="submit" value="save" class="save" />
		</p>
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>

	
<?php else: ?>

	<h1>cSbirt Link</h1>
	
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Link</th>
		</tr>
	</thead>
	<tbody>
		<?php $_from = $this->_tpl_vars['cards']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cardsList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cardsList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['card']):
        $this->_foreach['cardsList']['iteration']++;
?>
			<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['card']['href']; ?>
');">
				<td class="even"><?php echo $this->_tpl_vars['card']['link']; ?>
</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
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