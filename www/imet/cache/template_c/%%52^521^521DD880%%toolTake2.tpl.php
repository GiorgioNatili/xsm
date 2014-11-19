<?php /* Smarty version 2.6.22, created on 2012-07-26 19:35:16
         compiled from admin/toolTake2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolTake2.tpl', 46, false),)), $this); ?>
<?php if ($this->_tpl_vars['singleCoupon']): ?>

	<h1>Take 2 - answers</h1>
		
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
		<p><strong>Fan:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['coupon']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['coupon']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['coupon']['errMsg']; ?>
</p><?php endif; ?><br />
		
		<div style="float:left;padding:0 15px 0 0;">
			<p><strong>Substance:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['type']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['type']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['type']['errMsg']; ?>
</p><?php endif; ?><br />
		</div>
		<div style="float:left">
			<p><strong>Set:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['set']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['set']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['set']['errMsg']; ?>
</p><?php endif; ?><br />
		</div>
		
		<?php if (! $this->_tpl_vars['addSingleCoupon']): ?>
		
			<div class="bttnCont">
				<a href="<?php echo $this->_tpl_vars['newHref']; ?>
">Add new</a>
				<div class="clear"></div>
			</div>
	
			<table cellpadding="0" cellspacing="0" class="table">
			<thead>
				<tr>
					<th class="odd">Answer</th>
					<th class="even">Input mode</th>
					<th class="odd">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php $_from = $this->_tpl_vars['answers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['answers'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['answers']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['answers']['iteration']++;
?>
					<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
');">
						<td class="odd"><?php echo $this->_tpl_vars['item']['answer']; ?>
</td>
						<td class="even"><?php echo $this->_tpl_vars['item']['input']; ?>
</td>
						<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="<?php echo $this->_tpl_vars['item']['delHref']; ?>
" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
					</tr>
				<?php endforeach; else: ?>
					<tr>
						<td colspan="4"><?php echo $this->_tpl_vars['lang']['no_types']; ?>
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
		
		<p class="adminBackToList">
			<?php if (! $this->_tpl_vars['addSingleCoupon']): ?><input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br /><?php endif; ?>
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>

	
<?php elseif ($this->_tpl_vars['singleAnswer']): ?>

	<h1>Take2 - single answer</h1>
		
	<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
	
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
		<p><strong>Answer:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['text']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['text']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['text']['errMsg']; ?>
</p><?php endif; ?><br />
		
		<p style="padding:0 0 5px 0"><strong>Input mode:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['inputmode']['field']; ?>
<label for="inputmode" style="padding:0 0 0 10px;vertical-align:top;">Yes</label><br />
		
		<p class="adminBackToList">
			<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br />
			<input type="submit" name="submit" value="save" class="save" />
		</p>
		
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>


<?php else: ?>

	<h1>Take 2 - fan</h1>
	
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
			<th class="odd">Fan</th>
			<th class="even">Substance</th>
			<th class="even">Set</th>
			<th class="odd">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php $_from = $this->_tpl_vars['coupons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['coupons'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['coupons']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['coupons']['iteration']++;
?>
			<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
');">
				<td class="odd"><?php echo $this->_tpl_vars['item']['text']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['item']['substance']; ?>
</td>
				<td class="odd"><?php echo $this->_tpl_vars['item']['set']; ?>
</td>
				<td class="even" style="text-align:center;width:40px;"><a class="delete" rel="<?php echo $this->_tpl_vars['item']['delHref']; ?>
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

<?php endif; ?>