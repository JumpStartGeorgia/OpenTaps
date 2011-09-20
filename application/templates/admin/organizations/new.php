  	<form method='post' enctype="multipart/form-data" action='<?php echo href("admin/organizations/create"); ?>'>
  	    <label for='pname'>Name: </label>
  	    <br />
  	    <input name='p_name' id='pname' type='text' />
  	    <br /><br />

  	    <label for='porg_info'>Organization Info: </label>
  	    <br />
  	    <textarea name='p_org_info' id='porg_info' cols='30' rows='3'></textarea>
  	    <br />

  	    <label for='porg_projects_info'>Organization Projects info: </label>
  	    <br />
  	    <textarea name='p_org_projects_info' id='porg_projects_info' cols='30' rows='3'></textarea>
  	    <br />


  	    <label for='pcitytown'>City/Town: </label>
  	    <br />
  	    <input name='p_city_town' id='pcitytown' type='text' />
  	    <br /><br />

  	    <label for='pdistrict'>District: </label>
  	    <br />
  	    <input name='p_district' id='pdistrict' type='text' />
  	    <br /><br />

  	    <label for='pgrante'>Grante: </label>
  	    <br />
  	    <input name='p_grante' id='pgrante' type='text' />
  	    <br /><br />

  	    <!--<label for='pdonors'>Donors: </label>
  	    <br />
  	    <input name='p_donors' id='pdonors' type='text' />
  	    <br /><br />-->

	    <label for='psector'>Sector: </label>
  	    <br />
  	    <input name='p_sector' id='psector' type='text' />
  	    <br /><br />
  	    
  	    <label for='plogo'>Logo: </label>
  	    <br />
  	    <input name='p_logo' id='plogo' type='file' />
  	    <br /><br />
  	    

  	    <label for='ptags'>Tags: (hold down Ctrl to select multiple)</label>
  	    <br />
  	    <select name='p_tags[]' id='ptags' multiple='multiple'>
  	      <?php
  	        foreach($all_tags as $tag)
  	        {
  	            ?>
  	            <option value="<?php echo $tag['unique'] ?>"><?php echo $tag['name'] ?></option>
  	            <?php
  	        }
  	      ?>
  	    </select>
  	    <br /><br />

  	    <input type='submit' style='width:90px;' value='Submit' onclick='return document.getElementById("dname").value != "" ' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/organizations"); ?>">Back</a>
