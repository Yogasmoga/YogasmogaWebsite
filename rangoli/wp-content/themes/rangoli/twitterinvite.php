<?php
/*
 * Template Name: Invite friends
 *
 *
 */
session_start();
//if(!is_user_logged_in()){
//    wp_redirect(get_site_url());
//}
get_header();
require('twitteroauth/twitteroauth.php');
require('twt_config.php');

if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    ;//header('Location: /rangoli/wp-content/themes/rangoli/twt_clearsessions.php');
}
$access_token = $_SESSION['access_token'];

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

$content = $connection->get('account/verify_credentials');

?>
    <!--<script type="text/javascript" src="js/jquery.js"></script>-->
    <script type="text/javascript">
        $(document).ready(function(){
            $(".chkcolor").click(function(){

                var classes=$(this).attr("class");

                if(classes.indexOf("checked")>-1){
                    $(this).removeClass("checked");
                    $(this).parent().find("input[type='checkbox']").attr("checked", "none");
                }
                else{
                    $(this).addClass("checked");
                    $(this).parent().find("input[type='checkbox']").attr("checked", "checked");
                }
            });
        });






        function sendNow() {

            var matches = Array();
            var selected = false;
            $("input[name='screen_name']:checked").each(function () {
                matches.push(this.value);
                selected = true;
            });

            if(selected) {
                var values = matches.toString();

                $(".send-invites").val('Sending Invites...');

                $.ajax({
                    url: "http://yogasmoga.com/rangoli/wp-content/themes/rangoli/twt_send_direct_messages.php",
                    type: 'POST',
                    data: 'screen_names=' + values,
                    success: function (result) {
                        if (result == "done") {
                            $(".message-display").hide();
                            $(".page-heading").hide();
                            $(".invite_sent_message").slideDown();
                        }
                        else{
                            $(".send-invites").val('Invites not sent!');
                        }
                    }
                });
            }
        }
    </script>
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

$text = "Join me on RANGOLI and let's paint the town red together. Discover more <br/>—" . $_SESSION['referrer_link'];

?>
    <div class="message">
        <div class="align-center">
            <h1 class="page-heading">INVITE FRIENDS</h1>
        </div>
        <div class="message-display">
        <div class="twitter-friends">
            <?php
            if (isset($ar['users'])) {
            foreach ($ar['users'] as $data) {

                $screen_name = $data['screen_name'];
                $name = $data['name'];
                $profile_image_url = $data['profile_image_url'];
                $profile_image_url = str_replace("_normal.", "_bigger.", $profile_image_url);
                ?>
                <div class="friend">
                    <img src='<?php echo $profile_image_url; ?>' class='pic'/>

                    <p class="twt_name"><?php echo $name; ?></p>

                    <p><span class="chkcolor"></span><input type="checkbox" name="screen_name" style="visibility: hidden" value="<?php echo $screen_name; ?>"/></p>
                </div>

            <?php
            }
            ?>
            <div class="align-center row">

                <input type="button" class="send-invites" value="Send Request" onclick="sendNow()"/>

            </div>



            </div>
        </div>
        <?php
        }
        else {
            echo "<p style='text-align: center'>No body is following you</p>";
        }
        ?>

        <div class="invite_sent_message">
            <p>Your invitations are on their way.</p>
            <p>Thank you for inviting more people to discover their color journey on RANGOLI. When<br/>
                your friends sign on & make a purchase at yogasmoga.com, you earn $2 SMOGI Bucks. <br/>
                Yep, you heard us right: free money for bringing friends to the party.
            </p>

            <div class="CTA-buttons">
                <div class="row">
                    <div class="span6">
                        <a href="">Invite more friends.</a>
                    </div>
                    <div class="span6">
                        <a href="<?php echo get_site_url(); ?>">Return to RANGOLI.</a>
                    </div>
                </div>
            </div>


        </div>

    </div>

    <style>
        .twitter-friends {
            margin: 0 auto;
            width: 650px;
        }

        .twitter-friends img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
        }
        .chkcolor {
            border: 1px solid #444;
            border-radius: 50%;
            display: block;
            height: 10px;
            margin: 15px auto 0;
            width: 10px;
            cursor: pointer;
        }
        .chkcolor.checked{
            background: #<?php $user = get_user_profile(get_current_user_id());  echo $user->color_shade;  ?> ;
            border: #<?php $user = get_user_profile(get_current_user_id());  echo $user->color_shade;  ?> ;
        }
        .twt_name {
            font-family: ITCAvantGardeStd-Bk;
            font-size: 13px;
            line-height: 18px;
            margin-top: 14px;
            text-transform: uppercase;
            word-wrap: break-word;
        }
        .friend {
            box-sizing: border-box;
            float: left;
            height: 180px;
            padding: 20px 0;
            text-align: center;
            width: 20%;
        }
        .invite_sent_message {
            clear: both;
            display: none;
            font-family: GraphikRegular;
            font-size: 15px;
            left: 50%;
            line-height: 25px;
            margin: 0 auto 0 -450px;
            padding: 50px 0;
            position: absolute;
            text-align: center;
            top: 90px;
            width: 900px;
        }
        .invite_sent_message p:first-child {
            font-family: ITCAvantGardeStd-Bk;
            font-size: 20px;
            margin-bottom: 30px;
        }
        .CTA-buttons a {
            border: 1px solid #444;
            color: #444;
            display: block;
            line-height: 35px;
            margin: 0 auto;
            width: 317px;
            margin-top: 30px;
        }
    </style>
<?php

get_footer();
?>