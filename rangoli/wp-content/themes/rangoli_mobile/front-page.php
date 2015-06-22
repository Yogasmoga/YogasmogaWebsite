<?php
    get_header();
?>
<div class="flexslider homepage_slider">
    <ul class="slides">
        <?php
        $args = array(
            "post_type" => "slider",
        );
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
        $post = get_post();
        $banner_img_url="";
        ?>
        <li>
            <?php
            echo get_the_post_thumbnail($post->ID, mobile_slider);
            ?>
            <div class='over-the-slide homepage_page_banner' onclick="window.location='<?php echo get_permalink() ?>'" >
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
    $array_post = array("227","invite","204","204","7","227","111","5","227");
//    $array_post = array("355","invite","261","232","69","370","523","81","330");

        $i = 0;
        foreach ($array_post as $element) {

            $i++;
            if ($i!=2 && !i !=5 && $i!=8 ) {
                $class = "half";
                if($i==1 || $i==4 || $i==7 ){
                    $class = "full";
                }
                echo "<div class='homepage_post $class'>";
                $post = get_post($element);
                $category = get_post_categories($post->ID);

                if($class=="half"){
                    echo get_the_post_thumbnail($post->ID, "mobile_posts_half");
                }
                else
                    echo get_the_post_thumbnail($post->ID, "mobile_posts");

                ?>
                <div class="overlay-text"  onclick="window.location='<?php echo get_permalink($post->ID); ?>'">
                    <div class="post_category">
                <?php echo $category ?>
                    </div>
                <?php
                if (!has_post_video($post->ID)) {

                    echo '<div class="post_title"><a class="no_load" href="'.get_the_permalink($post->ID).'">' . $post->post_title . '</a></div>';
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
                $home = get_site_url();
                $base_link_text = "";
                if (has_category("read", $post->ID)) {
                    $base_link_text = "Read More";
                    $base_link = $home . "/read";
                }
                else if (has_category("look", $post->ID)) {
                    $base_link_text = "Look More";
                    $base_link = $home . "/read";
                }
                else if (has_category("learn", $post->ID)) {
                    $base_link_text = "Learn More";
                    $base_link = $home . "/read";
                }

                echo "</div>";
                echo '<div class="post_bottom_link"><a href="' . $base_link . '">' . $base_link_text . '</a></div>';
                echo "</div>";
            }

            if($i==2){
                ?>
                    <div class="homepage_post half  <?php if($logged_in){echo 'user-color-shade-trans';} ?>" style="background: #555">
                        <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/no-background.png" />
                        <div class="overlay-text ">
                            <div class="text-center"> Invite<br/> friends</div>
                        </div>
                    </div>
                <?php
            }
            if($i==5 || $i==8){
                $author = get_userdata($element);
                $banners = get_user_meta($author->ID,"author_profile_picture");
                $banner = $banners[0];
                ?>
                    <div class="homepage_post half" style="background: url('<?php echo $banner ?>') no-repeat #000; background-size: cover; background-position: center center;" >
                        <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/no-background.png" />
                        <div class="overlay-text " onclick="window.location='<?php echo get_author_posts_url($author->ID); ?>'">
                            <div class="text-center"><a class="no_load" href="<?php echo get_author_posts_url($author->ID); ?>"><?php $name = strtoupper($author->display_name);
                                $name = str_replace(" ","<br/>",$name);
                                echo $name; ?></a></div>
                        </div>
                    </div>
                <?php
            }
        }


get_footer();

?>
