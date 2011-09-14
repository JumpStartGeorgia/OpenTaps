<?php /*print_r(Storage::instance()->js_years); ?>
<?php print_r(Storage::instance()->js_types); ?>
<?php exit;*/ ?>
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
			var region_marker_click = true;
	</script>
    </head>
    <body onload="init()">
 	<script type="text/javascript">
	   var places = [<?php echo implode(', ', empty(Storage::instance()->js_places) ? array() : Storage::instance()->js_places) ?>];
 	   var projects = [<?php echo implode(', ', empty(Storage::instance()->js_projects) ? array() : Storage::instance()->js_projects) ?>];
       var news = [<?php echo implode(', ', empty(Storage::instance()->js_news) ? array() : Storage::instance()->js_news) ?>];
console.log(news[0]);
 	</script>
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
	    	<div id="map_and_menus" style="position: relative; cursor:pointer;">
	                <div id="map" style="height:360px;"></div>
	                
        	        <div id="map_menu" style="position:absolute;top:40px;right:20px;z-index:6000;width:170px;height:0px;visibility:hidden;">
        	        <div id="filter_projects" onclick="map_menu_filter_click('projects');" onmouseover="map_menu_filter_over(this.id,'projects');" onmouseout="map_menu_filter_out(this.id,'projects');" style="z-index:5000;border:0px solid #000;width:170px;height:27px;background-color:#F5F5F5;">
        	        	<!--<input id="filter_checkbox_projects" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />-->
        	        	<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/project.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_projects" size="1pt">Projects</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        <!--<div style="border-top:1px dotted #A6A6A6;width:180px;height:1px;position:absolute;top:70px;right:19px;z-index:5000;">
        	        
        	        </div>-->
        	       <!--  <div id="filter_sewage" onclick="map_menu_filter_click('sewage');" onmouseover="map_menu_filter_over(this.id,'sewage');" onmouseout="map_menu_filter_out(this.id,'sewage');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:32px;background-color:#F5F5F5;top:32px;">
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
        	        </div>-->
        	   	<div id="filter_type" onclick="map_menu_filter_click('type');" onmouseover="map_menu_filter_over(this.id,'type');" onmouseout="map_menu_filter_out(this.id,'type');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:170px;height:27px;background-color:#F5F5F5;top:27px;">
        	        	<!--<input id="filter_checkbox_type" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />-->
        	        	<img style="position:absolute;left:25px;top:px;float:left;" src="<?php echo URL.'images/type.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_type" size="1pt">Type</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        <div id="filter_news" onclick="map_menu_filter_click('news');" onmouseover="map_menu_filter_over(this.id,'news');" onmouseout="map_menu_filter_out(this.id,'news');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:170px;height:27px;background-color:#F5F5F5;top:53px;">
        	         <input id="filter_checkbox_news" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" onclick="map_menu_filter_click('news')"/>
        	        	<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/news.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_news" size="1pt">News</font></p>
        	        	<!--<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>-->
        	        </div>
        	        <!--<div id="filter_report" onclick="map_menu_filter_click('report');" onmouseover="map_menu_filter_over(this.id,'report');" onmouseout="map_menu_filter_out(this.id,'report');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:170px;height:27px;background-color:#F5F5F5;top:80px;">
        	       <!-- 	<input id="filter_checkbox_report" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/report.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_report" size="1pt">Report</font></p>
        	        	<!--<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>-->
        	        <div id="filter_date" onclick="map_menu_filter_click('date');" onmouseover="map_menu_filter_over(this.id,'date');" onmouseout="map_menu_filter_out(this.id,'date');" style="position:absolute;z-index:5000;position:absolute;border-top:1px dotted #A6A6A6;width:170px;height:27px;background-color:#F5F5F5;top:80px;">
        	        	<!--<input id="filter_checkbox_date" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />-->
        	        	<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/date.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_date" size="1pt">Date</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        
        	        </div>
        	        
        	        
        	        
        	        <div id="map_submenu_projects" style="position:absolute;top:40px;right:195px;z-index:6000;width:180px;height:0px;visibility:hidden;">
        	        <div id="filter_projects_completed" onclick="map_menu_filter_click('projects_completed');" onmouseover="map_menu_filter_over(this.id,'projects_completed');" onmouseout="map_menu_filter_out(this.id,'projects_completed');" style="z-index:5000;border:0px solid #000;width:180px;height:27px;background-color:#F5F5F5;">
        	        	<input id="filter_checkbox_projects_completed" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" onclick="map_menu_filter_click('projects_completed')"/>
        	        	<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/project.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_projects_completed" size="1pt">Completed</font></p>
        	        </div>
        	        <div id="filter_projects_current" onclick="map_menu_filter_click('projects_current');" onmouseover="map_menu_filter_over(this.id,'projects_current');" onmouseout="map_menu_filter_out(this.id,'projects_current');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:27px;background-color:#F5F5F5;top:27px;">
        	        	<input id="filter_checkbox_projects_current" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" onclick="map_menu_filter_click('projects_current')"/>
        	        	<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/project-current.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_projects_current" size="1pt">Current</font></p>
        	        </div>
        	        <div id="filter_projects_scheduled" onclick="map_menu_filter_click('projects_scheduled');" onmouseover="map_menu_filter_over(this.id,'projects_scheduled');" onmouseout="map_menu_filter_out(this.id,'projects_scheduled');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:27px;background-color:#F5F5F5;top:55px;">
        	        	<input id="filter_checkbox_projects_scheduled" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" onclick="map_menu_filter_click('projects_scheduled')" />
        	        	<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/project-scheduled.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_projects_scheduled" size="1pt">Scheduled</font></p>
        	        </div>
        	        </div>
        	        
        	        <!--<script type="text/javascript">
        	        	var years = [];
        	        	for(var i=0,len=projects.length;i<len;i++)
        	        		if( i>0 ){
	        	        	   if(years.indexOf(projects[i][1].getFullYear())!=0)
        		        	   	years.push(projects[i][1].getFullYear());
					   if(years.indexOf(projects[i][2].getFullYear())!=0)
					   	years.push(projects[i][2].getFullYear());
				   	}
        	        	years.sort();
        	        	console.log(years);
        	        </script>-->
        	        
        	        <?php 
        	        	$types = Storage::instance()->js_types;
        	        ?>
        	        <div id="map_submenu_type" style="position:absolute;top:40px;right:195px;z-index:6000;width:180px;height:0px;visibility:hidden;">
        	        <?php   $top = 27;
        	        	$i=0;
        	        foreach( $types as $type ):  
	        	  	$type_title = $type[0];
	        	  	$type_value = explode(' ',$type_title);
	        	  	$type_value = implode('_',$type_value);
        	        	?>
        	        <div id="filter_type_<?php echo $type_value; ?>" onclick="map_menu_filter_click('<?php echo $type_value; ?>');" onmouseover="map_menu_filter_over(this.id,'<?php echo $type_value; ?>');" onmouseout="map_menu_filter_out(this.id,'<?php echo $type_value; ?>');" style="position:absolute;z-index:5000;border-top:<?php echo ($i!=0) ? 1 : 0; ?>px dotted #A6A6A6;width:180px;height:27px;background-color:#F5F5F5;top:<?php echo  $top; ?>px;">
        	        	<input id="filter_checkbox_<?php echo $type_value; ?>" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<?php if( isset($type[1]) ): ?>
        	        		<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/'.$type[1]; ?>"/>
        	        	<?php endif; ?>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_<?php echo $type_value; ?>" size="1pt"><?php echo $type_title; ?></font></p>
        	        </div>
        	        <?php
        	         	$top+=27;
        	        	$i++;
        	        endforeach; ?>
        	        </div>
        	        
        	        
        	        
        	        <?php
        	        	$years = Storage::instance()->js_years;
        	        	if( count($years) > 4 ){
		        	        $years_1 = array_slice($years,0,round(count($years)/2));
	        		        $years_2 = array_slice($years,round(count($years)/2));
	        		 }
	        		 else{
	        		 	$years_1 = array();
	        		 	$years_2 = $years;
	        		 }
        	         ?>
        	         
        	         
        	        <div id="map_submenu_date_1" style="position:absolute;top:40px;right:377px;z-index:6000;width:180px;height:0px;visibility:hidden;">
        	        <?php 	$top = 87;
        	        	$i=0;
        	        foreach( $years_1 as $year ):  
        	        	?>
        	        <div id="filter_date_<?php echo $year; ?>" onclick="map_menu_filter_click('<?php echo $year; ?>');" onmouseover="map_menu_filter_over(this.id,'<?php echo $year; ?>');" onmouseout="map_menu_filter_out(this.id,'<?php echo $year; ?>');" style="position:absolute;z-index:5000;border-top:<?php echo ($i!=count($years_1)-1) ? 1 : 0; ?>px dotted #A6A6A6;width:180px;height:20px;background-color:#F5F5F5;top:<?php echo  $top; ?>px;">
        	        	<input id="filter_checkbox_<?php echo $year; ?>" style="position:absolute;top:5px;left:5px;float:left;" type="checkbox" onclick="map_menu_filter_click('<?php echo $year; ?>')"/>
        	        	<p style="position:absolute;left:20px;top:1px;float:left;"><font id="filter_text_<?php echo $year; ?>" size="1pt"><?php echo $year; ?></font></p>
        	        </div>
        	        <?php
        	         	$top-=21;
        	        	$i++;
        	        endforeach; ?>
        	        </div>
        	        
        	        
        	        
        	        <div id="map_submenu_date_2" style="position:absolute;top:40px;right:195px;z-index:6000;width:180px;height:0px;visibility:hidden;">
        	        <?php   $top = 87;
        	        	$i=0;
        	        foreach( $years_2 as $year ):  
        	        	?>
        	        <div id="filter_date_<?php echo $year; ?>" onclick="map_menu_filter_click('<?php echo $year; ?>');" onmouseover="map_menu_filter_over(this.id,'<?php echo $year; ?>');" onmouseout="map_menu_filter_out(this.id,'<?php echo $year; ?>');" style="position:absolute;z-index:5000;border-top:<?php echo ($i!=count($years_2)-1) ? 1 : 0; ?>px dotted #A6A6A6;width:180px;height:20px;background-color:#F5F5F5;top:<?php echo  $top; ?>px;">
        	        	<input id="filter_checkbox_<?php echo $year; ?>" style="position:absolute;top:5px;left:5px;float:left;" type="checkbox" onclick="map_menu_filter_click('<?php echo $year; ?>')"/>
        	        	<p style="position:absolute;left:20px;top:1px;float:left;"><font id="filter_text_<?php echo $year; ?>" size="1pt"><?php echo $year; ?></font></p>
        	        </div>
        	        <?php
        	         	$top-=21;
        	        	$i++;
        	        endforeach; ?>
        	        </div>
        	        
        	        
        	        <!--<div id="filter_projects_current" onclick="map_menu_filter_click('projects_current');" onmouseover="map_menu_filter_over(this.id,'projects_current');" onmouseout="map_menu_filter_out(this.id,'projects_current');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:32px;background-color:#F5F5F5;top:32px;">
        	        	<input id="filter_checkbox_projects_current" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<img style="position:absolute;left:25px;top:5px;float:left;" src="<?php echo URL.'images/project-current.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:7px;float:left;"><font id="filter_text_projects_current" size="1pt">Current</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        <div id="filter_projects_scheduled" onclick="map_menu_filter_click('projects_scheduled');" onmouseover="map_menu_filter_over(this.id,'projects_scheduled');" onmouseout="map_menu_filter_out(this.id,'projects_scheduled');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:32px;background-color:#F5F5F5;top:62px;">
        	        	<input id="filter_checkbox_projects_scheduled" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />
        	        	<img style="position:absolute;left:25px;top:5px;float:left;" src="<?php echo URL.'images/project-scheduled.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:7px;float:left;"><font id="filter_text_projects_scheduled" size="1pt">Scheduled</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>-->
        	        
        	        
        	        
        	</div>
        	
        	<div class="group" style="height: 1.5em; display: block"></div>
            <?php endif; ?>

	    <div class='content group'>
              <?php echo Storage::instance()->content ?>
            </div>


	    <div id="bot-container" class="group">
		<div id="about-us" class="group">
			<div id='about-us-title-container'>
				<div id='about-us-title'>ABOUT</div>
			</div>
			<div style='padding: 30px 22px 40px 16px;'>
				<div><?php echo $about_us; ?></div>
			</div>
		</div>
		<div id="contact-us" class="group" >
			<iframe src ="http://mapspot.ge/embed/embedmap.php?lt=41.698656732302&lg=44.798275215241&z=16&m=1&mlg=44.796767813687&mlt=41.697999849411" width="929" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
			<div id='contact-us-form-container' class='group'>
			    <div id='contact-us-circle'>
				<div style='margin-top: 40px'>CONTACT US</div>
				<div style='margin-top: 7px'>Address: 5 Shevchenko Str.,<br /> Suite 2, Tbilisi, Georgia</div>
				<div style='margin-top: 7px'>
				    <span style=''>Mail: </span>
				    <span style='color: #000'>info@opentaps.ge</span>
				</div>
				<div style='margin-top: 7px;'>Tel: +995 32 214 29 26</div>
				<div style='color: #000; margin-top: 27px;'>We'd love to hear from you</div>
				<div style='color: #000;'>Let's get started!</div>
			    </div>
			    <div id='contact-us-form'>
				<form action='' method=''>
				    <input type='text' name='' value='name:' class='contact-us-input'
					onfocus='contact_us_input_focus(this, "name:")'
					onblur='contact_us_input_blur(this, "name:")' />
				    <input type='text' name='' value='e-mail:*' class='contact-us-input'
					onfocus='contact_us_input_focus(this, "e-mail:*")'
					onblur='contact_us_input_blur(this, "e-mail:*")' />
				    <textarea id='contact-us-textarea'
				    	onfocus='contact_us_input_focus(this, "message:*")'
				    	onblur='contact_us_input_blur(this, "message:*")'>message:*</textarea>
				</form>
			    </div>
			</div>
		</div>
	    </div>

            <div class='bottom group'>
                <div class='bottom1'>
		    © 2011 OPEN TAPS. &nbsp; Designed and developed by
		    <a href='http://jumpstart.ge/'>Jumpstart Georgia</a>
		</div>
	        <div class="bottom2">
	            <span id="about_us_button">ABOUT US</span> &nbsp;&nbsp;|&nbsp;&nbsp;
	            <span id="contact_us_button">
	            	CONTACT US<span style='cursor: pointer'>
	            	</span><img width='10px' src='<?php echo href() ?>images/contact-line.gif' id='contact_us_toggle' />
	            </span>
	        </div>
	    </div>










        </div>

	<script type='text/javascript'>var baseurl = "<?php echo href(); ?>";;</script>
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
	<script type="text/javascript" src="<?php echo URL ?>js/jquery_ui_slide_effect.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/bottom_toggles.js"></script>
    </body>
</html>
