<?php
session_start();

//unset($_SESSION["bullseye"]);
//unset($_SESSION["new_customer"]);

if(!isset($_SESSION["new_customer"])){
    $_SESSION["new_customer"] = "new";
}
else{
    $_SESSION["new_customer"] = "old";
}
if(!isset($_SESSION["bullseye"])){
    $_SESSION["bullseye"] = "open";
}
else{
    $_SESSION["bullseye"] = "closed";
}
$array = array(
    "customer"=>$_SESSION["new_customer"],
    "bullseye"=>$_SESSION["bullseye"]
);

 echo json_encode($array);