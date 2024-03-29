<div class="row">
    <?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    $user_id=$curauth->ID;
    $user_info=get_userdata($user_id);

    $user_favs = wpfp_get_users_favorites($user_info->user_login);

//    print_r($user_favs);

    $name=$curauth->display_name;
    $name=strtoupper($name);
    ?>
    <?php
    if ($user_favs) {

        foreach ($user_favs as $user_fav) {
            $post = get_post($user_fav);
            $wpauthors = get_user_profile($post->post_author);
            if ($post->post_type == "post") {
                if (has_category("read", $post)) {

                    echo '<p class="align-center author_posts_heading">'.$name .'\'S READINGS</p>';
                    break;
                }
            }
        }
    }
    ?>


    <?php
    if ($user_favs) {
    ?>

    <div class="flexslider" id="author_reads">
        <ul class="slides" >
            <?php

            $x = 0;
            foreach ($user_favs as $user_fav) {
                $post = get_post($user_fav);

                $wp_author = get_user_profile($post->post_author);
//                print_r($wp_author);
                if ($post->post_type == "post" && !empty($user_fav)) {

                    // finding category READ
                    if (has_category("read", $post)) {

                        ++$x;
                        if ($x % 2 == 1) {
                            echo "<li>";
                            $started = true;
                        }

                        ?>


                        <div class="single_post span6">
                            <div class="author_post" style="background: #<?php echo $wp_author->color_shade; ?>">

                                <?php echo get_the_post_thumbnail($post->ID,'thumb',array('style'=>'width:100%; float:left;height:auto;'));
                                if(!has_post_thumbnail($post->ID,'thumb',array('onclick'=>'"'.get_the_permalink().'?cat=read"'))){

                                    ?>
                                    <img src="<?php bloginfo('template_directory') ?>/images/no-background.png" style="width:100%;float:left;" />
                                <?php
                                }
                                echo '<div class="overlay-text" onclick="ajax_load_pages(\''.get_the_permalink().'\')">';



                                echo '</div>';

                                echo '<div class="likeandshare">
                                    <div class="like-btn">';
                                    // get_template_part('heartsvg');
                                    wpfp_link();
                                    echo '</div>';

                                    echo '<div class="share-arrow">';
//                                    get_template_part('sharearrow');
                                    echo '</div>
                                </div>';

                                $categories=category();
                                $post=get_post();
                                    echo '<div class="post_below_text">';
                                    echo '<p class="post_category">'.$categories."</p>";
                                    echo "<p class='post_title'>".get_the_title()."</p>";
                                    echo "<p class='post_author'>by <span>".get_the_author_meta('display_name',$post->post_author)."</span></p>
                                          </div>";

                                ?>

                            </div>

                        </div>

    <?php
                }
                // end of READ category find


            }
            if ($x % 2 == 0) {
                echo "</li>";
                $started = false;

                $x = 0;
            }


        }
    if ($started) {
        echo "</li>";
    }
    wp_reset_postdata();
?>



</ul>
</div>



<?php
    }
    ?>
</div>
<style>
    #author_reads.flexslider{
        overflow: visible;
    }
    #author_reads .flex-direction-nav {
        display: block;
        height: 24px;
        position: absolute;
        top: -37px;
        width: 100%;
        z-index: 2;
    }
    #author_reads .flex-direction-nav .flex-prev {
        background: url("<?php  echo get_site_url() ?>/wp-content/themes/rangoli/images/arrows-slider.png") repeat scroll 0 0 / 50px auto rgba(0, 0, 0, 0);
        height: 17px;
        background-position: left;
        left: 0;
        width: 25px;
        text-indent: 999px;
        margin-top: -11px !important;
        overflow: hidden;
    }
    #author_reads .flex-direction-nav .flex-next {
        background: url("<?php  echo get_site_url() ?>/wp-content/themes/rangoli/images/arrows-slider.png") repeat scroll 0 0 / 50px auto rgba(0, 0, 0, 0);
        height: 17px;
        right: 0;
        background-position: right;
        width: 25px;
        text-indent: 999px;
        margin-top: -11px !important;
        overflow: hidden;
    }
    #author_reads .flex-control-nav{
        display:none;
    }
</style>
<script>
    $(document).ready(function(){
        $("#author_reads").flexslider();
    });
</script>