<!DOCTYPE html>
﻿<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php empty(Storage::instance()->title) OR print Storage::instance()->title . ' - ' ?>OpenTaps</title>
        <link type="text/css" rel="stylesheet" href="<?php echo URL ?>style.css" media="all" />
        <link rel="icon" href="<?php echo URL ?>images/favicon.ico?<?php echo time() ?>">
        <!--<link rel="stylesheet" type="text/css" href="<?php echo URL ?>scripts/akzhan-jwysiwyg/help/lib/blueprint/screen.css" media="screen, projection" />-->
        <link type="text/css" rel="stylesheet" href="<?php echo URL ?>scripts/akzhan-jwysiwyg/jquery.wysiwyg.css" />
        <script type="text/javascript">
            var baseurl = '<?php echo href() ?>',
            lang = '<?php echo LANG ?>';            
        </script>
        <?php if (LANG == 'ka'): ?><style type="text/css"> .menu ul li div { font-family: 'Babuka Mtavruli' } </style><?php endif; ?>
    </head>
    <body>

        <div class="main group">

            <div class="header" style="position: relative">

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

                <div class="header_right slidenews">
                    <?php foreach ($slide_news as $news): ?>
                        <div class="slide"><a href="<?php echo href('news/' . $news['unique'], TRUE) ?>">
                                <p><?php echo $news['title']; ?></p>
                                <?php echo char_limit(strip_tags($news['body'], 320),130) ?>
                            </a></div>
                    <?php endforeach; ?>
                </div>

            </div>

            <div class="after_header"></div>

            <div class="menu"><ul id="menu"><?php echo Storage::instance()->viewmenu ?></ul></div>

            <div id="submenu"><?php echo Storage::instance()->viewsubmenu ?></div>

            <div class="after_menu"></div>

            <?php Storage::instance()->show_map AND require_once 'map.php'; ?>

            <div id="content" class="group">
                <?php echo Storage::instance()->content ?>
            </div>

            <?php require_once 'footer.php' ?>

        </div>

        <?php
        $scripts = array(
            'jquery.js', //'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js',
            'ie6mustdie/ie6mustdie.js',
            'jquery.chosen.js',
            'jquery.slideQuery.js',
            'jquery.ui.effects.js',
            'jquery.easing.js'
        );
        if (isset(Storage::instance()->show_chart))
        {
            $scripts[] = 'charts/highcharts.js';
            $scripts[] = 'charts/modules/exporting.js';
            $scripts[] = 'charts/chart_config.js';
        }
        isset(Storage::instance()->show_chart['home']) AND $scripts[] = 'charts/chart_home.js';
        isset(Storage::instance()->show_chart['organization']) AND $scripts[] = 'charts/chart_org.js';
        isset(Storage::instance()->show_chart['project']) AND $scripts[] = 'charts/chart_project.js';
        $scripts[] = 'OpenLayers/OpenLayers.js';
        //if (Storage::instance()->show_map OR isset(Storage::instance()->show_project_map))
        //{
            //$scripts[] = 'http://maps.google.com/maps/api/js?v=3.5&amp;sensor=false';
            $scripts[] = 'map.js';
        //}
        if (LANG == 'ka')
        {
            $scripts[] = 'cufon.js';
            $scripts[] = 'babuka_mtavruli.js';
        }
        $scripts[] = 'common.js';
        //userloggedin() AND $scripts[] = 'tinymce/tiny_mce.js';
        if (userloggedin())
        {
            $scripts[] = 'akzhan-jwysiwyg/jquery.wysiwyg.js';
            $scripts[] = 'akzhan-jwysiwyg/controls/wysiwyg.link.js';
            $scripts[] = 'akzhan-jwysiwyg/controls/wysiwyg.table.js';
            $scripts[] = 'akzhan-jwysiwyg/controls/wysiwyg.image.js';
        }
        
        ?>
        	<script type="text/javascript">
				<?php 			
						browserIncompatible();
				?>
        	</script>
        <?php
        foreach ($scripts AS $script)
            echo '<script type="text/javascript" src="' . (substr($script, 0, 4) === 'http' ? $script : URL . 'scripts/' . $script) . '"></script>' . PHP_EOL;
        ?>

    </body>
</html>
