<p class="smogi_page_title">KNOW OUR SMOGIS</p>
<p class="smogi_title">SMOGIS</p>

<div class="smogi-content">
    <?php $blogusers = get_users('role=smogi');

    if ($blogusers) {
    foreach ($blogusers as $user) {


    $user_id = $user->ID;
    $size = 'thumbnail';
    $imgURL = get_the_author_meta('cupp_upload_meta', $user_id);

    ?>



    <div class="smogi span4">
        <div class="author_post">
            <div class="smogi_image">
                <a class="smogi_link ajax-load" href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>">
                    <?php
                    if ($imgURL == "") {
                        echo '<img src="' . get_site_url() . '/wp-content/themes/rangoli/images/default.jpg" />';
                    } else
                        echo '<img src="' . $imgURL . '" />';
                    ?>

                </a>
            </div>
            <div >
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
                    echo '<div class="' . $class . ' row like" author="' . $user_id . '" user="' . $current_user_id . '">';
                    get_template_part("heartsvg");
                    echo '</div>';

                ?>
            </div>
        </div>
        <a class="author-link ajax-load"
           href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php echo get_the_author_meta('display_name', $user->ID) ?></a>

        <p class="author_profession"><?php $user_profession = get_the_author_meta("wpcf-profession", $user_id);
            echo $user_profession; ?></p>
    </div>


<?php }
} ?>

</div>