<div id='project_content'>
    <div style='float:left;width:673px;'>
	<div class='group'>
		<script type="text/javascript">
			/*var region_map_boundsLeft = 4550479.3343998;
			var region_map_boundsRight = 4722921.2701802;
			var region_map_boundsTop = 5183901.869223;
			var region_map_boundsBottom = 5034696.790037;*/
			var region_map_zoom = false;
			var region_make_def_markers = false;
			var region_show_def_buttons = false;
			var region_map_maxzoomout = 8;
			var region_marker_click = false;
			var region_map_longitude = <?php echo isset($region_cordinates[0]) ? $region_cordinates[0]['longitude'] : 'false'; ?>;
			var region_map_latitude = <?php echo isset($region_cordinates[0]) ? $region_cordinates[0]['latitude'] : 'false'; ?>;
		</script>
		<div id='map' style='width:282px;border:1px dotted #a6a6a6;border-top:0;height:244px;float:left;'></div>
		
		<div id='project_details' style='min-height: 15px; max-height: 244px; border-bottom: 0px;'>
			<div id='project_budget'>
				<p>Overall Region Budget</p>
				<p style='font-size:27px;color:#FFF;'><?php echo $region_budget ?></p>
			</div>
			<?php if (!empty($region['city']) AND strlen($region['city']) > 0): ?>
			<div class='project_details_line'>
				<div class='line_left'>
					City :
				</div>
				<div>
					<?php echo $region['city']; ?>
				</div>
			</div>
			<?php endif; ?>
			<div class='project_details_line'>
				<div class='line_left'>
					Population :
				</div>
				<div>
					<?php echo $region['population']; ?>
				</div>
			</div>
			<?php if (!empty($region['square_meters']) AND strlen($region['square_meters']) > 0): ?>
			<div class='project_details_line'>
				<div class='line_left'>
					Square Meters :
				</div>
				<div>
					<?php echo $region['square_meters']; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if (!empty($region['settlement']) AND strlen($region['settlement']) > 0): ?>
			<div class='project_details_line'>
				<div class='line_left'>
					Settlement Type :
				</div>
				<div>
					<?php echo $region['settlement']; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if (!empty($region['villages']) AND strlen($region['villages']) > 0): ?>
			<div class='project_details_line'>
				<div class='line_left'>
					The Village :
				</div>
				<div>
					<?php echo $region['villages']; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if (!empty($region['districts']) AND strlen($region['districts']) > 0): ?>
			<div class='project_details_line'>
				<div class='line_left'>
					District :
				</div>
				<div>
					<?php echo $region['districts']; ?>
				</div>
			</div>
			<?php endif; ?>
		</div>

		<?php userloggedin() AND print("<a class='region_link' style='float: right; display: block; margin-right: 5px;' href='" . href('admin/regions/' . $region['unique'], TRUE) . "'>Edit</a>"); ?>

	</div>
		
	<div id='project_description'>
		<p class='desc'><?php echo $region['name']; ?></p>
		<div><?php echo $region['region_info']; ?></div>

		<p class='desc'>INFO ON PROJECTS</p>
		<div><?php echo $region['projects_info']; ?></div>

		<?php foreach ($data as $d): ?>
			<p class='desc'><?php echo strtoupper($d['key']); ?></p>
			<div><?php echo $d['value']; ?></div>
		<?php endforeach; ?>
	</div>

	<div id='project_description' style="margin-bottom: 35px;">
		<p class='desc'>PROJECTS IN THIS REGION</p>
		<table style="margin-left: 0px; margin-bottom: 30px; float: left;">
			<?php foreach($projects AS $project): ?>
			<tr>	
			    <td>
			      <a style='text-decoration:underline;color:#656565' href="<?php echo href('project/' . $project['unique'], TRUE); ?>">
			    	<?php echo $project['title']; ?>
			      </a>
			    </td>
			</tr>			
			<?php endforeach; ?>
		</table>
	</div>



    </div>


	<div style="float: right;"><!--DATA-->
	<?php $i = 0; foreach ($side_data as $d): $i ++; ?>

		<div class='data_block group' <?php ($i == 1) AND print("style='border-top: 0 none;'"); ?>>
			<div class='key'>
				<?php echo strtoupper($d['key']); ?>
			</div>
			<div class='value group'>
				<?php echo $d['value']; ?>
			</div>
		</div>

	<?php endforeach; ?>

	</div><!--DATA END-->


</div>
