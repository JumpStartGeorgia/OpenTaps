  	<form action="<?php echo href('admin/places/create', TRUE); ?>" method='post'>
    	   Language: &nbsp;
	   <select style="width: 70px;" name="record_language">
	   <?php foreach (config('languages') AS $lang): $s = 'selected="selected"';?>
	   	<option <?php LANG == $lang AND print $s; ?> value="<?php echo $lang; ?>"><?php echo $lang; ?></option>
	   <?php endforeach; ?>
	   </select><br /><br />


  	    <label for='plname'>Name: </label>
  	    <br />
  	    <input name='pl_name' id='plname' type='text' />
  	    <br /><br />
         
         <label for='plregion'>Regions: </label>

         <select name="pl_region" id="plregion">
            <option></option>
         <?php foreach ($regions as $region): ?>
         <option value="<?php echo $region['unique']; ?>"><?php echo $region['name']; ?></option>
         <?php endforeach; ?>
         </select>
        <br /><br />
         <label for='pllongitude'>Longitude: </label>
  	    <br />
  	    <input name='pl_longitude' id='pllongitude' type='text' />
  	    <br /><br />

         
         <label for='pllatitude'>Latitude: </label>
  	    <br />
  	    <input name='pl_latitude' id='pllatitude' type='text' />


         
         <br /><br />
  	    <input type='submit' style='width:90px;' value='Submit' />
  	</form>

        <br />
  	<a href="<?php echo href("admin/places", TRUE); ?>">Back</a>
