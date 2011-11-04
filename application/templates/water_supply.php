<div id='project_content' style="margin-top:5px;">
    <div style='float:left;width:673px;'>
        <div class='group'>
            <br /><br />
     <p>
     <font style="font-size:10pt;"><?php echo l('ws_hiy') ?>:</font><br /><br /><font style="color:#000;font-size:10pt;"><?php echo strtoupper(l('ws_region')) ?></font>
        <select id="ws_regions">
             <?php foreach( $regions as $region  ): ?> 
     <option value="<?php echo $region['unique']; ?>" <?php echo (isset($region_unique) AND $region_unique == $region['unique']) ? 'selected="selected"' : NULL; ?>>
                         <?php echo $region['name']; ?>
                    </option>
             <?php endforeach; ?>
        </select><br /><br />
         <font style="color:#000;font-size:10pt;"><?php echo strtoupper(l('ws_district')) ?></font>&nbsp;&nbsp;
        <select id="ws_districts"></select>
        </p>
        </div>
        <br />

	<div id="cont" style="width: 400px; margin: 0px; padding: 0px; float: left; height: auto;" class="group"></div>

   	</div>


</div>
