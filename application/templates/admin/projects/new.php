  	<form method='post' enctype="multipart/form-data" action='<?php echo href("admin/projects/create"); ?>'>
  	    <label for='ptitle'>Title: </label>
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

  	    <label for='pdistrict'>District: </label>
  	    <br />
  	    <input name='p_district' id='pdistrict' type='text' />
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
  	    <br /><br />


  	    <label for='ptags'>Tags: (hold down Ctrl to select multiple)</label>
  	    <br />
  	    <select name='p_tags[]' id='ptags' multiple='multiple'>
  	      <?php
  	        foreach($all_tags as $tag)
  	        {
  	            ?>
  	            <option value="<?php echo $tag['id'] ?>"><?php echo $tag['name'] ?></option>
  	            <?php
  	        }
  	      ?>
  	    </select>
  	    <br /><br />

  	    <input type='submit' style='width:90px;' value='Submit' onclick=' return document.getElementById("dname").value != "" ' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/projects"); ?>">Back</a>
