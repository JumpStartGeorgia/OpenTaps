<?
  $action = href("admin/menu/" . $result['unique'] . "/update", TRUE);
  echo "
  	<form action='" . $action . "' method='post'>
  	    <label for='mname'>Name: </label>
  	    <br />
  	    <input name='m_name' id='mname' type='text' value=\"" . $result['name'] . "\" />
  	    <br /><br />
  	    <label for='mshortname'>Short Name: </label>
  	    <br />
  	    <input name='m_short_name' id='mshortname' type='text' value=\"" . $result['short_name'] . "\" />
  	    <br /><br />
        <label for='mtitle'>Title:</label>
        <br />
        <input type='text' value='". $result['title'] ."' name='m_title' id='mtitle'/>
        <br /><br />
        <label for='mtext'>Text:</label>
        <br />
        <textarea name='m_text' id='mtext'>". $result['text'] ."</textarea>
        <br /><br  />
  ";
  if($result['parent_unique'] != 0)
  {
      echo "
  	    Parent: 
  	    <select name='m_parent_unique'>
      ";

      foreach(Storage::instance()->menu as $parent)
      {
         $selected = ($parent['unique'] == $result['parent_unique']) ? "selected" : "";

         echo "  <option " . $selected . " value=\"" . $parent['unique'] . "\">" . $parent['name'] . "</option>";
      }
      echo "
      	    </select>
            <br /><br />
      ";
  }
  else
    echo "  <input type='hidden' value='0' name='m_parent_unique' />";

  echo "
        <input type='checkbox' ";
echo $result['hide'] == 0 ? "checked" : NULL;
    echo " name='m_hide' id='mhide'/>
        <label for='mhide'>Hidden</label>&nbsp;&nbsp;";
        /*<input type='checkbox'";
echo $result['footer'] == 0 ? "checked" : NULL;
echo " name='m_footer' id='mfooter'/>
<label for='mfooter'>Footer</label>*/
	echo "
	<br /><br />
  	    <input type='submit' style='width:90px;' value='Submit' />
  	    <br /><br />
  	</form>

  	<a href=\"" . href("admin/menu", TRUE) . "\">Back</a>
  	<br />
  	<a href=\"" . href("admin/menu/" . $result['unique'] . "/delete", TRUE) . "\" onclick='return confirm(\"Are you sure?\");'>
  	    Delete this record
  	</a>
  ";
