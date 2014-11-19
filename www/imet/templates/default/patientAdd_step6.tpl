<script type="text/javascript" src="templates/default/scripts/jquery.tooltip.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.simplemodal.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.ui.core.js"></script>
<script type="text/javascript" src="templates/default/scripts/jquery.ui.datepicker.js"></script>

<h1>{$page->title}</h1>

<form method="post" action="">
	<div id="tlfbCalendar" class="step6Calendar">
	
		{$page->body}
		{$question}
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

						<td class="{if $smarty.foreach.days.iteration%2==0}odd{/if} {if $smarty.foreach.days.iteration%2==0 && !$day.day}emptyOdd{elseif !$day.day}empty{/if} {if $day.options}holiday{/if}">
							{if $day.day}
								<strong>{$day.day}</strong>
								{*<p>{$day.text|strip_tags:false|truncate:40:"&hellip;"}</p>*}
								{if $day.options}
									<div class="options">
										{foreach from=$day.options item=option key=optionID}
											<span class="option_{$optionID}">{$option}</span>
										{/foreach}
									</div>
								{/if}
							{else}
								&nbsp;
							{/if}
							<input type="hidden" name="date" value="{$day.year}-{$day.month}-{$day.day}" title="{$day.dayName}" />
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
		<input type="submit" name="nextStep" value="{if $save}submit{else}next question{/if}" class="newPatientFormSubmit{if !$save}2{/if}" />
		{if $backQuestion}
			<input type="submit" name="prevQuestion" value="prev question" class="newPatientFormSubmit3" />
		{/if}
		<div class="clear"></div>
	</div>
</form>

<div id="addForm">
	<form method="post" action="">
		<fieldset>
			<p class="currentDate"></p>
			<ul class="stimulants">
				{foreach from=$stimulants item=stimulant name=stimulants}
					<li>
						<label>{$stimulant.name}</label>
						<input type="text" id="stimulant_{$stimulant.id}" class="stimulant" name="stimulant_{$stimulant.id}" value="" />
						<input type="button" class="repeat" value="repeat" rel="{$stimulant.id}" />
						<input type="submit" class="delete" name="stimulantdel_{$stimulant.id}" value="1" title="Remove this value" />
						<div class="clear"></div>
						<div class="repeatBox repeatBox_{$stimulant.id}">
							<ul class="dates">
								<li>Start date: <input type="text" class="datepicker1" readonly="readonly" name="dateFrom_{$stimulant.id}" value= "" /></li>
								<li>End date: <input type="text" class="datepicker2" readonly="readonly" name="dateTo_{$stimulant.id}" value= "" /></li>
							</ul>
							<div class="clear"></div>
							<p style="padding:10px 0 5px 5px;font-weight:bold">Repeat Daily:</p>
							<div class="repeatOptions">
								<select name="stimulantoptions_{$stimulant.id}">
									<option value="0">Choose one</option>
									<option value="1">Include all days</option>
									<option value="2">Include week days only</option>
									<option value="3">Include week-end days only</option>
									<option value="4">Include school days only</option>
									<option value="5">Include non-school days only</option>
									<option value="6">Include Fridays and Saturdays only</option>
									<option value="7">Include Sundays through Thursdays only</option>
								</select>
							</div>
						</div>
					</li>
				{/foreach}
			</ul>
			<a href="#" class="cancel">cancel</a>
			<input type="submit" name="addTLFB" value="add" class="submit" />
			<input type="hidden" id="addDate" name="addDate" value="" />
			<div class="clear"></div>
		</fieldset>
	</form>
</div>

<script type="text/javascript">
{literal}
$(document).ready(function(){

	$('#addForm .stimulants .repeat').click(function(){
		if($(this).val()=='repeat')
		{
			$('#addForm .stimulants .repeatBox').hide();
			$('#addForm .stimulants .repeat').val('repeat');
			$(this).val('hide');
		}
		else $(this).val('repeat');
		$(this).parent().children('.repeatBox').toggle();
		
		var dateFromTo = "#addForm .repeatBox_"+$(this).attr('rel')+" .datepicker1, #addForm .repeatBox_"+$(this).attr('rel')+" .datepicker2";

		var dates = $(dateFromTo).datepicker({
			changeMonth: false,
			dateFormat: 'yy-mm-dd',
			minDate: "-{/literal}{$dayLimit}{literal}D",
			maxDate: 0,
			onSelect: function( selectedDate ) {
				//var option = this.id == "from" ? "minDate" : "maxDate",
				var option = $(this).attr('class') == "datepicker1 hasDatepicker" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	
	});	
	
});
{/literal}
</script>
