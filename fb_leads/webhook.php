<?php 
session_start();
//var_dump($_POST);
$challenge = $_REQUEST['hub_challenge'];
$token = $_REQUEST['hub_verify_token'];



if($token === 'shiva_123'){

	echo $challenge;
}



$input = json_decode(file_get_contents('php://input'),true);
error_log(print_r($input,true));


$msg = var_dump($input);

mail('shivaji.chauhan@yogasmoga.com','from : shivaji',$msg);

?>