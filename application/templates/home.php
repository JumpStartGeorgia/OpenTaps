
<div class='projects_organization'>
  <strong>PROJECTS ORGANIZATION</strong>
</div>

<div class='spacer'>
</div>

<div class='news'>
    <span><strong>NEWS</strong></span>
</div>


<div id="chart" class='chart'>
</div>


<div class='news_body'>

<?php
  $news_all = read_news(7);
    for ($idx = 0; $idx < 2; $idx++):
        ?>
           <div class="news_each_main">          	
           	<img src="<?php echo URL.$news_all[$idx]['image']; ?>"/>
 		<center><p><?php echo $news_all[$idx]['title']; ?></p></center>
           </div>
        <?php
    endfor;
	?>
	<div class="news_each_others">
  	<div class="news_each_menu_image" id="menu_img"></div>
  		<div class="news_each_menu">
	<?php
    for ($idx = 2, $num = count($news_all); $idx < $num; $idx++):
        ?>
  			<div onmouseover="show_menu_img(<?php echo $news_all[$idx]['image'] ?>);">
  				<?php echo $news_all[$idx]['title']; ?>
  			</div>
        <?php
    endfor;
  	?>
  		</div>
  </div>
  <?php
?>
    <div class='more_news'><a href='<?php echo URL . "news"; ?>'>▸ ALL NEWS</a></div>

</div>


