<script type="text/javascript" src="templates/default/scripts/jquery.simplemodal.js"></script>

<h1 style="width:300px;float:left">Mailbox</h1>
<div style="float:right;">
	<span>Sort patients:</span>
	<select id="mailSort" name="sortPatients" style="width:200px">
		{foreach from=$patients item=item name=patients}
			<option value="{$item.key}"{if $item.selected} selected="selected"{/if}>
				{if $item.key==0}All{else}{$item.value}{/if}
			</option>
		{/foreach}
	</select>
</div>
<div class="clear"></div>


<div id="summaryRight" style="float:left">
	<p class="header">Inbox <span>{$inbox.new} new email(s)</span></p>
	<div class="spacer2"></div>
	<div class="newMessage" style="height:19px">&nbsp;</div>
	<div class="spacer2"></div>
	
	<div class="body">
	
		{foreach from=$inbox.list item=mail name=mails}
		
			<a href="#" rel="rightbox{$mail.id}" class="bttn{if !$mail.read} unread{/if}">
				<strong style="float:left">{$mail.sender}</strong>
				<span style="float:right">{$mail.date}</span>
				<ins style="clear:both;display:block;"></ins>
				<ins style="float:left" class="subject{$mail.id}">{$mail.subject}</ins>
				<ins style="clear:both;display:block;"></ins>
			</a>
			<div id="rightbox{$mail.id}" class="box">
				<div class="mailbody">{$mail.content}</div>
				<ul class="panel">
					<li>
						<a href="#" class="cloudBttn" rel="removeCloud{$mail.id}"><img src="templates/default/images/summary_arrow.png" alt="" />Remove</a>
						<div id="removeCloud{$mail.id}" class="sendConfirm">
							<div class="cont">
								Are you sure you want to delete the message?<br />
								<a href="{$mail.delHref}" class="yes">Yes</a>
								<a href="#no" class="no">No</a>
							</div>
						</div>
					</li>
					{if !$mail.approved}
						<li><a href="#" class="edit" rel="mail_{$mail.id}"><img src="templates/default/images/summary_arrow.png" alt="" />Edit</a></li>
						<li><a href="{$mail.approveHref}"><img src="templates/default/images/summary_arrow.png" alt="" />Approve</a></li>
					{else}
						{if !$mail.read}<li><a href="{$mail.readHref}"><img src="templates/default/images/summary_arrow.png" alt="" />Read</a></li>{/if}
					{/if}
					<li><a href="#" class="replyTo" rel="{$mail.id}_{$mail.sender_type}_{$mail.sender_id}"><img src="templates/default/images/summary_arrow.png" alt="" />Reply</a></li>
				</ul>
				<div class="clear"></div>
			</div><!-- box -->
			<div class="spacer"></div>
			
		{/foreach}
		
	</div>
</div>

<div id="summaryRight2">
	<p class="header">Sent</p>
	<div class="spacer2"></div>
	<div class="newMessage"><a href="#" class="newMsg">Create a New Message</a></div>
	<div class="spacer2"></div>
	
	<div class="body">
	
		{foreach from=$sent.list item=mail name=mails}
		
			<a href="#" rel="rightbox{$mail.id}" class="bttn {*bttnOpen*}">
				<strong style="float:left">{$mail.sender}</strong>
				<span style="float:right">{$mail.date}</span>
				<ins style="clear:both;display:block;"></ins>
				<ins style="float:left">{$mail.subject}</ins>
				<ins style="clear:both;display:block;"></ins>
			</a>
			<div id="rightbox{$mail.id}" class="box {*boxOpen*}">
				{$mail.content}
				<ul class="panel">
					<li>
						<a href="#" class="cloudBttn" rel="removeCloud{$mail.id}"><img src="templates/default/images/summary_arrow.png" alt="" />Remove</a>
						<div id="removeCloud{$mail.id}" class="sendConfirm">
							<div class="cont">
								Are you sure you want to delete the message?<br />
								<a href="{$mail.delHref}" class="yes">Yes</a>
								<a href="#no" class="no">No</a>
							</div>
						</div>
					</li>
				</ul>
				<div class="clear"></div>
			</div><!-- box -->
			<div class="spacer"></div>
			
		{/foreach}
		
	</div>
</div>
<div class="clear"></div>

<div id="addForm">
	{$form.open}
		<fieldset>
			<ul class="receiver">
				<li>Receiver:</li>
				<li>
					<input type="radio" name="sendTo" value="1" id="sendTo1" {if $formSendTo==1}checked="checked"{/if} /> 
					<label for="sendTo1">Patient</label> 
					{$form.fields.patients.field}
					<div class="clear"></div>
					{if $form.fields.patients.errMsg}
						<p class="errMsg patientsErr" style="padding-left:80px;width:220px">{$form.fields.patients.errMsg}</p>
					{/if}
				</li>
				<li>
					<input type="radio" name="sendTo" value="2" id="sendTo2" {if $formSendTo==2}checked="checked"{/if} /> 
					<label for="sendTo2">Doctor</label> 
					{$form.fields.doctors.field}
					<div class="clear"></div>
					{if $form.fields.doctors.errMsg}
						<p class="errMsg doctorsErr" style="padding-left:80px;width:220px">{$form.fields.doctors.errMsg}</p>
					{/if}
				</li>
				{if $form.submitted && !$formSendTo}
					<li>
						<p class="errMsg">{$lang.form_pole_obowiazkowe}</p>
					</li>
				{/if}
				<li class="msgType" {if $formSendTo==2}style="display:block"{/if}>
					Message type:<br />
					{$form.fields.msgTypes.field}
					<div class="clear"></div>
				</li>
				<li class="msgTypePatients" {if $formSendTo==2}style="display:block"{/if}>
					Patient:<br />
					{$form.fields.msgTypePatients.field}
					<div class="clear"></div>
				</li>
			</ul>
			<p style="padding:0 0 5px 0">Subject:</p>
			<p>{$form.fields.subject.field}</p>
			{if $form.fields.subject.errMsg}<p class="errMsg">{$form.fields.subject.errMsg}</p>{/if}
			<br />
			<p style="padding:0 0 5px 0">Message:</p>
			<p>{$form.fields.message.field}</p>
			{if $form.fields.message.errMsg}<p class="errMsg">{$form.fields.message.errMsg}</p>{/if}
			<br />
			<a href="#" class="cancel">cancel</a>
			<input type="submit" name="addComment" value="send" class="submit" />
			<div class="clear"></div>
		</fieldset>
	{$form.close}
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

{if $approval}
	<div id="addForm3">
		<p>{$approval}</p>
		<a href="#" class="cancel" style="float:none;display:block;margin:10px auto 0 auto;">Ok</a>
	</div>
{/if}

<script type="text/javascript">
{literal}
	var sort_link = "{$sortLink}";
	function UrlReplace(link,param1)
	{
		link=link.replace('*param1*',param1);
		href=link.replace(/&amp;/gi,'&');
		location.href=href;
	}

	$(document).ready(function(){
		$("#addForm .submit, #addForm2 .submit").click(function(){



			$(this).attr('display','none');
		});

		$(".newMsg").click(function(){
			$("#addForm").modal({
				overlayClose:true,
				overlayId:'tlfbCalendarOverlay',
				closeClass:'cancel'
			});
			return false;
		});
		$(".edit").click(function(){
			$("#addForm2 textarea").html($(this).parent().parent().parent().children('.mailbody').html());
			var mail_id = $(this).attr('rel');
			mail_id = mail_id.split('_');
			if(mail_id[1]) mail_id = mail_id[1];
			$("#addForm2 .subject").val($(".subject"+mail_id).html());
			$("#addForm2 .editID").val(mail_id);
			$("#addForm2").modal({
				overlayClose:true,
				overlayId:'tlfbCalendarOverlay',
				closeClass:'cancel'
			});
			return false;
		});
		$('#addForm2 input[name="saveEdit"]').click(function(){
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
		$('input[name$="sendTo"]').click(function(){
			if($(this).val()==1)
			{
				$("#doctors").hide();
				$('.doctorsErr').hide();
				$("#patients").show();
				$('.patientsErr').show();
				$('.msgType').hide();
				
			}
			else
			{
				$("#doctors").show();
				$('.doctorsErr').show();
				$("#patients").hide();
				$('.patientsErr').hide();
				$('.msgType').show();
			}
		});
		$('#msgTypes').change(function(){
			if($(this).val())
			{
				$('.msgTypePatients').show();
			}
			else
			{
				$('.msgTypePatients').hide();
			}
		});
		{/literal}
		{if $showForm}
			{literal}
			$("#addForm").modal({
				overlayClose:true,
				overlayId:'tlfbCalendarOverlay',
				closeClass:'cancel'
			});
			{/literal}
		{/if}

		{if $approval}
			{literal}
			$("#addForm3").modal({
				overlayClose:true,
				overlayId:'tlfbCalendarOverlay',
				closeClass:'cancel'
			});
			{/literal}
		{/if}
		
	{literal}
		$("#mailSort").change(function(){
			UrlReplace(sort_link,this.value);
		});
		
		$(".replyTo").click(function(){
			var params = $(this).attr('rel');
			params = params.split('_');
			if(params.length==3)
			{
				$("#addForm").modal({
					overlayClose:true,
					overlayId:'tlfbCalendarOverlay',
					closeClass:'cancel'
				});
				$("#sendTo1").attr('checked', false);
				$("#sendTo2").attr('checked', false);
				$("#patients").attr('style','display:block');
				$("#patients").hide();
				$("#doctors").attr('style','display:block');
				$("#doctors").hide();
				$("#addForm .errMsg").hide();
				$("#addForm .subject").attr('style','');
				$("#addForm .calendarComment").attr('style','');
				$('.patientsErr,.doctorsErr').hide();
				$("#addForm .subject").val("Re: " + $("ins.subject"+params[0]).html());
				if(params[1]==1)
				{
					$("#sendTo1").attr('checked', true);
					$("#patients").show();
					$("#patients").val(params[2]);
				}
				else if(params[1]==2)
				{
					$("#sendTo2").attr('checked', true);
					$("#doctors").show();
					$("#doctors").val(params[2]);
				}
			}
			return false;
		});
	});
{/literal}
</script>