<?php
$post = get_post();

$left_image = get_post_meta($post->ID, "wpcf-left-image");
$right_image = get_post_meta($post->ID, "wpcf-right-image");
$left_product_name = get_post_meta($post->ID, "wpcf-left-product-name");
$right_product_name = get_post_meta($post->ID, "wpcf-right-product-name");
$left_product_url = get_post_meta($post->ID, "wpcf-left-product-url");
$right_image_url = get_post_meta($post->ID, "wpcf-right-product-url");

if (
    isset($left_image) && count($left_image) > 0 &&
    isset($right_image) && count($right_image) > 0 &&
    isset($left_product_name) && count($left_product_name) > 0 &&
    isset($left_product_url) && count($left_product_url) > 0 &&
    isset($right_product_name) && count($right_product_name) > 0 &&
    isset($right_image_url) && count($right_image_url) > 0
) {
    ?>
    <div class="row">
        <div class="span1"></div>
        <div class="span10 get_the_look">
            <p>GET THIS LOOK</p>

            <div class="span6">
                <a href="<?php echo implode("", $left_product_url) ?>">
                    <img src="<?php echo implode("", $left_image) ?>"/>
                    <span><?php echo implode("", $left_product_name) ?></span>
                </a>
            </div>
            <div class="span6">
                <a href="<?php echo implode("", $right_image_url) ?>">
                    <img src="<?php echo implode("", $right_image) ?>"/>
                    <span><?php echo implode("", $right_product_name) ?></span>
                </a>
            </div>
        </div>
        <div class="span1"></div>
    </div>
<?php
}
