<?php /* Smarty version 2.6.22, created on 2012-04-23 18:58:46
         compiled from admin/toolDoctors.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin/toolDoctors.tpl', 24, false),)), $this); ?>
<?php if (! $this->_tpl_vars['singleDoctor']): ?>

	<h1>Doctors</h1>
	
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
			<th class="odd">Login</th>
			<th class="even">First name</th>
			<th class="odd">Last name</th>
			<th class="even">Role</th>
			<th class="odd">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php $_from = $this->_tpl_vars['doctors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['doctors'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['doctors']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['doctors']['iteration']++;
?>
			<tr class="<?php echo smarty_function_cycle(array('values' => 'odd,even'), $this);?>
" onclick="redirect('<?php echo $this->_tpl_vars['item']['href']; ?>
');">
				<td class="odd"><?php echo $this->_tpl_vars['item']['login']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
				<td class="odd"><?php echo $this->_tpl_vars['item']['surname']; ?>
</td>
				<td class="even"><?php echo $this->_tpl_vars['item']['role']; ?>
</td>
				<td class="odd" style="text-align:center;width:40px;"><a class="delete" rel="<?php echo $this->_tpl_vars['item']['delHref']; ?>
" href="#"><img src="templates/default/images/delete.png" alt="" title="Delete" /></a></td>
			</tr>
		<?php endforeach; else: ?>
			<tr>
				<td colspan="5">No items</td>
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

	<h1>Doctors - <?php if ($this->_tpl_vars['addNew']): ?> add new<?php else: ?>edit<?php endif; ?></h1>
	
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
			<p><strong>Login:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['login']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['login']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['login']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong><?php if ($this->_tpl_vars['edit']): ?>New password<?php else: ?>Password<?php endif; ?>:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['pass1']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['pass1']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['pass1']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Re-password:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['pass2']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['pass2']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['pass2']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Password hint:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['passhint']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['passhint']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['passhint']['errMsg']; ?>
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
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Surname:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['surname']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['surname']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['surname']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Email:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['email']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['email']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['email']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Email 2:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['email2']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['email2']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['email2']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Organization:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['organization']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['organization']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['organization']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Telephone 1:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['phone1']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['phone1']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['phone1']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Telephone 2:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['phone2']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['phone2']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['phone2']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Role:</strong></p>
			<?php if ($this->_tpl_vars['edit']): ?>
				<?php echo $this->_tpl_vars['doctorType']; ?>

			<?php else: ?>
				<?php echo $this->_tpl_vars['form']['fields']['type']['field']; ?>
<br />
				<?php if ($this->_tpl_vars['form']['fields']['type']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['type']['errMsg']; ?>
</p><?php endif; ?>
			<?php endif; ?>
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Notes:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['notes']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['notes']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['notes']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<?php echo $this->_tpl_vars['form']['fields']['disabled']['field']; ?>
 &nbsp; <label for="disabled">Disabled</label>
		</div>
		<div class="clear"></div><br />
		
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Site:</strong></p>
			<?php echo $this->_tpl_vars['form']['fields']['site']['field']; ?>
<br />
			<?php if ($this->_tpl_vars['form']['fields']['site']['errMsg']): ?><p class="adminError"><?php echo $this->_tpl_vars['form']['fields']['site']['errMsg']; ?>
</p><?php endif; ?>
		</div>
		<div class="clear"></div><br />
		
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Choose icon:</strong></p>
		</div>
		<div class="clear"></div><br />
		
		
		
		<?php $_from = $this->_tpl_vars['icons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['icons'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['icons']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['icons']['iteration']++;
?>
			<div class="doctorIco<?php if ($this->_tpl_vars['item']['selected']): ?> doctorActiveIco<?php endif; ?>" style="background-image:url(<?php echo $this->_tpl_vars['item']['img']; ?>
);" rel="<?php echo $this->_tpl_vars['item']['id']; ?>
"></div>
		<?php endforeach; else: ?>
			<p>No icons</p>
		<?php endif; unset($_from); ?>
		<div class="clear"></div>
		<?php echo $this->_tpl_vars['form']['fields']['ico']['field']; ?>

		
		<div style="float:left;padding:0 20px 0 0">
			<p><strong>Access to:</strong></p>
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="1" id="patient_information" <?php if ($this->_tpl_vars['roles'][1]['checked']): ?>checked="checked"<?php endif; ?> /> &nbsp; <label for="patient_information">Patient information</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="2" id="events" <?php if ($this->_tpl_vars['roles'][2]['checked']): ?>checked="checked"<?php endif; ?> /> &nbsp; <label for="events">Events</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="3" id="substance_list" <?php if ($this->_tpl_vars['roles'][3]['checked']): ?>checked="checked"<?php endif; ?> /> &nbsp; <label for="substance_list">Substance list</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="4" id="eligibility_results" <?php if ($this->_tpl_vars['roles'][4]['checked']): ?>checked="checked"<?php endif; ?> /> &nbsp; <label for="eligibility_results">Eligibility results</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="5" id="journal" <?php if ($this->_tpl_vars['roles'][5]['checked']): ?>checked="checked"<?php endif; ?> /> &nbsp; <label for="journal">Journal</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="6" id="tools_summary" <?php if ($this->_tpl_vars['roles'][6]['checked']): ?>checked="checked"<?php endif; ?> /> &nbsp; <label for="tools_summary">Tools summary</label>
		</div>
		<div class="clear"></div><br />
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="7" id="mail" <?php if ($this->_tpl_vars['roles'][7]['checked']): ?>checked="checked"<?php endif; ?> /> &nbsp; <label for="mail">Mail</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="8" id="doctors" <?php if ($this->_tpl_vars['roles'][8]['checked']): ?>checked="checked"<?php endif; ?> /> &nbsp; <label for="doctors">Doctors</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="9" id="assessments" <?php if ($this->_tpl_vars['roles'][9]['checked']): ?>checked="checked"<?php endif; ?> /> &nbsp; <label for="assessments">Assessments</label>
		</div>
		<div style="float:left;padding:0 20px 0 0">
			<input type="checkbox" name="roles[]" value="10" id="add_new_patient" <?php if ($this->_tpl_vars['roles'][10]['checked']): ?>checked="checked"<?php endif; ?> /> &nbsp; <label for="add_new_patient">Add new patients</label>
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