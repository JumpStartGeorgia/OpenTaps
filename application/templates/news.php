<?php
$images = array(
    'photo' => 'images/photo.png',
    'document' => 'images/doc.png',
    'barchart' => 'images/chart-bar.png',
    'piechart' => 'images/chart-pie.png',
    'text' => 'images/text.png',
    'video' => 'images/video.png'
);

$this_type_original = empty($this_type) ? NULL : $this_type;
$this_type = empty($this_type) ? NULL : 'type/' . $this_type . '/';
?>
<a name="news"></a>

<div id='tag_content'>

    <div id='left_list'>

        <div class='group headers'><div class='headers_left'><?php echo strtoupper(l('news')) ?></div></div>

        <div class='group' id='newstype_filter' style='width: 100%; border-bottom: 1px solid #eee;'>

            <div class='titletype_left' style='padding-left: 11px; font-size:9px;'>

                <a href='<?php echo href('news', TRUE, "news") ?>' class='choosedef<?php echo empty($this_type_original) ? '_selected' : NULL ?>'><?php echo l('news_page_all'); ?></a>
                <?php
                $types = config("news_types");
                foreach ($types as $type):
                    ?>
                    <a href='<?php echo href('news/type/' . $type, TRUE, "news") ?>' class='choosedef<?php echo $type == $this_type_original ? '_selected' : NULL ?>'><?php echo strtoupper(l('nt_' . $type)); ?></a>
                <?php endforeach; ?>
            </div>

            <div class='titletype_right' style='margin-top:4px;'></div>

        </div>

        <div id='internal_container' class='group'>

            <?php foreach ($news_all as $index => $news): ?>
                <div class='content_each group <?php echo ($index % 2 == 1) ? 'with_bg' : NULL ?>'>
                  <a href="<?php echo href('news/' . $news['unique'], TRUE) ?>">
                    <div class='content_each_left'>
                        <div class='content_each_title'><?php echo $news['title'] ?></div>
                        <div class='content_each_body'>
                            <?php echo word_limiter(strip_tags($news['body']), 170); ?>
                        </div>
                    </div>
                    <?php $rgba = 1 - ($index % 3) / 2.5; ?>
                    <div class='content_each_right' style='border-left: 7px solid rgba(12, 181, 245, <?php echo $rgba; ?>)'>
                        <div style='padding: 4px; padding-top: 15px; font-size: 10px; text-align: center;'>
                            <img src="<?php echo href() . $images[$news['category']] ?>" height='36px' /> <br />
                            <?php echo dateformat($news['published_at']); ?>
                        </div>
                    </div>
                  </a>  
                </div>
            <?php endforeach; ?>

        </div>

        <?php if ($total_pages > 1): ?>
            <div id='pages'>
                <?php if ($current_page > 1):
                    $pagelink = empty($this_type) ? 'page/' . ($current_page - 1) : ($current_page - 1); ?>
                    <a href='<?php echo href("news/" . $this_type . $pagelink, TRUE, "news") ?>' class='prevnext'>Prev</a>
                <?php endif; ?>
                <?php
                for ($page = 1; $page <= $total_pages; $page++):
                    $pagelink = empty($this_type) ? 'page/' . $page : $page;
                    if ($page != $current_page):
                        ?>
                        <a href='<?php echo href("news/" . $this_type . $pagelink, TRUE, "news") ?>'>
                            <?php
                            echo $page;
                            echo ($total_pages == $page) ? NULL : " |";
                            ?>
                        </a>
                        <?php
                    else:
                        echo $page;
                        echo ($total_pages == $page) ? NULL : " |";
                    endif;
                endfor;
                if ($current_page < $total_pages):
                    $pagelink = empty($this_type) ? 'page/' . ($current_page + 1) : ($current_page + 1);
                    ?>
                    <a href='<?php echo href("news/" . $this_type . $pagelink, TRUE, "news") ?>' class='prevnext'>Next</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>

    <?php if (!empty($tags)): ?>
        <div id="right_list">
            <div class="right_box">
                <div class="headers">
                    <div class="right_box_title"><?php echo strtoupper(l('tag_cloud')) ?></div>
                </div>
                <div class="right_box_content" id="right_box_tags"><?php
    $limit = config('projects_in_sidebar');
    foreach ($tags AS $key => $tag):
        if ($key == $limit)
            break;
        $link = href('tag/news/' . $tag['name'], TRUE, 'tags');
        echo '<a href="' . $link . '" style="display: block">' . $tag['name'] . ' (' . $tag['total_tags'] . ')</a>';
    endforeach;
        ?></div>
            </div>
        </div>
    <?php endif; ?>

</div>
