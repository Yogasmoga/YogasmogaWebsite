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
			<!--twitter cards meta -->
			<?php 
			$twitter_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
			$twitter_thumb  = $twitter_thumbs[0];
			  if(!$twitter_thumb) {
			  $twitter_thumb = get_template_directory_uri().'/images/ys_twitter.jpg';
			} 
			$tc_author   = str_replace('@', '', get_the_author_meta('twitter'));
			?>
			<meta name="twitter:card" content="summary_large_image">
			<meta name="twitter:site" content="@YOGASMOGA">
			<meta name="twitter:creator" content="<?php echo $tc_author; ?>">
			<meta name="twitter:title" content="Rangoli: The YOGASMOGA Community">
			<meta name="twitter:description" content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community.">
			<meta name="twitter:image" content="<?php echo $twitter_thumb; ?>">
			<!--twitter cards meta, ends -->	  
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
			<!--twitter cards meta -->
			<?php 
			$twitter_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
			$twitter_thumb  = $twitter_thumbs[0];
			  if(!$twitter_thumb) {
			  $twitter_thumb = get_template_directory_uri().'/images/ys_twitter.jpg';
			} 
			$tc_author   = str_replace('@', '', get_the_author_meta('twitter'));
			?>
			<meta name="twitter:card" content="summary_large_image">
			<meta name="twitter:site" content="@YOGASMOGA">
			<meta name="twitter:creator" content="<?php echo $tc_author; ?>">
			<meta name="twitter:title" content="Read | Rangoli: The YOGASMOGA Community">
			<meta name="twitter:description" content="Our READ section features a curated selection of health & wellness related articles, op-eds, editorial, recipes, biographies, interviews and more. Your brain will love you for it. Rangoli: The YOGASMOGA Community.">
			<meta name="twitter:image" content="<?php echo $twitter_thumb; ?>">
			<!--twitter cards meta, ends -->
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
			<!--twitter cards meta -->
			<?php 
			$twitter_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
			$twitter_thumb  = $twitter_thumbs[0];
			  if(!$twitter_thumb) {
			  $twitter_thumb = get_template_directory_uri().'/images/ys_twitter.jpg';
			} 
			$tc_author   = str_replace('@', '', get_the_author_meta('twitter'));
			?>
			<meta name="twitter:card" content="summary_large_image">
			<meta name="twitter:site" content="@YOGASMOGA">
			<meta name="twitter:creator" content="<?php echo $tc_author; ?>">
			<meta name="twitter:title" content="Look | Rangoli: The YOGASMOGA Community">
			<meta name="twitter:description" content="Discover our Look section and browse through photography, slideshows, and more awe-inspiring imagery that revolve around health & wellness. Pictures are worth 1000 words and our Look section will give you plenty to talk about. Rangoli: The YOGASMOGA Community.">
			<meta name="twitter:image" content="<?php echo $twitter_thumb; ?>">
			<!--twitter cards meta, ends -->
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
			<!--twitter cards meta -->
			<?php 
			$twitter_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
			$twitter_thumb  = $twitter_thumbs[0];
			  if(!$twitter_thumb) {
			  $twitter_thumb = get_template_directory_uri().'/images/ys_twitter.jpg';
			} 
			$tc_author   = str_replace('@', '', get_the_author_meta('twitter'));
			?>
			<meta name="twitter:card" content="summary_large_image">
			<meta name="twitter:site" content="@YOGASMOGA">
			<meta name="twitter:creator" content="<?php echo $tc_author; ?>">
			<meta name="twitter:title" content="Learn | Rangoli: The YOGASMOGA Community">
			<meta name="twitter:description" content="Learn how to hit that yoga pose with video tutorials from our beloved SMOGIs. Whether you’re a beginner or a seasoned yogi, our SMOGIs will guide you step-by-step with each pose, adjustment, inhale and exhale. Rangoli: The YOGASMOGA Community.">
			<meta name="twitter:image" content="<?php echo $twitter_thumb; ?>">
			<!--twitter cards meta, ends -->
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
			
			<!--twitter cards meta -->
			<?php 
			$twitter_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
			$twitter_thumb  = $twitter_thumbs[0];
			  if(!$twitter_thumb) {
			  $twitter_thumb = get_template_directory_uri().'/images/ys_twitter.jpg';
			} 
			$tc_author   = str_replace('@', '', get_the_author_meta('twitter'));
			?>
			<meta name="twitter:card" content="summary_large_image">
			<meta name="twitter:site" content="@YOGASMOGA">
			<meta name="twitter:creator" content="<?php echo $tc_author; ?>">
			<meta name="twitter:title" content="404 | Rangoli: The YOGASMOGA Community">
			<meta name="twitter:description" content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community.">
			<meta name="twitter:image" content="<?php echo $twitter_thumb; ?>">
			<!--twitter cards meta, ends -->
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
				<!--twitter cards meta -->
				<?php 
				$twitter_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
				$twitter_thumb  = $twitter_thumbs[0];
				  if(!$twitter_thumb) {
				  $twitter_thumb = get_template_directory_uri().'/images/ys_twitter.jpg';
				} 
				$tc_author   = str_replace('@', '', get_the_author_meta('twitter'));
				?>
				<meta name="twitter:card" content="summary_large_image">
				<meta name="twitter:site" content="@YOGASMOGA">
				<meta name="twitter:creator" content="<?php echo $tc_author; ?>">
				<meta name="twitter:title" content="YOGASMOGA Brentwood | Rangoli: The YOGASMOGA Community">
				<meta name="twitter:description" content="Centrally located on the corner of San Vicente Boulevard and Montana Avenue in Brentwood, Los Angeles. We chose this space for its accessibility and neighborhood vibe. Our bright and sunny Brentwood store is wrapped in floor-to-ceiling windows that fill the space with natural light and warm, welcoming energy.">
				<meta name="twitter:image" content="<?php echo $twitter_thumb; ?>">
				<!--twitter cards meta, ends -->
            <?php
            }
            if ($author_name == "YOGASMOGA TOWNHOUSE") {
                ?>
                <meta property="og:title" content="YOGASMOGA Townhouse | Rangoli: The YOGASMOGA Community"/>
                <meta property="og:description"
                      content="We chose this two-story townhouse on Greenwich Avenue as our first store for its strong feel of community. The exposed brick walls create a cozy atmosphere and neutral palate for our bright collections. We are currently renovating the upstairs space for yoga classes and other wellness events."/>
                <meta property="description"
                      content="We chose this two-story townhouse on Greenwich Avenue as our first store for its strong feel of community. The exposed brick walls create a cozy atmosphere and neutral palate for our bright collections. We are currently renovating the upstairs space for yoga classes and other wellness events."/>
				<!--twitter cards meta -->
				<?php 
				$twitter_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
				$twitter_thumb  = $twitter_thumbs[0];
				  if(!$twitter_thumb) {
				  $twitter_thumb = get_template_directory_uri().'/images/ys_twitter.jpg';
				} 
				$tc_author   = str_replace('@', '', get_the_author_meta('twitter'));
				?>
				<meta name="twitter:card" content="summary_large_image">
				<meta name="twitter:site" content="@YOGASMOGA">
				<meta name="twitter:creator" content="<?php echo $tc_author; ?>">
				<meta name="twitter:title" content="YOGASMOGA Townhouse | Rangoli: The YOGASMOGA Community">
				<meta name="twitter:description" content="We chose this two-story townhouse on Greenwich Avenue as our first store for its strong feel of community. The exposed brick walls create a cozy atmosphere and neutral palate for our bright collections. We are currently renovating the upstairs space for yoga classes and other wellness events.">
				<meta name="twitter:image" content="<?php echo $twitter_thumb; ?>">
				<!--twitter cards meta, ends -->
            <?php
            }
            if ($author_name == "YOGASMOGA HQ") {
                ?>
                <meta property="og:title" content="YOGASMOGA HQ | Rangoli: The YOGASMOGA Community"/>
                <meta property="og:description"
                      content="We are YOGASMOGA. Designed in NYC. Made in USA. We make things for life, one breath at a time."/>
                <meta property="description"
                      content="We are YOGASMOGA. Designed in NYC. Made in USA. We make things for life, one breath at a time."/>
				<!--twitter cards meta -->
				<?php 
				$twitter_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
				$twitter_thumb  = $twitter_thumbs[0];
				  if(!$twitter_thumb) {
				  $twitter_thumb = get_template_directory_uri().'/images/ys_twitter.jpg';
				} 
				$tc_author   = str_replace('@', '', get_the_author_meta('twitter'));
				?>
				<meta name="twitter:card" content="summary_large_image">
				<meta name="twitter:site" content="@YOGASMOGA">
				<meta name="twitter:creator" content="<?php echo $tc_author; ?>">
				<meta name="twitter:title" content="YOGASMOGA HQ | Rangoli: The YOGASMOGA Community">
				<meta name="twitter:description" content="We are YOGASMOGA. Designed in NYC. Made in USA. We make things for life, one breath at a time.">
				<meta name="twitter:image" content="<?php echo $twitter_thumb; ?>">
				<!--twitter cards meta, ends -->
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
			<!--twitter cards meta -->
			<?php 
			$twitter_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
			$twitter_thumb  = $twitter_thumbs[0];
			  if(!$twitter_thumb) {
			  $twitter_thumb = get_template_directory_uri().'/images/ys_twitter.jpg';
			} 
			$tc_author   = str_replace('@', '', get_the_author_meta('twitter'));
			?>
			<meta name="twitter:card" content="summary_large_image">
			<meta name="twitter:site" content="@YOGASMOGA">
			<meta name="twitter:creator" content="<?php echo $tc_author; ?>">
			<meta name="twitter:title" content="About Rangoli | Rangoli: The YOGASMOGA Community">
			<meta name="twitter:description" content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind.">
			<meta name="twitter:image" content="<?php echo $twitter_thumb; ?>">
			<!--twitter cards meta, ends -->
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
				  <!--twitter cards meta -->
				<?php 
				$twitter_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
				$twitter_thumb  = $twitter_thumbs[0];
				  if(!$twitter_thumb) {
				  $twitter_thumb = get_template_directory_uri().'/images/ys_twitter.jpg';
				} 
				$tc_author   = str_replace('@', '', get_the_author_meta('twitter'));
				?>
				<meta name="twitter:card" content="summary_large_image">
				<meta name="twitter:site" content="@YOGASMOGA">
				<meta name="twitter:creator" content="<?php echo $tc_author; ?>">
				<meta name="twitter:title" content="<?php echo get_the_title(); ?> | Rangoli: The YOGASMOGA Community">
				<meta name="twitter:description" content="<?php echo $description; ?>">
				<meta name="twitter:image" content="<?php echo $twitter_thumb; ?>">
				<!--twitter cards meta, ends -->
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
        <?php $canicalurl="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>
        <link rel="canonical" href="<?php echo $canicalurl; ?>" />
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
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 width="44px" height="44px" viewBox="0 0 44 44" enable-background="new 0 0 44 44" xml:space="preserve">
<g>
    <rect fill="#555555" width="44" height="44"/>
    <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="14" y1="14" x2="30" y2="30"/>
    <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="30" y1="14" x2="14" y2="30"/>
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
                            </span><span class="open_signin">Sign In</span>&nbsp; / <span class="open_signup">Sign Up</span></a>
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
<!--                                            <li><a href="/women/tops/rangoli">Rangoli</a></li>-->
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
<!--                                            <li><a href="/women/bottoms/rangoli">Rangoli</a></li>-->
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
                                            <li><a href="/women/accessories/scarves">Scarves</a></li>
                                            <!--<li><a href="/women/accessories/head-bands">Head Bands</a></li>-->
<!--                                            <li><a href="/women/accessories/yoga-mats">Yoga Mats</a></li>-->
<!--                                            <li><a href="/women/accessories/yoga-towels">Yoga Towels</a></li>-->
                                            <li><a href="/women/accessories/yoga-flops">Yoga Flops</a></li>
                                            <li><a href="/women/accessories/namaskar-bracelets">Namask&aacute;r Bracelets</a>
											<li><a href="/women/accessories/bags">Bags</a></li>
                                            </li>
                                        </ul>
                                    </li>
									
									 <li><a href="/women/whats-new">What&rsquo;s New</a></li>
								  <li><a href="/women/core">Core</a></li>
								   <li><a href="/women/select">Select</a></li>
								    <li><a href="/women/premium">Premium</a></li>
                                   
									<li><a href="/women/prints">PRINTS</a></li>
                                    <!--<li><a href="/women/one-too-many"> One 2 Many</a></li>-->
									<!--<li><a href="/women/super-sale">Super Sale</a></li>-->
                                    <li><a href="/women/additional-sizes">ADDITIONAL SIZES</a></li>
                                    <li><a href="/women/vivacity-collection">VIVACITY COLLECTION</a></li>
									<li><a href="/women/carbon6">Carbon6&trade; COLLECTION</a></li>
<!--                                    <li><a href="/women/rangoli-collection">RANGOLI COLLECTION</a></li>-->
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
<!--                                            <li><a href="/men/accessories/yoga-mats">Yoga Mats</a></li>-->
<!--                                            <li><a href="/men/accessories/yoga-towels">Yoga Towels</a></li>-->
                                            <li><a href="/men/accessories/namaskar-bracelets">Namask&aacute;r Bracelets</a>
											<li><a href="/men/accessories/bags">Bags</a></li>
                                            </li>
                                        </ul>
                                    </li>
                                <li><a href="/men/whats-new">WHAT'S NEW</a></li>
								<li><a href="/men/core">CORE</a></li>
								<li><a href="/men/select">SELECT</a></li>
								<li><a href="/men/premium">PREMIUM</a></li>
									<li><a href="/men/carbon6">Carbon6&trade; COLLECTION</a></li>
									<li><a href="/men/golf-inspired">Golf Inspired</a></li>
									<!--<li><a href="/men/super-sale"> Super Sale</a></li>-->
									
                                </ul>
								
                            </li>
								 <li class="ys_main_category">
								<p><a  href="/one-too-many">ONE 2 MANY</a></p>
								</li>
								
                            <li class="ys_single_link"><a href="/our-story">YS Story</a>
                                <span class="ys_story">

                                        <svg width="44px" height="44px" viewBox="0 0 44 44" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">

                                                <!--                                          <use xlink:href="#ys_story"></use>-->
                                                <g id="XMLID_35_">
                                                    <polyline points="29.4,160.3 16.3,166.6 22.6,153.5 	" class="st0" id="XMLID_37_"/>
                                                    <circle r="5.5" cy="155.1" cx="27.8" class="st0" id="XMLID_36_"/>
                                                </g>
                                                <g id="XMLID_32_">
                                                    <rect height="14.7" width="3.9" class="st0" y="238.4" x="22.9" id="XMLID_34_"/>
                                                    <circle r="2.7" cy="232.1" cx="24.8" class="st0" id="XMLID_33_"/>
                                                </g>
                                                <g id="XMLID_25_">
                                                    <line y2="117" x2="30.7" y1="109.5" x1="26.4" class="st0" id="XMLID_31_"/>
                                                    <line y2="109.3" x2="23.3" y1="117.1" x1="18.8" class="st0" id="XMLID_30_"/>
                                                    <line y2="119.7" x2="20.4" y1="119.7" x1="29.2" class="st0" id="XMLID_29_"/>
                                                    <circle r="3" cy="106.8" cx="24.8" class="st0" id="XMLID_28_"/>
                                                    <circle r="3" cy="119.7" cx="32.2" class="st0" id="XMLID_27_"/>
                                                    <path d="M20.4,119.7c0,1.7-1.4,3-3,3c-1.7,0-3-1.4-3-3s1.4-3,3-3C19,116.6,20.4,118,20.4,119.7" class="st0" id="XMLID_26_"/>
                                                </g>
                                                <g id="XMLID_18_">
                                                    <circle r="6.6" cy="195.5" cx="24.8" class="st0" id="XMLID_24_"/>
                                                    <circle r="6.6" cy="197.7" cx="21" class="st0" id="XMLID_23_"/>
                                                    <circle r="6.6" cy="202.1" cx="21" class="st0" id="XMLID_22_"/>
                                                    <circle r="6.6" cy="204.3" cx="24.8" class="st0" id="XMLID_21_"/>
                                                    <circle r="6.6" cy="202.1" cx="28.6" class="st0" id="XMLID_20_"/>
                                                    <circle r="6.6" cy="197.7" cx="28.6" class="st0" id="XMLID_19_"/>
                                                </g>
                                                <g id="XMLID_15_">
                                                    <path d="M23.3,23.5c0,0-4.5,0.1-7.3-2.7s-2.7-7.3-2.7-7.3s4.5-0.1,7.3,2.7S23.3,23.5,23.3,23.5z" class="st0" id="XMLID_17_"/>
                                                    <path d="M23.3,23.5c0,0,4.5,0.1,7.3-2.7s2.7-7.3,2.7-7.3s-4.5-0.1-7.3,2.7S23.3,23.5,23.3,23.5z" class="st0" id="XMLID_16_"/>
                                                </g>
                                                <line y2="30.5" x2="23.3" y1="23.5" x1="23.3" class="st0" id="XMLID_14_"/>
                                                <g id="XMLID_3_">
                                                    <g id="XMLID_5_">
                                                        <line y2="-75.5" x2="-185.5" y1="-75.5" x1="-211.6" class="st0" id="XMLID_12_"/>
                                                        <line y2="-80.8" x2="-185.5" y1="-80.8" x1="-211.6" class="st0" id="XMLID_11_"/>
                                                        <line y2="-78.2" x2="-185.5" y1="-78.2" x1="-211.6" class="st0" id="XMLID_10_"/>
                                                        <line y2="-83.5" x2="-185.5" y1="-83.5" x1="-201.2" class="st0" id="XMLID_9_"/>
                                                        <line y2="-86.2" x2="-185.5" y1="-86.2" x1="-201.2" class="st0" id="XMLID_8_"/>
                                                        <line y2="-88.8" x2="-185.5" y1="-88.8" x1="-201.2" class="st0" id="XMLID_7_"/>
                                                        <line y2="-91.5" x2="-185.5" y1="-91.5" x1="-201.2" class="st0" id="XMLID_6_"/>
                                                    </g>
                                                    <polygon points="-207.6,-85.6 -210.1,-83.7 -209.1,-86.7 -211.6,-88.5 -208.5,-88.5 -207.6,-91.5
		-206.6,-88.5 -203.5,-88.5 -206,-86.7 -205,-83.7 	" class="st0" id="XMLID_4_"/>
                                                </g>
                                        </svg>
                                </span>
                            </li>
                            <li class="ys_single_link"><a href="/ys-fabric-tech">YS Tech</a>
                                <span class="tech_icon">
                                        <svg xml:space="preserve" width="44px" height="44px" style="enable-background:new 0 0 44 44;" viewBox="0 0 44 44" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">

                                            <!--                                          <use xlink:href="#ys_tech"></use>-->
                                            <g id="XMLID_35_">
                                                <polyline points="29.4,160.3 16.3,166.6 22.6,153.5 	" class="st0" id="XMLID_37_"/>
                                                <circle r="5.5" cy="155.1" cx="27.8" class="st0" id="XMLID_36_"/>
                                            </g>
                                            <g id="XMLID_32_">
                                                <rect height="14.7" width="3.9" class="st0" y="238.4" x="22.9" id="XMLID_34_"/>
                                                <circle r="2.7" cy="232.1" cx="24.8" class="st0" id="XMLID_33_"/>
                                            </g>
                                            <g id="XMLID_25_">
                                                <line y2="25.8" x2="28" y1="18.3" x1="23.7" class="st0" id="XMLID_31_"/>
                                                <line y2="18.1" x2="20.6" y1="25.9" x1="16.1" class="st0" id="XMLID_30_"/>
                                                <line y2="28.5" x2="17.7" y1="28.5" x1="26.5" class="st0" id="XMLID_29_"/>
                                                <circle r="3" cy="15.5" cx="22.1" class="st0" id="XMLID_28_"/>
                                                <circle r="3" cy="28.5" cx="29.5" class="st0" id="XMLID_27_"/>
                                                <path d="M17.7,28.5c0,1.7-1.4,3-3,3s-3-1.4-3-3c0-1.7,1.4-3,3-3S17.7,26.8,17.7,28.5" class="st0" id="XMLID_26_"/>
                                            </g>
                                            <g id="XMLID_18_">
                                                <circle r="6.6" cy="195.5" cx="24.8" class="st0" id="XMLID_24_"/>
                                                <circle r="6.6" cy="197.7" cx="21" class="st0" id="XMLID_23_"/>
                                                <circle r="6.6" cy="202.1" cx="21" class="st0" id="XMLID_22_"/>
                                                <circle r="6.6" cy="204.3" cx="24.8" class="st0" id="XMLID_21_"/>
                                                <circle r="6.6" cy="202.1" cx="28.6" class="st0" id="XMLID_20_"/>
                                                <circle r="6.6" cy="197.7" cx="28.6" class="st0" id="XMLID_19_"/>
                                            </g>
                                            <g id="XMLID_15_">
                                                <path d="M-147.1,37c0,0-4.5,0.1-7.3-2.7s-2.7-7.3-2.7-7.3s4.5-0.1,7.3,2.7S-147.1,37-147.1,37z" class="st0" id="XMLID_17_"/>
                                                <path d="M-147.1,37c0,0,4.5,0.1,7.3-2.7s2.7-7.3,2.7-7.3s-4.5-0.1-7.3,2.7S-147.1,37-147.1,37z" class="st0" id="XMLID_16_"/>
                                            </g>
                                            <line y2="44" x2="-147.1" y1="37" x1="-147.1" class="st0" id="XMLID_14_"/>
                                            <g id="XMLID_3_">
                                                <g id="XMLID_5_">
                                                    <line y2="-75.5" x2="-185.5" y1="-75.5" x1="-211.6" class="st0" id="XMLID_12_"/>
                                                    <line y2="-80.8" x2="-185.5" y1="-80.8" x1="-211.6" class="st0" id="XMLID_11_"/>
                                                    <line y2="-78.2" x2="-185.5" y1="-78.2" x1="-211.6" class="st0" id="XMLID_10_"/>
                                                    <line y2="-83.5" x2="-185.5" y1="-83.5" x1="-201.2" class="st0" id="XMLID_9_"/>
                                                    <line y2="-86.2" x2="-185.5" y1="-86.2" x1="-201.2" class="st0" id="XMLID_8_"/>
                                                    <line y2="-88.8" x2="-185.5" y1="-88.8" x1="-201.2" class="st0" id="XMLID_7_"/>
                                                    <line y2="-91.5" x2="-185.5" y1="-91.5" x1="-201.2" class="st0" id="XMLID_6_"/>
                                                </g>
                                                <polygon points="-207.6,-85.6 -210.1,-83.7 -209.1,-86.7 -211.6,-88.5 -208.5,-88.5 -207.6,-91.5
		-206.6,-88.5 -203.5,-88.5 -206,-86.7 -205,-83.7 	" class="st0" id="XMLID_4_"/>
                                            </g>
</svg>
                                </span>
                            </li>
							 <li class="ys_single_link"><a href="/our-stores">YS Stores</a>
                                <span class="tech_icon">
                                       <svg width="44" height="44" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 44 44" style="enable-background:new 0 0 44 44;" xml:space="preserve">

<g id="XMLID_2_">
	<path id="XMLID_7_" fill="#CECECD"  d="M9.9,11.4l11.8,20.5l11.8-20.5H9.9z M11.7,12.4h20.2L21.7,29.9L11.7,12.4z"/>
	<path id="XMLID_4_" fill="#CECECD"  d="M14.6,14.1l7.1,12.4l7.1-12.4H14.6z M16.3,15.1h4.9v2h-1.7l2.2,3.9l2.3-3.9h-1.8v-2h4.9
		l-5.4,9.4L16.3,15.1z"/>
</g>
</svg>
                                </span>
                            </li>
                            <li class="ys_single_link"><a href="/smogi-bucks">
                                    <span class="smogi_bucks_icon">

                                        <svg xml:space="preserve" width="44px" height="44px" style="enable-background:new 0 0 44 44;" viewBox="0 0 44 44" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">

                                            <!--    <use xlink:href="#smogi_bucks"></use>-->
                                            <g id="XMLID_35_">
                                                <polyline points="-155,197.7 -168.1,204 -161.8,190.9 	" class="st0" id="XMLID_37_"/>
                                                <circle r="5.5" cy="192.5" cx="-156.6" class="st0" id="XMLID_36_"/>
                                            </g>
                                            <g id="XMLID_32_">
                                                <rect height="14.7" width="3.9" class="st0" y="238.4" x="22.9" id="XMLID_34_"/>
                                                <circle r="2.7" cy="232.1" cx="24.8" class="st0" id="XMLID_33_"/>
                                            </g>
                                            <g id="XMLID_25_">
                                                <line y2="114.3" x2="-146.2" y1="106.8" x1="-150.6" class="st0" id="XMLID_31_"/>
                                                <line y2="106.6" x2="-153.6" y1="114.4" x1="-158.1" class="st0" id="XMLID_30_"/>
                                                <line y2="117" x2="-156.5" y1="117" x1="-147.7" class="st0" id="XMLID_29_"/>
                                                <circle r="3" cy="104.1" cx="-152.1" class="st0" id="XMLID_28_"/>
                                                <circle r="3" cy="117" cx="-144.7" class="st0" id="XMLID_27_"/>
                                                <path d="M-156.5,117c0,1.7-1.4,3-3,3s-3-1.4-3-3s1.4-3,3-3S-156.5,115.3-156.5,117" class="st0" id="XMLID_26_"/>
                                            </g>
                                            <g id="XMLID_18_">
                                                <circle r="6.6" cy="17.6" cx="22" class="st0" id="XMLID_24_"/>
                                                <circle r="6.6" cy="19.8" cx="18.2" class="st0" id="XMLID_23_"/>
                                                <circle r="6.6" cy="24.2" cx="18.2" class="st0" id="XMLID_22_"/>
                                                <circle r="6.6" cy="26.4" cx="22" class="st0" id="XMLID_21_"/>
                                                <circle r="6.6" cy="24.2" cx="25.8" class="st0" id="XMLID_20_"/>
                                                <circle r="6.6" cy="19.8" cx="25.8" class="st0" id="XMLID_19_"/>
                                            </g>
                                            <g id="XMLID_15_">
                                                <path d="M-147.1,37c0,0-4.5,0.1-7.3-2.7s-2.7-7.3-2.7-7.3s4.5-0.1,7.3,2.7S-147.1,37-147.1,37z" class="st0" id="XMLID_17_"/>
                                                <path d="M-147.1,37c0,0,4.5,0.1,7.3-2.7s2.7-7.3,2.7-7.3s-4.5-0.1-7.3,2.7S-147.1,37-147.1,37z" class="st0" id="XMLID_16_"/>
                                            </g>
                                            <line y2="44" x2="-147.1" y1="37" x1="-147.1" class="st0" id="XMLID_14_"/>
                                            <g id="XMLID_3_">
                                                <g id="XMLID_5_">
                                                    <line y2="-75.5" x2="-185.5" y1="-75.5" x1="-211.6" class="st0" id="XMLID_12_"/>
                                                    <line y2="-80.8" x2="-185.5" y1="-80.8" x1="-211.6" class="st0" id="XMLID_11_"/>
                                                    <line y2="-78.2" x2="-185.5" y1="-78.2" x1="-211.6" class="st0" id="XMLID_10_"/>
                                                    <line y2="-83.5" x2="-185.5" y1="-83.5" x1="-201.2" class="st0" id="XMLID_9_"/>
                                                    <line y2="-86.2" x2="-185.5" y1="-86.2" x1="-201.2" class="st0" id="XMLID_8_"/>
                                                    <line y2="-88.8" x2="-185.5" y1="-88.8" x1="-201.2" class="st0" id="XMLID_7_"/>
                                                    <line y2="-91.5" x2="-185.5" y1="-91.5" x1="-201.2" class="st0" id="XMLID_6_"/>
                                                </g>
                                                <polygon points="-207.6,-85.6 -210.1,-83.7 -209.1,-86.7 -211.6,-88.5 -208.5,-88.5 -207.6,-91.5
		-206.6,-88.5 -203.5,-88.5 -206,-86.7 -205,-83.7 	" class="st0" id="XMLID_4_"/>
                                            </g>
</svg>
                                    </span>SMOGI Bucks</a></li>
									
									 <li class="ys_single_link"><a href="/gift_of_ys">
                                    <span class="gift_card_icon">

                                       <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="44px" height="44px" viewBox="0 0 44 44" enable-background="new 0 0 44 44" xml:space="preserve">
<g>
	<defs>
		<rect id="SVGID_1_" x="9" y="13" width="26.807" height="16.983"/>
	</defs>
	<clipPath id="SVGID_2_">
		<use xlink:href="#SVGID_1_"  overflow="visible"/>
	</clipPath>
	<path clip-path="url(#SVGID_2_)" fill="#CCCCCC" d="M34.888,29.126H9.917V13.858h24.971V29.126z M35.805,13H9v16.983h26.805V13z"/>
	<polygon clip-path="url(#SVGID_2_)" fill="none" stroke="#CCCCCC" stroke-width="0.707" stroke-miterlimit="10" points="
		40.326,26.249 38.492,27.965 21.066,11.666 22.9,9.95 	"/>
	<path clip-path="url(#SVGID_2_)" fill="none" stroke="#CCCCCC" stroke-width="0.707" stroke-miterlimit="10" d="M26.144,33.528
		l-1.835,1.716L6.882,18.946l1.834-1.716L26.144,33.528z"/>
</g>
</svg>
                                    </span>YS Gift Card</a></li>
                            <li class="ys_single_link"><a href="/contacts">
                                    <span class="contact_icon">
                                        <svg width="44px" height="44px" xml:space="preserve" style="enable-background:new 0 0 44 44;" viewBox="0 0 44 44" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">

                                            <!--                                    <use xlink:href="#contact"></use>-->
                                            <g id="XMLID_4_">
                                                <rect height="14.7" width="3.9" class="st0" y="59.3" x="20.1" id="XMLID_6_"/>
                                                <circle r="2.7" cy="53" cx="22" class="st0" id="XMLID_5_"/>
                                            </g>
                                            <path d="M28.4,26.9l0.6,0h6.5v-4.4c0-2.7-6-5-13.5-5c-7.4,0-13.5,2.2-13.5,5v4.4h7l0-3.2
	c0-1.6,2.9-2.9,6.4-2.9s6.4,1.3,6.4,2.9L28.4,26.9z" class="st0" id="XMLID_3_"/>
</svg>
                                    </span>Contact</a></li>
                            <li class="ys_single_link"><a href="/help">
                            <span class="contact_icon">
                                <svg width="44px" height="44px" xml:space="preserve" style="enable-background:new 0 0 44 44;" viewBox="0 0 44 44" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">


                                    <!--                                    <use xlink:href="#help"></use>-->
                                    <g id="XMLID_4_">
                                        <rect height="14.7" width="3.9" class="st0" y="19.1" x="19.8" id="XMLID_6_"/>
                                        <circle r="2.7" cy="12.8" cx="21.8" class="st0" id="XMLID_5_"/>
                                    </g>
                                    <path d="M-70.9,26.7l0.6,0h6.5v-4.4c0-2.7-6-5-13.5-5c-7.4,0-13.5,2.2-13.5,5v4.4h7l0-3.2
	c0-1.6,2.9-2.9,6.4-2.9s6.4,1.3,6.4,2.9L-70.9,26.7z" class="st0" id="XMLID_3_"/>
</svg>
                            </span>Help</a></li>
							
							     
						
						<li class="ys_single_link"><a href="/careers">
                            <span class="contact_icon">
                             <svg width="44px" height="44px" version="1.1" id="Layer_1" viewBox="0 0 44 44" style="enable-background:new 0 0 44 44;" xml:space="preserve">
								<style type="text/css">
								.st0{fill:#BFBFC0;}
								.st1{fill:none;stroke:#CCCBCB;stroke-miterlimit:10;}
								</style>
								<path id="XMLID_4_" class="st0" d="M37.1,117.8"/>
								<path id="XMLID_1_" class="st0" d="M37.1-152.7"/>
								<polygon id="XMLID_2_" class="st1" points="23.6,13.8 23.6,19.7 18.1,19.7 18.1,25.1 12.2,25.1 12.2,31.5 30,31.5 30,13.8 "/>
							</svg>

                            </span>Careers</a></li>


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
<style>
    .st0{
        stroke : #CCC !important;
    }
	.mobile-orange-banner{background: rgb(255, 102, 0) none repeat scroll 0 0; color: rgb(255, 255, 255);font-size: 10px; height: 44px;    letter-spacing: 0 !important;
    line-height: 44px;
    position: fixed;
	text-align:center;
    top: 88px;
    width: 100%;
	font-family:ITCAvantGardeStd-Md;
    z-index: 8;}
	
</style>

<?php
if(!is_user_logged_in() && is_home()) {
?>
  <div  class="mobile-orange-banner">SIGN UP NOW TO RECEIVE $25 SMOGI BUCKS</div>
<?php
}
?>
