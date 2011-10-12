<?php

if (!isset($_SESSION) OR (isset($_SESSION) AND empty($_SESSION)))
    session_start();

error_reporting(E_ALL);

define('DIR', getcwd() . '/');

require_once DIR . 'application/storage.php';

// Declare and define environments by URI string.
foreach (array(
 'localhost.com' => 'development',
 'deda.omc.ge' => 'testing',
 'opentaps.ge' => 'production'
) AS $uri => $env)
{
    if (strpos($_SERVER['SERVER_NAME'], $uri) === FALSE)
        continue;
    define('ENV', $env);
    break;
}
defined('ENV') OR define('ENV', 'development');
$env_config = DIR . 'application/config_' . ENV . '.php';
file_exists($env_config) OR exit('Environment configuration not found.');
Storage::instance()->config_env = require_once $env_config;


define('URL', Storage::instance()->config_env['url']);

Storage::instance()->config = require_once DIR . 'application/config.php';
/*require_once DIR . 'application/firephp/fb.php';*/

define('LANG', (isset($_GET['lang']) AND in_array($_GET['lang'], array('en', 'ka'))) ? $_GET['lang'] : 'ka');

Storage::instance()->language_items = require_once DIR . 'application/languages/' . LANG . '.php';

require_once DIR . 'application/functions.php';

try
{
    $db_conf = Storage::instance()->config_env['db'];
    Storage::instance()->db = new PDO('mysql:dbname=' . $db_conf['name'] . ';host=' . $db_conf['host'], $db_conf['user'], $db_conf['pass']);
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
Storage::instance()->show_map = (strpos($_SERVER['REQUEST_URI'], '/admin/') !== FALSE) ? FALSE : TRUE;
Storage::instance()->viewsubmenu = template('submenu', array(
    'submenus' => read_submenu(),
    'projects' => read_projects(),
    'organizations' => fetch_db("SELECT * FROM organizations WHERE lang = '" . LANG . "';")
));
Storage::instance()->content = template('home');

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
    'slide_news' => read_news(),
    'languages' => config('languages')
));
