<div class='projects_organization'>
<<<<<<< HEAD
  PROJECTS ORGANIZATION
</div>

<div class='spacer'>
</div>

=======
                PROJECTS ORGANIZATION
            </div>

            <div class='spacer'>
            </div>
>>>>>>> 9015394620aca5f81778a8764afedc7dce890948
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

<<<<<<< HEAD
<?php
  $news_all = read_news(4);
  $i = 0;
  foreach($news_all as $news)
  {
      $i++;
      $cl = ($i % 2 == 0) ? "_with_bg" : "";
       
      echo
          "<div class='news_each".$cl."' onmouseover='news_over(this,".$i.")' onmouseout='news_out(this,".$i.")'>
               <p class='ptitle'>" . $news['title'] . "</p>
               <p class='pdate' id='p_news".$i."'>". substr($news['published_at'],0,10) ."</p>
               <div class='news_text' id='news".$i."'>
 	           " . $news['body'] . "
               </div>
           </div>"
      ;
  }
?>

    <div class='more_news'><a href='<?php echo URL . "news"; ?>'>▸ MORE NEWS</a></div>
=======
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
>>>>>>> 9015394620aca5f81778a8764afedc7dce890948

</div>
