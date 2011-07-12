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

function authenticate($username, $password)
{
    $sql = "SELECT id, username FROM users WHERE username = :username AND password = :password LIMIT 1;";
    $statement = Storage::instance()->db->prepare($sql);
    $statement->execute(array(
        ':username' => $username,
        ':password' => sha1($password)
    ));
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if(strlen($result['username']) > 3 && $result['id'] > 0)
	return $result;
    else
	return false;
}
