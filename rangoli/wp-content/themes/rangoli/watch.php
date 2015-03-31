<?php
/*
Template Name: WATCH PAGE
*/
?>

<?php
get_header();

$filter_category_name = "look";
?>
    <div class="wp_page span12" style="margin-top: 20px; text-align: center;">
        <?php
$cat = "look";
echo filter($cat);
?>
        <h1 class="page-heading">LOOK</h1>
    <div class="post_listing">
        <div id="posts">
            <?php
$post = get_post(get_the_ID());
$authors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
$author_color = '#' . $authors[0]->color_shade;
$args = array(
    'category_name' => 'look',
    'order' => 'DESC');
$the_query = new WP_Query($args);
echo '<div class="author_posts row">';
            $i=0;
if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();


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
        <div class="single_post span4">
            <div class="author_post read" style="background:<?php echo $author_color ?>">

                <?php echo get_the_post_thumbnail(get_the_ID(), 'thumb', array('style' => 'width:100%; float:left;height:auto;'));
                if (!has_post_thumbnail()) {

                    ?>
                    <img src="<?php bloginfo('template_directory') ?>/images/no-background.png"
                         style="width:100%;float:left;"/>
                <?php
                }
                echo '<div class="overlay-text" onclick="ajax_load_pages(\'' . get_the_permalink() . '?cat=look\')">';

                $categories = category();
                $post = get_post();
                echo '<div class="align-bottom">';
                echo '<p class="post_category">' . $categories . "</p>";
                echo "<p class='post_title'>" . get_the_title() . "</p>";
                echo "<p class='post_author'>with <span>" . get_the_author_meta('display_name', $post->post_author) . "</span></p>";
                echo '</div>';

            if (has_post_video()) {

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
                ?>
            </div>
            <?php

            echo '<div class="likeandshare"><div class="like-btn">';
            // get_template_part('heartsvg');
            wpfp_link();
            echo '</div>';

            echo '<div class="share-arrow">';
//            get_template_part('sharearrow');
            echo '</div></div>';
            echo '</div>';


            ?>
            <div class="post_date right">
                <p><?php echo date('m.j.y', strtotime($post->post_date)); ?></p>
            </div>
        </div>

        <?php

        if ($i % 3 == 0) {
//            echo "<div style='clear:both'></div>";
        }
        $i++;
    }



endwhile;
    rangoli_paging_nav($the_query, $page);
endif;
wp_reset_query();
echo "</div>";
?>
    </div>
</div></div>


<?php
    get_footer();
    ?>