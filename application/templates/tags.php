<div id='tag_content'>
    <div id='left_list'>
    	<div class='group headers'>
    	    <div class='headers_left'>TAGS</div>
    	    <div class='headers_right'>SORT BY ▾</div>
    	</div>

    	<div class='group' id='titletype'>
    	    <div id='titletype_left'>
    	    <?php $def = strtoupper($def); ?>
    	    	<a href='<?php echo href('tag/project/' . $tag_name) ?>'
    	    		class='choosedef<?php ($def == "PROJECTS") AND print("_selected") ?>'>PROJECTS
    	    	</a>
    	    	<a href='<?php echo href('tag/organization/' . $tag_name) ?>'
    	    		class='choosedef<?php ($def == "ORGANIZATIONS") AND print("_selected") ?>'>ORGANIZATIONS
    	    	</a>
    	    	<a href='<?php echo href('tag/news/' . $tag_name) ?>'
    	    		class='choosedef<?php ($def == "NEWS") AND print("_selected") ?>'>NEWS
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
	    	<div class='content_each_left' style='border-right: 7px solid <?php echo $color ?>'>
	    	    <div class='content_each_title'><?php echo (empty($result['name'])) ? $result['title'] : $result['name']; ?></div>
	    	    <div class='content_each_body'>
	    	    	<?php
	    	    	    $body = (empty($result['body'])) ? $result['description'] : $result['body'];
	    	    	    (strlen($body) > 200) AND $body = substr($body, 0, 200) . "...";
	    	    	    echo $body;
	    	    	?>
	    	    </div>
	    	</div>
    		<div class='content_each_right'>
    		    <div style='padding:4px;padding-top:25px;font-size:10px;text-align:center;'>
    		    	<?php
    		    	    empty($result['start_at']) OR print($result['start_at'] . "<br/>-<br/>" . $result['end_at']);
    		    	    empty($result['published_at']) OR print($result['published_at']);
    		    	    (!empty($result['district']) AND empty($result['start_at'])) AND print($result['district']);
    		    	?>
    		    </div>
    		</div>
    	    </div>
    	<?php endforeach; ?>
    	</div>

    	<div id='pages'>
    	    <a href='#' class='prevnext'><</a> 1 | 2 | 3 | 4 | 5 | 6 <a href='#' class='prevnext'>></a>
    	</div>
    </div>

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
</div>
