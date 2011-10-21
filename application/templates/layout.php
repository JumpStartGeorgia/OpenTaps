<!DOCTYPE html>
﻿<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php empty(Storage::instance()->title) OR print Storage::instance()->title . ' - ' ?>OpenTaps</title>
        <link type="text/css" rel="stylesheet" href="<?php echo URL ?>main.css" media="all" />
        <link type="text/css" rel="stylesheet" href="<?php echo URL ?>adm.css" media="all" />
        <link type="text/css" rel="stylesheet" href="<?php echo URL ?>chosen.css" media="all" />
        <script type="text/javascript">
            var baseurl = '<?php echo href() ?>';
<?php if (Storage::instance()->show_map): ?>
        var region_map_boundsLeft = false,
        region_map_boundsRight = false,
        region_map_boundsTop = false,
        region_map_boundsBottom = false,
        region_map_zoom = false,
        region_map_maxzoomout = false,
        region_map_longitude = false,
        region_map_latitude = false,
        region_make_def_markers = false,
        region_show_def_buttons = true,
        region_marker_click = true,
        places = [<?php echo implode(', ', empty(Storage::instance()->js_places) ? array() : Storage::instance()->js_places) ?>],
        news = [<?php echo implode(', ', empty(Storage::instance()->js_news) ? array() : Storage::instance()->js_news) ?>],
        projects = [<?php echo implode(', ', empty(Storage::instance()->js_projects) ? array() : Storage::instance()->js_projects) ?>];
<?php endif; ?>
        </script>
    </head>
    <body onload="init()">
        <div class='main group'>

            <div class='header' style="position: relative">

                <a href="<?php echo href(NULL, TRUE) ?>" style="text-decoration: none"><img id="site-logo" src="<?php echo URL ?>images/open-taps-logo.gif" /></a>

                <div style="position: absolute; font-size: 11px; right:0px; word-spacing: 7px;">
                    <?php foreach ($languages AS $lang): ?>
                        <?php if (LANG == $lang): ?>
                            <a class="region_link" style="font-weight: bold; text-decoration: none;"><?php echo strtoupper($lang); ?></a>
                            <?php continue;
                        endif; ?>
                        <a class="region_link" href="<?php echo change_language($lang); ?>"><?php echo strtoupper($lang); ?></a>
                    <?php endforeach; ?>
                </div>

                <div class='header_right slidenews'>
                    <?php foreach ($slide_news as $news): ?>
                        <div class="slide"><a href="<?php echo href('news/' . $news['unique'], TRUE) ?>">
                                <p><?php echo $news['title']; ?></p>
                                <?php echo word_limiter(strip_tags($news['body']), 320); /* ?>
                                  <div class="slider_date"><?php echo $news['published_at']; ?></div> */ ?>
                            </a></div>
                    <?php endforeach; ?>
                </div>

            </div>

            <div class='after_header'></div>

            <div class='menu'>
                <ul id="menu"><?php echo Storage::instance()->viewmenu ?></ul>

                <div class='search' style="display: none">
                    <form method='GET' action=''>
                        <input class='search' type='text' value='Search...' onfocus='this.value=""' onblur='if(this.value=="")
                            this.value="Search..."' name='' />
                        <input class='submit' type='submit' value='' />
                    </form>
                </div>
            </div>

            <div id="submenu"><?php echo Storage::instance()->viewsubmenu ?></div>

            <div class='after_menu'></div>

            <?php
            if (Storage::instance()->show_map)
                require_once 'map.php';
            ?>

            <div class='content group'>
                <?php echo Storage::instance()->content ?>
            </div>

            <?php require_once 'footer.php' ?>

        </div>

        <?php
        $scripts = array(
            'OpenLayers/OpenLayers.js',
            'jq.js',
            'chosen.jquery.min.js',
            'jquery.slideQuery.js',
                //'raphael.js',
                //'graphael.js',
                //'g.bar.js',
                //'g.pie.js',
                //'chart.js',
                ////'map.js',
                ////'main.js',
                ////'tinymce/jscripts/tiny_mce/tiny_mce.js',
                ////'tinymce/jscripts/tiny_mce/init.js',
                ////'menu.js',
                ////'jquery_ui_slide_effect.js',
                ////'bottom_toggles.js',
                ////'admin_edit.js'
        );
        Storage::instance()->show_map AND $scripts[] = 'map.js';
        $scripts[] = 'main.js';
        $scripts[] = 'menu.js';
        if (userloggedin())
        {
            $scripts[] = 'tinymce/jscripts/tiny_mce/tiny_mce.js';
            $scripts[] = 'tinymce/jscripts/tiny_mce/init.js';
            $scripts[] = 'admin_edit.js';
        }
        $scripts[] = 'jquery_ui_slide_effect.js';
        $scripts[] = 'bottom_toggles.js';
        foreach ($scripts AS $script)
            echo '<script type="text/javascript" src="' . URL . 'js/' . $script . '"></script>' . PHP_EOL;
        ?>

    </body>
</html>
