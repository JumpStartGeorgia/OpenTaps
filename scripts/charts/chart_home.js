$(document).ready(function() {

    if (typeof(home_page) !== 'undefined' && home_page)
    {
	pie_chart_options.chart.renderTo = 'home-chart-container';
	pie_chart_options.series.push({
		type: 'pie',
		name: 'org_budgets',
		data: data
      });

	var home_chart = new Highcharts.Chart(pie_chart_options);
    }

});
