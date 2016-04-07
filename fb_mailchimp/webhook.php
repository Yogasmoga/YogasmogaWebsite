<?php  //error_reporting(E_ALL);
/*$access_token = 'EAAHpJxZAzidkBAPmDXm3VYLZB3RzJ19DayRuThSdrZCjZBV4XKqpIOVPF5X8lWwY8OYXtwQXPZAL2u2hq074vBOGGrCNNZAZAAzXN1GCuqI9hT5WKSjw4lQ1I3CpzI8vK9ZA5mU6MhkKCYZBfWHc7OFQcrsla1ZBeTlXoZD';
$app_id = '537829066377689';
$app_secret = '2a8cd1b41e7c2ba1a27a33e5a6bc5c7c';

$loader = require_once('vendor/autoload.php');
*/

$challenge = $_REQUEST['hub_challenge'];
$token = $_REQUEST['hub_verify_token'];

if($token === 'shiva_123'){

	echo $challenge;
}


/*use FacebookAds\Api;
use FacebookAds\Object\Lead;

// Initialize a new Session and instanciate an Api object
Api::init($app_id, $app_secret, $access_token);

// The Api object is now available trough singleton
$api = Api::instance();





$input = json_decode(file_get_contents('php://input'),true);

$leads = array();
$leads = $input['entry']['0']['changes'];

foreach($leads as $lead){

$lead_id = $lead['value']['leadgen_id'];


if(!empty($lead_id)){


	
	$form = new Lead($lead_id);
	$lead_data = $form->read();
	$data = $lead_data->getData();
	
	$firstname = $data['field_data']['0']['values']['0'];
	$lastname  = $data['field_data']['1']['values']['0'];
	$email     = $data['field_data']['2']['values']['0'];
	$zipcode   = $data['field_data']['3']['values']['0'];
	$gender    = $data['field_data']['4']['values']['0'];
	
	//error_log(print_r($firstname,true));
	//MailChimp
	$apikey = 'e49184c3866b4d458797fdffe11f22d8-us3';
	$list_id = "ca4e5865d6";

            $auth = base64_encode( 'user:'.$apikey );

            $data = array(
                'apikey'        => $apikey,
                'email_address' => $email,
                'status'        => 'subscribed',
                'merge_fields'  => array(
                    'FNAME' => $firstname, 
					'LNAME' => $lastname,
					'ORIGIN' => 'Facebook ads',
					'GENDER' => $gender,
					'ZIPCODE' => $zipcode
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

            
			error_log(print_r($result,true));
            //die('Mailchimp executed');
}

}
?>