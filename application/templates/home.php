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

</div>
