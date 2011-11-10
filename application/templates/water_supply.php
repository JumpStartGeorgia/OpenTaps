<div id='project_content' style="margin-top:5px;">
    <div style='float:left;width:673px;'>
        <div class='group'>
            <br /><br />
     <p>
     <font style="font-size:10pt;"><?php echo l('ws_hiy') ?>:</font><br /><br /><div style="margin-left:100px;"><font style="color:#000;font-size:10pt;"><?php echo strtoupper(l('ws_region')) ?></font></div><br/>
        <select id="ws_regions">
             <?php foreach ( $regions as $region  ): ?> 
     <option value="<?php echo $region['unique']; ?>" <?php echo (isset($region_unique) AND $region_unique == $region['unique']) ? 'selected="selected"' : NULL; ?>>
                         <?php echo $region['name']; ?>
                    </option>
             <?php endforeach; ?>
        </select>
        <div style="margin-left:400px;margin-top:-58px;">
        <div style="margin-left:100px;"><font style="color:#000;font-size:10pt;"><?php echo strtoupper(l('ws_district')) ?></font></div>&nbsp;&nbsp;
        <select id="ws_districts"></select>
        </p>
        </div>
        </div>
        <br /><br />

   	</div>




</div>
