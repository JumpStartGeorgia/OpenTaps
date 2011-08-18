
<div class='projects_organization'>
  <strong>PROJECTS ORGANIZATION</strong>
</div>

<div class='news group'>
    <span><strong>NEWS</strong></span>
</div>


<div id="chart" class='chart'>
</div>


<div class='news_body group'>

<?php
  $news_all = read_news(6);
    for ($idx = 0; $idx < 2; $idx++):
        ?>
           <div class="news_each_main">          	
           	<img src="<?php echo (substr($news_all[$idx]['image'], 0, 4) == "http") ? $news_all[$idx]['image'] : URL.$news_all[$idx]['image']; ?>"/>
 		<center><p><?php echo $news_all[$idx]['title']; ?></p></center>
           </div>
        <?php
    endfor;
	?>
	<div class="news_each_others">
  	<img src="http://localhost.com/OpenTaps/uploads/593276screenshot_opentaps.png" id="menu_img" width="120px" height="130px"/>
  		<div class="news_each_menu">
	<?php
    for ($idx = 2, $num = count($news_all); $idx < $num; $idx++):
    			if($news_all[$idx]['category'] == 'project'): 
  			 	$color = 'rgb(11%,76%,100%);'; 
  			 elseif($news_all[$idx]['category'] == 'media'): 
  			 	$color = 'rgb(51%,87%,100%);';
  			 else:  
  			 	$color = 'rgb(85%,96%,100%);';
  			 endif; 
        ?>
        		
  			<div style="border-right:5px solid <?php echo $color; ?>"
  			  onmouseover="show_menu_img('<?php echo URL.$news_all[$idx]['image'] ?>',this);" onmouseout="show_menu_img(this)">
  				<p><&nbsp;&nbsp; <?php echo $news_all[$idx]['title']; ?></p>
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
