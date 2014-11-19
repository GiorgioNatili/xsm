<?php /* Smarty version 2.6.22, created on 2012-06-01 16:19:47
         compiled from admin/toolTailItUp.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolTailItUp.tpl', 20, false),array('modifier', 'strip_tags', 'admin/toolTailItUp.tpl', 62, false),array('modifier', 'truncate', 'admin/toolTailItUp.tpl', 62, false),)), $this); ?>

<?php if (! $this->_tpl_vars['addNew']): ?>

	<?php if ($this->_tpl_vars['stimulants']): ?>
	
		<h1>Tail It Up!</h1>
		
		<?php if ($this->_tpl_vars['toolSaved']): ?><p class="toolSaved"><?php echo $this->_tpl_vars['toolSaved']; ?>
</p><?php endif; ?>
		
		<table cellpadding="0" cellspacing="0" class="table">
		<thead>
			<tr>
				<th class="odd">Stimulant</th>
				<th class="even">Box Label</th>
			</tr>
		</thead>
		<tbody>
			<?php $_from = $this->_tpl_vars['stimulants']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['stimulants'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['stimulants']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['stimulant']):
        $this->_foreach['stimulants']['iteration']++;
?>
				<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['stimulant']['href']; ?>
');">
					<td class="odd"><?php echo $this->_tpl_vars['stimulant']['name']; ?>
</td>
					<td class="even"><?php echo $this->_tpl_vars['stimulant']['label']; ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
		</tbody>
		</table>
		
	<?php elseif ($this->_tpl_vars['stimulant']): ?>
	
		<h1>Tail It Up! - <?php echo $this->_tpl_vars['stimulant']['stimulant']; ?>
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
			<p><strong>Box label:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['label']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['label']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['label']['errMsg']; ?>
</p><?php endif; ?><br />
			
			<div class="bttnCont">
				<a href="<?php echo $this->_tpl_vars['newHref']; ?>
">Add new</a>
				<div class="clear"></div>
			</div>
	
			<table cellpadding="0" cellspacing="0" class="table">
			<thead>
				<tr>
					<th class="odd">Calculator Info Text</th>
					<th class="even">Stuff Info Text</th>
					<th class="odd">Type</th>
					<th class="even">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php $_from = $this->_tpl_vars['types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['types'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['types']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['type']):
        $this->_foreach['types']['iteration']++;
?>
					<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['type']['href']; ?>
');">
						<td class="odd"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['type']['calculator_info'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp, false) : smarty_modifier_strip_tags($_tmp, false)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 50, "&hellip;") : smarty_modifier_truncate($_tmp, 50, "&hellip;")); ?>
</td>
						<td class="even"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['type']['stuff_info'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp, false) : smarty_modifier_strip_tags($_tmp, false)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 50, "&hellip;") : smarty_modifier_truncate($_tmp, 50, "&hellip;")); ?>
</td>
						<td class="odd"><?php echo $this->_tpl_vars['type']['type']; ?>
</td>
						<td class="even" style="text-align:center;width:40px;"><a class="delete" rel="<?php echo $this->_tpl_vars['type']['delHref']; ?>
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
			
			<p class="adminBackToList">
				<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br />
				<input type="submit" name="submit" value="save" class="save" />
			</p>
			
		</fieldset>
		<?php echo $this->_tpl_vars['form']['close']; ?>

		
	<?php elseif ($this->_tpl_vars['stimulantName'] && $this->_tpl_vars['isTypes']): ?>
	
		<h1>Tail It Up! - <?php echo $this->_tpl_vars['stimulantName']; ?>
 - <?php echo $this->_tpl_vars['typeName']; ?>
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
		
			<p><strong>Calculator Info Text:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['info1']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['info1']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['info1']['errMsg']; ?>
</p><?php endif; ?><br />
			
			<p><strong>Stuff Info Text:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['info2']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['info2']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['info2']['errMsg']; ?>
</p><?php endif; ?><br />
			
			<p><strong>Type:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['type']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['type']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['type']['errMsg']; ?>
</p><?php endif; ?><br />
			
			
			
			
			<div id="optionList">
				<p><strong>Stuffs:</strong></p>
				<ul>
					<?php $_from = $this->_tpl_vars['stuffs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['stuffs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['stuffs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['stuffs']['iteration']++;
?>
						<li style="float:left; padding-right:20px;line-height:18px;">
							<?php echo $this->_tpl_vars['item']['name']; ?>

							<a href="<?php echo $this->_tpl_vars['item']['delHref']; ?>
" class="delete" title="Delete"><img src="templates/default/images/delete.png" alt="" style="vertical-align:top;" /></a>
						</li>
					<?php endforeach; endif; unset($_from); ?>
					<li style="float:left;width:90px;">
						<a href="<?php echo $this->_tpl_vars['newStuffHref']; ?>
" style="color:#000;font-weight:bold;">Add new</a>
					</li>
				</ul>
				<div class="clear"></div>
			</div>
			
			
			
			
			
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
				<?php $_from = $this->_tpl_vars['types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['types'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['types']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['type']):
        $this->_foreach['types']['iteration']++;
?>
					<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['type']['href']; ?>
');">
						<td class="odd"><?php echo $this->_tpl_vars['type']['label']; ?>
</td>
						<td class="even"><?php echo $this->_tpl_vars['type']['type']; ?>
</td>
						<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="<?php echo $this->_tpl_vars['type']['delHref']; ?>
" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
					</tr>
				<?php endforeach; else: ?>
					<tr>
						<td colspan="3"><?php echo $this->_tpl_vars['lang']['no_types']; ?>
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
			
			<p class="adminBackToList">
				<input type="checkbox" name="backToList" class="back" value="1" checked="checked" id="backToList" /><label for="backToList"><?php echo $this->_tpl_vars['lang']['back_to_list']; ?>
</label><br />
				<input type="submit" name="submit" value="save" class="save" />
			</p>
			
		</fieldset>
		<?php echo $this->_tpl_vars['form']['close']; ?>

	
	<?php elseif ($this->_tpl_vars['stimulantName'] && $this->_tpl_vars['calOption']): ?>
	
		<h1>Tail It Up! - <?php echo $this->_tpl_vars['stimulantName']; ?>
 - <?php echo $this->_tpl_vars['typeName']; ?>
 - options</h1>
		
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
				<p><strong>Label:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['label']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['label']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['label']['errMsg']; ?>
</p><?php endif; ?>
			</div>
			<div style="float:left">
				<p><strong>Type:</strong></p>
				<?php echo $this->_tpl_vars['form']['fields']['type']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['type']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['type']['errMsg']; ?>
</p><?php endif; ?>
			</div>
			<div class="clear"></div><br />
			
			
			<div id="optionList"<?php if ($this->_tpl_vars['calOption']['type'] == 'input'): ?> style="display:none"<?php endif; ?>>
				<ul>
					<?php $_from = $this->_tpl_vars['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['values'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['values']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['value']):
        $this->_foreach['values']['iteration']++;
?>
						<li>
							Label: <input class="adminInput" style="width:150px;margin-right:20px;" type="text" name="label_<?php echo $this->_foreach['values']['iteration']; ?>
" value="<?php echo $this->_tpl_vars['value']['label']; ?>
" />
							Data:  <input class="adminInput" style="width:80px;margin-right:20px;" type="text" name="data_<?php echo $this->_foreach['values']['iteration']; ?>
" value="<?php echo $this->_tpl_vars['value']['data']; ?>
" />
							<a href="#" onclick="return deleteRow(this);" class="delete" title="Delete"><img src="templates/default/images/delete.png" alt="" style="vertical-align:middle;" /></a>
						</li>
					<?php endforeach; endif; unset($_from); ?>
				</ul>
				<a href="#" class="addNew">Add new</a>
			</div>
			
			
			<script type="text/javascript">
			<?php echo '
				$(document).ready(function(){
					$("#optionsType").change(function(){
						if($(this).val() == 1)
						{
							$("#optionList").hide();
						}
						else if($(this).val() == 2)
						{
							$("#optionList").show();
						}
					});
					
					$("#optionList .addNew").click(function(){
						var id=1;
						$("#optionList ul li").each(function(i){
							id++;
						});
						var html = \'<li>\';
							html += \'Label: <input class="adminInput" style="width:150px;margin-right:20px;" type="text" name="label_\' + id + \'" value="" /> \';
							html += \'Data:  <input class="adminInput" style="width:80px;margin-right:20px;" type="text" name="data_\' + id + \'" value="" /> \';
							html += \'<a href="#" onclick="return deleteRow(this);" class="delete" title="Delete"><img src="templates/default/images/delete.png" alt="" style="vertical-align:middle;" /></a>\';
							html += \'</li>\';
						$("#optionList ul").append(html);
						return false;
					});
				});
				
				function deleteRow(row)
				{
					$(row).parent().remove();
					return false;
				}
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

	
<?php elseif ($this->_tpl_vars['addNew'] == 1): ?>
	
	<h1>Tail It Up! - <?php echo $this->_tpl_vars['stimulant']['stimulant']; ?>
 - new type</h1>
		
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
	
		<p><strong>Calculator Info Text:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['info1']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['info1']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['info1']['errMsg']; ?>
</p><?php endif; ?><br />
		
		<p><strong>Stuff Info Text:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['info2']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['info2']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['info2']['errMsg']; ?>
</p><?php endif; ?><br />
		
		<p><strong>Type:</strong></p>
		<?php echo $this->_tpl_vars['form']['fields']['type']['field']; ?>
<br />
		<?php if ($this->_tpl_vars['form']['fields']['type']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['type']['errMsg']; ?>
</p><?php endif; ?><br />
		
		<p class="adminBackToList">
			<input type="submit" name="submit" value="add" class="save" />
		</p>
		
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>

	
<?php elseif ($this->_tpl_vars['addNew'] == 2): ?>

	<h1>Tail It Up! - <?php echo $this->_tpl_vars['stimulant']['stimulant']; ?>
 - <?php echo $this->_tpl_vars['typeName']; ?>
 - new type</h1>
	
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
	
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Label:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['label']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['label']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['label']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div style="float:left">
			<p><strong>Type:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['type']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['type']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['type']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div class="clear"></div>
		<br />
	
		<p class="adminBackToList">
			<input type="submit" name="submit" value="add" class="save" />
		</p>
	
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>


<?php elseif ($this->_tpl_vars['addNew'] == 3): ?>

	<h1>Tail It Up! - <?php echo $this->_tpl_vars['stimulant']['stimulant']; ?>
 - <?php echo $this->_tpl_vars['typeName']; ?>
 - new stuff</h1>
	
	<div class="bttnCont">
		<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back</a>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->_tpl_vars['form']['open']; ?>

	<fieldset>
	
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Stuff list:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['stuff']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['stuff']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['stuff']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div class="clear"></div>
		<br />
	
		<p class="adminBackToList">
			<input type="submit" name="submit" value="add" class="save" />
		</p>
	
	</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>


<?php endif; ?>