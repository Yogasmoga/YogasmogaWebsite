<div class="row" style="position: relative">
    <div class="span12">
        <?php
        $user_id = get_current_user_id();

        $user_info = get_userdata($user_id);
        $user_favs = wpfp_get_users_favorites($user_info->user_login);


        $profile = get_user_profile($user_id);
        $name = $profile->user_display_name;
        if($name==null){
            $name = $user_info->display_name;
        }


        $name = strtoupper($name);
        $filter_category_name = "look";
        ?>
        <?php
        if ($user_favs) {


            foreach ($user_favs as $user_fav) {


                    $post = get_post($user_fav);


                    if (isset($_REQUEST['topic'])) {
                        $filter_category_name = $_REQUEST['topic'];
                        $filter_query = has_category($filter_category_name, $post);
                    } else if (isset($_REQUEST['author'])) {
                        $filter_author_name = $_REQUEST['author'];
                        $filter_query = (get_the_author_meta('display_name', $post->post_author) == $filter_author_name);
                    } else if (isset($_REQUEST['length'])) {
                        $filter_author_name = $_REQUEST['length'];
                        $post_length = get_post_meta(get_the_ID(), "wpcf-length");
                        $filter_query = ($post_length == $_REQUEST['length']);
                    }
                    else {
                        $filter_query = true;
                    }




                    $wpauthors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
                    $wp_author = $wpauthors[0];
                    if ($post->post_type == "post") {
                        if ($filter_query) {
                            if (has_category("look", $post) && isset($user_fav)) {

                                echo '<p class="align-center author_posts_heading">' . $name . '\'S LOOKINGS</p>';
                                break;
                            }
                        }
                    }

            }
        }
        ?>


    <?php
    if ($user_favs) {
        ?>
        <div class="flexslider liked_watchs" id="liked_watchs">
            <ul class="slides">
                <?php

                $x = 0;


                foreach ($user_favs as $user_fav) {


                    $post = get_post($user_fav);


                    if (isset($_REQUEST['topic'])) {
                        $filter_category_name = $_REQUEST['topic'];
                        $filter_query = has_category($filter_category_name, $post);
                    } else if (isset($_REQUEST['author'])) {
                        $filter_author_name = $_REQUEST['author'];
                        $filter_query = (get_the_author_meta('display_name', $post->post_author) == $filter_author_name);
                    } else if (isset($_REQUEST['length'])) {
                        $filter_author_name = $_REQUEST['length'];
                        $post_length = get_post_meta(get_the_ID(), "wpcf-length");
                        $filter_query = ($post_length == $_REQUEST['length']);
                    }
                    else {
                        $filter_query = true;
                    }





                    $wpauthors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
                    $wp_author = $wpauthors[0];
                    if ($post->post_type == "post" && !empty($user_fav)) {

                        if ($filter_query) {
                            if (has_category("look", $post)) {
                                ++$x;
                                if ($x % 3 == 1) {
                                    echo "<li>";
                                    $started = true;
                                }

                                ?>
                                <div class="single_post span4">
                                    <div class="author_post"
                                         style="background: <?php echo '#' . $wpauthors[0]->color_shade; ?>"
                                         rel="<?php echo $post->ID; ?>">

                                        <?php echo get_the_post_thumbnail($post->ID, 'thumb', array('style' => 'width:100%; float:left;height:auto;'));
                                        if (!has_post_thumbnail($post->ID, 'thumb', array('onclick' => '"' . get_the_permalink() . '?cat=read"'))) {

                                            ?>
                                            <img src="<?php bloginfo('template_directory') ?>/images/no-background.png"
                                                 style="width:100%;float:left;"/>
                                        <?php
                                        }
                                        echo '<div class="overlay-text" onclick="ajax_load_pages(\'' . get_the_permalink($post->ID) . '\')">';


                                        if (has_post_video()) {
                                            ?>
                                            <div class="play-video"
                                                 video="<?php echo get_the_post_video_url($post->ID); ?>">
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     x="0px" y="0px" width="56px"
                                                     height="56px" viewBox="-0.317 0.093 55 55"
                                                     enable-background="new -0.317 0.093 55 55"
                                                     xml:space="preserve">
                                                <defs>
                                                </defs>
                                                    <path fill="<?php echo '#' . $wp_author->color_shade; ?>"
                                                          d="M54.389,27.195c0,15.019-12.175,27.193-27.194,27.193C12.175,54.389,0,42.214,0,27.195  C0,12.175,12.175,0,27.195,0C42.214,0,54.389,12.175,54.389,27.195z M18.683,15.027v22.824l24.398-11.412L18.683,15.027z"/>
                                            </svg>
                                            </div>
                                        <?php
                                        }
                                        echo '</div>';
                                        echo '<div class="likeandshare">
                                            <div class="like-btn">';
                                        // get_template_part('heartsvg');
                                        wpfp_link();
                                        echo '</div>';

                                        echo '<div class="share-arrow">';
                                        //                        get_template_part('sharearrow');
                                        echo '</div>
                                </div>';
                                        $categories = category();
                                        $post = get_post();
                                        echo '<div class="post_below_text">';
                                        echo '<p class="post_category">' . $categories . "</p>";
                                        echo "<p class='post_title'>" . get_the_title() . "</p>";
                                        echo "<p class='post_author'>by <span>" . get_the_author_meta('display_name', $post->post_author) . "</span></p>";
                                        echo "</div>";
                                        ?>

                                    </div>

                                </div>

                                <?php
                                if ($x % 3 == 0) {
                                    echo "</li>";
                                    $started = false;

                                    $x = 0;
                                }

                            }
                        }
                    }
                }
                if ($started) {
                    echo "</li>";
                }

                ?>
            </ul>
        </div>
                <?php
    }
        wp_reset_postdata();
        ?>
    </div>

</div>

<script>
    $(document).ready(function () {
        $(".liked_watchs").flexslider();
    })
</script>

<style>
    #liked_watchs.flexslider {
        overflow: visible;
    }

    #liked_watchs .flex-direction-nav {
        display: block;
        height: 24px;
        position: absolute;
        top: -37px;
        width: 100%;
        z-index: 2;
    }

    #liked_watchs .flex-direction-nav .flex-prev {
        background: url("<?php  echo get_site_url() ?>/wp-content/themes/rangoli/images/arrows-slider.png") repeat scroll 0 0 / 50px auto rgba(0, 0, 0, 0);
        height: 17px;
        background-position: left;
        left: 0;
        width: 25px;
        text-indent: 999px;
        margin-top: -11px !important;
        overflow: hidden;
    }

    #liked_watchs .flex-direction-nav .flex-next {
        background: url("<?php  echo get_site_url() ?>/wp-content/themes/rangoli/images/arrows-slider.png") repeat scroll 0 0 / 50px auto rgba(0, 0, 0, 0);
        height: 17px;
        right: 0;
        background-position: right;
        width: 25px;
        text-indent: 999px;
        margin-top: -11px !important;
        overflow: hidden;
    }

    #liked_watchs .flex-control-nav {
        display: none !important;
    }
</style>