<?php

session_start();
echo sha1('password');
define('DIR', getcwd() . '/');
define('URL', 'http://www.localhost.com/OpenTaps/');

require_once DIR . 'application/storage.php';
Storage::instance()->config = require DIR . 'application/config.php';
require_once DIR . 'application/functions.php';

try
{
    Storage::instance()->db = new PDO('mysql:dbname=opentaps;host=127.0.0.1', config('db_user'), config('db_pass'));
}
catch (PDOException $exception)
{
    exit($exception->getMessage());
}

require_once DIR . 'application/Slim/Slim.php';
Slim::init();

Storage::instance()->title = 'Home Page';
Storage::instance()->content = template('home');

require_once DIR . 'application/routes.php';

Slim::run();

echo template('layout');
