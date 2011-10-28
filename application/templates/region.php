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
				<p><?php echo l('region_budget') ?></p>
				<p style='font-size:27px;color:#FFF;'><?php echo $region_budget ?></p>
			</div>
			<?php if (!empty($region['city']) AND strlen($region['city']) > 0): ?>
			<div class='project_details_line'>
				<div class='line_left'>
					<?php echo l('region_city') ?> :
				</div>
				<div>
					<?php echo $region['city']; ?>
				</div>
			</div>
			<?php endif; ?>
			<div class='project_details_line'>
				<div class='line_left'>
					<?php echo l('region_population') ?> :
				</div>
				<div>
					<?php echo $region['population']; ?>
				</div>
			</div>
			<?php if (!empty($region['square_meters']) AND strlen($region['square_meters']) > 0): ?>
			<div class='project_details_line'>
				<div class='line_left'>
					<?php echo l('region_square_meters') ?> :
				</div>
				<div>
					<?php echo $region['square_meters']; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if (!empty($region['settlement']) AND strlen($region['settlement']) > 0): ?>
			<div class='project_details_line'>
				<div class='line_left'>
					<?php echo l('region_settlement_type') ?> :
				</div>
				<div>
					<?php echo $region['settlement']; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if (!empty($region['villages']) AND strlen($region['villages']) > 0): ?>
			<div class='project_details_line'>
				<div class='line_left'>
					<?php echo l('region_villages') ?> :
				</div>
				<div>
					<?php echo $region['villages']; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if (!empty($region['districts']) AND strlen($region['districts']) > 0): ?>
			<div class='project_details_line'>
				<div class='line_left'>
					<?php echo l('district') ?> :
				</div>
				<div>
					<?php echo $region['districts']; ?>
				</div>
			</div>
			<?php endif; ?>
		</div>

		<?php userloggedin() AND print("<a class='region_link' style='float: right; display: block; margin-right: 5px;' href='" . href('admin/regions/' . $region['unique'], TRUE) . "'>" . l('region_edit') . "</a>"); ?>

	</div>
		
	<div id='project_description'>
		<p class='desc'><?php echo $region['name']; ?></p>
		<div><?php echo $region['region_info']; ?></div>

		<p class='desc'><?php echo l('projects_info') ?></p>
		<div><?php echo $region['projects_info']; ?></div>

		<?php foreach ($data as $d): ?>
			<p class='desc'><?php echo strtoupper($d['key']); ?></p>
			<div><?php echo $d['value']; ?></div>
		<?php endforeach; ?>

		<?php if ($count !== FALSE AND is_array($count)): ?>
                <div id="organization_project_types" class="group" style="margin-top: 25px;">
                    <?php foreach (config('project_types') AS $type): ?>
                        <?php if ($count[$type] == 0)
                            continue; ?>
                        <a href="<?php echo href('projects', TRUE) /* filter link here */ ?>">
                            <img src="<?php echo href('images') . str_replace(' ', '-', strtolower(trim($type))) ?>.png" />
                            <?php echo $type . " (" . $count[$type] . ")" ?>
                        </a>
                    <?php endforeach; ?>
                </div>
		<?php endif; ?>

	</div>

	<?php /*<div id='project_description' style="margin-bottom: 35px;">
		<p class='desc'><?php echo l('') ?><?php echo l('region_projects') ?></p>
		<table style="margin-left: 0px; margin-bottom: 30px; float: left;">
			<?php foreach($projects AS $key => $project): ?>
			<tr>	
			    <td>
			      <a style='text-decoration:underline;color:#656565' href="<?php echo href('project/' . $project['unique'], TRUE); ?>">
			    	<?php echo $project['title']; ?>
			      </a>
			    </td>
			</tr>			
			<?php endforeach; ?>
		</table>
	</div>*/ ?>



    </div>


     <?php if (!empty($side_data) OR !empty($projects)): ?>
	<div style="float: right;"><!--DATA-->

                <?php if (!empty($projects)): ?>
                    <div class='data_block group' style="border-bottom: 0px; border-top: 0px;">
                        <div class='key'>
                            <?php echo strtoupper(l('ws_region_projects')) ?>
                        </div>
                        <div class='value' style="padding: 0px;">
                            <?php foreach ($projects AS $key => $project):
                                if ($key == config('projects_in_sidebar'))
                                {
				    break;
                                }
                                $ptype = str_replace(" ", "-", strtolower(trim($project['type']))); ?>
                                <a class="organization_project_link" href="<?php echo href('project/' . $project['unique'], TRUE) ?>">
                                    <img src="<?php echo href('images') . $ptype ?>.png" />
                                    <?php echo char_limit($project['title'], 28) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>



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
     <?php endif; ?>


</div>
