<?php
get_header();
$post=get_post();
$user_id=$post->post_author;
$users = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=".$user_id);
if($users){
$user=$users[0];
$author_color=$user->color_shade;
}
$author_color="555555";

$banner_img_url=wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

    ?>

     <div class="wp_page_banner rangoli_press_banner" style="background: url('<?php echo $banner_img_url[0]; ?>') no-repeat; background-size: cover; <?php echo '#'.$author_color; ?>">
        <?php
            if(has_category("read"))
                    echo "<a class='back_to_parent' href='".get_site_url()."/read'>BACK TO READ</a>";
            else if(has_category("look"))
                    echo "<a class='back_to_parent' href='".get_site_url()."/look'>BACK TO LOOK</a>";
            else if(has_category("read"))
                    echo "<a class='back_to_parent' href='".get_site_url()."/learn'>BACK TO LEARN</a>";
        ?>
        <?php
        $categories = get_the_category_list(" ");
        $categories_list = strtolower($categories);
        $categories = str_replace('homepage', '', $categories_list);
        $categories = str_replace('read', '', $categories);
        $categories = str_replace('look', '', $categories);
        $categories = str_replace('learn', '', $categories);
        $categories = strtoupper($categories);


        if (has_post_video()) {

            $authors = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $user_id);
            $author_color = '#'.$authors[0]->color_shade;
            ?>
            <div class="play-video" video="<?php echo get_the_post_video_url($post->ID); ?>">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                    <defs>
                    </defs>
                    <path fill="<?php echo $author_color; ?>"
                          opacity="0.9" enable-background="new" d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                </svg>
            </div>
        <?php
        }


        echo " <div class='overlay-text'>
                    <div class='align-bottom'>
                        <p class='post_category'>" . $categories . "</p>";


//        echo "<p class='post_title'>" . $title . "</p>";
//        if (!$category[0]) {
                        echo "<p class='post_title'>".$post->post_title."</p>"; ?>
						<p class="press-name">
							<a href="<?php echo(types_render_field( "contributing-website-url", array( 'raw' => true) )); ?>">
								<?php echo "From: ".(types_render_field( "contributing-website", array( 'raw' => true) ));?>
							</a>
						</p>
                        <?php echo "<p class='post_subtitle'>" . $post->post_excerpt . "<p>";
//        }
//        echo "<p class='post_link'><a href='" . get_the_permalink() . "'>" . $link_text[0] . "</a></p>";
                    echo "</div>
            </div>";

        if(has_post_video()){
            echo "<div class='play_video'>";
                        the_post_video();
            echo "</div>";
        }

        ?>
    </div>

	<!--<p class="press-icon"><a href="<?php // echo(types_render_field( "contributing-website-url", array( 'raw' => true) )); ?>">
				<img src="<?php // echo(types_render_field( "contributing-website-icon", array( 'raw' => true) )); ?>" alt="" />
			</a></p>-->

    <div class="row ww post_content_box rangoli_press_content">
        <div class="twenty">
            <div class="author_details_post">
			<p class="press-icon"><a href="<?php  echo(types_render_field( "contributing-website-url", array( 'raw' => true) )); ?>">
				<img src="<?php  echo(types_render_field( "contributing-website-icon", array( 'raw' => true) )); ?>" alt="" />
			</a></p>
			
			<!--<p class="press-name"><a href="<?php // echo(types_render_field( "contributing-website-url", array( 'raw' => true) )); ?>">
				<?php // echo(types_render_field( "contributing-website", array( 'raw' => true) ));?>
			</a></p>-->
			
            </div>
        </div>

        <div class="sixty">
			
            <div class="post_content">
				
                <?php
                echo "<div class='clear'></div>";
                $content = $post->post_content;
                $content = apply_filters('the_content', $content);
                echo ($content);
                
                ?>
            </div>
			
			
			
            <div class="comments row">
                <!--<p class="align-center">COMMENTS</p>-->

                <?php

                 // echo get_template_part("post", "comments");
                ?>
            </div>


           


            </div>


        <div class="twenty">
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
			<?php echo get_template_part("rangoli-press", "getthelook"); ?>
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