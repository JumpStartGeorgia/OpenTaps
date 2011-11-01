<script type="text/javascript">
    /*var region_map_boundsLeft = 4550479.3343998,
        region_map_boundsRight = 4722921.2701802,
        region_map_boundsTop = 5183901.869223,
        region_map_boundsBottom = 5034696.790037;*/
    var region_map_zoom = false,
    region_make_def_markers = false,
    region_show_def_buttons = false,
    region_map_maxzoomout = 8,
    region_map_longitude = <?php echo isset($project) ? $project['longitude'] : 'false'; ?>,
    region_map_latitude = <?php echo isset($project) ? $project['latitude'] : 'false'; ?>,
    region_marker_click = false;
</script>

<div id='project_content'>

    <div style="float: left;">
        <div id="map" style="width: 638px; height: 160px; border-top: 0;"></div>
        <div style="background:url(<?php echo URL . 'images/bg.jpg' ?>) repeat; width: 610px; height: 31px; padding: 8px 15px;">
            <span style="font-size: 16px;"><?php echo $project['title'] ?></span>
<?php /* <span style="font-size: 10px; display: block; margin-top: 2px;"><?php echo $project['start_at'] ?></span> */ ?>

        </div>
        <?php userloggedin() AND print("<a class='region_link' style='float: right; display: block; margin-right: 5px;' href='" . href('admin/projects/' . $project['unique'], TRUE) . "'>Edit</a>"); ?>
        <div class="group" style="width: 640px; padding: 8px 0px; margin-top: 30px; line-height: 18px;">
            <div>
                <span class="expand_title">
                    <span class="racxa">▼</span> <?php echo l('project_name') ?>: <?php echo $project['title'] ?>
                </span>
                <?php /*<abbr><?php $edit_permission AND print edit_button('basic_info'); ?></abbr>*/ ?>
                <div class="expandable" style="display: block;">
                    <?php echo l('location_region') ?>:
                    <a id="region_link" href="<?php echo href('region/' . $project['region_unique'], TRUE); ?>">
                    <?php echo $project['region_name']; ?>
                    </a><br />
                    <?php echo l('location_city_town') ?>: <?php echo $project['city']; ?><br />
                    <?php echo l('grantee') ?>: <?php echo $project['grantee']; ?><br />
                    <?php echo l('sector') ?>: <?php echo $project['sector']; ?><br />
                    <?php echo l('beneficiary_people') ?>: <?php 
                    		$ben_people = explode(' ',$project['beneficiary_people']);
                    		if( isset($ben_people[1]) ):
                    			$ben_people[0] = number_format($ben_people[0]);
                    		endif; 
                    		echo implode(' ', $ben_people);
                    	?>
							<br />
                    <?php
                    foreach ($budgets as $budget):
                        echo l('budget') . ' ' . $budget['name'] . ' - ' . number_format($budget['budget']) . ' ' .
                        strtoupper($budget['currency']) . '<br />';
                    endforeach;
                    ?>
<?php echo l('beginning') ?>: <?php 
	if( LANG  == 'en'):
		echo call_user_func(config('getDate'),'en',$project['start_at'] );
	else: 
		echo call_user_func(config('getDate'),'ka',$project['start_at'] );
	endif;
	
 ?><br />
<?php echo l('ends') ?>: <?php 

	if( LANG  == 'en'):
		echo call_user_func(config('getDate'),'en',$project['end_at'] );
	else: 
		echo call_user_func(config('getDate'),'ka',$project['end_at'] );
	endif;

?><br />
<?php echo l('type') ?>: <?php echo $project['type']; ?>
                </div>
            </div>

            <?php foreach ($data AS $d): ?>
                <div>
                    <span class="expand_title"><span class="racxa">►</span> <?php echo $d['key'] ?></span>
                    <div class="expandable" data_unique="<?php echo $d['unique']; ?>"><?php echo $d['value']; ?></div>
                </div>
            <?php endforeach; ?>

            <?php if (!empty($organizations)): ?>
                <div>
                    <span class="expand_title"><span class="racxa">►</span> <?php echo l('organizations') ?></span>
                    <div class="expandable">
		        <?php foreach ($organizations AS $org): ?>
		                    <a class="region_link" href="<?php echo href('organization/' . $org['unique'], TRUE); ?>">
					<?php echo $org['name']; ?>
		                    </a><br />
	    		<?php endforeach; ?>
                    </div>
                </div>
		<?php endif; ?>


		<?php if (!empty($chart_data['organization_projects']['data'])): ?>
                <div>
		    <script type="text/javascript">
			var project_page = true,
			data_1 = <?php echo $chart_data['organization_projects']['data'] ?>,
			serialized_data_1 = "<?php echo base64_encode(serialize(json_decode($chart_data['organization_projects']['data']))); ?>";;
		    </script>
                    <span class="expand_title"><span class="racxa">►</span><?php echo $chart_data['organization_projects']['title'] ?></span>
                    <div class="expandable" style="margin-left: 0px; padding-left: 0px; text-align: center; width: 640px;">
			<div id="project-chart-container-1" style="padding: 0; margin: 0; width: 640px;"></div>
                    </div>
                </div>
                <?php endif; ?>

		<?php /*if (!empty($chart_data['all_projects']['data'])): ?>
                <div>
		    <script type="text/javascript">
			var project_page = true,
			data_2 = <?php echo $chart_data['all_projects']['data'] ?>,
			serialized_data_2 = "<?php echo base64_encode(serialize(json_decode($chart_data['all_projects']['data']))); ?>";
		    </script>
                    <span class="expand_title"><span class="racxa">►</span><?php echo $chart_data['all_projects']['title'] ?></span>
                    <div class="expandable" style="margin-left: 0px; padding-left: 0px; text-align: center; width: 640px;">
			<div id="project-chart-container-2" style="padding: 0; margin: 0; width: 640px;"></div>
                    </div>
                </div>
                <?php endif;*/ ?>


            <br />
            <div id="disqus_thread"></div>
            <script type="text/javascript">
                var disqus_shortname = 'opentapsge';
                (function() {
                    var dsq = document.createElement('script');
                    dsq.type = 'text/javascript';
                    dsq.async = true;
                    dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
            </script>


        </div>



    </div><!--LEFT PANEL END-->

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

            <?php if (!empty($tags)): ?>
            <div class='data_block group' <?php ($i == 1) AND print("style='border-top: 0 none;'"); ?>>
                <div class='key'>TAG CLOUD</div>
                <div class='value group' style="line-height: 25px;">
		    <?php foreach ($tags as $key = $tag):
			if ($key == config('projects_in_sidebar'))
                        {
			    break;
                        }
			echo
			"<a href='" . href('tag/project/' . $tag['name'], TRUE) . "'>" .
			char_limit($tag['name'], 28) . " (" . $tag['total_tags'] . ")" .
			"</a><br />"
			;
		    endforeach; ?>
                </div>
            </div>
	    <?php endif; ?>

    </div><!--DATA END-->


<?php /*
  <div id='charts'>

  </div>
 */ ?>

    <input type="hidden" id="project_unique" value="<?php echo $project['unique']; ?>" />

</div>
