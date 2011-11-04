<?php

$file = (isset ($_GET['file']) AND !empty($file)) ? 'mappings/' . $_GET['file'] : FALSE;

if (FALSE === $file OR !file_exists($file))
    return;

ob_start('gzhandler');

echo file_get_contents($file);

ob_end_flush();
