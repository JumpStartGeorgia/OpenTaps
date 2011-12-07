<?php
$direction = strtoupper($direction);
$this_order = empty($this_order) ? NULL : $this_order;
$this_order_href = 'order/' . $this_order . '-' . $direction . '/';
$filterlink = $filter ? '/filter/' . $filter : NULL;
?>
<a name="projects"></a>

<div id='tag_content'>
    <div id='left_list'>
        <div class='group headers'>
            <div class='headers_left'><?php echo strtoupper(l('tags_projects')) ?></div>
            <div class='headers_right' style="padding-top: 5px; padding-right: 5px;">
                <?php echo l('projects_filter_by') ?>
                <?php $location = URL . 'projects/order/' . $this_order . '-' . $direction . '/page/' . $current_page . '/'; ?>
                <select style="width: 170px;" onchange="if (this.value == '') window.location.href = '<?php echo $location; ?>'; else window.location.href = '<?php echo $location; ?>filter/' + this.value + '/?lang=' + lang + '#projects';">
                    <option selected="selected" value=""><?php echo l('news_page_all') ?></option>
                    <?php
                    foreach ($types AS $type)
                    {
                        $value = strtolower(str_replace(" ", "%20", $type));
                        echo '<option ' . ($filter == $type ? 'selected="selected"' : NULL) . ' value="' . $value . '">' . l('pt_' . strtolower($type)) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class='group' id='newstype_filter' style='width: 100%; border-bottom: 1px solid #eee;'>
            <div class='titletype_left' style='font-size: 9px; padding-left: 11px;'>
                <span style="font-size: 11px; margin-right: 7px;"><?php echo l('projects_sort_by') ?></span>
                <?php
                $orders = array('region', 'district', 'years', 'categories', 'a-z');
                foreach ($orders as $order):
                    ?>
                    <a<?php LANG == 'ka' and print ' style="font-size: 13px;"' ?> href="<?php echo href('projects/order/' . $order . '-ASC' . $filterlink, TRUE, 'projects') ?>"
                                                                                  class='choosedef<?php ($order == $this_order) AND print("_selected") ?>'>
                                                                                      <?php echo strtoupper(l('project_order_' . $order)); ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class='titletype_center'></div>

            <div class='titletype_right'>
                <a class="choosedef<?php ($direction == 'ASC') AND print('_selected') ?>" style="color: #0cb5f5;" title="from first to last" href="<?php echo href('projects/order/' . $this_order . '-ASC' . $filterlink, TRUE, 'projects'); ?>">▼</a>
                <a class="choosedef<?php ($direction == 'DESC') AND print('_selected') ?>" style="color: #0cb5f5;" title="from last to first" href="<?php echo href('projects/order/' . $this_order . '-DESC' . $filterlink, TRUE, 'projects'); ?>">▲</a>
            </div>
        </div>

        <div id='internal_container' class='group'>
            <?php foreach ($projects as $index => $project): ?>
                <div class='content_each group <?php ($index % 2 == 1) AND print("with_bg"); ?>'>
                    <a href="<?php echo href('project/' . $project['unique'], TRUE) ?>">
                        <div class='content_each_left'>
                            <div class='content_each_title'><?php echo $project['title'] ?></div>
                            <div class='content_each_body'>
                                <?php echo word_limiter(strip_tags($project['description']), 170); ?>
                            </div>
                        </div>
                        <?php $rgba = 1 - ($index % 3) / 2.5; ?>
                        <div class='content_each_right' style='border-left: 7px solid rgba(12, 181, 245, <?php echo $rgba; ?>)'>
                            <div style='padding: 20px 4px;font-size: 10px; text-align: center;'>
                                <!--
                                <a id="region_link" href="<?php echo href('region/' . $project['region_unique'], TRUE); ?>">
                                <?php echo $project['region_name'] ?>
                                </a><br />
                                -->
                                <?php echo l('pt_' . strtolower($project['type'])) ?><br />
                                <?php
                                $start_at = substr($project['start_at'], 0, 10);
                                __(!strtotime($start_at) ? '<span style="font-size: 9px">' . l('no_time') . '</span>' : $start_at );
                                ?>
                            </div>
                        </div>
                </div>
            <?php endforeach; ?>
            </a>
        </div>

        <?php if ($total_pages > 1): ?>
            <div id='pages'>
                <?php if ($current_page > 1):
                    $pagelink = 'page/' . ($current_page - 1); ?>
                    <a href="<?php echo href('projects/' . $this_order_href . $pagelink . $filterlink, TRUE) ?>" class='prevnext'><</a>
                <?php endif; ?>
                <?php
                for ($page = 1; $page <= $total_pages; $page++):
                    $pagelink = 'page/' . $page;
                    if ($page != $current_page):
                        ?>
                        <a href='<?php echo href("projects/" . $this_order_href . $pagelink . $filterlink, TRUE) ?>'>
                            <?php
                            echo $page;
                            ($total_pages == $page) OR print(" |");
                            ?>
                        </a>
                        <?php
                    else:
                        echo "<b style=\"font-size: 105%\">{$page}</b>";
                        ($total_pages == $page) OR print(" |");
                    endif;
                endfor;
                if ($current_page < $total_pages):
                    $pagelink = 'page/' . ($current_page + 1);
                    ?>
                    <a href="<?php echo href('projects/' . $this_order_href . $pagelink . $filterlink, TRUE) ?>" class='prevnext'>></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>

    <div id='right_list'>
        <div class='right_box'>
            <div class='headers'>
                <div class='right_box_title'><?php echo strtoupper(l('tag_cloud')) ?></div>
            </div>

	    <div class="value group right_box_content" style="padding: 0px; border-bottom: 0px;" id='right_box_tags'>
            <?php $limit = config('projects_in_sidebar');
            foreach (array_values($tags) as $key => $tag):
                $hidden = $key >= $limit ? 'display: none; ' : FALSE;
                ?>
                <a style="<?php echo $hidden; ?>padding: 9px 15px; margin: 0px;" class="organization_project_link" href="<?php echo href('tag/projects/' . $tag['name'], TRUE) ?>">
                <?php echo char_limit($tag['name'], 28) . " (" . $tag['total_tags'] . ")" ?>
                </a><?php
            endforeach;
            if ($hidden):
                ?><a class="show_hidden_list_items organization_project_link" style="margin: 0px; display: block;">▾</a><?php
            endif; ?>
	    </div>
        </div>
    </div>
</div>
