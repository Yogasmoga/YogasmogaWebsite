<?php
$challenge = $_REQUEST['hub_challenge'];
$token = $_REQUEST['hub_verify_token'];

if($token=='abc123'){
    echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);
error_log(print_r($input, true));