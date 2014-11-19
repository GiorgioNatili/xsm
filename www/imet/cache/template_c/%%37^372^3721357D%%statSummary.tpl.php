<?php /* Smarty version 2.6.22, created on 2012-05-15 13:31:31
         compiled from statSummary.tpl */ ?>
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
	<?php if (count ( $this->_tpl_vars['showStatuses'] )): ?>
		<tr class="wait"><td colspan="3"><img src="templates/default/images/ajax-loader.gif" style="vertical-align:bottom" alt="" /> Loading</td></tr>
	<?php else: ?>
		<tr><td colspan="3">No patients</td></tr>
	<?php endif; ?>
</tbody>
</table>

<?php if ($this->_tpl_vars['showStatuses']): ?>
	<script type="text/javascript">
	<?php echo '
	
		var rowsCount = 1;
		var statusHref = "'; ?>
<?php echo $this->_tpl_vars['statusHref']; ?>
<?php echo '";
	
		$(document).ready(function(){
			showOneStatus();
		});
	
		function showOneStatus()
		{
			$.ajax({
				type: "POST",
				url: '; ?>
"<?php echo $this->_tpl_vars['ajaxHref']; ?>
"<?php echo ',
				data: "status="+rowsCount,
				success: function(msg){
					if(msg.substr(0,2)=="ok" && msg.length>2)
					{
						msg = msg.split(\'||\');
						if(msg.length == 4)
						{
							statHref = \'\';
							if(msg[1]>0)
							{
								statHref = \' onclick="redirect(\\\'\'+statusHref+\'\\\')"\';
								statHref = statHref.replace("*id*", rowsCount);
							}
							var trHTML = \'<tr\'+statHref+\'>\';
							trHTML += \'<td>\'+msg[1]+\'</td>\';
							trHTML += \'<td>\'+msg[2]+\'</td>\';
							trHTML += \'<td>\'+msg[3]+\'</td>\';
							trHTML += \'</tr>\';
							$("#summaryTable tbody tr.wait").before(trHTML).fadeIn(function(){
								rowsCount++;
								if(rowsCount<='; ?>
<?php echo $this->_tpl_vars['statusesCount']; ?>
<?php echo ')
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
	
	'; ?>

	</script>
<?php endif; ?>