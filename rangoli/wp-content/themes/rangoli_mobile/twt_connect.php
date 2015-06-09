<?php
session_start();
require('twitteroauth/twitteroauth.php');
require('twt_config.php');

if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    header('Location: ./clearsessions.php');
}
$access_token = $_SESSION['access_token'];

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

$content = $connection->get('account/verify_credentials');

echo "<b>Username: </b>" . $content->screen_name . "<br>";
?>

<html>
<head>
    <style type="text/css">
        img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }

        div {
            float: left;
            margin-right: 20px;
            width: 100px;
            height: 150px;
            text-align: center;
        }
    </style>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript">
        function sendNow(){

            var matches = Array();
            $("input[name='screen_name']:checked").each(function() {
                matches.push(this.value);
            });

            var values = matches.toString();

            $.ajax({
                url: 'send_direct_messages.php',
                type: 'POST',
                data: 'screen_names=' + values,
                success: function(result){
                    alert(result);
                }
            });
        }
    </script>
</head>
<body>


<?php
require_once('TwitterAPIExchange.php');

$settings = array(
    'oauth_access_token' => ACCESS_TOKEN,
    'oauth_access_token_secret' => ACCESS_TOKEN_SECRET,
    'consumer_key' => CONSUMER_KEY,
    'consumer_secret' => CONSUMER_SECRET
);

$url = "https://api.twitter.com/1.1/followers/list.json";

$requestMethod = "GET";
$getfield = '?screen_name=' . $content->screen_name . '&count=200';

$twitter = new TwitterAPIExchange($settings);

$ar = json_decode($twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest(), $assoc = TRUE);

if ($ar["errors"][0]["message"] != "") {
    echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>" . $ar[errors][0]["message"] . "</em></p>";
    exit();
}

//$text = "Hi, check this amazing website : " . $_SESSION['referrer_link'];

$text = "Hi, check this amazing website : " . file_get_content(REFERRAL_URL);


foreach ($ar['users'] as $data) {

    $screen_name = $data['screen_name'];
    $profile_image_url = $data['profile_image_url'];
    ?>
    <div>
        <img src='<?php echo $profile_image_url; ?>' class='pic'/>
        <input type="checkbox" name="screen_name" value="<?php echo $screen_name; ?>"/> Invite
        <!--        <a href="https://api.twitter.com/1.1/direct_messages/new.json?text=--><?php //echo $text; ?><!--&screen_name=--><?php //echo $screen_name; ?><!--">Invite</a>-->
    </div>

<?php
}
?>
<input type="button" value="Send Request" onclick="sendNow()"/>

</body>
</html>
