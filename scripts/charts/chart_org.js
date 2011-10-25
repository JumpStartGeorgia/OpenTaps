$(document).ready(function() {

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

		var org_chart_2 = new Highcharts.Chart(pie_chart_options);
	}
    }

});
