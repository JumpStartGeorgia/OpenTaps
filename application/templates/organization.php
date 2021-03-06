<?php
	$projects = array_values($projects);
?>
<div id='project_content' class="group" style="margin-bottom: 6px;">
    <div style='float: left; width: 673px;'>
        <div class='group'>
            <?php
            if (!empty($organization['logo']) AND file_exists($organization['logo']))
            {
                $p = substr($organization['logo'], 0, 7);
                if ($p != 'http://' AND $p != 'https:/')
                    $logo = URL . $organization['logo'];
                $dimensions = theOrganizationLogoDimensions($logo);                
                ?><div style="width: 262px; float: left; padding: 0px 10px; text-align: center; border: 1px dotted #a6a6a6; border-top: 0px;">
                    <img style="vertical-align:middle;padding: 0px; margin: 0px;width:<?php echo $dimensions['width'] ?>px;height:<?php echo $dimensions['height']  ?>px;" src="<?php echo $logo; ?>" />
                </div><?php
        }
        else
        {
                ?>
                <div style="width: 282px; height: 170px; background: url(<?php echo URL ?>images/bg.jpg); float: left;">
                    <div style="width: 100%; padding-top: 65px; height: 105px; text-align: center; color: #FFF; font-weight: bold; background: rgba(12, 181, 245, 1); letter-spacing: 1px; font-size: 25px;">
                        <?php echo l('no_logo') ?>
                    </div>
                </div>
                <?php
            }
            ?>


            <div id='project_details' style="min-height: 15px; border-bottom: 0px;">
                <div id='project_budget'>
                  <?php if (!empty($organization_budget) AND $organization_budget != 0): ?>
                    <p><?php echo l('overall_project_budget') ?></p>
                    <p style='font-size:27px;color:#FFF;'><?php echo $organization_budget ?></p>
                  <?php else: ?>
		    <p style='font-size:27px;color:#FFF;'><?php echo l('budget_empty_text') ?></p>
                  <?php endif; ?>
                </div>
                <?php if (!empty($organization['district']) AND strlen($organization['district']) > 0): ?>
                    <div class="project_details_line clearfix" style="width:100%;">
                        <div class='line_left'>
                            <?php echo l('region_district') ?> :
                        </div>
                        <div class="wordwrap">
                            <?php echo $organization['district']; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($organization['city_town']) AND strlen($organization['city_town']) > 0): ?>
                    <br />
                    <div class="project_details_line clearfix">
                        <div class='line_left' >
                            <?php echo l('org_city') ?> :
                        </div>
                        <div class="wordwrap">
                            <?php echo $organization['city_town']; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($organization['grante']) AND strlen($organization['grante']) > 0): ?>
                    <div class='project_details_line clearfix'>
                        <div class='line_left'>
                            <?php echo l('grantee') ?> :
                        </div>
                        <div class="wordwrap">
                            <?php echo $organization['grante']; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($organization['sector']) AND strlen($organization['sector']) > 0): ?>
                    <div class='project_details_line clearfix'>
                        <div class='line_left'>
                            <?php echo l('sector') ?> :
                        </div>
                        <div class="wordwrap">
                            <?php echo $organization['sector']; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <?php userloggedin() AND print("<a class='region_link' style='float: right; display: block; margin-right: 5px;' href='" . href('admin/organizations/' . $organization['unique'], TRUE) . "'>Edit</a>"); ?>

        </div>

        <div id='project_description' style="margin-top: 40px;">
            <p class='desc'><?php echo $organization['name'] ?></p>
            <?php if (!empty($organization['description'])): ?>
                <p class='desc' style='font-size: 17px; font-weight: normal; margin-top: 5px;'><?php echo strtoupper(l('org_desc')) ?></p>
                <div class="withmargin" style="margin-bottom: 15px; padding-bottom: 0px;"><?php echo $organization['description']; ?></div>
            <?php endif; ?>


            <?php /* <p class='desc'>INFO ON PROJECTS</p> */ ?>
            <?php if (!empty($organization['projects_info'])): ?>
                <div style="margin: 0px 0px 25px; width: 100%; border-top: 1px solid rgba(12, 181, 245, .5); height: 0px"></div>
                <div class="withmargin" style="margin-top: 0px;"><?php echo $organization['projects_info']; ?></div>
            <?php endif; ?>

            <?php foreach ($data as $d): ?>
                <p class='desc'><?php echo strtoupper($d['key']); ?></p>
                <div class="withmargin"><?php echo $d['value']; ?></div>
            <?php endforeach; ?>

            <?php if ($count !== FALSE AND is_array($count)): ?>
                <div id="organization_project_types" class="group">
                    <?php foreach (config('project_types') AS $type): ?>
                        <?php if ($count[$type] == 0)
                            continue; ?>
                        <a href="<?php echo href('projects/order/region-ASC/page/1/filter/' . urlencode(strtolower($type)) . '/?lang=' . LANG, TRUE) /* filter link here */ ?>">
                            <img src="<?php echo href('images') . str_replace(' ', '-', strtolower(trim($type))) ?>.png" />
                            <?php echo l('pt_' . strtolower($type)) . " (" . $count[$type] . ")" ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($chart_data['organizations_budgets'])): ?>
                <div class="group">
                    <?php /*
                    if (!empty($chart_data['organization_projects']['data'])):
                        $csv_uniq = 'chartcsv' . uniqid();
                        $_SESSION[$csv_uniq] = $chart_data['organization_projects']['data'];
                        $_SESSION[$csv_uniq . '_first_row'] = array('Project Name', 'Budget');
                        ?>
                        <script type="text/javascript">
                            var org_page = true,
                            data_1 = <?php echo $chart_data['organization_projects']['data'] ?>,
                            uniqid_1 = "<?php echo $csv_uniq; ?>";
                        </script>
                        <div class="withmargin" style="width: 100%; text-align: center;">
                            <p class='desc'><?php echo l('chart_org_projects') ?></p>
                            <div id="org-chart-container-1" style="padding: 0; margin: 0 auto; width: 100%;"></div>
                        </div>
                    <?php endif; */

                    if (!empty($chart_data['budgets_by_year']['data'])):
                        /*$csv_uniq = 'chartcsv' . uniqid();
                        $_SESSION[$csv_uniq] = $chart_data['budgets_by_year']['data'];
                        $_SESSION[$csv_uniq . '_first_row'] = array('Project Name', 'Budget');
                        */ ?>
                        <script type="text/javascript">
                            var data_3 = <?php echo $chart_data['budgets_by_year']['data'] ?>;
                            //uniqid_3 = "<?php //echo $csv_uniq; ?>";
                        </script><div id="breaker" class="group" style="clear:both; display: block; height: 0px; width: 100%;"></div>
                        <div class="withmargin" style="width: 100%; text-align: center; display: block;">
                            <p class="desc"><?php echo l('budgets_by_year'); ?></p>
                            <div id="org-chart-container-3" style="padding: 0; margin: 0 auto; width: 100%;"></div>
                        </div>
                    <?php endif; ?>


                    <?php
                    if (!empty($chart_data['organizations_budgets']['data'])):
                        $csv_uniq = 'chartcsv' . uniqid();
                        $_SESSION[$csv_uniq] = $chart_data['organizations_budgets']['data'];
                        $_SESSION[$csv_uniq . '_first_row'] = array('Organization Name', 'Budget');
                        ?>
                        <script type="text/javascript">
                            var org_page = true,
                            data_2 = <?php echo $chart_data['organizations_budgets']['data'] ?>,
                            uniqid_2 = "<?php echo $csv_uniq; ?>";
                        </script>
                        <div class="withmargin group" style="width: 334px; margin: 20px auto 0px auto; text-align: center; display: block;">
                            <p class="desc"><?php echo l('chart_org_budget') ?></p>
                            <div id="org-chart-container-2" style="padding: 0; margin: 0 auto; width: 335px;"></div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

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
    </div>

    <?php if (!empty($tags) OR !empty($projects) OR !empty($side_data) OR !empty($donors)): ?>
        <div style="float: right; width: 240px; border:0px solid #a6a6a6;" >
            <div class="organization_right">

                <?php if (!empty($projects)): ?>
                    <div class='data_block group' style="border-bottom: 0px; border-top: 0px;">
                        <div class='key'>
                            <?php echo strtoupper(l('org_projects')) ?>
                        </div>
                        <div class='value' style='padding: 0px;'>
                            <?php
                            foreach ($projects AS $key => $project):
                                /*if ($key == config('projects_in_sidebar'))
                                    break;*/
                                $hidden = $key >= config('projects_in_sidebar') ? 'style="display: none;"' : FALSE;
                                $ptype = str_replace(' ', '-', strtolower(trim($project['type'])));
                                ?>
                                <a <?php echo $hidden; ?> class="organization_project_link" href="<?php echo href('project/' . $project['unique'], TRUE) ?>">
                                    <img src="<?php echo href('images') . $ptype ?>.png" />
                                    <?php echo char_limit($project['title'], 28); ?>
                                </a>
                            <?php endforeach; ?>
                            <?php if ($hidden): ?><a class="show_hidden_list_items organization_project_link">▾</a><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($donors)): ?>
                    <div class='data_block group' style="border-bottom: 0px; border-top: 0px;">
                        <div class='key'>
                            <?php echo 'DONOR' ?>
                        </div>
                        <div class='value' style='padding: 0px;'>
                            <?php
                            foreach ($donors AS $key => $donor):
                                /*if ($key >= config('projects_in_sidebar'))
                                {
                                    break;
                                }*/
                                $hidden = $key >= config('projects_in_sidebar') ? 'style="display: none;"' : FALSE;
                                $ptype = str_replace(" ", "-", strtolower(trim($donor['type'])));
                                ?>
                                <a <?php echo $hidden; ?> class="organization_project_link" href="<?php echo href('project/' . $donor['unique'], TRUE) ?>">
                                    <img src="<?php echo href('images') . $ptype ?>.png" />
                                    <?php echo char_limit($donor['title'], 28) ?>
                                </a>
                            <?php endforeach; ?>
                            <?php if ($hidden): ?><a class="show_hidden_list_items organization_project_link">▾</a><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php $i = 0;
                foreach ($side_data as $d): $i++; ?>

                    <div class='data_block group' <?php ($i == 1) AND print("style='border-top: 0 none;'"); ?>>
                        <div class='key'>
                            <?php echo strtoupper($d['key']); ?>
                        </div>
                        <div class="value group">
                            <?php echo $d['value']; ?>
                        </div>
                    </div>

                <?php endforeach; ?>

                <?php if (!empty($tags)): ?>
                    <div class="data_block group" style="border-bottom: 0px;">
                        <div class='key'>
                            <?php echo strtoupper(l('tag_cloud')) ?>
                        </div>
		        <div class="value group" style="padding: 0px;">
		            <?php
		            foreach (array_values($tags) as $key => $tag):
		                $hidden = $key >= config('projects_in_sidebar') ? 'display: none; ' : FALSE;
		                ?>
		                <a style="<?php echo $hidden; ?>padding: 9px 15px;" class="organization_project_link" href="<?php echo href('tag/organization/' . $tag['name'], TRUE) ?>">
		                <?php echo char_limit($tag['name'], 28) . " (" . $tag['total_tags'] . ")" ?>
		                </a><?php
		            endforeach;
		            if ($hidden):
		                ?><a class="show_hidden_list_items organization_project_link">▾</a><?php endif; ?>
		        </div>
		            </div>
		        <?php endif; ?>

            </div>

        </div>
    <?php endif; ?>

</div>
<script>
	var Organization = {
		Unique: <?php theData($organization,'unique') ?>,
		Prefix: 'org'
	};
</script>
<?php Storage::instance()->show_export = true ?>
