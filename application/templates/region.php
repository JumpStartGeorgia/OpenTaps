<div id='project_content'>
    <div style='float:left;width:673px;'>
	<div class='group'>
		<script type="text/javascript">
			var region_map_boundsLeft = 4550479.3343998;
			var region_map_boundsRight = 4722921.2701802;
			var region_map_boundsTop = 5183901.869223;
			var region_map_boundsBottom = 5034696.790037;
			var region_map_zoom = false;
			var region_make_def_markers = false;
			var region_show_def_buttons = false;
			var region_map_maxzoomout = 8;
			var region_map_longitude = <?php echo isset($region_cordinates[0]) ? $region_cordinates[0]['longitude'] : 'false'; ?>;
			var region_map_latitude = <?php echo isset($region_cordinates[0]) ? $region_cordinates[0]['latitude'] : 'false'; ?>;
		</script>
		<div id='map' style='width:282px;height:244px;float:left;'></div>
		
		<div id='project_details'>
			<div id='project_budget'>
				<p>Overall Project Budget</p>
				<p style='font-size:27px;color:#FFF;'><?php echo $region_budget ?></p>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					City :
				</div>
				<div>
					<?php echo $region['city']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Population :
				</div>
				<div>
					<?php echo $region['population']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Square Meters :
				</div>
				<div>
					<?php echo $region['square_meters']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Settlement Type :
				</div>
				<div>
					<?php echo $region['settlement']; ?>
				</div>
			</div>
			<div class='project_details_line' style='border:0;'>
				<div class='line_left'>
					The Village :
				</div>
				<div>
					<?php echo $region['villages']; ?>
				</div>
			</div>
			<div class='project_details_line' style='border:0;'>
				<div class='line_left'>
					District :
				</div>
				<div>
					<?php echo $region['districts']; ?>
				</div>
			</div>
		</div>
	</div>

	<div id='project_description'>
		<p><?php echo $region['name']; ?></p>
		<div><?php echo $region['region_info']; ?></div>

		<p>INFO ON PROJECTS</p>
		<div><?php echo $region['projects_info']; ?></div>
	</div>
    </div>
    <div style="float:right;width:240px;border:0px solid #000;" >
    	<div class="region_right">
			<div style="border:1px dotted #000;width:100%;height:40px;background-color:rgb(30%,75%,100%);border-bottom:0px;">
				<p style="float:left;margin-top:12px;margin-left:20px;color:#FFF;font-size:11pt;font-weight:bold;font-family:arial;">PROJECTS</p>
				<p style="float:right;margin-top:12px;margin-right:25px;"><a href="projects" style="text-decoration:none;color:#FFF;font-size:7.5pt;">►View All</a></p>
			</div>				
			
				<div style="width:100%;height:35px;border:1px dotted #000;">
					<p style="foat:left;margin-left:7px;margin-top:5px;"><img src="" /></p>
					<p style="float:left;margin-left:40px;margin-top:-16px;">sdfsdf</p>
				</div>
				<br /><br /><br />
			<div style="border:1px dotted #000;width:100%;height:40px;background-color:rgb(30%,75%,100%);border-bottom:0px;">
				<p style="float:left;margin-top:12px;margin-left:20px;color:#FFF;font-size:11pt;font-weight:bold;font-family:arial;">OTHERS</p>
				<p style="float:right;margin-top:12px;margin-right:25px;"><a href="projects" style="text-decoration:none;color:#FFF;font-size:7.5pt;">►View All</a></p>
			</div>
				<div style="width:100%;height:250px;border:1px dotted #000;">
					<p style="margin-top:15px;margin-left:10px;font-weight:bold;">sdkfjhsdfhdsf</p>
					<p style="margin-top:10px;">
						<blockquote style="margin-left:10px;width:210px;">
							This is a long quotation.
							 This is a long quotation. This 
							 is a long quotation. This is a long quotation. This is a long quotation.
						</blockquote>
					</p>
				</div>
   	</div>
    	
    </div>
  

</div>
