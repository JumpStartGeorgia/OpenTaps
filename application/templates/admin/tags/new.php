  	<form action='<?php echo href("admin/tags/create", TRUE); ?>' method='post'>
  	    <label for='tname'>Name: </label>
  	    <br />
  	    <input name='t_name' id='tname' type='text' />
  	    <br /><br />
  	    <input type='submit' style='width:90px;' value='Submit' />
  	</form>

        <br /><br />
  	<a href="<?php echo href("admin/tags", TRUE); ?>">Back</a>
