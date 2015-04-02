<?php
function searchTweets($hash_tag)
{
    require_once 'twitteroauth/twitteroauth.php';
    require_once 'twt_config.php';

    $toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

    $results = $toa->get('statuses/user_timeline', array('screen_name' => 'yogasmoga', 'count' => 100));
    if ($results) {
        foreach ($results as $result) {

            $ar = get_object_vars($result);

            $ar_entities = get_object_vars($ar['entities']);

            $found = false;
            foreach ($ar_entities['hashtags'] as $hashtag) {

                $hashtag_ar = get_object_vars($hashtag);

                if (strtolower($hashtag_ar['text']) == $hash_tag) {
                    $found = true;
                    break;
                }
            }

            if ($found) {
                $text = $ar['text'];
//die();
                $media = "";

                if (isset($ar_entities['media'][0])) {
                    $ar_media_data = get_object_vars($ar_entities['media'][0]);
                    if (isset($ar_media_data) && isset($ar_media_data['media_url'])) {
//                    echo "<img src='" . $ar_media_data['media_url'] . "'/>";
                        $media = $ar_media_data['media_url'];

                    }
//                echo "<hr/>";
                }

                ?>
                <div
                    class="row span4 twt" <?php if ($media) { ?> style="background: url('<?php echo $ar_media_data['media_url'] ?>'); background-position: center center; position:absolute;top:0;left:0; width: 100%;height:100%;"        <?php } ?>
                    onclick="window.open('http://twitter.com/yogasmoga', '_blank')">
                    <?php
                    echo '<img src="' . get_site_url() . '/wp-content/themes/rangoli/images/no-background.png" style="width:100%;float:left; "/>';
                    ?>
                </div>

                <div class="overlay-text" onclick="window.open('http://twitter.com/yogasmoga','_blank')">

                    <?php
                    if ($ar['text']) {
                        $text = $ar['text'];
                        $text = str_replace("#rangoli", "", $text);
                        $text = strip_tags($text);
                        $text = trim($text);
                        $text = substr($text, 0, 65);
                        $text .= "...";
                        ?>
                        <span class='fts-twitter-text'
                              onclick="window.open('http://twitter.com/yogasmoga/', '_blank')"
                            ><?php print $text ?></span>
                        <span class="twitter_author"><a target="_blank"
                                                        href='http://twitter.com/yogasmoga'>YOGASMOGA</a></span>
                    <?php
                    }
                    ?>
                    <a class="twitter-icon" href="javascript:void(0);"><img
                            src="<?php echo get_site_url() ?>/wp-content/themes/rangoli/images/tw-w.png"/></a>
                </div>
            <?php
            }
        }
    }
}

searchTweets('rangoli');

?>
