<?

  $sql = "UPDATE menu SET name = :name, short_name = :short_name, parent_id = :parent_id WHERE id = :id";
  $statement = Storage::instance()->db->prepare($sql);

  try
  {
      $statement->execute(array(
  	    ':name' = > $_POST['m_name'],
  	    ':short_name' = > $_POST['m_short_name'],
  	    ':parent_id' => $_POST['m_parent_id'],
  	    ':id' => $id
      ));
  }
  catch (PDOException $exception)
  {
      print_r($exception->getMessage());
  }
