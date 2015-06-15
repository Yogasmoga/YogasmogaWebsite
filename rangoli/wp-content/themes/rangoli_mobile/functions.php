<?php

add_theme_support('post-thumbnails');
add_image_size('banner', '1024', '600', true);
add_image_size('thumb', '700', '525', true);
add_image_size('mobile_slider', '600', '750', true);
add_image_size('mobile_posts', '500', '375', true);
add_image_size('mobile_posts_half', '500', '500', true);

function add_url_rewrite()
{
    add_rewrite_rule('^([0-9]+)/?', 'index.php/profile/?user_id=$matches[1]', 'top');
}

add_action('init', 'add_url_rewrite');

function themeblvd_disable_admin_bar()
{
    if (!current_user_can('edit_posts'))
        add_filter('show_admin_bar', '__return_false');
}

add_action('after_setup_theme', 'themeblvd_disable_admin_bar');

function themeblvd_redirect_admin()
{
    if (!current_user_can('edit_posts')) {
        wp_redirect(site_url());
        exit;
    }
}

add_action('admin_init', 'themeblvd_redirect_admin');


add_role(
    'store',
    __('YS Stores'),
    array(

        'read' => true, // true allows this capability
        'edit_posts' => true, // Allows user to edit their own posts
        'edit_pages' => true, // Allows user to edit pages
        'edit_published_posts' => true, // Allows user to edit others posts not just their own
        'create_posts' => true, // Allows user to create new posts
        'manage_categories' => true, // Allows user to manage post categories
        'publish_posts' => true, // Allows the user to publish, otherwise posts stays in draft mode
        'delete_posts' => true,
        'delete_published_posts' => true,


    )
);
add_role(
    'smogi',
    __('YS Smogi'),
    array(

        'read' => true, // true allows this capability
        'edit_posts' => true, // Allows user to edit their own posts
        'create_posts' => true, // Allows user to create new posts
        'publish_posts' => true, // Allows the user to publish, otherwise posts stays in draft mode
        'delete_posts' => true,
    )
);


$role = get_role('smogi');
// This only works, because it accesses the class instance.
$role->add_cap('edit_published_posts');
$role->add_cap('upload_files');
$role->add_cap('publish_posts');

$role = get_role('store');
// This only works, because it accesses the class instance.
$role->add_cap('edit_published_posts');
$role->add_cap('upload_files');
$role->add_cap('publish_posts');


function register_my_menus()
{
    register_nav_menus(
        array(
            'menu1' => __('Category_pages Menu'),
            'menu2' => __('YS Menu'),
            'menu3' => __('Menu3'),
            'menu1_mobile' => __('Category_pages_Menu_mobile'),
            'menu2_mobile' => __('YS_Menu_mobile'),
            'menu3_mobile' => __('Menu3_mobile')
        )
    );
}

add_action('init', 'register_my_menus');

function get_post_categories($post_id = false)
{
    $categories = get_the_category_list(" ", "", $post_id);

//    return $categories;
    $categories = strtolower($categories);
    $categories = str_replace('homepage', '', $categories);
    $categories = str_replace('read', '', $categories);
    $categories = str_replace('look', '', $categories);
    $categories = str_replace('learn', '', $categories);
    $categories = strtoupper(trim($categories));

    return $categories;
}

/*
function get_post_categories($post_id = false){
    $category_names = array();
    $post=get_post($post_id);
    $categories = get_categories("exclude=read,look,learn,all");

    foreach($categories as $category){
        if(has_category($category,$post))
            $category_names[] = $category->cat_name;
    }
    $categories="";

    $i=0;
    foreach($category_names as $name){
        $i++;
        $name = strtolower($name);
        if($name != "read" &&  $name != "look" && $name != "learn"){
            $categories = $categories.$name.", ";
        }
    }
    $categories = substr($categories,0, -2);
    $categories = strtoupper(trim($categories));

    return $categories;
}*/


function get_user_level($user_id)
{
    $user_info = get_userdata($user_id);
    $root = get_site_url();
    $root = str_replace("/rangoli", "/", $root);
    $json = file_get_contents($root . 'ys/session/getcustomerbyemail/email/' . $user_info->user_login);
    if ($json) {
        $magento_user = json_decode($json);
        if ($magento_user) {
            $magento_id = $magento_user->user_id;
            if (isset($magento_id)) {
                $smogi_balance = json_decode(file_get_contents($root . "ys/session/customertotalsmogibucks/id/" . $magento_id));

                if ($smogi_balance) {
                    if ($smogi_balance <= 50) {
                        $level = "level_1";
                    }
                    if ($smogi_balance <= 100 && $smogi_balance > 50) {
                        $level = "level_2";
                    }
                    if ($smogi_balance <= 150 && $smogi_balance > 100) {
                        $level = "level_3";
                    }
                    if ($smogi_balance <= 200 && $smogi_balance > 150) {
                        $level = "level_4";
                    }
                    if ($smogi_balance <= 250 && $smogi_balance > 200) {
                        $level = "level_5";
                    }
                    if ($smogi_balance <= 300 && $smogi_balance > 250) {
                        $level = "level_6";
                    }
                    if ($smogi_balance > 300) {
                        $level = "level_7";
                    }

                    reset($magento_user);
                    return $level;
                } else {
                    return "hide";
                }
            } else {
                return "hide";
            }
        } else {
            return "hide";
        }
    }
}


function get_user_interests($id)
{
    $root = get_site_url();
    $interests = json_decode(file_get_contents($root . '/wp_get_user_interests.php?user_id=' . $id));
    if ($interests) {
        return $interests;

    } else {
        return "";
    }
}


function get_user_smogi_bucks($id)
{
    $user_info = get_userdata($id);
    $roles = $user_info->roles;

    $root = get_site_url();
    $root = str_replace("/rangoli", "/", $root);
    $magento_user = json_decode(file_get_contents($root . 'ys/session/getcustomerbyemail/email/' . $user_info->user_login));
    if ($magento_user) {
        $magento_id = $magento_user->user_id;
        if (isset($magento_id)) {
//            $smogi_balance = json_decode(file_get_contents($root . "ys/session/customertotalsmogibucks/id/" . $magento_id));
            global $wpdb;
            $query = "SELECT points_current,points_spent FROM rewardpoints_account where customer_id=$magento_id";
            $points = $wpdb->get_results($query);

            if ($points && count($points) > 0) {


                $smogi_bucks = 0;
                foreach ($points as $point) {

                    $point_data = get_object_vars($point);

                    $smogi_bucks += intval($point_data["points_current"]);
                    $smogi_bucks += intval($point_data["points_spent"]);

                }
            } else

                $smogi_bucks = "0";

            if ($smogi_bucks) {
                if (is_array($roles) && count($roles) > 0) {
                    $role = $roles[0];
                    if ($role == "store") {
                        reset($magento_user);
                        return 0;
                    } else
                        return $smogi_bucks;
                } else
                    return $smogi_bucks;
            } else return 0;

        } else return 0;
    } else return 0;
}

function get_user_profile_from_magento($id)
{
    $user_info = get_userdata($id);
    $root = get_site_url();
    $root = str_replace("/rangoli", "/", $root);
    $magento_user = json_decode(file_get_contents($root . 'ys/session/getcustomerbyemail/email/' . $user_info->user_login));
    if ($magento_user) {
        $magento_id = $magento_user->user_id;
        $rangoli_user = json_decode(file_get_contents($root . 'ys/session/getrangoliprofilebyid?id=' . $magento_id));
//        print_r($rangoli_user);
        return $rangoli_user;

    }
}


function get_post_rating($subject_id, $subject_type)
{
    global $wpdb;
    $query = "select avg(rating_value) as rating_value from rangoli_ratings where subject_id=$subject_id and subject_type='$subject_type'";

    $rating = $wpdb->get_results($query);

    if ($rating && count($rating) > 0) {

        $post_rating = get_object_vars($rating[0]);
        return $post_rating['rating_value'];
    } else {
        return 0;
    }
}


function get_user_profile($userId)
{
    global $wpdb;

    $user_profile_info = $wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=" . $userId);

    if ($user_profile_info) {
        return $user_profile_info[0];

    }
}


function get_bitly_url($link, $format = 'txt')
{
    $login = "yogasmogarangoli";
    $appkey = "R_0f1d1bc2a82f472eaa33ef817e8d5548";
    $bitly_api = 'http://api.bit.ly/v3/shorten?login=' . $login . '&apiKey=' . $appkey . '&uri=' . urlencode($link) . '&format=' . $format;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $bitly_api);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}


function is_journey_first_time()
{
    $visited = 0;
    $currentUser = get_current_user_id();
    $userInformation = get_user_profile($currentUser);
    if ($userInformation) {
        $visited = $userInformation->journey_visited;
    }
    return $visited;
}

function make_journey_visited()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $result = $wpdb->query("update rangoli_user_profiles set journey_visited=1 where user_id=$user_id");

    if ($result) {
        return true;
    } else {
        return false;
    }
}


function curl_get($url)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    $return = curl_exec($curl);
    curl_close($curl);
    return $return;
}

function youtube_id_from_url($url)
{

    $result = str_replace("http://youtu.be/", "", $url);
    if ($result) {
        return $result;
    }
    return false;
}

function getVideolength($videoid = '')
{
    define('YT_API_URL', 'http://gdata.youtube.com/feeds/api/videos?q=');
    $video_id = $videoid;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, YT_API_URL . $video_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $feed = curl_exec($ch);
    curl_close($ch);
    $xml = simplexml_load_string($feed);
    $entry = $xml->entry[0];
    $media = $entry->children('media', true);
    $group = $media->group;
    $vid_duration = $group['yt:duration'];
    $duration_formatted = str_pad(floor($vid_duration / 60), 2,
            '0', STR_PAD_LEFT) . ':' . str_pad($vid_duration % 60, 2, '0', STR_PAD_LEFT);
    return $duration_formatted;
}


function get_post_comments($post_id)
{
    ?>
    <div class="post_comments_listing">
    <?php
    $post = get_post();
    $comments = get_comments(array('post_id' => $post->ID, "order" => "DESC"));

    $count = count($comments);
    $i = 0;
    $print = 0;
    if ($count > 3):
        $print = 3;
    else:
        $print = 4;
    endif;

    $hasMore = false;
    foreach ($comments as $comment) :
        if ($comment->comment_approved != "trash" && $comment->comment_approved != "post-trashed") {
            $user_id = $comment->user_id;
            $user_info = get_userdata($user_id);
            if ($i >= $print) {
                $print = $count + 1;
                $hasMore = true;
                ?>
                <div class='row' style='clear:both;'>
                    <div class='span2'></div>
                    <div class='span10'>
                        <span class='show_more_comments'>More</span>
                    </div>
                </div>
                <div class='more_comments row' style='clear:both;'>

            <?php
            }
            if (username_exists($user_info->user_login)) {
                $imgURL = get_the_author_meta('cupp_upload_meta', $user_id);
                $size = 'thumbnail';
                if ($imgURL != "") {

                    ?>
                    <div class="row">

                    <div class="profile-img-small"
                         style="background: url('<?php echo $imgURL ?>'); background-size: 100%;"></div>


                <?php } else { ?>

                    <div class="row">

                    <div class="profile-img-small"
                         style="background: url('<?php echo get_site_url() . "/wp-content/themes/rangoli/images/default.jpg" ?>'); background-size: 100%;">
                    </div>


                <?php } ?>

                <div class='span12'>
                    <p class='comment_author'><?php $profile = get_user_profile($user_id);
                        $name = $profile->user_display_name;
                        if ($name == null) {
                            $name = get_the_author_meta('display_name', $user_id);
                        }
                        echo $name; ?></p>

                    <p class='comment'><?php echo nl2br($comment->comment_content); ?></p>
                </div>
                <div class='span12'>
                    <p class='comment_time'><?php echo date('m.d.y', strtotime($comment->comment_date)); ?></p>
                </div>

                </div>
            <?php
            }

            $i++;
        }
    endforeach;
    if ($hasMore) {
        echo "</div>";
    }

    ?>

    <?php
    $args = array(
        'fields' => apply_filters(
            'comment_form_default_fields',
            array('comment_field' => __(''),
                'reply-title' => __(''),
                'logged-in-as' => __(''),
                'form-allowed-tags' => __(''),
                'comment-notes' => __('')
            )),
        'label_submit' => __('SUBMIT')
    );
    ?>
    <div style='clear:both;'></div>
    <div class="row">
        <div class='span12'>
            <?php
            comment_form($args);
            if (has_category('learn', $post_id)) {
                ?>
                <div class="rate_btn user-color-shade-trans">Rate
                    <?php
                    $rating = get_post_rating($post->ID, 'post');
                    $rating = intval($rating);
                    ?>
                    <div class="do_rating" rel="<?php echo $rating; ?>" post_id="<?php echo $post->ID; ?>">

                    </div>

                </div>
            <?php
            }
            ?>
        </div>
        <div class="span12"></div>
    </div>
    <div style='clear:both;'></div>
    </div>
<?php
}


function get_author_shared_posts($author_id)
{
    $author_data = get_userdata($author_id);
    $name = strtoupper($author_data->display_name);
    $author_profile = get_user_profile($author_id);
    $color = '#' . $author_profile->color_shade;
    ?>
    <p class="align-center author_posts_heading"><?php echo $name ?>'S POSTS</p>
    <div class="flexslider shared_posts">
        <ul class="slides">

            <?php
            $args = array(
                'order' => 'DESC',
                'order' => 'DESC',
                'post_type' => 'post',
                'author_name' => $author_data->user_nicename
            );

            $the_query = new WP_Query($args);

            if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
                $post = get_post();
                $post_author = get_userdata($post->post_author);
                ?>
                <li>
                    <div class="author_post_read_author" style="background:<?php echo $color; ?>">
                        <?php
                        echo get_the_post_thumbnail($post->ID, "mobile_posts");
                        if (!has_post_thumbnail()) {

                            ?>
                            <img src="<?php bloginfo('template_directory') ?>/images/no-background_posts.png"
                                 style="width:100%;float:left;"/>
                        <?php
                        }
                        ?>
                        <div class="overlay-text" onclick="window.location='<?php echo get_permalink(); ?>'">
                            <?php
                            if (has_post_video()) {

                                ?>
                                <div class="play-video"
                                     video="<?php echo get_the_post_video_url($post->ID); ?>">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px"
                                         height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64"
                                         xml:space="preserve">
                                            <defs>
                                            </defs>
                                        <path fill="<?php echo $color; ?>"
                                              opacity="0.9" enable-background="new"
                                              d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                                            </svg>
                                </div>
                            <?php
                            }

                            ?>
                            <div class="align_bottom">
                                <div class="post_category"><?php echo get_post_categories(); ?></div>
                                <div class="post_title"><?php echo $post->post_title; ?></div>
                                <div class="post_author">with
                                    <span><?php echo $post_author->display_name; ?></span></div>
                            </div>
                            <?php
                            $post_author_image_urls = get_user_meta($post->post_author, 'cupp_upload_meta');
                            $post_author_image_url = $post_author_image_urls[0];
                            if ($post_author_image_url == "") {
                                $post_author_image_url = get_site_url() . "/wp-content/themes/rangoli_mobile/images/default.jpg";
                            }
                            ?>
                            <div class="author_picture"
                                 style="background: url('<?php echo $post_author_image_url; ?>') no-repeat; background-position: center center; background-size: cover"></div>
                        </div>
                        <!--
                            <div class="close_post user-color-shade-trans"></div>
                            <div class="share_post user-color-shade-trans"></div>
                        -->
                    </div>
                    <!--

                        <div class="post_content">
                            <?php /*echo apply_filters('the_content', $post->post_content); */ ?>
                            <?php
                    /*                            $post_link = get_permalink($post->ID);
                                                $b_pl = get_bitly_url($post_link);
                                                */ ?>
                            <div class="sharing_box user-color-shade-trans">
                <span class="facebook"><a target="_blank"
                                          href="https://www.facebook.com/sharer/sharer.php?app_id=909386705751971&u=<?php /*echo $b_pl; */ ?>"></a> </span>
                <span class="twitter"><a target="_blank" rel="<?php /*echo $post->ID; */ ?>"
                                         user="<?php /*echo get_current_user_id(); */ ?>"
                                         href="http://twitter.com/intent/tweet?text=<?php /*echo $post->post_title; */ ?>&url=<?php /*echo $b_pl; */ ?>"></a></span>
                <span class="mail"><a target="_blank" rel="<?php /*echo $post->ID; */ ?>"
                                      user="<?php /*echo get_current_user_id(); */ ?>"
                                      href="mailto:?subject= RANGOLI—The YOGASMOGA Community &amp;body=Check out <?php /*echo $post->post_title; */ ?> on Rangoli <?php /*echo $b_pl; */ ?> "></a></span>
                                <span class="unknown"></span>
                                <?php /*wpfp_link(); */ ?>
                            </div>
                            <div class="post_comments">
                                <p class="comments_heading">COMMENTS</p>
                                <?php /*echo get_post_comments($post->ID); */ ?>

                            </div>
                        </div>
-->
                </li>
            <?php
            endwhile; endif;
            ?>
        </ul>
    </div>
<?php
}


function get_author_events_posts($author_id){
    $author = get_userdata($author_id);
    $author_profile = get_user_profile($author_id);
    $color = "#" . $author_profile->color_shade;
    ?>
    <div class="align-center author_posts_heading">
        <?php
        echo strtoupper($author->display_name) . "'S EVENTS";
        ?>
    </div>
    <?php
    $args = array(
        'order' => 'DESC',
        'post_type' => 'event'
//    'author_name' => $curauth->user_nicename
    );
    $i = 0;
    $the_query = new WP_Query($args);
    echo '<div class="author_events row">';
    ?>
    <div class="flexslider">
    <ul class="slides">
    <?php
    if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
        $post = get_post();
        $title = get_the_title();
        $date = $post->post_date;
        $date = date('h:i A', strtotime($date));
        $event_day_ar = get_post_meta($post->ID, "wpcf-dayname");

        $month_ar = get_post_meta($post->ID, "wpcf-month");
        if ($event_day_ar) {
            $month = $month_ar[0];
            $arr = str_split($month, 3);
            $month = $arr[0];
        } else {
            $month = "";
        }

        $location_ar = get_post_meta($post->ID, "wpcf-location");
        if ($location_ar) {
            $location = $location_ar[0];
        } else {
            $location = "";
        }

        $monthday_ar = get_post_meta($post->ID, "wpcf-monthday");
        if ($location_ar) {
            $monthday = $monthday_ar[0];
        } else {
            $monthday = "";
        }

        ?>
        <li style="background: <?php echo $color; ?> ">
            <div class="author_event">
                <p class="event_time"><?php echo $date; ?></p>

                <p class="event_day"><?php echo $month . " " . $monthday; ?></p>

                <p class="event_title"><?php echo $title ?></p>

                <p class="event_location"><?php echo nl2br($location) ?></p>
            </div>
        </li>

        <?php
        $i++;
        if ($i == 5) {
            break;
        }
    endwhile;
    endif;
    wp_reset_query();
    echo '</ul></div></div>';
}


function get_author_liked_posts($author_id)
{
    $author_data = get_userdata($author_id);
    $name = strtoupper($author_data->display_name);
    $author_profile = get_user_profile($author_id);
    $color = '#' . $author_profile->color_shade;
    ?>
    <p class="align-center author_posts_heading"><?php echo $name ?>'S LIKES</p>
    <div class="flexslider liked_posts">
        <ul class="slides">

            <?php
            $args = array(
                'order' => 'DESC',
                'order' => 'DESC',
                'post_type' => 'post',
                'author_name' => $author_data->user_nicename
            );

            $the_query = new WP_Query($args);

            if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
                $post = get_post();
                $post_author = get_userdata($post->post_author);
                ?>
                <li>
                    <div class="author_post_read_author" style="background:<?php echo $color; ?>">
                        <?php
                        echo get_the_post_thumbnail($post->ID, "mobile_posts");
                        if (!has_post_thumbnail($post->ID)) {

                            ?>
                            <img
                                src="<?php bloginfo('template_directory') ?>/images/no-background_posts.png"
                                style="width:100%;float:left;"/>
                        <?php
                        }
                        ?>
                        <div class="overlay-text"
                             onclick="window.location='<?php echo get_permalink(); ?>'">
                            <?php
                            if (has_post_video($post->ID)) {

                                ?>
                                <div class="play-video" video="<?php echo get_the_post_video_url($post->ID); ?>">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px"
                                         height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64"
                                         xml:space="preserve">
                                            <defs>
                                            </defs>
                                        <path fill="<?php echo $color; ?>"
                                              opacity="0.9" enable-background="new"
                                              d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                                            </svg>
                                </div>
                            <?php
                            }

                            ?>
                            <div class="align_bottom">
                                <div class="post_category"><?php echo get_post_categories(); ?></div>
                                <div class="post_title"><?php echo $post->post_title; ?></div>
                                <div class="post_author">with
                                    <span><?php echo $post_author->display_name; ?></span></div>
                            </div>
                            <?php
                            $post_author_image_urls = get_user_meta($post->post_author, 'cupp_upload_meta');
                            $post_author_image_url = $post_author_image_urls[0];
                            if ($post_author_image_url == "") {
                                $post_author_image_url = get_site_url() . "/wp-content/themes/rangoli_mobile/images/default.jpg";
                            }
                            ?>
                            <div class="author_picture"
                                 style="background: url('<?php echo $post_author_image_url; ?>') no-repeat; background-position: center center; background-size: cover"></div>
                        </div>
                    </div>
                </li>
            <?php
            endwhile; endif;
            ?>
        </ul>
    </div>
<?php
}


function get_user_recent_activities($user_id)
{
    $author_data = get_userdata($user_id);
    $name = strtoupper($author_data->display_name);
    $author_profile = get_user_profile($user_id);
    $color = '#' . $author_profile->color_shade;
    ?>
    <div class="flexslider liked_posts">
        <p class="align-center author_posts_heading"><?php echo $name ?>'S POSTS</p>
        <ul class="slides">

            <?php
            $args = array(
                'order' => 'DESC',
                'order' => 'DESC',
                'post_type' => 'post',
                'author_name' => $author_data->user_nicename
            );

            $the_query = new WP_Query($args);

            if ($the_query->have_posts()):while ($the_query->have_posts()): $the_query->the_post();
                $post = get_post();
                ?>
                <li style="background: <?php echo $color ?>">
                    <div class="author_posts_read" style="background:<?php echo $color; ?>">
                        <?php
                        echo get_the_post_thumbnail($post->ID, "mobile_posts");
                        if (!has_post_thumbnail()) {

                            ?>
                            <img
                                src="<?php bloginfo('template_directory') ?>/images/no-background_posts.png"
                                style="width:100%;float:left;"/>
                        <?php
                        }
                        ?>
                        <div class="overlay-text">
                            <?php echo $post->ID; ?>
                        </div>

                    </div>
                </li>
            <?php
            endwhile; endif;
            ?>
        </ul>
    </div>
<?php
}


function filter()
{


    ?>
    <div class="filter-wrapper">
        <div class="filter-container">
            <ul>
                <li><p class="user-color-shade"><span class="down-arrow-grey-white">Author</span><i><img
                                src="<?php echo get_site_url() . '/wp-content/themes/rangoli_mobile/images/arrow.png' ?>"/></i>
                    </p>
                    <ul>
                        <?php
                        if (is_page("read")) {
                            $cat = "read";
                        }
                        if (is_page("look")) {
                            $cat = "look";
                        }
                        if (is_page("learn")) {
                            $cat = "learn";
                        }
                        $authors = get_users("role=smogi");
                        $stores = get_users("role=store");
                        $contributors = get_users("role=contributor");
                        $authors = array_merge($authors, $stores, $contributors);

                        foreach ($authors as $author) {

                            if ($cat) {
                                $catID = get_cat_ID($cat);
                                $userposts = get_posts("cat=$catID&showposts=-1&author=" . $author->ID . "&numberposts=-1");
                                $count = count($userposts);

                                if ($count > 0) {
                                    $author_name = str_replace(" ", "%20", $author->display_name);
                                    echo "<li><a href='?author=" . $author_name . "'>" . $author->display_name . "<span class='radio'></span></a></li>";
                                }
                            }

                        }
                        ?>
                    </ul>
                </li>
                <li><p class="user-color-shade"><span class="down-arrow-grey-white">Topic</span><i><img
                                src="<?php echo get_site_url() . '/wp-content/themes/rangoli_mobile/images/arrow.png' ?>"/></i>
                    </p>
                    <ul>
                        <?php
                        $categories = get_categories("exclude=read,look,learn,all");
                        $catID = get_cat_ID($cat);
                        $userposts = null;
                        $userposts = get_posts(array("category" => $catID, "numberposts" => -1));
                        $count = count($userposts);
                        if ($count > 0) {
                            $cats = array();
                            foreach ($userposts as $userpost) {
                                foreach ($categories as $category) {
                                    if ($category) {
                                        if ($category->slug != "all" && $category->slug != "read" && $category->slug != "look" && $category->slug != "learn") {
                                            if ($userpost->post_status == "publish") {
                                                if (has_category($category, $userpost)) {
                                                    $cats[] = $category->cat_name;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $cats = array_unique($cats);
                            sort($cats);
                            foreach ($cats as $value)
                                echo "<li><a href='?topic=" . $value . "'>" . $value . " <span class='radio'></span></a></li>";
                        }



                        ?>
                    </ul>
                </li><?php

                if ($cat != "learn") {

                    ?>
                    <li><p class="user-color-shade"><span class="down-arrow-grey-white">Length</span><i><img
                                    src="<?php echo get_site_url() . '/wp-content/themes/rangoli_mobile/images/arrow.png' ?>"/></i>
                        </p>
                        <ul>

                            <li><a href='?length=short'>SHORT<span class='radio'></span></a></li>
                            <li><a href='?length=medium'>MEDIUM<span class='radio'></span></a></li>
                            <li><a href='?length=long'>LONG<span class='radio'></span></a></li>

                        </ul>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>

<?php
}


function get_the_look($post)
{
    $left_image = get_post_meta($post->ID, "wpcf-left-image");
    $right_image = get_post_meta($post->ID, "wpcf-right-image");
    $left_product_name = get_post_meta($post->ID, "wpcf-left-product-name");
    $right_product_name = get_post_meta($post->ID, "wpcf-right-product-name");
    $left_product_url = get_post_meta($post->ID, "wpcf-left-product-url");
    $right_image_url = get_post_meta($post->ID, "wpcf-right-product-url");
    $author_post = get_userdata($post->post_author);
    $name = $author_post->display_name;
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
            <div class="get_the_look">
                <p><?php echo $name; ?>'s wearing:</p>

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
        </div>
    <?php
    }

}


function get_subscribers_count($author_id)
{
    global $wpdb;
    $query = "SELECT count(*) FROM rangoli_wpsa_subscribe_author where author_id=$author_id and status='active'";
    $rows = $wpdb->get_results($query);

    $count = get_object_vars($rows[0]);
    return $count['count(*)'];
}


function get_user_feeds($user_id)
{
    $user_info = get_userdata($user_id);
    global $wpdb;
    $results = $wpdb->get_results("SELECT post_id FROM rangoli_shares WHERE user_id=" . $user_id);
    $post_ids = array();
    if ($results) {
        foreach ($results as $data) {
            $poST = get_object_vars($data);
            $post_ids[] = $poST['post_id'];
        }
    }

    $user_favs = $post_ids;
    $profile = get_user_profile($user_id);
    $name = $profile->user_display_name;
    if ($name == null)
        $name = $user_info->display_name;
    $name = strtoupper($name);

    if ($user_favs) {

        foreach ($user_favs as $user_fav) {
            $post = get_post($user_fav);
            if ($post->post_type == "post") {

                echo '<p class="align-center author_posts_heading">' . $name . '\'S SHARES</p>';
                break;

            }
        }
    }
    if ($user_favs) {
        ?>

        <div class="flexslider shared_posts">
            <ul class="slides">
                <?php
                foreach ($user_favs as $user_fav) {
                    $post = get_post($user_fav);

                    $wp_author = get_user_profile($post->post_author);
                    if ($post->post_type == "post" && !empty($user_fav)) {
                        ?>
                        <li>
                            <div class="single_post">
                                <div class="author_post_read_author"
                                     style="background: #<?php echo $wp_author->color_shade; ?>">

                                    <?php echo get_the_post_thumbnail($post->ID, 'mobile_posts');
                                    if (!has_post_thumbnail($post->ID, 'thumb')) {
                                        ?>
                                        <img
                                            src="<?php bloginfo('template_directory') ?>/images/no-background_posts.png"
                                            style="width:100%;float:left;"/>
                                    <?php
                                    }
                                    ?>
                                    <div class="overlay-text"
                                         onclick="window.location='<?php echo get_the_permalink(); ?> '">
                                        <?php
                                        $author = get_user_profile($post->post_author);
                                        $author_color = $author->color_shade;
                                        if (has_post_video($post->ID)) {
                                            ?>
                                            <div class="play-video"
                                                 video="<?php echo get_the_post_video_url($post->ID); ?>">
                                                <svg version="1.1" id="Layer_1"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                     width="64px" height="64px" viewBox="0 0 64 64"
                                                     enable-background="new 0 0 64 64" xml:space="preserve">
                                                                <defs>
                                                                </defs>
                                                    <path fill="<?php echo "#" . $author_color; ?>"
                                                          opacity="0.9" enable-background="new"
                                                          d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                                                                </svg>
                                            </div>
                                        <?php
                                        }
                                        $categories = get_post_categories($post->ID);
                                        $post = get_post();
                                        ?>
                                        <div class="align_bottom">
                                            <?php
                                            echo '<p class="post_category">' . $categories . "</p>";
                                            echo "<p class='post_title'>" . get_the_title() . "</p>";
                                            echo "<p class='post_author'>by <span>" . get_the_author_meta('display_name', $post->post_author) . "</span></p>";
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php
                    }
                }
                ?>


            </ul>
        </div>
    <?php
    }


}


function get_user_liked_posts($author_id)
{
    $author_data = get_userdata($author_id);
    $author_profile = get_user_profile($author_id);

    $name = $author_profile->user_display_name;
    if ($name == null)
        $name = strtoupper($author_data->display_name);


    $color = '#' . $author_profile->color_shade;
    ?>
    <p class="align-center author_posts_heading"><?php echo $name ?>'S LIKES</p>
    <div class="flexslider liked_posts">
        <ul class="slides">
        <?php
    $user_favs = wpfp_get_users_favorites($author_data->user_login);

    if (is_array($user_favs) && count($user_favs) > 0) {
        foreach ($user_favs as $post_id) {

            if (isset($post_id) && !empty($post_id)) {

                $post = get_post($post_id);
                $post_author = get_userdata($post->post_author);
                ?>
                <li>
                    <div class="author_post_read_author" style="background:<?php echo $color; ?>">
                        <?php
                        echo get_the_post_thumbnail($post->ID, "mobile_posts");
                        if (!has_post_thumbnail($post_id)) {

                            ?>
                            <img
                                src="<?php bloginfo('template_directory') ?>/images/no-background_posts.png"
                                style="width:100%;float:left;"/>
                        <?php
                        }
                        ?>
                        <div class="overlay-text"
                             onclick="window.location='<?php echo get_permalink(); ?>'">
                            <?php
                            if (has_post_video()) {

                                ?>
                                <div class="play-video"
                                     video="<?php echo get_the_post_video_url($post->ID); ?>">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px"
                                         height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64"
                                         xml:space="preserve">
                                            <defs>
                                            </defs>
                                        <path fill="<?php echo $color; ?>"
                                              opacity="0.9" enable-background="new"
                                              d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                                            </svg>
                                </div>
                            <?php
                            }

                            ?>
                            <div class="align_bottom">
                                <div class="post_category"><?php echo get_post_categories(); ?></div>
                                <div class="post_title"><?php echo $post->post_title; ?></div>
                                <div class="post_author">with
                                    <span><?php echo $post_author->display_name; ?></span></div>
                            </div>
                            <?php
                            $post_author_image_urls = get_user_meta($post->post_author, 'cupp_upload_meta');
                            $post_author_image_url = $post_author_image_urls[0];
                            if ($post_author_image_url == "") {
                                $post_author_image_url = get_site_url() . "/wp-content/themes/rangoli_mobile/images/default.jpg";
                            }
                            ?>
                            <div class="author_picture"
                                 style="background: url('<?php echo $post_author_image_url; ?>') no-repeat; background-position: center center; background-size: cover"></div>
                        </div>
                    </div>
                </li>
            <?php
            }
        }
    }

    ?>
        </ul>
    </div>
<?php
}

function user_id_exists($user)
{

    global $wpdb;

    $arr = $wpdb->get_results("SELECT * FROM rangoli_users WHERE ID = '$user'");
    $count = count($arr);
    if ($count == 1) {
        return true;
    } else {
        return false;
    }

}

