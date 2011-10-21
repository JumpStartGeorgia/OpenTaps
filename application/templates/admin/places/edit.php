
  	<form action='<?php echo href("admin/places/" . $place[0]['unique'] . "/update", TRUE); ?>' method='post'>
  	    <label for='plname'>Name: </label>
  	    <br />
  	    <input name='pl_name' id='plname' value="<?php echo $place[0]['name']; ?>" type='text' />
  	    <br /><br />
         
         <label for='plregion'>Regions: </label>

         <select name="pl_region" id="plregion">
            <option></option>
         <?php foreach ($regions as $region): ?>
         <?php $selected = (!empty($region_this) and $region_this[0]['unique'] == $region['unique']) ? " selected='selected'"  : NULL;?>
         <option value="<?php echo $region['unique']; ?>"<?php echo $selected; ?> ><?php echo $region['name']; ?></option>
         <?php endforeach; ?>
         </select>
         <br /><br />
         <select name="pl_district" id="pldistrict">
            <option></option>
         <?php foreach ($districts as $district): ?>
			<option <?php echo  ( $place[0]['district_id'] == $district['id'] )  ?  'selected=selected' : NULL; ?> value="<?php echo $district['id']; ?>"><?php echo $district['name']; ?></option>
         <?php endforeach; ?>
         </select>
        <br /><br />
         <label for='pllongitude'>Longitude: </label>
  	    <br />
  	    <input name='pl_longitude' id='pllongitude' value="<?php echo $place[0]['longitude']; ?>" type='text' />
  	    <br /><br />


         <label for='pllatitude'>Latitude: </label>
  	    <br />
  	    <input name='pl_latitude' id='pllatitude'  value="<?php echo $place[0]['latitude']; ?>" type='text' />



         <br /><br />
  	    <input type='submit' style='width:90px;' value='Submit' />
  	</form>

        <br />
  	<a href="<?php echo href("admin/places", TRUE); ?>">Back</a>
