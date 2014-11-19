<script type="text/javascript" src="templates/default/scripts/jquery.tooltip.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.simplemodal.js"></script>

<h1>{$page->title}</h1>

<form method="post" action="">
	<div id="tlfbCalendar" class="step5Calendar">
		
		{$page->body}
		<br />
		
		<ul class="months">
			{foreach from=$calendar item=date name=calendar}
				<li id="month{$date.id}" class="{if $smarty.foreach.calendar.first}active{/if} {if $smarty.foreach.calendar.last}last{/if}">
					{$date.month} {$date.year}
				</li>
			{/foreach}
		</ul>
		<div class="clear"></div>
		
		{foreach from=$calendar item=date name=calendar}
			<div id="month{$smarty.foreach.calendar.iteration}Box" class="monthBox" {if !$smarty.foreach.calendar.first}style="display:none"{/if}>
				<div class="cont">
					<table cellpadding="0" cellspacing="0">
					<tr>
						<th>Sun</th>
						<th class="odd">Mon</th>
						<th>Tue</th>
						<th class="odd">Wen</th>
						<th>Thu</th>
						<th class="odd">Fri</th>
						<th>Sat</th>
					</tr>
					{foreach from=$date.days item=day name=days}
						{if $smarty.foreach.days.first}
							<tr>
						{/if}
						{if $smarty.foreach.days.index%7 == 0 && !$smarty.foreach.days.first}
							</tr>
							<tr>
								<td colspan="7" class="spacer"></td>
							</tr>
							<tr>
						{/if}

						<td class="{if $smarty.foreach.days.iteration%2==0}odd{/if} {if $smarty.foreach.days.iteration%2==0 && !$day.day}emptyOdd{elseif !$day.day}empty{/if} {if $day.holiday}holiday{/if}">
							{if $day.day}
								<strong>{$day.day}</strong>
								{if $day.text || $day.holiday}
									<p>{$day.text|strip_tags:false|truncate:40:"&hellip;"}</p>
									<span>{$day.text}{if $day.holiday}<strong>{if $day.text}<br /><br />{/if}{$day.holiday}</strong>{/if}</span>
								{/if}
							{else}
								&nbsp;
							{/if}
							<input type="hidden" name="date" value="{$day.year}-{$day.month}-{$day.day}" />
						</td>
						
						{if $smarty.foreach.days.last}
							</tr>
						{/if}
					{/foreach}
					</table>
				</div>
			</div>
		{/foreach}
		
	</div><!--tlfbCalendar-->
	
	<div>
		<br />
		<a class="newPatientBack" href="{$backHref}">back</a>
		<input type="submit" name="nextStep" value="next" class="newPatientFormSubmit" />
		<div class="clear"></div>
	</div>
</form>

<div id="addForm">
	<form method="post" action="">
		<fieldset>
			<p style="padding:0 0 5px 0">ADD COMMENT:</p>
			<p><textarea rows="1" cols="1" name="calendarComment"></textarea></p><br />
			<a href="#" class="cancel">cancel</a>
			<input type="submit" name="addComment" value="add" class="submit" />
			<input type="hidden" id="addDate" name="addDate" value="" />
			<div class="clear"></div>
		</fieldset>
	</form>
</div>
