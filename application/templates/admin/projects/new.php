  	<form method='post' enctype="multipart/form-data" action='<?php echo href("admin/projects/create", TRUE); ?>'>
  	    <label for='ptitle'>Title<span style="color: red">*</span>: </label>
  	    <br />
  	    <input name='p_title' id='ptitle' type='text' />
  	    <br /><br />

  	    <label for='pdesc'>Description: </label>
  	    <br />
  	    <textarea name='p_desc' id='pdesc' cols='30' rows='3'></textarea>
  	    <br />

  	    <label for='pinfo'>Project info: </label>
  	    <br />
  	    <textarea name='p_info' id='pinfo' cols='30' rows='3'></textarea>
  	    <br />

  	    <label for='pbudget'>Budget: </label>
  	    <br />
  	    <input name='p_budget' id='pbudget' type='text' />
  	    <br /><br />

  	   <?php /* <label for='pregions'>Region:</label>
  	    <br />
  	    <select name='p_region' id='pregions'>
  	      <?php
  	        foreach($regions as $region):
  	            ?><option value="<?php echo $region['id'] ?>"><?php echo $region['name'] ?></option><?php
  	        endforeach;
  	      ?>
  	    </select>
  	    <br /><br />-->*/ ?>

        <label for='pplace'>Place:</label>
  	    <br />
  	    <select name='p_place' class="chosen-select" id='pplace'>
  	      <?php
  	        foreach($places as $place):
  	            ?><option value="<?php echo $place['unique'] ?>"><?php echo $place['name'] ?></option><?php
  	        endforeach;
  	      ?>
  	    </select>
  	    <br /><br />


  	    <label for='pcity'>City: </label>
  	    <br />
  	    <input name='p_city' id='pcity' type='text' />
  	    <br /><br />

  	    <label for='pgrantee'>Grantee: </label>
  	    <br />
  	    <input name='p_grantee' id='pgrantee' type='text' />
  	    <br /><br />

  	    <label for='psector'>Sector: </label>
  	    <br />
  	    <input name='p_sector' id='psector' type='text' />
  	    <br /><br />

  	    <label for='pstart_at'>Start at: (yyyy-mm-dd) </label>
  	    <br />
  	    <input name='p_start_at' id='pstart_at' type='text' />
  	    <br /><br />

  	    <label for='pend_at'>End at: (yyyy-mm-dd) </label>
  	    <br />
  	    <input name='p_end_at' id='pend_at' type='text' />
  	    <br /><br /><br />


  	    <label for='ptags'>Tags: (enter by hand or select tags below)</label>
  	    <br /><br />
  	    <input type="text" id="tag_box" name="p_tag_names" style="width: 150px; border-right: 1px solid #ccc;" value="" />
  	    <span style='font-size:12px;'>separate by comma ",&nbsp"</span>
  	    <br /><br />
  	    <select name='p_tag_uniques[]' id='ptags' multiple="multiple" style="width: 153px; border-right: 1px solid #ccc;">
  	      <?php
  	        foreach($all_tags as $tag):
  	            ?><option value="<?php echo $tag['unique'] ?>"><?php echo $tag['name'] ?></option><?php
  	        endforeach;
  	      ?>
  	    </select>
  	    <br /><br />

 	    <label for='porgs'>Organizations: (hold down Ctrl to select multiple)</label>
  	    <br />
  	    <select name='p_orgs[]' id='porgs' multiple='multiple'>
  	      <?php
  	        foreach($organizations as $org):
  	            ?><option value="<?php echo $org['unique'] ?>"><?php echo $org['name'] ?></option><?php
  	        endforeach;
  	      ?>
  	    </select>
  	    <br /><br />

 	    <label for='porgs'>Project Types:</label>
  	    <br />
  	    <select name='p_type' id='ptypes'>
  	      <?php
  	        foreach($project_types as $type):
  	            ?><option value="<?php echo $type ?>"><?php echo $type ?></option><?php
  	        endforeach;
  	      ?>
  	    </select>
  	    <br /><br />

	    <h3>Project Data</h3>
	    <div id="data_fields_container" style="padding-left: 55px;">
	    </div>
	    <a style="color: #4CBEFF; cursor: pointer; font-size: 13px;" id="add_data_field">+Add data</a><br /><br />


  	    <input type='submit' style='width:90px;' value='Submit' onclick=' return document.getElementById("dname").value != "" ' />
  	    <br /><br />

  	</form>

  	<a href="<?php echo href("admin/projects", TRUE); ?>">Back</a>
