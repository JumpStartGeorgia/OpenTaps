<?php

function edit_button($edit_id = NULL)
{
    return '<span id="' . $edit_id . '" class="admin_edit_button">Edit</span>';
} ?>

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
<?php /*
  <span style="font-size: 10px; display: block; margin-top: 2px;"><?php echo $project['start_at'] ?></span>
 */ ?>
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
                    <?php
                    foreach ($budgets as $budget):
                        echo 'Budget ' . $budget['name'] . ' - ' . $budget['budget'] . ' ' .
                        strtoupper($budget['currency']) . '<br />';
                    endforeach;
                    ?>
<?php echo l('beginning') ?>: <?php echo substr($project['start_at'], 8, 2) . '-' . substr($project['start_at'], 5, 2) . '-' . substr($project['start_at'], 0, 4); ?><br />
<?php echo l('ends') ?>: <?php echo substr($project['end_at'], 8, 2) . '-' . substr($project['end_at'], 5, 2) . '-' . substr($project['end_at'], 0, 4); ?><br />
<?php echo l('type') ?>: <?php echo $project['type']; ?>
                </div>
            </div>

            <?php foreach ($data AS $d): ?>
                <div>
                    <span class="expand_title"><span class="racxa">►</span> <?php echo $d['key'] ?></span>
                    <abbr style="display: none;"><?php $edit_permission AND print edit_button('project_data'); ?></abbr>
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


                <div>
                    <span class="expand_title"><span class="racxa">►</span>chart</span>
                    <div class="expandable" style="margin-left: 0px; padding-left: 0px; text-align: center; width: 640px;">
			<div id="chart-container" style="width: 640px; height: 400px"></div>
                    </div>
                </div>


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
                <?php $i = 0;
                foreach ($side_data as $d): $i++; ?>

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
    <?php
    foreach ($tags as $tag):
        echo
        "<a href='" . href('tag/project/' . $tag['name'], TRUE) . "'>" .
        $tag['name'] . " (" . $tag['total_tags'] . ")" .
        "</a><br />"
        ;
    endforeach;
    ?>
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
