var pie_chart_options = {
      chart: {
         renderTo: '',
         plotBackgroundColor: null,
         plotBorderWidth: null,
         plotShadow: false,
      },
      credits: {
      	 enabled: false
      },
      /*colors: [
	 '#0CB5F5',
	 '#24BCF6',
	 '#3CC3F7',
	 '#54CBF8',
	 '#6DD2F9',
	 '#85DAFA',
	 '#9DE1FB',
	 '#B6E8FC',
	 '#CEF0FD',
	 '#E6F7FE'
      ],*/
      colors: [
	 '#774F38',
	 '#957055',
	 '#B49173',
	 '#D2B291',
	 '#F1D4AF',
	 '#DBDAC5',
	 '#C5E0DC',
	 '#BBD1CA',
	 '#B2C2B9',
	 '#9FA597',
	 '#8C8775',
	 '#7A6A53',
	 '#978B79',
	 '#C2BCB3',
	 '#EEEEEE'
      ],/*
      colors: [
		'#555555',
		'#5C5C5C',
		'#646464',
		'#6B6B6B',
		'#737373',
		'#7B7B7B',
		'#828282',
		'#8A8A8A',
		'#929292',
		'#999999',
		'#A1A1A1',
		'#A9A9A9',
		'#B0B0B0',
		'#B8B8B8',
		'#C0C0C0',
		'#C7C7C7',
		'#CFCFCF',
		'#D7D7D7',
		'#DEDEDE',
		'#E6E6E6',
		'#EEEEEE'
      ],*/
      title: {
         text: null,
         floating: true,
         margin: null
      },
      subtitle: {
	 floating: true,
	 text: null
      },
      tooltip: {
         formatter: function() {
            return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage * 100) / 100 +' %';
         }
      },
      plotOptions: {
         pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
               enabled: false
            },
            borderWidth: 0.3,
            shadow: false,
            showInLegend: true,
            center: ['50%', '120']
         }
      },
      legend: {
	 floating: true,
	 layout: "vertical",
	 borderWidth: 0,
      },
      series: [],
      exporting: {
          url: baseurl + 'exportserver/?lang=' + lang,
	  enabled: true,
          buttons: {
	      printButton: {
		  enabled: false
	      },
	      exportButton: {
		  menuItems: [
		      {},
		      {},
		      {},
		      {}
		  ]
	      }
	  }
      }

   },

line_chart_options = {
      chart: {},
      credits: { enabled: false },
      title: {},
      subtitle: {},
      xAxis: {},
      yAxis: {},
      tooltip: {},
      legend: {},
      series: [
      	{ name: 'va', data: [0,1.05,2.831,1.3,1] }
      ]
};
