<?php
$file = $_REQUEST['file'];

$file_url = "http://admin.yogasmoga.com/var/export/" . $file;
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
readfile($file_url);
?>