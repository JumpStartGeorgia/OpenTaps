<?php
  foreach($news_all as $news)
  {
      $img = ( strlen($news['image']) > 0 ) ? "<img src=\"" . URL . $news['image'] . "\" width='100px' /> <br/>" : "";
      echo
          "<b>" . $news['title'] . "</b> <br />" .
          $img .
          $news['body'] . "<hr />
          <br /><br /><br />"
      ;
  }
/*?>
<div id='tag_content'>
    <div id='left_list'>
    	<div class='group headers'>
    	    <div class='headers_left'>NEWS</div>
    	    <div class='headers_right'>SORT BY ▾</div>
    	</div>

    	<div class='group' id='titletype'>
    	    <div id='titletype_left'>TITLE</div>
    	    <div id='titletype_right'>
    	    	<span style='color: #9b9b9b'>Type of News: </span>
    	    	<span class='newstypebg1'></span> Project 
    	    	<span class='newstypebg2'></span> Media
    	    	<span class='newstypebg3'></span> Pro Media
    	    </div>
    	</div>

    	<div id='internal_container' class='group'>
    	    <div class='content_each group'>
	    	<div class='content_each_left' style='border-right: 7px solid #d9f5ff'><!--83ddff 19c1ff-->
	    	    <div class='content_each_title'>Just an empty space</div>
	    	    <div class='content_each_body'>
	    	    	Just an empty space. With some color in it (probably not blue but any other color that will be in the logo).
	    	    	 However, important updates.
	    	    </div>
	    	</div>
    		<div class='content_each_right'>
    		    <div image></div>
    		    <div date></div>
    		</div>
    	    </div>
    	    <div class='content_each group with_bg'>
	    	<div class='content_each_left' style='border-right: 7px solid #83ddff'><!--d9f5ff 19c1ff-->
	    	    <div class='content_each_title'>Just an empty space</div>
	    	    <div class='content_each_body'>
	    	    	Just an empty space. With some color in it (probably not blue but any other color that will be in the logo).
	    	    	 However, important updates.
	    	    </div>
	    	</div>
    		<div class='content_each_right'>
    		    <div image></div>
    		    <div date></div>
    		</div>
    	    </div>
    	</div>

    	<div id='pages'>
    	    <a href='#' class='prevnext'><</a> 1 | 2 | 3 | 4 | 5 | 6 <a href='#' class='prevnext'>></a>
    	</div>
    </div>

    <div id='right_list'>
        <div class='right_box'>
    	    <div class='headers'>
    		<div class='right_box_title'>CHART</div>
    	    </div>

	    <div class='right_box_content'>
		Chart Data
	    </div>
	</div>
    </div>
</div>
<?php */ ?>

