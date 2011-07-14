<?
      $sql = "SELECT * FROM ".$table;
      $statement = Storage::instance()->db->prepare($sql);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      $rows = array_keys($result);
      echo "
      		<table class='records' cellpadding='0' cellspaing='0'>
      		  <tr>
      ";
      foreach($rows as $row)
      {
          echo "
          		<th>" . $row . "</th>
          ";
      }
      echo "
      		  </tr>
      ";
      $link_new = URL . $table . '/' . 'new';
      do
      {
          echo "
          	  <tr>
          ";
	  foreach($rows as $row)
          {
              if(strlen($result[$row]) > 15)
                  $result[$row] = substr($result[$row], 0, 15) . "...";
              echo "
              		<td>" . $result[$row] . "</td>
              ";
          }
	  $link_edit = URL . "admin/" . $table . '/' . $result['id'] . '/';
	  $link_del = URL . "admin/" . $table . '/' . $result['id'] . '/delete/';
          echo "
         		<td><a href=\" " . $link_edit . " \">Edit</a></td>
         		<td><a href=\" " . $link_del . " \" onclick='return confirm(\" Are you Sure? \")'>Delete</a></td>
          ";
          echo "
                  </tr>
          ";
      }
      while($result = $statement->fetch(PDO::FETCH_ASSOC));
      echo "
                  <tr>
                  	<td align='center' colspan='6'><a href=\" " . $link_new . " \">New Record</a></td>
                  </tr>
      	      </table>
      ";
