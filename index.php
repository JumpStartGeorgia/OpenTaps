<?php
session_start();

define('DIR', getcwd() . '/');
define('URL', 'http://localhost.com/OpenTaps/');

error_reporting(E_ALL);

require_once DIR . 'application/storage.php';
Storage::instance()->config = require DIR . 'application/config.php';
require_once DIR . 'application/functions.php';
try
{
    Storage::instance()->db = new PDO('mysql:dbname=opentaps;host=localhost', config('db_user'), config('db_pass'));
}
catch (PDOException $exception)
{
    exit($exception->getMessage());
}

require_once DIR . 'application/Slim/Slim.php';
Slim::init();

Storage::instance()->title = 'Home Page';
Storage::instance()->menu = read_menu();
Storage::instance()->viewmenu = template('menu');
Storage::instance()->viewsubmenu = template('submenu', array('submenus' => read_submenu()));
Storage::instance()->content = template('home');
Storage::instance()->show_map = TRUE;

require_once DIR . 'application/routes/default_routes.php';
require_once DIR . 'application/routes/irakli_routes.php';
require_once DIR . 'application/routes/projects_routes.php';
require_once DIR . 'application/routes/organization_routes.php';
require_once DIR . 'application/routes/tags_routes.php';
require_once DIR . 'application/routes/menu_routes.php';
require_once DIR . 'application/routes/news_routes.php';
require_once DIR . 'application/routes/region_routes.php';

Slim::run();

echo template('layout');
