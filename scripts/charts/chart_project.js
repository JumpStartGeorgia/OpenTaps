$(document).ready(function() {

    if (typeof(project_page) !== 'undefined' && project_page)
    {
	if (typeof(data_1) !== 'undefined')
	{
		pie_chart_options.chart.renderTo = 'project-chart-container-1';
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
		      { text: 'Download HTML document' },
		      null,
		      menuitem3,
		      null
		];

		var project_chart_1 = new Highcharts.Chart(pie_chart_options);
	}

	if (typeof(data_2) !== 'undefined')
	{
		pie_chart_options.chart.renderTo = 'project-chart-container-2';
		pie_chart_options.series = [{
			type: 'pie',
			name: 'all_budgets',
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
		      { text: 'Download HTML document' },
		      null,
		      menuitem3,
		      null
		];

		var project_chart_2 = new Highcharts.Chart(pie_chart_options);
	}
    }

});
