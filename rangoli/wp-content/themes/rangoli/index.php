<?php
get_header();
$post=get_post();
$user_id=$post->post_author;
$users = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=".$user_id);
if($users){
$user=$users[0];
$author_color=$user->color_shade;
}
$author_color="555555";

$banner_img_url=wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

    ?>

    <div class="wp_page_banner" style="background: url('<?php echo $banner_img_url[0]; ?>') no-repeat; background-size: cover; <?php echo '#'.$author_color; ?>">
        <?php
            if (isset($current_category)){
                $curr_cat=strtoupper($current_category);
                if($current_category=="read"){
                    echo "<a class='back_to_parent' href='".get_site_url()."/read'>BACK TO $curr_cat</a>";
                }if($current_category=="look"){
                    echo "<a class='back_to_parent' href='".get_site_url()."/look'>BACK TO $curr_cat</a>";
                }if($current_category=="learn"){
                    echo "<a class='back_to_parent' href='".get_site_url()."/learn'>BACK TO $curr_cat</a>";
                }
            }
        ?>
        <?php
        $categories = get_the_category_list(" ");
        $categories_list = strtolower($categories);
        $categories = str_replace('homepage', '', $categories_list);
        $categories = str_replace('read', '', $categories);
        $categories = str_replace('look', '', $categories);
        $categories = str_replace('learn', '', $categories);
        $categories = strtoupper($categories);


        if (has_post_video()) {

            $authors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $user_id);
            $author_color = '#'.$authors[0]->color_shade;
            ?>
            <div class="play-video" video="<?php echo get_the_post_video_url($post->ID); ?>">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                    <defs>
                    </defs>
                    <path fill="<?php echo $author_color; ?>"
                          opacity="0.9" enable-background="new" d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                </svg>
            </div>
        <?php
        }


        echo " <div class='overlay-text'>
                    <div class='align-bottom'>
                        <p class='post_category'>" . $categories . "</p>";


//        echo "<p class='post_title'>" . $title . "</p>";
//        if (!$category[0]) {
                        echo "<p class='post_title'>".$post->post_title."</p>";
                        echo "<p class='post_subtitle'>" . $post->post_excerpt . "<p>";
//        }
//        echo "<p class='post_link'><a href='" . get_the_permalink() . "'>" . $link_text[0] . "</a></p>";
                    echo "</div>
            </div>";

        if(has_post_video()){
            echo "<div class='play_video'>";
                        the_post_video();
            echo "</div>";
        }

        ?>
    </div>



    <div class="row ww post_content_box">
        <div class="twenty">
            <div class="author_details_post">
            <?php
            echo get_template_part("post", "authordetails");
            ?>
            </div>
        </div>

        <div class="sixty">
            <div class="post_content">
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
                                <div class="do_rating" rel="<?php echo $rating; ?>"
                                     post_id="<?php echo $post->ID; ?>">

                                </div>
                            </div>
                        <?php
                        }
                    }
//                }
                echo "<div class='clear'></div>";
                $content = $post->post_content;
                $content = apply_filters('the_content', $content);
                echo ($content);
                if(has_category("learn")) {
                    echo get_template_part("post", "getthelook");
                }
                ?>
            </div>
            <div class="comments row">
                <p class="align-center">COMMENTS</p>

                <?php

                echo get_template_part("post", "comments");
                ?>
            </div>


            <div class="row">
                <?php

//                        if(isset($current_category))
//                        $curr_category=strtoupper($current_category);
//                        else{
//                            $curr_category="POST";
//                            $current_category="read, look, learn";
//                        }
                    if(has_category("read",$post->ID)){
                        $current_category = "READ";
                        $curr_cat = "READING";
                    }
                    elseif(has_category("learn",$post->ID)){
                        $current_category = "LEARN";
                        $curr_cat = "LEARNING";
                    }
                    elseif(has_category("look",$post->ID)){
                        $current_category = "LOOK";
                        $curr_cat = "LOOKING";
                    }
                    else{
                        $current_category ="POST";
                        $curr_cat = "POST";
                    }
//    }
//

                    ?>
                    <p class="align-center heading">OTHER <?php echo $curr_cat  ?>S</p>

                </div>


            </div>


        <div class="right post_right_share_like">
<!--             style="margin-right: 50px;"-->

            <div class="sharing_icons">
                <ul>
                    <?php
                        $post_link = get_permalink($post->ID);
                        $b_pl = get_bitly_url($post_link);
                    ?>
                    <li>
                        <a target="_blank" rel="<?php echo $post->ID; ?>" user="<?php echo get_current_user_id();  ?>" href="https://www.facebook.com/sharer/sharer.php?app_id=853109404769569&u=<?php echo $b_pl; ?>">
                            <img src="/rangoli/wp-content/themes/rangoli/images/fb.png">
                            <img src="/rangoli/wp-content/themes/rangoli/images/fb_hover.png">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" rel="<?php echo $post->ID; ?>" user="<?php echo get_current_user_id();  ?>" href="http://twitter.com/intent/tweet?text=<?php echo $post->post_title;  ?>&url=<?php echo $b_pl; ?>">
                            <img src="/rangoli/wp-content/themes/rangoli/images/tw.png">
                            <img src="/rangoli/wp-content/themes/rangoli/images/tw_hover.png">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" rel="<?php echo $post->ID; ?>" user="<?php echo get_current_user_id();  ?>" href="https://pinterest.com/pin/create/button/?url=<?php echo $b_pl; ?>&media=<?php echo $banner_img_url[0]; ?> ">
                            <img src="/rangoli/wp-content/themes/rangoli/images/pin.png">
                            <img src="/rangoli/wp-content/themes/rangoli/images/pin_hover.png">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" rel="<?php echo $post->ID; ?>" user="<?php echo get_current_user_id();  ?>" href="mailto:?subject= RANGOLI—The YOGASMOGA Community &amp;body=Check out <?php echo $post->post_title; ?> on Rangoli <?php echo $b_pl; ?> ">
                            <img src="/rangoli/wp-content/themes/rangoli/images/mail.png">
                            <img src="/rangoli/wp-content/themes/rangoli/images/mail_hover.png">
                        </a>
                    </li>
                </ul>
            </div>

            <!--<div class="post_share">
                <?php
/*                    echo  get_template_part("shareIcon");
                */?>
            </div>-->


            <div class="single_post_like">
                <?php wpfp_link(); ?>
            </div>
        </div>



        <?php


        echo '<div class="author_posts row index posts_grid" style="clear:both;">';

                if($current_category == "POST"){
                    $current_category = "READ, LEARN, WATCH";
                }

                $current_category = strtolower($current_category);

        $args = array(
            'category_name' => $current_category,
            'order' => 'DESC',
            'post_type' => 'post',
        //            'paged' => $page
            'posts_per_page'=>30
        );
        //                echo $page;
        $the_query = new WP_Query($args);
        $count = 0;
        if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
            $count++;
        endwhile;
        endif;

//echo $count;

        wp_reset_query();

        ob_flush();
        global $the_query;
        $args = array(
            'category_name' => $current_category,
            'order' => 'DESC',
            'post_type' => 'post',
            'posts_per_page'=>30
        );
        $the_query = new WP_Query($args);
        $i = 0;
        if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
//            $i++;
            $post=get_post();
            $author = get_user_profile($post->post_author);
            $author_color=$author->color_shade;
            if($i==0){
                echo '<div class="row section_animate">';
            }
            echo '<div class="span4">
                    <div class="author_post" style="background: #' .$author_color, '" >';

            echo get_the_post_thumbnail(get_the_ID(), "thumb", array("style" => "width:100%;float:left; background: $author_color"));
            if (!has_post_thumbnail()) {

                ?>
                <img src="<?php bloginfo('template_directory') ?>/images/no-background.png" style="width:100%;float:left;"/>
            <?php
            }

            echo '<div class="overlay-text" onclick="ajax_load_pages(\'' . get_the_permalink() . '?cat=' . $current_category . '\')" >';

            if (has_post_video()) {
                $post = get_post(get_the_ID());
                $author = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
                $author_color = "#".$author[0]->color_shade;
                ?>
                <div class="play-video" video="<?php echo get_the_post_video_url($post->ID); ?>">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                    <defs>
                    </defs>
                        <path fill="<?php echo $author_color; ?>"
                              opacity="0.9" enable-background="new" d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                    </svg>
                </div>
            <?php
            }

                echo '<div class="align-bottom">';

                        echo '<p class="post_category">' . category() . '</p>';

                        $post = get_post(get_the_ID());
                        $title = $post->post_title;
                        echo '<p class="post_title">' . $title . '</p>';
                        echo '<p class="post_author">by <span>' . get_the_author_meta('display_name', $post->post_author) . '</span></p>';

                echo "</div>
            </div>";

            echo '<div class="likeandshare">
                    <div class="like-btn">';
                    wpfp_link();
                    echo '</div>
            </div>';
    echo "</div>";
            if(has_category("learn",$post->ID)){
                $level=get_post_meta($post->ID,"wpcf-level");
                $duration=get_post_meta($post->ID,"wpcf-duration");
                $style=get_post_meta($post->ID,"wpcf-style");
                    if(isset($level)&& count($level)>0 && isset($duration)&& count($duration)>0 && isset($style)&& count($style)>0){
                        ?>
                        <div class="left-side">

                            <p>Level : <?php echo implode(" ",$level); ?></p>
                            <p>Style : <?php echo implode(" ",$style); ?></p>
                            <p>Duration :  <?php echo implode(" ",$duration); ?></p>
                        </div>
                    <?php
                    }
                echo "<div class='post_date right'>";
                $rating_value=get_post_rating($post->ID,'post');
                $rating_value=intval($rating_value);
                ?>
                <div class="rating" rel="<?php echo $rating_value; ?>"></div></div>
            <?php
            }
            else{
                    echo "<div class='post_date right'>";

                    $date=$post->post_date;
                    echo date("m.d.y",strtotime($date))."</div>";
             }
    echo "</div>";

            $i++;
            if ($i % 3 == 0 && $i<$count) {
                echo '</div><div class="row section_animate">';
            }
        if($i>=$count){
            echo "</div>";
        }
        endwhile;
            rangoli_paging_nav($the_query, $page);
        endif;
        wp_reset_query();



        ?>


</div></div></div>
<!---->
<?php
if($count>0){
//    echo '<script>
//        $(window).load(function(){
//           animate_tiles();
//        });
//        function animate_tiles(){
//        ';
//        for ($i=0; $i<$count; $i++) {
//            if ($i % 3 == 0)
//                echo '
//                       $(document).find(".section' . $i . '").unbind();
//                       ';
//        }
//         for ($i=0; $i<$count; $i++){
//            if ($i % 3 == 0 )
//               echo '
//                    var offset_section'.$i.' = $(document).find(".section'.$i.'").offset().top;
//                    var content_offset_section'.$i.' = offset_section'.$i.' - $(window).scrollTop();
//                    if (content_offset_section'.$i.'  <= $(window).height() - 100) {
//                        $(document).find(".section'.$i.'").css({"opacity":1});
//                        $(document).find(".section'.$i.'").addClass("fadeInUp").addClass("animated");
//                    }';
//            }
//            for ($i=0; $i<$count; $i++){
//                if ($i % 3 == 0 )
//                echo '
//                    $(window).scroll(function(){
//                        var content_offset_section'.$i.' = offset_section'.$i.' - $(window).scrollTop();
//                        if (content_offset_section'.$i.'  <= $(window).height() - 100) {
//                                $(document).find(".section'.$i.'").css({"opacity":1});
//                            $(document).find(".section'.$i.'").addClass("fadeInUp").addClass("animated");
//                        }
//                    });';
//            }
//        echo '}
//    </script>
//    ';
    echo '<style>';
    echo '
            .section_animate{
                opacity:0;
                clear:both;
            }
            ';
    echo '</style>';
//
}
get_footer();
//?>