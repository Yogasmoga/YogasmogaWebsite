<?php
get_header();
$logged_in = is_user_logged_in();
?>
<?php
$home = get_site_url();
global $the_query;
global $page;
$filter_category_name = "look";
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
//                $i = 1;
$args = array(
    'post_type' => 'iloveyogasmoga',
    'paged' => $page);
$the_query = new WP_Query($args);
$i=0;

if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
    $post = get_post();
    $post_author = get_userdata($post->post_author);
    $author = get_user_profile($post->post_author);
    $color = '#'.$author->color_shade;

        ?>

        <div class="author_post_read" style="background: <?php echo $color; ?>">
            <?php echo get_the_post_thumbnail($post->ID, "mobile_posts");
            if (!has_post_thumbnail()) {
                echo '<img src="' . $home . '/wp-content/themes/rangoli_mobile/images/no-background_posts.png" />';
            }
            ?>
            <div class="overlay-text">

                <div class="align_bottom">
                    <div class="post_category"><?php echo get_post_categories(); ?></div>
                    <div class="post_title">LOVE, YOGASMOGA</div>
                    <div class="post_author"><span><?php echo $post->post_title; ?></span></div>
                </div>
            </div>
            <div class="close_post <?php if($logged_in){echo 'user-color-shade-trans';} ?>">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                width="44px" height="44px" viewBox="0 0 44 44" enable-background="new 0 0 44 44" xml:space="preserve">
                <g>
                <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="16.508" y1="15.751" x2="30.975" y2="30.218"/>
                <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="30.975" y1="15.751" x2="16.508" y2="30.218"/>
                </g>
                </svg>
            </div>

        </div>
        <div class="post_content">
            <?php
            $images =& get_children( 'post_parent='. $post->ID .'&orderby=menu_order&order=ASC&post_type=attachment&post_mime_type=image&numbersposts=-1' );

            foreach ( (array) $images as $attachment_id => $attachment ) {
            ?>


            <div class="insta_post_content">

                <?php
                echo "<img src='".wp_get_attachment_url( $attachment_id )."' />";
                $i++;?>
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

<?php
endwhile; endif;
wp_reset_query();
?>
<div class="insta_popup">
    <img src="" class="insta_post_image" />
</div>

<style>
    .insta_post.author_post_read .overlay-text{
        background: none;
    }
    .post_content {
        padding: 14px !important;
    }
    .insta_post_content {
        float: left;
        padding: 0 0 14px;
        width: 100%;
    }
    .insta_post_content img {
        float: left;
        height: auto;
        width: 100%;
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
    .insta_user{
        font: 12px/25px GraphikRegular;
        color: #999;
        letter-spacing: 1px;
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
