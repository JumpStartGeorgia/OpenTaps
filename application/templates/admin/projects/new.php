  	<form method='post' enctype="multipart/form-data" action="<?php echo href('admin/projects/create', TRUE); ?>">
    	   Language: &nbsp;
	   <select style="width: 70px;" name="record_language">
	   <?php foreach (config('languages') AS $lang): $s = 'selected="selected"';?>
	   	<option <?php LANG == $lang AND print $s; ?> value="<?php echo $lang; ?>"><?php echo $lang; ?></option>
	   <?php endforeach; ?>
	   </select><br /><br />


  	    <label for='ptitle'>Title<span style="color: red">*</span>: </label>
  	    <br />
  	    <input name='p_title' id='ptitle' type='text' />
  	    <br /><br />

  	    <?php /*<label for='pdesc'>Description: </label>
  	    <br />
  	    <textarea name='p_desc' id='pdesc' cols='30' rows='3'></textarea>
  	    <br />

  	    <label for='pinfo'>Project info: </label>
  	    <br />
  	    <textarea name='p_info' id='pinfo' cols='30' rows='3'></textarea>
  	    <br />*/ ?>

	    <label>
		Beneficiary People: <br />
		<input name="p_beneficiary_people" type="text" value="" />
	    </label>
  	    <br /><br />

  	    Budgets:
  	    <span style="font-size: 12px;">
  	    	(if you select an organization twice or more, the first one will be inserted in database)
  	    </span>
  	    <br />
  	    <div style="margin: 0px; width: 300px;" class="group" id="budget_fields_container">
		<div class="budget-container group" id="budget_fields">
			<div style="width: 100%; height: 30px;">
		  	    <div style="margin-top: 1px; float: left">Organization</div>
		  	    <div style="float: right">
				<select class="chosen-select" name='p_budget_org[]' style="width: 160px;">
				<?php foreach($organizations as $org): ?>
				    <option value="<?php echo $org['unique'] ?>"><?php echo $org['name'] ?></option>
				<?php endforeach; ?>
				</select>
		  	    </div>
		  	</div>
		  	<div style="width: 100%; height: 30px;">
		  	    <div style="margin-top: 1px; float:left;">Budget</div>
			    <div style="float:right;"><input name='p_budget[]' type='text' /></div>
		  	</div>
		  	<div style="width: 100%; height: 25px; display: none;">
		  	    <div style="margin-top: 1px; float:left;">Currency</div>
			    <div style="float:right;">
				<select class="chosen-select" name='p_budget_currency[]' style="width: 160px;">
				<?php foreach($currency_list as $currency): ?>
				    <option <?php $currency == 'gel' AND print 'selected="selected"'; ?>value="<?php echo $currency ?>"><?php echo $currency ?></option>
				<?php endforeach; ?>
				</select>
			    </div>
		  	</div>
		</div>
	    </div>
	    <a class="region_link" style="display: block; margin-bottom: 20px; font-size: 13px;" id="add_budget_field">+Add budget</a>

	    <label for='pplace'>Place:</label>
  	    <br />
  	    <select name='p_place[]' multiple="multiple" class="chosen-select" id='pplace'>
  	    <?php foreach($places as $place): ?>
  	    	<option value="<?php echo $place['unique'] ?>"><?php echo $place['name'] ?></option>
	    <?php endforeach; ?>
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
  	    <?php foreach($organizations as $org): ?>
		<option value="<?php echo $org['unique'] ?>"><?php echo $org['name'] ?></option>
  	    <?php endforeach; ?>
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
	    <a class="region_link" style="font-size: 13px;" id="add_data_field">+Add data</a><br /><br />


  	    <input type='submit' style='width:90px;' value='Submit' onclick=' return document.getElementById("dname").value != "" ' />
  	    <br /><br />

  	</form>

  	<a href="<?php echo href("admin/projects", TRUE); ?>">Back</a>
