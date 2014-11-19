<?php /* Smarty version 2.6.22, created on 2012-08-02 13:01:45
         compiled from mailbox.tpl */ ?>
<script type="text/javascript" src="templates/default/scripts/jquery.simplemodal.js"></script>

<h1 style="width:300px;float:left">Mailbox</h1>
<div style="float:right;">
	<span>Sort patients:</span>
	<select id="mailSort" name="sortPatients" style="width:200px">
		<?php $_from = $this->_tpl_vars['patients']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['patients'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['patients']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['patients']['iteration']++;
?>
			<option value="<?php echo $this->_tpl_vars['item']['key']; ?>
"<?php if ($this->_tpl_vars['item']['selected']): ?> selected="selected"<?php endif; ?>>
				<?php if ($this->_tpl_vars['item']['key'] == 0): ?>All<?php else: ?><?php echo $this->_tpl_vars['item']['value']; ?>
<?php endif; ?>
			</option>
		<?php endforeach; endif; unset($_from); ?>
	</select>
</div>
<div class="clear"></div>


<div id="summaryRight" style="float:left">
	<p class="header">Inbox <span><?php echo $this->_tpl_vars['inbox']['new']; ?>
 new email(s)</span></p>
	<div class="spacer2"></div>
	<div class="newMessage" style="height:19px">&nbsp;</div>
	<div class="spacer2"></div>
	
	<div class="body">
	
		<?php $_from = $this->_tpl_vars['inbox']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['mails'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['mails']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['mail']):
        $this->_foreach['mails']['iteration']++;
?>
		
			<a href="#" rel="rightbox<?php echo $this->_tpl_vars['mail']['id']; ?>
" class="bttn<?php if (! $this->_tpl_vars['mail']['read']): ?> unread<?php endif; ?>">
				<strong style="float:left"><?php echo $this->_tpl_vars['mail']['sender']; ?>
</strong>
				<span style="float:right"><?php echo $this->_tpl_vars['mail']['date']; ?>
</span>
				<ins style="clear:both;display:block;"></ins>
				<ins style="float:left" class="subject<?php echo $this->_tpl_vars['mail']['id']; ?>
"><?php echo $this->_tpl_vars['mail']['subject']; ?>
</ins>
				<ins style="clear:both;display:block;"></ins>
			</a>
			<div id="rightbox<?php echo $this->_tpl_vars['mail']['id']; ?>
" class="box">
				<div class="mailbody"><?php echo $this->_tpl_vars['mail']['content']; ?>
</div>
				<ul class="panel">
					<li>
						<a href="#" class="cloudBttn" rel="removeCloud<?php echo $this->_tpl_vars['mail']['id']; ?>
"><img src="templates/default/images/summary_arrow.png" alt="" />Remove</a>
						<div id="removeCloud<?php echo $this->_tpl_vars['mail']['id']; ?>
" class="sendConfirm">
							<div class="cont">
								Are you sure you want to delete the message?<br />
								<a href="<?php echo $this->_tpl_vars['mail']['delHref']; ?>
" class="yes">Yes</a>
								<a href="#no" class="no">No</a>
							</div>
						</div>
					</li>
					<?php if (! $this->_tpl_vars['mail']['approved']): ?>
						<li><a href="#" class="edit" rel="mail_<?php echo $this->_tpl_vars['mail']['id']; ?>
"><img src="templates/default/images/summary_arrow.png" alt="" />Edit</a></li>
						<li><a href="<?php echo $this->_tpl_vars['mail']['approveHref']; ?>
"><img src="templates/default/images/summary_arrow.png" alt="" />Approve</a></li>
					<?php else: ?>
						<?php if (! $this->_tpl_vars['mail']['read']): ?><li><a href="<?php echo $this->_tpl_vars['mail']['readHref']; ?>
"><img src="templates/default/images/summary_arrow.png" alt="" />Read</a></li><?php endif; ?>
					<?php endif; ?>
					<li><a href="#" class="replyTo" rel="<?php echo $this->_tpl_vars['mail']['id']; ?>
_<?php echo $this->_tpl_vars['mail']['sender_type']; ?>
_<?php echo $this->_tpl_vars['mail']['sender_id']; ?>
"><img src="templates/default/images/summary_arrow.png" alt="" />Reply</a></li>
				</ul>
				<div class="clear"></div>
			</div><!-- box -->
			<div class="spacer"></div>
			
		<?php endforeach; endif; unset($_from); ?>
		
	</div>
</div>

<div id="summaryRight2">
	<p class="header">Sent</p>
	<div class="spacer2"></div>
	<div class="newMessage"><a href="#" class="newMsg">Create a New Message</a></div>
	<div class="spacer2"></div>
	
	<div class="body">
	
		<?php $_from = $this->_tpl_vars['sent']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['mails'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['mails']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['mail']):
        $this->_foreach['mails']['iteration']++;
?>
		
			<a href="#" rel="rightbox<?php echo $this->_tpl_vars['mail']['id']; ?>
" class="bttn ">
				<strong style="float:left"><?php echo $this->_tpl_vars['mail']['sender']; ?>
</strong>
				<span style="float:right"><?php echo $this->_tpl_vars['mail']['date']; ?>
</span>
				<ins style="clear:both;display:block;"></ins>
				<ins style="float:left"><?php echo $this->_tpl_vars['mail']['subject']; ?>
</ins>
				<ins style="clear:both;display:block;"></ins>
			</a>
			<div id="rightbox<?php echo $this->_tpl_vars['mail']['id']; ?>
" class="box ">
				<?php echo $this->_tpl_vars['mail']['content']; ?>

				<ul class="panel">
					<li>
						<a href="#" class="cloudBttn" rel="removeCloud<?php echo $this->_tpl_vars['mail']['id']; ?>
"><img src="templates/default/images/summary_arrow.png" alt="" />Remove</a>
						<div id="removeCloud<?php echo $this->_tpl_vars['mail']['id']; ?>
" class="sendConfirm">
							<div class="cont">
								Are you sure you want to delete the message?<br />
								<a href="<?php echo $this->_tpl_vars['mail']['delHref']; ?>
" class="yes">Yes</a>
								<a href="#no" class="no">No</a>
							</div>
						</div>
					</li>
				</ul>
				<div class="clear"></div>
			</div><!-- box -->
			<div class="spacer"></div>
			
		<?php endforeach; endif; unset($_from); ?>
		
	</div>
</div>
<div class="clear"></div>

<div id="addForm">
	<?php echo $this->_tpl_vars['form']['open']; ?>

		<fieldset>
			<ul class="receiver">
				<li>Receiver:</li>
				<li>
					<input type="radio" name="sendTo" value="1" id="sendTo1" <?php if ($this->_tpl_vars['formSendTo'] == 1): ?>checked="checked"<?php endif; ?> /> 
					<label for="sendTo1">Patient</label> 
					<?php echo $this->_tpl_vars['form']['fields']['patients']['field']; ?>

					<div class="clear"></div>
					<?php if ($this->_tpl_vars['form']['fields']['patients']['errMsg']): ?>
						<p class="errMsg patientsErr" style="padding-left:80px;width:220px"><?php echo $this->_tpl_vars['form']['fields']['patients']['errMsg']; ?>
</p>
					<?php endif; ?>
				</li>
				<li>
					<input type="radio" name="sendTo" value="2" id="sendTo2" <?php if ($this->_tpl_vars['formSendTo'] == 2): ?>checked="checked"<?php endif; ?> /> 
					<label for="sendTo2">Doctor</label> 
					<?php echo $this->_tpl_vars['form']['fields']['doctors']['field']; ?>

					<div class="clear"></div>
					<?php if ($this->_tpl_vars['form']['fields']['doctors']['errMsg']): ?>
						<p class="errMsg doctorsErr" style="padding-left:80px;width:220px"><?php echo $this->_tpl_vars['form']['fields']['doctors']['errMsg']; ?>
</p>
					<?php endif; ?>
				</li>
				<?php if ($this->_tpl_vars['form']['submitted'] && ! $this->_tpl_vars['formSendTo']): ?>
					<li>
						<p class="errMsg"><?php echo $this->_tpl_vars['lang']['form_pole_obowiazkowe']; ?>
</p>
					</li>
				<?php endif; ?>
				<li class="msgType" <?php if ($this->_tpl_vars['formSendTo'] == 2): ?>style="display:block"<?php endif; ?>>
					Message type:<br />
					<?php echo $this->_tpl_vars['form']['fields']['msgTypes']['field']; ?>

					<div class="clear"></div>
				</li>
				<li class="msgTypePatients" <?php if ($this->_tpl_vars['formSendTo'] == 2): ?>style="display:block"<?php endif; ?>>
					Patient:<br />
					<?php echo $this->_tpl_vars['form']['fields']['msgTypePatients']['field']; ?>

					<div class="clear"></div>
				</li>
			</ul>
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

<div id="addForm2">
	<form method="post" action="" id="editForm">
		<fieldset>
			<p style="padding:0 0 5px 0">Subject:</p>
			<p><input type="text" class="subject" style="" value="" name="editSubject" /></p>
			<p class="errMsg subjectError" style="display:none">This is a required field.</p>
			<br />
			<p style="padding:0 0 5px 0">Message:</p>
			<p><textarea class="calendarComment" rows="1" cols="1" name="editMessage"></textarea></p>
			<p class="errMsg msgError" style="display:none">This is a required field.</p>
			<br />
			<a href="#" class="cancel">cancel</a>
			<input type="hidden" class="editID" name="edit_id" value="" />
			<input type="button" name="saveEdit" value="save" class="submit" />
			<div class="clear"></div>
		</fieldset>
	</form>
</div>

<?php if ($this->_tpl_vars['approval']): ?>
	<div id="addForm3">
		<p><?php echo $this->_tpl_vars['approval']; ?>
</p>
		<a href="#" class="cancel" style="float:none;display:block;margin:10px auto 0 auto;">Ok</a>
	</div>
<?php endif; ?>

<script type="text/javascript">
<?php echo '
	var sort_link = "{$sortLink}";
	function UrlReplace(link,param1)
	{
		link=link.replace(\'*param1*\',param1);
		href=link.replace(/&amp;/gi,\'&\');
		location.href=href;
	}

	$(document).ready(function(){
		$("#addForm .submit, #addForm2 .submit").click(function(){



			$(this).attr(\'display\',\'none\');
		});

		$(".newMsg").click(function(){
			$("#addForm").modal({
				overlayClose:true,
				overlayId:\'tlfbCalendarOverlay\',
				closeClass:\'cancel\'
			});
			return false;
		});
		$(".edit").click(function(){
			$("#addForm2 textarea").html($(this).parent().parent().parent().children(\'.mailbody\').html());
			var mail_id = $(this).attr(\'rel\');
			mail_id = mail_id.split(\'_\');
			if(mail_id[1]) mail_id = mail_id[1];
			$("#addForm2 .subject").val($(".subject"+mail_id).html());
			$("#addForm2 .editID").val(mail_id);
			$("#addForm2").modal({
				overlayClose:true,
				overlayId:\'tlfbCalendarOverlay\',
				closeClass:\'cancel\'
			});
			return false;
		});
		$(\'#addForm2 input[name="saveEdit"]\').click(function(){
			var editError = 0;
			if(!$("#addForm2 .subject").val())
			{
				$("#addForm2 .subjectError").show();
				editError = 1;
			}
			else
			{
				$("#addForm2 .subjectError").hide();
			}
			if(!$("#addForm2 .calendarComment").val())
			{
				$("#addForm2 .msgError").show();
				editError = 1;
			}
			else
			{
				$("#addForm2 .msgError").hide();
			}
			if(!editError)
			{
				$("#editForm").submit();
			}
		});
		$(\'input[name$="sendTo"]\').click(function(){
			if($(this).val()==1)
			{
				$("#doctors").hide();
				$(\'.doctorsErr\').hide();
				$("#patients").show();
				$(\'.patientsErr\').show();
				$(\'.msgType\').hide();
				
			}
			else
			{
				$("#doctors").show();
				$(\'.doctorsErr\').show();
				$("#patients").hide();
				$(\'.patientsErr\').hide();
				$(\'.msgType\').show();
			}
		});
		$(\'#msgTypes\').change(function(){
			if($(this).val())
			{
				$(\'.msgTypePatients\').show();
			}
			else
			{
				$(\'.msgTypePatients\').hide();
			}
		});
		'; ?>

		<?php if ($this->_tpl_vars['showForm']): ?>
			<?php echo '
			$("#addForm").modal({
				overlayClose:true,
				overlayId:\'tlfbCalendarOverlay\',
				closeClass:\'cancel\'
			});
			'; ?>

		<?php endif; ?>

		<?php if ($this->_tpl_vars['approval']): ?>
			<?php echo '
			$("#addForm3").modal({
				overlayClose:true,
				overlayId:\'tlfbCalendarOverlay\',
				closeClass:\'cancel\'
			});
			'; ?>

		<?php endif; ?>
		
	<?php echo '
		$("#mailSort").change(function(){
			UrlReplace(sort_link,this.value);
		});
		
		$(".replyTo").click(function(){
			var params = $(this).attr(\'rel\');
			params = params.split(\'_\');
			if(params.length==3)
			{
				$("#addForm").modal({
					overlayClose:true,
					overlayId:\'tlfbCalendarOverlay\',
					closeClass:\'cancel\'
				});
				$("#sendTo1").attr(\'checked\', false);
				$("#sendTo2").attr(\'checked\', false);
				$("#patients").attr(\'style\',\'display:block\');
				$("#patients").hide();
				$("#doctors").attr(\'style\',\'display:block\');
				$("#doctors").hide();
				$("#addForm .errMsg").hide();
				$("#addForm .subject").attr(\'style\',\'\');
				$("#addForm .calendarComment").attr(\'style\',\'\');
				$(\'.patientsErr,.doctorsErr\').hide();
				$("#addForm .subject").val("Re: " + $("ins.subject"+params[0]).html());
				if(params[1]==1)
				{
					$("#sendTo1").attr(\'checked\', true);
					$("#patients").show();
					$("#patients").val(params[2]);
				}
				else if(params[1]==2)
				{
					$("#sendTo2").attr(\'checked\', true);
					$("#doctors").show();
					$("#doctors").val(params[2]);
				}
			}
			return false;
		});
	});
'; ?>

</script>