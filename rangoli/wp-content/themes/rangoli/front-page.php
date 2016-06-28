<?php

get_header();
?>

    <!--- HOME PAGE MAIN SLIDER (Flex slider)--------- -->
    <div class="flexslider homepage_slider">
        <div class="rangoli_logo">
            <img src="<?php bloginfo('template_directory') ?>/images/logo.png"/>
        </div>
        <ul class="slides">
            <?php
            $readIdObj = get_category_by_slug('read');
            $readId = $readIdObj->term_id;

            $lookIdObj = get_category_by_slug('look');
            $lookId = $lookIdObj->term_id;

            $learnIdObj = get_category_by_slug('learn');
            $learnId = $learnIdObj->term_id;


            $args = array(
                "post_type" => "post",
                "posts_per_page" => 5,
                "terms"=> array($readId,$lookId,$learnId)
            );
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
                $post = get_post();
                if (has_category("read", $post) || has_category("learn", $post) || has_category("look", $post)) {
                    $i++;

                    $authors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
                    $author_color = '#' . $authors[0]->color_shade;
                    $author = get_userdata($post->post_author);
                    $name = $author->display_name;
                    if ($name) {
                        $name = "<span>by</span> " . $name;
                    }

                    ?>
                    <li style="background: <?php echo $author_color; ?>">
                        <?php
                        if (has_post_thumbnail($post->ID)) {
                            echo get_the_post_thumbnail();
                        } else {
                            $imgUrl = get_bloginfo("template_url") . "/images/no-slide.png";
                            echo "<img src='$imgUrl' />";
                        }
                        ?>
                        <div class='over-the-slide homepage_page_banner'
                             onclick='ajax_load_pages("<?php $url = get_the_permalink($post->ID);
                             if ($url) {
                                 echo $url;
                             } ?>")'>
                            <?php
                            if (has_post_video()) {
                                ?>
                                <div class="play-video" video="<?php echo get_the_post_video_url($post->ID); ?>">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px"
                                         height="64px"
                                         viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">                    <defs>
                                        </defs>
                                        <path fill="<?php echo $author_color; ?>"
                                              opacity="0.9" enable-background="new"
                                              d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                    </svg>
                                </div>
                                <?php
                            }
                            echo "<div class='post_excerpt_slider'><p class='slider_post_title'><span>$post->post_title</span></p> $post->post_excerpt
                        <p class='slider_post_author'>$name</p>

                        </div>";

                            echo "</div>";


                            ?>
                    </li>
                    <?php
                }
            endwhile;
            endif;
            ?>
        </ul>
    </div>

    <!-- RANGOLI SLOGAN BLOCK ----------- -->
    <section class="row">
        <div class="pad3 grey align-center">
            <h1 class="bold"> RANGOLI<span>—The YOGASMOGA Community</span></h1>

            <h2 class="light"><span>CULTURE, CONVERSATION, CONNECTION</span></h2>

        </div>
    </section>

    <!-- ---- HOME PAGE GRID ARRAY (needs only to be changed to update page Grid) --- -->
<?php
$blockSettings = [
    [
        'blockType' => 'post',
        'id' => '6713',
        'category' => 'read'
    ],
    [
        'blockType' => 'post',
        'id' => '6003',
        'category' => 'read'
    ],
    [
        'blockType' => 'post',
        'id' => '6656',
        'category' => 'read'
    ],
    [
        'blockType' => 'post',
        'id' => '6419',
        'category' => 'read'
    ],
    [
        'blockType' => 'post',
        'id' => '6435',
        'category' => 'look'
    ],
    [
        'blockType' => 'post',
        'id' => '6192',
        'category' => 'read'
    ],
    [
        'blockType' => 'post',
        'id' => '6447',
        'category' => 'read'
    ],
    [
        'blockType' => 'post',
        'id' => '6313',
        'category' => 'read'
    ],
    [
        'blockType' => 'post',
        'id' => '5799',
        'category' => 'read'
    ],
    [
        'blockType' => 'post',
        'id' => '6664',
        'category' => 'read'
    ],
    [
        'blockType' => 'love',
        'id' => 'N/A',
        'category' => 'N/A'
    ],
    [
        'blockType' => 'post',
        'id' => '4517',
        'category' => 'read'
    ]
];

/////////////////////////////////////////////////////////////////
//////////////GENERATING BLOCKS USING ARRAY ABOVE ///////////////
/////////////////////////////////////////////////////////////////
$i = 1;
foreach ($blockSettings as $block) {
    echo "<!-- -------------BLOCK $i-------------- -->";

    if ($i == 4) {
        $class = "two-three left double-width";
    } else {
        $class = "one-three left";
    }

//    if($i==1 || $i==4 || $i==7 || $i==10){
    if ($i == 1 || ($i - 1) % 3 == 0) {
        echo "<section class='row'>";
    }
    ///////////////////////////////////////////////////////////////
    ///////////////////POST BLOCK GENERATOR////////////////////////
    ///////////////////////////////////////////////////////////////
    if ($block["blockType"] == "post") {
        $post = get_post($block["id"]);
        $category = $block["category"];
        $author = get_user_profile($post->post_author);
        ?>
        <div class="<?php echo $class; ?>">
            <?php echo get_the_post_thumbnail($post->ID, "thumb");
            if (!has_post_thumbnail($post->ID)) {
                echo '<img src="' . get_site_url() . '/wp-content/themes/rangoli/images/no-background.png" style="width:100%;float:left;"/>';
            }
            ?>

            <div onclick="ajax_load_pages('<?php echo get_permalink($post->ID) ?>')" class="overlay-text">
                <p class="post_category"><?php echo category($post->ID); ?></p>

                <?php if (has_post_video($post->ID)) { ?>
                    <div class="play-video">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px"
                             viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                        <defs>
                        </defs>
                            <path fill="<?php echo '#' . $author->color_shade; ?>"
                                  d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>

                        </svg>
                    </div>
                <?php } else { ?>
                    <p class="post_title"><?php echo $post->post_title; ?></p>
                <?php } ?>


            </div>
            <p class="post_link"><a class="ajax-load" class="ajax-load"
                                    href="<?php echo get_site_url() . "/" . $category; ?>"><?php echo $category; ?>
                    More</a></p>
        </div>

        <?php
    }
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////


    ///////////////////////////////////////////////////////////////
    ///////////////////AUTHOR BLOCK GENERATOR//////////////////////
    ///////////////////////////////////////////////////////////////
    if ($block["blockType"] == "author") {
        $authorID = $block["id"];
        $author = get_userdata($authorID);
        $category = $block["category"];
        $author_banner_url = get_the_author_meta("author_profile_picture", $authorID);
        ?>
        <div class="<?php echo $class; ?>">
            <?php

            if ($author_banner_url) {
                echo '<div style="background:url(\'' . $author_banner_url . '\'); background-size: cover; background-position: center center; float:left; width:100%;">';
                ?>
                <img src="<?php echo get_site_url() ?>/wp-content/themes/rangoli/images/no-background.png"
                     style="float: left; width: 100%"/>
                <?php
                echo "</div>";
            }

            ?>
            <div onclick="ajax_load_pages('<?php echo get_author_posts_url($authorID); ?>')" class="overlay-text">
                <p class="post_category">SMOGI</p>

                <p class="post_title"><?php echo strtoupper($author->display_name) ?></p>

                <p class="post_link"><a class="ajax-load" href="<?php echo get_author_posts_url($authorID); ?>">MEET
                        OUR SMOGIs</a></p>


            </div>


        </div>

        <?php
    }
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////


    ///////////////////////////////////////////////////////////////
    ///////////////////LOVE BLOCK GENERATOR////////////////////////
    ///////////////////////////////////////////////////////////////
    if ($block["blockType"] == "love") {
        ?>
        <div class="<?php echo $class; ?>">
            <div class="flexslider">
                <ul class="slides">
                    <?php
                    $args = array(
                        "post_type" => "iloveyogasmoga",
                        "posts_per_page" => 5
                    );
                    $the_query = new WP_Query($args);
                    if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
                        $post = get_post();
                        $wpauthors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
                        $wp_author = $wpauthors[0];
                        $post_url= get_permalink($post->ID);
                        ?>
                        <li>

                            <?php
                            echo get_the_post_thumbnail($post->ID, 'insta_posts', array('style' => 'width:100%; float:left;height:auto;'));
                            if (!has_post_thumbnail($post->ID, 'insta_posts', array('onclick' => '"' . get_the_permalink() . '"'))) {

                                ?>
                                <img src="<?php bloginfo('template_directory') ?>/images/no-background.png"
                                     style="width:100%;float:left;"/>
                                <?php
                            }
                            ?>


                            <div onclick="ajax_load_pages('<?php echo get_permalink($post->ID) ?>')" class="overlay-text">
                                <p class="post_category"><?php echo category($post->ID); ?></p>

                                <p class="post_title">LOVE, YOGASMOGA</p>

                            </div>

                        </li>
                        <?php
                    endwhile;
                    endif;
                    ?>
                </ul>
            </div>


        </div>

        <?php
    }
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////


    if ($i % 3 == 0) {
        echo "</section>";
    }

    $i++;
}

?>


<?php

get_footer();

?>