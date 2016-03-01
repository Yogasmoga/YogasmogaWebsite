<?php
$challenge = $_REQUEST['hub_challenge'];
$token = $_REQUEST['hub_verify_token'];

if($token=='abc123'){
    echo $challenge;
}