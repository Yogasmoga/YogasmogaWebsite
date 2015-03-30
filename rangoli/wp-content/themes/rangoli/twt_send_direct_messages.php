<?php
session_start();
require('twitteroauth/twitteroauth.php');
require('twt_config.php');

if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    echo "error";
    exit(0);
}
$access_token = $_SESSION['access_token'];

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

$content = $connection->get('account/verify_credentials');

require_once('TwitterAPIExchange.php');

//$settings = array(
//    'oauth_access_token' => "162238335-OtC9xIwS3xUdMubw1UpR30016fykU8NzoAsTEzXn",
//    'oauth_access_token_secret' => "aL17Gl1iTMiX8VhT2sxy6EGINGZCLDEcBnStEQNHaxSbV",
//    'consumer_key' => "wEC50LtllbyTzwt0u7oPVg",
//    'consumer_secret' => "5A1s3rMBnR4OdvIcFA2gymN5jsEMErvyWpCE3sJTc"
//);

$settings = array(
    'oauth_access_token' => ACCESS_TOKEN,
    'oauth_access_token_secret' => ACCESS_TOKEN_SECRET,
    'consumer_key' => CONSUMER_KEY,
    'consumer_secret' => CONSUMER_SECRET
);

$url = 'https://api.twitter.com/1.1/direct_messages/new.json';

$requestMethod = "POST";
$getfield = '?screen_name=' . $content->screen_name . '&count=200';

$text = "Join me on RANGOLI and let's paint the town red together. Discover more —" . $_SESSION['referrer_link'];

$twitter = new TwitterAPIExchange($settings);

$screen_names = $_REQUEST['screen_names'];

if($screen_names) {

    $ar_screen_names = explode(",", $screen_names);

    foreach ($ar_screen_names as $screen_name) {

        $postFields = array(
            'user_id' => $content->screen_name,
            'screen_name' => $screen_name,
            'text' => $text
        );

        $ar = $twitter->buildOauth($url, $requestMethod)->setPostfields($postFields)->performRequest();
    }

    echo "done";
}
else{
    echo "nothing";
}
?>