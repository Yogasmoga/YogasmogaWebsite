<?php
/*
Template Name: READ PAGE
*/
?>

<?php
get_header();


$filter_category_name = "read";
// checking if request is opened for first time


?>
    <div class="wp_page span12" style="margin-top: 10px; text-align: center;">
        <?php
        $cat = "read";
        echo filter($cat);
        ?>
        <h1 class="page-heading">READ</h1>

        <div class="post_listing">
            <div id="posts">
                <?php
                ob_flush();
                global $the_query;
                $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $i = 1;
                $args = array(
                    'category_name' => 'read',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'paged' => $page);
//                echo $page;
                $the_query = new WP_Query($args);
                echo '<div class="author_posts row">';
                if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
                    $post = get_post();
                    $wpauthors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
                    $wp_author = $wpauthors[0];


                    if (isset($_REQUEST['topic'])) {
                        $filter_category_name = $_REQUEST['topic'];
                        $filter_query = has_category($filter_category_name);
                    } else if (isset($_REQUEST['author'])) {
                        $filter_author_name = $_REQUEST['author'];
                        $filter_query = (get_the_author_meta('display_name', $post->post_author) == $filter_author_name);
                    } else if (isset($_REQUEST['length'])){
                        $filter_author_name = $_REQUEST['length'];
                        $post_length = get_post_meta(get_the_ID(), "wpcf-length");
                        if(count($post_length)>0)
                        $filter_query = ($post_length[0] == $_REQUEST['length']);
                    } else {
                        $filter_query = true;
                    }

//            $filter_length=();
                    if ($filter_query) {
//                        if(true){
                        ?>

                        <div class="single_post span4">
                            <div class="author_post read"
                                 style="background: <?php echo '#' . $wpauthors[0]->color_shade; ?>">

                                <?php echo get_the_post_thumbnail($post->ID, 'thumb', array('style' => 'width:100%; float:left;height:auto;'));
                                if (!has_post_thumbnail($post->ID, 'thumb', array('onclick' => '"' . get_the_permalink() . '?cat=read"'))) {

                                    ?>
                                    <img src="<?php bloginfo('template_directory') ?>/images/no-background.png"
                                         style="width:100%;float:left;"/>
                                <?php
                                }
                                echo '<div class="overlay-text" onclick="ajax_load_pages(\'' . get_the_permalink() . '?cat=read\')">';

                                $categories = category();
                                $post = get_post();
                                echo '<div class="align-bottom">';
                                echo '<p class="post_category">' . $categories . "</p>";
                                echo "<p class='post_title'>" . get_the_title() . "</p>";
                                echo "<p class='post_author'>with <span>" . get_the_author_meta('display_name', $post->post_author) . "</span></p>";
                                echo '</div>';
                                ?>
                            </div>
                            <?php
                            echo '<div class="likeandshare"><div class="like-btn">';
                            // get_template_part('heartsvg');
                            wpfp_link();
                            echo '</div>';

                            echo '<div class="share-arrow">';
//                            get_template_part('sharearrow');
                            echo '</div></div>';
                            echo '</div>';

                            ?>
                            <div class="post_date read">
                                <p><?php echo date('m.j.y', strtotime($post->post_date)); ?></p>
                            </div>
                        </div>

                        <?php

                        if ($i % 3 == 0) {
//                            echo "<div style='clear:both'></div>";
                        }
                        $i++;
                    }

                endwhile;
                    rangoli_paging_nav($the_query, $page);
//                    wp_paginate($query);

                endif;

                wp_reset_query();
                echo "</div>";
                ?>
            </div>
        </div>
    </div>


<?php
get_footer();
?>