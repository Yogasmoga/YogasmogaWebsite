<?php
get_header();
$post=get_post();
/*$user_id=$post->post_author;
$users = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=".$user_id);
if($users){
$user=$users[0];
$author_color=$user->color_shade;
}
$author_color="555555";

$banner_img_url=wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );*/

    ?>

    



    <div class="row ww post_content_box rangoli_press_content">
        <div class="twenty">
            <div class="author_details_post">
			<p class="press-icon"><a href="<?php echo(types_render_field( "contributing-website-url", array( 'raw' => true) )); ?>">
				<img src="<?php echo(types_render_field( "contributing-website-icon", array( 'raw' => true) )); ?>" alt="" />
			</a></p>
			
			<p class="press-name"><a href="<?php echo(types_render_field( "contributing-website-url", array( 'raw' => true) )); ?>">
				<?php echo(types_render_field( "contributing-website", array( 'raw' => true) ));?>
			</a></p>
			
            </div>
        </div>

        <div class="sixty">
            <div class="post_content">
                <?php
//                
                echo "<div class='clear'></div>";
                $content = $post->post_content;
                $content = apply_filters('the_content', $content);
                echo ($content);
                
                ?>
            </div>
            <div class="comments row">
                <p class="align-center">COMMENTS</p>

                <?php

                echo get_template_part("post", "comments");
                ?>
            </div>


           


            </div>


        <div class="right post_right_share_like">
<!--             style="margin-right: 50px;"-->

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
                        <a target="_blank" rel="<?php echo $post->ID; ?>" user="<?php echo get_current_user_id();  ?>" href="mailto:?subject= RANGOLI—The YOGASMOGA Community &amp;body=Check out <?php echo $post->post_title; ?> on Rangoli <?php echo $b_pl; ?> ">
                            <img src="/rangoli/wp-content/themes/rangoli/images/mail.png">
                            <img src="/rangoli/wp-content/themes/rangoli/images/mail_hover.png">
                        </a>
                    </li>
                </ul>
            </div>

            <!--<div class="post_share">
                <?php
/*                    echo  get_template_part("shareIcon");
                */?>
            </div>-->


            <!--<div class="single_post_like">
                <?php /* wpfp_link(); */ ?>
            </div>-->
        </div>



        </div>
</div>
<!---->
<?php

get_footer();
//?>