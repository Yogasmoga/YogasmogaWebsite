<?php
error_reporting(0);
ini_set("memory_limit", "-1");
set_time_limit(0);


require '../vendor/autoload.php';

$location_id = 'REPLACE_ME';

$access_token = 'sq0atp-DTuNrNZytik1cfSU850jIw';//live

//$access_token = 'sq0atb-o8YyBc5M42gDiNvRYTDHiQ';//sandbox

$object = new \SquareConnect\ObjectSerializer();

$customers_api = new \SquareConnect\Api\CustomerApi();




$url = "http://staging.yogasmoga.com/crm/service/v4_1/soap.php?wsdl";
$username = "soap";
$password = "soap";

require_once("../crm/ys/lib/nusoap.php");

$client = new nusoap_client($url, 'wsdl');

$err = $client->getError();
if ($err) {
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
    exit();
}

$login_parameters = array(
  'user_auth' => array(
      'user_name' => $username,
      'password' => md5($password),
      'version' => '1'
            ),
      'application_name' => '',
      'name_value_list' => array(),
);

$login_result = $client->call('login', $login_parameters);



global $data;
$i=0;

try {
		do{
		  $result = $customers_api->listCustomers($access_token,$data->cursor);
		 
		  $object = new \SquareConnect\ObjectSerializer();
		  $data = $object->sanitizeForSerialization($result);
		  foreach($data->customers as $customer){
		  
			if (isset($login_result) && isset($login_result['id'])) {

            $session_id = $login_result['id'];

            if (isset($session_id)) {

                
					if(isset($customer->email_address) && !empty($customer->email_address)){

                    $email = $customer->email_address;

                    try {

                        /****** find person by email ******/
                        $contacts = $client->call('get_entry_list', array(
                            $session_id,
                            'Contacts',
                            "contacts.id in (
            SELECT eabr.bean_id
                FROM email_addr_bean_rel eabr JOIN email_addresses ea
                    ON (ea.id = eabr.email_address_id)
                WHERE eabr.deleted=0 AND ea.email_address = '" . $email . "')",
                            '',
                            0,
                            array(),
                            10,
                            -1
                        ));

                    } catch (SoapFault $fault) {
                        echo "Cannot read customer data for email : " . $email . "<br/><br/>";
                        continue;
                    }

                    if (!isset($contacts["entry_list"][0]["id"])){
                        // we need to create contact

                        $contact_parameters = array(
                            "session" => $session_id,
                            "module_name" => 'Contacts',
                            "name_value_list" => array(
                                array("name" => 'email1', "value" => $customer->email_address),
                                array("name" => 'first_name', "value" => $customer->given_name),
                                array("name" => 'last_name', "value" => $customer->family_name),
								array("name" => 'phone_mobile', "value" => $customer->phone_number),
                                array("name" => 'location_city_c', "value" => $customer->locality),
								array("name" => 'location_state_c', "value" => $customer->administrative_district_level_1),
                                array("name" => 'location_zip_c', "value" => $customer->postal_code),
								array("name" => 'note_c', "value" => $customer->note),
								array("name" => 'square_id_c', "value" => $customer->id),
                                array("name" => 'create_source_c', "value" => 'Square'),
                                array("name" => 'date_entered', "value" => date('Y-m-d h:i:s')),
                                array("name" => 'date_modified', "value" => date('Y-m-d h:i:s')),
                                array("name" => 'modified_user_id', "value" => "1"),
                                array("name" => 'modified_by_name', "value" => "Administrator"),
                                array("name" => 'created_by', "value" => "1"),
                                array("name" => 'created_by_name', "value" => "Administrator"),
                            ));

                        $response = $client->call('set_entry', $contact_parameters);
                        //echo "<pre>"; print_r($contact_parameters); echo "</pre><hr/>";
                        $contactId = $response['id'];
                    }
                    else{
                       $contactId = $contacts["entry_list"][0]["id"];
					   echo "<pre>Customer Already Exist '".$contactId."'</pre><hr/>";
					}
			}


			}else{
				echo "<pre>Email Not Recieved</pre><hr/>";
			}


		}
$i++;
}

}while(count($data->customers) >= 100 && $data->cursor);

} catch (\SquareConnect\ApiException $e) {
  echo "Caught exception!<br/>";
  print_r("<strong>Response body:</strong><br/>");
  echo "<pre>"; var_dump($e->getResponseBody()); echo "</pre>";
  echo "<br/><strong>Response headers:</strong><br/>";
  echo "<pre>"; var_dump($e->getResponseHeaders()); echo "</pre>";
}


print_r("<strong>Total Records processed: $i </strong><br/>");