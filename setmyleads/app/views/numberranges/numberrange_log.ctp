
<link href="../DataTables/css/demo_table.css" rel="stylesheet" />
<link href="../DataTables/css/CustomTable.css" rel="stylesheet" />
<link href="../DataTables/css/demo_table_jui.css" rel="stylesheet" />
<script type="text/javascript" src="../DataTables/js/jquery.dataTables.js"></script>

<script type="text/javascript">

	$(document).ready(function() {



		$('#table_user').DataTable({
			"aaSorting": [],
			"iDisplayLength": 50
		});
	});

</script>

<div  id="maincontent">
	<div class="mainheading"><div align="left">Number Range Logs</div> </div>





	<table  border="0" cellspacing="0" cellpadding="0" class="table_border" id="table_user" style="float: left; margin-top: 10px; margin-bottom: 10px; line-height: 3; width: 100%;">
		<thead class="gridtableHeader">
			<tr>

				<td width="15%" align="center"><?php echo ('Created'); ?></td>
				<td width="28%" style="padding-left:10px;" align="left"><?php echo ('Log Text'); ?></td>
				<td width="14%" align="center"><?php echo ('Daily Rate'); ?></td>
				<td width="14%" align="center"><?php echo ('Weekly Rate'); ?></td>
				<td width="14%" align="center"><?php echo ('Monthly Rate'); ?></td>
				<td width="15%" align="center"><?php echo ('Opr Name'); ?></td>
				

			</tr>

		</thead>
		<tbody style="border: solid 1px #2f9300;">
		
			<?php
			$i = 0;
			$counter = 0;
			foreach ($nr_logs as $log):
				$class = '';
			if ($i++ % 2 == 0) {
				$class = ' class="grid2dark"';
			} else {
				$class = ' class="grid1light"';
			}

			if ($i == 1) {
				?>
				<?php } ?>

				<tr <?php echo $class; ?>>
					
					<td width="15%" align="center" class="gridcellborder" style=\"padding-left:10px;\">
						<?php echo $log['numberranges_log']['created']; ?>
					</td>
					<td width="28%" align="center" class="gridcellborder" style=\"padding-left:10px;\">
						<?php echo $log['numberranges_log']['log_text']; ?> by <?php echo $log['users']['login']; ?>
					</td>
					<td width="14%" align="center" class="gridcellborder" style=\"padding-left:10px;\">
						<?php echo $log['numberranges_log']['daily_rate']; ?>
					</td>
					<td width="14%" align="center" class="gridcellborder" style=\"padding-left:10px;\">
						<?php echo $log['numberranges_log']['weekly_rate']; ?>
					</td>
					<td width="14%" align="center" class="gridcellborder" style=\"padding-left:10px;\">
						<?php echo $log['numberranges_log']['monthly_rate']; ?>
					</td>
					<td width="15%" align="center" class="gridcellborder" style=\"padding-left:10px;\">
						<?php echo $log['operators']['name']; ?>
					</td>


				</tr>

			<?php endforeach; ?>
		</tbody>
	</table>
	
