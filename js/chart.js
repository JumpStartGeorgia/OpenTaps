pieData = [40,30,20,10,5];
pieLegend = ["%% - text1","%% - text2","%% - text3","%% - text4","%% - text5"];
	
var r = Raphael("chart");
function chart_init(){
	if(document.getElementById('chart').value != ""){
      // pieChart();
        barChart();
	}
}

function barChart(){
    var bar = r.g.barchart(10, 10, 300, 220, [[55, 20, 13, 32, 5, 1, 2, 10]]).hover(function(){
        this.flag.animate({opacity: 0}, 300, function () {this.remove();});
    },
    function(){
        this.flag.animate({opacity: 0}, 300, function () {this.remove();});
    }
    );
}
function pieChart(){
      var pie = r.g.piechart(150,110, 100, pieData, {legend:pieLegend,legendpos:"south"}).hover(function () {
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
}
