<?php
/*
 *  Template Name: LIKED POSTS
 */


if (!is_user_logged_in()) {
    wp_redirect(get_site_url());
}
get_header();
?>

    <div class="wp_page row" style="margin-top: 50px; text-align: center;">
        <?php
$cat = "look, learn, read";
echo filter($cat);
?>
        <h1 class="align-center page-heading">LIKED</h1>

        <div class='row span12 post_listing'>
            <div id="posts">

            <?php
echo get_template_part("liked", "readings");
echo get_template_part("liked", "watchings");
echo get_template_part("liked", "learnings");
?>

            </div>
        </div>
    </div>



<?php
get_footer();
?>