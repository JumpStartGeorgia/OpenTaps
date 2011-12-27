<?php

/*
 *
 * To all those geeks who try to dig deep inside a source code:
 * Life's short, save your nerves and health!
 *
 */

define('DIR', getcwd() . '/');

if (!isset($_SESSION) OR (isset($_SESSION) AND empty($_SESSION)))
    session_start();

require_once DIR . 'application/storage.php';

// Environments: Start
$environments = array(
    'localhost.com' => 'development',
    'deda.jumpstart.ge' => 'testing',
    'opentaps.ge' => 'production'
);
foreach ($environments AS $uri => $env)
{
    if (strpos($_SERVER['SERVER_NAME'], $uri) === FALSE)
        continue;
    define('ENV', $env);
    break;
}
defined('ENV') OR define('ENV', key($environments));
$env_config = DIR . 'application/config_' . ENV . '.php';
file_exists($env_config) OR exit('Environment configuration not found.');
Storage::instance()->config_env = require_once $env_config;
// Environments: End

error_reporting(Storage::instance()->config_env['error_level']);

define('URL', Storage::instance()->config_env['url']);

Storage::instance()->config = require_once DIR . 'application/config.php';
require_once DIR . 'application/firephp/fb.php';

require_once DIR . 'application/Slim/Slim.php';
Slim::init();

$has_lang = (isset($_GET['lang']) AND in_array($_GET['lang'], array('en', 'ka')));
if (!$has_lang)
{
    if (FALSE === strpos(Slim_Http_Uri::getUri(TRUE), 'map-data/'))
    {
        if (empty($_SERVER['QUERY_STRING']))
            $url = '?lang=ka';
        else
        {
            parse_str($_SERVER['QUERY_STRING'], $parts);
            $url = '?' . http_build_query(array('lang' => 'ka') + $parts);
        }
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . URL . ltrim(Slim_Http_Uri::getUri(TRUE), '/') . $url);
        exit;
    }
    else
        $_GET['lang'] = 'ka';
}
define('LANG', $_GET['lang']);

Storage::instance()->language_items = require_once DIR . 'application/languages/' . LANG . '.php';

require_once DIR . 'application/functions.php';

try
{
    $db_conf = Storage::instance()->config_env['db'];
    Storage::instance()->db = new PDO('mysql:dbname=' . $db_conf['name'] . ';host=' . $db_conf['host'], $db_conf['user'], $db_conf['pass']);
    Storage::instance()->db->prepare('SET NAMES utf8;')->execute();
    Storage::instance()->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $exception)
{
    exit($exception->getMessage());
}

Storage::instance()->title = 'Home Page';
Storage::instance()->show_map = $homepage = (Slim_Http_Uri::getUri(TRUE) === '/');
Storage::instance()->show_chart = array('home' => $homepage);
Storage::instance()->show_export = false;

if (Slim::request()->isGet())
{
    Storage::instance()->menu = read_menu();
    Storage::instance()->viewmenu = template('menu');
    Storage::instance()->viewsubmenu = template('submenu', array(
        'submenus' => read_submenu(),
        'projects' => read_projects(FALSE, 14),
        'organizations' => fetch_db("SELECT * FROM organizations WHERE lang = '" . LANG . "' AND hidden = 0;")
            ));
    Storage::instance()->content = template('home', array('home_chart_data' => home_chart_data()));
}

foreach (glob(DIR . 'application/routes/*.php') AS $route)
    require_once $route;

if (Slim::request()->isGet())
{
    $about_uniques = config('about_us_uniques');
    $about_sql = "SELECT text FROM menu WHERE `unique` = ";
    $lang_sql = "AND lang = '" . LANG . "' LIMIT 1;";
}

Slim::run();

if (Slim::request()->isGet())
{
    echo template('layout', array(
        'about_us' => array(
            'main' => fetch_db("{$about_sql} '{$about_uniques['main']}' {$lang_sql}", NULL, TRUE),
            'open_information' => fetch_db("{$about_sql} '{$about_uniques['open_information']}' {$lang_sql}", NULL, TRUE),
            'participation' => fetch_db("{$about_sql} '{$about_uniques['participation']}' {$lang_sql}", NULL, TRUE),
            'innovation' => fetch_db("{$about_sql} '{$about_uniques['innovation']}' {$lang_sql}", NULL, TRUE)
        ),
        'slide_news' => fetch_db("SELECT * FROM news WHERE lang = '" . LANG . "' AND show_in_slider = 1 ORDER BY published_at DESC LIMIT 0, 5"),
        'languages' => config('languages')
    ));
}

exit;
// Stop right here!
