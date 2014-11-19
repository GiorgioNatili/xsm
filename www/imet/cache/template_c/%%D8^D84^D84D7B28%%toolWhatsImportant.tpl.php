<?php /* Smarty version 2.6.22, created on 2012-07-26 19:35:47
         compiled from admin/toolWhatsImportant.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolWhatsImportant.tpl', 100, false),)), $this); ?>

<?php if (! $this->_tpl_vars['addNew']): ?>

	<?php if ($this->_tpl_vars['edit']): ?>
	
		<h1>What's important to me? - edit card</h1>
		
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
				<p><strong>Type:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['type']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['type']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['type']['errMsg']; ?>
</p><?php endif; ?>
			</div>
			<div style="float:left;">
				<p><strong>Background:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['background']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['background']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['background']['errMsg']; ?>
</p><?php endif; ?>
			</div>
			<div class="clear"></div><br />
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>Label:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['label1']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['label1']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['label1']['errMsg']; ?>
</p><?php endif; ?>
			</div>
			<div style="float:left;padding:0 20px 0 0" id="label2">
				<p><strong>Second side label:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['label2']['field']; ?>
<br />
			</div>
			<div class="clear"></div><br />
			
			<p class="adminBackToList">
				<?php if ($this->_tpl_vars['edit']): ?><input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br /><?php endif; ?>
				<input type="submit" name="submit" value="save" class="save" />
			</p>
			
		</fieldset>
		<?php echo $this->_tpl_vars['form']['close']; ?>

		
		<script type="text/javascript">
		<?php echo '
			$(document).ready(function(){
			
				if($(\'#typeSelect\').val() == \'1\') $(\'#label2\').hide();
			
				$(\'#typeSelect\').change(function(){
					if($(this).val() == \'1\')
					{
						$(\'#label2\').hide();
					}
					else
					{
						$(\'#label2\').show();
					}
				});
				
				$(\'#background\').ColorPicker({
									onSubmit: function(hsb, hex, rgb, el) {
										$(el).val(hex);
										$(el).ColorPickerHide();
									},
									onBeforeShow: function () {
										$(this).ColorPickerSetColor(this.value);
									}
				});
				
			});
		'; ?>

		</script>
		
	<?php else: ?>
	
		<h1>What's important to me?</h1>
		
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
				<th class="even">Type</th>
				<th class="odd">&nbsp;</th>
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
					<td class="odd"><?php echo $this->_tpl_vars['card']['label']; ?>
</td>
					<td class="even"><?php echo $this->_tpl_vars['card']['type']; ?>
</td>
					<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="<?php echo $this->_tpl_vars['card']['delHref']; ?>
" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
				</tr>
			<?php endforeach; else: ?>
				<tr>
					<td colspan="2"><?php echo $this->_tpl_vars['lang']['no_cards']; ?>
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

	
<?php elseif ($this->_tpl_vars['addNew']): ?>

	<h1>What's important to me? - new card</h1>
		
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Type:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['type']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['type']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['type']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div style="float:left;">
			<p><strong>Background:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['background']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['background']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['background']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Label:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['label1']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['label1']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['label1']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div style="float:left;padding:0 20px 0 0" id="label2">
			<p><strong>Second side label:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['label2']['field']; ?>
<br />
		</div>
		<div class="clear"></div><br />
		
		<p class="adminBackToList">
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>

	
	<script type="text/javascript">
	<?php echo '
		$(document).ready(function(){
		
			if($(\'#typeSelect\').val() == \'1\') $(\'#label2\').hide();
		
			$(\'#typeSelect\').change(function(){
				if($(this).val() == \'1\')
				{
					$(\'#label2\').hide();
				}
				else
				{
					$(\'#label2\').show();
				}
			});
			
			$(\'#background\').ColorPicker({
								onSubmit: function(hsb, hex, rgb, el) {
									$(el).val(hex);
									$(el).ColorPickerHide();
								}
			});
			
		});
	'; ?>

	</script>

<?php endif; ?>