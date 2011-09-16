<?php
  $action = href("admin/news/" . $news[0]['id'] . "/update");
  $img = view_image($news[0]['id']);
?>
    	<form enctype='multipart/form-data' action='<? echo $action; ?>' method='post'>
  	    <label for='ntitle'>Title: </label>
  	    <br />
  	    <input name='n_title' id='ntitle' type='text' value='<?php echo $news[0]['title']; ?>' />
  	    <br /><br />

  	    Picture: <br />
  	<?php
  	    echo (!$img) ?  "No current picture <br/>" : "Current: <br /><image src='" . $img . "' width='100' /><br />";
  	?>
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
      <option value="<?php echo $place['id']; ?>" <?php echo $place['id'] == $news[0]['place_id'] ? 'selected=selected' : NULL; ?>><?php echo $place['name']; ?></option>
                   <?php
         endforeach;
                    ?>
         </select>

        <br /><br />
		<label for='ptags'>Tags: (hold down Ctrl to select multiple)</label>
  	    <br />
  	    <select name='p_tags[]' id='ptags' multiple='multiple'>
  	      <?php
  	        foreach($all_tags as $tag)
  	        {
  	            ?>
  	            <option value="<?php echo $tag['id'] ?>" <?php echo (in_array($tag['id'],$news_tags)) ? "selected='selected'" : NULL;?>><?php echo $tag['name'] ?></option>
  	            <?php
  	        }
  	      ?>
  	    </select>
  	    <br /><br />
  	    
  	    <input type='submit' value='Submit' onclick='return document.getElementById("ntitle").value != ""' />
  	    <br /><br />
  	    
  	</form>

  	<a href="<?php echo href("admin/news"); ?>">Back</a>
  	<br />
  	
  	<a onclick='return confirm("Are you sure?");' href="<?php echo href("admin/news/" . $news[0]['id'] . "/delete"); ?>" >
  	    Delete this record
  	</a>
