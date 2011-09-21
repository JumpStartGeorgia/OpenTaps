<?php
  $action = href("/project-tags/" . $id . "/update", TRUE);
?>
    	<form action='<? echo $action; ?>' method='post'>
            <label for='ptags'>Tags: (hold down Ctrl to select multiple)</label>
  	    <br />
  	    <select name='p_tags[]' id='ptags' multiple='multiple'>
  	      <?php
  	        foreach($all_tags as $tag)
  	        {
  	            echo $selected = (in_array($tag['id'], $this_tags)) ? "selected='selected'" : NULL;
  	            ?>
  	            <option value="<?php echo $tag['id'] ?>"<?php echo $selected ?>><?php echo $tag['name'] ?></option>
  	            <?php
  	        }
  	      ?>
  	    </select>
  	    <br /><br />

  	    <input type='submit' value='Submit' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/projects", TRUE); ?>">Back</a>
