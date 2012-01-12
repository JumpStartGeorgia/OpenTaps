$(document).ready(function()
    {

        if (typeof(org_page) !== 'undefined' && org_page)
        {
            /*if (typeof(data_1) !== 'undefined')
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
            }*/

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



    function addCommas(nStr)
    {
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
	x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
    }


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


	/* scatter *//*
	var data = new google.visualization.DataTable();
	data.addColumn('number', 'X');
	data.addColumn('number', 'Budget');
	data.addColumn({type:'string', role:'tooltip'});
	var mindate = data_1[0][2], maxdate = data_1[0][2], direction = 1;
	for (var i = 0; i < data_1.length; i ++)
	{
	    data.addRow([data_1[i][1], data_1[i][2], data_1[i][0] + '\nBudget: ' + addCommas(data_1[i][1])]);
	    if (data_1[i][2] > maxdate) maxdate = data_1[i][2];
	    if (data_1[i][2] < mindate) mindate = data_1[i][2];
	}
	if (mindate == maxdate)
	{
	    mindate += -1;
	    maxdate += 1;
	}
	if (data_1[0][2] < 13)
	{
	    mindate = 1;
	    maxdate = 12;
	    direction = -1;
	}

	var chart = new google.visualization.ScatterChart(document.getElementById('org-chart-container-1'));
	/*google.visualization.events.addListener(chart, 'onmouseover', function (e){
	    //chart.setSelection([e]);
	    //console.log('column: ' + e.column + '; row: ' + e.row);
	    //console.log(titles[e.row]);
	});*//*

	chart.draw(
	    data,
	    {title: null,
	     width: '100%',
	     pointSize: 4,
	     vAxis: {title: 'Month', format: '####', direction: direction, minValue: mindate, maxValue: maxdate, gridlines: {count: Math.abs(maxdate - mindate + 1)}, titleTextStyle: {color: "#0CB5F5"}},
	     hAxis: {title: "Budget", titleTextStyle: {color: "green"}}}
	);*/

      }
