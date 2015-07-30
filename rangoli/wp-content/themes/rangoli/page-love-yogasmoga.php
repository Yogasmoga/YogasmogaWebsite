<?php
get_header();
?>
    <div class="page_heading">
        <h1><span>Love,</span> YOGASMOGA</h1>
        <p>View our SMOGIs looking their best in this week's Instagram posts.<br/>
            Because no one wears it better than you</p>
    </div>
<?php
ob_flush();
global $the_query;
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$i = 0;
$args = array(
    'post_type' => 'iloveyogasmoga',
    'paged' => $page);
    $the_query = new WP_Query($args);
?>
    <div class="fixed_images_container">
        <?php
        if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();

            ?>

    <?php
    $banner_img_url=wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

    ?>

    <div class="insta_post" onclick="ajax_load_pages('<?php echo get_permalink(); ?>')">
        <?php echo get_the_post_thumbnail(); ?>
    </div>
    <div class="insta_post_summary">
        <p class="insta_post_name"><?php echo get_the_title(); ?></p>
    <p class="insta_post_author">@<?php $meta = get_post_meta($post->ID, 'wpcf-instagram-author');  echo $meta[0];  ?></p>
        <p class="insta_post_excerpt"><?php echo get_the_excerpt(); ?></p>
    </div>
            <?php
        endwhile;
        endif;
        ?>
    </div>
    <style>
        .insta_post{
            width:480px;
            display: block;
            margin: 0 auto 20px;
            box-sizing: border-box;
        }
        .insta_post img{
            width: 100%;
            height: auto;;
        }
        .page_heading{
             padding: 50px 0;
             text-align: center;
             color: #666;
        }
        .page_heading h1{
            font: normal 30px/35px ITCAvantGardeStd-Bk;
        }
        .insta_post_author {
            color: #333;
            font: 12px/17px Graphik-SemiBold;
            letter-spacing: 0.5px;
            margin-top: 20px;
        }
        .insta_post_excerpt {
            color: #333;
            font: 12px/17px GraphikRegular;
            margin-bottom: 30px;
        }
        .insta_post_summary{
            text-align: center;
        }
        .page_heading h1 span{
            font: 35px/50px freight-text-pro;
            font-weight: 300;
            font-style: italic;
        }
        .page_heading p {
            font: 400 12px/17px GraphikRegular;
            margin-top: 40px;
        }
        .insta_post_name {
            font: 20px/35px freight-text-pro;
            text-align: center;
            text-transform: capitalize;
            color: #656565;
        }
    </style>
<?php
get_footer();
?>