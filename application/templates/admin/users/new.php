  	<form action='<?php echo href("admin/users/create"); ?>' method='post'>
       <label for='uname'>UserName: </label>
  	    <br />
  	    <input name='u_name' id='uname' type='text' />
  	    <br /><br />
        <label for='upass'>Passsword: </label>
  	    <br />
  	    <input name='u_pass' id='upass' type='text' />
  	    <br /><br />
  	    <input type='submit' style='width:90px;' value='Submit' />
  	</form>

        <br /><br />
  	<a href="<?php echo href("admin/tags"); ?>">Back</a>
