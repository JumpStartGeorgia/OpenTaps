<div class="group">
    <div class='projects_organization'><?php echo strtoupper(l('projects_org')); ?></div>

    <div class='news group'><?php echo strtoupper(l('news')) ?></div>

    <div id="chart" class='chart'></div>

    <?php
    $news_all = fetch_db("SELECT * FROM news WHERE lang = '" . LANG . "' AND image != '' ORDER BY published_at DESC LIMIT 0,6");
    $count = count($news_all);
    if ($count > 2)
    {
	$image = $news_all[2]['image'];
	$third_src = substr($image, 0, 7);
	$third_src = ($third_src == "http://" OR $thirdsrc == "https:/") ? $image : href() . $image;
    }
    ?>

    <div class='news_body group'>
        <div style="width: 535px;" class="group">

            <?php for ($index = 0; $index < 2; $index++):
		if (empty($news_all[$index]))
		{
    		    break;
    		}
                $news = $news_all[$index];
                $src = substr($news['image'], 0, 7);
                $src = ($src == "http://" OR $src == "https:/") ? $news['image'] : href() . $news['image'];
                switch ($news['category'])
                {
                    default: $filename = "text";
                        break;
                    case "text": $filename = "text";
                        break;
                    case "video": $filename = "video";
                        break;
                    case "photo": $filename = "photo";
                        break;
                    case "document": $filename = "doc";
                        break;
                    case "chart": $filename = "chart-pie";
                        break;
                }
                $type_src = href() . "images/" . $filename . ".png";
                $margin = $index == 1 ? 'style="margin-left: 25px"' : NULL;
                ?>
                <div class="top_image" <?php echo $margin ?>>
                    <div class="over_background">
                        <img style="width:38px; height:55px; border: 0px;" src="<?php echo $type_src ?>" />
                        <br />
	    		<?php echo strtoupper($news['title']); ?>
                    </div>
                    <a href="<?php echo href("news/" . $news['unique'], TRUE); ?>">
                        <img src="<?php echo $src ?>" />
                    </a>
                </div>
            <?php endfor; ?>

        </div>
        <div id="news_middle_content">
            <?php if ($count > 2): ?>
            <div id="left_image_box">
                <img src="<?php $count > 2 AND print $third_src ?>" />
            </div>
            <?php endif; ?>
            <div id="right_titles_box">
<?php
for ($index = 2; $index < 6; $index++):
    if (!isset($news_all[$index]) OR empty($news_all[$index]))
    {
        break;
    }
    $news = $news_all[$index];
    $src = substr($news['image'], 0, 7);
    $src = ($src == "http://" OR $src == "https:/") ? $news['image'] : href() . $news['image'];
    ?>
                    <div class="right_title_one">
                        <a href="<?php echo href("news/" . $news['unique'], TRUE); ?>">
                            <span><</span><?php echo strtoupper($news['title']); ?>
                        </a>
                        <input type="hidden" class="src_container" value="<?php echo $src; ?>" />
                    </div>
    <?php if ($index != 5): ?>
                        <hr style="background: transparent; border: 0px; height: 2px;" />
    <?php endif; ?>
<?php endfor; ?>
            </div>
        </div>

        <div id="news_bottom_content">
            <a href="<?php echo href("news", TRUE); ?>">▸ <?php echo l('all_news') ?></a>
        </div>
    </div>
</div>


<?php $filenameend = (LANG == "ka") ? "-geo.png" : ".gif"; ?>

<div style="margin-top: 27px; " class="group">
    <div style="float: left; width: 293px; text-align: justify; font-size: 11px; color: #808080">
	<?php echo l('home_page_bottom_text'); ?>
    </div>
    <div style="float: left; margin-left: 85px; font-size: 14px; font-weight: bold; color: #00AFF2;">
        <a href="<?php echo href("water_supply", TRUE) ?>">
            <img src="<?php echo href('images') . 'water-supply' . $filenameend ?>" style="margin-top: 9px;" />
        </a>
        <h4 style="visibility: hidden;">WATER SUPPLY SCHEDULE</h4>
    </div>
    <div style="display: inline-block; margin-left: 56px; height: 57px; padding-left: 56px; font-size: 14px; font-weight: bold; color: #00AFF2; border-left: 1px dotted #a6a6a6;">
        <a href="#">
            <img src="<?php echo href('images') . 'water-diseases' . $filenameend ?>" style="margin-top: 9px;" />
        </a>
        <h4 style="visibility: hidden;">WATER AND DISEASES</h4>
    </div>
</div>
