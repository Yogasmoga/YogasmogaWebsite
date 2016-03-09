<?php
    if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){

        require '../app/Mage.php';

        Mage::app();

        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];

        if($username=="physical" && $password=="store") {

            $token = date('Ymdhis');

            Mage::getSingleton('core/session')->setToken($token);

            echo json_encode(array('message' => 'correct', 'token' => Mage::getSingleton('core/session')->getToken()));
        }
        else
            echo json_encode(array('message' => 'wrong'));
    }
    else
        echo json_encode(array('message' => 'invalid'));