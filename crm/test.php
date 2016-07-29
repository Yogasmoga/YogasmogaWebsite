<?php
/**
 * Created by PhpStorm.
 * User: BlankO
 * Date: 29-07-2016
 * Time: 12:08 PM
 */

$servername = "yogasmoga.ctfwon1h9dxc.us-east-1.rds.amazonaws.com";
$username = "yogasmoga";
$password = "Yoga$moga";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";