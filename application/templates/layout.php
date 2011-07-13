<html>
    <head>
        <title><?php echo Storage::instance()->title ?> - OpenTaps</title>
        <link href="<?php echo URL ?>main.css" rel="stylesheet" type="text/css" />
    </head>
    <body onload="init()">

        <div class='main'>

            <div class='header'>
                <img src='<?php echo URL ?>images/opentaps.jpg' />

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
                <ul>
                    <li onmouseover='menu_over(this)' onmouseout='menu_out(this)' style='padding-left:0;'>GEORGIA PROFILE ▾</li>
                    <li onmouseover='menu_over(this)' onmouseout='menu_out(this)'>WATER ISSUES</li>
                    <li onmouseover='menu_over(this)' onmouseout='menu_out(this)'>PROJECTS</li>
                    <li onmouseover='menu_over(this)' onmouseout='menu_out(this)'>ORGANIZATIONS ▾</li>
                    <li onmouseover='menu_over(this)' onmouseout='menu_out(this)'>STATISTICS</li>
                    <li onmouseover='menu_over(this)' onmouseout='menu_out(this)'>DATA</li>
                </ul>

                <div class='search'>
                    <form method='GET' action=''>
                        <input class='search' type='text' value='Search...' onfocus='this.value=""' onblur='if(this.value=="")
                            this.value="Search..."' name='' />
                        <input class='submit' type='submit' value='' />
                    </form>
                </div>
            </div>
		
            <div id="map" class="middle">
            </div>
            <br/><br/>
            

            <?php echo Storage::instance()->content ?>

            <hr class='bottom' />

            <div class='bottom'>
                © 2011 OPEN TAPS. &nbsp;&nbsp; Designed and developed by <a href='http://jumpstart.ge/'>Jumpstart Georgia</a>
            </div>
            <div class='bottom1'>Donate | About Us | Report</div>
            <div class='bottom2'>GEORGIAN WATER PROJECT </div>
            <div class='bottom3'><img src='<?php echo URL ?>images/connect_fb.jpg' /> &nbsp;CONNECT HERE&nbsp; <img src='<?php echo URL ?>images/connect.jpg' /></div>

        </div>

	<script type="text/javascript">
	    var places = [<?php echo implode(', ', empty(Storage::instance()->js_places) ? array() : Storage::instance()->js_places) ?>];
	</script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="http://openlayers.org/api/OpenLayers.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/raphael.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/graphael.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/g.pie.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/map.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/chart.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/main.js"></script>

    </body>
</html>
