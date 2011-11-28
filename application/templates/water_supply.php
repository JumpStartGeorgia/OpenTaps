<div id='project_content' style="margin-top:5px;">


	<div style="font-size: 15px; font-weight: bold; margin: 20px 0px 25px 2px"><?php echo l('ws_hiy') ?>:</div>

	<div style="margin-left: 15px;">
	    <span style="color: #000; font-size: 10pt;"><?php echo strtoupper(l('ws_region')) ?></span>
	    <select id="ws_regions" style="float: left; width: 290px;">
		<option disabled selected="selected"><?php echo l('disabled_option'); ?></option>
		<?php foreach ( $regions as $region  ): ?> 
		    <option value="<?php echo $region['unique']; ?>" <?php echo (isset($region_unique) AND $region_unique == $region['unique']) ? 'selected="selected"' : NULL; ?>>
			 <?php echo $region['name']; ?>
		    </option>
		<?php endforeach; ?>
	    </select>

	    <span style="margin-left: 25px; color: #000; font-size: 10pt;"><?php echo strtoupper(l('ws_district')) ?></span>
            <select id="ws_districts" style="width: 290px;">
		<option disabled selected="selected"><?php echo l('disabled_option'); ?></option>
            </select>
            <span id="supply_clear_button" style="margin-left: 30px;"><?php echo l('ws_clear') ?></span>
        </div>


        <div id="cont" style="width: 100%; margin: 25px 0px; padding: 0px; height: auto;" class="group"></div>



</div>
