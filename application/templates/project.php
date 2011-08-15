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
    	/*google.setOnLoadCallback(drawChart(<?php echo $pp_rows.",".$pc_rows.",".$op_rows.",".$oc_rows ?>));*/
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
      
      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart(<?php echo $pp_rows.",".$pc_rows.",".$op_rows.",".$oc_rows ?>));
      // Callback that creates and populates a data table, 
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart(pp_rows, pc_rows, op_rows, oc_rows) {

      // Create the data table.
      var pp_data = new google.visualization.DataTable(),
          pc_data = new google.visualization.DataTable(),
          op_data = new google.visualization.DataTable(),
          oc_data = new google.visualization.DataTable();

      pp_data.addColumn('string', 'Topping');
      pp_data.addColumn('number', 'Slices');
      pp_data.addRows([
        ['Mushrooms', 3],
        ['Onions', 1],
        ['Olives', 1], 
        ['Zucchini', 1],
        ['Pepperoni', 2],
        ['rame', .5]
      ]);

      pc_data.addColumn('string', 'Topping');
      pc_data.addColumn('number', 'Slices');
      pc_data.addRows(pc_rows);

      op_data.addColumn('string', 'Topping');
      op_data.addColumn('number', 'Slices');
      op_data.addRows(op_rows);

      oc_data.addColumn('string', 'Topping');
      oc_data.addColumn('number', 'Slices');
      oc_data.addRows(oc_rows);

      // Set chart options
      var options = {
	      		     'title':'Projects',
		             'width':168,
		             'height':378,
		             'chartArea':{width:'100%', height:'90%'},
		             //'colors':['black', 'grey', 'green', 'blue', 'red'],
		             'legend':'bottom'
                     };
      var pp_options = options, pc_options = options, op_options = options, oc_options = options;

      // Instantiate and draw our chart, passing in some options.
      var projects_pie_chart = new google.visualization.PieChart(document.getElementById('projects_pie_chart_div'));
      projects_pie_chart.draw(pp_data, pp_options);

    /*  var projects_column_chart = new google.visualization.ColumnChart(document.getElementById('projects_column_chart_div'));
      projects_column_chart.draw(pc_data, pc_options);

      var organisations_pie_chart = new google.visualization.PieChart(document.getElementById('organisations_pie_chart_div'));
      organisations_pie_chart.draw(op_data, op_options);

      var organisations_column_chart = new google.visualization.ColumnChart(document.getElementById('organisations_column_chart_div'));
      organisations_column_chart.draw(oc_data, oc_options);*/
    }
    </script>
    <div id='charts'>
	<div id="projects_pie_chart_div"></div>
	<div id="organisations_pie_chart_div"></div>
	<div id="projects_column_chart_div"></div>
	<div id="organisations_column_chart_div"></div>
    </div>

</div>
