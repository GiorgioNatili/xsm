<?php /* Smarty version 2.6.22, created on 2012-04-25 17:12:16
         compiled from admin/toolHoliday.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolHoliday.tpl', 53, false),)), $this); ?>
<?php if ($this->_tpl_vars['new']): ?>

	<h1>Holidays - add new</h1>
		
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
		<div style="float:left;width:150px;">
			<p><strong>Day:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['day']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['day']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['day']['errMsg']; ?>
</p><?php endif; ?><br />
		</div>
		<div style="float:left;padding:0 0 0 50px;">
			<p><strong>Month:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['month']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['month']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['month']['errMsg']; ?>
</p><?php endif; ?><br />
		</div>
		<div class="clear"></div>
		
		<p><strong>Text:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['name']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['name']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['name']['errMsg']; ?>
</p><?php endif; ?><br />
			
		<p class="adminBackToList">
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>


<?php else: ?>
	<?php if ($this->_tpl_vars['textsList']): ?>
	
		<h1>Holidays <a href="<?php echo $this->_tpl_vars['addNewHref']; ?>
" class="addNew">Add new</a></h1>
		
		<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
		
		<table cellpadding="0" cellspacing="0" class="table">
		<thead>
			<tr>
				<th class="odd">ID</th>
				<th class="even">Date</th>
				<th class="odd">Text</th>
				<th class="even">&nbsp;</th>
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
					<td class="even"><?php echo $this->_tpl_vars['text']['date']; ?>
</td>
					<td class="odd"><?php echo $this->_tpl_vars['text']['text']; ?>
</td>
					<td class="even" style="text-align:center;width:40px;"><a class="delete" rel="<?php echo $this->_tpl_vars['text']['delHref']; ?>
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
		
	<?php elseif ($this->_tpl_vars['singleText']): ?>
	
		<h1>Holidays - <?php echo $this->_tpl_vars['singleText']['date']; ?>
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
			<div style="float:left;width:150px;">
				<p><strong>Day:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['day']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['day']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['day']['errMsg']; ?>
</p><?php endif; ?><br />
			</div>
			<div style="float:left;padding:0 0 0 50px;">
				<p><strong>Month:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['month']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['month']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['month']['errMsg']; ?>
</p><?php endif; ?><br />
			</div>
			<div class="clear"></div>
			
			<p><strong>Text:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['name']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['name']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['name']['errMsg']; ?>
</p><?php endif; ?><br />
				
			<p class="adminBackToList">
				<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br />
				<input type="submit" name="submit" value="save" class="save" />
			</p>
			
		</fieldset>
		<?php echo $this->_tpl_vars['form']['close']; ?>

	
	<?php endif; ?>
<?php endif; ?>