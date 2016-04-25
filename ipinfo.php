<?php
//$root = Mage::getBaseDir();

require_once('Ipinfo/Host.php');
require_once('Ipinfo/Ipinfo.php');


$ipInfo = new Ipinfo\Ipinfo();

if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
    echo $ip = $_SERVER['HTTP_CLIENT_IP'];echo " - 1";
} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    echo $ips = $_SERVER['HTTP_X_FORWARDED_FOR'];echo " - 2 ,";
    echo "<pre/>";
    var_dump($ips_array = explode(',',$ips));
    echo $ip = $ips_array[0];
} else {
    echo $ip = $_SERVER['REMOTE_ADDR'];echo " - 3";
}


echo "<pre/>";
var_dump($host = $ipInfo->getYourOwnIpDetails());

if (isset($host)) {
    $request_city = $host->getCity();
    $request_state = $host->getRegion();
    $request_zip = $host->getPostal();
}
else {
    $request_city = "N/A";
    $request_state = "N/A";
    $request_zip = "N/A";
}


echo "City "." -".$request_city."<br/>";
echo "State "." -".$request_state."<br/>";
echo "Zip "." -".$request_zip."<br/>";
?>