<?php
  $action = href("admin/users/" . $result['id'] . "/update", TRUE);
?>
    	<form action='<?php echo $action; ?>' method='post'>
  	    <label for='uname'>UserName: </label>
  	    <br />
  	    <input name='u_name' id='uname' type='text' value="<?php echo $result['username']; ?>" />
  	    <br /><br />
     	    <label for='upass'>New Password: </label>
  	    <br />
  	    <input name='u_pass' id='upass' type='text' />
  	    <br /><br />
  	    <input type='submit' style='width:90px;' value='Submit' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/users", TRUE); ?>">Back</a>
  	<br />
  	<a href="<?php echo href("admin/users/" . $result['id'] . "/delete", TRUE); ?>" onclick='return confirm("Are you sure?");'>
  	    Delete this record
  	</a>
