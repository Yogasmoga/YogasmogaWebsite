<?php
get_header();
$logged_in = get_site_url();
?>

<div class="smogi-content">
<?php $blogusers = get_users('role=store');

if ($blogusers) {
    foreach ($blogusers as $user) {


        $user_id = $user->ID;
        $location =$user_id;
        $size = 'thumbnail';
//        $imgURLs = get_user_meta($user_id,'wpcf-mobile-banner');
//        $imgURL = $imgURLs[0];
        $imgURL = get_the_author_meta('author_profile_picture', $user_id);

        ?>

        <div class="smogi">
            <div class="author_post_read">
                        <?php
                        if ($imgURL == "") {
                            echo '<img src="' . get_site_url() . '/wp-content/themes/rangoli/images/default.jpg" />';
                        } else
                            echo '<img src="' . $imgURL . '" />';
                        ?>
                <div class="overlay-text">
                    <div class="align_bottom">
                    <a class="author-link" href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php echo get_the_author_meta('display_name', $user->ID) ?></a>

                    <p class="author_profession"><?php $user_profession = get_the_author_meta("wpcf-profession", $user_id);
                echo $user_profession; ?></p>
                        </div>
                </div>
<div class="close_post <?php if($logged_in){echo 'user-color-shade-trans';} ?>">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="44px" height="44px" viewBox="0 0 44 44" enable-background="new 0 0 44 44" xml:space="preserve">
                        <g>
                            <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="16.508" y1="15.751" x2="30.975" y2="30.218"/>
                            <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="30.975" y1="15.751" x2="16.508" y2="30.218"/>
                        </g>
</svg>
            </div>
<!--                    <div class="share_post user-color-shade-trans"></div>-->



                    <?php
                    if(is_user_logged_in()) {
                        $current_user = wp_get_current_user();
                        $subscribed_authors = $wpdb->get_results("SELECT status FROM rangoli_wpsa_subscribe_author WHERE author_id=" . $user->ID . " AND subscriber_id=" . $current_user->ID);
//                $subscribed_author = array();
                        //print_r($subscribed_authors);


//                    print_r($subscribed_author);
                        if(count($subscribed_authors)>0){
                            $subscribed_author = $subscribed_authors[0];
                            if ($subscribed_author->status == "active") {
                                $class = "subscribed";
                            }
                        }
                        else {
                            $class = "unsubscribed";
                        }
                        $user_id =$user->ID;
                        $current_user_id = $current_user->ID;
                    }
                    else{
                        $class = "unsubscribed";
                        $user_id="not-logged";
                        $current_user_id = "visitor";
                    }
                    echo '<div class="' . $class . ' row like ';
                    if($logged_in){echo 'user-color-shade-trans';}
                    echo '" author="' . $user_id . '" user="' . $current_user_id . '">';
                    get_template_part("heartsvg");
                    echo "<p>".get_subscribers_count($user->ID)."</p>";
                    echo '</div>';

                    ?>
                </div>
            </div>

            <div class="author_posts">
                <?php
                echo "<p class='address'>".nl2br($user->description)."</p>";
                $user_id = $location;
                //echo get_author_liked_posts($user->ID);
                echo get_author_events_posts($user_id);
                echo get_author_shared_posts($user_id);
                ?>
            </div>



        </div>
</div>

    <?php }
} ?>

<?php
    get_footer();
?>