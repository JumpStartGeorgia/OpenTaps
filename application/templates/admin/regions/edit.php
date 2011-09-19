<?php
  $action = href("admin/regions/" . $region['id'] . "/update");
?>
    	<form action='<? echo $action; ?>' method='post'>
  	     <label for='pname'>Name: </label>
  	    <br />
  	    <input name='p_name' id='pname' type='text' value="<?php echo $region['name']; ?>"/>
  	    <br /><br />

  	    <label for='preg_info'>Region Info: </label>
  	    <br />
  	    <textarea name='p_reg_info' id='preg_info' cols='30' rows='3'><?php echo $region['region_info']; ?></textarea>
  	    <br />

  	    <label for='preg_projects_info'>Region Projects info: </label>
  	    <br />
  	    <textarea name='p_reg_projects_info' id='preg_projects_info' cols='30' rows='3'><?php echo $region['projects_info']; ?></textarea>
  	    <br />


  	    <label for='pcity'>City: </label>
  	    <br />
  	    <input name='p_city' id='pcity' type='text' value="<?php echo $region['city']; ?>"/>
  	    <br /><br />

  	    <label for='ppopulation'>Population: </label>
  	    <br />
  	    <input name='p_population' id='ppopulation' type='text' value="<?php echo $region['population']; ?>"/>
  	    <br /><br />

  	    <label for='psquares'>Square Meters: </label>
  	    <br />
  	    <input name='p_squares' id='psquares' type='text' value="<?php echo $region['square_meters']; ?>" />
  	    <br /><br />

  	    <label for='psettlements'>Settlement: </label>
  	    <br />
  	    <input name='p_settlement' id='psettlement' type='text' value="<?php echo $region['settlement']; ?>" />
  	    <br /><br />

  	    <label for='pvillages'>Villages </label>
  	    <br />
  	    <input name='p_villages' id='pvillages' type='text' value="<?php echo $region['villages']; ?>"/>
  	    <br /><br />

  	    <label for='pdisrtricts'>Districts </label>
  	    <br />
  	    <input name='p_districts' id='pdistricts' type='text' value="<?php echo $region['districts']; ?>" />
  	    <br /><br />


  	   <!-- <label for='ptags'>Tags: (hold down Ctrl to select multiple)</label>
  	    <br />
  	    <select name='p_tags[]' id='ptags' multiple='multiple'>
  	      <?php
  	        foreach($all_tags as $tag)
  	        {
  	            ?>
  	            <option value="<?php echo $tag['id'] ?>"><?php echo $tag['name'] ?></option>
  	            <?php
  	        }
  	      ?>
  	    </select>-->

         <label for='pwatersupply'>Water Supply: </label>
  	    <br />
  	    <input name='p_watersupply' id='pwatersupply' value="<?php echo $water_supply[0]['text']; ?>" type='text' />
        <br /><br />

  	    <input type='submit' style='width:90px;' value='Submit' onclick='return document.getElementById("ptitle").value != ""' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/regions"); ?>">Back</a>
  	<br />
  	<a onclick='return confirm("Are you sure?");' href="<?php echo href("admin/regions/" . $region['id'] . "/delete"); ?>" >
  	    Delete this record
  	</a>
