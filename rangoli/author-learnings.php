<div class="row">
    <?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    $user_id=$curauth->ID;
    //
    //     $get_favorites = $wpdb->get_results("SELECT meta_value FROM rangoli_usermeta WHERE user_id=".$user_id." AND meta_key='wpfp_favorites'");
    //     $user_favs=$get_favorites[0];

    $user_info=get_userdata($user_id);

    $user_favs = wpfp_get_users_favorites($user_info->user_login);


    $name=$curauth->display_name;
    $name=strtoupper($name);
    ?>
    <?php


    if ($user_favs) {


        foreach ($user_favs as $user_fav) {


            if (strlen(trim($user_fav)) == 0)
                continue;


            $post = get_post($user_fav);
            $wpauthors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $post->post_author);
            $wp_author = $wpauthors[0];
            if ($post->post_type == "post") {
                if (has_category("learn", $post)) {

                    echo '<p class="align-center author_posts_heading">'.$name .'\'S LEARNINGS</p>';
                    break;
                }
            }
        }
    }
    ?>

<?php
    if ($user_favs) {
    ?>
    <div class="flexslider" id="author_learn">
        <ul class="slides" >
            <?php

            $x = 0;
            foreach ($user_favs as $user_fav) {
            $post = get_post($user_fav);

            $wp_author = get_user_profile($post->post_author);
            if ($post->post_type == "post" && !empty($user_fav)) {

            // finding category READ
            if (has_category("learn", $post)) {

            ++$x;
            if ($x % 2 == 1) {
                echo "<li>";
                $started = true;
            }

            ?>

            <div class="single_post span6">
                            <div class="author_post" style="background: <?php echo '#'.$wpauthors[0]->color_shade; ?>"  rel="<?php echo $post->ID;?>">

                                <?php echo get_the_post_thumbnail($post->ID,'thumb',array('style'=>'width:100%; float:left;height:auto;'));
                                if(!has_post_thumbnail($post->ID,'thumb',array('onclick'=>'"'.get_the_permalink().'?cat=read"'))){

                                    ?>
                                    <img src="<?php bloginfo('template_directory') ?>/images/no-background.png" style="width:100%;float:left;" />
                                <?php
                                }
                                echo '<div class="overlay-text" onclick="ajaax_load_pages(\''.get_the_permalink($post->ID).'\')">';





                                echo '<div class="likeandshare"><div class="like-btn">';
                                // get_template_part('heartsvg');
                                wpfp_link();
                                echo '</div>';

                                echo '<div class="share-arrow">';
                                get_template_part('sharearrow');
                                echo '</div></div>';
                                echo '</div>';
                                if(has_post_video()){
                                    ?>
                                    <div class="play-video" video="<?php echo get_the_post_video_url($post->ID); ?>">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                             x="0px" y="0px" width="56px"
                                             height="56px" viewBox="-0.317 0.093 55 55" enable-background="new -0.317 0.093 55 55"
                                             xml:space="preserve">
                    <defs>
                    </defs>
                                            <path fill="<?php echo '#'.$wp_author->color_shade; ?>"
                                                  d="M54.389,27.195c0,15.019-12.175,27.193-27.194,27.193C12.175,54.389,0,42.214,0,27.195  C0,12.175,12.175,0,27.195,0C42.214,0,54.389,12.175,54.389,27.195z M18.683,15.027v22.824l24.398-11.412L18.683,15.027z"/>
                    </svg>
                                    </div>
                                <?php
                                }
                                $categories=category();
                                $post=get_post();
                                echo '<div class="post_below_text">';
                                echo '<p class="post_category">'.$categories."</p>";
                                echo "<p class='post_title'>".get_the_title()."</p>";
                                echo "<p class='post_author'>by <span>".get_the_author_meta('display_name',$post->post_author)."</span></p>";

                                ?>
                                <?php
                                $rating = get_post_rating($post->ID, 'post');
                                $rating = intval($rating);
                                ?>
                                <div class="rating" rel="<?php echo $rating; ?>"
                                     post_id="<?php echo $post->ID; ?>">
                                </div>
                            </div>

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




<script>
    $(document).ready(function(){
        $("#author_learn").flexslider();
    })
</script>

<style>
    #author_learn.flexslider{
        overflow: visible;
    }
    #author_learn .flex-direction-nav {
        display: block;
        height: 24px;
        position: absolute;
        top: -37px;
        width: 100%;
        z-index: 2;
    }
    #author_learn .flex-direction-nav .flex-prev {
        background: url("<?php  echo get_site_url() ?>/wp-content/themes/rangoli/images/arrows-slider.png") repeat scroll 0 0 / 50px auto rgba(0, 0, 0, 0);
        height: 17px;
        background-position: left;
        left: 0;
        width: 25px;
        text-indent: 999px;
        margin-top: -11px !important;
        overflow: hidden;
    }
    #author_learn .flex-direction-nav .flex-next {
        background: url("<?php  echo get_site_url() ?>/wp-content/themes/rangoli/images/arrows-slider.png") repeat scroll 0 0 / 50px auto rgba(0, 0, 0, 0);
        height: 17px;
        right: 0;
        background-position: right;
        width: 25px;
        text-indent: 999px;
        margin-top: -11px !important;
        overflow: hidden;
    }
    #author_learn .flex-control-nav{
        display:none;
    }
</style>