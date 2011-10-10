<?php

if (!isset($_SESSION) OR (isset($_SESSION) AND empty($_SESSION)))
    session_start();

define('DIR', getcwd() . '/');
define('URL', 'http://localhost/OpenTaps/');

error_reporting(E_ALL);

require_once DIR . 'application/storage.php';
Storage::instance()->config = require DIR . 'application/config.php';
require_once DIR . 'application/firephp/fb.php';

define('LANG', (isset($_GET['lang']) AND in_array($_GET['lang'], array('en', 'ka'))) ? $_GET['lang'] : 'ka');

Storage::instance()->language_items = require_once DIR . 'application/languages/' . LANG . '.php';

require_once DIR . 'application/functions.php';

try
{
    Storage::instance()->db = new PDO('mysql:dbname=' . config('db_name') . ';host=' . config('db_host'), config('db_user'), config('db_pass'));
    Storage::instance()->db->prepare('SET NAMES utf8;')->execute();
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
Storage::instance()->viewsubmenu = template('submenu', array(
    'submenus' => read_submenu(),
    'projects' => read_projects(),
    'organizations' => fetch_db("SELECT * FROM organizations WHERE lang = '" . LANG . "';")
        ));
Storage::instance()->content = template('home');
Storage::instance()->show_map = TRUE;

foreach (glob(DIR . 'application/routes/*.php') AS $route)
    require_once $route;

$about_uniques = config('about_us_uniques');
$about_sql = "SELECT text FROM menu WHERE `unique` = ";
$lang_sql = "AND lang = '" . LANG . "' LIMIT 1;";

Slim::run();

echo template('layout', array(
    'about_us' => array(
        'main' => fetch_db("{$about_sql} '{$about_uniques['main']}' {$lang_sql}", NULL, TRUE),
        'open_information' => fetch_db("{$about_sql} '{$about_uniques['open_information']}' {$lang_sql}", NULL, TRUE),
        'participation' => fetch_db("{$about_sql} '{$about_uniques['participation']}' {$lang_sql}", NULL, TRUE),
        'innovation' => fetch_db("{$about_sql} '{$about_uniques['innovation']}' {$lang_sql}", NULL, TRUE)
    ),
    'slide_news' => read_news()
));
