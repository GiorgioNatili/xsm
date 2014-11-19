<?php /* Smarty version 2.6.22, created on 2012-06-01 16:14:13
         compiled from admin/toolNotifications.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolNotifications.tpl', 15, false),)), $this); ?>
<?php if ($this->_tpl_vars['textsList']): ?>

	<h1>Notifications</h1>
	
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">Text</th>
		</tr>
	</thead>
	<tbody>
		<?php $_from = $this->_tpl_vars['textsList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['textsList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['textsList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['textsList']['iteration']++;
?>
			<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
');">
				<td class="odd"><?php echo $this->_tpl_vars['item']['text']; ?>
</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	</tbody>
	</table>
	
<?php elseif ($this->_tpl_vars['singleText']): ?>

	<script type="text/javascript" src="lib/ckeditor/ckeditor.js"></script>

	<h1>Notification</h1>
	
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
		<p><strong>Notification:</strong></p>
		<div class="<?php if ($this->_tpl_vars['form']['fields']['body']['errMsg']): ?>textAreaError<?php endif; ?>"><?php echo $this->_tpl_vars['form']['fields']['body']['field']; ?>
</div>
		<?php if ($this->_tpl_vars['form']['fields']['body']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['body']['errMsg']; ?>
</p><?php endif; ?>

		<script type="text/javascript">
		<?php echo '
			$(document).ready(function(){
				CKEDITOR.replace( \'editor1\', { toolbar: \'Full\' } );
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


<?php endif; ?>