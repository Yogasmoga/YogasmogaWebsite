<?php
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('twt_config.php');

    //$link = file_get_contents(REFERRAL_URL);

    $link = $_REQUEST['l'];

    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

    $request_token = $connection->getRequestToken(OAUTH_CALLBACK);

    $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
    $_SESSION['referrer_link'] = $link;

switch ($connection->http_code) {
    case 200:
        $url = $connection->getAuthorizeURL($token);
        header('Location: ' . $url);
        break;
    default:
        echo 'Could not connect to Twitter. Refresh the page or try again later.' . $connection->http_code;
}