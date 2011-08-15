<?php
  $action = href("admin/project-data/" . $data[0]['project_id'] . "/update");
?>
	<h4>Leave key and value empty for the data you wish to delete</h4>
	<br />

    	<form action='<? echo $action; ?>' method='post'>
<?php
	foreach ( $data as $d )
	{
?>
  	    <label for='pk<?php echo $d['id'] ?>'>Key: </label>
  	    <br />
  	    <input name='project_key[]' id='p<?php echo $d['id'] ?>' type='text' value="<?php echo $d['key'] ?>" />
  	    <br />

  	    <label for='pv<?php echo $d['id'] ?>'>Value: </label>
  	    <br />
  	    <textarea name='project_value[]' id='pv<?php echo $d['id'] ?>' cols='55' rows='5'><?php echo $d['value'] ?></textarea>
  	    <br /><br />
<?php
	}
?>
  	    <input type='submit' style='width:90px;' value='Submit' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/projects/" . $data[0]['project_id']); ?>">Back</a>
