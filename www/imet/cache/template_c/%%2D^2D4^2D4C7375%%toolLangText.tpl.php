<?php /* Smarty version 2.6.22, created on 2012-07-26 19:42:21
         compiled from admin/toolLangText.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolLangText.tpl', 17, false),)), $this); ?>
<?php if ($this->_tpl_vars['textsList']): ?>

	<h1>Short texts</h1>
	
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">ID</th>
			<th class="even">Code</th>
			<th class="odd">Text</th>
		</tr>
	</thead>
	<tbody>
		<?php $_from = $this->_tpl_vars['textsList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['textsList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['textsList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['text']):
        $this->_foreach['textsList']['iteration']++;
?>
			<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['text']['href']; ?>
');">
				<td class="odd"><?php echo $this->_foreach['textsList']['iteration']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['text']['code']; ?>
</td>
				<td class="odd"><?php echo $this->_tpl_vars['text']['text']; ?>
</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	</tbody>
	</table>
	
<?php elseif ($this->_tpl_vars['singleText']): ?>

	<h1>Short texts - <?php echo $this->_tpl_vars['singleText']['code']; ?>
</h1>
	
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
		<p><strong>Text:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['text']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['text']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['text']['errMsg']; ?>
</p><?php endif; ?><br />
			
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>


<?php endif; ?>