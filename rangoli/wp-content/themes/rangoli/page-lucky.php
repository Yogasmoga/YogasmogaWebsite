<?php
get_header();

?>

    <div class="row">
        <h1 class="page-heading align-center">LUCKY ME</h1>
    </div>
<?php
$url = get_site_url() . "/get_lucky_me.php";
$json = file_get_contents($url);

//print_r($json);

$posts = array();

$feeds = json_decode($json, true);
if (count($feeds) > 0) {
    foreach ($feeds as $feed) {
        $color_shade = $feed["color"];
        $date = $feed["post_date"];
        $post_id = $feed["post_id"];
        $post = get_post($post_id);

        $author_id = $post->post_author;


        $author = get_userdata($author_id);
        $author_profile = get_user_profile($author_id);
        $smogiBucks = get_user_smogi_bucks($author_id);
        $interests = get_user_interests($author_id);
        if (is_array($interests))
            $interests = strtoupper(implode(" ", $interests));


        $comments = get_comments(array('post_id' => $post->ID, "order" => "DESC"));
        if($comments){
        ?>
        <div class="row lucky_me" style="background:#<?php echo $color_shade; ?> ; height: 500px; ">
            <div class="span3">
                <div class="row">
                    <!-- ----------- -->
                    <?php

                    $x = 0;
                    foreach ($comments as $comment) {
                        $profileUrl_ar = get_user_meta( $comment->user_id,"cupp_upload_meta");
                        if ($profileUrl_ar)
                            $profileUrl = $profileUrl_ar[0];
                        else
                            $profileUrl = get_site_url() . "/wp-content/themes/rangoli/images/default.jpg";
                        $commentDate = $comment->comment_date;
                        ?>
                        <div class="span12">
                            <div class="profile-image">
                                <a class="ajax-load" href="<?php echo get_site_url() . '/profile/?user_id=' . $comment->user_id; ?>">
                                    <img class="profile-img-small" rel="<?php echo $comment->user_id; ?>"
                                         src="<?php echo $profileUrl ?>">
                                </a>
                            </div>
                            <div class="details">
                                <p class="post_date">
                                    <?php echo date('m.d.y', strtotime($commentDate)); ?></p>

                                <p class="comment">
                                    <?php $comment_content = $comment->comment_content;
                                    $comment_content = substr($comment->comment_content, 0, 15);
                                    echo $comment->comment_author . " <span class='font-italic'>says " . $comment_content . "...</span> ";
                                    ?></p>
                            </div>
                        </div>
                        <?php
                        $x++;
                        if ($x == 4) {
                            break;
                        }
                    }
                    ?>

                    <?php
                    $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
                    if ($thumbnail)
                        $thumbnail_src = $thumbnail[0];
                    else
                        $thumbnail_src = get_site_url() . "/wp-content/themes/rangoli/images/no-background.png";

                    ?>
                    <!-- ----------- -->
                </div>
            </div>
            <div class="spanV span6"
                 style="background:url('<?php echo $thumbnail_src; ?>') no-repeat; background-position: center center; background-size: cover; ">
                <div style=" position: relative; height: 100%;">
                    <div class="overlay-text" onclick="ajax_load_pages('<?php echo get_permalink($post_id) ?>')">
                        <?php
                        if (has_post_video($post_id)) {

                            ?>
                            <div class="play-video" video="<?php echo get_the_post_video_url($post_id); ?>">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px"
                                     height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64"
                                     xml:space="preserve">
                                <defs>
                                </defs>
                                    <path fill="<?php echo '#' . $color_shade; ?>"
                                          opacity="0.9" enable-background="new"
                                          d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                                </svg>
                            </div>
                        <?php
                        }
                            ?>
                            <div class="align-bottom">

                                <p class="post_category"><?php
                                    $categories = category($post_id);
                                    echo $categories; ?>
                                </p>

                                <p class="post_title"><?php echo $post->post_title ?></p>

                                <p class="post_subtitle"><?php echo $post->post_excerpt; ?></p>

                                <p class="author">by <span><?php echo $author->display_name; ?></span></p></div>
                        </div>

                    <?php

                    echo '<div class="likeandshare"><div class="like-btn">';
                    // get_template_part('heartsvg');
                    wpfp_link();
                    echo '</div>
                        </div>';
                    ?>
                </div>
            </div>
            <div class="span3 right">
                <!-- ------------------------- -->
                <div class="feed-box">
                    <div class="feed-content">
                        <div class="abt-user">
                            <div class="img-level">
                                <div class="profile-image">

                                    <?php
//                                    echo $author_id. "***********";
                                    $img = get_user_meta($author_id,"cupp_upload_meta");
//                                    print_r($img);
                                    $imgUrl = get_site_url() . "/wp-content/themes/rangoli/images/default.jpg";
                                    if (is_array($img) && count($img)>0) {
                                        $imgUrl = $img[0];
                                    }
                                    ?>
                                    <img class="profile-img-small" src="<?php echo $imgUrl; ?>">
                                </div>
                                <?php
                                $level = get_user_level($author_id);
                                $color_shade = strtoupper($color_shade);
                                ?>
                                <span class="charm color_<?php echo $color_shade . " " . $level ?>"></span>
                            </div>
                            <div class="uname"><?php echo $author->display_name ?></div>
                            <p class="uplace"><?php $place = get_user_meta($author_id, "wpcf-address");
                                if ($place)
                                    echo $place[0];

                                ?></p>

                            <p class="uinterests"><?php echo $interests ?></p>

                            <p class="ubucks"><?php if($smogiBucks!=""){ echo $smogiBucks." SMOGI Bucks"; }?> </p>
                        </div>
                        <span class="sep"></span>

                        <div class="act-user">
                            <?php
                            $post_titles = $wpdb->get_results("SELECT post_title, ID, post_date FROM rangoli_posts WHERE post_author=$author_id and post_type='post' and post_status='publish'");
                            $recent_post = end($post_titles);
                            ?>
                            <p class="post_date"><?php echo date('m.d.y', strtotime($recent_post->post_date)); ?></p>

                            <p><a class="post_author ajax-load"
                                  href="<?php echo get_author_posts_url($author_id); ?>"><?php echo $author->display_name ?></a>
                                    <span class="font-italic">posted an article
                                    "<?php
                                        echo "<a class='ajax-load' href='" . get_permalink($recent_post->ID) . "'>";
                                        echo $recent_post->post_title . "</a></span>"
                                        ?>"</p>

                            <!--<p><a class="see_all  ajax-load"
                                  href="<?php /*echo get_site_url() . "/feeds/?color=" . $color_shade; */?>">See all</a></p>-->
                        </div>
                    </div>
                </div>
                <!-- ----------------------------------- -->
            </div>
            <div class="lucky_me_post_date">
                <?php if(has_category("learn",$post->ID)){?>
                <div class="rating" rel="<?php echo $rating; ?>"
                     post_id="<?php echo $post->ID; ?>">
                </div>
            <?php } ?>
                <p class="post_date">
                    <?php
                    echo date('m.d.y', strtotime($date));
                    ?>
                </p>
            </div>
        </div>

    <?php
        }
    }
}


get_footer();
