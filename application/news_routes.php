<?php
################################################################ News admin routes start
Slim::get('/admin/news/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/news/all_records');
});

Slim::get('/admin/news/new/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/news/new');
});

Slim::get('/admin/news/:id/', function($id){
    if(userloggedin())
    {
	$sql = "SELECT * FROM news WHERE id = :id";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(':id' => $id));
	$result = $statement->fetch(PDO::FETCH_ASSOC);
	Storage::instance()->content = template('admin/news/edit', array('id' => $id, 'result' => $result));
    }
});

Slim::get('/admin/news/:id/delete/', function($id){
    if(userloggedin())
    {
  	$sql = "DELETE FROM `opentaps`.`news` WHERE  `news`.`id` =:id";
  	$statement = Storage::instance()->db->prepare($sql);

  	$statement->execute(array(':id' => $id));
	Storage::instance()->content = "
		News deleted successfully.
		<meta http-equiv='refresh' content='1; url=" . href("admin/news") . "' />
	";
    }
});


Slim::post('/admin/news/create/', function(){
    if(userloggedin())
    {
  	$sql = "INSERT INTO  `opentaps`.`news` (`parent_id`, `name`, `short_name`) VALUES(:parent_id, :name, :short_name)";
  	$statement = Storage::instance()->db->prepare($sql);

  	$statement->execute(array(
 		':short_name' => $_POST['m_short_name'],
 		':name' => $_POST['m_name'],
 		':parent_id' => $_POST['m_parent_id']
 	));
	Storage::instance()->content = "
		News <b><i>" . $_POST['m_name'] . "</i></b> added successfully.
		<br />
		<a href=\"" . href("admin/news/". Storage::instance()->db->lastInsertId()) . "\">Edit</a>
		<br />
		<a href=\"" . href("admin/news") . "\">Back to news list</a>
	";
    }
});
Slim::post('/admin/news/:id/update/', function($id){
    if(userloggedin())
    {
  	$sql = "
	UPDATE  `opentaps`.`news` SET  `parent_id` =  :parent_id, `short_name` =  :short_name, `name` =  :name WHERE  `news`.`id` =:id
	 ";
  	$statement = Storage::instance()->db->prepare($sql);

  	$statement->execute(array(
 		':id' => $id,
 		':short_name' => $_POST['m_short_name'],
 		':name' => $_POST['m_name'],
 		':parent_id' => $_POST['m_parent_id']
 	));
	Storage::instance()->content = "
		News <b><i>" . $_POST['m_name'] . "</i></b> updated successfully.
		<br />
		<a href=\"" . href("admin/news/". $id) . "\">Edit</a>
		<br />
		<a href=\"" . href("admin/news") . "\">Back to News list</a>
	";
    }
});
################################################################ News admin routes end
