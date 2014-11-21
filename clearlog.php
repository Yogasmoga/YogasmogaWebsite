<?php
$filename = 'var/log/system.log';

$file = fopen($filename, "a+");
ftruncate($file,100);
fclose($file);
?>