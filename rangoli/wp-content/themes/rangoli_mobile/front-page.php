<?php
get_header();
$home = get_site_url();
?>
<div class="flexslider homepage_slider">
    <ul class="slides">
        <?php
        $args = array(
            "post_type" => "slider",
        );
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()):while ($the_query->have_posts()):
        $the_query->the_post();
        $post = get_post();
        $banner_img_url = "";
        ?>
        <li>
            <?php
            echo get_the_post_thumbnail($post->ID, mobile_slider);
            ?>
            <div class='over-the-slide homepage_page_banner' onclick="window.location='<?php echo get_permalink() ?>'">
                <?php
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
                    the_post_video();
                    echo "</div> ";
                }
                echo "</li>";
                endwhile;
                endif;
                ?>
    </ul>

</div>

<?php /////////////////////POSTS and Profiles//////////////////////////////////// ?>


<?php
$args = array(
    "post_type" => "home-grid"
);
$i = 0;
$the_query = new WP_Query($args);
if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
    $post = get_post();
    $class = "half";
    $banner_size = "mobile_posts_half";
    $interest_name = "";
    $category_name = "";
    $target_url = "";
    if ($i == 0 || $i % 3 == 0) {
        $class = "full";
        $banner_size = "mobile_posts";
    }
    $interests = get_post_meta($post->ID, 'wpcf-interest-type');
    if (is_array($interests) && count($interests) > 0)
        $interest_name = $interests[0];

    $categories = get_post_meta($post->ID, 'wpcf-category');
    if (is_array($categories) && count($categories) > 0)
        $category_name = $categories[0];

    $target_urls = get_post_meta($post->ID, 'wpcf-target-url');
    if (is_array($target_urls) && count($target_urls) > 0)
        $target_url = $target_urls[0];

    if ($post->post_title != "Invite friends") {
        ?>
    <div class="homepage_post <?php echo $class ?>">
        <?php echo get_the_post_thumbnail($post->ID, $banner_size); ?>
        <?php if (!has_post_thumbnail()) {
            if ($class == "half")
                echo "<img src='" . $home . "/wp-content/themes/rangoli_mobile/images/no-background.png' />";
            else
                echo "<img src='" . $home . "/wp-content/themes/rangoli_mobile/images/no-background_posts.png' />";
        } ?>
        <div class="overlay-text">

            <div class="post_category">
                <?php echo $interest_name; ?>
            </div>
            <?php
        if (!has_post_video($post->ID)) {
            if ($class == "full")
                echo '<div class="post_title"><a class="no_load" href="' . get_the_permalink($post->ID) . '">' . $post->post_title . '</a></div>';
        } else {
            $author = get_user_profile($post->post_author);
            $author_color = '#' . $author->color_shade;
            ?>
            <div class="play-video" video="<?php echo get_the_post_video_url($post->ID); ?>">
                <a class="no_load" href="<?php echo get_the_permalink($post->ID); ?>">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px"
                         viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">                    <defs>
                        </defs>
                        <path fill="<?php echo $author_color; ?>"
                              opacity="0.9" enable-background="new"
                              d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                                    </svg>
                </a>
            </div>
        <?php
        }

        ?>
        <?php if ($post->post_title != "Invite friends") ?>
            <div class="post_bottom_link"><a href="<?php echo $home . "/" . $category_name ?>"><?php echo $category_name; ?> More</a></div>
        </div>
    </div>

    </div>
    <?php
    } else {
        ?>
        <div class="homepage_post <?php echo $class ?>">
            <?php
            if ($class == "half")
                echo "<img src='" . $home . "/wp-content/themes/rangoli_mobile/images/no-background.png' />";
            else
                echo "<img src='" . $home . "/wp-content/themes/rangoli_mobile/images/no-background_posts.png' />";

            ?>
            <div class="overlay-text invite-friend">
                <div class="text-center"> Invite<br> friends</div>
            </div>
        </div>
    <?php
    }
    $i++;
endwhile;
endif;


get_footer();

?>
