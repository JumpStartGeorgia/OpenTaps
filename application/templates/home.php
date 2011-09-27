<div class="group">
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
    $start = 2;
    for ($idx = $start, $num = count($news_all); $idx < $num; $idx++):
    		 if($news_all[$idx]['category'] == 'project'): 
  			 	$color = 'rgb(11%,76%,100%);'; 
  			 elseif($news_all[$idx]['category'] == 'media'): 
  			 	$color = 'rgb(51%,87%,100%);';
  			 else:  
  			 	$color = 'rgb(85%,96%,100%);';
  			 endif;
?>
  		<div style="border-right:5px solid <?php echo $color . ';'; ($idx == $start) AND print 'background-color:#FFF; color: #A6A6A6; border-top: 0px;'; ?>" onmouseover="news_menu_over('<?php echo (substr($news_all[$idx]['image'], 0, 4) == "http") ? $news_all[$idx]['image'] : URL . $news_all[$idx]['image']; ?>',this);" onclick="news_menu_click('<?php echo $news_all[$idx]['unique'];  ?>');">
                        &#60;&nbsp;&nbsp;<?php echo $news_all[$idx]['title']; ?>
  		</div>
<?php
    endfor;
?>
  	    </div>
  	</div>

    <div class='more_news'><a href='<?php echo href("news", TRUE); ?>'>▸ ALL NEWS</a></div>



</div>
</div>



<div style="margin-top: 27px; " class="group">
<div style="float: left; width: 293px; text-align: justify; font-size: 11px; color: #808080">
The OpenTaps project is made possible thanks to the generous support of information Program and the Think Tank Fund of Open Society Foundations and O'Sullivan Foundation.
</div>
<div style="float: left; margin-left: 85px; font-size: 14px; font-weight: bold; color: #00AFF2;">
	<a href="#">
		<img src="<?php echo href('images') . 'water-supply-24.gif' ?>" style="margin-top: 9px;" />
	</a>
	<h4 style="visibility: hidden;">WATER SUPPLY SCHEDULE</h4>
</div>
<div style="display: inline-block; margin-left: 56px; height: 57px; padding-left: 56px; font-size: 14px; font-weight: bold; color: #00AFF2; border-left: 1px dotted #a6a6a6;">
	<a href="#">
		<img src="<?php echo href('images') . 'water-diseases.gif' ?>" style="margin-top: 9px;" />
	</a>
	<h4 style="visibility: hidden;">WATER AND DISEASES</h4>
<div>
</div>
