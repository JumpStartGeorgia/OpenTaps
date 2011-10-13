<?php
  $action = href("admin/organizations/update/" . $organization['unique'], TRUE);
?>
    	<form action="<? echo $action; ?>" method='post' enctype="multipart/form-data" style="padding-top: 5px;">
  	   <label for='pname'>Name: </label>
  	    <br />
  	    <input name='p_name' id='pname' type='text' value="<?php echo $organization['name']; ?>" />
  	    <br /><br />

  	    <label>
		Type:
		<br />
		<select name='p_type' style="width: 150px;">
		    <?php $s = 'selected="selected"'; ?>
		    <option <?php $organization['type'] == "organization" AND print $s; ?> value="organization">Organization</option>
		    <option <?php $organization['type'] == "donor" AND print $s; ?> value="donor">Donor</option>
		</select>
	    </label>
  	    <br /><br />

  	    <label for='plogo'>Logo: </label>
  	    <?php if (!empty($organization['logo'])): ?>
  	    	<span>
  	    	<span>
  	    	    <br />
	  	    current logo :
	  	    <a target="_blank" href="<?php echo href() . $organization['logo'] ?>" class="region_link">here</a>
  	    	    &nbsp;<a onclick="$(this).parent().parent().find('input').val('yes'); $(this).parent().slideUp('normal', function(){ $(this).remove(); });" class="region_link" style="cursor: pointer; text-decoration: underline; color: black">remove</a>
  	    	</span>
  	    	<input type="hidden" name="delete_logo" value="no" />
  	    	</span>
  	    <?php endif; ?>
  	    <br />
  	    <input name='p_logo' id='plogo' type='file' />
  	    <br /><br />

  	    <label for='porg_info'>Organization Info: </label>
  	    <br />
  	    <textarea name='p_org_info' id='porg_info' cols='30' rows='3'><?php echo $organization['description']; ?></textarea>
  	    <br />

  	    <label for='porg_projects_info'>Organization Projects info: </label>
  	    <br />
  	    <textarea name='p_org_projects_info' id='porg_projects_info' cols='30' rows='3'><?php echo $organization['projects_info'] ?></textarea>
  	    <br />

 

  	    <label for='pcitytown'>City/Town: </label>
  	    <br />
  	    <input name='p_city_town' id='pcitytown' type='text' value="<?php echo $organization['city_town']; ?>"/>
  	    <br /><br />

  	    <label for='pdistrict'>District: </label>
  	    <br />
  	    <input name='p_district' id='pdistrict' type='text' value="<?php echo $organization['district']; ?>"/>
  	    <br /><br />

  	    <label for='pgrante'>Grante: </label>
  	    <br />
  	    <input name='p_grante' id='pgrante' type='text' value="<?php echo $organization['grante']; ?>" />
  	    <br /><br />

  	    <!--<label for='pdonors'>Donors: </label>
  	    <br />
  	    <input name='p_donors' id='pdonors' type='text' />
  	    <br /><br />-->

	    <label for='psector'>Sector: </label>
  	    <br />
  	    <input name='p_sector' id='psector' type='text' value="<?php echo $organization['sector']; ?>" />
  	    <br /><br />

  	    <label for='ptags'>Tags: (enter by hand or select tags below)</label>
  	    <br /><br />
  	    <input type="text" id="tag_box" name="p_tag_names" style="width: 150px; border-right: 1px solid #ccc;" value="" />
  	    <span style='font-size:12px;'>separate by comma ",&nbsp"</span>
  	    <br /><br />
  	    <label for='ptags'>Tags: (hold down Ctrl to select multiple)</label>
  	    <br />
  	    <select name='p_tag_uniques[]' id='ptags' multiple='multiple'>
  	      <?php
  	        foreach($all_tags as $tag)
  	        {
  	            ?>
  	            <option value="<?php echo $tag['unique'] ?>" <?php echo (in_array($tag['unique'], $org_tags)) ? "selected='selected'" : NULL;?>><?php echo $tag['name'] ?></option>
  	            <?php
  	        }
  	      ?>
  	    </select>
  	    <br /><br />



	    <h3>Organization Data</h3>
	    <div id="data_fields_container" style="padding-left: 55px;">
<?php	    foreach ($data as $idx => $d):
	    	$bg = ($idx & 1) ? 'url(' . href() . 'images/bg.jpg) repeat' : 'white'; ?>
			<div class='group' style='background: <?php echo $bg; ?>'>
			<label style='cursor: pointer'>
  	    			Title: <br />
  	    			<input name='data_key[]' value="<?php empty($d['key']) OR print $d['key'] ?>" type='text' />
  	    		</label><br /><br />
  	    		<label style='cursor: pointer'>
				Sort: <br />
				<input name='data_sort[]' value="<?php empty($d['sort']) OR print $d['sort']; ?>" type='text' style='width: 40px' />
  	    		</label>
  	    		<input type='hidden' name='sidebar[]' value='<?php (!empty($d['sidebar']) AND $d['sidebar'] == 1) AND print "checked"; ?>' class="data_unique_container" />
  	    		<label style='margin-left: 25px; cursor: pointer;' onmouseup="check_sidebar($(this))">
  	    			<input type='checkbox' <?php (!empty($d['sidebar']) AND $d['sidebar'] == 1) AND print 'checked="checked"'; ?> /> Sidebar
  	    		</label><br /><br />
			<label style='cursor: pointer'>
  	    			Text: <br />
  	    			<textarea class='mceEditor' name='data_value[]' cols='55' rows='5'><?php empty($d['value']) OR print $d['value'] ?></textarea>
	    		</label>
	    		<a style='color: red; cursor: pointer; font-size: 13px;' onclick='$(this).parent().slideUp(function(){ $(this).remove(); })'>
	    			- Remove data
	    		</a>
	    		<br /><hr style='margin-left: -27px' />
	    		</div>
<?php	    endforeach; ?>
	    </div>
	    <a style="color: #4CBEFF; cursor: pointer; font-size: 13px;" id="add_data_field">+Add data</a><br /><br />



  	    <input type='submit' style='width:90px;' value='Submit' onclick='return document.getElementById("ptitle").value != ""' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/organizations", TRUE); ?>">Back</a>
  	<br />
  	<a onclick='return confirm("Are you sure?");' href="<?php echo href("admin/organizations/" . $organization['unique'] . "/delete", TRUE); ?>" >
  	    Delete this record
  	</a>
