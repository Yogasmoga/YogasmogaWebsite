<?php


require 'app/Mage.php';
$app = Mage::app('');





//$post = Mage::app()->getRequest()->getPost();
//echo "<pre/>";
//print_r($post);

//exit;
$response = array(
            "status" => 'error',
            "error" => '',
            "success_message" => ""
        );
if(Mage::app()->getRequest()->isPost()){
		$email = Mage::app()->getRequest()->getPost('email');		
		if($email){
		$fname = Mage::app()->getRequest()->getPost("firstname");
		$lname = Mage::app()->getRequest()->getPost("lastname");
		$gender = Mage::app()->getRequest()->getPost("gender");
		if($gender == 2){
			$gender = "Female";
		}
		elseif($gender == 1){
			$gender = "Male";
		}

		//$email  =  $_POST['email'];
		//echo $email;
		//exit;	
			//MailChimp
			//$apikey = 'e49184c3866b4d458797fdffe11f22d8-us3';
			//$list_id = "ca4e5865d6"; //TEST
			//$list_id = "51f988d786"; //LIVE
			//$list_id = "40611aba4e"; //New List--recent
			$apikey = '57207d2b7f3567e409649541d591ca33-us3';//api key.
			$list_id = "51f988d786"; //New List.
			//$list_id = "9654d81eb8";

					$auth = base64_encode( 'user:'.$apikey );

					$data = array(
						'apikey'        => $apikey,
						'email_address' => $email,
						'status'        => 'subscribed',
						'merge_fields'  => array(
							//'ORIGIN' => 'Mailchimp' // for test
						   'MAILSOURCE' => 'Mailchimp', //for live and for new list
						   'FNAME' => $fname,
						   'LNAME' => $lname,
						   'GENDER' => $gender
						   
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
						$response['error'] = "You are already subscribed.";
						}else{
						$response['error'] = $res->title;
						}
						echo json_encode($response);

					}

					

			

		}else{
			$response['status'] = "error";
			$response['error'] = "No Email Recieved";

		}

}
?>