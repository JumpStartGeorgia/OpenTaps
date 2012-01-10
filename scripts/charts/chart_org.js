$(document).ready(function()
    {

        if (typeof(org_page) !== 'undefined' && org_page)
        {
            if (typeof(data_1) !== 'undefined')
            {
                pie_chart_options.chart.renderTo = 'org-chart-container-1';
                pie_chart_options.series = [{
                    type: 'pie',
                    name: 'org_projects',
                    data: data_1
                }];
                if (typeof(uniqid_1) !== 'undefined')
                {
                    menuitem3 = {
                        text: 'Download CSV document',
                        onclick: function() {
                            window.location.href = baseurl + 'export/csv/' + uniqid_1 + '/chart/';
                        }
                    };
                }
                else
                {
                    menuitem3 = null;
                }
                pie_chart_options.exporting.buttons.exportButton.menuItems = [
                {
                    text: 'Download HTML document'
                },
                null,
                menuitem3,
                null
                ];

                var org_chart_1 = new Highcharts.Chart(pie_chart_options);
            }

            if (typeof(data_2) !== 'undefined')
            {
                pie_chart_options.chart.renderTo = 'org-chart-container-2';
                pie_chart_options.series = [{
                    type: 'pie',
                    name: 'org_budgets',
                    data: data_2
                }];
                if (typeof(uniqid_2) !== 'undefined')
                {
                    menuitem3 = {
                        text: 'Download CSV document',
                        onclick: function() {
                            window.location.href = baseurl + 'export/csv/' + uniqid_2 + '/chart/';
                        }
                    };
                }
                else
                {
                    menuitem3 = null;
                }
                pie_chart_options.exporting.buttons.exportButton.menuItems = [
                {
                    text: 'Download HTML document'
                },
                null,
                menuitem3,
                null
                ];

                var org_chart_2 = new Highcharts.Chart(pie_chart_options);
            }

            /*if (typeof(data_3) !== 'undefined' || 1 == 1)
            {
                line_chart_options.chart.renderTo = 'org-chart-container-3';
                /*
                if (typeof(uniqid_3) !== 'undefined')
                {
                    menuitem3 = {
                        text: 'Download CSV document',
                        onclick: function() {
                            window.location.href = baseurl + 'export/csv/' + uniqid_2 + '/chart/';
                        }
                    };
                }
                else
                {
                    menuitem3 = null;
                }
                pie_chart_options.exporting.buttons.exportButton.menuItems = [
                {
                    text: 'Download HTML document'
                },
                null,
                menuitem3,
                null
                ];

                var org_chart_3 = new Highcharts.Chart(line_chart_options);
            }*/
        }

    });
    
    
    /*$(window).load(function()
    {
        $('.highcharts-container svg').hide(0, function()
        {
            $(this).show(0);
        });
    });*/






    //google chart api
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
	/* line */
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'year');
	data.addColumn('number', 'budget');
	for(i = 0; i < data_3.length; i ++){ data.addRow(data_3[i]); }

        var chart = new google.visualization.LineChart(document.getElementById('org-chart-container-3'));
        chart.draw(data, {legend: 'none', width: '100%', colors: ['#0CB5F6'], pointSize: 4});

	/* scatter */
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Age');
        data.addColumn('number', 'Weight');
        data.addRows([
          [8, 12],
          [4, 5.5],
          [11, 14],
          [4, 4.5],
          [3, 3.5],
          [6.5, 7]
        ]);

        var options = {
          width: 400, height: 240,
          title: 'Age vs. Weight comparison',
          hAxis: {title: 'Age', minValue: 0, maxValue: 15},
          vAxis: {title: 'Weight', minValue: 0, maxValue: 15},
          legend: 'none'
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
