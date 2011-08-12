<!DOCTYPE html>
﻿<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php echo Storage::instance()->title ?> - OpenTaps</title>
        <link href="<?php echo URL ?>main.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>adm.css" rel="stylesheet" type="text/css" />
        <meta charset="utf-8"/>
    </head>
    <body onload="init()">
        <div class='main'>

            <div class='header'>
                <a href = "<? echo URL ?>">
                  <img src='<?php echo URL ?>images/opentaps.jpg' />
		</a>
                <div class='header_right'>
                    <p>News title</p>
	  Just an empty space. With some color in it (probably not blue but any other color that will be in the logo).
	  However, important updates. Just an empty space. With some color in it (probably not blue but any other
	  color that will be in the logo). However, this "empty space" can be turned into space. (More...)
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

	    <?php if (Storage::instance()->show_map): ?>
                <div id="map"></div>
            <?php endif; ?>

	    <div class='content'>
              <?php echo Storage::instance()->content ?>
            </div>

            <br/><br/>
            
            <hr class='bottom' />

            <div class='bottom'>
                © 2011 OPEN TAPS. &nbsp;&nbsp; Designed and developed by <a href='http://jumpstart.ge/'>Jumpstart Georgia</a>
            </div>
            <div class='bottom1'>Donate | About Us | Report</div>
            <div class='bottom2'>GEORGIAN WATER PROJECT </div>
            <div class='bottom3'><img src='<?php echo URL ?>images/connect_fb.jpg' />
                &nbsp;CONNECT HERE&nbsp; <img src='<?php echo URL ?>images/connect.jpg' />
            </div>

        </div>

	<script type="text/javascript">
	    var places = [<?php echo implode(', ', empty(Storage::instance()->js_places) ? array() : Storage::instance()->js_places) ?>];
	    var places_id = [],k=24;
	    for(var i=0,len=places.length;i<len;i++){
	    	places_id.push("OL_Icon_"+k);
	    	k+=4;
	    }
	</script>
	<script type="text/javascript" src="<?php echo URL ?>js/OpenLayers/OpenLayers.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/jq.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/raphael.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/graphael.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/g.bar.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/g.pie.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/chart.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/map.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/main.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>js/menu.js"></script>
    </body>
</html>
