<?php /* Smarty version 2.6.22, created on 2012-07-26 19:35:09
         compiled from admin/toolTake2Sets.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolTake2Sets.tpl', 45, false),)), $this); ?>
<?php if ($this->_tpl_vars['singleCard']): ?>

	<h1>Take 2 - Sets</h1>
		
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
		<p><strong>Card class:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['card']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['card']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['card']['errMsg']; ?>
</p><?php endif; ?><br />
		
		<p><strong>Info:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['info']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['info']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['info']['errMsg']; ?>
</p><?php endif; ?><br />
		
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>


<?php else: ?>

	<h1>Take 2 - Sets</h1>
	
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Set</th>
			<th class="even">Info</th>
		</tr>
	</thead>
	<tbody>
		<?php $_from = $this->_tpl_vars['sets']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['coupons'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['coupons']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['coupons']['iteration']++;
?>
			<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
');">
				<td class="odd"><?php echo $this->_tpl_vars['item']['set']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['item']['info']; ?>
</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	</tbody>
	</table>

<?php endif; ?>