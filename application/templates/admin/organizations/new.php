  	<form method='post' enctype="multipart/form-data" action="<?php echo href('admin/organizations/create', TRUE); ?>">
    	   Language: &nbsp;
	   <select style="width: 70px;" name="record_language">
	   <?php foreach (config('languages') AS $lang): $s = 'selected="selected"';?>
	   	<option <?php LANG == $lang AND print $s; ?> value="<?php echo $lang; ?>"><?php echo $lang; ?></option>
	   <?php endforeach; ?>
	   </select><br /><br />

  	    <label style="cursor: pointer;">
		<input type="checkbox" name="hidden" /> Hidden
	    </label><br /><br />

  	    <label for='pname'>Name: </label>
  	    <br />
  	    <input name='p_name' id='pname' type='text' />
  	    <br /><br />

  	    <label>
		Type:
		<br />
		<select name='p_type' style="width: 150px;">
		    <option selected="selected" value="organization">Organization</option>
		    <option value="donor">Donor</option>
		</select>
	    </label>
  	    <br /><br />


  	    <label for='plogo'>Logo: </label>
  	    <br />
  	    <input name='p_logo' id='plogo' type='file' />
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

	    <label for='psector'>Sector: </label>
  	    <br />
  	    <input name='p_sector' id='psector' type='text' />
  	    <br /><br />

  	    <label for='ptags'>Tags: (enter by hand or select tags below)</label>
  	    <br /><br />
  	    <input type="text" id="tag_box" name="p_tag_names" style="width: 150px; border-right: 1px solid #ccc;" value="" />
  	    <span style='font-size:12px;'>separate by comma ",&nbsp"</span>
  	    <br /><br />
  	    <select name='p_tag_uniques[]' id='ptags' multiple='multiple'>
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


	    <h3>Organization Data</h3>
	    <div id="data_fields_container" style="padding-left: 55px;">
	    </div>
	    <a style="color: #4CBEFF; cursor: pointer; font-size: 13px;" id="add_data_field">+Add data</a><br /><br />



  	    <input type='submit' style='width:90px;' value='Submit' onclick='return document.getElementById("dname").value != "" ' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/organizations", TRUE); ?>">Back</a>
