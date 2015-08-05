<?php
get_header();
?>
<div class="wp_page span12" style="margin-top: 10px; text-align: center;">
    <h1 class="page-heading">LOVE</h1>

    <div class="post_listing">
        <div id="posts">
            <?php
            ob_flush();
            global $the_query;
            $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $i = 1;
            $args = array(
                'order' => 'DESC',
                'post_type' => 'iloveyogasmoga',
                'paged' => $page);
            //                echo $page;
            $the_query = new WP_Query($args);
            echo '<div class="author_posts row">';
            if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
                $post = get_post();
                $wpauthors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
                $wp_author = $wpauthors[0];

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
                            ?>
                            <div class="overlay-text" onclick="ajax_load_pages('<?php echo get_the_permalink(); ?>')">
                            <?php
                            $categories = category();
                            $post = get_post();
                            echo '<div class="align-bottom">';
                            echo '<p class="post_category">' . $categories . "</p>";
                            echo "<p class='post_title'>LOVE, YOGASMOGA</p>";
                            echo "<p class='post_author'><span>" . get_the_title() .  "</span></p>";
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
                            <p><?php echo date('m.d.y', strtotime($post->post_date)); ?></p>
                        </div>
                    </div>

                    <?php
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
