<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(is_ssl()) {
    $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("location: ".$url);
}


?>
<!DOCTYPE html>
<html>
<head>
    <?php
    $home = get_site_url();
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
<span style="display: none;" class="current_user_img_url">
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
        <div class="menu_btn user-color-shade">
            <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/rangoli_logo.png" />
        </div>

        <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/yogasmoga_logo.png" />

        <span class="cart"></span>
    </div>
</div>
<!-- RANGOLI YS MENU -->
    <div class="menu-box">
        <span class="close_menu user-color-shade-trans"></span>
        <div class="menu_list user-color-shade-trans">
            <div class="side_left"></div>
            <div class="menu-container">
                <?php if(!is_user_logged_in()) { ?>
                <ul class="sign-signup">
                    <li>
                        <a href="javascript:void(0)" class="open_signup"><span></span>Sign in / Sign up</a>
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
                        <span class="menu_arrow"> <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/arrow.png" /></span>
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
                        <a href="/"><img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/yogasmoga.png" /></a>
                        <span class="menu_arrow"> <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/arrow.png" /></span>
                    </div>
                    <div class="yogasmoga_menu_links">
                        <ul>
                            <li><a href="">Men</a> </li>
                            <li><a href="">Women</a> </li>

                        </ul>
                    </div>
                    <div class="line"></div>
                </div>
                <div class="rangoli_menu">
                    <div class="main_btn">
                        <a href="<?php echo $home;?>"><img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/rangoli.png" /></a>
                        <span class="menu_arrow active"> <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/arrow.png" /></span>
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
        <?php $page = '<img src="'.$home.'/wp-content/themes/rangoli_mobile/images/rangoli_logo_dark.png" />' ;?>
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

        <?php if(!is_user_logged_in()){ ?>
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
<div style="padding: 30px; "></div>
<?php
if(!is_home() && is_page()){
?>
<div style="padding: 29px; "></div>
<?php
}
if(!is_user_logged_in() && is_home()){
?>
<div class="signup-signin-block">
    <span class="open_signin">SIGN IN</span>
    <span class="open_signup">SIGN UP</span>
</div>
<?php
}
?>