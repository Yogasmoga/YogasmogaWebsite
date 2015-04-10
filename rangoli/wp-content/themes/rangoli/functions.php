<?php



add_theme_support('post-thumbnails');
add_image_size('banner', '1024', '600', true);
add_image_size('thumb', '700', '525', true);

function themeblvd_disable_admin_bar()
{
    if (!current_user_can('edit_posts'))
        add_filter('show_admin_bar', '__return_false');
}

add_action('after_setup_theme', 'themeblvd_disable_admin_bar');

/**
 * Redirect back to homepage and not allow access to
 * WP admin for Subscribers.
 */
function themeblvd_redirect_admin()
{
    if (!current_user_can('edit_posts')) {
        wp_redirect(site_url());
        exit;
    }
}

add_action('admin_init', 'themeblvd_redirect_admin');


require get_template_directory() . '/inc/template-tags.php';


function add_categories_for_attachments()
{
    register_taxonomy_for_object_type('category', 'attachment');
}

add_action('init', 'add_categories_for_attachments');


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
            'menu3' => __('Menu3')
        )
    );
}

add_action('init', 'register_my_menus');


function hex2rgb($colour)
{
    if ($colour[0] == '#') {
        $colour = substr($colour, 1);
    }
    if (strlen($colour) == 6) {
        list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
    } elseif (strlen($colour) == 3) {
        list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
    } else {
        return false;
    }
    $r = hexdec($r);
    $g = hexdec($g);
    $b = hexdec($b);
    return array('red' => $r, 'green' => $g, 'blue' => $b);
}


function category($post_id = false)
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


// pagination


if (!function_exists('rangoli_paging_nav')) {
    function rangoli_paging_nav($query = null, $page = 0)
    {
        global $wp_query, $wp_rewrite;
        $pagenum_link = html_entity_decode(get_pagenum_link());
        $query_args = array();
        $url_parts = explode('?', $pagenum_link);

        if (isset($url_parts[1])) {
            wp_parse_str($url_parts[1], $query_args);
        }

        $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
        $pagenum_link = trailingslashit($pagenum_link) . '%_%';

        $format = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';

        // Set up paginated links.
        $links = paginate_links(array(
            'base' => $pagenum_link,
            'format' => $format,
            'total' => $query->max_num_pages,
            'current' => max( 1, get_query_var('paged') ),
            'mid_size' => 1,
            'add_args' => array_map('urlencode', $query_args),
            'prev_text' => __('&larr; Previous', 'twentyfourteen'),
            'next_text' => __('Next &rarr;', 'twentyfourteen'),
        ));
        if ($links) :
            ?>
            <nav class="navigation paging-navigation row" role="navigation">
                <div class="pagination loop-pagination">
                    <?php echo $links; ?>
                </div>
                <!-- .pagination -->
            </nav><!-- .navigation -->
        <?php
        endif;
    }
}


if (!function_exists('rangoli_post_nav')) :
    function rangoli_post_nav()
    {
        $previous = (is_attachment()) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
        $next = get_adjacent_post(false, '', false);

        if (!$next && !$previous) {
            return;
        }

        ?>
        <nav class="navigation post-navigation" role="navigation">
            <h1 class="screen-reader-text"><?php _e('Post navigation', 'rangoli'); ?></h1>

            <div class="nav-links">
                <?php
                if (is_attachment()) :
                    previous_post_link('%link', __('<span class="meta-nav">Published In</span>%title', 'rangoli'));
                else :
                    previous_post_link('%link', __('<span class="meta-nav">Previous Post</span>%title', 'rangoli'));
                    next_post_link('%link', __('<span class="meta-nav">Next Post</span>%title', 'rangoli'));
                endif;
                ?>
            </div>
            <!-- .nav-links -->
        </nav><!-- .navigation -->
    <?php
    }
endif;


function cat_filter()
{
    $tax = 'category';
    $terms = get_terms($tax, 'hide_empty=0&exclude=0');
    $count = count($terms);
    if ($count > 0): ?>
        <div class="post-tags">
            <span class="tag-title">Filter By</span>

            <div class="tags">
                <?php
                $ajax_layout = 'list';
                if (is_author()) {
                    $ajax_layout = 'grid';
                };
                foreach ($terms as $term) {
                    $filter_link = add_query_arg(array('category_name' => $term->slug, 'layout' => $ajax_layout));
                    echo '<a href="' . $filter_link . '" class="tax-filter" title="' . $term->slug . '">' . $term->name . '</a> ';
                } ?>
            </div>
        </div>
    <?php endif;
}


function tags_filter()
{
    $tax = 'post_tag';
    $terms = get_terms($tax);
    $count = count($terms);

    if ($count > 0): ?>
        <div class="post-tags">
            <span class="tag-title">Filter By</span>

            <div class="tags">
                <?php
                foreach ($terms as $term) {
                    $term_link = get_term_link($term, $tax);
                    echo '<a href="' . $term_link . '" class="like-filter" title="' . $term->slug . '">' . $term->name . '</a> ';
                } ?>
            </div>
        </div>
    <?php endif;
}


function filter($cat="all")
{
    ?>
    <div class="filter-wrapper">
        <div class="filter" id="filter">
            <span class="down-arrow-grey">FILTER</span>
        </div>
        <div class="filter-container">
            <ul>
                <li><p class="user-color-shade"><span class="down-arrow-grey-white">Author</span></p>
                    <ul>
                        <?php
                        if(is_page("read")){
                            $cat = "read";
                        }
                        if(is_page("look")){
                            $cat = "look";
                        }
                        if(is_page("learn")){
                            $cat = "learn";
                        }
                        $authors = get_users("role=smogi");
                        $stores = get_users("role=store");
                        $contributors = get_users("role=contributor");
                        $authors = array_merge($authors, $stores,$contributors);

                        foreach ($authors as $author) {

                            if($cat){
                                $catID = get_cat_ID($cat);
                                $userposts = get_posts("cat=$catID&showposts=-1&author=".$author->ID);
                                $count=count($userposts);
                                if ($count>0) {
                                    $author_name = str_replace(" ", "%20", $author->display_name);
                                    echo "<li><a href='?author=" . $author_name . "'>" . $author->display_name . "<span class='radio'></span></a></li>";
                                }
                            }

                        }
                        ?>
                    </ul>
                </li>
                <li><p class="user-color-shade"><span class="down-arrow-grey-white">Topic</span></p>
                    <ul>
                        <?php
                        $categories = get_categories("exclude=read,look,learn,all");


                                        $catID = get_cat_ID($cat);
                                        $userposts = null;
                                        $userposts = get_posts("cat=$catID");
                                        $count=count($userposts);
                                        if($count>0) {
                                            foreach ($userposts as $userpost) {

                                                    foreach ($categories as $category) {
                                                        if ($category) {
                                                            if ($category->slug != "all" && $category->slug != "read" && $category->slug != "look" && $category->slug != "learn") {
                                                               
                                                                if (has_category($category->slug,$userpost)) {
                                                                    echo "<li><a href='?topic=" . $category->slug . "'>" . $category->slug . " <span class='radio'></span></a></li>";
                                                                }
                                                            }
                                                        }
                                                    }


                                            }
                                        }



                        ?>
                    </ul>
                </li><?php

                if ($cat != "learn") {

                    ?>
                    <li><p class="user-color-shade"><span class="down-arrow-grey-white">Length</span></p>
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

function get_cart_count(){
    $root = get_site_url();
    $root = str_replace("/rangoli", "/", $root);
    $count=file_get_contents($root ."ys/session/getcartcount");
    return $count;
}
function get_user_smogi_bucks($id)
{
    $user_info = get_userdata($id);
    $roles =  $user_info->roles;

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

                foreach ($points as $point) {

                    $smogi_bucks = 0;
                    foreach ($points as $point) {

                        $point_data = get_object_vars($point);

                        $smogi_bucks += intval($point_data["points_current"]);
                        $smogi_bucks += intval($point_data["points_spent"]);
                    }
                }
            } else

                $smogi_bucks = "0";

            if ($smogi_bucks) {
            if(is_array($roles) && count($roles)>0) {
                $role = $roles[0];
                if($role != "store"){
                    reset($magento_user);
                    return $smogi_bucks;
                }
                else
                    return 0;
            }
            else
                return 0;
        }else return 0;

        }else return 0;
    }
    else return 0;
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


function get_bitly_url($link, $format='txt'){
        $login = "yogasmogarangoli";
        $appkey = "R_0f1d1bc2a82f472eaa33ef817e8d5548";
        $bitly_api = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($link).'&format='.$format;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$bitly_api);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
}


function is_journey_first_time(){
    $visited = 0;
    $currentUser = get_current_user_id();
    $userInformation = get_user_profile($currentUser);
    if($userInformation){
        $visited = $userInformation->journey_visited;
    }
    return $visited;
}

function make_journey_visited(){
    global $wpdb;
    $user_id = get_current_user_id();
    $result = $wpdb->query("update rangoli_user_profiles set journey_visited=1 where user_id=$user_id");

    if($result){
        return true;
    }
    else{
        return false;
    }
}