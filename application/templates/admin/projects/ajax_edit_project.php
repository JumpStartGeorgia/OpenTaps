<div style="float: left; line-height: 27px;">
	Location - City/Town: <br />
	Place: <br />
	Grantee: <br />
	Sector: <br />
	Budget: <br />
	Beginning: <br />
	Ending: <br />
	Type: <br />
</div>
<div style="display: inline-block; margin-left: 50px; line-height: 27px;">
	<input type='text' id='p_city' value='<?php echo $project['city']; ?>' /><br />
	<select id='p_place_unique'><?php
	foreach($places as $place):
		$selected = ($place['unique'] == $project['place_unique']) ? "selected='selected'" : NULL;
		?><option value="<?php echo $place['unique'] ?>" <?php echo $selected ?>><?php echo $place['name'] ?></option><?php
	endforeach;
	?></select> by choosing a place, you also choose the region.<br />
	<input type='text' id='p_grantee' value='<?php echo $project['grantee']; ?>' /><br />
	<input type='text' id='p_sector' value='<?php echo $project['sector']; ?>' /><br />
	<input type='text' id='p_budget' value='<?php echo $project['budget']; ?>' /><br />
	<input type='text' id='p_start_at' value='<?php echo $project['start_at']; ?>' /><br />
	<input type='text' id='p_end_at' value='<?php echo $project['end_at']; ?>' /><br />
	<select id='p_type'><?php
	foreach($types as $type):
		$selected = ($type == $project['type']) ? "selected='selected'" : NULL;
		?><option <?php echo $selected ?> value="<?php echo $type ?>"><?php echo $type ?></option><?php
	endforeach;
	?></select><br />
	<input type="submit" value="Save" id="admin_save_button" datatype="basic_info" style="cursor: pointer" />
	<span id='message_container'></span>
</div>
