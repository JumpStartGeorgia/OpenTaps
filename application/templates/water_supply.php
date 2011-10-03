<div id='project_content' style="margin-top:5px;">
    <div style='float:left;width:673px;'>
        <div class='group'>
            <br /><br />
     <p><font style="font-size:10pt;">How Interest You:</font>&nbsp;<font style="color:#000;font-size:10pt;">REGION</font>
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
                         Last Updated: <?php echo $ws['last_updated']; ?>
                         </font>
                    </p>
            <?php
             endif;
             endforeach;?>
            </p>
        </div>

   	</div>

    <div style="float:right;width:240px;border:0px solid #a6a6a6;" >
    	<div class="organization_right">
			<div style="border:1px dotted #a6a6a6;width:100%;height:40px;background-color:rgb(30%,75%,100%);border-top:0px;border-bottom:0px;">
				<p style="float:left;margin-top:12px;margin-left:20px;color:#FFF;font-size:11pt;font-weight:bold;font-family:arial;">ORGANIZATION PROJECTS</p>
				<!--<p style="float:right;margin-top:12px;margin-right:25px;"><a href="projects" style="text-decoration:none;color:#FFF;font-size:7.5pt;">►View All</a></p>-->
            </div>
			<div style="width:100%;border:1px dotted #a6a6a6;" class='group'>
					<p style="display:inline-block;foat:left;margin-left:7px;margin-top:5px;"><img width='225px' src="http://media.strategywiki.org/images/thumb/5/57/Angry_Birds_logo.jpg/250px-Angry_Birds_logo.jpg" /></p>
					<p style="padding:5px;display:inline-block">Curabitur a enim in ipsum bibendum pellentesque vitae et orci. Phasellus metus erat, bibendum id dignissim quis, interdum sit amet lectus.</p>
			</div>
       	</div>
    </div>

</div>
