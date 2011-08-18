      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
      
      // Set a callback to run when the Google Visualization API is loaded.
      
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
