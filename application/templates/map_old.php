<div id="map_and_menus" style="position: relative; cursor:pointer;">
                    <div id="map" style="height:360px;"></div>
                <div id="map-overlay"><?php echo strtoupper(l('map_active')) ?></div>
        	        <div id="map_menu" style="position:absolute;top:40px;right:20px;z-index:6000;width:170px;height:0px;visibility:hidden;">
        	        <div id="filter_projects" onclick="map_menu_filter_click('projects');" onmouseover="map_menu_filter_over(this.id,'projects');" onmouseout="map_menu_filter_out(this.id,'projects');" style="z-index:5000;border:0px solid #000;width:170px;height:27px;background-color:#F5F5F5;">
        	        	<!--<input id="filter_checkbox_projects" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />-->
        	        	<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/project.png'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_projects" size="1pt">Projects</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>


        	   	<div id="filter_type" onclick="map_menu_filter_click('type');" onmouseover="map_menu_filter_over(this.id,'type');" onmouseout="map_menu_filter_out(this.id,'type');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:170px;height:27px;background-color:#F5F5F5;top:27px;">
        	        	<!--<input id="filter_checkbox_type" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" />-->
        	        	<img style="position:absolute;left:25px;top:px;float:left;" src="<?php echo URL.'images/type.gif'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_type" size="1pt">Type</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        <div id="filter_news" onclick="map_menu_filter_click('news');" onmouseover="map_menu_filter_over(this.id,'news');" onmouseout="map_menu_filter_out(this.id,'news');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:170px;height:27px;background-color:#F5F5F5;top:53px;">
        	         <input id="filter_checkbox_news" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" onclick="map_menu_filter_click('news')"/>
        	        	<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/news.png'; ?>"/>
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
        	        	<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/date.png'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_date" size="1pt">Date</font></p>
        	        	<img style="position:absolute;right:5px;top:8px;" src="<?php echo URL.'images/left_arrow.gif'; ?>" width="15px" height="15px"/>
        	        </div>
        	        
        	        </div>
        	        
        	        
        	        
        	        <div id="map_submenu_projects" style="position:absolute;top:40px;right:195px;z-index:6000;width:180px;height:0px;visibility:hidden;">
        	        <div id="filter_projects_completed" onclick="map_menu_filter_click('projects_completed');" onmouseover="map_menu_filter_over(this.id,'projects_completed');" onmouseout="map_menu_filter_out(this.id,'projects_completed');" style="z-index:5000;border:0px solid #000;width:180px;height:27px;background-color:#F5F5F5;">
        	        	<input id="filter_checkbox_projects_completed" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" onclick="map_menu_filter_click('projects_completed')"/>
        	        	<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/project.png'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_projects_completed" size="1pt">Completed</font></p>
        	        </div>
        	        <div id="filter_projects_current" onclick="map_menu_filter_click('projects_current');" onmouseover="map_menu_filter_over(this.id,'projects_current');" onmouseout="map_menu_filter_out(this.id,'projects_current');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:27px;background-color:#F5F5F5;top:27px;">
        	        	<input id="filter_checkbox_projects_current" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" onclick="map_menu_filter_click('projects_current')"/>
        	        	<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/project-current.png'; ?>"/>
        	        	<p style="position:absolute;left:55px;top:4px;float:left;"><font id="filter_text_projects_current" size="1pt">Current</font></p>
        	        </div>
        	        <div id="filter_projects_scheduled" onclick="map_menu_filter_click('projects_scheduled');" onmouseover="map_menu_filter_over(this.id,'projects_scheduled');" onmouseout="map_menu_filter_out(this.id,'projects_scheduled');" style="position:absolute;z-index:5000;border-top:1px dotted #A6A6A6;width:180px;height:27px;background-color:#F5F5F5;top:55px;">
        	        	<input id="filter_checkbox_projects_scheduled" style="position:absolute;top:10px;left:5px;float:left;" type="checkbox" onclick="map_menu_filter_click('projects_scheduled')" />
        	        	<img style="position:absolute;left:25px;top:2px;float:left;" src="<?php echo URL.'images/project-scheduled.png'; ?>"/>
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

        	        
        	</div>
        	
        	<div class="group" style="height: 1.5em; display: block"></div>
