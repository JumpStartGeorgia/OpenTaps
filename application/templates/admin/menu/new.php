<?
  echo "
  	<form action='" . href("admin/menu/create") . "' method='post'>
  	    <label for='mname'>Name: </label>
  	    <br />
  	    <input name='m_name' id='mname' type='text' />
  	    <br /><br />
  	    <label for='mshortname'>Short Name: </label>
  	    <br />
  	    <input name='m_short_name' id='mshortname' type='text' />
  	    <br /><br />
  	    Parent: 
  	    <select name='m_parent_id'>
  	        <option selected value='0'>None</option>
  ";

  foreach(Storage::instance()->menu as $parent)
    echo "  	<option value=\"" . $parent['id'] . "\">" . $parent['name'] . "</option>";

  echo "
  	    </select>
            <br /><br />
  	    <input type='submit' style='width:90px;' value='Submit' />
  	    <br /><br />
  	</form>

  	<a href=\"" . href("admin/menu") . "\">Back</a>
  ";
