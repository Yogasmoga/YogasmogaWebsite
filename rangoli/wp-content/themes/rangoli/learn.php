<?php
/*
Template Name: LEARN PAGE
*/
?>

<?php
get_header();

$filter_category_name = "learn";
?>
    <div class="wp_page span12" style="margin-top: 20px; text-align: center;">
        <?php
        $cat = "learn";
        echo filter($cat);
        ?>
        <h1 class="page-heading">LEARN</h1>

        <div class="post_listing">
            <div id="posts">
                <?php
                ob_flush();
                global $the_query;
                global $page;
                $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
//                $i = 1;
                $args = array(
                    'category_name' => 'learn',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'paged' => $page);
                $the_query = new WP_Query($args);
                $i=0;
                echo '<div class="author_posts row">';
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
                            <div class="author_post read" style="background: <?php echo $author_color ?>">

                                <?php echo get_the_post_thumbnail(get_the_ID(), 'thumb', array('style' => 'width:100%; float:left;height:auto;'));
                                if (!has_post_thumbnail()) {

                                    ?>
                                    <img src="<?php bloginfo('template_directory') ?>/images/no-background.png"
                                         style="width:100%;float:left;"/>
                                <?php
                                }
                                echo '<div class="overlay-text" onclick="ajax_load_pages(\'' . get_the_permalink() . '?cat=learn\')">';

                                $categories = category();
                                $post = get_post();
                                echo '<div class="align-bottom">';
                                echo '<p class="post_category">' . $categories . "</p>";
                                echo "<p class='post_title'>" . get_the_title() . "</p>";
                                echo "<p class='post_author'>with <span>" . get_the_author_meta('display_name', $post->post_author) . "</span></p>";
                                echo '</div>';
                                ?>

                            <?php

                            if (has_post_video()) {
                                $post = get_post(get_the_ID());
                                $authors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
                                $author_color = '#' . $authors[0]->color_shade;
                                ?>
                                <div class="play-video" video="<?php echo get_the_post_video_url($post->ID); ?>">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                         x="0px" y="0px" width="56px"
                                         height="56px" viewBox="-0.317 0.093 55 55"
                                         enable-background="new -0.317 0.093 55 55"
                                         xml:space="preserve">
                    <defs>
                    </defs>
                                        <path fill="<?php echo $author_color; ?>"
                                              d="M54.389,27.195c0,15.019-12.175,27.193-27.194,27.193C12.175,54.389,0,42.214,0,27.195  C0,12.175,12.175,0,27.195,0C42.214,0,54.389,12.175,54.389,27.195z M18.683,15.027v22.824l24.398-11.412L18.683,15.027z"/>
                    </svg>
                                </div>
                            <?php
                            }
                            ?>
                            </div>
                            <?php
                            echo '<div class="likeandshare"><div class="like-btn">';
                             wpfp_link();
                            echo '</div>';

                            echo '<div class="share-arrow">';
//                                get_template_part('sharearrow');
                            echo '</div></div>';
                            echo '</div>';


                            ?>

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
                           <div class="right">
                               <?php
                               $rating = get_post_rating($post->ID, 'post');
                               $rating = intval($rating);
                               ?>
                               <div class="rating" rel="<?php echo $rating; ?>"
                                    post_id="<?php echo $post->ID; ?>">
                               </div>
                               <div class="post_date right">
                                   <p><?php echo date('m.d.y', strtotime($post->post_date)); ?></p>
                               </div>
                           </div>
                       <?php
                       }?>


                        </div>
                        <?php

                        if ($i % 3 == 0) {
//                            echo "<div style='clear:both'></div>";
                        }
                        $i++;
                    }
                    ?>

                <?php

                endwhile;
                    rangoli_paging_nav($the_query, $page);
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