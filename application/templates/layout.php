<!DOCTYPE html>
﻿<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php echo Storage::instance()->title ?> - OpenTaps</title>
        <link href="<?php echo URL ?>main.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>adm.css" rel="stylesheet" type="text/css" />
        <meta charset="utf-8"/>
    	<script type="text/javascript">
    		var region_map_boundsLeft = false;
		var region_map_boundsRight = false;
		var region_map_boundsTop = false;
		var region_map_boundsBottom = false;
		var region_map_zoom = false;
		var region_map_maxzoomout = false;
		var region_map_longitude = false;
		var region_map_latitude = false;
		var region_make_def_markers = false;
		var region_show_def_buttons = true;
	</script>
    </head>
    <body onload="init()">
        <div class='main group'>

            <div class='header'>
                <a href = "<? echo URL ?>">
                  <img src='<?php echo URL ?>images/opentaps.jpg' />
		</a>
                <div class='header_right'>
                    <p>News title</p>
	  Just an empty space. With some color in it (probably not blue but any other color that will be in the logo).
	  However, important updates. Just an empty space. With some color in it (probably not blue but any other
	  color that will be in the logo). However, this "empty space" can be turned into space. (More...)
                </div>
            </div>

            <div class='after_header'>
            </div>

            <div class='menu'>
                <ul id="menu"><?php echo Storage::instance()->viewmenu ?></ul>

                <div class='search'>
                    <form method='GET' action=''>
                        <input class='search' type='text' value='Search...' onfocus='this.value=""' onblur='if(this.value=="")
                            this.value="Search..."' name='' />
                        <input class='submit' type='submit' value='' />
                    </form>
                </div>
            </div>

	    <div id="submenu"><?php echo Storage::instance()->viewsubmenu ?></div>

	    <div class='after_menu'></div>

	    <?php if (Storage::instance()->show_map): ?>
	    	<div style="position: relative; cursor:pointer; border: 1px solid maroon">
	                <div id="map" style="height:360px;"></div>
        	        <div id="map_menu" style="position:absolute;top:40px;right:20px;z-index:6000;width:180px;height:0px;visibility:hidden;">
        	        <div id="filter_projects" onclick="map_menu_filter_click('projects');" onmouseover="map_menu_filter_over(this.id,'projects');" onmouseout="map_menu_filter_out(this.id,'projects');" style="z-index:5000;border:0px solid #000;width:180px;height:32px;background-color:#F5F5F5;">
        	        	<input id="filter_checkbox_projects" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<img style="position:absolute;left:25px;top:5px;float:left;" src="<?php echo URL.'images/project.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:7px;float:left;"><font id="filter_text_projects" size="1pt">Projects</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        <!--<div style="border-top:1px dotted #A6A6A6;width:180px;height:1px;position:absolute;top:70px;right:19px;z-index:5000;">
        	        
        	        </div>-->
        	         <div id="filter_sewage" onclick="map_menu_filter_click('sewage');" onmouseover="map_menu_filter_over(this.id,'sewage');" onmouseout="map_menu_filter_out(this.id,'sewage');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:32px;background-color:#F5F5F5;top:32px;">
        	        	<input id="filter_checkbox_sewage" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<img style="position:absolute;left:25px;top:5px;float:left;" src="<?php echo URL.'images/sewage.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:7px;float:left;"><font id="filter_text_sewage" size="1pt">Sewage</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	       	<div id="filter_water_supply" onclick="map_menu_filter_click('water_supply');" onmouseover="map_menu_filter_over(this.id,'water_supply');" onmouseout="map_menu_filter_out(this.id,'water_supply');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:32px;background-color:#F5F5F5;top:62px;">
        	        	<input id="filter_checkbox_water_supply" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<img style="position:absolute;left:25px;top:5px;float:left;" src="<?php echo URL.'images/water-supply.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:7px;float:left;"><font id="filter_text_water_supply" size="1pt">Water Supply</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        <div id="filter_water_pollution" onclick="map_menu_filter_click('water_pollution');" onmouseover="map_menu_filter_over(this.id,'water_pollution');" onmouseout="map_menu_filter_out(this.id,'water_pollution');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:32px;background-color:#F5F5F5;top:92px;">
        	        	<input id="filter_checkbox_water_pollution" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<img style="position:absolute;left:25px;top:5px;float:left;" src="<?php echo URL.'images/water-pollution.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:7px;float:left;"><font id="filter_text_water_pollution" size="1pt">Water Pollution</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	         <div id="filter_irrigation" onclick="map_menu_filter_click('irrigation');" onmouseover="map_menu_filter_over(this.id,'irrigation');" onmouseout="map_menu_filter_out(this.id,'irrigation');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:32px;background-color:#F5F5F5;top:122px;">
        	        	<input id="filter_checkbox_irrigation" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<img style="position:absolute;left:25px;top:5px;float:left;" src="<?php echo URL.'images/irrigation.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:7px;float:left;"><font id="filter_text_irrigation" size="1pt">Irrigation</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        <div id="filter_water_quality" onclick="map_menu_filter_click('water_quality');" onmouseover="map_menu_filter_over(this.id,'water_quality')" onmouseout="map_menu_filter_out(this.id,'water_quality');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:32px;background-color:#F5F5F5;top:152px;">
        	        	<input id="filter_checkbox_water_quality" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<img style="position:absolute;left:25px;top:5px;float:left;" src="<?php echo URL.'images/water-quality.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:7px;float:left;"><font id="filter_text_water_quality" size="1pt">Water Quality</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        <div id="filter_water_accidents" onclick="map_menu_filter_click('water_accidents');" onmouseover="map_menu_filter_over(this.id,'water_accidents');" onmouseout="map_menu_filter_out(this.id,'water_accidents');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:32px;background-color:#F5F5F5;top:182px;">
        	        	<input id="filter_checkbox_water_accidents" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<img style="position:absolute;left:25px;top:5px;float:left;" src="<?php echo URL.'images/water-accidents.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:7px;float:left;"><font id="filter_text_water_accidents" size="1pt">Water Accidents</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        <div id="filter_news" onclick="map_menu_filter_click('news');" onmouseover="map_menu_filter_over(this.id,'news');" onmouseout="map_menu_filter_out(this.id,'news');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:32px;background-color:#F5F5F5;top:212px;">
        	        	<input id="filter_checkbox_news" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<img style="position:absolute;left:25px;top:5px;float:left;" src="<?php echo URL.'images/news.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:7px;float:left;"><font id="filter_text_news" size="1pt">News</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        <div id="filter_report" onclick="map_menu_filter_click('report');" onmouseover="map_menu_filter_over(this.id,'report');" onmouseout="map_menu_filter_out(this.id,'report');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:32px;background-color:#F5F5F5;top:242px;">
        	        	<input id="filter_checkbox_report" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<img style="position:absolute;left:25px;top:5px;float:left;" src="<?php echo URL.'images/report.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:7px;float:left;"><font id="filter_text_report" size="1pt">Report</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        <div id="filter_date" onclick="map_menu_filter_click('date');" onmouseover="map_menu_filter_over(this.id,'date');" onmouseout="map_menu_filter_out(this.id,'date');" style="position:absolute;z-index:5000;position:absolute;border-top:1px dotted #A6A6A6;width:180px;height:32px;background-color:#F5F5F5;top:272px;">
        	        	<input id="filter_checkbox_date" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<img style="position:absolute;left:25px;top:5px;float:left;" src="<?php echo URL.'images/date.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:7px;float:left;"><font id="filter_text_date" size="1pt">Date</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        </div>
        	</div>
            <?php endif; ?>

	    <div class='content group'>
              <?php echo Storage::instance()->content ?>
            </div>

            <div class='bottom group'>
                <div class='bottom0'>
		    © 2011 OPEN TAPS. &nbsp;&nbsp; Designed and developed by
		    <a href='http://jumpstart.ge/'>Jumpstart Georgia</a>
		</div>
	        <div class='bottom1'>Donate | About Us | Report</div>
	        <div class='bottom2'>GEORGIAN WATER PROJECT </div>
	        <div class='bottom3'>
	            <img src='<?php echo URL ?>images/connect_fb.jpg' />
	            &nbsp;CONNECT HERE&nbsp; <img src='<?php echo URL ?>images/connect.jpg' />
	        </div>
	    </div>

        </div>









	<script type="text/javascript">
	    var places = [<?php echo implode(', ', empty(Storage::instance()->js_places) ? array() : Storage::instance()->js_places) ?>];
	    alert(places);
	    var places_id = [],k=24;
	    for(var i=0,len=places.length;i<len;i++){
	    	places_id.push("OL_Icon_"+k);
	    	k+=4;
	    }
	</script>
	<script type="text/javascript" src="<?php echo URL ?>js/OpenLayers/OpenLayers.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/jq.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/raphael.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/graphael.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/g.bar.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/g.pie.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/chart.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/map.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/main.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/menu.js"></script>
    </body>
</html>
