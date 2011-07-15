<?php

function template($view, $vars = array())
{
    ob_start();
    empty($vars) OR extract($vars);
    require_once DIR . 'application/templates/' . $view . '.php';
    return ob_get_clean();
}

function config($item)
{
    return isset(Storage::instance()->config[$item]) ? Storage::instance()->config[$item] : FALSE;
}

function href($segments = NULL)
{
    return URL . ltrim($segments, '/') . "/";
}

function authenticate($username, $password)
{
    $sql = "SELECT id, username FROM users WHERE username = :username AND password = :password";
    $statement = Storage::instance()->db->prepare($sql);
    $statement->execute(array(
        ':username' => $username,
        ':password' => sha1($password)
    ));

    return ($statement->columnCount() == 2) ? $statement->fetch(PDO::FETCH_ASSOC) : FALSE;
}

function userloggedin()
{
    return (isset($_SESSION['id']) && isset($_SESSION['username']));
}

								### MENU MANAGEMENT
function read_menu($parent_id = 0, $lang = null)
{
    $sql = "SELECT id,name,short_name FROM menu WHERE parent_id = :parent_id";
    $statement = Storage::instance()->db->prepare($sql);
    $statement->execute(array(':parent_id' => $parent_id));
    return $statement->fetchAll();    
}

function add_menu($name, $short_name, $parent_id)
{
    if( strlen($name) < 2 )
	return false;

    $sql = "INSERT INTO  `opentaps`.`menu` (`parent_id`, `name`, `short_name`) VALUES(:parent_id, :name, :short_name)";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':name' => $name,
 	':short_name' => $short_name,
 	':parent_id' => $parent_id
    ));

    return ($exec) ? true : false;
}

function update_menu($id, $name, $short_name, $parent_id)
{
    if( strlen($name) < 2 || !is_numeric($id) )
	return false;

    $sql = "UPDATE `menu` SET  `parent_id` =  :parent_id, `short_name` =  :short_name, `name` =  :name WHERE  `menu`.`id` =:id";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':id' => $id,
 	':short_name' => $short_name,
 	':name' => $name,
 	':parent_id' => $parent_id
    ));

    return ($exec) ? true : false;
}

function delete_menu($id)
{
    if( !is_numeric($id) )
	return false;

    $sql = "DELETE FROM `opentaps`.`menu` WHERE  `menu`.`id` =:id";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':id' => $id
    ));

   return ($exec) ? true : false;
}
								### NEWS MANAGEMENT
function read_news($limit = false, $news_id = false)
{
    if($news_id)
    {
	$sql = "SELECT * FROM news WHERE id = :news_id";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(':news_id' => $news_id));
    }
    else
    {
	$sql = ( $limit ) ? "SELECT * FROM news LIMIT :limit" : "SELECT * FROM news";
	$arr = ( $limit ) ? array(':limit' => $limit) : null;
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute($arr);
    }
    return $statement->fetchAll();
}

function add_news($title, $body)
{
    if( strlen($title) < 3 || strlen($body) < 11 )
	return false;

    $sql = "INSERT INTO  `opentaps`.`news` (`title`, `body`, `published_at`) VALUES(:title, :body, :published_at)";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':title' => $title,
 	':body' => $body,
 	':published_at' => date("Y-m-d")
    ));

    return ($exec) ? true : false;
}

function update_news($id, $title, $body)
{
    if( strlen($title) < 3 || strlen($body) < 11 || !is_numeric($id) )
	return false;

    $sql = "UPDATE  `opentaps`.`news` SET  `title` =  :title, `body` =  :body WHERE  `news`.`id` =:id";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':id' => $id,
 	':title' => $title,
 	':body' => $body,
    ));

    return ($exec) ? true : false;
}

function delete_news($id)
{
    if( !is_numeric($id) )
	return false;

    $sql = "DELETE FROM `opentaps`.`news` WHERE  `news`.`id` =:id";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':id' => $id
    ));

   return ($exec) ? true : false;
}
