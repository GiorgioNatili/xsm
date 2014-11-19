<?php /* Smarty version 2.6.22, created on 2012-08-10 17:32:04
         compiled from admin/toolDoctorsSites.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolDoctorsSites.tpl', 24, false),)), $this); ?>
<?php if (! $this->_tpl_vars['singleSite']): ?>

	<h1>Sites</h1>
	
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
			<th class="odd">Name</th>
			<th class="even">Code</th>
			<th class="odd">Doctors</th>
			<th class="even">Patients</th>
			<th class="odd">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sites'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sites']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['sites']['iteration']++;
?>
			<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
');">
				<td class="odd"><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['item']['code']; ?>
</td>
				<td class="odd"><?php echo $this->_tpl_vars['item']['quantityDoctors']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['item']['quantityPatients']; ?>
</td>
				<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="<?php echo $this->_tpl_vars['item']['delHref']; ?>
" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
			</tr>
		<?php endforeach; else: ?>
			<tr>
				<td colspan="2">No items</td>
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
	
<?php else: ?>

	<h1>Sites - <?php if ($this->_tpl_vars['edit']): ?> edit<?php else: ?>add new<?php endif; ?></h1>
	
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
				<p><strong>Name:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['name']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['name']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['name']['errMsg']; ?>
</p><?php endif; ?>
			</div>
			<div style="float:left;padding:0 20px 0 0">
				<p><strong>Code:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['code']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['code']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['code']['errMsg']; ?>
</p><?php endif; ?>
			</div>
			<div class="clear"></div><br />
			
			<p class="adminBackToList">
				<?php if ($this->_tpl_vars['edit']): ?><input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br /><?php endif; ?>
				<input type="submit" name="submit" value="<?php if ($this->_tpl_vars['edit']): ?>Save<?php else: ?>Add<?php endif; ?>" class="save" />
			</p>
		</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>

	
	<script type="text/javascript">
	<?php echo '
		$(document).ready(function(){
			$(\'.doctorIco\').click(function(){
				if($(this).hasClass(\'doctorActiveIco\'))
				{
					$(this).removeClass(\'doctorActiveIco\');
					$("#doctorIcoId").val(\'\');
				}
				else
				{
					$(\'.doctorIco\').removeClass(\'doctorActiveIco\');
					$(this).addClass(\'doctorActiveIco\');
					$("#doctorIcoId").val($(this).attr(\'rel\'));
				}
			});
		});
	'; ?>

	</script>

<?php endif; ?>