var chart;
var chart_options = {
      chart: {
         renderTo: 'chart-container',
         plotBackgroundColor: null,
         plotBorderWidth: null,
         plotShadow: false
      },
      title: {
         text: 'Browser market shares at a specific website, 2010'
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
       series: [{
         type: 'pie',
         name: 'Browser share',
         data: [
            ['Firefox',   45.0],
            ['IE',       26.8],
            {
               name: 'Chrome',    
               y: 322.8,
               sliced: true,
               selected: true
            },
            ['Safari',    8.5],
            ['Opera',     6.2],
            ['Others',   0.7]
         ]
      }]
   };

$(document).ready(function() {
   chart = new Highcharts.Chart(chart_options);
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
