<?
  $sql = "SELECT * FROM ".$table." WHERE id = :id";
  $statement = Storage::instance()->db->prepare($sql);
  $statement->execute(array(':id' => $id));
  $result = $statement->fetch(PDO::FETCH_ASSOC);
  $rows = array_keys($result);
  echo "
  		<form action='' method='post' />
  ";
  foreach($rows as $row)
  {
      echo 
      		$row . "<br />
      ";
      if(strlen($result[$row]) < 23)
          echo "
      		    <input type='text' value=\" " . $result[$row] . " \" /><br />
          ";
      else
      {
        if(strlen($result[$row]) / 10 > 100)
          echo "
      		    <textarea rows='20' cols='" . round(strlen($result[$row]) / 20) . "'>" . $result[$row] . "</textarea><br />
          ";
        else
          echo "
      		    <textarea rows='10' cols='" . round(strlen($result[$row]) / 10) . "'>" . $result[$row] . "</textarea><br />
          ";
       }
  }
  $link_back = URL . "admin/" . $table . '/';
  $link_del = URL . "admin/" . $table . '/' . $result['id'] . '/delete/';
  echo "
  		    <br />
  		    <input type='submit' value='Submit' />
  		    <br /> <br />
  		    <a href=\" " . $link_back . " \">Back</a><br/ >
  		    <br />
  		    <a href=\" " . $link_del . "\" onclick='return confirm(\" Are you Sure? \")'>Delete this record</a>
  		</form>
  ";
