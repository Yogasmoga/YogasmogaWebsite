<?php
require('DavidePastore\Ipinfo\Ipinfo.php');
require('DavidePastore\Ipinfo\Host.php');

$ipInfo = new DavidePastore\Ipinfo\Ipinfo();

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$host = $ipInfo->getFullIpDetails($ip);

echo "<pre>";
print_r($host);
echo "</pre>";