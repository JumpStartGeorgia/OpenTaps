  	<form action='<?php echo href("admin/tags/create", TRUE); ?>' method='post'>
    	   Language: &nbsp;
	   <select style="width: 70px;" name="record_language">
	   <?php foreach (config('languages') AS $lang): $s = 'selected="selected"';?>
	   	<option <?php LANG == $lang AND print $s; ?> value="<?php echo $lang; ?>"><?php echo $lang; ?></option>
	   <?php endforeach; ?>
	   </select><br /><br />


  	    <label for='tname'>Name: </label>
  	    <br />
  	    <input name='t_name' id='tname' type='text' />
  	    <br /><br />
  	    <input type='submit' style='width:90px;' value='Submit' />
  	</form>

        <br /><br />
  	<a href="<?php echo href("admin/tags", TRUE); ?>">Back</a>
