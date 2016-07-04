<?php
require_once '../app/Mage.php';
Mage::app();umask(0);

/************************ crm soap **********************/
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
/************************ crm soap **********************/


# Square API V2 library
require '../vendor/autoload.php';

# V1 Unirest PHP library
require_once '../vendor/mashape/unirest-php/src/Unirest.php';

$access_token = 'sq0atp-DTuNrNZytik1cfSU850jIw';//live

//$access_token = 'sq0atb-o8YyBc5M42gDiNvRYTDHiQ';//sandbox

# V1 Config
$connectHost = 'https://connect.squareup.com';

# Standard HTTP headers for every Connect API request
$requestHeaders = array (
	'Authorization' => 'Bearer ' . $access_token,
	'Accept' => 'application/json',
	'Content-Type' => 'application/json'
	);

$object = new \SquareConnect\ObjectSerializer();

$LocationApi = new \SquareConnect\Api\LocationApi();
$transaction_api = new \SquareConnect\Api\TransactionApi();
$customers_api = new \SquareConnect\Api\CustomerApi();

try {
	$result = $LocationApi->listLocations($access_token);
	$data = $object->sanitizeForSerialization($result);

} catch (\SquareConnect\ApiException $e) {
	echo "Caught exception!<br/>";
	print_r("<strong>Response body:</strong><br/>");
	echo "<pre>"; var_dump($e->getResponseBody()); echo "</pre>";
	echo "<br/><strong>Response headers:</strong><br/>";
	echo "<pre>"; var_dump($e->getResponseHeaders()); echo "</pre>";
}
$begin_time = '2016-06-01T00:00:00-08:00';
$end_time   = '2016-06-16T00:00:00-08:00';
if(count($data->locations) > 0){
	foreach($data->locations as $location){
		echo "<pre>";
		echo $location->id;
		echo $location->name;

		try {
			$resultT = $transaction_api->listTransactions($access_token, $location->id, $begin_time, $end_time);
			$dataT = $object->sanitizeForSerialization($resultT);

			$requestPath = $connectHost . '/v1/' . $location->id . '/payments?begin_time=' . $begin_time . '&end_time='.$end_time.'&order=DESC';
                    # Send a GET request to the List Payments endpoint
			$response = Unirest\Request::get($requestPath, $requestHeaders);
                    //print_r($response->body);
                    //print_r($dataT);
			$i= 0;
			if(isset($dataT->transactions)){
				foreach($dataT->transactions as $transection){
					if(isset($transection->tenders[0]->customer_id) && !empty($transection->tenders[0]->customer_id) && $transection->tenders[0]->type != 'NO_SALE'){
						/************** customers ****************/
						$customer_id = $transection->tenders[0]->customer_id;
						if (isset($login_result) && isset($login_result['id'])) {

							$session_id = $login_result['id'];

							if (isset($session_id)) {
								try {

									$get_entry_list_parameters = array(
										'session' => $session_id,
										'module_name' => 'Contacts',
										'query' => "contacts_cstm.square_id_c =  '".$customer_id."'",
										'order_by' => "",
										'offset' => 0,
										'select_fields' => array(),
										'max_results' => 1,
										'deleted' => 0,
										'favorites' => false,
										);
									$contacts = $client->call('get_entry_list', $get_entry_list_parameters);
									$contactId = $contacts["entry_list"][0]["id"];
								} catch (SoapFault $fault) {
									echo "Cannot read customer data for email : " . $customer_id . "<br/><br/>";
									continue;
								}								
							}
						}

						if (!isset($contacts["entry_list"][0]["id"])){
							$square_customer_object = $customers_api->retrieveCustomer($access_token,$customer_id);
							$square_customer = $object->sanitizeForSerialization($square_customer_object);
							//check customer with email
							$get_entry_list_parameters = array(
								'session' => $session_id,
								'module_name' => 'Contacts',
								'query' => "contacts.id in (
								SELECT eabr.bean_id
								FROM email_addr_bean_rel eabr JOIN email_addresses ea
								ON (ea.id = eabr.email_address_id)
								WHERE eabr.deleted=0 AND ea.email_address = '".$square_customer->customer->email_address."')",
								'order_by' => "",
								'offset' => 0,
								'select_fields' => array(),
								'max_results' => 1,
								'deleted' => 0,
								'favorites' => false,
								);
							$contacts = $client->call('get_entry_list', $get_entry_list_parameters);
							$contactId = $contacts["entry_list"][0]["id"];

							if (!isset($contacts["entry_list"][0]["id"])){
                        		//we need to create contact
								$contact_parameters = array(
									"session" => $session_id,
									"module_name" => 'Contacts',
									"name_value_list" => array(
										array("name" => 'email1', "value" => $square_customer->customer->email_address),
										array("name" => 'first_name', "value" => $square_customer->customer->given_name),
										array("name" => 'last_name', "value" => $square_customer->customer->family_name),
										array("name" => 'phone_mobile', "value" => $square_customer->customer->phone_number),
										array("name" => 'location_city_c', "value" => $square_customer->customer->address->locality),
										array("name" => 'location_state_c', "value" => $square_customer->customer->address->administrative_district_level_1),
										array("name" => 'location_zip_c', "value" => $square_customer->customer->address->postal_code),
										array("name" => 'note_c', "value" => $square_customer->customer->note),
										array("name" => 'square_id_c', "value" => $square_customer->customer->id),
										array("name" => 'create_source_c', "value" => 'Square'),
										array("name" => 'date_entered', "value" => date('Y-m-d h:i:s')),
										array("name" => 'date_modified', "value" => date('Y-m-d h:i:s')),
										array("name" => 'modified_user_id', "value" => "1"),
										array("name" => 'modified_by_name', "value" => "Administrator"),
										array("name" => 'created_by', "value" => "1"),
										array("name" => 'created_by_name', "value" => "Administrator"),
										));
								$contact_response = $client->call('set_entry', $contact_parameters);
								$contactId = $contact_response['id'];
							}
						}
						/************** customers ****************/
                    	//print_r($transection->tenders[0]);

						$order_id = $transection->tenders[0]->transaction_id;
						$order_total = number_format(($transection->tenders[0]->amount_money->amount/100),2);
						$customer_id = $transection->tenders[0]->customer_id;
						$response->body[$i]->tender[0]->id;
						$order_total2 = number_format(($response->body[$i]->tender[0]->total_money->amount/100),2);
						$date_closed = $response->body[$i]->created_at;
						//print_r($response->body[$i]);
						
						/********************* Create Order in CRM *************/
						$source = 'Physical - '.$location->name;
						$lead_source = str_replace('Physical - YOGASMOGA \ ','Physical_',$source);
						$lead_source = str_replace(' ','_',$lead_source);

						$order_values = array(
							"session" => $session_id,
							"module_name" => 'Opportunities',
							"name_value_list" => array(
								array("name" => 'name', "value" => 'Square Order #'.$order_id),
								array("name" => 'lead_source', "value" => $lead_source),
								array("name" => 'amount', "value" => $order_total),
								array("name" => 'amount_usdollar', "value" => $order_total),
								array("name" => 'sales_stage', "value" => 'Closed Won'),
								array("name" => 'date_closed', "value" => date('Y-m-d',strtotime($date_closed)))
								));
						$order_response = $client->call('set_entry', $order_values);
						/********************* Create Order in CRM *************/
						/*******************set order to customer relationship************************/
						$opportunityId = $order_response[id];

						$set_relationship_parameters = array(
							'session' => $session_id,
							'module_name' => 'Opportunities',
							'module_id' => "$opportunityId",
							'link_field_name' => 'contacts',
							'related_ids' => array(
								"$contactId",
								),
							'name_value_list' => array(),
							'delete'=> 0,
							);
						$res = $client->call('set_relationship', $set_relationship_parameters);
						/*******************set order to customer relationship************************/

                    	//itemization
						$discount_total = 0;
						foreach ($response->body[$i]->itemizations as $item) {
							$name = $item->name;
							$quantity = (int)$item->quantity;
							$notes = $item->notes;
							$item_variant = explode(',' , $item->item_variation_name);
							$color = $item_variant[0];
							$size = $item_variant[1];
							$sku = $item->item_detail->sku;
							$amount = number_format(($item->single_quantity_money->amount/100),2);

							//var_dump($item);

							/******** Shivaji Chauhan : custom code to get root category *******/
							if(!empty($item->item_detail->sku) && isset($item->item_detail->sku) && Mage::getModel('catalog/product')->loadByAttribute('sku',$item->item_detail->sku)){
								$_product = Mage::getModel('catalog/product')->loadByAttribute('sku',$item->item_detail->sku);

								$parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')->getParentIdsByChild($_product->getId());
								$conf_product = Mage::getModel('catalog/product')->load($parentIds[0]);
								$categoryIds = $conf_product->getCategoryIds();
								foreach ($categoryIds as $category_id) {
									$category = Mage::getModel('catalog/category')->load($category_id);
									//each category has a path attribute
									$path = $category->getPath(); //should look like 1/3/14/23/55.
									//split the path by slash
									$pathParts = explode('/', $path);
									if (count($pathParts) == 3) {
										//it means the category is already a top level category
										$gender =  $category->getName();
										if($gender == 'Men' || $gender == 'Women')
											break;
									}
									elseif (isset($pathParts[2])) {
										$topCategory = Mage::getModel('catalog/category')->load($pathParts[2]);
										$gender =  $topCategory->getName();
										if($gender == 'Men' || $gender == 'Women')
											break;
									}
								}

								if($gender != 'Men' && $gender != 'Women')
								{
									$gender = 'Accessories/GiftCard';
								}

								unset($categoryIds);
							}

							/******** Shivaji Chauhan : custom code to get root category *******/

							$size = isset($size) ? $size : "N/A";
							$product_values = array(
								"session" => $session_id,
								"module_name" => 'YS_Products',
								"name_value_list" => array(
									array("name" => 'name', "value" => $name),
									array("name" => 'sku', "value" => $sku),
									array("name" => 'price', "value" => $amount),
									array("name" => 'color', "value" => $color),
									array("name" => 'size', "value" => $size),
									array("name" => 'category_c', "value" => $gender)
									));

							unset($_product);
							/*******************set product entry************************/
							$product_response = $client->call('set_entry', $product_values);
							/*******************set product entry************************/

							/*******************set order to product relationship************************/
							$opportunityId = $order_response['id'];
							$productId = $product_response['id'];

							$set_relationship_parameters_products = array(
								'session' => $session_id,
								'module_name' => 'Opportunities',
								'module_id' => "$opportunityId",
								'link_field_name' => 'opportunities_ys_products_1',
								'related_ids' => array(
									"$productId",
									),
								'name_value_list' => array(),
								'delete'=> 0,
								);
							$res = $client->call('set_relationship', $set_relationship_parameters_products);
							/*******************set order to product relationship************************/

							/************ ys custom code push customers items (shivaji)***************/
							if($customer_id) {
								$set_relationship_parameters_products = array(
									'session' => $session_id,
									'module_name' => 'Contacts',
									'module_id' => "$contactId",
									'link_field_name' => 'contacts_ys_products_1',
									'related_ids' => array(
										"$productId",
										),
									'name_value_list' => array(),
									'delete'=> 0,
									);
								$res = $client->call('set_relationship', $set_relationship_parameters_products);
							}
							/************ ys custom code push customers items (shivaji)***************/
                        	//discount
							if(count($item->discounts) > 0){
								foreach($item->discounts as $discount){
									$discount_name = $discount->name;
									$amount = number_format(($discount->applied_money->amount/100),2);
									$discount_total = $discount_total + $amount;
								}
							}
						}
						if(isset($discount_name) && isset($discount_total) && !empty($discount_total)){
							$discount_values = array(
								"session" => $session_id,
								"module_name" => 'YS_Di_YS_Discount',
								"name_value_list" => array(
									array("name" => 'name', "value" => $discount_name),
									array("name" => 'amount', "value" => $discount_total),
									array("name" => 'description', "value" => 'Square Order #'.$order_id),
									));
							$discount_responce = $client->call('set_entry', $discount_values);
							$discountId = $discount_responce['id'];
							/************ ys custom code push order discount items (shivaji)***************/
							$set_relationship_parameters_discount = array(
								'session' => $session_id,
								'module_name' => 'Opportunities',
								'module_id' => "$opportunityId",
								'link_field_name' => 'ys_di_ys_discount_opportunities',
								'related_ids' => array(
									"$discountId",
									),
								'name_value_list' => array(),
								'delete'=> 0,
								);
							$res = $client->call('set_relationship', $set_relationship_parameters_discount);
							/************ ys custom code push order discount items (shivaji)***************/
							exit('Script Stop');
							
						}
					}
					$i++;
				}
			}

			echo "</pre>";
		} catch (\SquareConnect\ApiException $e) {
			echo "Caught exception!<br/>";
			print_r("<strong>Response body:</strong><br/>");
			echo "<pre>"; var_dump($e->getResponseBody()); echo "</pre>";
			echo "<br/><strong>Response headers:</strong><br/>";
			echo "<pre>"; var_dump($e->getResponseHeaders()); echo "</pre>";
		}


	}
}
