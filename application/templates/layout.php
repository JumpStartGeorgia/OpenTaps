<!DOCTYPE html>
﻿<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php echo Storage::instance()->title ?> - OpenTaps</title>
        <?php /* <link href="<?php echo URL ?>main.css" rel="stylesheet" type="text/css" />*/ ?>
        <style type="text/css">
	<?php
		$file = fopen('main.css', 'r');
		$style = fread($file, filesize('main.css'));
		fclose($file);
		$variables = array(
			"@opentaps_default_color" => "#0cb5f5",
			"@opentaps_default_rgba" => "12, 181, 245",
			"@baseurl" => href(),
			"@opentaps_default_bordercolor" => "#A6A6A6"
		);
		echo str_replace(array_keys($variables), $variables, $style);
	?>
        </style>
        <link href="<?php echo URL ?>adm.css" rel="stylesheet" type="text/css" />
        <meta charset="utf-8"/>
    	<script type="text/javascript">
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
	</script>
    </head>
    <body onload="init()">
        <div class='main group'>

            <div class='header'>
                <a href = "<? echo href(NULL, TRUE) ?>">
                  <img src='<?php echo URL ?>images/open-taps-logo.gif' />
		</a>
                <div class='header_right slidenews'>
                <?php foreach ($slide_news as $news): ?>
                  <div class="slide"><a href="<?php echo href('news/' . $news['unique'], TRUE) ?>">
                    <p><?php echo $news['title']; ?></p>
                    <?php echo word_limiter(strip_tags($news['body']), 320); ?>
                    <div class="slider_date"><?php echo $news['published_at']; ?></div>
	  	  </a></div>
	  	<?php endforeach; ?>
                </div>
            </div>

            <div class='after_header'>
            </div>

            <div class='menu'>
                <ul id="menu"><?php echo Storage::instance()->viewmenu ?></ul>

                <div class='search'>
                    <form method='GET' action=''>
                        <input class='search' type='text' value='Search...' onfocus='this.value=""' onblur='if(this.value=="")
                            this.value="Search..."' name='' />
                        <input class='submit' type='submit' value='' />
                    </form>
                </div>
            </div>

	    <div id="submenu"><?php echo Storage::instance()->viewsubmenu ?></div>

	    <div class='after_menu'></div>

	    <?php if (Storage::instance()->show_map): 
                  require_once 'map.php';
              endif; ?>

	    <div class='content group'>
              <?php echo Storage::instance()->content ?>
            </div>


	    <div id="bot-container" class="group">
		<div id="about-us" class="group">
			<div id='about-us-main-title-container'>
				<div id='about-us-main-title'>ABOUT</div>
			</div>
			<div style='padding: 30px 22px 40px 16px;'>
				<div><?php echo $about_us['main']['text']; ?></div>
				<div class="about-us-inner-box" style="margin-left: 0px;">
					<div class="about-us-main-title-container">
						<div class='about-us-title'>OPEN INFORMATION</div>
					</div>
					<div class="inner-text-box"><?php echo $about_us['open_information']['text']; ?></div>
				</div>
				<div class="about-us-inner-box">
					<div class="about-us-main-title-container">
						<div class='about-us-title'>PARTICIPATION</div>
					</div>
					<div class="inner-text-box"><?php echo $about_us['participation']['text']; ?></div>
				</div>
				<div class="about-us-inner-box">
					<div class="about-us-main-title-container">
						<div class='about-us-title'>INNOVATION</div>
					</div>
					<div class="inner-text-box"><?php echo $about_us['innovation']['text']; ?></div>
				</div>
			</div>
		</div>
		<div id="contact-us" class="group">
			<iframe src ="http://mapspot.ge/embed/embedmap.php?lt=41.697067732318&lg=44.790275215241&z=16&m=1&mlg=44.796767813687&mlt=41.697999849411" width="929" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
			<div id='map_image' style='display: none; background: url(<?php echo href() ?>images/mapspot_address_on_map.png);'></div>
			<div id='contact-us-form-container' class='group'>
			    <div id='contact-us-circle'>
				<div style='margin-top: 40px'>CONTACT US</div>
				<div style='margin-top: 7px'>Address: 5 Shevchenko Str.,<br /> Suite 2, Tbilisi, Georgia</div>
				<div style='margin-top: 7px'>
				    <span style=''>Mail: </span>
				    <span style='color: #000'>info@opentaps.ge</span>
				</div>
				<div style='margin-top: 7px;'>Tel: +995 32 214 29 26</div>
				<div style='color: #000; margin-top: 27px;'>We'd love to hear from you</div>
				<div style='color: #000;'>Let's get started!</div>
			    </div>
			    <div id='contact-us-form'>
				<form action='' method=''>
				    <input type='text' name='' value='name:' class='contact-us-input'
					onfocus='contact_us_input_focus(this, "name:")'
					onblur='contact_us_input_blur(this, "name:")' />
				    <input type='text' name='' value='e-mail:*' class='contact-us-input'
					onfocus='contact_us_input_focus(this, "e-mail:*")'
					onblur='contact_us_input_blur(this, "e-mail:*")' />
				    <textarea id='contact-us-textarea' class='mceNoEditor'
				    	onfocus='contact_us_input_focus(this, "message:*")'
				    	onblur='contact_us_input_blur(this, "message:*")'>message:*</textarea>
				</form>
			    </div>
			</div>
		</div>
	    </div>

            <div class='bottom group'>
                <div class='bottom1'>
		    © 2011 OPEN TAPS. &nbsp; Designed and developed by
		    <a target="_blank" href='http://jumpstart.ge/'>Jumpstart Georgia</a>
		</div>
	        <div class="bottom2">
	            <span id="about_us_button">ABOUT US</span> &nbsp;&nbsp;|&nbsp;&nbsp;
	            <span id="contact_us_button">
	            	CONTACT US<span style='cursor: pointer'>
	            	</span><img width='10px' src='<?php echo href() ?>images/contact-line.gif' id='contact_us_toggle' />
	            </span>
	        </div>
	    </div>


        </div>

	<script type='text/javascript'>var baseurl = "<?php echo href(); ?>";</script>
	<script type="text/javascript" src="<?php echo URL ?>js/OpenLayers/OpenLayers.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/jq.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/jquery.slideQuery.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/raphael.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/graphael.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/g.bar.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/g.pie.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/chart.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/map.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/main.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/tinymce/jscripts/tiny_mce/init.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/menu.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/jquery_ui_slide_effect.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/bottom_toggles.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/admin_edit.js"></script>
    </body>
</html>
