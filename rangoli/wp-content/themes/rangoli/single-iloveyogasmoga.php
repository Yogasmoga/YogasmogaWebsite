<?php
get_header();
$post=get_post();
$banner_img_url=wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

    ?>

    <div class="wp_page_banner" style="background: #CCC url('<?php echo get_site_url()."/wp-content/themes/rangoli/images/pattern.png" ?>') repeat;">
        <?php
            echo "<a class='back_to_parent' href='".get_site_url()."/love-yogasmoga'>BACK TO LOVE</a>";
        ?>
        <?php
        $categories = get_the_category_list(" ");
        $categories_list = strtolower($categories);
        $categories = str_replace('homepage', '', $categories_list);
        $categories = str_replace('read', '', $categories);
        $categories = str_replace('look', '', $categories);
        $categories = str_replace('learn', '', $categories);
        $categories = strtoupper($categories);

?>
        <div class='overlay-text' style="background: none; padding: 0;">
            <img src="<?php echo $banner_img_url[0]; ?>" />
            <div class='align-bottom'>
                <p class='post_category'><?php echo $categories ?></p>
                    <p class='post_title'>LOVE, YOGASMOGA</p>
                    <p class='post_subtitle'><?php echo $post->post_title ?><p>
            </div>
        </div>
    </div>



    <div class="row ww post_content_box">

        <div class="row post_right_share_like">

            <div class="sharing_icons">
                <ul>
                    <?php
                        $post_link = get_permalink($post->ID);
                        $b_pl = get_bitly_url($post_link);
                    ?>
                    <li>
                        <a target="_blank" rel="<?php echo $post->ID; ?>" user="<?php echo get_current_user_id();  ?>" href="https://www.facebook.com/sharer/sharer.php?app_id=853109404769569&u=<?php echo $b_pl; ?>">
                            <img src="/rangoli/wp-content/themes/rangoli/images/fb.png">
                            <img src="/rangoli/wp-content/themes/rangoli/images/fb_hover.png">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" rel="<?php echo $post->ID; ?>" user="<?php echo get_current_user_id();  ?>" href="http://twitter.com/intent/tweet?text=<?php echo $post->post_title;  ?>&url=<?php echo $b_pl; ?>">
                            <img src="/rangoli/wp-content/themes/rangoli/images/tw.png">
                            <img src="/rangoli/wp-content/themes/rangoli/images/tw_hover.png">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" rel="<?php echo $post->ID; ?>" user="<?php echo get_current_user_id();  ?>" href="https://pinterest.com/pin/create/button/?url=<?php echo $b_pl; ?>&media=<?php echo $banner_img_url[0]; ?> ">
                            <img src="/rangoli/wp-content/themes/rangoli/images/pin.png">
                            <img src="/rangoli/wp-content/themes/rangoli/images/pin_hover.png">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" rel="<?php echo $post->ID; ?>" user="<?php echo get_current_user_id();  ?>" href="mailto:?subject= RANGOLI &mdash; The YOGASMOGA Community &amp;body=Check out <?php echo $post->post_title; ?> on Rangoli <?php echo $b_pl; ?> ">
                            <img src="/rangoli/wp-content/themes/rangoli/images/mail.png">
                            <img src="/rangoli/wp-content/themes/rangoli/images/mail_hover.png">
                        </a>
                    </li>
                    <li>

                        <div class="likeandshare">
                            <div class="like-btn">
                                <?php echo wpfp_link(); ?>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

    <div class="row">
        <?php // find images attached to this post / page.
        $images =& get_children( 'post_parent='. $post->ID .'&orderby=menu_order&order=ASC&post_type=attachment&post_mime_type=image&numbersposts=-1' );
        $i=0;
        foreach ( (array) $images as $attachment_id => $attachment ) {
            ?>


            <div class="span4 insta_post">

                <?php
                $url =wp_get_attachment_url( $attachment_id );
                echo "<img src='".$url."' />";
                ?>
                <div class="insta_user">
                    <?php
                    $array = explode("/",$url);
                    $lastElement = count($array) - 1;
                    $ImageName = $array[$lastElement];
                    $extractNameArray = explode("@@@",$ImageName);
                    echo $extractNameArray[0];

                    ?>
                </div>
            </div>
        <?php	}

        ?>
    </div>

</div>
<style>
    .insta_post img{
        width: 100%;
        height: auto;
    }
    .overlay-text .post_category{
        width: 30%;
    }
    .wp_page_banner{
        background-size: auto auto !important;
    }
    .overlay-text>img{
        height: 100%;
    }
    .sharing_icons {
        float: right;
        margin: -39px 2px 0 0;
        position: relative;
    }
    .likeandshare {
        display: block;
        position: initial;
        width: 32px;
    }
    .insta_user{
        font: 12px/25px GraphikRegular;
        color: #999;
        letter-spacing: 1px;
    }
</style>
<?php
get_footer();
?>



