  	<form method='post' enctype="multipart/form-data" action='<?php echo href("admin/donors/create"); ?>'>
  	    <label for='dname'>Title: </label>
  	    <br />
  	    <input name='d_name' id='dname' type='text' />
  	    <br /><br />

  	    <label for='ddesc'>Body: </label>
  	    <br />
  	    <textarea name='d_desc' id='desc' cols='30' rows='3'></textarea>
  	    <br />

  	    <label for='dtags'>Tags: (hold down Ctrl to select multiple)</label>
  	    <br />
  	    <select name='d_tags[]' id='dtags' multiple='multiple'>
  	      <?php
  	        foreach($all_tags as $tag)
  	        {
  	            ?>
  	            <option value="<?php echo $tag['id'] ?>"><?php echo $tag['name'] ?></option>
  	            <?php
  	        }
  	      ?>
  	    </select>
  	    <br /><br />

  	    <input type='submit' value='Submit' onclick=' return document.getElementById("dname").value != "" ' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/donors"); ?>">Back</a>
