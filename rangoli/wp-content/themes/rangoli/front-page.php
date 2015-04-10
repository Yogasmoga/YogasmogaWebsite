<?php

get_header();
?>


        <!--- Flex slider--------- -->
        <div class="flexslider">
            <div class="rangoli_logo">
                <img src="<?php bloginfo('template_directory') ?>/images/logo.png"/>
            </div>
            <?php if (!is_user_logged_in()) {
    ?>
    <div id="signup_signin_btn">
        Sign in / Sign up
    </div>
<?php
}
?>
<ul class="slides">
<?php
$args = array(
    "post_type" => "slider",
);
$the_query = new WP_Query($args);
if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
    $post = get_post();
    echo " <li>";
    echo get_the_post_thumbnail();
    ?>
    <!--onclick='ajax_load_pages("<?php /*$url = get_post_meta($post->ID,"wpcf-posturl");  if($url){echo $url[0];} */ ?>")'-->
    <div class='over-the-slide homepage_page_banner' >
<?php
//    echo "<p class='post_category'>" . get_the_title() . "</p>";
//    echo "<p class='post_text'>" . get_the_excerpt() . "</p>";
//    echo "<p class='post_author' style='text-transform: none'>by <span>" . get_the_author() . "</span></p>";
    if (has_post_video()) {

        $authors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
        $author_color = '#' . $authors[0]->color_shade;
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
    }


    echo "</div>";



    if (has_post_video()) {
        echo "<div class='play_video'>";
//            echo "<iframe height='100%' width='100%' src='".get_the_post_video_url($post->ID)."'></iframe>";
        the_post_video();
        echo "</div> ";
    }


    echo "</li>";

endwhile;
endif;
?>

            </ul>

        </div>

        <section class="first">
            <div class="pad3 grey align-center">
                <p class="bold"> DISCOVER, SHARE, ENJOY</p>

                <p class="light"><span>OUR COMMUNITY IN COLOR</span></p>

                <p class="freighttextbook">At YOGASMOGA, we recognize the important role color has in shaping our world. <br/>
                    Color gives meaning and dimension – we use it to express the connections we make and express who we are. <br/>
                    Our relationship with color defines RANGOLI: a journey of content, conversation and connection.</p>
            </div>
        </section>




        <?php
get_template_part("content");
?>
        <section class="fifth">
        <div class="row">
            <div class="one-three left facebook"  style="background: #2D9630;">
                    <?php
                    $post = get_post(523);
                    ?>
                    <?php echo get_the_post_thumbnail($post->ID,"thumb");
                    if(!has_post_thumbnail($post->ID)){
                    echo '<img src="'.get_site_url().'/wp-content/themes/rangoli/images/no-background.png" style="width:100%;float:left;"/>';
                    }
                    ?>

                    <div onclick="ajax_load_pages('<?php echo get_permalink($post->ID) ?>')" class="overlay-text">
                    <p class="post_category"><?php echo category($post->ID); ?></p>

                    <p class="post_title"><?php echo $post->post_title; ?></p>
                    <?php
                    if (has_post_video()) {
                    ?>
                    <div class="play-video">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px"
                    viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                    <defs>
                    </defs>
                    <path fill="<?php $author = get_user_profile($post->post_author);
                    echo '#' . $author->color_shade; ?>"
                    d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>

                    </svg>
                    </div>
                    <?php
                    }
                    ?>



                    </div>
                    <p class="post_link"><a  class="ajax-load"  class="ajax-load"  href="<?php echo get_site_url(); ?>/look">Look More</a></p>







            </div>

  <!--          <div class="one-three left instagram"  style="background:#802780;">
                <?php
/*echo do_shortcode("[fts instagram instagram_id=14781732 super_gallery=yes image_size=500px icon_size=0px space_between_photos=1px hide_date_likes_comments=yes center_container=yes image_stack_animation=no type=user]");
*/ ?>
            </div>
-->


            <div class="one-three left twitter">
                <div class="flexslider">
                    <ul class="slides" style="background:#6D3ABB;">
                        <li>

                        <?php
echo get_template_part("hashtweets");
?>
                        </li>
                        <li>
                        <?php
echo get_template_part("latest_rangoli_instagram");
?>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="one-three left twitter" style="background: #6d3abb;">


     <?php
            $post = get_post(433);
            ?>
            <?php echo get_the_post_thumbnail($post->ID,"thumb");
            if(!has_post_thumbnail($post->ID)){
                echo '<img src="'.get_site_url().'/wp-content/themes/rangoli/images/no-background.png" style="width:100%;float:left;"/>';
            }
            ?>

            <div onclick="ajax_load_pages('<?php echo get_permalink($post->ID) ?>')" class="overlay-text">
            <p class="post_category"><?php echo category($post->ID); ?></p>

            <p class="post_title"><?php echo $post->post_title; ?></p>
            <?php
            if (has_post_video()) {
            ?>
            <div class="play-video">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px"
            viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
            <defs>
            </defs>
            <path fill="<?php $author = get_user_profile($post->post_author);
            echo '#' . $author->color_shade; ?>"
            d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>

            </svg>
            </div>
            <?php
            }
            ?>



            </div>
            <p class="post_link"><a  class="ajax-load"  class="ajax-load"  href="<?php echo get_site_url(); ?>/look">Look More</a></p>





            </div>
        </div>
</section>
    </div>

<?php

get_footer();

?>