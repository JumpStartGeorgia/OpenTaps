<?
  //echo isset($alert) ? "<i>".$alert."</i><br />" : "";

  if(!isset($table) && !isset($id) && !isset($action))		#show all tables
  {
      $sql = "show tables";
      $statement = Storage::instance()->db->prepare($sql);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $table)
      {
      	  $link = URL . 'admin/' . $table[0] . '/';
          echo "<a href=\" " . $link . " \">" . $table[0] . "</a><br />";
      }
  }
