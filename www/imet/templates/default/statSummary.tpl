<h1>Summary Page</h1>

<table cellpadding="0" cellspacing="0" class="table" id="summaryTable">
<thead>
	<tr>
		<th class="odd">Number</th>
		<th class="even">Status</th>
		<th class="odd">Status Description</th>
	</tr>
</thead>
<tbody>
	{if count($showStatuses)}
		<tr class="wait"><td colspan="3"><img src="templates/default/images/ajax-loader.gif" style="vertical-align:bottom" alt="" /> Loading</td></tr>
	{else}
		<tr><td colspan="3">No patients</td></tr>
	{/if}
</tbody>
</table>

{if $showStatuses}
	<script type="text/javascript">
	{literal}
	
		var rowsCount = 1;
		var statusHref = "{/literal}{$statusHref}{literal}";
	
		$(document).ready(function(){
			showOneStatus();
		});
	
		function showOneStatus()
		{
			$.ajax({
				type: "POST",
				url: {/literal}"{$ajaxHref}"{literal},
				data: "status="+rowsCount,
				success: function(msg){
					if(msg.substr(0,2)=="ok" && msg.length>2)
					{
						msg = msg.split('||');
						if(msg.length == 4)
						{
							statHref = '';
							if(msg[1]>0)
							{
								statHref = ' onclick="redirect(\''+statusHref+'\')"';
								statHref = statHref.replace("*id*", rowsCount);
							}
							var trHTML = '<tr'+statHref+'>';
							trHTML += '<td>'+msg[1]+'</td>';
							trHTML += '<td>'+msg[2]+'</td>';
							trHTML += '<td>'+msg[3]+'</td>';
							trHTML += '</tr>';
							$("#summaryTable tbody tr.wait").before(trHTML).fadeIn(function(){
								rowsCount++;
								if(rowsCount<={/literal}{$statusesCount}{literal})
								{
									showOneStatus();
								}
								else
								{
									$("#summaryTable tbody tr.wait").remove();
								}
							});
						}
					}
				}
			});
		}
	
	{/literal}
	</script>
{/if}