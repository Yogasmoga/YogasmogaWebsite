<?php
get_header();
?>
<?php
    $post = get_post();
?>
    <div class="fixed_images_container">
        <?php
            $banner_img_url=wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
        ?>

            <div class="author_post_read insta_post">
                <a href="<?php echo get_permalink($post->ID) ?>">
                <?php echo get_the_post_thumbnail(); ?>
                </a>
                <div class="overlay-text"></div>

                    <div class="insta_post_summary">
                        <p class="insta_post_name"><?php echo get_the_title(); ?></p>
                        <!--<p class="insta_post_author">@<?php /*$meta = get_post_meta($post->ID, 'wpcf-instagram-author');  echo $meta[0];  */?></p>
                        <p class="insta_post_excerpt"><?php /*/*echo get_the_excerpt(); */?></p>-->
                    </div>


                <div class="close_post_index    user-color-shade-trans"  style="display: block;">
                    <svg xml:space="preserve" enable-background="new 0 0 44 44" viewBox="0 0 44 44" height="44px" width="44px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">
            <g>
                <line y2="30.218" x2="30.975" y1="15.751" x1="16.508" stroke-miterlimit="10" stroke="#FFFFFF" fill="none"/>
                <line y2="30.218" x2="16.508" y1="15.751" x1="30.975" stroke-miterlimit="10" stroke="#FFFFFF" fill="none"/>
            </g>
            </svg>
                </div>


            </div>



            <div class="insta_weak_posts post_content row" style="display: block;">
                <?php // find images attached to this post / page.
                $images =& get_children( 'post_parent='. $post->ID .'&orderby=menu_order&order=ASC&post_type=attachment&post_mime_type=image&numbersposts=-1' );

                foreach ( (array) $images as $attachment_id => $attachment ) {
                    ?>


                    <div class="insta_post_content">

                        <?php
                        echo "<img src='".wp_get_attachment_url( $attachment_id )."' />";
                        $i++;?>

                    </div>
                <?php	}

                ?>

            </div>



  </div>
    <div class="insta_popup">
        <img src="" class="insta_post_image" />
    </div>

    <style>
        .insta_post.author_post_read{
            margin-bottom: 2px;
        }
        .insta_post.author_post_read .overlay-text{
            background: none;
        }
        .insta_weak_posts.post_content{
            padding: 0;
        }
        .insta_post_content{
            float:left;
            width:50%;
            box-sizing: border-box;
            padding: 2px;
        }
        .insta_post_summary {
            color: #656565;
            font: 20px/35px freight-text-pro;
            padding: 8px;
            text-align: center;
            text-transform: capitalize;
        }
        .insta_post_content:nth-child(odd){
            padding-left: 0px;
        }
        .insta_post_content:nth-child(even){
            padding-right: 0px;
        }
        .insta_post_content img {
            float: left;
            height: auto;
            width: 100%;
        }
        .fixed_images_container {
            float: none;
            margin: 0 auto;
            width: 100%;
            max-width: 640px;
        }
        .insta_popup {
            bottom: 0;
            left: 0;
            position: fixed;
            right: 0;
            top: 0;
            display: none;
            padding: 120px 10px 0;
            text-align: center;
            z-index: 10;
        }
        .insta_post_image {
            border: medium none;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            height: auto;
            max-height: 75%;
            max-width: 100%;
            width: auto;
        }
    </style>

    <script>
        $(".page_name").html("LOVE, YOGASMOGA");
        $(document).ready(function(){
            $(".insta_post_content").each(function(){
                var image = $(this).find("img");
                var image_src = image.attr("src");
                image.click(function(){
                    $(".insta_popup").fadeIn();
                    $(".insta_popup img").attr("src",image_src);
                });
            });
            $(".insta_popup").click(function(){
                $(this).fadeOut();
            })
        })
    </script>

<?php
get_footer();
?>