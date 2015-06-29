<?php
$post = get_post();
if($post->post_type=="post" && $post->post_status=="publish" ) {
    get_header();

    ?>
    <div class="author_post_read">
        <?php echo get_the_post_thumbnail($post->ID, "mobile_posts");
        if (!has_post_thumbnail()) {
            echo '<img src="' . $home . '/wp-content/themes/rangoli_mobile/images/no-background_posts.png" />';
        }
        ?>
        <?php
        if (has_post_video()) {
            $authors = get_user_profile($post->post_author);
            $author_color = '#' . $authors->color_shade;
            ?>
            <div class="play-video" video="<?php echo get_the_post_video_url($post->ID); ?>">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px"
                     viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">                    <defs>
                    </defs>
                    <path fill="<?php echo $author_color; ?>"
                          opacity="0.9" enable-background="new"
                          d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                    </svg>
            </div>
            <?php
            echo "<div class='play_video'>";
            the_post_video($post->ID);
            echo "</div>";
        }
        ?>
        <div class="overlay-text">
            <div class="align_bottom">
                <div class="post_category"><?php echo get_post_categories(); ?></div>
                <div class="post_title"><?php echo $post->post_title; ?></div>
                <div class="post_author">with <span><?php $post_author = get_userdata($post->post_author);
                        echo $post_author->display_name; ?></span></div>
            </div>
            <?php
            $post_author_image_urls = get_user_meta($post->post_author, 'cupp_upload_meta');
            $post_author_image_url = $post_author_image_urls[0];
            if ($post_author_image_url == "") {
                $post_author_image_url = $home . "/wp-content/themes/rangoli_mobile/images/default.jpg";
            }
            ?>
            <div class="author_picture"
                 style="background: url('<?php echo $post_author_image_url; ?>') no-repeat; background-position: center center; background-size: cover"></div>
        </div>
        <?php
        $home = get_site_url();
        if (has_category("read")) {
            $cat_link = $home . "/read";
        } else if (has_category("look")) {
            $cat_link = $home . "/look";
        } else if (has_category("learn")) {
            $cat_link = $home . "/learn";
        } else {
            $cat_link = $home;
        }
        ?>
        <div class="close_post_index <?php if ($logged_in) {
            echo 'user-color-shade-trans';
        } ?>" onclick="window.location='<?php echo $cat_link; ?>'">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 width="44px" height="44px" viewBox="0 0 44 44" enable-background="new 0 0 44 44" xml:space="preserve">
                        <g>
                            <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="16.508" y1="15.751"
                                  x2="30.975" y2="30.218"/>
                            <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="30.975" y1="15.751"
                                  x2="16.508" y2="30.218"/>
                        </g>
    </svg>

        </div>
        <div class="share_post_index  <?php if ($logged_in) {
            echo 'user-color-shade-trans';
        } ?>" style="display: block;">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 width="44px" height="44px" viewBox="0 0 44 44" enable-background="new 0 0 44 44" xml:space="preserve">
<g>
    <g>
        <g>
            <polygon fill="none" stroke="#FFFFFF" stroke-miterlimit="10"
                     points="20.624,15.692 23.742,10.293 26.859,15.692 			"/>
            <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="23.742" y1="15.93" x2="23.742" y2="22.984"/>
        </g>
    </g>
    <polyline fill="none" stroke="#FFFFFF" stroke-miterlimit="10" points="28.443,17.962 31.698,17.962 31.698,33.037 15.302,32.991
		15.302,17.962 18.678,17.962 	"/>
</g>
</svg>
        </div>
    </div>
    <div class="post_content" style="display: block;">

        <?php



        //                if(isset($current_category)) {
        if (has_category("learn")) {
            $level = get_post_meta($post->ID, "wpcf-level");
            $duration = get_post_meta($post->ID, "wpcf-duration");
            $style = get_post_meta($post->ID, "wpcf-style");
            if (isset($level) && count($level) > 0 && isset($duration) && count($duration) > 0 && isset($style) && count($style) > 0) {
                ?>
                <div class="span6 basic_learn_page_info" style="padding-left: 0px;">

                    <p>Level : <?php echo implode(" ", $level); ?></p>

                    <p>Style : <?php echo implode(" ", $style); ?></p>

                    <p>Duration :  <?php echo implode(" ", $duration); ?></p>
                </div>
                <div class="right">
                    <?php
                    $rating = get_post_rating($post->ID, 'post');
                    $rating = intval($rating);
                    ?>
                    <div class="rating" rel="<?php echo $rating; ?>"
                         post_id="<?php echo $post->ID; ?>">

                    </div>
                </div>
            <?php
            }
        }
        //                }
        echo "<div class='clear'></div>";

        echo apply_filters('the_content', $post->post_content);


        $comment_array = get_approved_comments($post->ID);
        $comm_no = count($comment_array);
        $key = "wpfp_favorites";
        $favorite_count_check = get_post_meta($post->ID, $key, true);

        echo "<p class='comments_no'>$favorite_count_check Likes &nbsp;&nbsp; $comm_no Comments</p>";


        if (has_category("learn")) {
            echo get_the_look($post);
        }
        $post_link = get_permalink($post->ID);
        $b_pl = get_bitly_url($post_link);
        ?>

        <div class="sharing_box  <?php if ($logged_in) {
            echo 'user-color-shade-trans';
        } ?>">
                    <span class="facebook"><a target="_blank" user="<?php echo get_current_user_id(); ?>"
                                              href="https://www.facebook.com/sharer/sharer.php?app_id=909386705751971&u=<?php echo $b_pl; ?>">

                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 width="23.024px" height="29px" viewBox="0 0 23.024 29"
                                 enable-background="new 0 0 23.024 29" xml:space="preserve">
<path fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M18.295,16.185l0.619-4.8H14.16V8.32c0-1.389,0.388-2.336,2.381-2.336
	l2.539-0.001V1.689C18.643,1.631,17.135,1.5,15.377,1.5c-3.664,0-6.172,2.237-6.172,6.346v3.54H5.06v4.8h4.146V28.5h4.955V16.185
	H18.295z"/>
</svg>

                        </a> </span>
                    <span class="twitter"><a target="_blank" rel="<?php echo $post->ID; ?>"
                                             user="<?php echo get_current_user_id(); ?>"
                                             href="http://twitter.com/intent/tweet?text=<?php echo $post->post_title; ?>&url=<?php echo $b_pl; ?>">

                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 width="31.646px" height="29px" viewBox="0 0 31.646 29"
                                 enable-background="new 0 0 31.646 29" xml:space="preserve">
<path fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M30.646,5.277c-1.059,0.47-2.196,0.787-3.389,0.929
	c1.218-0.73,2.155-1.885,2.593-3.264c-1.137,0.676-2.4,1.167-3.744,1.432c-1.076-1.147-2.61-1.864-4.307-1.864
	c-3.259,0-5.899,2.642-5.899,5.9c0,0.463,0.052,0.913,0.152,1.344C11.149,9.51,6.802,7.162,3.893,3.591
	C3.385,4.464,3.094,5.476,3.094,6.557c0,2.046,1.041,3.854,2.624,4.911c-0.967-0.03-1.876-0.297-2.672-0.738v0.074
	c0,2.858,2.033,5.242,4.731,5.785c-0.494,0.134-1.018,0.208-1.555,0.208c-0.379,0-0.75-0.038-1.109-0.107
	c0.75,2.345,2.93,4.048,5.511,4.098c-2.018,1.582-4.562,2.525-7.328,2.525c-0.475,0-0.944-0.029-1.405-0.083
	c2.61,1.673,5.711,2.65,9.044,2.65c10.851,0,16.784-8.988,16.784-16.785c0-0.255-0.007-0.509-0.016-0.764
	C28.853,7.5,29.853,6.461,30.646,5.277"/>
</svg>


                        </a></span>
                    <span class="mail"><a target="_blank" rel="<?php echo $post->ID; ?>"
                                          user="<?php echo get_current_user_id(); ?>"
                                          href="mailto:?subject= RANGOLI—The YOGASMOGA Community &amp;body=Check out <?php echo $post->post_title; ?> on Rangoli <?php echo $b_pl; ?> ">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 width="32.636px" height="29px" viewBox="0 0 32.636 29"
                                 enable-background="new 0 0 32.636 29" xml:space="preserve">
<g>
    <polygon fill="none" stroke="#FFFFFF" stroke-miterlimit="10" points="1.065,4.688 1.065,24.33 31.4,24.33 31.4,4.688
		16.025,15.509 	"/>
    <polygon fill="none" stroke="#FFFFFF" stroke-miterlimit="10" points="1.065,4.668 30.146,4.668 15.876,14.5 	"/>
</g>
</svg>

                        </a></span>
                    <span class="unknown">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             width="31.646px" height="29px" viewBox="0 0 31.646 29"
                             enable-background="new 0 0 31.646 29" xml:space="preserve">
<path fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M9.081,20.807c2.153,0.846,4.749,1.271,7.543,1.271
	c7.452,0,13.493-3.025,13.493-8.962s-6.041-8.962-13.493-8.962c-7.451,0-13.492,3.025-13.492,8.962c0,2.359,0.954,4.258,2.57,5.69
	l-4.173,4.917L9.081,20.807z"/>
</svg>
                    </span>
            <?php wpfp_link(); ?>
        </div>


        <div class="post_comments" style="display: block;">
            <p class="comments_heading">COMMENTS</p>
            <?php echo get_post_comments($post->ID); ?>

        </div>
    </div>
    <?php
    get_footer();
}
else{
    wp_redirect(get_site_url());
}


?>
