<?php
	$images = array(
		'photo' => 'images/newstype_photo.gif',
		'document' => 'images/newstype_doc.gif',
		'barchart' => 'images/newstype_barchart.gif',
		'piechart' => 'images/newstype_piechart.gif',
		'chart' => 'images/newstype_piechart.gif',
		'text' => 'images/newstype_text.gif',
		'video' => 'images/newstype_video.gif'
	);

	$this_type_original = empty($this_type) ? NULL : $this_type;
	$this_type = empty($this_type) ? NULL : 'type/' . $this_type . '/';
?>
<a name="news"></a>

<div id='tag_content'>
    <div id='left_list'>
    	<div class='group headers'>
    	    <div class='headers_left'>NEWS</div>
    	    <?php /*<div class='headers_right' style='cursor: pointer;' onclick='$("#newstype_filter").slideToggle("fast");'>SORT BY ▾</div>
    	    */ ?>
    	</div>

    	<div class='group' id='newstype_filter' style='width: 100%; border-bottom: 1px solid #eee;'>
    	    <div class='titletype_left' style='padding-left: 11px; font-size:9px;'>
		    <a href='<?php echo href('news', TRUE, "news") ?>'
    	    		class='choosedef<?php empty($this_type_original) AND print("_selected") ?>'>ALL
		    </a>
	    <?php
		$types = config("news_types");
		foreach ($types as $type):
	    ?>
		    <a href='<?php echo href('news/type/' . $type, TRUE, "news") ?>'
    	    		class='choosedef<?php ($type == $this_type_original) AND print("_selected") ?>'>
			<?php echo strtoupper($type); ?>
		    </a>
	    <?php endforeach; ?>
    	    </div>

    	    <div class='titletype_right' style='margin-top:4px;'>
		<?php /*<span style='color: rgba(86, 86, 86, .6)'>Type of news: </span>
		<div class='newstypebg1'></div> Project
		<div class='newstypebg2'></div> Media
		<div class='newstypebg3'></div> Pro Media*/ ?>
    	    </div>
    	</div>

    	<div id='internal_container' class='group'>
	<?php foreach ($news_all as $index => $news): ?>
    	    <div class='content_each group <?php ($index % 2 == 1) AND print("with_bg"); ?>'>
    	      <a href="<?php echo href('news/' . $news['unique'], TRUE, "news") ?>">
<?php
	$rem = $index % 3;
	switch($rem):
		case 1:
		    $color = "#83ddff";
		    break;
		case 2:
		    $color = "#d9f5ff";
		    break;
		case 0:
		    $color = "#19c1ff";
		    break;
	endswitch;
?>
	    	<div class='content_each_left'>
	    	    <div class='content_each_title'><?php echo $news['title'] ?></div>
	    	    <div class='content_each_body'>
	    	    	<?php echo word_limiter(strip_tags($news['body']), 170); ?>
	    	    </div>
	    	</div>
    		<div class='content_each_right' style='border-left: 7px solid <?php echo $color ?>'>
    		    <div style='padding: 4px; padding-top: 25px; font-size: 10px; text-align: center;'>
    		    	<img src='<?php echo href() . $images[$news['category']] ?>' width='27px' />
    		    	<br />
    		    	<?php echo substr($news['published_at'], 0, 10) ?>
    		    </div>
    		</div>
    	    </div>
    	<?php endforeach; ?>
    	  </a>
    	</div>

<?php if ($total_pages > 1): ?>
    	<div id='pages'>
    	    <?php if ($current_page > 1):
    	        $pagelink = empty($this_type) ? 'page/' . ($current_page - 1) : ($current_page - 1); ?>
    	    	<a href='<?php echo href("news/" . $this_type . $pagelink, TRUE) ?>' class='prevnext'><</a>
    	    <?php endif; ?>
    	    <?php
    	    for ($page = 1; $page <= $total_pages; $page ++):
    	      $pagelink = empty($this_type) ? 'page/' . $page : $page;
    	      if ($page != $current_page): ?>
    	    	<a href='<?php echo href("news/" . $this_type . $pagelink, TRUE) ?>'>
    	    		<?php echo $page; ($total_pages == $page) OR print(" |"); ?>
    	    	</a>
    	    <?php
    	      else:
		echo $page; ($total_pages == $page) OR print(" |");
    	      endif;
    	    endfor;
    	    if ($current_page < $total_pages):
    	        $pagelink = empty($this_type) ? 'page/' . ($current_page + 1) : ($current_page + 1); ?>
    	    	<a href='<?php echo href("news/" . $this_type . $pagelink, TRUE) ?>' class='prevnext'>></a>
    	    <?php endif; ?>
    	</div>
<?php endif; ?>

    </div>

    <div id='right_list'>
        <div class='right_box'>
    	    <div class='headers'>
    		<div class='right_box_title'>TAG CLOUD</div>
    	    </div>

	    <div class='right_box_content' id='right_box_tags'>
		<?php
			foreach($tags as $tag):
				echo 
					"<a href='".href('tag/project/' . $tag['name'], TRUE)."'>" .
						$tag['name'] . " (" . $tag['total_tags'] . ")".
					"</a><br />"
				;
			endforeach;
		?>
	    </div>
	</div>
    </div>
</div>
