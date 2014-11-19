<?php /* Smarty version 2.6.22, created on 2012-04-25 17:52:34
         compiled from admin/toolFlashStatic.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolFlashStatic.tpl', 16, false),)), $this); ?>
<?php if ($this->_tpl_vars['pagesList']): ?>

	<h1>Static pages</h1>
	
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr>
			<th class="odd">ID</th>
			<th class="even">Title</th>
		</tr>
	</thead>
	<tbody>
		<?php $_from = $this->_tpl_vars['pagesList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pagesList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pagesList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['page']):
        $this->_foreach['pagesList']['iteration']++;
?>
			<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['page']['href']; ?>
');">
				<td class="odd"><?php echo $this->_foreach['pagesList']['iteration']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['page']['title']; ?>
</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	</tbody>
	</table>
	
<?php elseif ($this->_tpl_vars['singlePage']): ?>

	<script type="text/javascript" src="lib/ckeditor/ckeditor.js"></script>

	<h1>Static pages - <?php echo $this->_tpl_vars['singlePage']['title']; ?>
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
		<p><strong><?php echo $this->_tpl_vars['lang']['title']; ?>
:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['title']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['title']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['title']['errMsg']; ?>
</p><?php endif; ?><br />
	
		<p><strong><?php echo $this->_tpl_vars['lang']['text']; ?>
:</strong></p>
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
		
		<?php if ($this->_tpl_vars['form']['fields']['body2']['field']): ?>
			<p>&nbsp;</p>
			<p><strong><?php echo $this->_tpl_vars['lang']['text']; ?>
 2:</strong></p>
			<div class="<?php if ($this->_tpl_vars['form']['fields']['body2']['errMsg']): ?>textAreaError<?php endif; ?>"><?php echo $this->_tpl_vars['form']['fields']['body2']['field']; ?>
</div>
			<?php if ($this->_tpl_vars['form']['fields']['body2']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['body2']['errMsg']; ?>
</p><?php endif; ?>
			<script type="text/javascript">
			<?php echo '
				$(document).ready(function(){
					CKEDITOR.replace( \'editor2\', { toolbar: \'Full\' } );
				});
			'; ?>

			</script>
		<?php endif; ?>
		
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>


<?php endif; ?>