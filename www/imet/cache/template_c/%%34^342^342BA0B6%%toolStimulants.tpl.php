<?php /* Smarty version 2.6.22, created on 2012-06-01 16:20:06
         compiled from admin/toolStimulants.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolStimulants.tpl', 42, false),)), $this); ?>
<?php if ($this->_tpl_vars['edit']): ?>

	<h1>Substances - edit</h1>
	
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
			<p><strong>Substance:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['stimulant']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['stimulant']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['stimulant']['errMsg']; ?>
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

	<h1>Substances</h1>
	
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Substance</th>
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
				<td class="odd"><?php echo $this->_tpl_vars['card']['stimulant']; ?>
</td>
			</tr>
		<?php endforeach; else: ?>
			<tr>
				<td colspan="2"><?php echo $this->_tpl_vars['lang']['no_cards']; ?>
</td>
			</tr>
		<?php endif; unset($_from); ?>
	</tbody>
	</table>

<?php endif; ?>