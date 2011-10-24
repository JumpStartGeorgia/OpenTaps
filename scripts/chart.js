var chart,
home_chart,
chart_options = {
      chart: {
         renderTo: '',
         plotBackgroundColor: null,
         plotBorderWidth: null,
         plotShadow: false
      },
      colors: [
	 '#1ac3f8',
	 '#15b4f0',
	 '#83e8ff',
	 '#b2f4ff',
	 '#5bd8ff',
	 '#63e1f5',
	 '#5acaf5',
	 '#8be4ff',
	 '#0cb5f5'
      ],
      title: {
         text: ''
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
       series: []
   };
/*
$(document).ready(function() {
   chart = new Highcharts.Chart(chart_options);
});
*/

$(document).ready(function() {

    if (home_page)
    {
	chart_options.chart.renderTo = 'home-chart-container';
	chart_options.series.push({
		type: 'pie',
		name: 'org_budgets',
		data: data
      });

	home_chart = new Highcharts.Chart(chart_options);
    }

});



































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
