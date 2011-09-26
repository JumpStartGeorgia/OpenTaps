<?php
  $action = href("admin/project-data/" . $unique . "/create", TRUE);
?>
    	<form action='<? echo $action; ?>' method='post'>
  	    <label style="cursor: pointer">
  	    	Title: <br />
		<input name='project_key[]' type='text' />
  	    </label>
  	    <br /><br />

  	    <label style="cursor: pointer">
		Sort: <br />
		<input name="project_sort[]" type="text" style="width: 40px" />
  	    </label>
  	    <label style='margin-left: 25px; cursor: pointer;'><input type="checkbox" name="sidebar" value="checked" /> Sidebar</label>
  	    <br /><br />

  	    <label style="cursor: pointer">
  	    	Text: <br />
		<textarea name='project_value[]' cols='55' rows='5'></textarea>
	    </label>
	    <br />
  	    <input type='submit' style='width:90px;' value='Submit' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/projects", TRUE) ?>">Back</a>
