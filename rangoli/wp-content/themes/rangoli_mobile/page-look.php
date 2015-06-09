<?php
get_header();
?>
<?php
$home = get_site_url();
global $the_query;
global $page;
$filter_category_name = "look";
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
//                $i = 1;
$args = array(
    'category_name' => 'look',
    'order' => 'DESC',
    'post_type' => 'post',
    'paged' => $page);
$the_query = new WP_Query($args);
$i=0;

if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
    $post = get_post();
    $post_author = get_userdata($post->post_author);
    $author = get_user_profile($post->post_author);
    $color = '#'.$author->color_shade;


    if (isset($_REQUEST['topic'])) {
        $filter_category_name = $_REQUEST['topic'];
        $filter_query = has_category($filter_category_name);
    } else if (isset($_REQUEST['author'])) {
        $filter_author_name = $_REQUEST['author'];
        $filter_query = (get_the_author_meta('display_name', $post->post_author) == $filter_author_name);
    } else if (isset($_REQUEST['length'])) {
        $filter_author_name = $_REQUEST['length'];
        $post_length = get_post_meta(get_the_ID(), "wpcf-length");
        $filter_query = ($post_length == $_REQUEST['length']);
    } else {
        $filter_query = true;
    }

//            $filter_length=();
    if ($filter_query) {


        ?>

        <div class="author_post_read" style="background: <?php echo $color; ?>">
            <?php echo get_the_post_thumbnail($post->ID, "mobile_posts");
            if (!has_post_thumbnail()) {
                echo '<img src="' . $home . '/wp-content/themes/rangoli_mobile/images/no-background_posts.png" />';
            }
            ?>
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
                echo "<div class='play_video'>";
                the_post_video();
                echo "</div>";
            }
            ?>
            <div class="overlay-text">

                <div class="align_bottom">
                    <div class="post_category"><?php echo get_post_categories(); ?></div>
                    <div class="post_title"><?php echo $post->post_title; ?></div>
                    <div class="post_author">with <span><?php echo $post_author->display_name; ?></span></div>
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
            <div class="close_post user-color-shade-trans"></div>
            <div class="share_post user-color-shade-trans"></div>
        </div>
        <div class="post_content">
            <?php echo apply_filters('the_content', $post->post_content);


            $comment_array = get_approved_comments($post->ID);
            $comm_no = count($comment_array);
            $key="wpfp_favorites";
            $favorite_count_check = get_post_meta($post->ID, $key, true);

            echo "<p class='comments_no'>$favorite_count_check Likes &nbsp;&nbsp; $comm_no Comments</p>";

            ?>
            <?php
            $post_link = get_permalink($post->ID);
            $b_pl = get_bitly_url($post_link);
            ?>
            <div class="sharing_box user-color-shade-trans">
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
            <div class="post_comments">
                <p class="comments_heading">COMMENTS</p>
                <?php echo get_post_comments($post->ID); ?>

            </div>
        </div>


    <?php
    }
endwhile; endif;
wp_reset_query();
?>

<?php
get_footer();
?>