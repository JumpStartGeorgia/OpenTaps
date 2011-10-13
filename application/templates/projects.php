<?php
	$direction = strtoupper($direction);
	$this_order = empty($this_order) ? NULL : $this_order;
	$this_order_href = 'order/' . $this_order . '-' . $direction . '/';
?>
<a name="projects"></a>

<div id='tag_content'>
    <div id='left_list'>
    	<div class='group headers'>
    	    <div class='headers_left'>PROJECTS</div>
    	    <div class='headers_right' style="padding-top: 5px; padding-right: 5px;">
    	        filter by
	        <?php $location = href('projects', TRUE, 'projects'); ?>
		<select style="width: 170px;" onchange="window.location.href = '<?php echo $location; ?>';">
<?php		foreach ($types AS $type)
		{
		    $value = strtolower(str_replace(" ", "_", $type));
		    echo '<option value="' . $value . '">' . $type . '</option>';
		}
?>
		</select>
    	    </div>
    	</div>

    	<div class='group' id='newstype_filter' style='width: 100%; border-bottom: 1px solid #eee;'>
    	    <div class='titletype_left' style='font-size: 9px; padding-left: 11px;'>
		    <span style="font-size: 11px; margin-right: 7px;">sort by</span>
	    <?php
		$orders = array('region', 'district', 'years', 'categories', 'a-z');
		foreach ($orders as $order):
	    ?>
		    <a href='<?php echo href('projects/order/' . $order . '-ASC', TRUE, "projects") ?>'
    	    		class='choosedef<?php ($order == $this_order) AND print("_selected") ?>'>
			<?php echo strtoupper($order); ?>
		    </a>
	    <?php endforeach; ?>
    	    </div>

    	    <div class='titletype_center'></div>

    	    <div class='titletype_right'>
		<a class="choosedef<?php ($direction == 'ASC') AND print('_selected') ?>" style="color: #0cb5f5;" title="from first to last" href="<?php echo href('projects/order/' . $this_order . '-ASC', TRUE, 'projects'); ?>">▼</a>
		<a class="choosedef<?php ($direction == 'DESC') AND print('_selected') ?>" style="color: #0cb5f5;" title="from last to first" href="<?php echo href('projects/order/' . $this_order . '-DESC', TRUE, 'projects'); ?>">▲</a>
    	    </div>
    	</div>

    	<div id='internal_container' class='group'>
	<?php foreach ($projects as $index => $project): ?>
    	    <div class='content_each group <?php ($index % 2 == 1) AND print("with_bg"); ?>'>
    	      <a href="<?php echo href('project/' . $project['unique'], TRUE) ?>">
	    	<div class='content_each_left'>
	    	    <div class='content_each_title'><?php echo $project['title'] ?></div>
	    	    <div class='content_each_body'>
	    	    	<?php echo word_limiter(strip_tags($project['description']), 170); ?>
	    	    </div>
	    	</div>
	    	<?php $rgba = 1 - ($index % 3) / 2.5; ?>
    		<div class='content_each_right' style='border-left: 7px solid rgba(12, 181, 245, <?php echo $rgba; ?>)'>
    		    <div style='padding: 20px 4px;font-size: 10px; text-align: center;'>
    		    	<a id="region_link" href="<?php echo href('region/' . $project['region_unique'], TRUE); ?>">
    		    		<?php echo $project['region_name'] ?>
    		    	</a><br />
    		    	<?php echo $project['type'] ?><br />
    		    	<?php echo substr($project['start_at'], 0, 10) ?>
    		    </div>
    		</div>
    	    </div>
    	<?php endforeach; ?>
    	  </a>
    	</div>

<?php if ($total_pages > 1): ?>
    	<div id='pages'>
    	    <?php if ($current_page > 1):
    	        $pagelink = empty($this_order) ? 'page/' . ($current_page - 1) : ($current_page - 1); ?>
    	    	<a href="<?php echo href('projects/' . $this_order_href . $pagelink, TRUE) ?>" class='prevnext'><</a>
    	    <?php endif; ?>
    	    <?php
    	    for ($page = 1; $page <= $total_pages; $page ++):
    	      $pagelink = empty($this_order) ? 'page/' . $page : $page;
    	      if ($page != $current_page): ?>
    	    	<a href='<?php echo href("projects/" . $this_order_href . $pagelink, TRUE) ?>'>
    	    		<?php echo $page; ($total_pages == $page) OR print(" |"); ?>
    	    	</a>
    	    <?php
    	      else:
		echo $page; ($total_pages == $page) OR print(" |");
    	      endif;
    	    endfor;
    	    if ($current_page < $total_pages):
    	        $pagelink = empty($this_order) ? 'page/' . ($current_page + 1) : ($current_page + 1); ?>
    	    	<a href='<?php echo href("projects/" . $this_order_href . $pagelink, TRUE) ?>' class='prevnext'>></a>
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
					"<a href='" . href('tag/projects/' . $tag['name'], TRUE) . "'>" .
						$tag['name'] . " (" . $tag['total_tags'] . ")" .
					"</a><br />"
				;
			endforeach;
		?>
	    </div>
	</div>
    </div>
</div>
