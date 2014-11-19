<?php /* Smarty version 2.6.22, created on 2012-07-26 19:35:36
         compiled from admin/toolTailItUpStuffs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolTailItUpStuffs.tpl', 22, false),)), $this); ?>
<?php if ($this->_tpl_vars['stuffs']): ?>

	<h1>Tail It Up! - Things</h1>
			
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
			<th class="odd">Text</th>
			<th class="even">Value</th>
			<th class="odd">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php $_from = $this->_tpl_vars['stuffs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['stuffs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['stuffs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['stuff']):
        $this->_foreach['stuffs']['iteration']++;
?>
			<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['stuff']['href']; ?>
');">
				<td class="odd"><?php echo $this->_tpl_vars['stuff']['text']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['stuff']['value']; ?>
</td>
				<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="<?php echo $this->_tpl_vars['stuff']['delHref']; ?>
" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
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
	
<?php elseif ($this->_tpl_vars['form']): ?>

	<h1>Tail It Up! - Things</h1>
			
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
			<p><strong>Text:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['text']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['text']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['text']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div style="float:left">
			<p><strong>Value:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['value']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['value']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['value']['errMsg']; ?>
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


<?php endif; ?>