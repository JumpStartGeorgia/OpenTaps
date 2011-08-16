<?php
  $action = href("admin/projects/" . $project['id'] . "/update");
?>
    	<form action='<? echo $action; ?>' method='post'>
  	    <label for='ptitle'>Title: </label>
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

  	    <label for='pdistrict'>District: </label>
  	    <br />
  	    <input name='p_district' id='pdistrict' type='text' value="<?php echo $project['district'] ?>" />
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

  	    <label for='ptags'>Tags: (hold down Ctrl to select multiple)</label>
  	    <br />
  	    <select name='p_tags[]' id='ptags' multiple='multiple'>
  	      <?php
  	        foreach($all_tags as $tag):
  	            $selected = (in_array($tag['id'], $this_tags)) ? "selected='selected'" : NULL;
  	            ?><option value="<?php echo $tag['id'] ?>" <?php echo $selected ?>><?php echo $tag['name'] ?></option><?php
  	        endforeach;
  	      ?>
  	    </select>
  	    <br /><br />

  	    <label for='porgs'>Organizations: (hold down Ctrl to select multiple)</label>
  	    <br />
  	    <select name='p_orgs[]' id='porgs' multiple='multiple'>
  	      <?php
  	        foreach($organizations as $org):
  	            $selected = (in_array($org['id'], $this_orgs)) ? "selected='selected'" : NULL;
  	            ?><option <?php echo $selected ?> value="<?php echo $org['id'] ?>"><?php echo $org['org_name'] ?></option><?php
  	        endforeach;
  	      ?>
  	    </select>
  	    <br /><br />

  	    <input type='submit' style='width:90px;' value='Submit' onclick='return document.getElementById("ptitle").value != ""' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/projects"); ?>">Back</a>
  	<br />
  	<a onclick='return confirm("Are you sure?");' href="<?php echo href("admin/projects/" . $project['id'] . "/delete"); ?>" >
  	    Delete this record
  	</a>
