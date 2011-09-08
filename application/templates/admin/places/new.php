  	<form action='<?php echo href("admin/places/create"); ?>' method='post'>
  	    <label for='plname'>Name: </label>
  	    <br />
  	    <input name='pl_name' id='plname' type='text' />
  	    <br /><br />
         
         <label for='plregion'>Regions: </label>

         <select name="pl_region" id="plregion">
            <option></option>
         <?php foreach( $regions as $region ): ?>
         <option value="<?php echo $region['id']; ?>"><?php echo $region['name']; ?></option>
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
  	<a href="<?php echo href("admin/places"); ?>">Back</a>
