<div class="row post">
    <?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    $user_id = $curauth->ID;

    $wpauthors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $user_id);
    $wp_author = $wpauthors[0];

    $name = $curauth->display_name;
    $name = strtoupper($name);
    ?>
    <p class="align-center author_posts_heading"><?php echo $name ?>'S POSTS</p>

    <?php
    $args = array(
        'order' => 'DESC',
        'author_name' => $curauth->user_nicename
    );

    $the_query = new WP_Query($args);
    $width = "span6";
    $i = 0;
    if ($the_query->have_posts()):while ($the_query->have_posts()):
    $the_query->the_post();

    if ($i == 3) {
        break;
    }
    if ($i == 0) {
        $width = "span12 first_post";
    } else {
        $width = "span6";
    }
    ?>

    <div class="single_post <?php echo $width ?>">
        <div class="author_post" style="background: <?php echo '#'.$wpauthors[0]->color_shade; ?>">

            <?php echo get_the_post_thumbnail(get_the_ID(), 'thumb', array('style' => 'width:100%; float:left;height:auto;'));
            if (!has_post_thumbnail(get_the_ID(), 'thumb', array('onclick' => '"' . get_the_permalink() . '?cat=read"'))) {

                ?>
                <img src="<?php bloginfo('template_directory') ?>/images/no-background.png"
                     style="width:100%;float:left;"/>
            <?php
            }
            echo '<div class="overlay-text" onclick="ajax_load_pages(\'' . get_the_permalink() . '\')">';

            if (has_post_video()) {
                ?>
                <div class="play-video" video="<?php echo get_the_post_video_url($post->ID); ?>">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                    <defs>
                    </defs>
                        <path fill="<?php echo '#'.$wp_author->color_shade; ?>"
                              opacity="0.9" enable-background="new" d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                    </svg>
                </div>
            <?php
            }
            $categories = category($post->ID);
            $post = get_post();
            echo '<div class="post_below_text">';
            echo '<p class="post_category">' . $categories . "</p>";
            echo "<p class='post_title'>" . get_the_title($post->ID) . "</p>";
            echo "<p class='post_author'>by <span>" . get_the_author_meta('display_name', $post->post_author) . "</span></p>";


            echo '</div>';
            echo '</div>';

            echo '<div class="likeandshare">
                        <div class="like-btn">';
                        wpfp_link();
            echo '</div>';

            ?>

        </div>

    </div>
    <?php
    if ($i == 0) {
        $level = get_post_custom_values("level");
        $style = get_post_custom_values("style");
        $duration = get_post_custom_values("duration");

        $data = true;

        $data = $data && isset($level) && is_array($level) && count($level) > 0;
        $data = $data && isset($style) && is_array($style) && count($style) > 0;
        $data = $data && isset($duration) && is_array($duration) && count($duration) > 0;
        ?>
        <div class="other_details row">
            <?php $level = get_post_meta($post->ID, "wpcf-level");
            $duration = get_post_meta($post->ID, "wpcf-duration");
            $style = get_post_meta($post->ID, "wpcf-style");
            if (isset($level) && count($level) > 0 && isset($duration) && count($duration) > 0 && isset($style) && count($style) > 0) {
                ?>
                <div class="left-side" style="padding-left: 0px;">

                    <p>Level : <?php echo implode(" ", $level); ?></p>

                    <p>Style : <?php echo implode(" ", $style); ?></p>

                    <p>Duration :  <?php echo implode(" ", $duration); ?></p>
                </div>
            <?php
            }
            ?>
            <div class="right">
                <?php
                if(has_category("learn",$post->ID)) {
                    $rating = get_post_rating($post->ID, 'post');
                    $rating = intval($rating);
                    ?>
                    <div class="rating" rel="<?php echo $rating; ?>"
                         post_id="<?php echo $post->ID; ?>">
                    </div>
                <?php
                }
                ?>
                <div class="post_date right">
                    <p><?php echo date('m.d.y', strtotime($post->post_date)); ?></p>
                </div>
            </div>




        </div>
    <?php
    }

    else{
    if(has_category("learn", $post->ID)){
            ?>

                <div class="author_post_rating row">
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

    ?>
</div>

<?php
$i++;

endwhile;
endif;
wp_reset_query();
?>
</div>


