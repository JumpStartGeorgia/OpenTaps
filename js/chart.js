pieData = [50,30,20,10,5,34,74];
pieLegend = ["%% - text1","%% - text2","%% - text3","%% - text4","%% - text5", "%% - text6", "%% - text7"];	

function chart_init(){
	 var r = Raphael("chart");
                var pie = r.g.piechart("#00AFF2", 150,110, 100, pieData, {legend:pieLegend,legendpos:"south"});
                pie.hover(function () {
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
