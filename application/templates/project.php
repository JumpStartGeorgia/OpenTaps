<div id='project_content' class="group">

    <div style="float: left;">
        <div id="map" style="width: 638px; height: 160px; border-top: 0;"></div>
        <?php /* <div style="background:url(<?php echo URL . 'images/bg.jpg' ?>) repeat; width: 610px; height: 31px; padding: 8px 15px;">
            <span style="font-size: 16px;"><?php echo $project['title'] ?></span>
        </div>
        <?php */ userloggedin() AND print("<a class='region_link' style='float: right; display: block; margin-right: 5px;' href='" . href('admin/projects/' . $project['unique'], TRUE) . "'>Edit</a>"); ?>
        <div class="group" id="group" style="width: 640px; padding: 8px 0px; margin-top: 5px; line-height: 18px;">
            <div>
                <span class="expand_title">
                    <span class="racxa">▼</span> <?php echo l('project_name') ?>: <?php echo $project['title'] ?>
                </span>
                <?php /* <abbr><?php $edit_permission AND print edit_button('basic_info'); ?></abbr> */ ?>
                <div class="expandable" style="display: block;">

                    <?php
                    $region_sql = "SELECT name FROM regions WHERE `unique` = {$project['region_unique']} AND lang = '" . LANG . "' LIMIT 1;";
                    $region = db()->query($region_sql, PDO::FETCH_ASSOC)->fetch();
                    if (!empty($region)): ?>
			<div class="project_details_line clearfix" style="width: 100%;">
			    <div class='line_left'>
				<?php echo l('location_region') ?> :
			    </div>
			    <div class="wordwrap">
				<a id="region_link" href="<?php echo href('region/' . $project['region_unique'], TRUE); ?>"><?php echo $region['name'] ?></a>
			    </div>
			</div>
                    <?php endif; ?>

                    <div class="project_details_line clearfix" style="width: 100%;">
                        <div class='line_left'>
                            <?php echo l('location_city_town') ?> :
                        </div>
                        <div class="wordwrap">
                            <?php echo $project['city']; ?>
                        </div>
                    </div>

                    <div class="project_details_line clearfix" style="width: 100%;">
                        <div class='line_left'>
                            <?php echo l('grantee') ?> :
                        </div>
                        <div class="wordwrap">
                            <?php echo $project['grantee']; ?>
                        </div>
                    </div>

                    <div class="project_details_line clearfix" style="width: 100%;">
                        <div class='line_left'>
                            <?php echo l('sector') ?> :
                        </div>
                        <div class="wordwrap">
                            <?php echo $project['sector']; ?>
                        </div>
                    </div>

                    <div class="project_details_line clearfix" style="width: 100%;">
                        <div class='line_left'>
                            <?php echo l('beneficiary_people') ?> :
                        </div>
                        <div class="wordwrap">
			<?php
			    $ben_people = explode(' ', $project['beneficiary_people']);
			    if (isset($ben_people[1]))
					$ben_people[0] = empty($ben_people[0]) ? 'N/A' : number_format($ben_people[0]);

                            echo implode(' ', $ben_people);
                        ?>
                        </div>
                    </div>

                    <div class="project_details_line clearfix" style="width: 100%;">
                        <div class='line_left'>
                            <?php echo l('sector') ?> :
                        </div>
                        <div class="wordwrap">
                            <?php echo $project['sector']; ?>
                        </div>
                    </div>

                    <div class="project_details_line clearfix" style="width: 100%;">
                        <div class='line_left'>
                            <?php echo l('beginning') ?> :
                        </div>
                        <div class="wordwrap">
                            <?php $start_at = $project['start_at'];__( !strtotime($start_at) ? l('no_time') : $start_at) ?>
                        </div>
                    </div>

                    <div class="project_details_line clearfix" style="width: 100%;">
                        <div class='line_left'>
                            <?php echo l('ends') ?> :
                        </div>
                        <div class="wordwrap">
                            <?php $end_at = $project['end_at'];__( !strtotime($start_at) ? l('no_time') : $end_at ) ?>
                        </div>
                    </div>

                    <div class="project_details_line clearfix" style="width: 100%;">
                        <div class='line_left'>
                            <?php echo l('type') ?> :
                        </div>
                        <div class="wordwrap">
                            <?php echo $project['type']; ?>
                        </div>
                    </div>

                    <?php
                    foreach ($budgets as $budget): ?>
			<div class="project_details_line clearfix" style="width: 100%;">
			    <div class='line_left'>
				<?php echo l('budget') . ' <a href="' . href('organization/' . $budget['organization_unique'], TRUE) . '" class="region_link">' . $budget['name'] ?></a> :
			    </div>
			    <div class="wordwrap">
				<?php echo number_format($budget['budget']) . ' ' . strtoupper($budget['currency']); ?>
			    </div>
			</div>
                    <?php endforeach; ?>
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


            <?php
            if (!empty($chart_data['organization_projects']['data'])):
                $csv_uniq = 'chartcsv' . uniqid();
                $_SESSION[$csv_uniq] = $chart_data['organization_projects']['data'];
                $_SESSION[$csv_uniq . '_first_row'] = array('Project Name', 'Budget');
                ?>
                <div>
                    <script type="text/javascript">
                        var project_page = true,
                        data_1 = <?php echo $chart_data['organization_projects']['data'] ?>,
                        uniqid_1 = "<?php echo $csv_uniq; ?>";
                    </script>
                    <span class="expand_title"><span class="racxa">►</span><?php echo $chart_data['organization_projects']['title'] ?></span>
                    <div class="expandable" style="margin-left: 0px; padding-left: 0px; text-align: center; width: 640px;">
                        <div id="project-chart-container-1" style="padding: 0; margin: 0; width: 640px;"></div>
                    </div>
                </div>
            <?php endif; ?>

            <?php /* if (!empty($chart_data['all_projects']['data'])): ?>
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
              <?php endif; */ ?>


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

            <div class="data_block group" <?php ($i == 1) AND print("style='border-top: 0 none;'"); ?>>
                <div class="key">
                    <?php echo strtoupper($d['key']); ?>
                </div>
                <div class="value group">
                    <?php echo $d['value']; ?>
                </div>
            </div>

        <?php endforeach; ?>

        <?php if (!empty($tags)): ?>
            <div class="data_block group" style="border-bottom: 0px;">
                <div class='key'><?php echo strtoupper(l('tag_cloud')) ?></div>
                <div class="value group" style="padding: 0px;">
                    <?php
                    foreach (array_values($tags) as $key => $tag):
                        $hidden = $key >= config('projects_in_sidebar') ? 'style="display: none;"' : FALSE;
                        ?>
                        <a <?php echo $hidden; ?> style="padding: 9px 15px;" class="organization_project_link" href="<?php echo href('tag/project/' . $tag['name'], TRUE) ?>">
                        <?php echo char_limit($tag['name'], 28) . " (" . $tag['total_tags'] . ")" ?>
                        </a><?php
                    endforeach;
                    if ($hidden):
                        ?><a class="show_hidden_list_items organization_project_link">▾</a><?php endif; ?>
                </div>
            </div>
<?php endif; ?>

    </div><!--DATA END-->

    <input type="hidden" id="project_unique" value="<?php echo $project['unique']; ?>" />

</div>

<script>
	var Project = {
		Unique: <?php theData($project,'unique') ?>,
		Type: <?php theData($project,'type') ?>,
		Status: <?php theData($project,'status') ?>
	}, mapMode = 'project';
</script>
