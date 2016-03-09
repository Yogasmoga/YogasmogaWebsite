<?php
    if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){

        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];

        if($username=="physical" && $password=="store") {

            $_SESSION['token'] = date('Ymdhis');

            echo json_encode(array('message' => 'correct', 'token' => $_SESSION['token']));
        }
        else
            echo json_encode(array('message' => 'wrong'));
    }
    else
        echo json_encode(array('message' => 'invalid'));