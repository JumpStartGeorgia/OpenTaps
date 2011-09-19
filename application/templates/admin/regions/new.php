  	<form method='post' enctype="multipart/form-data" action='<?php echo href("admin/regions/create"); ?>'>
  	    <label for='pname'>Name: </label>
  	    <br />
  	    <input name='p_name' id='pname' type='text' />
  	    <br /><br />

  	    <label for='preg_info'>Region Info: </label>
  	    <br />
  	    <textarea name='p_reg_info' id='preg_info' cols='30' rows='3'></textarea>
  	    <br />

  	    <label for='preg_projects_info'>Region Projects info: </label>
  	    <br />
  	    <textarea name='p_reg_projects_info' id='preg_projects_info' cols='30' rows='3'></textarea>
  	    <br />


  	    <label for='pcity'>City: </label>
  	    <br />
  	    <input name='p_city' id='pcity' type='text' />
  	    <br /><br />

  	    <label for='ppopulation'>Population: </label>
  	    <br />
  	    <input name='p_population' id='ppopulation' type='text' />
  	    <br /><br />

  	    <label for='psquares'>Square Meters: </label>
  	    <br />
  	    <input name='p_squares' id='psquares' type='text' />
  	    <br /><br />

  	    <label for='psettlements'>Settlement: </label>
  	    <br />
  	    <input name='p_settlement' id='psettlement' type='text' />
  	    <br /><br />

         <label for='pvillages'>Villages: </label>
  	    <br />
  	    <input name='p_villages' id='pvillages' type='text' />
  	    <br /><br />

         <label for='pdisrtricts'>Districts: </label>
  	    <br />
  	    <input name='p_districts' id='pdistricts' type='text' />
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
  	    <input name='p_watersupply' id='pwatersupply' type='text' />
        <br /><br />
         
  	    <input type='submit' style='width:90px;' value='Submit' onclick=' return document.getElementById("dname").value != "" ' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/regions"); ?>">Back</a>
