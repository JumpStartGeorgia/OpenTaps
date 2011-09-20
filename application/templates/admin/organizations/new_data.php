<?php
  $action = href("admin/project-data/" . $unique . "/create");
?>
    	<form action='<? echo $action; ?>' method='post'>
  	    <label for='pkey'>Key: </label>
  	    <br />
  	    <input name='project_key[]' id='pkey' type='text' />
  	    <br />

  	    <label for='pvalue'>Value: </label>
  	    <br />
  	    <textarea name='project_value[]' id='pvalue' cols='55' rows='5'></textarea>
  	    <br /><br />
  	    <input type='submit' style='width:90px;' value='Submit' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/projects/" . $unique) ?>">Back</a>
