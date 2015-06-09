<?php
get_header();
$author_id = get_current_user_id();
$author_data = get_userdata($author_id);
$name = strtoupper($author_data->display_name);
$author_profile = get_user_profile($author_id);
$color = '#' . $author_profile->color_shade;
?>
        <?php
            $user_favs = wpfp_get_users_favorites($author_data->user_login);

            if(is_array($user_favs) && count($user_favs)>0) {
                foreach ($user_favs as $post_id) {

                    if (isset($post_id) && !empty($post_id)) {

                        $post = get_post($post_id);
                        $post_author = get_userdata($post->post_author);
                        ?>
                        <div>
                            <div class="author_post_read_author" style="background:<?php echo $color; ?>">
                                <?php
                                echo get_the_post_thumbnail($post->ID, "mobile_posts");
                                if (!has_post_thumbnail($post_id)) {

                                    ?>
                                    <img
                                        src="<?php bloginfo('template_directory') ?>/images/no-background_posts.png"
                                        style="width:100%;float:left;"/>
                                <?php
                                }
                                ?>
                                <div class="overlay-text"
                                     onclick="window.location='<?php echo get_permalink(); ?>'">
                                    <?php
                                    if (has_post_video()) {

                                        ?>
                                        <div class="play-video" video="<?php echo get_the_post_video_url($post->ID); ?>">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                                            <defs>
                                            </defs>
                                                <path fill="<?php echo $color; ?>"
                                                      opacity="0.9" enable-background="new" d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                                            </svg>
                                        </div>
                                    <?php
                                    }

                                    ?>
                                    <div class="align_bottom">
                                        <div class="post_category"><?php echo get_post_categories(); ?></div>
                                        <div class="post_title"><?php echo $post->post_title; ?></div>
                                        <div class="post_author">with
                                            <span><?php echo $post_author->display_name; ?></span></div>
                                    </div>
                                    <?php
                                    $post_author_image_urls = get_user_meta($post->post_author, 'cupp_upload_meta');
                                    $post_author_image_url = $post_author_image_urls[0];
                                    if ($post_author_image_url == "") {
                                        $post_author_image_url = get_site_url() . "/wp-content/themes/rangoli_mobile/images/default.jpg";
                                    }
                                    ?>
                                    <div class="author_picture"
                                         style="background: url('<?php echo $post_author_image_url; ?>') no-repeat; background-position: center center; background-size: cover"></div>
                                </div>

                                <div class="close_post user-color-shade-trans"></div>
                                <div class="share_post user-color-shade-trans"></div>

                            </div>

                            <div class="post_content">
                                <?php echo apply_filters('the_content', $post->post_content); ?>
                                <?php
                                $post_link = get_permalink($post->ID);
                                $b_pl = get_bitly_url($post_link);
                                ?>
                                <div class="sharing_box user-color-shade-trans">
                <span class="facebook"><a target="_blank"
                                          href="https://www.facebook.com/sharer/sharer.php?app_id=909386705751971&u=<?php echo $b_pl; ?>"></a> </span>
                <span class="twitter"><a target="_blank" rel="<?php echo $post->ID; ?>"
                                         user="<?php echo get_current_user_id(); ?>"
                                         href="http://twitter.com/intent/tweet?text=<?php echo $post->post_title; ?>&url=<?php echo $b_pl; ?>"></a></span>
                <span class="mail"><a target="_blank" rel="<?php echo $post->ID; ?>"
                                      user="<?php echo get_current_user_id(); ?>"
                                      href="mailto:?subject= RANGOLI—The YOGASMOGA Community &amp;body=Check out <?php echo $post->post_title;?> on Rangoli <?php echo $b_pl; ?> "></a></span>
                                    <span class="unknown"></span>
                                    <?php wpfp_link(); ?>
                                </div>
                                <div class="post_comments">
                                    <p class="comments_heading">COMMENTS</p>
                                    <?php echo get_post_comments($post->ID); ?>

                                </div>
                            </div>
                        </div>
                    <?php
                    }
                }
            }
        ?>


<?php

get_footer();
?>