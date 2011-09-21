<?php
  $action = href("admin/project-data/" . $project_unique . "/update", TRUE);
?>
	<h4>Leave key and value empty for the data you wish to delete</h4>
	<br />

    	<form action='<? echo $action; ?>' method='post'>
<?php
	foreach ( $data as $d )
	{
?>
  	    <label for='pk<?php echo $d['unique'] ?>'>Key: </label>
  	    <br />
  	    <input name='project_key[]' id='p<?php echo $d['unique'] ?>' type='text' value="<?php echo $d['key'] ?>" />
  	    <br />

  	    <label for='pv<?php echo $d['unique'] ?>'>Value: </label>
  	    <br />
  	    <textarea name='project_value[]' id='pv<?php echo $d['unique'] ?>' cols='55' rows='5'><?php echo $d['value'] ?></textarea>
  	    <br /><br />
<?php
	}
?>
  	    <input type='submit' style='width:90px;' value='Submit' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/projects", TRUE); ?>">Back</a>
