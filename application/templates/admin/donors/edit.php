<?php
  $action = href("admin/donors/" . $donors['id'] . "/update");
?>
    	<form action='<? echo $action; ?>' method='post'>
  	    <label for='dname'>Title: </label>
  	    <br />
  	    <input name='d_name' id='dname' type='text' value='<?php echo $donors['don_name']; ?>' />
  	    <br /><br />

  	    <label for='ddesc'>Body: </label>
  	    <br />
  	    <textarea name='d_desc' id='ddesc' cols='70' rows='5'><?php echo $donors['don_desc']; ?></textarea>
  	    <br />

  	    <label for='dtags'>Tags: (hold down Ctrl to select multiple)</label>
  	    <br />
  	    <select name='d_tags[]' id='dtags' multiple='multiple'>
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

  	    <input type='submit' value='Submit' onclick='
	  	    return document.getElementById("dname").value != ""
  	    ' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/donors"); ?>">Back</a>
  	<br />
  	<a onclick='return confirm("Are you sure?");' href="<?php echo href("admin/donors/" . $donors['id'] . "/delete"); ?>" >
  	    Delete this record
  	</a>
