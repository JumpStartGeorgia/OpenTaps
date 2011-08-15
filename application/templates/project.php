<div id='project_content'>

    <div style='float:left;width:673px;'>
	<div class='group'>
		<div id='map' style='width:282px;height:244px;float:left;'></div>
		<div id='project_details'>
			<div id='project_budget'>
				<p>Overall Project Budget</p>
				<p style='font-size:27px;color:#FFF;'><?php echo $project['budget'] ?></p>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Title :
				</div>
				<div>
					<?php echo $project['title']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					District :
				</div>
				<div>
					<?php echo $project['district']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					City/Town :
				</div>
				<div>
					<?php echo $project['city']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Grantee :
				</div>
				<div>
					<?php echo $project['grantee']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Sector :
				</div>
				<div>
					<?php echo $project['sector']; ?>
				</div>
			</div>
			<div class='project_details_line' style='border:0;'>
				<div class='line_left'>
					Time line :
				</div>
				<div>
					<?php echo $project['start_at'] . " - " . $project['end_at']; ?>
				</div>
			</div>
		</div>
	</div>

	<div id='project_description'>
		<p>PROJECT DESCRIPTION</p>
		<div><?php echo $project['description']; ?></div>

		<p>INFO ON PROJECT</p>
		<div><?php echo $project['info']; ?></div>
	</div>
    </div>

    <div style='float:right;'>

<?php $i = 0; foreach ( $data as $d ): $i ++; ?>

	<div class='data_block group' <?php ($i == 1) AND print("style='border-top: 0 none;'"); ?>>
		<div class='key'>
			<?php echo strtoupper($d['key']); ?>
		</div>
		<div class='value'>
			<?php echo $d['value']; ?>
		</div>
	</div>

<?php endforeach; ?>

    </div>
<?php
$pp_rows = $pc_rows = $op_rows = $oc_rows = "
		[
			['Mushrooms', 3],
			['Onions', 1],
			['Olives', 1], 
			['Zucchini', 1],
			['Pepperoni', 2],
			['rame', .5]
		]";
?>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="<?php echo URL ?>js/google_chart.js"></script>
    <script type='text/javascript'>
    	google.setOnLoadCallback(drawChart(<?php echo $pp_rows.",".$pc_rows.",".$op_rows.",".$oc_rows ?>));
    </script>
    <div id='charts'>
	<div id="projects_pie_chart_div"></div>
	<div id="organisations_pie_chart_div"></div>
	<div id="projects_column_chart_div"></div>
	<div id="organisations_column_chart_div"></div>
    </div>

</div>
