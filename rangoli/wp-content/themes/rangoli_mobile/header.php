<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (is_ssl()) {
    $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("location: " . $url);
}
$logged_in = is_user_logged_in();

?>
    <!DOCTYPE html>
<html>
    <head>
        <?php
        $home = get_site_url();
        $root = str_replace("/rangoli", "/", $home);
        $media = $home . "/wp-content/themes/rangoli_mobile/images/";
        include_once('icons_svg.php');
        ?>
        <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1.0, user-scalable=no"/>

        <?php
        if (is_home()) {
            ?>
            <title>Rangoli: The YOGASMOGA Community</title>
            <meta property="og:title" content="Rangoli: The YOGASMOGA Community"/>
            <meta property="og:description"
                  content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community."/>
            <meta property="description"
                  content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community."/>
        <?php
        }
        if (is_page("read")) {
            ?>
            <title>Read | Rangoli: The YOGASMOGA Community</title>
            <meta property="og:title" content="Look | Rangoli: The YOGASMOGA Community"/>
            <meta property="og:description"
                  content="Our READ section features a curated selection of health & wellness related articles, op-eds, editorial, recipes, biographies, interviews and more. Your brain will love you for it. Rangoli: The YOGASMOGA Community."/>
            <meta property="description"
                  content="Our READ section features a curated selection of health & wellness related articles, op-eds, editorial, recipes, biographies, interviews and more. Your brain will love you for it. Rangoli: The YOGASMOGA Community."/>
        <?php
        }
        if (is_page("look")) {
            ?>
            <title>Look | Rangoli: The YOGASMOGA Community</title>
            <meta property="og:title" content="Look | Rangoli: The YOGASMOGA Community"/>
            <meta property="og:description"
                  content="Discover our Look section and browse through photography, slideshows, and more awe-inspiring imagery that revolve around health & wellness. Pictures are worth 1000 words and our Look section will give you plenty to talk about. Rangoli: The YOGASMOGA Community."/>
            <meta property="description"
                  content="Discover our Look section and browse through photography, slideshows, and more awe-inspiring imagery that revolve around health & wellness. Pictures are worth 1000 words and our Look section will give you plenty to talk about. Rangoli: The YOGASMOGA Community."/>
        <?php
        }
        if (is_page("learn")) {
            ?>
            <title>Learn | Rangoli: The YOGASMOGA Community</title>
            <meta property="og:title" content="Learn | Rangoli: The YOGASMOGA Community"/>
            <meta property="og:description"
                  content="Learn how to hit that yoga pose with video tutorials from our beloved SMOGIs. Whether you’re a beginner or a seasoned yogi, our SMOGIs will guide you step-by-step with each pose, adjustment, inhale and exhale. Rangoli: The YOGASMOGA Community."/>
            <meta property="description"
                  content="Learn how to hit that yoga pose with video tutorials from our beloved SMOGIs. Whether you’re a beginner or a seasoned yogi, our SMOGIs will guide you step-by-step with each pose, adjustment, inhale and exhale. Rangoli: The YOGASMOGA Community."/>
        <?php
        }
        if (is_404()) {
            ?>
            <title>404 | Rangoli: The YOGASMOGA Community</title>
            <meta property="og:title" content="404 | Rangoli: The YOGASMOGA Community"/>
            <meta property="og:description"
                  content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community."/>
            <meta property="description"
                  content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community."/>
        <?php
        }
        if (is_author()) {
            $author_obj = $wp_query->get_queried_object();
            $author_name = strtoupper($author_obj->display_name);
            ?>
            <title><?php echo $author_name ?> | Rangoli: The YOGASMOGA Community</title>
            <?php
            if ($author_name == "YOGASMOGA BRENTWOOD") {
                ?>
                <meta property="og:title" content="YOGASMOGA Brentwood | Rangoli: The YOGASMOGA Community"/>
                <meta property="og:description"
                      content="Centrally located on the corner of San Vicente Boulevard and Montana Avenue in Brentwood, Los Angeles. We chose this space for its accessibility and neighborhood vibe. Our bright and sunny Brentwood store is wrapped in floor-to-ceiling windows that fill the space with natural light and warm, welcoming energy."/>
                <meta property="description"
                      content="Centrally located on the corner of San Vicente Boulevard and Montana Avenue in Brentwood, Los Angeles. We chose this space for its accessibility and neighborhood vibe. Our bright and sunny Brentwood store is wrapped in floor-to-ceiling windows that fill the space with natural light and warm, welcoming energy."/>
            <?php
            }
            if ($author_name == "YOGASMOGA TOWNHOUSE") {
                ?>
                <meta property="og:title" content="YOGASMOGA Townhouse | Rangoli: The YOGASMOGA Community"/>
                <meta property="og:description"
                      content="We chose this two-story townhouse on Greenwich Avenue as our first store for its strong feel of community. The exposed brick walls create a cozy atmosphere and neutral palate for our bright collections. We are currently renovating the upstairs space for yoga classes and other wellness events."/>
                <meta property="description"
                      content="We chose this two-story townhouse on Greenwich Avenue as our first store for its strong feel of community. The exposed brick walls create a cozy atmosphere and neutral palate for our bright collections. We are currently renovating the upstairs space for yoga classes and other wellness events."/>
            <?php
            }
            if ($author_name == "YOGASMOGA HQ") {
                ?>
                <meta property="og:title" content="YOGASMOGA HQ | Rangoli: The YOGASMOGA Community"/>
                <meta property="og:description"
                      content="We are YOGASMOGA. Designed in NYC. Made in USA. We make things for life, one breath at a time."/>
                <meta property="description"
                      content="We are YOGASMOGA. Designed in NYC. Made in USA. We make things for life, one breath at a time."/>
            <?php
            }
        }
        if (is_page("about")) {
            ?><title>About Rangoli | Rangoli: The YOGASMOGA Community</title>
            <meta property="og:title" content="About Rangoli | Rangoli: The YOGASMOGA Community"/>
            <meta property="og:description"
                  content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind."/>
            <meta property="description"
                  content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind."/>
        <?php
        } else {
            $post = get_post();
            $post_content = "";
            $description = "";
            if ($post) {
                $post_content = strip_tags($post->post_content);
                $description = substr($post_content, 0, 155);
            }
            ?>
            <title><?php echo get_the_title(); ?> | Rangoli: The YOGASMOGA Community</title>
            <meta property="og:title" content="<?php echo get_the_title(); ?> | Rangoli: The YOGASMOGA Community"/>
            <meta property="og:description" content="<?php echo $description; ?>"/>
            <meta property="description" content="<?php echo $description; ?>"/>
            <meta property="og:image"
                  content="<?php $banner_img_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
                  echo $banner_img_url[0]; ?>"/>
        <?php
        }
        ?>

        <link rel="stylesheet" href="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/css/flexslider.css"/>
        <link rel="stylesheet" href="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/css/croppic.css"/>
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url') ?>"/>
        <link rel="stylesheet" href="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/css/custom.css"/>
        <?php
        if (is_home()) {
            ?>

            <link rel="stylesheet" href="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/css/homepage.css"/>
        <?php
        }
        ?>
        <script src="<?php bloginfo('template_directory') ?>/js/jquery.js"></script>
        <script src="<?php bloginfo('template_directory') ?>/js/jquery.flexslider.js"></script>
        <script src="<?php bloginfo('template_directory') ?>/js/touchSwipe.js"></script>
        <script src="<?php bloginfo('template_directory') ?>/js/custom.js"></script>
        <script src="<?php bloginfo('template_directory') ?>/js/game.js"></script>
        <script src="<?php bloginfo('template_directory') ?>/js/jquery.raty.js"></script>
        <script src="<?php bloginfo('template_directory') ?>/js/zeroClipboard.js"></script>
        <script src="<?php bloginfo('template_directory') ?>/js/croppic.min.js"></script>


        <script type="text/javascript">

            <?php
            echo "var homeUrl = '".$root."';
            ";
            echo "var logged_in_id =0;";
            echo "var root = '".$root."';
            ";
            if(is_user_logged_in()){
            $userId = get_current_user_id();
            echo "var userId = $userId ;
            ";
            echo "var logged_in_id = ".get_current_user_id().";";
            echo "var user_color_shade='#555555';";
            }
            ?>
            (function (d) {
                var config = {
                        kitId: 'hhs7njj',
                        scriptTimeout: 3000
                    },
                    h = d.documentElement, t = setTimeout(function () {
                        h.className = h.className.replace(/\bwf-loading\b/g, "") + " wf-inactive";
                    }, config.scriptTimeout), tk = d.createElement("script"), f = false, s = d.getElementsByTagName("script")[0], a;
                h.className += " wf-loading";
                tk.src = '//use.typekit.net/' + config.kitId + '.js';
                tk.async = true;
                tk.onload = tk.onreadystatechange = function () {
                    a = this.readyState;
                    if (f || a && a != "complete" && a != "loaded")return;
                    f = true;
                    clearTimeout(t);
                    try {
                        Typekit.load(config)
                    } catch (e) {
                    }
                };
                s.parentNode.insertBefore(tk, s)
            })(document);
        </script>

    </head>
<body>
    <span style="display: none;" class="logged_in">
    <?php if (is_user_logged_in()) {
        $user = get_current_user_id();
        $user_data = get_userdata($user);
        $profile = get_user_profile($user);
        $name = $profile->user_display_name;
        if ($name == null) {
            $name = $user_data->display_name;
        }
        echo $name;
    } ?></span>
    <span style="display: none;" id="current_user_img_url">
    <?php if (is_user_logged_in()) {
        $user = get_current_user_id();
        $user_data = get_user_meta($user, "cupp_upload_meta");
        echo $user_data[0];
    } ?></span>

    <span style="display: none;" class="current_date">
    <?php
    $current_date = date('m.d.y');
    echo $current_date;
    ?></span>
    <div class="header">
        <div class="header-container">
            <div class="menu_btn">
                <svg width="44px" height="44px">
                    <use xlink:href="#ys_menu_icon"></use>
                </svg>
            </div>

            <a href="/">
                <svg height="44px" width="154px">
                    <use xlink:href="#yogasmoga_logo_white"></use>
                </svg>
            </a>

            <div class="shopping_cart">
                <svg width="44px" height="44px">
                    <use xlink:href="#shopping_cart"></use>
                </svg>
        <span class="cart">
        </span>
            </div>
        </div>
    </div>
    <!-- RANGOLI YS MENU -->
    <div class="menu-box <?php //if(!$logged_in) {echo 'not-logged-in-menu';} ?>">
        <span class="close_menu">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 width="44px" height="44px" viewBox="0 0 44 44" enable-background="new 0 0 44 44" xml:space="preserve">
<g>
    <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="12.517" y1="12.517" x2="31.482" y2="31.483"/>
    <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="31.482" y1="12.517" x2="12.517" y2="31.483"/>
</g>
</svg>

        </span>

        <div class="menu_list">
            <!--            <div class="side_left"></div>-->
            <div class="menu-container">
                <?php if (!$logged_in) { ?>
                    <ul class="sign-signup">
                        <li>
                            <a href="javascript:void(0)" style="color:#555;"><span>
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     width="44px" height="44px" viewBox="164.167 0 44 44"
                                     enable-background="new 164.167 0 44 44" xml:space="preserve">
<g>
    <g>
        <path fill="none" stroke="#666666" stroke-miterlimit="10" d="M189.256,16.171c0-2.083-1.689-3.771-3.771-3.771
			c-2.084,0-3.771,1.689-3.771,3.771c0,1.615,1.02,2.981,2.445,3.52L182.627,30h5.715l-1.533-10.309
			C188.237,19.153,189.256,17.786,189.256,16.171z"/>
    </g>
</g>
</svg>
                            </span><span class="open_signin">Sign in</span> / <span
                                    class="open_signup">Sign up</span></a>
                        </li>
                    </ul>
                <?php } else { ?>
                    <div class="user_menu">
                        <?php
                        $user_id = get_current_user_id();
                        $profile_pic = $media . "default.jpg";
                        $profile_pics = get_user_meta($user_id, "cupp_upload_meta");
                        if (is_array($profile_pics) and count($profile_pics) > 0) {
                            $profile_pic = $profile_pics[0];
                        }
                        $user = get_userdata($user_id);
                        $userObj = get_user_profile($user_id);
                        $name = $userObj->user_display_name;
                        if ($name == null) {
                            $name = $user->first_name;
                        }
                        ?>
                        <div class="main_btn">
                            <span class="profile_picture"><img src="<?php echo $profile_pic; ?>"/></span>
                            <a href="<?php echo $home; ?>/profile?user_id=<?php echo $user_id; ?>"> Hi
                                <?php echo $name; ?>
                            </a>
                        <span class="menu_arrow">
                            <svg width="44px" height="44px">
                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="272.374" y1="109.657"
                                      x2="288.374"
                                      y2="109.657"/>
                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="14.374"
                                      y1="21.39" x2="30.374" y2="21.39"/>
                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="22.374"
                                      y1="13.39" x2="22.374" y2="29.39"/>
                            </svg>
                        </span>
                        </div>
                        <div class="user_menu_links">
                            <ul>
                                <li class="my_account">
                                    <span></span><a href="/customer/account/">My Account</a>
                                </li>
                                <li class="my_likes">
                                    <span></span><a href="/rangoli/liked">My Likes</a>
                                </li>
                                <li class="my_journey">
                                    <span></span><a href="/rangoli/journey">Edit Journey</a>
                                </li>
                                <li class="signout">
                                    <span></span><a href="javascript:wplogout();">Sign Out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>


                <div class="line"></div>
                <div class="yogasmoga-menu level1">
                    <div class="main_btn">
                        <a href="/">
                            <svg width="207.667px" height="44px">
                                <use xlink:href="#yogasmoga_logo"></use>
                            </svg>

                        </a>
                        <span class="menu_arrow">
                            <svg width="44px" height="44px">
                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="272.374" y1="109.657"
                                      x2="288.374"
                                      y2="109.657"/>
                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="14.374"
                                      y1="21.39" x2="30.374" y2="21.39"/>
                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="22.374"
                                      y1="13.39" x2="22.374" y2="29.39"/>
                            </svg>
                        </span>
                    </div>
                    <div class="yogasmoga_menu_links level2">
                        <ul>
                            <li class="ys_main_category">
                                <p><a href="/women">WOMEN</a>
                                <span class="menu_arrow">

                            <svg width="44px" height="44px">
                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="272.374" y1="109.657"
                                      x2="288.374"
                                      y2="109.657"/>
                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="14.374"
                                      y1="21.39" x2="30.374" y2="21.39"/>
                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="22.374"
                                      y1="13.39" x2="22.374" y2="29.39"/>
                            </svg>
                                </span>
                                </p>

                                <ul class="ys_sub_menu level3">
                                    <li><a href="/women/tops">TOPS</a>
                                        <span class="menu_arrow">
                                            <svg width="44px" height="44px">
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="272.374" y1="109.657"
                                                      x2="288.374"
                                                      y2="109.657"/>
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="14.374"
                                                      y1="21.39" x2="30.374" y2="21.39"/>
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="22.374"
                                                      y1="13.39" x2="22.374" y2="29.39"/>
                                            </svg>
                                        </span>
                                        <ul>
                                            <li><a href="/women/tops/bras">Bras</a></li>
                                            <li><a href="/women/tops/tanks">Tanks</a></li>
                                            <li><a href="/women/tops/tees">Tees</a></li>
                                            <li><a href="/women/tops/sweaters">Sweaters</a></li>
                                            <li><a href="/women/tops/jackets">Jackets</a></li>
                                            <li><a href="/women/tops/rangoli">Rangoli</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="/women/bottoms">BOTTOMS</a>
                                        <span class="menu_arrow">
                                            <svg width="44px" height="44px">
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="272.374" y1="109.657"
                                                      x2="288.374"
                                                      y2="109.657"/>
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="14.374"
                                                      y1="21.39" x2="30.374" y2="21.39"/>
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="22.374"
                                                      y1="13.39" x2="22.374" y2="29.39"/>
                                            </svg>
                                        </span>
                                        <ul>
                                            <li><a href="/women/bottoms/shorts">Shorts</a></li>
                                            <li><a href="/women/bottoms/crops">Crops</a></li>
                                            <li><a href="/women/bottoms/leggings">Leggings</a></li>
                                            <li><a href="/women/bottoms/pants">Pants</a></li>
                                            <li><a href="/women/bottoms/rangoli">Rangoli</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="/women/accessories">ACCESSORIES</a>
                                        <span class="menu_arrow">
                                            <svg width="44px" height="44px">
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="272.374" y1="109.657"
                                                      x2="288.374"
                                                      y2="109.657"/>
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="14.374"
                                                      y1="21.39" x2="30.374" y2="21.39"/>
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="22.374"
                                                      y1="13.39" x2="22.374" y2="29.39"/>
                                            </svg>
                                        </span>
                                        <ul>
                                            <li><a href="/women/accessories/head-bands">Head Bands</a></li>
                                            <li><a href="/women/accessories/yoga-mats">Yoga Mats</a></li>
                                            <li><a href="/women/accessories/yoga-towels">Yoga Towels</a></li>
                                            <li><a href="/women/accessories/yoga-flops">Yoga Flops</a></li>
                                            <li><a href="/women/accessories/namaskar-bracelets">NAMASKÀR Bracelets</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="/women/whats-new">What's New</a></li>
                                    <li><a href="/women/one-too-many">ONE 2 MANY</a></li>
                                    <li><a href="/women/additional-sizes">ADDITIONAL SIZES</a></li>
                                    <li><a href="/women/vivacity-collection">VIVACITY COLLECTION</a></li>
                                    <li><a href="/women/rangoli-collection">RANGOLI COLLECTION</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="yogasmoga_menu_links level2">
                        <ul>
                            <li class="ys_main_category">
                                <p><a href="/men">MEN</a>
                                <span class="menu_arrow">
                                    <svg width="44px" height="44px">
                                        <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="272.374" y1="109.657"
                                              x2="288.374"
                                              y2="109.657"/>
                                        <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="14.374"
                                              y1="21.39" x2="30.374" y2="21.39"/>
                                        <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="22.374"
                                              y1="13.39" x2="22.374" y2="29.39"/>
                                    </svg>
                                </span>
                                </p>
                                <ul class="ys_sub_menu level3">
                                    <li><a href="/men/tops">TOPS</a>
                                        <span class="menu_arrow">
                                            <svg width="44px" height="44px">
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="272.374" y1="109.657"
                                                      x2="288.374"
                                                      y2="109.657"/>
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="14.374"
                                                      y1="21.39" x2="30.374" y2="21.39"/>
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="22.374"
                                                      y1="13.39" x2="22.374" y2="29.39"/>
                                            </svg>
                                        </span>
                                        <ul>
                                            <li><a href="/men/tops/tees">Tees</a></li>
                                            <li><a href="/men/tops/tanks">Tanks</a></li>
                                            <li><a href="/men/tops/jackets">Jackets</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/men/bottoms">BOTTOMS</a>
                                        <span class="menu_arrow">
                                            <svg width="44px" height="44px">
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="272.374" y1="109.657"
                                                      x2="288.374"
                                                      y2="109.657"/>
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="14.374"
                                                      y1="21.39" x2="30.374" y2="21.39"/>
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="22.374"
                                                      y1="13.39" x2="22.374" y2="29.39"/>
                                            </svg>
                                        </span>
                                        <ul>
                                            <li><a href="/men/bottoms/shorts">Shorts</a></li>
                                            <li><a href="/men/bottoms/pants">Pants</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/men/accessories">ACCESSORIES</a>
                                        <span class="menu_arrow">
                                            <svg width="44px" height="44px">
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="272.374" y1="109.657"
                                                      x2="288.374"
                                                      y2="109.657"/>
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="14.374"
                                                      y1="21.39" x2="30.374" y2="21.39"/>
                                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="22.374"
                                                      y1="13.39" x2="22.374" y2="29.39"/>
                                            </svg>
                                        </span>
                                        <ul>
                                            <li><a href="/men/accessories/yoga-mats">Yoga Mats</a></li>
                                            <li><a href="/men/accessories/yoga-towels">Yoga Towels</a></li>
                                            <li><a href="/men/accessories/namaskar-bracelets">NAMASKÀR Bracelets</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="/men/whats-new">WHAT'S NEW</a></li>
                                </ul>
                            </li>

                            <li class="ys_single_link"><a href="/our-story">YS Story</a>
                                <span class="ys_story">

                                        <svg width="44px" height="44px">
                                            <use xlink:href="#ys_story"></use>
                                        </svg>
                                </span>
                            </li>
                            <li class="ys_single_link"><a href="/ys-fabric-tech">YS Tech</a>
                                <span class="tech_icon">
                                        <svg width="44px" height="44px">
                                            <use xlink:href="#ys_tech"></use>
                                        </svg>
                                </span>
                            </li>
                            <li class="ys_single_link"><a href="/smogi-bucks">
                                    <span class="smogi_bucks_icon">

                                        <svg width="44px" height="44px">
                                            <use xlink:href="#smogi_bucks"></use>
                                        </svg>
                                    </span>SMOGI Bucks</a></li>
                            <li class="ys_single_link"><a href="/contacts">
                                    <span class="contact_icon">
                                        <svg width="44px" height="44px">
                                            <use xlink:href="#contact"></use>
                                        </svg>
                                    </span>Contact</a></li>
                            <li class="ys_single_link"><a href="/help">
                            <span class="contact_icon">
                                <svg width="44px" height="44px">
                                    <use xlink:href="#help"></use>
                                </svg>
                            </span>Help</a></li>


                        </ul>
                    </div>
                    <div class="line"></div>
                </div>
                <div class="rangoli_menu level1">
                    <div class="main_btn">
                        <a href="<?php echo $home; ?>">
                            <svg width="171.333px" height="44px">
                                <use xlink:href="#rangoli_logo"></use>
                            </svg>

                        </a>
                        <span class="menu_arrow active">
                        
                            <svg width="44px" height="44px">
                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="272.374" y1="109.657"
                                      x2="288.374"
                                      y2="109.657"/>
                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="14.374"
                                      y1="21.39" x2="30.374" y2="21.39"/>
                                <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="22.374"
                                      y1="13.39" x2="22.374" y2="29.39"/>
                            </svg>
                        </span>
                    </div>
                    <li>
                    <ul class="rangoli_menu_links level2"  style="padding-bottom: 15px;">
                        <?php
                        wp_nav_menu(array('theme_location' => 'menu1_mobile', 'container_class' => 'category-menu'));
                        wp_nav_menu(array('theme_location' => 'menu2_mobile', 'container_class' => 'category-menu_mobile'));
                        ?>
                    </ul>
                    </li>
                    <div class="line"></div>
                </div>
                <div class="additional_links">
                    <ul>
                        <li><a href="javascript:void(0);">&copy; 2015 YOGASMOGA</a></li>
                        <li><a href="/privacy-policy/">Privacy Policy</a></li>
                        <li><a href="/terms-and-conditions/">Terms &amp; Conditions</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <!-- --------------- -->

    <div class="page_heading">
        <?php
        $page = "";
        if (is_home()) {
            ?>
            <?php $page = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="105px" height="44px" viewBox="0 0 105 44" enable-background="new 0 0 105 44" xml:space="preserve">
<g>
	<g>
		<path fill="#555555" d="M3.637,12.608h4.53c2.722,0,3.989,0.327,4.881,0.892c1.408,0.845,2.371,2.698,2.371,4.67
			c0.023,1.173-0.305,2.417-1.033,3.402c-1.033,1.407-2.277,1.737-3.872,1.902l4.318,6.5H12.72l-4.905-7.579h0.563
			c1.22,0,2.911-0.023,3.849-0.893c0.916-0.892,1.314-1.948,1.314-3.193c0-1.289-0.634-2.652-1.713-3.356
			c-0.869-0.562-1.948-0.634-3.52-0.634H5.585v15.654H3.637V12.608z"/>
		<path fill="#555555" d="M17.629,29.974h-2.088l7.252-17.366h1.877l7.182,17.366h-2.112l-2.018-4.882h-8.098L17.629,29.974z
			 M23.661,14.791l-3.45,8.706h6.923L23.661,14.791z"/>
		<path fill="#555555" d="M45.088,27.111l-0.024-14.502h1.877v17.366h-1.877L34.761,15.353l0.047,14.621H32.93V12.608h1.971
			L45.088,27.111z"/>
		<path fill="#555555" d="M63.949,17.113c-0.541-0.75-1.198-1.384-1.949-1.878c-1.126-0.773-2.486-1.219-4.036-1.219
			c-3.802,0-7.111,2.91-7.111,7.252c0,4.412,3.333,7.322,7.135,7.322c1.83,0,3.449-0.635,4.647-1.572
			c1.219-0.964,2.064-2.275,2.346-3.639h-8.637v-1.596h10.891c-0.024,1.008-0.259,2.275-0.774,3.355
			c-1.503,3.263-4.977,5.162-8.473,5.162c-5.069,0-9.083-3.895-9.083-9.033c0-5.211,4.083-8.966,9.107-8.966
			c3.52,0,6.781,1.972,8.144,4.812H63.949z"/>
		<path fill="#555555" d="M87.975,12.608h1.949V28.26h8.496v1.714H87.975V12.608z"/>
		<path fill="#555555" d="M99.438,12.608h1.926v17.366h-1.926V12.608z"/>
	</g>
	<path fill="#555555" d="M77.385,12.304c-4.766,0-9.114,3.504-9.114,9.159v0.023c0,4.44,3.646,8.761,9.089,8.761
		c5.376,0,9.16-4.156,9.16-8.97S82.711,12.304,77.385,12.304z M78.777,26.612l-1.404,2.422l-1.412-2.466
		c-2.32-0.687-3.682-2.95-3.682-5.344V21.2c0-2.641,1.801-5.49,5.129-5.49c3.457,0,5.105,3.125,5.105,5.566
		C82.514,23.354,81.29,25.934,78.777,26.612z"/>
</g>
</svg>
'; ?>
        <?php
        } else if (is_page()) {
            $page = strtoupper(get_the_title());
        } else {
            $post = get_post();
            if ($post->post_type == "post" && $post->post_status == "publish") {
                if (has_category("read", $post)) {
                    $page = "READ";
                } else if (has_category("look", $post)) {
                    $page = "LOOK";
                } else if (has_category("learn", $post)) {
                    $page = "LEARN";
                }
            }
        }
        ?>
        <div>

            <?php if (!$logged_in) { ?>
                <span class="open_signin">Sign In</span>
            <?php } else { ?>
                <span class="smogi_bucks"><?php $user_id = get_current_user_id();
                    echo "<i>$</i>" . get_currrent_user_smogi_bucks($user_id); ?> </span>
            <?php } ?>
            <span class="page_name">
            <?php
            if ($page == "JOURNEY") {
                $page = "STEP 1 OF 2";
            } else if (is_author()) {
                $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
                $user_id = $curauth->ID;
                $user_info = get_userdata($user_id);
                $page = strtoupper($user_info->display_name);
            }
            echo $page;
            ?></span>
            <?php if (is_page("read") || is_page("look") || is_page("learn")) { ?>
                <span class="open-filter">
                    <svg width="44px" height="44px">
                        <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="272.374" y1="109.657" x2="288.374"
                                                                                y2="109.657"/>
                        <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="14.374"
                              y1="21.39" x2="30.374" y2="21.39"/>
                        <line fill="none" stroke="#666666" stroke-miterlimit="10" x1="22.374"
                              y1="13.39" x2="22.374" y2="29.39"/>
                    </svg>
                </span>
                <span class="close-filter"></span>
            <?php } ?>
        </div>
        <?php if ($page == "READ" || $page == "LOOK" || $page == "LEARN") { ?>
            <?php echo filter(); ?>
        <?php } ?>
    </div>
    <div style="padding: 44px; "></div>
<?php
/*if(!is_home() && is_page()){
*/ ?><!--
<div style="padding: 44px; "></div>
--><?php
/*}*/
if (!is_user_logged_in() && is_home()) {
    ?>
    <div class="signup-signin-block">
        <span class="open_signin">SIGN IN</span>
        <span class="open_signup">SIGN UP</span>
    </div>
<?php
}
?>