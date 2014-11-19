<?php /* Smarty version 2.6.22, created on 2012-06-19 17:33:08
         compiled from patientToolsSummary.tpl */ ?>
<script type="text/javascript" src="templates/default/scripts/jquery.simplemodal.js"></script>

<h1>Tools Summary/Inbox - <?php echo $this->_tpl_vars['patient']['first_name']; ?>
 <?php echo $this->_tpl_vars['patient']['middle_name']; ?>
 <?php echo $this->_tpl_vars['patient']['last_name']; ?>
</h1>

<div class="bttnCont">
	<a href="<?php echo $this->_tpl_vars['backHref']; ?>
">Back to Patient information page</a>
	<div class="clear"></div>
</div>
			
<div class="summaryHeader">
	<strong>Patient:</strong> <?php echo $this->_tpl_vars['patient']['first_name']; ?>
 <?php echo $this->_tpl_vars['patient']['middle_name']; ?>
 <?php echo $this->_tpl_vars['patient']['last_name']; ?>
<br />
	<?php echo $this->_tpl_vars['patient']['first_name']; ?>
 <?php echo $this->_tpl_vars['patient']['middle_name']; ?>
 <?php echo $this->_tpl_vars['patient']['last_name']; ?>
 uses - <?php $_from = $this->_tpl_vars['stimulants']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['stimulants'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['stimulants']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['stimulant']):
        $this->_foreach['stimulants']['iteration']++;
?><?php echo $this->_tpl_vars['stimulant']; ?>
<?php if (! ($this->_foreach['stimulants']['iteration'] == $this->_foreach['stimulants']['total'])): ?>, <?php endif; ?><?php endforeach; endif; unset($_from); ?><br />
	Flash time: <?php echo $this->_tpl_vars['spentTime']; ?>
 &nbsp; (<a style="color:#000" href="<?php echo $this->_tpl_vars['timeDetailsHref']; ?>
">See details...</a>)
	</div><!-- summaryheader -->

<br />

<div id="summaryLeft">
	<div class="bttns">
		<a href="#" rel="session1" class="session sessionActive">Session 1</a>
		<a href="#" rel="session2" class="session last">Session 2</a>
		<div class="clear"></div>
	</div>
	
	<div class="body" id="session1div">
		
				
		<?php $_from = $this->_tpl_vars['tools']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tools'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tools']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['tool']):
        $this->_foreach['tools']['iteration']++;
?>
			<?php if ($this->_tpl_vars['tool']['number'] == 1): ?>
				<a href="#" rel="box<?php echo $this->_tpl_vars['tool']['id']; ?>
" class="bttn"><span>Tool <?php echo $this->_foreach['tools']['iteration']; ?>
:</span><strong><?php echo $this->_tpl_vars['tool']['name']; ?>
</strong></a>
				<div id="box<?php echo $this->_tpl_vars['tool']['id']; ?>
" class="box">
					<?php if ($this->_tpl_vars['tool']['template']): ?>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['tool']['template'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php else: ?>
						<p>Empty</p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php if (! ($this->_foreach['tools']['iteration'] == $this->_foreach['tools']['total'])): ?><div class="spacer"></div><?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		
	</div>
	
	<div class="body" id="session2div" style="display:none">
		
				
		<?php $_from = $this->_tpl_vars['tools']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tools'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tools']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['tool']):
        $this->_foreach['tools']['iteration']++;
?>
			<?php if ($this->_tpl_vars['tool']['number'] == 2): ?>
				<a href="#" rel="box<?php echo $this->_tpl_vars['tool']['id']; ?>
" class="bttn"><span>Tool <?php echo $this->_foreach['tools']['iteration']; ?>
:</span><strong><?php echo $this->_tpl_vars['tool']['name']; ?>
</strong></a>
				<div id="box<?php echo $this->_tpl_vars['tool']['id']; ?>
" class="box">
					<?php if ($this->_tpl_vars['tool']['template']): ?>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['tool']['template'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php else: ?>
						<p>Empty</p>
					<?php endif; ?>
				</div>
				<?php if (! ($this->_foreach['tools']['iteration'] == $this->_foreach['tools']['total'])): ?><div class="spacer"></div><?php endif; ?>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		
	</div>
</div>

<?php if ($this->_tpl_vars['mailbox']): ?>
	<div id="summaryRight">
		<p class="header">Patient's inbox <span><?php echo $this->_tpl_vars['mailbox']['new']; ?>
 new email(s)</span></p>
		<div class="spacer2"></div>
		<div class="newMessage"><a href="#" class="newMsg">Create a New Message</a></div>
		<div class="spacer2"></div>
		
		<div class="body">
		
			<?php $_from = $this->_tpl_vars['mailbox']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['mails'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['mails']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['mail']):
        $this->_foreach['mails']['iteration']++;
?>
			
				<a href="#" rel="rightbox<?php echo $this->_foreach['mails']['iteration']; ?>
" class="bttn ">
									<strong style="float:left"><?php echo $this->_tpl_vars['mail']['from']; ?>
</strong>
					<span style="float:right"><?php echo $this->_tpl_vars['mail']['date']; ?>
</span>
					<ins style="clear:both;display:block;"></ins>
					<ins style="float:left"><?php echo $this->_tpl_vars['mail']['subject']; ?>
</ins>
					<ins style="clear:both;display:block;"></ins>
				</a>
				<div id="rightbox<?php echo $this->_foreach['mails']['iteration']; ?>
" class="box ">
					<?php echo $this->_tpl_vars['mail']['content']; ?>

					<ul class="panel">
						<li>
							<a href="#" class="cloudBttn" rel="removeCloud<?php echo $this->_foreach['mails']['iteration']; ?>
"><img src="templates/default/images/summary_arrow.png" alt="" />Remove</a>
							<div id="removeCloud<?php echo $this->_foreach['mails']['iteration']; ?>
" class="sendConfirm">
								<div class="cont">
									Are you sure you want to delete the message?<br />
									<a href="<?php echo $this->_tpl_vars['mail']['delHref']; ?>
" class="yes">Yes</a>
									<a href="#no" class="no">No</a>
								</div>
							</div>
						</li>
						<?php if (! $this->_tpl_vars['mail']['approved']): ?><li><a href="<?php echo $this->_tpl_vars['mail']['approveHref']; ?>
"><img src="templates/default/images/summary_arrow.png" alt="" />Approve</a></li><?php endif; ?>
					</ul>
					<div class="clear"></div>
				</div><!-- box -->
				<div class="spacer"></div>
				
			<?php endforeach; endif; unset($_from); ?>
			
		</div>
	</div>
<?php endif; ?>
<div class="clear"></div>

<?php $this->assign('form', $this->_tpl_vars['mailbox']['form']); ?>

<div id="addForm">
	<?php echo $this->_tpl_vars['form']['open']; ?>

		<fieldset>
			<p style="padding:0 0 5px 0">Subject:</p>
			<p><?php echo $this->_tpl_vars['form']['fields']['subject']['field']; ?>
</p>
			<?php if ($this->_tpl_vars['form']['fields']['subject']['errMsg']): ?><p class="errMsg"><?php echo $this->_tpl_vars['form']['fields']['subject']['errMsg']; ?>
</p><?php endif; ?>
			<br />
			<p style="padding:0 0 5px 0">Message:</p>
			<p><?php echo $this->_tpl_vars['form']['fields']['message']['field']; ?>
</p>
			<?php if ($this->_tpl_vars['form']['fields']['message']['errMsg']): ?><p class="errMsg"><?php echo $this->_tpl_vars['form']['fields']['message']['errMsg']; ?>
</p><?php endif; ?>
			<br />
			<a href="#" class="cancel">cancel</a>
			<input type="submit" name="addComment" value="send" class="submit" />
			<div class="clear"></div>
		</fieldset>
	<?php echo $this->_tpl_vars['form']['close']; ?>

</div>

<?php if ($this->_tpl_vars['mailbox']['approval']): ?>
	<div id="addForm2">
		<p><?php echo $this->_tpl_vars['mailbox']['approval']; ?>
</p>
		<a href="#" class="cancel" style="float:none;display:block;margin:10px auto 0 auto;">Ok</a>
	</div>
<?php endif; ?>

<script type="text/javascript">
<?php echo '
	$(document).ready(function(){
		$("#addForm .submit").click(function(){
			$(this).attr(\'disabled\',true);
		});
		$(".newMsg").click(function(){
			$("#addForm").modal({
				overlayClose:true,
				overlayId:\'tlfbCalendarOverlay\',
				closeClass:\'cancel\'
			});
			return false;
		});
		$("#summaryLeft .bttns a").click(function(){
			$("#summaryLeft .bttns a").removeClass(\'sessionActive\');
			$(this).addClass(\'sessionActive\');
			box_id = "#" + $(this).attr(\'rel\') + "div";
			$("#summaryLeft .body").hide();
			$(box_id).show();
			return false;
		});
		'; ?>

		<?php if ($this->_tpl_vars['mailbox']['showForm']): ?>
			<?php echo '
			$("#addForm").modal({
				overlayClose:true,
				overlayId:\'tlfbCalendarOverlay\',
				closeClass:\'cancel\'
			});
			'; ?>

		<?php endif; ?>
		<?php if ($this->_tpl_vars['mailbox']['approval']): ?>
			<?php echo '
			$("#addForm2").modal({
				overlayClose:true,
				overlayId:\'tlfbCalendarOverlay\',
				closeClass:\'cancel\'
			});
			'; ?>

		<?php endif; ?>
	});
</script>