<?php 

//var_dump($_POST);
$challenge = $_REQUEST['hub_challenge'];
$token = $_REQUEST['hub_verify_token'];



if($token === 'shiva_123'){

	echo $challenge;
}
?>