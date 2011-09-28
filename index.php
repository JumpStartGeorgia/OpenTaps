<?php
/*$fh = fopen('settlements/settlements.shp.xml', 'r');
$xml = fread($fh, filesize('settlements/settlements.shp.xml'));
fclose($fh);
$xml = new SimpleXMLElement($xml);
print_r(json_encode($xml));
die;*/

session_start();

define('DIR', getcwd() . '/');
define('URL', 'http://localhost/OpenTaps/');

error_reporting(E_ALL);

require_once DIR . 'application/storage.php';
Storage::instance()->config = require DIR . 'application/config.php';
require_once DIR . 'application/firephp/fb.php';

$languages = array('en', 'ka');
$default_lang = 'ka';
$lang = (isset($_GET['lang']) AND in_array($_GET['lang'], $languages)) ? $_GET['lang'] : $default_lang;
define('LANG', $lang);

require_once DIR . 'application/functions.php';


try
{
    Storage::instance()->db = new PDO('mysql:dbname=opentaps;host=localhost', config('db_user'), config('db_pass'));
    Storage::instance()->db->prepare("SET NAMES 'utf8'")->execute();
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
$sql_organizations = "SELECT * FROM organizations WHERE lang = '" . LANG . "';";
Storage::instance()->viewsubmenu = template('submenu', array(
	'submenus' => read_submenu(),
	'projects' => read_projects(),
	'organizations' => fetch_db($sql_organizations)));
Storage::instance()->content = template('home');
Storage::instance()->show_map = TRUE;

$unique = config('about_us_menu_unique');
$query = "SELECT text FROM menu WHERE `unique` = :unique AND lang = '" . LANG . "' LIMIT 1;";
$query = db()->prepare($query);
$query->execute(array(':unique' => $unique));
$about_us = $query->fetch(PDO::FETCH_ASSOC);
$about_us = $about_us['text'];


require_once DIR . 'application/routes/default_routes.php';
require_once DIR . 'application/routes/irakli_routes.php';
require_once DIR . 'application/routes/projects_routes.php';

require_once DIR . 'application/routes/organization_routes.php';

require_once DIR . 'application/routes/tags_routes.php';

require_once DIR . 'application/routes/menu_routes.php';

require_once DIR . 'application/routes/news_routes.php';

require_once DIR . 'application/routes/region_routes.php';

Slim::run();

echo template('layout', array('about_us' => $about_us, 'slide_news' => read_news()));
