<?php
get_header();
$post = get_post();
?>

<div class="go_to_parent">
    <p>BACK TO LOVE, YOGASMOGA</p>
</div>

<div class="page_heading">
<h1><span>Love,</span> YOGASMOGA</h1>
<p><?php echo get_the_title($post);  ?></p>
</div>
<?php
    $post = get_post();
?>
    <div class="fixed_images_container">
    <div class="insta_weak_posts">
        <?php // find images attached to this post / page.
        $images =& get_children( 'post_parent='. $post->ID .'&orderby=menu_order&order=ASC&post_type=attachment&post_mime_type=image&numbersposts=-1' );

        foreach ( (array) $images as $attachment_id => $attachment ) {

            if($i==0){
                $class= "large left $i";
            }
            elseif($i%18==0){
                $class= "left $i";
            }
            elseif($i%9==0 && $i%2==0){
                $class = "left large $i";
            }
            elseif($i%14==0){
                $class = "left large $i";
            }
            elseif($i%9==0){
                $class= "right large $i";
            }
            else{
                $class="left $i";
            }

            ?>


            <div class="insta_post_content <?php echo $class ?>">

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
        .page_heading{
            padding: 50px 0;
            text-align: center;
            color: #666;
        }
        .page_heading h1{
            font: normal 30px/35px ITCAvantGardeStd-Bk;
        }
        .page_heading h1 span{
            font: 35px/50px freight-text-pro;
            font-weight: 300;
        }
        .page_heading p{
            font:400 20px/35px freight-text-pro;
        }
        .left{
            float: left;
            width:25%
        }
        .large{
            width: 50% !important;
        }
        .right{
            float: right;
        }
        .insta_post_content{
            display: block;
            padding: 5px;
            box-sizing: border-box;
        }
        .insta_post_content img {
            float: left;
            height: auto;
            width: 100%;
        }
        .fixed_images_container {
            float: none;
            margin: 0 auto;
            width: 670px;
        }
        .insta_popup {
            bottom: 0;
            left: 0;
            position: fixed;
            right: 0;
            top: 0;
            display: none;
        }
        .insta_post_image {
            border: medium none;
            left: 50%;
            margin: -270px 0 0 -320px;
            position: fixed;
            top: 50%;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }
        .go_to_parent > p {
            border-bottom: 1px solid #656565;
            color: #656565;
            font: 12px/15px freight-text-pro;
            letter-spacing: 1px;
            margin: 0 auto;
            padding: 15px 0;
            text-align: center;
            width: 314px;
        }
    </style>

<script>
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