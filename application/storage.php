<?php

class Storage
{

    private $_storage = array();
    protected static $instance;

    public static function instance()
    {
        NULL === self::$instance AND self::$instance = new self;
        return self::$instance;
    }

    public function __set($name, $value = NULL)
    {
        $this->_storage[$this->_sanitize($name)] = $value;
    }

    public function __get($name)
    {
        return isset($this->_storage[$this->_sanitize($name)]) ? $this->_storage[$this->_sanitize($name)] : FALSE;
    }

    public function __unset($name)
    {
        if (!isset($this->_storage[$this->_sanitize($name)]))
            return FALSE;
        unset($this->_storage[$this->_sanitize($name)]);
        return TRUE;
    }

    public function __isset($name)
    {
        return (array_key_exists($name, $this->_storage));
    }

    private function _sanitize($key)
    {
        return trim((string) $key);
    }

    private function __construct()
    {

    }

}

