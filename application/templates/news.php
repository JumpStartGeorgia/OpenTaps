  
  <div class='news'>
    <span><strong>NEWS</strong></span>
</div>
<div class='spacer'>
</div>

<div class='projects_organization'>
  <strong>PROJECTS ORGANIZATION</strong>
</div>



<div class='newsall_body'>
    <div style='float:left;padding-top:10px;padding-left:10px;font-size:8pt;color:#CCC;'>TITLE</div>
    <div style='float:right;padding-top:10px;padding-right:10px;font-size:8pt;color:#CCC;'>Type of News:</div>
    <hr  style="margin-top:40px;color:#CCC;" /><br />

<?php
	$from = (empty($from) ? 0 : $from);
  	$news_all = read_news(4,$from);
  	$count = count(read_news());
  	$i = 0;
  ?>
  	
  	<?php
  foreach($news_all as $news):
      $i++;
      $cl = ($i % 2 == 0) ? "_with_bg" : "";
     
      if($news['category'] == 'project'): 
  	 $color = 'rgb(11%,76%,100%);'; 
      elseif($news['category'] == 'media'): 
  	 $color = 'rgb(51%,87%,100%);';
      else:  
  	 $color = 'rgb(85%,96%,100%);';
      endif;
       ?>
     
      		<div style="cursor:pointer;width:100%;float:left;" class="news_each<?php echo $cl; ?>" onmouseover="news_over(this,'<?php echo $i; ?>')" onmouseout="news_out(this,'<?php echo $i; ?>')">
               		<div style="padding-left:20px;padding-bottom:20px;padding-top:20px;width:80%;float:left;border-right:3px solid <?php echo $color; ?>">
               			<p class="ptitle">
               				<?php echo $news['title']; ?>
               			</p>
               			<br />
               			<div class="news_text" id="news<?php echo $i; ?>">
 	           			<?php echo $news['body']; ?>
              		 	</div>
              		 </div>
              		 <div>	
              		
              			 <p class="pdate" id="p_news<?php echo $i; ?>"><?php echo substr($news['published_at'],0,10); ?></p>
              		 </div>
          	 </div>
        
      <?php
  endforeach;
  ?>
  <center>
  <?php if($from-4 >= 0):
  	$from_back = $from-4;?>
  <a href="<?php echo URL.'news/'.$from_back; ?>/"><img style="cursor:pointer;" width="15px" height="15px" src="<?php echo URL; ?>images/back_news.jpg"/></a>
  
  <?php
  endif;
  for($i=0,$len=  ($count%4 == 0 ?  intval($count/4) :  intval($count/4)+1)  ;$i<$len;$i++):
  	?>
  		<a href="<?php echo URL.'news/'.$i*4 ?>" style="color:#CCC;text-decoration:none;">
  	<?php
  	echo $i+1;
  	?>
  		</a>
  	<?php
  	if($i >= 0 && $i < $len-1):
  		echo '|';
  	endif;
  endfor;
  ?>
  
  <?php
  if($from+4 < $count):
  	$from_next = $from+4;
  ?>
  <a href="<?php echo URL.'news/'.$from_next; ?>/"><img style="padding-top:7px;cursor:pointer;" width="15px" height="15px" src="<?php echo URL; ?>images/next_news.jpg"/></a>
  <?php endif; ?>
  </center>
	

</div>

<div id="chart" class='chartall'>
</div>
