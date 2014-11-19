<script type="text/javascript" src="templates/default/scripts/jquery.simplemodal.js"></script>

<h1>Tools Summary/Inbox - {$patient.first_name} {$patient.middle_name} {$patient.last_name}</h1>

<div class="bttnCont">
	<a href="{$backHref}">Back to Patient information page</a>
	<div class="clear"></div>
</div>
			
<div class="summaryHeader">
	<strong>Patient:</strong> {$patient.first_name} {$patient.middle_name} {$patient.last_name}<br />
	{$patient.first_name} {$patient.middle_name} {$patient.last_name} uses - {foreach from=$stimulants item=stimulant name=stimulants}{$stimulant}{if !$smarty.foreach.stimulants.last}, {/if}{/foreach}<br />
	Flash time: {$spentTime} &nbsp; (<a style="color:#000" href="{$timeDetailsHref}">See details...</a>)
	{*
	<div class="bttns">
		<a class="email" href="#">Email</a>
		<a class="download" href="#">Download</a>
		<div class="clear"></div>
	</div>
	*}
</div><!-- summaryheader -->

<br />

<div id="summaryLeft">
	<div class="bttns">
		<a href="#" rel="session1" class="session sessionActive">Session 1</a>
		<a href="#" rel="session2" class="session last">Session 2</a>
		<div class="clear"></div>
	</div>
	
	<div class="body" id="session1div">
		
		{* domyslnie otwarta: <a class=" bttnbttnOpen"> i <div id="box1" class="box boxOpen"> *}
		
		{foreach from=$tools item=tool name=tools}
			{if $tool.number==1}
				<a href="#" rel="box{$tool.id}" class="bttn"><span>Tool {$smarty.foreach.tools.iteration}:</span><strong>{$tool.name}</strong></a>
				<div id="box{$tool.id}" class="box">
					{if $tool.template}
						{include file=$tool.template}
					{else}
						<p>Empty</p>
					{/if}
				</div>
			{/if}
			{if !$smarty.foreach.tools.last}<div class="spacer"></div>{/if}
		{/foreach}
		
	</div>
	
	<div class="body" id="session2div" style="display:none">
		
		{* domyslnie otwarta: <a class=" bttnbttnOpen"> i <div id="box1" class="box boxOpen"> *}
		
		{foreach from=$tools item=tool name=tools}
			{if $tool.number==2}
				<a href="#" rel="box{$tool.id}" class="bttn"><span>Tool {$smarty.foreach.tools.iteration}:</span><strong>{$tool.name}</strong></a>
				<div id="box{$tool.id}" class="box">
					{if $tool.template}
						{include file=$tool.template}
					{else}
						<p>Empty</p>
					{/if}
				</div>
				{if !$smarty.foreach.tools.last}<div class="spacer"></div>{/if}
			{/if}
		{/foreach}
		
	</div>
</div>

{if $mailbox}
	<div id="summaryRight">
		<p class="header">Patient's inbox <span>{$mailbox.new} new email(s)</span></p>
		<div class="spacer2"></div>
		<div class="newMessage"><a href="#" class="newMsg">Create a New Message</a></div>
		<div class="spacer2"></div>
		
		<div class="body">
		
			{foreach from=$mailbox.list item=mail name=mails}
			
				<a href="#" rel="rightbox{$smarty.foreach.mails.iteration}" class="bttn {*bttnOpen*}">
				{*
					<strong style="float:left">{$mail.from}</strong>
					<ins style="float:left">{$mail.subject}</ins>
					<span style="float:right">{$mail.date}</span>
					<ins style="clear:both"></ins>
				*}
					<strong style="float:left">{$mail.from}</strong>
					<span style="float:right">{$mail.date}</span>
					<ins style="clear:both;display:block;"></ins>
					<ins style="float:left">{$mail.subject}</ins>
					<ins style="clear:both;display:block;"></ins>
				</a>
				<div id="rightbox{$smarty.foreach.mails.iteration}" class="box {*boxOpen*}">
					{$mail.content}
					<ul class="panel">
						<li>
							<a href="#" class="cloudBttn" rel="removeCloud{$smarty.foreach.mails.iteration}"><img src="templates/default/images/summary_arrow.png" alt="" />Remove</a>
							<div id="removeCloud{$smarty.foreach.mails.iteration}" class="sendConfirm">
								<div class="cont">
									Are you sure you want to delete the message?<br />
									<a href="{$mail.delHref}" class="yes">Yes</a>
									<a href="#no" class="no">No</a>
								</div>
							</div>
						</li>
						{if !$mail.approved}<li><a href="{$mail.approveHref}"><img src="templates/default/images/summary_arrow.png" alt="" />Approve</a></li>{/if}
					</ul>
					<div class="clear"></div>
				</div><!-- box -->
				<div class="spacer"></div>
				
			{/foreach}
			
		</div>
	</div>
{/if}
<div class="clear"></div>

{assign var="form" value=$mailbox.form}

<div id="addForm">
	{$form.open}
		<fieldset>
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

{if $mailbox.approval}
	<div id="addForm2">
		<p>{$mailbox.approval}</p>
		<a href="#" class="cancel" style="float:none;display:block;margin:10px auto 0 auto;">Ok</a>
	</div>
{/if}

<script type="text/javascript">
{literal}
	$(document).ready(function(){
		$("#addForm .submit").click(function(){
			$(this).attr('disabled',true);
		});
		$(".newMsg").click(function(){
			$("#addForm").modal({
				overlayClose:true,
				overlayId:'tlfbCalendarOverlay',
				closeClass:'cancel'
			});
			return false;
		});
		$("#summaryLeft .bttns a").click(function(){
			$("#summaryLeft .bttns a").removeClass('sessionActive');
			$(this).addClass('sessionActive');
			box_id = "#" + $(this).attr('rel') + "div";
			$("#summaryLeft .body").hide();
			$(box_id).show();
			return false;
		});
		{/literal}
		{if $mailbox.showForm}
			{literal}
			$("#addForm").modal({
				overlayClose:true,
				overlayId:'tlfbCalendarOverlay',
				closeClass:'cancel'
			});
			{/literal}
		{/if}
		{if $mailbox.approval}
			{literal}
			$("#addForm2").modal({
				overlayClose:true,
				overlayId:'tlfbCalendarOverlay',
				closeClass:'cancel'
			});
			{/literal}
		{/if}
	});
</script>