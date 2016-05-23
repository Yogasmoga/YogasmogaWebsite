<?php

# Demonstrates generating a 2015 payments report with the Square Connect API.
# Replace the value of the `$accessToken` variable below before running this script.
#
# This sample assumes all monetary amounts are in US dollars. You can alter the
# formatMoney function to display amounts in other currency formats.
#
# This sample requires the Unirest PHP library. Download it here:
# http://unirest.io/php.html
#
# Results are rendered in a simple HTML pre block.


# Replace this value with the path to the Unirest PHP library
require_once '../vendor/mashape/unirest-php/src/Unirest.php';

# Replace this value with your application's personal access token,
# available from your application dashboard (https://connect.squareup.com/apps)

$accessToken = 'sq0atp-DTuNrNZytik1cfSU850jIw';//live

//$accessToken = 'sq0atb-o8YyBc5M42gDiNvRYTDHiQ';//sandbox

# The base URL for every Connect API request
$connectHost = 'https://connect.squareup.com';

# Standard HTTP headers for every Connect API request
$requestHeaders = array (
  'Authorization' => 'Bearer ' . $accessToken,
  'Accept' => 'application/json',
  'Content-Type' => 'application/json'
);


# Obtains all of the business's location IDs. Each location has its own collection of payments.
function getLocationIds() {
  global $accessToken, $connectHost, $requestHeaders;
  $requestPath = $connectHost . '/v1/me/locations';
  $response = Unirest\Request::get($requestPath, $requestHeaders);
  $locations = $response->body;
  $locationIds = array();

  foreach ($locations as $location) {
    $locationIds[] = $location->id;
  }

  return $locationIds;
}
/*
# Retrieves all of a merchant's payments from 2015
function get2015Payments($location_ids) {
  global $accessToken, $connectHost, $requestHeaders;

  # Restrict the request to the 2015 calendar year, eight hours behind UTC
  # Make sure to URL-encode all parameters
  $parameters = http_build_query(
  	array(
  	  'begin_time' => '2016-04-01T00:00:00-08:00',
  	  'end_time'   => '2016-05-20T00:00:00-08:00'
  	)
  );

  $payments = array();
  $i=0;
  foreach ($location_ids as $location_id) {

    $requestPath = $connectHost . '/v1/' . $location_id . '/payments?' . $parameters;
    $moreResults = true;

    while ($moreResults) {
	  
      # Send a GET request to the List Payments endpoint
      $response = Unirest\Request::get($requestPath, $requestHeaders);

      # Read the converted JSON body into the cumulative array of results
      $payments = array_merge($payments, $response->body);

      # Check whether pagination information is included in a response header, indicating more results
      if (array_key_exists('Link', $response->headers)) {
        $paginationHeader = $response->headers['Link'];
        if (strpos($paginationHeader, "rel='next'") !== false) {

          # Extract the next batch URL from the header.
          #
          # Pagination headers have the following format:
          # <https://connect.squareup.com/v1/MERCHANT_ID/payments?batch_token=BATCH_TOKEN>;rel='next'
          # This line extracts the URL from the angle brackets surrounding it.
          $requestPath = explode('>', explode('<', $paginationHeader)[1])[0];
        } else {
          $moreResults = false;
        }
      } else {
        $moreResults = false;
      }
    }
		if($i==1)
		break;

	$i++;
  }

  # Remove potential duplicate values from the list of payments
  $seenPaymentIds = array();
  $uniquePayments = array();
  foreach ($payments as $payment) {
  	if (array_key_exists($payment->id, $seenPaymentIds)) {
  	  continue;
  	}
  	$seenPaymentIds[$payment->id] = true;
  	array_push($uniquePayments, $payment);
  }

  return $uniquePayments;
}


# Call the functions defined above
$payments = get2015Payments(getLocationIds());
echo "<pre>";
var_dump($payments);
echo "</pre>";
*/

$requestPath = $connectHost . '/v1/257PFCAGHYSE9/payments/hY2hKZz4KKZ1tmBTqvMHNrleV';//?' . $parameters;
$response = Unirest\Request::get($requestPath, $requestHeaders);
echo "<pre>";
var_dump($response);
echo "</pre>";
?>
