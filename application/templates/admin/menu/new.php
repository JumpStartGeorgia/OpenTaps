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
        <label for='mtitle'>Title:</label>
        <br />
        <input type='text' name='m_title' id='mtitle'/>
        <br /><br />
        <label for='mtext'>Text:</label>
        <br />
        <textarea name='m_text' id='mtext'></textarea>
        <br /><br />
  	    Parent: 
  	    <select name='m_parent_unique'>
  	        <option selected value='0'>None</option>
  ";

  foreach(Storage::instance()->menu as $parent)
    echo       "<option value=\"" . $parent['unique'] . "\">" . $parent['name'] . "</option>";

  echo "
  	    </select>
            <br /><br />
        <input type='checkbox' name='m_hide' id='mhide'/>
        <label for='mhide'>Hidden</label>&nbsp;&nbsp;";
        /*<input type='checkbox' id='mfooter'  name='m_footer'/>
        <label for='mfooter'>Footer</label>*/ echo "
        <br /></br >
  	    <input type='submit' style='width:90px;' value='Submit' />
  	    <br /><br />
  	</form>

  	<a href=\"" . href("admin/menu") . "\">Back</a>
  ";
