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
                    <p> Just an empty</p>
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
            <div class='projects_organization'>
                PROJECTS ORGANIZATION
            </div>

            <div class='spacer'>
            </div>

            <div class='news'>
                <img src='<?php echo URL ?>images/news.jpg' />
                <span>NEWS</span>
            </div>


            <div id="chart" class='chart'>
              <!--<center>
               <img src='images/chart.jpg' />
              </center>-->
            </div>

            <div class='news_body'>
                <div style='float:left;'>&nbsp;&nbsp;TITLE</div>
                <div style='float:right;'>DATE&nbsp;&nbsp;</div>
                <hr /><br />

                <div class='news_each' onmouseover='news_over(this,0)' onmouseout='news_out(this,0)'>
                    <p class='ptitle'>Just an empty</p>
                    <p class='pdate' id='p_news0'>20.05.2011</p>
                    <div class='news_text' id='news0'>
	    Just an empty space. With some color in it (probably not blue but any other color that will be in the logo).
	    However, important updates.
                    </div>
                </div>
                <div class='news_each_with_bg' onmouseover='news_over(this,1)' onmouseout='news_out(this,1)'>
                    <p class='ptitle'>Just an empty</p>
                    <p class='pdate' id='p_news1'>20.05.2011</p>
                    <div class='news_text' id='news1'>
	    Just an empty space. With some color in it (probably not blue but any other color that will be in the logo).
	    However, important updates.
                    </div>
                </div>
                <div class='news_each' onmouseover='news_over(this,2)' onmouseout='news_out(this,2)'>
                    <p class='ptitle'>Just an empty</p>
                    <p class='pdate' id='p_news2'>20.05.2011</p>
                    <div class='news_text' id='news2'>
	    Just an empty space. With some color in it (probably not blue but any other color that will be in the logo).
	    However, important updates.
                    </div>
                </div>
                <div class='news_each_with_bg' onmouseover='news_over(this,3)' onmouseout='news_out(this,3)'>
                    <p class='ptitle'>Just an empty</p>
                    <p class='pdate' id='p_news3'>20.05.2011</p>
                    <div class='news_text' id='news3'>
	    Just an empty space. With some color in it (probably not blue but any other color that will be in the logo).
	    However, important updates.
                    </div>
                </div>

                <div class='more_news'>▸ MORE NEWS</div>

            </div>

            <hr class='bottom' />

            <div class='bottom'>
                © 2011 OPEN TAPS. &nbsp;&nbsp; Designed and developed by <a href='http://jumpstart.ge/'>Jumpstart Georgia</a>
            </div>
            <div class='bottom1'>Donate | About Us | Report</div>
            <div class='bottom2'>GEORGIAN WATER PROJECT </div>
            <div class='bottom3'><img src='<?php echo URL ?>images/connect_fb.jpg' /> &nbsp;CONNECT HERE&nbsp; <img src='<?php echo URL ?>images/connect.jpg' /></div>

        </div>

        <script type="text/javascript" src="http://openlayers.org/api/OpenLayers.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/raphael.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/graphael.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/g.pie.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/map.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/chart.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/main.js"></script>

    </body>
</html>