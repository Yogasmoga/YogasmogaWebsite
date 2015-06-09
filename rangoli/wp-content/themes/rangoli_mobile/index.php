<?php
get_header();
//if(!is_post()){
//    wp_redirect(get_site_url());
//}
$post = get_post();
if($post->post_type!="post" && $post->post_status!="publish" ){
    wp_redirect(get_site_url());
}
?>
<div class="author_post_read">
    <?php echo get_the_post_thumbnail($post->ID, "mobile_posts");
    if(!has_post_thumbnail()){
        echo '<img src="'.$home.'/wp-content/themes/rangoli_mobile/images/no-background_posts.png" />';
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
            <div class="post_author">with <span><?php $post_author = get_userdata($post->post_author); echo $post_author->display_name; ?></span></div>
        </div>
        <?php
        $post_author_image_urls = get_user_meta($post->post_author, 'cupp_upload_meta');
        $post_author_image_url =$post_author_image_urls[0];
        if($post_author_image_url==""){
            $post_author_image_url = $home."/wp-content/themes/rangoli_mobile/images/default.jpg";
        }
        ?>
        <div class="author_picture" style="background: url('<?php echo $post_author_image_url; ?>') no-repeat; background-position: center center; background-size: cover"></div>
    </div>
    <div class="share_post_index user-color-shade-trans" style="display: block; margin-top: 0px; border: none;"></div>
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

    echo apply_filters('the_content',$post->post_content);


    $comment_array = get_approved_comments($post->ID);
    $comm_no = count($comment_array);
    $key="wpfp_favorites";
    $favorite_count_check = get_post_meta($post->ID, $key, true);

    echo "<p class='comments_no'>$favorite_count_check Likes &nbsp;&nbsp; $comm_no Comments</p>";


    if(has_category("learn")) {
        echo get_the_look($post);
    }
                $post_link = get_permalink($post->ID);
                $b_pl = get_bitly_url($post_link);
                ?>
    <div class="sharing_box user-color-shade-trans" >
                    <span class="facebook"><a target="_blank" user="<?php echo get_current_user_id(); ?>"
                                              href="https://www.facebook.com/sharer/sharer.php?app_id=909386705751971&u=<?php echo $b_pl; ?>"></a> </span>
                    <span class="twitter"><a target="_blank" rel="<?php echo $post->ID; ?>"
                                             user="<?php echo get_current_user_id(); ?>"
                                             href="http://twitter.com/intent/tweet?text=<?php echo $post->post_title; ?>&url=<?php echo $b_pl; ?>"></a></span>
                    <span class="mail"><a target="_blank" rel="<?php echo $post->ID; ?>"
                                          user="<?php echo get_current_user_id(); ?>"
                                          href="mailto:?subject= RANGOLI—The YOGASMOGA Community &amp;body=Check out <?php echo $post->post_title; ?> on Rangoli <?php echo $b_pl; ?> "></a></span>
        <span class="unknown"></span>
        <?php wpfp_link(); ?>
    </div>





    <div class="post_comments"  style="display: block;">
        <p class="comments_heading">COMMENTS</p>
        <?php echo get_post_comments($post->ID); ?>

    </div>
</div>
<?php
get_footer();
?>
