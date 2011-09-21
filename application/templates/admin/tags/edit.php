<?php
  $action = href("admin/tags/" . $result['unique'] . "/update", TRUE);
?>
    	<form action='<?php echo $action; ?>' method='post'>
  	    <label for='tname'>Name: </label>
  	    <br />
  	    <input name='t_name' id='tname' type='text' value="<?php echo $result['name']; ?>" />
  	    <br /><br />
  	    <input type='submit' style='width:90px;' value='Submit' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/tags", TRUE); ?>">Back</a>
  	<br />
  	<a href="<?php echo href("admin/tags/" . $result['unique'] . "/delete", TRUE); ?>" onclick='return confirm("Are you sure?");'>
  	    Delete this record
  	</a>
