<?php
  $action = href("admin/news/" . $news[0]['unique'] . "/update", TRUE);
  $img = view_image($news[0]['unique']);
?>
    	<form enctype='multipart/form-data' action='<?php echo $action; ?>' method='post'>
  	    <label for='ntitle'>Title: </label>
  	    <br />
  	    <input name='n_title' id='ntitle' type='text' value='<?php echo $news[0]['title']; ?>' />
  	    <br /><br />

  	    <label style="cursor: pointer;">
		<input name='n_show_in_slider' id='ntitle' type='checkbox' value="yes" <?php $news[0]['show_in_slider'] == '1' AND print 'checked="checked"'; ?> />
		Show in top slider
  	    </label>
  	    <br /><br />

  	    Picture: <br />
  	    <?php echo (!$img) ?  "No current picture <br/>" : "Current: <br /><image src='" . $img . "' width='100' /><br />"; ?>
  	    <label for='nfile' onclick='document.getElementById("nfile").style.display = "block";' class='newpiclabel'>
  	        New picture
  	    </label>
  	    <input name='n_file' type='file' id='nfile' style='display:none;' />
  	    <br /><br />

  	    <label for='nbody'>Body: </label>
  	    <br />
  	    <textarea name='n_body' id='nbody' cols='70' rows='5'><?php echo $news[0]['body']; ?></textarea>
  	    <br /><br />
         <label for='ncategory'>Category: </label>
         <br />

      <select name='n_category' id='ncategory'>
            <!--<option value="-1"></option>-->
            <?php
      foreach( config('news_types') as $type ):
                  ?>
      <option value="<?php echo $type; ?>" <?php echo $type == $news[0]['category'] ? 'selected=selected' : NULL; ?>><?php echo $type; ?></option>
                   <?php
         endforeach;
                    ?>
         </select>
         <br /><br />
         
         <label for='nplace'>Place: </label>
         <br />
         <select name='n_place' id='nplace'>
            <option value="-1"></option>
            <?php
         foreach( $places as $place ):
                  ?>
      <option value="<?php echo $place['unique']; ?>" <?php echo $place['unique'] == $news[0]['place_unique'] ? 'selected=selected' : NULL; ?>><?php echo $place['name']; ?></option>
                   <?php
         endforeach;
                    ?>
         </select>

        <br /><br />

  	    <label for='ptags'>Tags: (enter by hand or select tags below)</label>
  	    <br /><br />
  	    <input type="text" id="tag_box" name="p_tag_names" style="width: 150px; border-right: 1px solid #ccc;" value="" />
  	    <span style='font-size:12px;'>separate by comma ",&nbsp"</span>
  	    <br /><br />
  	    <select name='p_tag_uniques[]' id='ptags' multiple='multiple'>
  	      <?php
  	        foreach($all_tags as $tag)
  	        {
  	            ?>
  	            <option value="<?php echo $tag['unique'] ?>" <?php echo (in_array($tag['unique'],$news_tags)) ? "selected='selected'" : NULL;?>><?php echo $tag['name'] ?></option>
  	            <?php
  	        }
  	      ?>
  	    </select>
  	    <br /><br />


	    <h3>News Data</h3>
	    <div id="data_fields_container" style="padding-left: 55px;">
<?php	    foreach ($data as $idx => $d):
	    	$bg = ($idx & 1) ? 'url(' . href() . 'images/bg.jpg) repeat' : 'white'; ?>
			<div class='group' style='background: <?php echo $bg; ?>'>
			<label style='cursor: pointer'>
  	    			Title: <br />
  	    			<input name='data_key[]' value="<?php empty($d['key']) OR print $d['key'] ?>" type='text' />
  	    		</label><br /><br />
  	    		<label style='cursor: pointer'>
				Sort: <br />
				<input name='data_sort[]' value="<?php empty($d['sort']) OR print $d['sort']; ?>" type='text' style='width: 40px' />
  	    		</label>
  	    		<input type='hidden' class="data_unique_container" name='sidebar[]' value='<?php (!empty($d['sidebar']) AND $d['sidebar'] == 1) AND print "checked"; ?>' />
  	    		<label style='margin-left: 25px; cursor: pointer;' onmouseup="check_sidebar($(this))">
  	    			<input type='checkbox' <?php (!empty($d['sidebar']) AND $d['sidebar'] == 1) AND print 'checked="checked"'; ?> /> Sidebar
  	    		</label><br /><br />
			<label style='cursor: pointer'>
  	    			Text: <br />
  	    			<textarea class='mceEditor' name='data_value[]' cols='55' rows='5'><?php empty($d['value']) OR print $d['value'] ?></textarea>
	    		</label>
	    		<a style='color: red; cursor: pointer; font-size: 13px;' onclick='$(this).parent().slideUp(function(){ $(this).remove(); })'>
	    			- Remove data
	    		</a>
	    		<br /><hr style='margin-left: -27px' />
	    		</div>
<?php	    endforeach; ?>
	    </div>
	    <a style="color: #4CBEFF; cursor: pointer; font-size: 13px;" id="add_data_field">+Add data</a><br /><br />


  	    <input type='submit' value='Submit' onclick='return document.getElementById("ntitle").value != ""' />
  	    <br /><br />
  	    
  	</form>

  	<a href="<?php echo href("admin/news", TRUE); ?>">Back</a>
  	<br />
  	
  	<a onclick='return confirm("Are you sure?");' href="<?php echo href("admin/news/" . $news[0]['unique'] . "/delete", TRUE); ?>" >
  	    Delete this record
  	</a>
