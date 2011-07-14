<?php
################################################################ Menu admin routes start
Slim::get('/admin/menu/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/menu/all_records');
});

Slim::get('/admin/menu/new/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/menu/new');
});

Slim::get('/admin/menu/:id/', function($id){
    if(userloggedin())
    {
	$sql = "SELECT * FROM menu WHERE id = :id";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(':id' => $id));
	$result = $statement->fetch(PDO::FETCH_ASSOC);
	Storage::instance()->content = template('admin/menu/edit', array('id' => $id, 'result' => $result));
    }
});

Slim::get('/admin/menu/:id/delete/', function($id){
    if(userloggedin())
    {
  	$sql = "DELETE FROM `opentaps`.`menu` WHERE  `menu`.`id` =:id";
  	$statement = Storage::instance()->db->prepare($sql);

  	$statement->execute(array(':id' => $id));
	Storage::instance()->content = "
		Menu deleted successfully.
		<meta http-equiv='refresh' content='1; url=" . href("admin/menu") . "' />
	";
    }
});


Slim::post('/admin/menu/create/', function(){
    if(userloggedin())
    {
  	$sql = "INSERT INTO  `opentaps`.`menu` (`parent_id`, `name`, `short_name`) VALUES(:parent_id, :name, :short_name)";
  	$statement = Storage::instance()->db->prepare($sql);

  	$statement->execute(array(
 		':short_name' => $_POST['m_short_name'],
 		':name' => $_POST['m_name'],
 		':parent_id' => $_POST['m_parent_id']
 	));
	Storage::instance()->content = "
		Menu <b><i>" . $_POST['m_name'] . "</i></b> added successfully.
		<br />
		<a href=\"" . href("admin/menu/". Storage::instance()->db->lastInsertId()) . "\">Edit</a>
		<br />
		<a href=\"" . href("admin/menu") . "\">Back to menu list</a>
	";
    }
});
Slim::post('/admin/menu/:id/update/', function($id){
    if(userloggedin())
    {
  	$sql = "
	UPDATE  `opentaps`.`menu` SET  `parent_id` =  :parent_id, `short_name` =  :short_name, `name` =  :name WHERE  `menu`.`id` =:id
	 ";
  	$statement = Storage::instance()->db->prepare($sql);

  	$statement->execute(array(
 		':id' => $id,
 		':short_name' => $_POST['m_short_name'],
 		':name' => $_POST['m_name'],
 		':parent_id' => $_POST['m_parent_id']
 	));
	Storage::instance()->content = "
		Menu <b><i>" . $_POST['m_name'] . "</i></b> updated successfully.
		<br />
		<a href=\"" . href("admin/menu/". $id) . "\">Edit</a>
		<br />
		<a href=\"" . href("admin/menu") . "\">Back to menu list</a>
	";
    }
});
################################################################ Menu admin routes end
