<?php
//Created By Fahim Khan. For Share smogi bucks.

require 'app/Mage.php';
$app = Mage::app('');

$email = Mage::app()->getRequest()->getparam('email');

$response = array(
    "status" => 'error',
    "error" => '',
    "success_message" => ""
);


if($email){

   //MailChimp
    $apikey = 'e49184c3866b4d458797fdffe11f22d8-us3';
    $list_id = "9654d81eb8"; //New List for share smogi bucks.

    $auth = base64_encode( 'user:'.$apikey );

    $data = array(
        'apikey'        => $apikey,
        'email_address' => $email,
        'status'        => 'subscribed',
        'merge_fields'  => array(
           // 'ORIGIN' => 'Mailchimp' // for test
            'MAILSOURCE' => 'Mailchimp' //for live and for new list
        )
    );
    $json_data = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://us3.api.mailchimp.com/3.0/lists/'.$list_id.'/members/');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Basic '.$auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

    $result = curl_exec($ch);

    //Mage::log("mail responce = ".print_r($result,true), null, "responce.log");

    //error_log(print_r($result,true));

    $res = json_decode($result);

    //Mage::log("mail responce = ".print_r($res,true), null, "responce.log");

    if($res->status == 'subscribed'){
        $response['status'] = 'success';
        $response['success_message'] = $res->email_address;
        echo json_encode($response);
    }else{

        $response['status'] = "error";
        if($res->status == '400'){
            $response['error'] = "You are already shared.";
        }else{
            $response['error'] = $res->title;
        }
        echo json_encode($response);

    }





}else{
    $response['status'] = "error";
    $response['error'] = "No Email Recieved";

}


?>