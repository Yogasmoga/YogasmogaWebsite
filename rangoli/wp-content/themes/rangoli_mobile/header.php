<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(is_ssl()) {
    $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("location: ".$url);
}
$logged_in = is_user_logged_in();

?>
<!DOCTYPE html>
<html>
<head>
    <?php
    $home = "/rangoli/";
    $root = str_replace("/rangoli","/",$home);
    $media = $home. "/wp-content/themes/rangoli_mobile/images/";
    ?>
    <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1.0, user-scalable=no" />

    <?php
    if(is_home()){
        ?>
        <title>Rangoli: The YOGASMOGA Community</title>
        <meta property="og:title" content="Rangoli: The YOGASMOGA Community" />
        <meta property="og:description" content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community." />
        <meta property="description" content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community." />
    <?php
    }
    if(is_page("read")){
        ?>
        <title>Read | Rangoli: The YOGASMOGA Community</title>
        <meta property="og:title" content="Look | Rangoli: The YOGASMOGA Community" />
        <meta property="og:description" content="Our READ section features a curated selection of health & wellness related articles, op-eds, editorial, recipes, biographies, interviews and more. Your brain will love you for it. Rangoli: The YOGASMOGA Community." />
        <meta property="description" content="Our READ section features a curated selection of health & wellness related articles, op-eds, editorial, recipes, biographies, interviews and more. Your brain will love you for it. Rangoli: The YOGASMOGA Community." />
    <?php
    }
    if(is_page("look")){
        ?>
        <title>Look | Rangoli: The YOGASMOGA Community</title>
        <meta property="og:title" content="Look | Rangoli: The YOGASMOGA Community" />
        <meta property="og:description" content="Discover our Look section and browse through photography, slideshows, and more awe-inspiring imagery that revolve around health & wellness. Pictures are worth 1000 words and our Look section will give you plenty to talk about. Rangoli: The YOGASMOGA Community." />
        <meta property="description" content="Discover our Look section and browse through photography, slideshows, and more awe-inspiring imagery that revolve around health & wellness. Pictures are worth 1000 words and our Look section will give you plenty to talk about. Rangoli: The YOGASMOGA Community." />
    <?php
    }
    if(is_page("learn")){
        ?>
        <title>Learn | Rangoli: The YOGASMOGA Community</title>
        <meta property="og:title" content="Learn | Rangoli: The YOGASMOGA Community" />
        <meta property="og:description" content="Learn how to hit that yoga pose with video tutorials from our beloved SMOGIs. Whether you’re a beginner or a seasoned yogi, our SMOGIs will guide you step-by-step with each pose, adjustment, inhale and exhale. Rangoli: The YOGASMOGA Community." />
        <meta property="description" content="Learn how to hit that yoga pose with video tutorials from our beloved SMOGIs. Whether you’re a beginner or a seasoned yogi, our SMOGIs will guide you step-by-step with each pose, adjustment, inhale and exhale. Rangoli: The YOGASMOGA Community." />
    <?php
    }
    if(is_404()){
        ?>
        <title>404 | Rangoli: The YOGASMOGA Community</title>
        <meta property="og:title" content="404 | Rangoli: The YOGASMOGA Community" />
        <meta property="og:description" content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community." />
        <meta property="description" content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community." />
    <?php
    }
    if(is_author()){
        $author_obj = $wp_query->get_queried_object();
        $author_name = strtoupper($author_obj->display_name);
        ?>
        <title><?php echo $author_name ?> | Rangoli: The YOGASMOGA Community</title>
        <?php
        if($author_name =="YOGASMOGA BRENTWOOD") {
            ?>
            <meta property="og:title" content="YOGASMOGA Brentwood | Rangoli: The YOGASMOGA Community"/>
            <meta property="og:description" content="Centrally located on the corner of San Vicente Boulevard and Montana Avenue in Brentwood, Los Angeles. We chose this space for its accessibility and neighborhood vibe. Our bright and sunny Brentwood store is wrapped in floor-to-ceiling windows that fill the space with natural light and warm, welcoming energy."/>
            <meta property="description" content="Centrally located on the corner of San Vicente Boulevard and Montana Avenue in Brentwood, Los Angeles. We chose this space for its accessibility and neighborhood vibe. Our bright and sunny Brentwood store is wrapped in floor-to-ceiling windows that fill the space with natural light and warm, welcoming energy."/>
        <?php
        }
        if($author_name =="YOGASMOGA TOWNHOUSE") {
            ?>
            <meta property="og:title" content="YOGASMOGA Townhouse | Rangoli: The YOGASMOGA Community"/>
            <meta property="og:description" content="We chose this two-story townhouse on Greenwich Avenue as our first store for its strong feel of community. The exposed brick walls create a cozy atmosphere and neutral palate for our bright collections. We are currently renovating the upstairs space for yoga classes and other wellness events."/>
            <meta property="description" content="We chose this two-story townhouse on Greenwich Avenue as our first store for its strong feel of community. The exposed brick walls create a cozy atmosphere and neutral palate for our bright collections. We are currently renovating the upstairs space for yoga classes and other wellness events."/>
        <?php
        }
        if($author_name =="YOGASMOGA HQ") {
            ?>
            <meta property="og:title" content="YOGASMOGA HQ | Rangoli: The YOGASMOGA Community"/>
            <meta property="og:description" content="We are YOGASMOGA. Designed in NYC. Made in USA. We make things for life, one breath at a time."/>
            <meta property="description" content="We are YOGASMOGA. Designed in NYC. Made in USA. We make things for life, one breath at a time."/>
        <?php
        }
    }
    if(is_page("about")){
        ?><title>About Rangoli | Rangoli: The YOGASMOGA Community</title>
        <meta property="og:title" content="About Rangoli | Rangoli: The YOGASMOGA Community" />
        <meta property="og:description" content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind." />
        <meta property="description" content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind." />
    <?php
    }
    else{
        $post = get_post();
        $post_content = "";
        $description="";
        if($post) {
            $post_content = strip_tags($post->post_content);
            $description = substr($post_content,0,155);
        }
        ?>
        <title><?php echo get_the_title(); ?> | Rangoli: The YOGASMOGA Community</title>
        <meta property="og:title" content="<?php echo get_the_title(); ?> | Rangoli: The YOGASMOGA Community" />
        <meta property="og:description" content="<?php echo $description; ?>" />
        <meta property="description" content="<?php echo $description; ?>" />
        <meta property="og:image" content="<?php $banner_img_url=wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); echo $banner_img_url[0]; ?>" />
    <?php
    }
    ?>

    <link rel="stylesheet" href="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/css/flexslider.css" />
    <link rel="stylesheet" href="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/css/croppic.css" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url')  ?>" />
    <link rel="stylesheet" href="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/css/custom.css" />
    <?php
        if(is_home()){
            ?>

    <link rel="stylesheet" href="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/css/homepage.css" />
    <?php
        }
    ?>
    <script src="<?php bloginfo('template_directory')?>/js/jquery.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/jquery.flexslider.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/touchSwipe.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/custom.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/game.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/jquery.raty.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/zeroClipboard.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/croppic.min.js" ></script>


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


    (function(d) {
        var config = {
                kitId: 'zom2eny',
                scriptTimeout: 3000
            },
            h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
    })(document);


    </script>

</head>
<body>
<span style="display: none;" class="logged_in">
    <?php if(is_user_logged_in()){
        $user = get_current_user_id();
        $user_data = get_userdata($user);
        $profile = get_user_profile($user);
        $name = $profile->user_display_name;
        if($name == null){
            $name = $user_data->display_name;
        }
        echo $name;
    }?></span>
<span style="display: none;" id="current_user_img_url">
    <?php if(is_user_logged_in()){
        $user = get_current_user_id();
        $user_data = get_user_meta($user, "cupp_upload_meta" );
        echo $user_data[0];
    }?></span>

<span style="display: none;" class="current_date">
    <?php
        $current_date = date('m.d.y');
        echo $current_date;
    ?></span>
<div class="header">
    <div class="header-container">
        <div class="menu_btn">
            <svg xml:space="preserve" enable-background="new 0 0 44 43.993" viewBox="0 0 44 43.993" height="43.993px" width="44px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">
<g>
    <line y2="29.997" x2="12.222" y1="29.997" x1="32.222" stroke-miterlimit="10" stroke="#FFFFFF" fill="none"/>
    <line y2="21.997" x2="12.222" y1="21.997" x1="32.222" stroke-miterlimit="10" stroke="#FFFFFF" fill="none"/>
    <line y2="13.997" x2="12.222" y1="13.997" x1="32.222" stroke-miterlimit="10" stroke="#FFFFFF" fill="none"/>
</g>
</svg>
        </div>

        <a href="/"><svg xml:space="preserve" enable-background="new 0 0 154 44" viewBox="0 0 154 44" height="44px" width="154px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">
<g>
    <path d="M61.742,18.975l1.726,5.368h-3.391L61.742,18.975z M60.222,14.29l-6.097,15.399h4.267l0.707-2.228h5.389
		l0.729,2.228h4.307L63.614,14.29H60.222z" fill="#FFFFFF"/>
    <g>
        <path d="M72.158,25.398c0.25,2.565,2.118,3.102,3.077,3.102c1.604,0,3.084-1.227,3.084-2.938
			c0-2.162-1.858-2.633-3.631-3.229c-1.262-0.367-3.945-1.157-3.945-4.063c-0.041-2.739,2.238-4.257,4.581-4.257
			c1.914,0,4.13,1.067,4.375,3.979h-1.707c-0.183-0.992-0.683-2.513-2.737-2.513c-1.537,0-2.8,1.048-2.8,2.638
			c-0.015,1.876,1.487,2.341,3.823,3.118c1.453,0.567,3.755,1.384,3.755,4.214c0,2.511-1.89,4.516-4.771,4.516
			c-2.576,0-4.714-1.621-4.816-4.567H72.158z" fill="#FFFFFF"/>
        <polygon points="82.123,29.688 82.123,14.292 84.533,14.292 90.249,27.208 95.923,14.292 98.33,14.292
			98.33,29.688 96.712,29.688 96.751,15.989 90.778,29.688 89.683,29.688 83.694,15.989 83.738,29.688 		" fill="#FFFFFF"/>
        <path d="M134.394,29.688h-1.858l6.433-15.396h1.663L147,29.688h-1.873l-1.785-4.323h-7.17L134.394,29.688z
			 M139.731,16.231l-3.055,7.72h6.146L139.731,16.231z" fill="#FFFFFF"/>
        <path d="M54.604,20.929h-7.666v3.141h3.131c-0.209,0.75-0.645,1.375-1.27,1.789
			c-0.625,0.438-1.438,0.687-2.414,0.687c-1.936,0-4.225-1.396-4.225-4.618c0-3.037,2.27-4.473,4.204-4.473
			c1.082,0,1.932,0.395,2.58,0.956c0.331,0.312,0.604,0.667,0.811,1.042h4.412C53.315,16.476,50.154,14,46.472,14
			c-4.537,0-8.242,3.33-8.242,7.928c0,4.434,3.52,8.072,8.178,8.072c2.54,0,5.992-1.268,7.49-4.661
			C54.565,23.843,54.69,22.032,54.604,20.929" fill="#FFFFFF"/>
        <path d="M126.58,22.433v1.417h4.901c-0.248,1.209-0.991,2.36-2.075,3.209c-1.07,0.84-2.494,1.397-4.123,1.397
			c-3.371,0-6.326-2.565-6.326-6.484c0-3.86,2.951-6.438,6.317-6.438c1.357,0,2.576,0.397,3.58,1.084
			c0.654,0.436,1.232,1,1.72,1.665h1.963c-1.218-2.515-4.115-4.265-7.228-4.265c-4.453,0-8.074,3.342-8.074,7.954
			c0,4.555,3.56,8.002,8.052,8.002c3.108,0,6.176-1.688,7.521-4.563c0.457-0.972,0.651-2.083,0.682-2.978H126.58L126.58,22.433z" fill="#FFFFFF"/>
        <polygon points="22.218,14.359 18.271,14.359 14.499,20.862 10.78,14.359 6.733,14.359 12.513,24.457
			12.513,29.688 16.447,29.688 16.447,24.311 		" fill="#FFFFFF"/>
        <path d="M107.849,14.013c-4.242,0-8.115,3.12-8.115,8.153v0.021c0,3.956,3.246,7.806,8.097,7.806
			c4.787,0,8.155-3.703,8.155-7.991C115.985,17.715,112.595,14.013,107.849,14.013 M108.99,26.373l-1.15,1.982l-1.155-2.021
			c-1.898-0.563-3.017-2.417-3.017-4.377V21.94c0-2.165,1.478-4.498,4.203-4.498c2.83,0,4.181,2.56,4.181,4.559
			C112.052,23.703,111.05,25.816,108.99,26.373" fill="#FFFFFF"/>
        <path d="M28.828,14.013c-4.244,0-8.117,3.12-8.117,8.153v0.021c0,3.956,3.249,7.806,8.097,7.806
			c4.787,0,8.157-3.703,8.157-7.991C36.964,17.715,33.573,14.013,28.828,14.013 M29.97,26.373l-1.148,1.982l-1.157-2.021
			c-1.901-0.563-3.019-2.417-3.019-4.377V21.94c0-2.165,1.479-4.498,4.203-4.498c2.83,0,4.183,2.56,4.183,4.559
			C33.031,23.703,32.026,25.816,29.97,26.373" fill="#FFFFFF"/>
    </g>
</g>
</svg></a>
        <div class="shopping_cart"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="44px" height="44px" viewBox="0 0 44 44" enable-background="new 0 0 44 44" xml:space="preserve">
<g>
    <rect x="13.873" y="14.691" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" width="17.461" height="19.208"/>
    <path fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M27.777,14.604h-2.619v-3.648c0-0.237-0.2-0.437-0.437-0.437h-4.236
		c-0.236,0-0.437,0.2-0.437,0.437v3.648h-2.619v-3.648c0-1.685,1.371-3.056,3.056-3.056h4.236c1.685,0,3.056,1.371,3.056,3.056
		V14.604z"/>
</g>
</svg>
        <span class="cart">
        </span>
        </div>
    </div>
</div>
<!-- RANGOLI YS MENU -->
    <div class="menu-box <?php if(!$logged_in) {echo 'not-logged-in-menu';} ?>" >
        <span class="close_menu"></span>
        <div class="menu_list user-color-shade-trans">
<!--            <div class="side_left"></div>-->
            <div class="menu-container">
                <?php if(!$logged_in) { ?>
                <ul class="sign-signup">
                    <li>
                        <a href="javascript:void(0)" style="color:#555;"><span>
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                    width="44px" height="44px" viewBox="164.167 0 44 44" enable-background="new 164.167 0 44 44" xml:space="preserve">
<g>
    <g>
        <path fill="none" stroke="#666666" stroke-miterlimit="10" d="M189.256,16.171c0-2.083-1.689-3.771-3.771-3.771
			c-2.084,0-3.771,1.689-3.771,3.771c0,1.615,1.02,2.981,2.445,3.52L182.627,30h5.715l-1.533-10.309
			C188.237,19.153,189.256,17.786,189.256,16.171z"/>
    </g>
</g>
</svg>
                            </span><span class="open_signin">Sign in</span> / <span  class="open_signup">Sign up</span></a>
                    </li>
                </ul>
                <?php } else {?>
                <div class="user_menu">
                        <?php
                        $user_id = get_current_user_id();
                        $profile_pic = $media."default.jpg";
                        $profile_pics = get_user_meta($user_id,"cupp_upload_meta");
                        if(is_array($profile_pics) and count($profile_pics)>0) {
                            $profile_pic = $profile_pics[0];
                        }
                        $user = get_userdata($user_id);
                        $userObj = get_user_profile($user_id);
                        $name = $userObj->user_display_name ;
                        if($name==null){
                            $name =  $user->display_name;
                        }
                        ?>
                    <div class="main_btn">
                        <span class="profile_picture"><img src="<?php echo $profile_pic; ?>" /></span>
                        <a href="<?php  echo $home;?>/profile?user_id=<?php echo $user_id; ?>">
                        <?php echo $name; ?>
                        </a>
                        <span class="menu_arrow">
                        <?php if(!$logged_in){?>
                            <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/grey-arrow.png" />
                        <?php } else{?>
                            <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/arrow.png" />
                        <?php } ?>
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
                <div class="yogasmoga-menu">
                    <div class="main_btn">
                        <a href="/">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 width="200.667px" height="44px" viewBox="0 0 200.667 44" enable-background="new 0 0 200.667 44" xml:space="preserve">
<g>
    <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M112.654,19.638l1.727,5.367h-3.391L112.654,19.638z M111.135,14.955l-6.095,15.398h4.264l0.708-2.226
		h5.388l0.729,2.226h4.307l-5.908-15.398H111.135z"/>
    <g>
        <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M123.071,26.063c0.25,2.567,2.119,3.1,3.077,3.1c1.604,0,3.084-1.227,3.084-2.937
			c0-2.161-1.858-2.632-3.631-3.227c-1.261-0.367-3.944-1.157-3.944-4.063c-0.042-2.738,2.237-4.258,4.58-4.258
			c1.914,0,4.131,1.068,4.375,3.98h-1.708c-0.18-0.993-0.682-2.514-2.736-2.514c-1.536,0-2.8,1.049-2.8,2.64
			c-0.014,1.875,1.487,2.34,3.823,3.116c1.453,0.566,3.755,1.384,3.755,4.216c0,2.511-1.891,4.514-4.772,4.514
			c-2.575,0-4.712-1.621-4.815-4.567H123.071z"/>
        <polygon fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" points="133.034,30.353 133.034,14.955 135.446,14.955 141.162,27.872 146.835,14.955 149.242,14.955
			149.242,30.353 147.625,30.353 147.665,16.655 141.693,30.353 140.595,30.353 134.607,16.655 134.649,30.353 		"/>
        <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M185.304,30.353h-1.857l6.432-15.396h1.664l6.368,15.396h-1.872l-1.785-4.326h-7.171L185.304,30.353z
			 M190.645,16.896l-3.055,7.721h6.144L190.645,16.896z"/>
        <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M105.52,21.593h-7.666v3.142h3.13c-0.209,0.75-0.644,1.375-1.269,1.79
			c-0.625,0.436-1.437,0.686-2.414,0.686c-1.936,0-4.225-1.394-4.225-4.619c0-3.038,2.27-4.473,4.205-4.473
			c1.083,0,1.933,0.396,2.58,0.957c0.333,0.312,0.603,0.665,0.811,1.041h4.413c-0.855-2.975-4.018-5.451-7.699-5.451
			c-4.538,0-8.241,3.329-8.241,7.927c0,4.433,3.518,8.073,8.177,8.073c2.539,0,5.992-1.268,7.491-4.661
			C105.479,24.507,105.604,22.697,105.52,21.593"/>
        <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M177.492,23.096v1.417h4.903c-0.248,1.208-0.994,2.36-2.076,3.208c-1.069,0.841-2.494,1.397-4.124,1.397
			c-3.369,0-6.325-2.563-6.325-6.484c0-3.859,2.95-6.436,6.317-6.436c1.359,0,2.577,0.396,3.581,1.082
			c0.653,0.438,1.231,1,1.717,1.667h1.963c-1.216-2.517-4.116-4.268-7.227-4.268c-4.453,0-8.073,3.343-8.073,7.955
			c0,4.556,3.559,8.002,8.053,8.002c3.107,0,6.173-1.687,7.519-4.563c0.456-0.97,0.651-2.082,0.68-2.978H177.492z"/>
        <polygon fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" points="73.131,15.023 69.186,15.023 65.415,21.525 61.695,15.023 57.649,15.023 63.428,25.122
			63.428,30.353 67.36,30.353 67.36,24.973 		"/>
        <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M158.762,14.675c-4.244,0-8.115,3.121-8.115,8.156v0.021c0,3.954,3.247,7.804,8.094,7.804
			c4.788,0,8.158-3.703,8.158-7.99C166.898,18.38,163.506,14.675,158.762,14.675 M159.902,27.037l-1.15,1.984l-1.156-2.021
			c-1.9-0.563-3.016-2.415-3.016-4.375v-0.02c0-2.164,1.477-4.496,4.202-4.496c2.831,0,4.181,2.559,4.181,4.558
			C162.963,24.367,161.962,26.48,159.902,27.037"/>
        <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M79.742,14.675c-4.244,0-8.116,3.121-8.116,8.156v0.021c0,3.954,3.247,7.804,8.095,7.804
			c4.786,0,8.156-3.703,8.156-7.99C87.877,18.38,84.485,14.675,79.742,14.675 M80.882,27.037l-1.148,1.984l-1.156-2.021
			c-1.902-0.563-3.019-2.415-3.019-4.375v-0.02c0-2.164,1.479-4.496,4.203-4.496c2.832,0,4.183,2.559,4.183,4.558
			C83.945,24.367,82.94,26.48,80.882,27.037"/>
    </g>
</g>
                                <g>
                                    <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M3.287,12.208l12.046,20.912L27.38,12.208H3.287z M4.943,13.166h20.78l-10.39,18.037L4.943,13.166z"/>
                                    <polygon fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" points="15.756,14.69 15.756,19.014 17.119,19.014 15.333,22.114 13.547,19.014 14.91,19.014 14.91,14.69
		7.581,14.69 15.333,28.148 23.085,14.69 	"/>
                                </g>
</svg>

                        </a>
                        <span class="menu_arrow">
                        <?php if(!$logged_in){?>
                            <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/grey-arrow.png" />
                        <?php } else{?>
                            <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/arrow.png" />
                        <?php } ?>
                        </span>
                    </div>
                    <div class="yogasmoga_menu_links">
                        <ul>
                            <li class="ys_main_category">
                                <p><a href="/women">Women</a>
                                <span class="menu_arrow">
                        <?php if(!$logged_in){?>
                            <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/grey-arrow.png" />
                        <?php } else{?>
                            <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/arrow.png" />
                        <?php } ?>
                                </span>
                                </p>
                                <ul class="ys_sub_menu">
                                    <li><a href="">Tops</a>
                                        <ul>
                                            <li><a href="/women/tops/bras">Bras</a></li>
                                            <li><a href="/women/tops/tanks">Tanks</a></li>
                                            <li><a href="/women/tops/tees">Tees</a></li>
                                            <li><a href="/women/tops/sweaters">Sweaters</a></li>
                                            <li><a href="/women/tops/jackets">Jackets</a></li>
                                            <li><a href="/women/tops/rangoli">Rangoli</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="">Bottoms</a>
                                        <ul>
                                            <li><a href="/women/bottoms/shorts">Shorts</a></li>
                                            <li><a href="/women/bottoms/crops">Crops</a></li>
                                            <li><a href="/women/bottoms/leggings">Leggings</a></li>
                                            <li><a href="/women/bottoms/pants">Pants</a></li>
                                            <li><a href="/women/bottoms/rangoli">Rangoli</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="">Accessories</a>
                                        <ul>
                                            <li><a href="/women/accessories/head-bands">Head Bands</a></li>
                                            <li><a href="/women/accessories/yoga-mats">Yoga Mats</a></li>
                                            <li><a href="/women/accessories/yoga-towels">Yoga Towels</a></li>
                                            <li><a href="/women/accessories/yoga-flops">Yoga Flops</a></li>
                                            <li><a href="/women/accessories/namaskar-bracelets">NAMASKÀR Bracelets</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/women/whats-new">What's New</a></li>
                                    <li><a href="/women/one-too-many">One 2 Many</a></li>
                                    <li><a href="/women/additional-sizes">Addtional Sizes</a></li>
                                    <li><a href="/women/vivacity-collection">Vivacity collection</a></li>
                                    <li><a href="/women/rangoli-collection">Rangoli collection</a></li>
                                </ul>
                            </li>
                            <li class="ys_main_category">
                                <p><a href="/men">Men</a>
                                <span class="menu_arrow">
                                    <?php if(!$logged_in){?>
                                        <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/grey-arrow.png" />
                                    <?php } else{?>
                                        <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/arrow.png" />
                                    <?php } ?>
                                </span>
                                </p>
                                <ul class="ys_sub_menu">
                                    <li><a href="">Tops</a>
                                        <ul>
                                            <li><a href="/men/tops/tees" >Tees</a></li>
                                            <li><a href="/men/tops/tanks">Tanks</a></li>
                                            <li> <a href="/men/tops/jackets">Jackets</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="">Bottoms</a>
                                        <ul>
                                            <li><a href="/men/bottoms/shorts" >Shorts</a></li>
                                            <li><a href="/men/bottoms/pants">Pants</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="">Accessories</a>
                                        <ul>
                                            <li><a href="/men/accessories/yoga-mats">Yoga Mats</a></li>
                                            <li><a href="/men/accessories/yoga-towels">Yoga Towels</a></li>
                                            <li><a href="/men/accessories/namaskar-bracelets">NAMASKÀR Bracelets</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/whats-new">What's New</a></li>
                                </ul>
                            </li>

                            <li class="ys_single_link"><a href="/our-story">YS Story</a></li>
                            <li class="ys_single_link"><a href="/ys-fabric-tech">YS Tech</a></li>
                            <li class="ys_single_link"><a href="/smogi-bucks">
                                    <span class="smogi_bucks_icon">
                                  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                       width="44px" height="44px" viewBox="0 0 44 44" enable-background="new 0 0 44 44" xml:space="preserve">
<g>
    <circle fill="none" stroke="<?php if(!$logged_in) { echo '#666666';}else{echo '#FFFFFF';} ?>" stroke-miterlimit="10" cx="17.348" cy="26.274" r="6.082"/>
    <path fill="none" stroke="<?php if(!$logged_in) { echo '#666666';}else{echo '#FFFFFF';} ?>" stroke-miterlimit="10" d="M15.757,20.385c0.27-0.984,0.791-1.913,1.564-2.686
		c2.375-2.375,6.227-2.375,8.602,0c2.375,2.375,2.375,6.227,0,8.602c-0.803,0.802-1.773,1.334-2.799,1.595"/>
    <path fill="none" stroke="<?php if(!$logged_in) { echo '#666666';}else{echo '#FFFFFF';} ?>" stroke-miterlimit="10" d="M20.031,16.111c0.27-0.984,0.791-1.913,1.564-2.687
		c2.375-2.375,6.226-2.375,8.601,0c2.376,2.375,2.376,6.227,0,8.602c-0.802,0.803-1.773,1.334-2.799,1.595"/>
</g>
</svg>

                                    </span>SMOGI Bucks</a></li>
                            <li class="ys_single_link"><a href="/contacts">
                                    <span class="contact_icon">
                                        <svg xml:space="preserve" enable-background="new 0 0 44 44" viewBox="0 0 44 44" height="44px" width="44px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">
<g>
    <g>
        <rect height="12.872" width="3.387" fill="<?php if(!$logged_in) { echo '#666666';}else{echo '#FFFFFF';} ?>" y="19.489" x="19.807"/>
        <circle r="2.355" cy="13.995" cx="21.5" fill="<?php if(!$logged_in) { echo '#666666';}else{echo '#FFFFFF';} ?>"/>
    </g>
</g>
</svg>


                                    </span>Contact</a></li>


                        </ul>
                    </div>
                    <div class="line"></div>
                </div>
                <div class="rangoli_menu">
                    <div class="main_btn">
                        <a href="<?php echo $home;?>">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 width="155.333px" height="44px" viewBox="0 0 155.333 44" enable-background="new 0 0 155.333 44" xml:space="preserve">
<g>
    <g>
        <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M57.776,14.273h4.026c2.42,0,3.546,0.291,4.339,0.792c1.252,0.751,2.107,2.398,2.107,4.151
			c0.021,1.042-0.271,2.149-0.918,3.024c-0.918,1.251-2.024,1.544-3.442,1.69l3.838,5.778h-1.877l-4.36-6.737h0.501
			c1.084,0,2.587-0.021,3.421-0.793c0.814-0.792,1.168-1.732,1.168-2.838c0-1.146-0.563-2.357-1.523-2.983
			c-0.772-0.5-1.732-0.563-3.129-0.563h-2.42v13.915h-1.731V14.273z"/>
        <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M71.214,29.709h-1.856l6.446-15.436h1.668l6.384,15.436h-1.877l-1.794-4.339h-7.197L71.214,29.709z
			 M76.576,16.213l-3.066,7.739h6.154L76.576,16.213z"/>
        <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M96.623,27.164l-0.021-12.891h1.668v15.436h-1.668l-9.158-12.996l0.042,12.996h-1.669V14.273h1.752
			L96.623,27.164z"/>
        <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M114.39,18.277c-0.482-0.667-1.066-1.23-1.734-1.67c-1-0.688-2.21-1.083-3.587-1.083
			c-3.38,0-6.321,2.586-6.321,6.446c0,3.922,2.963,6.509,6.342,6.509c1.627,0,3.066-0.563,4.131-1.397
			c1.083-0.857,1.835-2.023,2.085-3.235h-7.677v-1.418h9.681c-0.021,0.896-0.23,2.023-0.689,2.983
			c-1.336,2.9-4.423,4.589-7.531,4.589c-4.506,0-8.073-3.462-8.073-8.03c0-4.632,3.63-7.97,8.095-7.97
			c3.129,0,6.027,1.752,7.24,4.277H114.39z"/>
        <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M137.747,14.273h1.732v13.913h7.551v1.523h-9.283V14.273z"/>
        <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M148.937,14.273h1.711v15.436h-1.711V14.273z"/>
    </g>
    <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M127.333,14.002c-4.236,0-8.102,3.115-8.102,8.141v0.021c0,3.946,3.24,7.788,8.078,7.788
		c4.779,0,8.143-3.695,8.143-7.974C135.452,17.699,132.067,14.002,127.333,14.002z M128.569,26.721l-1.248,2.153l-1.256-2.192
		c-2.063-0.61-3.271-2.622-3.271-4.75V21.91c0-2.348,1.602-4.88,4.559-4.88c3.074,0,4.539,2.778,4.539,4.948
		C131.892,23.824,130.804,26.118,128.569,26.721z"/>
</g>
                                <g>
                                    <path fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" d="M8,22l7.408,12.95L22.919,22h-7.512H8z M15.415,32.852l-5.608-9.804H21.1L15.415,32.852z"/>
                                    <polygon fill="<?php if(!$logged_in) { echo '#A2853F';}else{echo '#FFFFFF';} ?>" points="8,9.051 15.408,22 22.919,9.051 	"/>
                                </g>
</svg>

                        </a>
                        <span class="menu_arrow active">
                        <?php if(!$logged_in){?>
                            <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/grey-arrow.png" />
                        <?php } else{?>
                            <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/arrow.png" />
                        <?php } ?>
                        </span>
                    </div>
                    <div class="rangoli_menu_links">
                    <?php
                        wp_nav_menu( array( 'theme_location' => 'menu1_mobile', 'container_class' => 'category-menu' ) );
                        wp_nav_menu( array( 'theme_location' => 'menu2_mobile', 'container_class' => 'category-menu_mobile' ) );
                    ?>
                    </div>
                    <div class="line"></div>
                </div>
            </div>
        </div>

    </div>

<!-- --------------- -->

<div class="page_heading">
    <?php
    $page ="";
    if(is_home()){?>
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
' ;?>
    <?php
    }
    else if(is_page()) {
        $page = strtoupper(get_the_title());
    }
    else {
        $post = get_post();
        if($post->post_type=="post" && $post->post_status=="publish" ){
            if(has_category("read",$post)){
                $page = "READ";
            }
            else if(has_category("look",$post)){
                $page = "LOOK";
            }
            else if(has_category("learn",$post)){
                $page = "LEARN";
            }
        }
    }
    ?>
    <div>

        <?php if(!$logged_in){ ?>
        <span class="open_signin">Sign In</span>
        <?php } else { ?>
            <span class="smogi_bucks"><?php $user_id = get_current_user_id(); echo "<i>$</i>".get_user_smogi_bucks($user_id);  ?> </span>
        <?php } ?>
        <span class="page_name">
            <?php
            if($page=="JOURNEY"){
                $page= "STEP 1 OF 2";
            }
            else if(is_author()){
                $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
                $user_id=$curauth->ID;
                $user_info=get_userdata($user_id);
                $page = strtoupper($user_info->display_name);
            }
            echo $page;
            ?></span>
        <?php if(is_page("read") || is_page("look") || is_page("learn") ){ ?>
        <span class="open-filter"></span>
        <span class="close-filter"></span>
        <?php } ?>
    </div>
    <?php if($page=="READ" || $page=="LOOK" || $page=="LEARN" ){ ?>
    <?php echo filter(); ?>
    <?php } ?>
</div>
<div style="padding: 44px; "></div>
<?php
/*if(!is_home() && is_page()){
*/?><!--
<div style="padding: 44px; "></div>
--><?php
/*}*/
if(!is_user_logged_in() && is_home()){
?>
<div class="signup-signin-block">
    <span class="open_signin">SIGN IN</span>
    <span class="open_signup">SIGN UP</span>
</div>
<?php
}
?>