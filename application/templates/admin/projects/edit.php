<?php
$action = href('admin/projects/' . $project['unique'] . '/update', TRUE);
$months = array(NULL, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$c = 'checked="checked"';
$dn = 'style="display: none;"';
$db = 'style="display: block;"';
?>
<form action="<? echo $action; ?>" method='post'>
    <label for='ptitle'>Title<span style="color: red">*</span>: </label>
    <br />
    <input name='p_title' id='ptitle' type='text' value="<?php echo $project['title'] ?>" />
    <br /><br />

    <label style="cursor: pointer;">
        <input type="checkbox" name="hidden" <?php $project['hidden'] == 1 and print $c ?> /> Hidden
    </label><br /><br />


    <?php /* <label for='pdesc'>Description: </label>
      <br />
      <textarea name='p_desc' id='pdesc' cols='30' rows='3'><?php echo $project['description'] ?></textarea>
      <br />

      <label for='pinfo'>Project info: </label>
      <br />
      <textarea name='p_info' id='pinfo' cols='30' rows='3'><?php echo $project['info'] ?></textarea>
      <br /> */ ?>

    <label>
		Beneficiary People: <br />
        <input name="p_beneficiary_people" type="text" value="<?php echo intval($project['beneficiary_people']) ?>" />
    </label>
    <select name="p_beneficiary_type">
        <?php
        $ben_people = explode(' ', $project['beneficiary_people']);
        if (LANG == 'en'):
            $ben_type['person'] = 'Person';
            $ben_type['family'] = 'Family';
        else:
            $ben_type['person'] = 'ადამიანი';
            $ben_type['family'] = 'ოჯახი';
        endif;
        if (isset($ben_people[1])):
            ?>
            <option <?php echo ( $ben_people[1] == $ben_type['person'] ) ? 'selected="selected"' : NULL; ?>><?php echo $ben_type['person']; ?></option>
            <option <?php echo ( $ben_people[1] == $ben_type['family'] ) ? 'selected="selected"' : NULL; ?>><?php echo $ben_type['family']; ?></option>
        <?php else: ?>
            <option></option>
            <option><?php echo $ben_type['person']; ?></option>
            <option><?php echo $ben_type['family']; ?></option>
        <?php endif; ?>
    </select>
    <br /><br />

  	    Budgets: <br /><?php $s = 'selected="selected"'; ?>
    <div style="margin: 0px; width: 300px;" class="group" id="budget_fields_container">
        <?php foreach ($budgets as $budget): ?>
            <div class="budget-container group" id="budget_fields">
                <div style="width: 100%; height: 30px;">
                    <div style="margin-top: 1px; float: left">Organization</div>
                    <div style="float: right">
                        <select class="chosen-select" name='p_budget_org[]' style="width: 160px;">
                            <?php foreach ($organizations as $org): ?>
                                <option <?php $budget['organization_unique'] == $org['unique'] AND print $s; ?>
                                    value="<?php echo $org['unique'] ?>">
                                        <?php echo $org['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div style="width: 100%; height: 30px;">
                    <div style="margin-top: 1px; float:left;">Budget</div>
                    <div style="float:right;">
                        <input name='p_budget[]' value="<?php echo $budget['budget']; ?>" type='text' />
                    </div>
                </div>
                <div style="width: 100%; height: 25px; display: none;">
                    <div style="margin-top: 1px; float:left;">Currency</div>
                    <div style="float:right;">
                        <select class="chosen-select" name='p_budget_currency[]' style="width: 160px;">
                            <?php foreach ($currency_list as $currency): ?>
                                <option <?php /* $budget['currency'] */'gel' == $currency AND print $s; ?> value="<?php echo $currency ?>">
                                    <?php echo $currency ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <a onclick="$(this).parent().slideUp(function(){$(this).remove();})"
                   class="region_link" style="color: red; font-size: 12px;">
        		  		-Remove budget
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <a class="region_link" style="display: block; margin-bottom: 20px; font-size: 13px;" id="add_budget_field">+Add budget</a>


    <label for='pplace'>Place: </label>
    <br />
    <select name='p_place[]' multiple="multiple" class="chosen-select" id='pplace'>
        <?php
        //$us = @unserialize($project['place_unique']);
        //is_array($us) OR $us = array();
        foreach ($places as $place):
            $selected = (in_array($place['unique'], $project_places)) ? "selected='selected'" : NULL;
            ?><option value="<?php echo $place['unique'] ?>" <?php echo $selected ?>><?php echo $place['name'] ?></option><?php
    endforeach;
        ?>
    </select>
    <br /><br />

    <label>
      Region<br />
      <select name="region_unique">
	<?php foreach ($regions as $region): ?>
	    <option <?php $region['unique'] == $project['region_unique'] and print $s; ?> value="<?php echo $region['unique']; ?>">
		<?php echo $region['name']; ?>
	    </option>
	<?php endforeach; ?>
      </select>
    </label><br /><br />

    <label>
      District<br />
      <select name="district_unique">
	<?php foreach ($districts as $district): ?>
	    <option <?php $district['unique'] == $project['district_unique'] and print $s; ?> value="<?php echo $district['unique']; ?>">
		<?php echo $district['name']; ?>
	    </option>
	<?php endforeach; ?>
      </select>
    </label><br /><br />

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

    <label>Start at:</label><br />
    <?php
    $date = (empty($project['start_at']) OR $project['start_at'] == NULL) ? FALSE : $project['start_at'];
    list($y, $m, $d) = $date ? array(substr($date, 0, 4), substr($date, 5, 2), substr($date, 8, 2)) : array(date('Y'), date('m'), date('d'));
    ?>
    <label class="p_overlay">
	<div id="sae_overlay" <?php echo $date ? $db : $dn; ?>></div>
	<input type="checkbox" <?php $date or print $c; ?> name="empty_start_at" value="1" onclick="$('#sa_overlay, #sae_overlay').toggle();" id="sae_cb" /> Empty
    </label>
    <div class="d_overlay group">
	<div onclick="$('#sae_cb').click();" <?php $date and print $dn; ?> id="sa_overlay"></div>
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
    <?php
    $date = (empty($project['end_at']) OR $project['end_at'] == NULL) ? FALSE : $project['end_at'];
    list($y, $m, $d) = $date ? array(substr($date, 0, 4), substr($date, 5, 2), substr($date, 8, 2)) : array(date('Y'), date('m'), date('d'));
    ?>
    <label class="p_overlay">
	<div id="eae_overlay" <?php echo $date ? $db : $dn; ?>></div>
	<input type="checkbox" <?php $date or print $c; ?> name="empty_end_at" value="1" onclick="$('#ea_overlay, #eae_overlay').toggle();" id="eae_cb" /> Empty
    </label>
    <div class="d_overlay group">
	<div onclick="$('#eae_cb').click();" <?php $date and print $dn; ?> id="ea_overlay"></div>
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
    <select class="chosen-select" name='p_tag_uniques[]' id='ptags' multiple='multiple'>
        <?php
        foreach ($all_tags as $tag):
            $selected = (in_array($tag['unique'], $this_tags)) ? "selected='selected'" : NULL;
            ?><option value="<?php echo $tag['unique'] ?>" <?php echo $selected ?>><?php echo $tag['name'] ?></option><?php
    endforeach;
        ?>
    </select>
    <br /><br />

    <label for='porgs'>Organizations:</label>
    <br />
    <select class="chosen-select" name='p_orgs[]' id='porgs' multiple='multiple'>
        <?php
        foreach ($organizations as $org):
            $selected = (in_array($org['unique'], $this_orgs)) ? "selected='selected'" : NULL;
            ?><option <?php echo $selected ?> value="<?php echo $org['unique'] ?>"><?php echo $org['name'] ?></option><?php
    endforeach;
        ?>
    </select>
    <br /><br />

    <label for='ptypes'>Project Type:</label>
    <br />
    <select class="chosen-select" name='p_type' id='ptypes'>
        <?php
        foreach ($project_types as $type):
            $selected = ( $type == $project['type'] ) ? "selected='selected'" : NULL;
            ?><option <?php echo $selected ?> value="<?php echo $type ?>"><?php echo $type ?></option><?php
    endforeach;
        ?>
    </select>
    <br /><br />


    <h3>Project Data</h3>
    <div id="data_fields_container" style="padding-left: 55px;">
        <?php foreach ($data as $idx => $d):
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
                <input type='hidden' class="data_unique_container" name='sidebar[]' value='<?php (!empty($d['sidebar']) AND $d['sidebar'] == 1) AND print "checked"; ?>' />
                <label style='margin-left: 25px; cursor: pointer;' onmouseup="check_sidebar($(this))">
                    <input type='checkbox' <?php (!empty($d['sidebar']) AND $d['sidebar'] == 1) AND print $c; ?> /> Sidebar
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
        <?php endforeach; ?>
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
