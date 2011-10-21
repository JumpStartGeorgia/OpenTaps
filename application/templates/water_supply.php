<div id='project_content' style="margin-top:5px;">
    <div style='float:left;width:673px;'>
        <div class='group'>
            <br /><br />
     <p><font style="font-size:10pt;"><?php echo l('ws_hiy') ?>:</font>&nbsp;<font style="color:#000;font-size:10pt;"><?php echo strtoupper(l('ws_region')) ?></font>
        <select onchange="$(this).children('option').each(function(){
                           if( $(this).is(':selected') ){
                                 window.location = '<?php echo href('water_supply'); ?>'+$(this).attr('value');
                            }
                        });">
             <?php foreach( $regions as $region  ): ?>
     <option value="<?php echo $region['unique']; ?>" <?php echo (isset($region_unique) AND $region_unique == $region['unique']) ? 'selected="selected"' : NULL; ?>>
                         <?php echo $region['name']; ?>
                    </option>
             <?php endforeach; ?>
        </select></p>
        </div>
        <br />

        <div style="margin-left:105px;width:525px;height:55px;border:1px dotted #A6A6A6;">
            <p style="padding-top:27px;">
             <?php foreach( $water_supply as $ws ):
             if( $ws['region_unique'] == $region_unique):?>
                    <p style="padding-left:10px;margin-top:-15px;">
                        <font style="color:#0CB5F5;">
                            <?php echo $ws['text'];?>
                        </font>
                    </p>
                         <br />
                    <p style="padding-left:10px;margin-top:-7px;">
                         <font style="color:#A6A6A6;">
                         <?php echo l('ws_last_updated') ?>: <?php echo $ws['last_updated']; ?>
                         </font>
                    </p>
            <?php
             endif;
             endforeach;?>
            </p>
        </div>

   	</div>

    <?php if (!empty($projects)): ?>
    <div style="float: right; width: 240px; border:0px;" >
    	<div class="organization_right">

		<div class='data_block group' style="border-bottom: 0px;">
			<div class='key'>
				<?php echo strtoupper(l('ws_region_projects')) ?>
			</div>
			<div class='value' style='padding: 0px;'>
			<?php foreach ($projects AS $project):
				$ptype = str_replace(" ", "-", strtolower(trim($project['type']))); ?>
				<a class="organization_project_link" href="<?php echo href('project/' . $project['unique'], TRUE) ?>">
					<img src="<?php echo href('images') . $ptype ?>.png" />
					<?php echo $project['title'] ?>
				</a>
			<?php endforeach; ?>
			</div>
		</div>

	</div>

    </div>
    <?php endif; ?>


</div>
