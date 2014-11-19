<?php /* Smarty version 2.6.22, created on 2012-07-26 19:35:40
         compiled from admin/toolExperienced.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolExperienced.tpl', 54, false),)), $this); ?>

<?php if (! $this->_tpl_vars['addNew']): ?>

	<?php if ($this->_tpl_vars['edit']): ?>
	
		<h1>What Have I Experienced - edit</h1>
		
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
				<p><strong>Question:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['question']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['question']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['question']['errMsg']; ?>
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
	
		<h1>What Have I Experienced</h1>
		
		<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
		
				
		<table cellpadding="0" cellspacing="0" class="table">
		<thead>
			<tr>
				<th class="odd">ID</th>
				<th class="even">Question</th>
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
					<td class="odd"><?php echo $this->_tpl_vars['card']['id']; ?>
</td>
					<td class="even"><?php echo $this->_tpl_vars['card']['question']; ?>
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

	
<?php elseif ($this->_tpl_vars['addNew']): ?>

	<h1>Comments - new</h1>
		
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

		<fieldset>
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>Tool:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['tool']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['tool']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['tool']['errMsg']; ?>
</p><?php endif; ?>
			</div>
			<div class="clear"></div><br />
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>Name:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['name']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['name']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['name']['errMsg']; ?>
</p><?php endif; ?>
			</div>
			<div class="clear"></div><br />
			<div style="float:left;padding:0 20px 0 0" id="label2">
				<p><strong>Value:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['value']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['value']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['value']['errMsg']; ?>
</p><?php endif; ?>
			</div>
			<div class="clear"></div><br />
			
			<p class="adminBackToList">
				<input type="submit" name="submit" value="save" class="save" />
			</p>
		</fieldset>
		<?php echo $this->_tpl_vars['form']['close']; ?>

	
<?php endif; ?>