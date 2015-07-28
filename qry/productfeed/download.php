<?php
$root = "admin.yogasmoga.com";
$file_url = "http://$root/productfeed/result.txt";
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
readfile($file_url);
?>