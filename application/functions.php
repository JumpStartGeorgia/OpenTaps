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
