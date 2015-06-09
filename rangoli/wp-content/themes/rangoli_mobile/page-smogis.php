<?php
get_header();
?>

<div class="smogi-content">
    <?php $blogusers = get_users('role=smogi');

    if ($blogusers) {
        foreach ($blogusers as $user) {

            $user_id = $user->ID;

            $size = 'thumbnail';
    //        $imgURLs = get_user_meta($user_id,'wpcf-mobile-profileimage');
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
                        <div class="charm smogi_charm <?php $profile = get_user_profile($user_id); echo get_user_level($user_id)." color_".strtoupper($profile->color_main); ?>"></div>
                        <div class="align_bottom">
                            <a class="author-link" href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php echo get_the_author_meta('display_name', $user->ID) ?></a>

                            <p class="author_profession"><?php $user_profession = get_the_author_meta("wpcf-profession", $user_id);
                        echo $user_profession; ?></p>
                        </div>
                    </div>
                    <div class="close_post user-color-shade-trans"></div>
<!--                    <div class="share_post user-color-shade-trans"></div>-->

                        <?php
                        if(is_user_logged_in()) {
                            $current_user = wp_get_current_user();
                            $subscribed_authors = $wpdb->get_results("SELECT status FROM rangoli_wpsa_subscribe_author WHERE author_id=" . $user->ID . " AND subscriber_id=" . $current_user->ID);

                            if(count($subscribed_authors)>0){
                                $subscribed_author = $subscribed_authors[0];
                                if ($subscribed_author->status == "active") {
                                    $class = "subscribed";
                                }
                                else {
                                    $class = "unsubscribed";
                                }
                            }
                            else {
                                $class = "unsubscribed";
                            }
                            $user_id =$user->ID;
                            $current_user_id = $current_user->ID;
                        }
                        else{
                            $class = "not_logged_in";
                            $user_id="not-logged";
                            $current_user_id = "visitor";
                        }
                        echo '<div class="' . $class . ' row like user-color-shade" author="' . $user_id . '" user="' . $current_user_id . '">';
                        get_template_part("heartsvg");
                        echo "<p>".get_subscribers_count($user->ID)."</p>";
                        echo '</div>';

                        ?>
                    </div>
                </div>

            <div class="author_posts">
                <?php
                    echo get_author_shared_posts($user->ID);
//                    echo get_author_liked_posts($user->ID);
                    echo get_author_events_posts($user->ID);
                ?>
            </div>



        <?php }
    } ?>
</div>
<?php
    get_footer();
?>