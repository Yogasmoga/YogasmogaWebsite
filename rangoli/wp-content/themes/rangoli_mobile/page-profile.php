<?php
get_header();

$home = get_site_url();
$media = $home."/wp-content/themes/rangoli_mobile/images/";
$user_id=$_REQUEST["user_id"];
if(user_id_exists($user_id)){

$user_info=get_userdata($user_id);
$profile = get_user_profile($user_id);
$urls = get_user_meta($user_id,"cupp_upload_meta");
$image_src = $media."default.jpg";
$designations = get_user_meta($user_id,"wpcf-profession");
$name = $profile->user_display_name;
if($name==null) {
    $name = $user_info->display_name;
}


if(is_array($urls) && count($urls)>0) {
    $image_src = $urls[0];
}

if(is_array($designations) && count($designations)>0) {
    $designation = $designations[0];
}
?>
<div class="row" style="position: relative" xmlns="http://www.w3.org/1999/html">
    <div class="charm user_charm <?php echo get_user_level($user_id)." color_".strtoupper($profile->color_main); ?>"></div>
    <div class="profile_picture_user">
        <img src="<?php echo $image_src; ?>" />
    </div>
    <p class="username"><?php echo strtoupper($user_info->display_name); ?></p>
    <p class="designation"><?php echo $designation; ?></p>
</div>

    <div class="author_posts" style="display: block;">
        <?php
        echo get_user_liked_posts($user_id);
        echo get_user_feeds($user_id);
        ?>
    </div>


<?php $interests =  get_user_interests($user_id);

$args = array(
    'type' => 'post',
    'child_of' => 0,
    'parent' => '',
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => 0,
    'hierarchical' => 1,
    'exclude' => '',
    'include' => '',
    'number' => '',
    'taxonomy' => 'category',
    'pad_counts' => false

);
$categories = get_categories($args);
?>
<div class="author_posts" style="display: block;">
    <p class="align-center author_posts_heading" style="margin-bottom: 0;"><?php echo strtoupper($name); ?>'S INTERESTS</p>
</div>
<div class="interest_listing" style="padding-bottom:0;">
    <span class="shade_overlay"></span>
<ul>
<?php
foreach ($categories as $cat){
    if(is_array($interests) && count($interests)>0){
        foreach($interests as $interest){
            if($cat->slug == $interest) {
                ?>


                    <li class="remove <?php echo $cat->slug; ?>">
                        <span></span>
                        <?php echo $cat->cat_name; ?>
                    </li>


                <?php
            }
        }
    }
}
?>
</ul>
</div>
<?php

}
else{
    wp_redirect(get_site_url());
}

get_footer();
