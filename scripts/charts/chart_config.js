var pie_chart_options = {
      chart: {
         renderTo: '',
         plotBackgroundColor: null,
         plotBorderWidth: null,
         plotShadow: false,
         marginBottom: 90
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
      ],
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
            showInLegend: true
         }
      },
      legend: {
	 floating: true,
	 layout: "vertical",
	 borderWidth: 0
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

   };
