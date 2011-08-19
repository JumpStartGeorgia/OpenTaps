  	<form method='post' enctype="multipart/form-data" action='<?php echo href("admin/news/create"); ?>'>
  	    <label for='ntitle'>Title: </label>
  	    <br />
  	    <input name='n_title' id='ntitle' type='text' />
  	    <br /><br />

  	    <label for='nfile'>Picture : </label>
  	    <br/>
  	    <input name='n_file' type='file' id='nfile' />
  	    <br /><br />

  	    <label for='nbody'>Body: </label>
  	    <br />
  	    <textarea name='n_body' id='nbody' cols='70' rows='5'></textarea>
  	    <br /><br />
  	    
  	    <label for='ptags'>Tags: (hold down Ctrl to select multiple)</label>
  	    <br />
  	    <select name='p_tags[]' id='ptags' multiple='multiple'>
  	      <?php
  	        foreach($all_tags as $tag)
  	        {
  	            ?>
  	            <option value="<?php echo $tag['id'] ?>" <?php ( echo in_array($tag['id'],$news_tags)  ) ? "selected = 'selected'" : NULL; ?>><?php echo $tag['name'] ?></option>
  	            <?php
  	        }
  	      ?>
  	    </select>
  	    <br /><br />

  	    <input type='submit' value='Submit' onclick='
  	    	return document.getElementById("ntitle").value != "" && document.getElementById("nbody").value != ""
  	    	' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/news"); ?>">Back</a>
