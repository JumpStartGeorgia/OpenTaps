<div id='project_content' style="margin-top:5px;">

    <div class="group" style="width: 670px; float: left;">

	<div style="font-size: 15px; font-weight: bold; margin: 20px 0px 25px 2px;"><?php echo l('ws_hiy') ?>:</div>

	<div style="margin-left: 15px; width: 500px;" class="group">
	    <span style="color: #000; font-size: 10pt; display: block; float: left;"><?php echo strtoupper(l('ws_region')) ?></span>
	    <div style="width: 330px; display: block; float: right;">
		<select id="ws_regions" style="width: 330px;">
		    <option disabled selected="selected"><?php echo l('disabled_option'); ?></option>
		    <?php foreach ( $regions as $region  ): ?> 
		    <option value="<?php echo $region['unique']; ?>" <?php echo (isset($region_unique) AND $region_unique == $region['unique']) ? 'selected="selected"' : NULL; ?>>
			<?php echo $region['name']; ?>
		    </option>
		    <?php endforeach; ?>
		</select>
	    </div>

	    <span style="color: #000; margin-top: 8px; font-size: 10pt; display: block; float: left; clear: both;"><?php echo strtoupper(l('ws_district')) ?></span>
            <div style="width: 330px; display:block; margin-top: 8px; float:right;">
		<select id="ws_districts" style="width: 330px;">
		    <option disabled selected="selected"><?php echo l('disabled_option'); ?></option>
		</select>
		<span id="supply_clear_button" style="float: right; margin-top: 8px;" class="group"><?php echo l('ws_clear') ?></span>
	    </div>
	</div>


	<div id="cont" style="width: 100%; margin: 25px 0px; padding: 0px; height: auto;" class="group"></div>

    </div>

    <div style="float: right; width: 242px; display: none;" class="group" id="ws_project_list">
	<div class='data_block group' style="border-bottom: 0px; border-top: 0px;">
	    <div class='key'><?php echo strtoupper(l('ws_region_projects')) ?></div>
	    <div class='value' style='padding: 0px;'>
	    <?php /*
	    foreach ($projects AS $key => $project):
		$hidden = $key >= config('projects_in_sidebar') ? 'style="display: none;"' : FALSE;
		$ptype = str_replace(' ', '-', strtolower(trim($project['type'])));
		?>
		<a <?php echo $hidden; ?> class="organization_project_link" href="<?php echo href('project/' . $project['unique'], TRUE) ?>">
		    <img src="<?php echo href('images') . $ptype ?>.png" />
		    <?php echo char_limit($project['title'], 28); ?>
		</a>
	    <?php endforeach; ?>
	    <?php if ($hidden): ?><a class="show_hidden_list_items organization_project_link">▾</a><?php endif;*/  ?>
	    </div>
	</div>
    </div>


</div>
