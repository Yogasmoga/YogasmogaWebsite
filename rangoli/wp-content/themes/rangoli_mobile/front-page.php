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
            echo get_the_post_thumbnail($post->ID, 'mobile_slider');
            ?>
            <div class='over-the-slide homepage_page_banner'
                 onclick="window.location='<?php $url = get_post_meta($post->ID, "wpcf-posturl");
                 echo $url[0]; ?>'">
                <?php
                if (has_post_video()) {
                    $authors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
                    $author_color = '#' . $authors[0]->color_shade;
                    ?>
                    <div class="play-video" video="<?php echo get_the_post_video_url($post->ID); ?>">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="44px" height="44px"
                             viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">                    <defs>
                            </defs>
                            <path fill="<?php echo $author_color; ?>"
                                  opacity="0.9" enable-background="new"
                                  d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                    </svg>
                    </div>
                    <?php
                }
                $slide = get_post();
                $post_author = get_userdata($slide->post_author);
                $display_name = $post_author->display_name;

                echo "<div class='slide_post_text'>";
                echo "<p class='slider_post_name'>" . get_the_title() . "</p>";
                echo "<p class='slider_post_author'><span>by</span> " . $display_name . "</p>";
                echo "</div>";

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
<div class="all_categories_block row lh0">
    <div class="category_block">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px" y="0px"
             viewBox="0 0 89.9 89.6" style="enable-background:new 0 0 89.9 89.6;" xml:space="preserve">
<style type="text/css">
    .str0 {
        fill: #45B649;
    }

    .str1 {
        fill: none;
        stroke: #FFFFFF;
        stroke-miterlimit: 10;
    }
</style>
            <rect id="XMLID_17_" x="0" y="0.1" class="str0" width="90.3" height="89.5"/>
            <g id="XMLID_11_">
                <polygon id="XMLID_13_" class="str1" points="23.7,61.1 45.1,58.9 45.1,30.8 23.7,28.7 	"/>
                <polygon id="XMLID_12_" class="str1" points="66.6,61.1 45.1,58.9 45.1,30.8 66.6,28.7 	"/>
            </g>
</svg>
    </div>
    <div class="category_block">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px" y="0px"
             viewBox="0 0 89.9 89.6" style="enable-background:new 0 0 89.9 89.6;" xml:space="preserve">
<style type="text/css">
    .stw0 {
        fill: #4990CD;
    }

    .stw1 {
        fill: none;
        stroke: #FFFFFF;
        stroke-miterlimit: 10;
    }
</style>
            <rect id="XMLID_16_" x="0" y="0.1" class="stw0" width="90.3" height="89.5"/>
            <g id="XMLID_8_">
                <circle id="XMLID_10_" class="stw1" cx="45.1" cy="44.8" r="6.6"/>
                <path id="XMLID_9_" class="stw1" d="M45.1,33.9c-9.3,0-17.6,4.3-23,10.9c5.4,6.7,13.7,10.9,23,10.9c9.3,0,17.6-4.3,23-10.9
		C62.7,38.2,54.4,33.9,45.1,33.9z"/>
            </g>
</svg>
    </div>
    <div class="category_block">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px" y="0px"
             viewBox="0 0 89.9 89.6" style="enable-background:new 0 0 89.9 89.6;" xml:space="preserve">
<style type="text/css">
    .stl0 {
        fill: #F26822;
    }

    .stl1 {
        fill: none;
        stroke: #FFFFFF;
        stroke-miterlimit: 10;
    }
</style>
            <rect id="XMLID_15_" x="0" y="0.1" class="stl0" width="90.3" height="89.5"/>
            <g id="XMLID_5_">
                <path id="XMLID_7_" class="stl1" d="M45.1,28.2c-6.8,0-12.4,5.5-12.4,12.4c0,3.3,0.9,5.4,3.3,8.4c2.4,3,3.5,5.2,3.5,8.6v4h11.2v-4
		c0-3.3,1-5.5,3.5-8.6c2.4-3,3.3-5.2,3.3-8.4C57.5,33.7,52,28.2,45.1,28.2z"/>
                <line id="XMLID_6_" class="stl1" x1="39.4" y1="55.6" x2="50.9" y2="55.6"/>
            </g>
</svg>
    </div>
    <div class="category_block">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px" y="0px"
             viewBox="0 0 89.9 89.6" style="enable-background:new 0 0 89.9 89.6;" xml:space="preserve">
<style type="text/css">
    .stlo0 {
        fill: #AE8637;
    }

    .stlo1 {
        fill: none;
        stroke: #FFFFFF;
        stroke-miterlimit: 10;
    }
</style>
            <rect id="XMLID_14_" x="-0.4" y="0.1" class="stlo0" width="90.3" height="89.5"/>
            <g id="XMLID_2_">
                <path id="XMLID_4_" class="stlo1" d="M26.8,35.1c-2.2,2.2-2.2,5.9,0,8.1l1.7,1.7l-1.7,1.7c-2.2,2.2-2.2,5.9,0,8.1
		c2.2,2.2,5.9,2.2,8.1,0l9.8-9.8l-9.8-9.8C32.7,32.9,29.1,32.9,26.8,35.1z"/>
                <path id="XMLID_3_" class="stlo1" d="M62.7,35.1c2.2,2.2,2.2,5.9,0,8.1L61,45l1.7,1.7c2.2,2.2,2.2,5.9,0,8.1c-2.2,2.2-5.9,2.2-8.1,0
		L44.8,45l9.8-9.8C56.8,32.9,60.5,32.9,62.7,35.1z"/>
            </g>
</svg>

    </div>
</div>
<?php /////////////////////POSTS and Profiles//////////////////////////////////// ?>
<div class="homepagegrid">
<!-- -------------------------------READ LATEST POST---------------------------------- -->
<?php

    $args = array(
        'category_name' => 'read',
        'order' => 'DESC',
        'post_type' => 'post',
        'numberposts' => 1);
    $the_query = new WP_Query($args);

    if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
        $post = get_post();
?>
        <div class="author_post_read read_section">
            <?php echo get_the_post_thumbnail($post->ID, "mobile_posts");
            if (!has_post_thumbnail()) {
                echo '<img src="' . $home . '/wp-content/themes/rangoli_mobile/images/no-background_posts.png" />';
            }
            ?>
        </div>
        <div class="featured_post_title">
            <svg width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 50 34.4" style="enable-background:new 0 0 50 34.4;" xml:space="preserve">
                <style type="text/css">
                    .wh{fill:none;stroke:#555; stroke-width: 2px; stroke-miterlimit:10;}
                </style>
                <g>
                    <polygon class="wh" points="3,33.2 24.4,31 24.4,2.9 3,0.8 	"/>
                    <polygon class="wh" points="45.9,33.2 24.4,31 24.4,2.9 45.9,0.8 	"/>
                </g>
            </svg>
            <div class="align_bottom">
                <div class="post_category"><?php echo get_post_categories(); ?></div>
                <div class="post_title"><?php echo $post->post_title; ?></div>
                <div class="post_author">with <span><?php echo $post_author->display_name; ?></span></div>
            </div>
        </div>

<?php
    break;
    endwhile;
    endif;

    $args = array(
        'category_name' => 'look',
        'order' => 'DESC',
        'post_type' => 'post',
        'numberposts' => 1);
    $the_query = new WP_Query($args);

    if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
        $post = get_post();
        ?>
        <div class="author_post_read look_section">
            <?php echo get_the_post_thumbnail($post->ID, "mobile_posts");
            if (!has_post_thumbnail()) {
                echo '<img src="' . $home . '/wp-content/themes/rangoli_mobile/images/no-background_posts.png" />';
            }
            ?>

            <?php
            if(has_post_video()){
                $authors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
                $author_color = '#' . $authors[0]->color_shade;
                ?>
                <div class="video">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="44px" height="44px"
                         viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">                    <defs>
                        </defs>
                        <path fill="<?php echo $author_color; ?>"
                              opacity="0.9" enable-background="new"
                              d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                            </svg>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="featured_post_title">
            <svg width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 48.9 24" style="enable-background:new 0 0 48.9 24;" xml:space="preserve">
                <style type="text/css">
                    .wh{fill:none;stroke:#555; stroke-width: 2px; stroke-miterlimit:10;}
                </style>
                <g id="XMLID_40_">
                    <circle id="XMLID_42_" class="wh" cx="24.4" cy="12.1" r="6.6"/>
                    <path id="XMLID_41_" class="wh" d="M24.4,1.3c-9.3,0-17.6,4.3-23,10.9c5.4,6.7,13.7,10.9,23,10.9c9.3,0,17.6-4.3,23-10.9
                C42,5.5,33.7,1.3,24.4,1.3z"/>
                </g>
            </svg>
            <div class="align_bottom">

                <div class="post_category"><?php echo get_post_categories(); ?></div>
                <div class="post_title"><?php echo $post->post_title; ?></div>
                <div class="post_author">with <span><?php echo $post_author->display_name; ?></span></div>
            </div>
        </div>

        <?php
        break;
    endwhile;
    endif;

    $args = array(
        'category_name' => 'learn',
        'order' => 'DESC',
        'post_type' => 'post',
        'numberposts' => 1);
    $the_query = new WP_Query($args);

    if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
        $post = get_post();
        ?>
        <div class="author_post_read learn_section">
            <?php echo get_the_post_thumbnail($post->ID, "mobile_posts");
            if (!has_post_thumbnail()) {
                echo '<img src="' . $home . '/wp-content/themes/rangoli_mobile/images/no-background_posts.png" />';
            }
            ?>
            <?php
            if(has_post_video()){
                $authors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
                $author_color = '#' . $authors[0]->color_shade;
                ?>
                <div class="video">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="44px" height="44px"
                         viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">                    <defs>
                        </defs>
                        <path fill="<?php echo $author_color; ?>"
                              opacity="0.9" enable-background="new"
                              d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                        </svg>
                </div>
                <?php
            }
            ?>

        </div>
        <div class="featured_post_title">
            <svg width="23px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 48.9 38.3" style="enable-background:new 0 0 48.9 38.3;" xml:space="preserve">
                <style type="text/css">
                    .wh{fill:none;stroke:#555; stroke-width: 2px; stroke-miterlimit:10;}
                </style>
                <g id="XMLID_40_">
                    <path id="XMLID_42_" class="wh" d="M24.4,1c-7.4,0-13.3,6-13.3,13.3c0,3.5,1,5.8,3.6,9.1c2.6,3.3,3.7,5.6,3.7,9.2V37h12v-4.4
                c0-3.6,1.1-6,3.7-9.2c2.6-3.3,3.6-5.6,3.6-9.1C37.8,7,31.8,1,24.4,1z"/>
                    <line id="XMLID_41_" class="wh" x1="18.2" y1="30.7" x2="30.6" y2="30.7"/>
                </g>
            </svg>
            <div class="align_bottom">

                <div class="post_category"><?php echo get_post_categories(); ?></div>
                <div class="post_title"><?php echo $post->post_title; ?></div>
                <div class="post_author">with <span><?php echo $post_author->display_name; ?></span></div>
            </div>
        </div>

        <?php
        break;
    endwhile;
    endif;

    $args = array(
        'post_type' => 'iloveyogasmoga',
        'order' => 'DESC',
        'numberposts' => 1);

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
        $post = get_post();
        ?>
        <div class="author_post_read love_section">
            <?php echo get_the_post_thumbnail($post->ID, "mobile_posts");
            if (!has_post_thumbnail()) {
                echo '<img src="' . $home . '/wp-content/themes/rangoli_mobile/images/no-background_posts.png" />';
            }
            ?>

        </div>
        <div class="featured_post_title">
            <svg width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 48.9 25.3" style="enable-background:new 0 0 48.9 25.3;" xml:space="preserve">
                <style type="text/css">
                    .st0-love{fill:none;stroke:#555 !important; stroke-width: 2px; stroke-miterlimit:10;}
                </style>
                <g id="XMLID_40_">
                    <path id="XMLID_42_" class="st0-love" d="M6.5,2.8c-2.2,2.2-2.2,5.9,0,8.1l1.7,1.7l-1.7,1.7c-2.2,2.2-2.2,5.9,0,8.1
                c2.2,2.2,5.9,2.2,8.1,0l9.8-9.8l-9.8-9.8C12.4,0.6,8.7,0.6,6.5,2.8z"/>
                    <path id="XMLID_41_" class="st0-love" d="M42.4,2.8c2.2,2.2,2.2,5.9,0,8.1l-1.7,1.7l1.7,1.7c2.2,2.2,2.2,5.9,0,8.1
                c-2.2,2.2-5.9,2.2-8.1,0l-9.8-9.8l9.8-9.8C36.5,0.6,40.2,0.6,42.4,2.8z"/>
                </g>
            </svg>
            <div class="align_bottom">
                <div class="post_category"><?php echo get_post_categories(); ?></div>
                <div class="post_title"><?php echo $post->post_title; ?></div>
                <div class="post_author">with <span><?php echo $post_author->display_name; ?></span></div>
            </div>
        </div>

        <?php
        break;
    endwhile;
    endif;

?>

</div>

<?php

get_footer();

?>
