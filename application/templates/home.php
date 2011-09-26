
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

    for ($idx = 0; $idx < (count($news_all) >= 2 ? 2 : count($news_all) ); $idx++):
        ?>
           <div class="news_each_main">          	
           	<img src="<?php echo (substr($news_all[$idx]['image'], 0, 4) == "http") ? $news_all[$idx]['image'] : URL.$news_all[$idx]['image']; ?>"/>
 		<center><p><?php echo $news_all[$idx]['title']; ?></p></center>
           </div>
        <?php
    endfor;
	?>
	<div class="news_each_others">

  	<img src="<?php echo $news_all[2]['image']; ?>" id="menu_img" width="130px" height="130px" style="margin-top:15px;margin-left:15px;"/>
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
if( $idx  == 2 ):
        ?>
          	<div style="border-right:5px solid <?php echo $color; ?>;background-color:rgba(255,255,255,0.0);"
  			  onmouseover="news_menu_over('<?php echo URL.$news_all[$idx]['image'] ?>',this);"
              onclick="news_menu_click('<?php echo $news_all[$idx]['id']; ?>');">
                 <p style="padding-top:10px;padding-left:15px;">&#60;&nbsp;&nbsp; <font style="color:#000;"><?php echo $news_all[$idx]['title']; ?></font></p>
  			</div>
    <?php else: ?>
  			<div style="border-right:5px solid <?php echo $color; ?>;background-color:#FFF;"
  			  onmouseover="news_menu_over('<?php echo URL.$news_all[$idx]['image'] ?>',this);"
              onclick="news_menu_click('<?php echo $news_all[$idx]['id'];  ?>');">
                                                        <p style="padding-top:10px;padding-left:15px;">&#60;&nbsp;&nbsp;<font style="color:#A6A6A6;"> <?php echo $news_all[$idx]['title']; ?></font></p>
  			</div>
        <?php
                endif;
    endfor;
  	?>
  		</div>
  	</div>
  <?php
?>
    <div class='more_news'><a style="text-decoration:none;" href='<?php echo URL . "news"; ?>' ><font style="font-size:7pt;color:#A6A6A6;">▸ ALL NEWS</font></a></div>

</div>
