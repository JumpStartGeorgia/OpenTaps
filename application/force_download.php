<?php

header('Content-Type: image/png');
//header ( 'Content-Length: 1234' );
header('Content-Disposition: attachment;filename="' . $_GET['name'] . '"');
$fp = fopen(base64_decode($_GET['image']), 'r');
fpassthru($fp);
fclose($fp);

