<?php
require '../vendor/autoload.php';

$location_id = 'REPLACE_ME';

//$access_token = 'sq0atp-DTuNrNZytik1cfSU850jIw';//live

$access_token = 'sq0atb-o8YyBc5M42gDiNvRYTDHiQ';//sandbox

$object = new \SquareConnect\ObjectSerializer();

$customers_api = new \SquareConnect\Api\CustomerApi();

$body = array (
  "given_name" => 'Shivaji',
  "family_name" => 'Chauhan',
  "company_name" => 'Yogasmoga',
  "nickname" => 'shiva',
  "email_address" => 'shivaji@yogasmoga.com',
  "phone_number" => '9999112223',
  "note" => 'Test Customer created by shivaji chauhan 2'
);

try {
  $result = $customers_api->createCustomer($access_token,$body);
  echo "<pre>";
  print_r($result);
  echo "</pre>";
} catch (\SquareConnect\ApiException $e) {
  echo "Caught exception!<br/>";
  print_r("<strong>Response body:</strong><br/>");
  echo "<pre>"; var_dump($e->getResponseBody()); echo "</pre>";
  echo "<br/><strong>Response headers:</strong><br/>";
  echo "<pre>"; var_dump($e->getResponseHeaders()); echo "</pre>";
}

/*$customers_api = new \SquareConnect\Api\CustomerApi();
global $data;
$i=0;

try {
		do{
		  $result = $customers_api->listCustomers($access_token,$data->cursor);
		  echo "<pre>";
		  //print_r($result);
		  $object = new \SquareConnect\ObjectSerializer();
		  $data = $object->sanitizeForSerialization($result);
		  print_r($data->customers);
		  echo "</pre>";
		  if($i == 3){break;}
		  $i++;
		}while(count($data->customers) >= 100 && $data->cursor);
} catch (\SquareConnect\ApiException $e) {
  echo "Caught exception!<br/>";
  print_r("<strong>Response body:</strong><br/>");
  echo "<pre>"; var_dump($e->getResponseBody()); echo "</pre>";
  echo "<br/><strong>Response headers:</strong><br/>";
  echo "<pre>"; var_dump($e->getResponseHeaders()); echo "</pre>";
}
*/


/*$LocationApi = new \SquareConnect\Api\LocationApi();
$transaction_api = new \SquareConnect\Api\TransactionApi();

try {
  $result = $LocationApi->listLocations($access_token);
  echo "<pre>";
  $data = $object->sanitizeForSerialization($result);
  //print_r($data);
  echo "</pre>";
} catch (\SquareConnect\ApiException $e) {
  echo "Caught exception!<br/>";
  print_r("<strong>Response body:</strong><br/>");
  echo "<pre>"; var_dump($e->getResponseBody()); echo "</pre>";
  echo "<br/><strong>Response headers:</strong><br/>";
  echo "<pre>"; var_dump($e->getResponseHeaders()); echo "</pre>";
}

if(count($data->locations) > 0){
	foreach($data->locations as $location){
		echo "<pre>";
		echo $location->id;
		echo $location->name;
		echo "</pre>";

			try {
			  $resultT = $transaction_api->listTransactions($access_token, $location->id);
			  $dataT = $object->sanitizeForSerialization($resultT);
			  echo "<pre>";
			  print_r($dataT);
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
*/
/*
$customers_api = new \SquareConnect\Api\CustomerApi();
global $data;
$i=0;

try {
		do{
		  $result = $customers_api->listCustomers($access_token,$data->cursor);
		  echo "<pre>";
		  //print_r($result);
		  $object = new \SquareConnect\ObjectSerializer();
		  $data = $object->sanitizeForSerialization($result);
		  print_r($data->customers);
		  echo "</pre>";
		  if($i == 3){break;}
		  $i++;
		}while(count($data->customers) >= 100 && $data->cursor);
} catch (\SquareConnect\ApiException $e) {
  echo "Caught exception!<br/>";
  print_r("<strong>Response body:</strong><br/>");
  echo "<pre>"; var_dump($e->getResponseBody()); echo "</pre>";
  echo "<br/><strong>Response headers:</strong><br/>";
  echo "<pre>"; var_dump($e->getResponseHeaders()); echo "</pre>";
}
*/





# Helps ensure this code has been reached via form submission
/*if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  error_log("Received a non-POST request");
  echo "Request not allowed";
  http_response_code(405);
  return;
}
# Fail if the card form didn't send a value for `nonce` to the server
$nonce = $_POST['nonce'];
if (is_null($nonce)) {
  echo "Invalid card data";
  http_response_code(422);
  return;
}*/

/*
$transaction_api = new \SquareConnect\Api\TransactionApi();
$request_body = array (
  "card_nonce" => $nonce,
  # Monetary amounts are specified in the smallest unit of the applicable currency.
  # This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
  "amount_money" => array (
    "amount" => 100,
    "currency" => "USD"
  ),
  # Every payment you process with the SDK must have a unique idempotency key.
  # If you're unsure whether a particular payment succeeded, you can reattempt
  # it with the same idempotency key without worrying about double charging
  # the buyer.
  "idempotency_key" => uniqid()
);
# The SDK throws an exception if a Connect endpoint responds with anything besides
# a 200-level HTTP code. This block catches any exceptions that occur from the request.
try {
  $result = $transaction_api->charge($access_token, $location_id, $request_body);
  echo "<pre>";
  print_r($result);
  echo "</pre>";
} catch (\SquareConnect\ApiException $e) {
  echo "Caught exception!<br/>";
  print_r("<strong>Response body:</strong><br/>");
  echo "<pre>"; var_dump($e->getResponseBody()); echo "</pre>";
  echo "<br/><strong>Response headers:</strong><br/>";
  echo "<pre>"; var_dump($e->getResponseHeaders()); echo "</pre>";
}
*/