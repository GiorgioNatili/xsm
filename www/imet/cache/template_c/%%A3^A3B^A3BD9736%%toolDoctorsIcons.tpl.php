<?php /* Smarty version 2.6.22, created on 2012-08-10 12:55:40
         compiled from admin/toolDoctorsIcons.tpl */ ?>
<h1>Icons</h1>

<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>


<?php $_from = $this->_tpl_vars['icons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['icons'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['icons']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['icons']['iteration']++;
?>
	<div class="doctorIco" style="background-image:url(<?php echo $this->_tpl_vars['item']['img']; ?>
);">
		<a href="#" class="del" title="Delete" rel="<?php echo $this->_tpl_vars['item']['delHref']; ?>
">X</a> 
	</div>
<?php endforeach; else: ?>
	<p>No icons</p>
<?php endif; unset($_from); ?>
<div class="clear"></div>

<div class="adminBackToList" style="text-align:left">
	<?php echo $this->_tpl_vars['form']['open']; ?>

		<label>Add new icon</label>
		<?php echo $this->_tpl_vars['form']['fields']['icon']['field']; ?>

		<input type="submit" name="submit" class="save" value="Add" /><br />
		<?php if ($this->_tpl_vars['form']['fields']['icon']['errMsg']): ?><p style="color:red"><?php echo $this->_tpl_vars['form']['fields']['icon']['errMsg']; ?>
</p><?php endif; ?>
	<?php echo $this->_tpl_vars['form']['close']; ?>

</div>

<script type="text/javascript">
<?php echo '
	$(document).ready(function(){
		$(\'.doctorIco .del\').click(function(){
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