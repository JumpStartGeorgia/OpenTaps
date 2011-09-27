<?php

  $action = href("admin/projects/" . $project['unique'] . "/update", TRUE);
?>
    	<form action='<? echo $action; ?>' method='post'>
  	    <label for='ptitle'>Title<span style="color: red">*</span>: </label>
  	    <br />
  	    <input name='p_title' id='ptitle' type='text' value="<?php echo $project['title'] ?>" />
  	    <br /><br />

  	    <label for='pdesc'>Description: </label>
  	    <br />
  	    <textarea name='p_desc' id='pdesc' cols='30' rows='3'><?php echo $project['description'] ?></textarea>
  	    <br />

  	    <label for='pinfo'>Project info: </label>
  	    <br />
  	    <textarea name='p_info' id='pinfo' cols='30' rows='3'><?php echo $project['info'] ?></textarea>
  	    <br />

  	    <label for='pbudget'>Budget: </label>
  	    <br />
  	    <input name='p_budget' id='pbudget' type='text' value="<?php echo $project['budget'] ?>" />
  	    <br /><br />


  	    <?php /*<label for='pregion'>Regions: </label>
  	    <br />
  	    <select name='p_region' id='pregion'>
  	      <?php
      foreach($regions as $region):
  	            $selected = ($region['id'] == $project['region_id']) ? "selected='selected'" : NULL;
  	            ?><option value="<?php echo $region['id'] ?>" <?php echo $selected ?>><?php echo $region['name'] ?></option><?php
  	        endforeach;
  	      ?>
  	    </select>
  	    <br /><br />*/ ?>

        <label for='pplace'>Place: </label>
  	    <br />
  	    <select name='p_place' id='pplace'>
  	      <?php
      foreach($places as $place):
  	            $selected = ($place['unique'] == $project['place_unique']) ? "selected='selected'" : NULL;
  	            ?><option value="<?php echo $place['unique'] ?>" <?php echo $selected ?>><?php echo $place['name'] ?></option><?php
  	        endforeach;
  	      ?>
  	    </select>
  	    <br /><br />
        
  	    <label for='pcity'>City: </label>
  	    <br />
  	    <input name='p_city' id='pcity' type='text' value="<?php echo $project['city'] ?>" />
  	    <br /><br />

  	    <label for='pgrantee'>Grantee: </label>
  	    <br />
  	    <input name='p_grantee' id='pgrantee' type='text' value="<?php echo $project['grantee'] ?>" />
  	    <br /><br />

  	    <label for='psector'>Sector: </label>
  	    <br />
  	    <input name='p_sector' id='psector' type='text' value="<?php echo $project['sector'] ?>" />
  	    <br /><br />

  	    <label for='pstart_at'>Start at: (yyyy-mm-dd) </label>
  	    <br />
  	    <input name='p_start_at' id='pstart_at' type='text' value="<?php echo $project['start_at'] ?>" />
  	    <br /><br />

  	    <label for='pend_at'>End at: (yyyy-mm-dd) </label>
  	    <br />
  	    <input name='p_end_at' id='pend_at' type='text' value="<?php echo $project['end_at'] ?>" />
  	    <br /><br />

  	    <label for='ptags'>Tags: (enter by hand or select tags below)</label>
  	    <br /><br />
  	    <input type="text" id="tag_box" name="p_tag_names" style="width: 150px; border-right: 1px solid #ccc;" value="" />
  	    <span style='font-size:12px;'>separate by comma ",&nbsp"</span>
  	    <br /><br />
  	    <select name='p_tag_uniques[]' id='ptags' multiple='multiple'>
  	      <?php
  	        foreach($all_tags as $tag):
  	            $selected = (in_array($tag['unique'], $this_tags)) ? "selected='selected'" : NULL;
  	            ?><option value="<?php echo $tag['unique'] ?>" <?php echo $selected ?>><?php echo $tag['name'] ?></option><?php
  	        endforeach;
  	      ?>
  	    </select>
  	    <br /><br />

  	    <label for='porgs'>Organizations: (hold down Ctrl to select multiple)</label>
  	    <br />
  	    <select name='p_orgs[]' id='porgs' multiple='multiple'>
  	      <?php
  	        foreach($organizations as $org):
  	            $selected = (in_array($org['unique'], $this_orgs)) ? "selected='selected'" : NULL;
  	            ?><option <?php echo $selected ?> value="<?php echo $org['unique'] ?>"><?php echo $org['name'] ?></option><?php
  	        endforeach;
  	      ?>
  	    </select>
  	    <br /><br />

  	    <label for='ptypes'>Project Type:</label>
  	    <br />
  	    <select name='p_type' id='ptypes'>
  	      <?php
  	        foreach($project_types as $type):
  	            $selected = ( $type == $project['type'] ) ? "selected='selected'" : NULL;
  	            ?><option <?php echo $selected ?> value="<?php echo $type ?>"><?php echo $type ?></option><?php
  	        endforeach;
  	      ?>
  	    </select>
  	    <br /><br />


	    <h3>Project Data</h3>
	    <div id="data_fields_container" style="padding-left: 55px;">
<?php	    foreach ($data as $idx => $d):
	    	$bg = ($idx & 1) ? 'url(' . href() . 'images/bg.jpg) repeat' : 'white'; ?>
			<div class='group' style='background: <?php echo $bg; ?>'>
			<label style='cursor: pointer'>
  	    			Title: <br />
  	    			<input name='project_key[]' value="<?php empty($d['key']) OR print $d['key'] ?>" type='text' />
  	    		</label><br /><br />
  	    		<label style='cursor: pointer'>
				Sort: <br />
				<input name='project_sort[]' value="<?php empty($d['sort']) OR print $d['sort']; ?>" type='text' style='width: 40px' />
  	    		</label>
  	    		<input type='hidden' name='sidebar[<?php echo $idx; ?>]' value='not_checked' />
  	    		<label style='margin-left: 25px; cursor: pointer;'>
  	    			<input type='checkbox' name='sidebar[<?php echo $idx; ?>]' value='checked' <?php (!empty($d['sidebar']) AND $d['sidebar'] == 1) AND print 'checked="checked"'; ?> /> Sidebar
  	    		</label><br /><br />
			<label style='cursor: pointer'>
  	    			Text: <br />
  	    			<textarea class='mceEditor' name='project_value[]' cols='55' rows='5'><?php empty($d['value']) OR print $d['value'] ?></textarea>
	    		</label>
	    		<a style='color: red; cursor: pointer; font-size: 13px;' onclick='$(this).parent().remove()'>
	    			-Remove data
	    		</a>
	    		<br /><hr style='margin-left: -27px' />
	    		</div>
<?php	    endforeach; ?>
	    </div>
	    <a style="color: #4CBEFF; cursor: pointer; font-size: 13px;" id="add_data_field">+Add data</a><br /><br />



  	    <input type='submit' style='width:90px;' value='Submit' onclick='return document.getElementById("ptitle").value != ""' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/projects", TRUE); ?>">Back</a>
  	<br />
  	<a onclick='return confirm("Are you sure?");' href="<?php echo href("admin/projects/" . $project['unique'] . "/delete", TRUE); ?>" >
  	    Delete this record
  	</a>
