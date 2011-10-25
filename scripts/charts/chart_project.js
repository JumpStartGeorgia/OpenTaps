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

		if (typeof(serialized_data_1) !== 'undefined')
		{
			menuitem3 = {
				text: 'Download CSV document',
				onclick: function() {
					window.location.href = baseurl + 'export/csv/' + serialized_data_1 + '/chart/';
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
		      {}
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

		if (typeof(serialized_data_2) !== 'undefined')
		{
			menuitem3 = {
				text: 'Download CSV document',
				onclick: function() {
					window.location.href = baseurl + 'export/csv/' + serialized_data_2 + '/chart/';
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
		      {}
		];

		var project_chart_2 = new Highcharts.Chart(pie_chart_options);
	}
    }

});
