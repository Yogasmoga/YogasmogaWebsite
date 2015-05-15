<section class="second">
    <div class="row">


        <div class="one-three left">
            <?php /////////////BLOCK 1////////
            $post = get_post(1447);
            ?>
            <?php echo get_the_post_thumbnail($post->ID,"thumb");
            if(!has_post_thumbnail($post->ID)){
                echo '<img src="'.get_site_url().'/wp-content/themes/rangoli/images/no-background.png" style="width:100%;float:left;"/>';
            }
            ?>

            <div onclick="ajax_load_pages('<?php echo get_permalink($post->ID) ?>')" class="overlay-text">
                <p class="post_category"><?php echo category($post->ID); ?></p>

                <p class="post_title"><?php echo $post->post_title; ?></p>




            </div>
            <p class="post_link"><a class="ajax-load"  href="<?php echo get_site_url(); ?>/read">Read More</a></p>
        </div>


        <?php if(!is_user_logged_in()) {
        /////////////BLOCK 2////////////
            ?>
            <div class="left invite_signup"   style = " position:relative; width:33.33%;cursor:pointer; background:url('<?php bloginfo('template_directory')?>/images/box_n.png') no-repeat; background-size: cover;" >
           <?php  }
           else {
           ?>
            <div class="left invite_signup" style = " position:relative; width:33.33%; cursor:pointer;  background:url('<?php bloginfo('template_directory')?>/images/box_a.png') no-repeat; background-size: cover;" >
            <?php  } ?>
            <img src="<?php bloginfo('template_directory')?>/images/no-background.png" style="width:100%;float:left;"/>
<!--            <div class="overlay-text">-->
<!--            </div>-->
        </div>
                <div style="background: none repeat scroll 0% 0% rgb(172, 132, 54);" class="one-three left get_app">
                    <?php
                    /////////////BLOCK 3////////////
                    $post = get_post(1507);
                    ?>
                    <?php echo get_the_post_thumbnail($post->ID,"thumb");
                    if(!has_post_thumbnail($post->ID)){
                        echo '<img src="'.get_site_url().'/wp-content/themes/rangoli/images/no-background.png" style="width:100%;float:left;"/>';
                    }
                    ?>

                    <div onclick="ajax_load_pages('<?php echo get_permalink($post->ID) ?>')" class="overlay-text">
                        <p class="post_category"><?php echo category($post->ID); ?></p>

                        <p class="post_title"><?php echo $post->post_title; ?></p>



                    </div>
                    <p class="post_link"><a  class="ajax-load" href="<?php echo get_site_url(); ?>/read">Read More</a></p>


                </div>



    </div>
</section>


<section class="third">
    <div class="row">
        <div class="two-three left double-width">

            <?php
            /////////////BLOCK 4////////////
            $post = get_post(1302);
            ?>
            <?php echo get_the_post_thumbnail($post->ID,"thumb");
            if(!has_post_thumbnail($post->ID)){
                echo '<img src="'.get_site_url().'/wp-content/themes/rangoli/images/no-background.png" style="width:100%;float:left;"/>';
            }
            ?>

            <div onclick="ajax_load_pages('<?php echo get_permalink($post->ID) ?>')" class="overlay-text">

                <p class="post_category"><?php echo category($post->ID); ?></p>

                <div class="play-video">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px"
                         viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                        <defs>
                        </defs>
                        <path fill="<?php $author = get_user_profile($post->post_author);
                        echo '#' . $author->color_shade; ?>"
                              d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>

                        </svg>
                </div>
                <p class="post_title"><?php echo $post->post_title; ?></p>




            </div>
            <p class="post_link"><a class="ajax-load"  href="<?php echo get_site_url(); ?>/learn">Learn More</a></p>
        </div>


        <div class="one-three left">
            <?php
            /////////////BLOCK 5////////////
//            $author_id = 71;
            $author_id = 70;
            $author = get_userdata($author_id);
            ?>

            <?php
            $author_banner_url = get_the_author_meta("author_profile_picture", $author_id);
            if ($author_banner_url) {
                echo '<div style="background:url(\''.$author_banner_url.'\'); background-size: cover; background-position: center center; float:left; width:100%;">';
                ?>
                <img src="<?php echo get_site_url() ?>/wp-content/themes/rangoli/images/no-background.png" style="float: left; width: 100%" />
                <?php
                echo "</div>";
            }

            ?>
            <div onclick="ajax_load_pages('<?php echo get_author_posts_url($author_id); ?>')" class="overlay-text">
                <p class="post_category">SMOGI</p>

                <p class="post_title"><?php echo strtoupper($author->display_name) ?></p>

                <p class="post_link"><a class="ajax-load"  href="<?php echo get_author_posts_url($author_id); ?>">MEET OUR SMOGIs</a></p>


            </div>


        </div>


        <div class="one-three left">
            <?php
            /////////////BLOCK 6////////////
            $post = get_post(1453);
            ?>
            <?php echo get_the_post_thumbnail($post->ID,"thumb");
            if(!has_post_thumbnail($post->ID)){
                echo '<img src="'.get_site_url().'/wp-content/themes/rangoli/images/no-background.png" style="width:100%;float:left;"/>';
            }
            ?>

            <div onclick="ajax_load_pages('<?php echo get_permalink($post->ID) ?>')" class="overlay-text">
                <p class="post_category"><?php echo category($post->ID); ?></p>

                <p class="post_title"><?php echo $post->post_title; ?></p>

<!--                <div class="play-video">-->
<!--                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"-->
<!--                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px"-->
<!--                         viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">-->
<!--                        <defs>-->
<!--                        </defs>-->
<!--                        <path fill="--><?php //$author = get_user_profile($post->post_author);
//                        echo '#' . $author->color_shade; ?><!--"-->
<!--                              d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>-->
<!---->
<!--                        </svg>-->
<!--                </div>-->




            </div>
            <p class="post_link"><a class="ajax-load"  href="<?php echo get_site_url(); ?>/look">Look More</a></p>
        </div>

    </div>



</section>


<section class="fourth">
    <div class="row">
        <div class="one-three left">
            <?php
            /////////////BLOCK 7////////////
            $author_id = 82;
            $author = get_userdata($author_id);
            ?>

            <?php
            $author_banner_url = get_the_author_meta("author_profile_picture", $author_id);
            if ($author_banner_url) {
                echo '<div style="background:url(\''.$author_banner_url.'\'); background-size: cover; background-position: center center; float:left; width:100%;">';
                    ?>
                    <img src="<?php echo get_site_url() ?>/wp-content/themes/rangoli/images/no-background.png" style="float: left; width: 100%" />
                <?php
                echo "</div>";
            }
            ?>
            <div onclick="ajax_load_pages('<?php echo get_author_posts_url($author_id); ?>')" class="overlay-text">
                <p class="post_category">YS LOCATIONS</p>

                <p class="post_title"><?php echo strtoupper($author->display_name) ?></p>

                <p class="post_link"><a class="ajax-load"  href="<?php echo get_author_posts_url($author_id); ?>">Visit Us</a></p>


            </div>

        </div>


        <div class="one-three left">
            <?php
            /////////////BLOCK 8////////////
            $post = get_post(953);
            ?>
            <?php echo get_the_post_thumbnail($post->ID,"thumb");
            if(!has_post_thumbnail($post->ID)){
                echo '<img src="'.get_site_url().'/wp-content/themes/rangoli/images/no-background.png" style="width:100%;float:left;"/>';
            }
            ?>

            <div onclick="ajax_load_pages('<?php echo get_permalink($post->ID) ?>')" class="overlay-text">
                <p class="post_category"><?php echo category($post->ID); ?></p>

                <p class="post_title"><?php echo $post->post_title; ?></p>

<!--                <div class="play-video">-->
<!--                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"-->
<!--                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px"-->
<!--                         viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">-->
<!--                        <defs>-->
<!--                        </defs>-->
<!--                        <path fill="--><?php //$author = get_user_profile($post->post_author);
//                        echo '#' . $author->color_shade; ?><!--"-->
<!--                              d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>-->
<!---->
<!--                        </svg>-->
<!--                </div>-->




            </div>
            <p class="post_link"><a class="ajax-load"  class="ajax-load" href="<?php echo get_site_url(); ?>/look">Look More</a></p>
        </div>


        <div class="one-three left">

            <?php
            /////////////BLOCK 9////////////
            $post = get_post(1428);
            ?>
            <?php echo get_the_post_thumbnail($post->ID,"thumb");
            if(!has_post_thumbnail($post->ID)){
                echo '<img src="'.get_site_url().'/wp-content/themes/rangoli/images/no-background.png" style="width:100%;float:left;"/>';
            }
            ?>

            <div onclick="ajax_load_pages('<?php echo get_permalink($post->ID) ?>')" class="overlay-text">
                <p class="post_category"><?php echo category($post->ID); ?></p>

                <p class="post_title"><?php echo $post->post_title; ?></p>
                <?php
                if(has_post_video()) {
                    ?>
                    <div class="play-video">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px"
                             viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                        <defs>
                        </defs>
                            <path fill="<?php $author = get_user_profile($post->post_author);
                            echo '#' . $author->color_shade; ?>"
                                  d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>

                        </svg>
                    </div>
                <?php
                }
                ?>



            </div>
            <p class="post_link"><a  class="ajax-load"  class="ajax-load"  href="<?php echo get_site_url(); ?>/look">Look More</a></p>

        </div>
    </div>
</section>
