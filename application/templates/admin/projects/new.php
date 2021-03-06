<form method='post' enctype="multipart/form-data" action="<?php echo href('admin/projects/create', TRUE); ?>">
    	   Language: &nbsp;
    <select style="width: 70px;" name="record_language">
        <?php foreach (config('languages') AS $lang): $s = 'selected="selected"'; ?>
            <option <?php LANG == $lang AND print $s; ?> value="<?php echo $lang; ?>"><?php echo $lang; ?></option>
        <?php endforeach; ?>
    </select><br /><br />

    <label style="cursor: pointer;">
        <input type="checkbox" name="hidden" /> Hidden
    </label><br /><br />



    <label for='ptitle'>Title<span style="color: red">*</span>: </label>
    <br />
    <input name='p_title' id='ptitle' type='text' />
    <br /><br />

    <?php /* <label for='pdesc'>Description: </label>
      <br />
      <textarea name='p_desc' id='pdesc' cols='30' rows='3'></textarea>
      <br />

      <label for='pinfo'>Project info: </label>
      <br />
      <textarea name='p_info' id='pinfo' cols='30' rows='3'></textarea>
      <br /> */ ?>

    <label>
		Beneficiary People: <br />
        <input name="p_beneficiary_people" type="text" value="" />
    </label>
    <select name="p_beneficiary_type">
        <option><?php echo (LANG == 'en') ? 'Person' : 'ადამიანი'; ?></option>
        <option><?php echo (LANG == 'en') ? 'Family' : 'ოჯახი' ?></option>
    </select>
    <br /><br />

  	    Budgets:
    <br />
    <div style="margin: 0px; width: 300px;" class="group" id="budget_fields_container">
        <div class="budget-container group" id="budget_fields">
            <div style="width: 100%; height: 30px;">
                <div style="margin-top: 1px; float: left">Organization</div>
                <div style="float: right">
                    <select class="chosen-select" name='p_budget_org[]' style="width: 160px;">
                        <?php foreach ($organizations as $org): ?>
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
                        <?php foreach ($currency_list as $currency): ?>
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
        <?php foreach ($places as $place): ?>
            <option value="<?php echo $place['unique'] ?>"><?php echo $place['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <br /><br />

    <label>
      Region<br />
      <select name="region_unique">
	<?php foreach ($regions as $region): ?>
	    <option value="<?php echo $region['unique']; ?>"><?php echo $region['name']; ?></option>
	<?php endforeach; ?>
      </select>
    </label><br /><br />

    <label>
      District<br />
      <select name="district_unique">
	<?php foreach ($districts as $district): ?>
	    <option value="<?php echo $district['unique']; ?>"><?php echo $district['name']; ?></option>
	<?php endforeach; ?>
      </select>
    </label><br /><br />

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

    <label>Start at:</label><br />
    <label class="p_overlay">
	<div id="sae_overlay"></div>
	<input type="checkbox" checked="checked" name="empty_start_at" value="1" onclick="$('#sa_overlay, #sae_overlay').toggle();" id="sae_cb" /> Empty
    </label>
    <?php
    list($y, $m, $d) = array(date("Y"), date("m"), date("d"));
    $months = array(NULL, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    ?>
    <div class="d_overlay group">
	<div onclick="$('#sae_cb').click();" id="sa_overlay"></div>
	<input type="text" style="width: 35px;" value="<?php echo $d; ?>" name="p_start_at[day]" />&nbsp;-
	<select class="chosen_deselector" name="p_start_at[month]">
	<?php for ($i = 1; $i <= 12; $i++): $ii = $i < 10 ? '0' . $i : $i; ?>
	    <option <?php $i == $m and print 'selected="selected"' ?> value="<?php echo $ii; ?>"><?php echo $months[$i]; ?></option>
	<?php endfor; ?>
	</select>&nbsp;-
	<input type="text" style="width: 45px;" value="<?php echo $y; ?>" name="p_start_at[year]" />
    </div>
    <br /><br />

    <label>End at:</label><br />
    <label class="p_overlay">
	<div id="eae_overlay"></div>
	<input type="checkbox" checked="checked" name="empty_end_at" value="1" onclick="$('#ea_overlay, #eae_overlay').toggle();" id="eae_cb" /> Empty
    </label>
    <div class="d_overlay group">
	<div onclick="$('#eae_cb').click();" id="ea_overlay"></div>
	<input type="text" style="width: 35px;" value="<?php echo $d; ?>" name="p_end_at[day]" />&nbsp;-
	<select class="chosen_deselector" name="p_end_at[month]">
	<?php for ($i = 1; $i <= 12; $i++): $ii = $i < 10 ? '0' . $i : $i; ?>
	    <option <?php $i == $m and print 'selected="selected"' ?> value="<?php echo $ii; ?>"><?php echo $months[$i]; ?></option>
	<?php endfor; ?>
	</select>&nbsp;-
	<input type="text" style="width: 45px;" value="<?php echo $y; ?>" name="p_end_at[year]" />
    </div>
    <br /><br /><br />


    <label for='ptags'>Tags: (enter by hand or select tags below)</label>
    <br /><br />
    <input type="text" id="tag_box" name="p_tag_names" style="width: 150px; border-right: 1px solid #ccc;" value="" />
    <span style='font-size:12px;'>separate by comma ",&nbsp"</span>
    <br /><br />
    <select name='p_tag_uniques[]' id='ptags' multiple="multiple" style="width: 153px; border-right: 1px solid #ccc;">
        <?php
        foreach ($all_tags as $tag):
            ?><option value="<?php echo $tag['unique'] ?>"><?php echo $tag['name'] ?></option><?php
    endforeach;
        ?>
    </select>
    <br /><br />

    <label for='porgs'>Organizations:</label>
    <br />
    <select name='p_orgs[]' id='porgs' multiple='multiple'>
        <?php foreach ($organizations as $org): ?>
            <option value="<?php echo $org['unique'] ?>"><?php echo $org['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <br /><br />

    <label for='porgs'>Project Types:</label>
    <br />
    <select name='p_type' id='ptypes'>
        <?php
        foreach ($project_types as $type):
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
