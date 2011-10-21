<?php $link_to_item = strtolower($def); $def == 'news' OR $link_to_item = substr($link_to_item, 0, -1); ?>

<div id='tag_content'>
    <div id='left_list' style="width: 100%;">
    	<div class='group headers'>
    	    <div class='headers_left'>TAGS</div>
    	    <div class='headers_right'><!--SORT BY ▾--></div>
    	</div>

    	<div class='group' id='titletype'>
    	    <div id='titletype_left' style='padding: 10px; padding-left: 17px;'>
    	    <?php $def = strtoupper($def); ?>
    	    	<a href='<?php echo href('tag/project/' . $tag_name, TRUE, 'tags') ?>'
    	    		class='choosedef<?php ($def == "PROJECTS") AND print("_selected") ?>'><?php echo strtoupper(l('tags_projects')) ?>
    	    	</a>
    	    	<a href='<?php echo href('tag/organization/' . $tag_name, TRUE, 'tags') ?>'
    	    		class='choosedef<?php ($def == "ORGANIZATIONS") AND print("_selected") ?>'><?php strtoupper(l('tags_organizations')) ?>
    	    	</a>
    	    	<a href='<?php echo href('tag/news/' . $tag_name, TRUE, 'tags') ?>'
    	    		class='choosedef<?php ($def == "NEWS") AND print("_selected") ?>'><?php echo strtoupper(l('tags_news')) ?>
    	    	</a>
    	    </div>
    	</div>

    	<div id='internal_container' class='group'>
	<?php foreach( $results as $index => $result ): ?>
    	    <div class='content_each group <?php ($index % 2 == 0) AND print("with_bg"); ?>'>
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
		<a name="tags"></a>

	    	<div class='content_each_left' style='width: 800px; min-height: 52px; border-right: 7px solid <?php echo $color ?>'>
	    	    <a href="<?php echo href($link_to_item . '/' . $result['unique'], TRUE) ?>" style="">
		    	    <div class='content_each_title'>
		    	    	<?php echo (empty($result['name'])) ? $result['title'] : $result['name']; ?>
		    	    </div>
		    	    <div class='content_each_body'>
		    	    	<?php
		    	    	    $body = (empty($result['body'])) ? $result['description'] : $result['body'];
		    	    	    (strlen($body) > 200) AND $body = substr($body, 0, 200) . "...";
		    	    	    echo $body;
		    	    	?>
		    	    </div>
	    	    </a>
	    	</div>
    		<div class='content_each_right'>
    		    <div style="padding: 4px; padding-top: 25px; font-size: 10px; text-align: center;">
    		    	<?php
    		    	    empty($result['start_at']) OR print($result['start_at'] . "<br/>-<br/>" . $result['end_at']);
    		    	    empty($result['published_at']) OR print($result['published_at']);
    		    	    (!empty($result['district']) AND empty($result['start_at'])) AND print($result['district']);
    		    	?>
    		    </div>
    		</div>
    	    </div>
    	<?php endforeach;?>
    	</div>

<?php if ($total_pages > 1): ?>
    	<div id='pages'>
    	    <?php if ($current_page > 1): ?>
    	    	<a href="<?php echo href('tag/' . $link_to_item . '/' . $tag_name . '/' . ($current_page - 1), TRUE, 'tags') ?>" class='prevnext'><</a>
    	    <?php endif; ?>
    	    <?php
    	    for ($page = 1; $page <= $total_pages; $page ++):
    	      if ($page != $current_page): ?>
    	    	<a href='<?php echo href("tag/" . $link_to_item . "/" . $tag_name . "/" . $page, TRUE, 'tags') ?>'>
    	    		<?php echo $page; ($total_pages == $page) OR print(" |"); ?>
    	    	</a>
    	    <?php
    	      else:
		echo $page; ($total_pages == $page) OR print(" |");
    	      endif;
    	    endfor;
    	    if ($current_page < $total_pages): ?>
    	    	<a href="<?php echo href('tag/' . $link_to_item . '/' . $tag_name . '/' . ($current_page + 1), TRUE, 'tags') ?>" class='prevnext'>></a>
    	    <?php endif; ?>
    	</div>
<?php endif; ?>

    </div>

    <?php /*
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
    */ ?>

</div>
