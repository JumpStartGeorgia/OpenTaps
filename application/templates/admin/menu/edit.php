<?
  $sql = "SELECT * FROM menu WHERE id = :id";
  $statement = Storage::instance()->db->prepare($sql);
  $statement->execute(array(':id' => $id));
  $result = $statement->fetch(PDO::FETCH_ASSOC);

  $action = href("admin/menu/" . $result['id'] . "/update");
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
  	    Parent: 
  	    <select name='m_parent_id'>
  ";

  $parents = Storage::instance()->menu;
  foreach($parents as $parent)
  {
      $selected = ($parent['id'] == $result['parent_id']) ? "selected" : "";

      if($parent['name'] != $result['name'])
         echo "
      		<option " . $selected . " value=\"" . $parent['id'] . "\">" . $parent['name'] . "</option>
         ";
  }

  echo"
  	    </select>
  	    <br /><br />
  	    <input type='submit' value='Submit' /><br /><br />
  	</form>

  	<a href=\"" . href("admin/menu") . "\">Back</a>
  	<br />
  	<a href=\"" . href("admin/menu/" . $result['id'] . "/delete") . "\" onclick='return confirm(\"Are you sure?\");'>Delete this record</a>
  ";
