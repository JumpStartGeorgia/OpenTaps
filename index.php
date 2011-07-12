<?php

define('DIR', getcwd() . '/');
define('URL', 'http://www.localhost.com/OpenTaps/');


require_once DIR . 'application/storage.php';
require_once DIR . 'application/functions.php';

require_once DIR . 'application/Slim/Slim.php';
Slim::init();

Storage::instance()->title = 'Home Page';

require_once DIR . 'application/routes.php';

Slim::run();

echo template('layout');
