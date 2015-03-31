<?php
// Set the image size. Accepts all registered images sizes and array(int, int)
$post = get_post();
$user_id = $post->post_author;
$user_info = get_userdata($user_id);
$size = 'thumbnail';
// Get the image URL using the author ID and image size params
$users = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $user_id);
if ($users) {
    $main_color = $users[0]->color_main;
}
$size = 'thumbnail';
$imgURL = get_the_author_meta('cupp_upload_meta', $user_id);
echo "<div class='row'>";

if ($imgURL != "") {
    echo '<div onclick="ajax_load_pages(\'' . get_author_posts_url($user_id) . ' \')" class="profile-img" style="background: url(\'' . $imgURL . '\'); background-size: 100%;">';
    echo '</div>';
} else {
    echo '<div onclick="ajax_load_pages(\'' . get_author_posts_url($user_id) . ' \')"  class="profile-img" style="background: url(\'' . get_site_url() . '/wp-content/themes/rangoli/images/default.jpg\'); background-size: 100%;">';
    echo '</div>';

}
$roles = $user_info->roles;
if (is_array($roles) && count($roles) > 0) {
    $role = $roles[0];
    if ($role == "smogi") {
        $main_color = strtoupper($main_color);
        $level = get_user_level($user_id);
        echo '<span  class="charm color_' . $main_color . ' ' . $level . '"></span>';
    }
}

?>

<?php
$addr = get_user_meta($user_id, 'wpcf-address');


echo "<p class='post_author row'>" . $user_info->display_name . "</p>";
if (!empty($addr))
    echo "<p class='post_author_address row'> " . nl2br($addr[0]) . "</p>";
$user_interests = get_user_interests($user_info->ID);
if (count($user_interests) > 0)
    if (!empty($user_interests)) {
        echo "<div class='row interests'>";
        foreach ($user_interests as $user_interest) {
            echo "<span>" . $user_interest . "</span> ";
        }
        echo "</div>";
    }
$smogi_balance = get_user_smogi_bucks($user_id);
if (isset($smogi_balance)) {
    if (is_array($roles) && count($roles) > 0) {
        $role = $roles[0];
        if ($role == "smogi")
            echo "<p class='smogiBucks'>$smogi_balance SMOGI Bucks </p>";
    }
}


echo "</div>";
?>