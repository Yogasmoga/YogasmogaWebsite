<?php
$post = get_post();
//$heading_block = get_post_meta($post->ID, "wpcf-heading-block");
$first_image = get_post_meta($post->ID, "wpcf-first-image");
$first_product_name = get_post_meta($post->ID, "wpcf-first-product-name");
$first_product_url = get_post_meta($post->ID, "wpcf-first-product-url");
$second_image = get_post_meta($post->ID, "wpcf-second-image");
$second_product_name = get_post_meta($post->ID, "wpcf-second-product-name");
$second_image_url = get_post_meta($post->ID, "wpcf-second-product-url");
$third_image = get_post_meta($post->ID, "wpcf-third-image");
$third_product_name = get_post_meta($post->ID, "wpcf-third-product-name");
$third_image_url = get_post_meta($post->ID, "wpcf-third-product-url");
$fourth_image = get_post_meta($post->ID, "wpcf-fourth-image");
$fourth_product_name = get_post_meta($post->ID, "wpcf-fourth-product-name");
$fourth_image_url = get_post_meta($post->ID, "wpcf-fourth-product-url");

if (
	//isset($heading_block) && count($heading_block) > 0 &&
    isset($first_image) && count($first_image) > 0 &&
    isset($first_product_name) && count($first_product_name) > 0 &&
    isset($first_product_url) && count($first_product_url) > 0 &&
	isset($second_image) && count($second_image) > 0 &&    
    isset($second_product_name) && count($second_product_name) > 0 &&
    isset($second_image_url) && count($second_image_url) > 0  &&
	isset($third_image) && count($third_image) > 0 &&
	isset($third_product_name) && count($third_product_name) > 0 &&
	isset($third_image_url) && count($third_image_url) > 0 &&
	isset($fourth_image) && count($fourth_image) > 0 &&
	isset($fourth_product_name) && count($fourth_product_name) > 0 &&
	isset($fourth_image_url) && count($fourth_image_url) > 0
	
) {
    ?>
    <div class="row">
        <div class="span1"></div>
        <div class="span12 get_the_look">
            <!--<p><?php // echo implode("", $heading_block) ?></p>-->

            <div class="span12">
                <a href="<?php echo implode("", $first_product_url) ?>">
                    <img src="<?php echo implode("", $first_image) ?>"/>
                    <span><?php echo implode("", $first_product_name) ?></span>
                </a>
            </div>
            <div class="span12">
                <a href="<?php echo implode("", $second_image_url) ?>">
                    <img src="<?php echo implode("", $second_image) ?>"/>
                    <span><?php echo implode("", $second_product_name) ?></span>
                </a>
            </div>
			<div class="span12">
                <a href="<?php echo implode("", $third_image_url) ?>">
                    <img src="<?php echo implode("", $third_image) ?>"/>
                    <span><?php echo implode("", $third_product_name) ?></span>
                </a>
            </div>
			<div class="span12">
                <a href="<?php echo implode("", $fourth_image_url) ?>">
                    <img src="<?php echo implode("", $fourth_image) ?>"/>
                    <span><?php echo implode("", $fourth_product_name) ?></span>
                </a>
            </div>
        </div>
        <div class="span1"></div>
    </div>
<?php
}
