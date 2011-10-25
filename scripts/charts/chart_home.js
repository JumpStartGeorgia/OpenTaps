$(document).ready(function() {

    if (typeof(home_page) !== 'undefined' && home_page)
    {
	pie_chart_options.chart.renderTo = 'home-chart-container';
	pie_chart_options.series.push({
		type: 'pie',
		name: 'org_budgets',
		data: data
	});

	if (typeof(serialized_data) !== 'undefined')
	{
		menuitem3 = {
			text: 'Download CSV document',
			onclick: function() {
				window.location.href = baseurl + 'export/csv/' + serialized_data + '/chart/';
			}
		};
	}
	else
	{
		menuitem3 = null;
	}

	pie_chart_options.exporting.buttons.exportButton.menuItems = [
	      {},
	      {},
	      menuitem3,
	];
		      

	var home_chart = new Highcharts.Chart(pie_chart_options);
    }

});
