<?php
  $action = href("admin/project-data/" . $project_unique . "/update", TRUE);
?>
    	<form action='<? echo $action; ?>' method='post'>
<?php

	foreach ($data as $idx => $d)
	{
	    $bg = ($idx & 1) ? 'url(' . href() . 'images/bg.jpg) repeat' : 'white';
?>
<div class="group" style="width: 695px; margin: 10px 0; padding: 1.5em .75em; background: <?php echo $bg ?>">
  	    <label style="cursor: pointer">
  	    	Title: <br />
		<input name='project_key[]' type='text' value="<?php echo $d['key'] ?>" />
  	    </label>
  	    <br /><br />

  	    <label style="cursor: pointer">
		Sort: <br />
		<input name="project_sort[]" type="text" value="<?php echo $d['sort'] ?>" style="width: 40px" />
  	    </label>
  	    <br /><br />

  	    <label style="cursor: pointer">
  	    	Text: <br />
		<textarea name='project_value[]' cols='55' rows='5'><?php echo $d['value'] ?></textarea>
	    </label>
</div>
<?php
	}
?>
  	    <input type='submit' style='width:90px;' value='Submit' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/projects", TRUE); ?>">Back</a>
