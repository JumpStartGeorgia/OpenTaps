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
      colors: [
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
            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
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
	 layout: "vertical"
      },
      series: [],
      exporting: {
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



































/*pieData = [50,30,20,10,5,34,74];
pieLegend = ["%% - text1","%% - text2","%% - text3","%% - text4","%% - text5", "%% - text6", "%% - text7"];	

var r = Raphael("chart");
function chart_init(){
		if(document.getElementById('chart').value != ""){
      			// pieChart();
        		barChart();
		}
}

function barChart(){
    var bar = r.g.barchart(10, 10, 300, 220, [[55, 20, 13, 32, 5, 1, 2, 10]]).hover(function(){
       this.flag = r.g.popup(this.bar.x, this.bar.y, this.bar.value || "0").insertBefore(this);
    },
    function(){
     this.flag.animate({opacity: 0}, 300, function () {this.remove();});
    });
}
function pieChart(){
      var pie = r.g.piechart("#00AFF2", 150,110, 100, pieData, {legend:pieLegend,legendpos:"south"}).hover(function () {
                    this.sector.stop();
                    this.sector.scale(1.1, 1.1, this.cx, this.cy);
                    if (this.label) {
                        this.label[0].stop();
                        this.label[0].scale(1.5);
                        this.label[1].attr({"font-weight": 800});
                    }
                }, function () {
                    this.sector.animate({scale: [1, 1, this.cx, this.cy]}, 500, "bounce");
                    if (this.label) {
                        this.label[0].animate({scale: 1}, 500, "bounce");
                        this.label[1].attr({"font-weight": 400});
                    }
                });
}*/