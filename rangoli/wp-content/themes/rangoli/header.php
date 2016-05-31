<?php
    /*header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");*/

    if(is_ssl()) {
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        header("location: ".$url);
    }
?>
<!DOCTYPE HTML>
<head>
    <link rel="shortcut icon"   href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
    <?php
    if(is_home()){
        ?>
            <title>Rangoli: The YOGASMOGA Community</title>
            <meta property="og:title" content="Rangoli: The YOGASMOGA Community" />
            <meta property="og:description" content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community." />
            <meta property="description" content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community." />
        <?php
    }
    else if(is_page("read")){
        ?>
        <title>Read | Rangoli: The YOGASMOGA Community</title>
        <meta property="og:title" content="Read | Rangoli: The YOGASMOGA Community" />
        <meta property="og:description" content="Our READ section features a curated selection of health & wellness related articles, op-eds, editorial, recipes, biographies, interviews and more. Your brain will love you for it. Rangoli: The YOGASMOGA Community." />
        <meta property="description" content="Our READ section features a curated selection of health & wellness related articles, op-eds, editorial, recipes, biographies, interviews and more. Your brain will love you for it. Rangoli: The YOGASMOGA Community." />
        <?php
        }
    else if(is_page("look")){
        ?>
        <title>Look | Rangoli: The YOGASMOGA Community</title>
        <meta property="og:title" content="Look | Rangoli: The YOGASMOGA Community" />
        <meta property="og:description" content="Discover our Look section and browse through photography, slideshows, and more awe-inspiring imagery that revolve around health & wellness. Pictures are worth 1000 words and our Look section will give you plenty to talk about. Rangoli: The YOGASMOGA Community." />
        <meta property="description" content="Discover our Look section and browse through photography, slideshows, and more awe-inspiring imagery that revolve around health & wellness. Pictures are worth 1000 words and our Look section will give you plenty to talk about. Rangoli: The YOGASMOGA Community." />
        <?php
        }
    else if(is_page("learn")){
        ?>
        <title>Learn | Rangoli: The YOGASMOGA Community</title>
        <meta property="og:title" content="Learn | Rangoli: The YOGASMOGA Community" />
        <meta property="og:description" content="Learn how to hit that yoga pose with video tutorials from our beloved SMOGIs. Whether you’re a beginner or a seasoned yogi, our SMOGIs will guide you step-by-step with each pose, adjustment, inhale and exhale. Rangoli: The YOGASMOGA Community." />
        <meta property="description" content="Learn how to hit that yoga pose with video tutorials from our beloved SMOGIs. Whether you’re a beginner or a seasoned yogi, our SMOGIs will guide you step-by-step with each pose, adjustment, inhale and exhale. Rangoli: The YOGASMOGA Community." />
        <?php
        }
    else if(is_404()){
       ?>
        <title>404 | Rangoli: The YOGASMOGA Community</title>
        <meta property="og:title" content="404 | Rangoli: The YOGASMOGA Community" />
        <meta property="og:description" content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community." />
        <meta property="description" content="Rangoli: A journey of culture, conversation, and connection. Read, look, and learn as you discover ideas about health & wellness that keep the essence of yoga in mind. Join The YOGASMOGA Community." />
    <?php
    }
    else if(is_author()){
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
        else if($author_name =="YOGASMOGA TOWNHOUSE") {
            ?>
            <meta property="og:title" content="YOGASMOGA Townhouse | Rangoli: The YOGASMOGA Community"/>
            <meta property="og:description" content="We chose this two-story townhouse on Greenwich Avenue as our first store for its strong feel of community. The exposed brick walls create a cozy atmosphere and neutral palate for our bright collections. We are currently renovating the upstairs space for yoga classes and other wellness events."/>
            <meta property="description" content="We chose this two-story townhouse on Greenwich Avenue as our first store for its strong feel of community. The exposed brick walls create a cozy atmosphere and neutral palate for our bright collections. We are currently renovating the upstairs space for yoga classes and other wellness events."/>
        <?php
        }
        else if($author_name =="YOGASMOGA HQ") {
            ?>
            <meta property="og:title" content="YOGASMOGA HQ | Rangoli: The YOGASMOGA Community"/>
            <meta property="og:description" content="We are YOGASMOGA. Designed in NYC. Made in USA. We make things for life, one breath at a time."/>
            <meta property="description" content="We are YOGASMOGA. Designed in NYC. Made in USA. We make things for life, one breath at a time."/>
        <?php
        }
    }
    else if(is_page("about")){
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


    <?php
        $root = get_site_url();
        $root = str_replace("/rangoli","/",$root);
    ?>
	<?php
		// for rangoli press
		$rangoliPressType = 0;
		if(is_singular('rangoli-press'))
		$rangoliPressType = 1;
	?>
    <script>
		var rangoli_press_type = <?php echo $rangoliPressType; ?>;
        var user_color_shade;
        var  homeUrl="<?php echo $root ?>";
        var today_date="<?php echo date("j.m.y", time()) ?>";

        (function(d) {
            var config = {
                    kitId: 'hhs7njj',
                    scriptTimeout: 3000
                },
                h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
        })(document);

    </script>

    <?php
      //  the_block('head');
    ?>
    <script src="<?php bloginfo('template_directory')?>/js/min/jquery.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/min/jquery.flexslider.js" ></script>

    <?php if(false){ ?>
    <!--<script src="<?php bloginfo('template_directory')?>/js/min/ajaxify.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/min/zeroClipboard.js" ></script>-->
    <?php } ?>
    <script data-pace-options='{ "ajax": true }'  src="<?php bloginfo('template_directory')?>/js/min/pace.min.js" ></script>

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url')  ?>" />
    <link rel="stylesheet" href="<?php bloginfo('template_directory')  ?>/css/custom.css" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory')  ?>/css/flexslider.css" />
    <link rel="stylesheet" href="<?php bloginfo('template_directory')  ?>/css/animation.css" />
    <link rel="stylesheet" href="<?php bloginfo('template_directory')  ?>/css/header.css" />
    <link rel="stylesheet" href="<?php  bloginfo("template_directory")  ?>/css/rangoli.css" />

    <?php if(false){ ?>
        
        <link rel='stylesheet' href="<?php bloginfo('template_directory'); ?>/css/homepage.css" />
        <link rel="stylesheet" href="<?php  bloginfo("template_directory")  ?>/css/rangoli_v1.css" />
        <link rel="stylesheet" href="<?php bloginfo('template_directory')  ?>/css/mystyle.css" />
        <link rel="stylesheet" href="<?php  bloginfo("template_directory")  ?>/css/jquery.raty.css" />
        <link rel="stylesheet" href="<?php  bloginfo("template_directory")  ?>/css/pace.css" />
    <?php } ?>

    <?php
        if(is_front_page()){
    ?>
        <script src="<?php bloginfo('template_directory')?>/js/min/homepage.js" ></script>

    <?php } ?>

    <script src="<?php bloginfo('template_directory')?>/js/combined.js" ></script>
    <?php if(false){ ?>
        <script src="<?php bloginfo('template_directory')?>/js/custom.js" ></script>
        <script async src="<?php bloginfo('template_directory')?>/js/min/smogi.js" ></script>
        <script async src="<?php bloginfo('template_directory')?>/js/min/rangoli.js" ></script>
        <script async src="<?php bloginfo('template_directory')?>/js/min/magento_signin.js" ></script>
        <script async src="<?php bloginfo('template_directory')?>/js/min/jquery.raty.js" ></script>
    <?php } ?>
	<?php 
	 
	if( $post->ID == 8987 ) {
		echo 'text to output goes here';
	}
	?>
</head>
<body>

<?php
$style= "";
if(!is_user_logged_in()){
    $style= "margin-top:25px;";
    echo "<style>
        .pace .pace-progress {
            top:95px;
        }
    </style>";
?>
<div class="banner" style="cursor:pointer" onclick="open_red_popup()">
    SIGN UP & GET $25 SMOGI BUCKS
</div>
<?php

}
?>
<div class="header-container" style="<?php echo $style; ?>">
    <div class="header">
        <div class="header-left">
            <div class="header-left logo">
                <a class="logo menu-heading menu-heading1" href="/"><img src="<?php  echo get_site_url(); ?>/wp-content/themes/rangoli/images/ys_logo.png"></a>
            </div>
            <ul class="header-left navigation-bar main-nav">
                <li class="menu-heading"><a class="menu-heading " href="/women">Women</a>
                    <ul class="sub-menu menu-ovr ">
                        <li>
                            <ul>
                                <li><a href="/women/whats-new"> What's New</a></li>
                                <!--<li><a href="/women/one-too-many"> One 2 Many</a></li>-->
								<li><a href="/women/prints">PRINTS</a></li>
								<!--<li><a href="/women/super-sale"> Super Sale</a></li>-->
								<li><a href="/women/additional-sizes"> ADDITIONAL SIZES</a></li>
                                <li><a href="/women/vivacity-collection"> VIVACITY COLLECTION</a></li>
								<li><a href="/women/carbon6">Carbon6&trade; COLLECTION</a></li>
<!--                                <li><a href="/women/rangoli-collection"> RANGOLI COLLECTION</a></li>-->
                            </ul>
                        </li>
                        <li><a href="/women/tops"> Tops</a>
                            <ul><li><a href="/women/tops/bras">Bras</a></li>
                                <li><a href="/women/tops/tanks">Tanks</a></li>
                                <li><a href="/women/tops/tees">TEES</a></li>
                                <li><a href="/women/tops/sweaters">SWEATERS</a></li>
                                <li><a href="/women/tops/jackets">Jackets</a></li>
<!--                                <li><a href="/women/tops/rangoli">Rangoli</a></li>-->
                            </ul>
                        </li>
                        <li><a href="/women/bottoms"> Bottoms</a>
                            <ul>
                                <li><a href="/women/bottoms/shorts">Shorts</a></li>
                                <li><a href="/women/bottoms/crops">Crops</a></li>
                                <li><a href="/women/bottoms/leggings">Leggings</a></li>
                                <li><a href="/women/bottoms/pants">Pants</a></li>
<!--                                <li><a href="/women/bottoms/rangoli">Rangoli</a></li>-->
                            </ul>
                        </li>
                        <li><a href="/women/accessories"> Accessories </a>
                            <ul>
                                <li><a href="/women/accessories/scarves">Scarves</a></li>
                                <!--<li><a href="/women/accessories/head-bands">Head Bands</a></li>-->
<!--                                <li><a href="/women/accessories/yoga-mats">Yoga Mats</a></li>-->
<!--                                <li><a href="/women/accessories/yoga-towels">Yoga Towels</a></li>-->
                                <li><a href="/women/accessories/yoga-flops">Yoga Flops</a></li>
                                <li><a href="/women/accessories/namaskar-bracelets">Namaskár Bracelets</a></li>
								<li><a href="/women/accessories/bags">Bags</a></li>
                            </ul>
                        </li>
                    </ul>

                </li>
                <li class="menu-heading"><a class="menu-heading " href="/mens">Men</a>
                    <ul class="sub-menu menu-ovr second-list">
                        <li>
                            <ul>
                                <li><a href="/men/whats-new"> What's New</a></li>
								<li><a href="/men/carbon6">Carbon6&trade; COLLECTION</a></li>
								<!--<li><a href="/men/super-sale"> Super Sale</a></li>-->
<!--                                <li><a href="/mens/top-sellers"> Top Sellers</a></li>-->
                            </ul>
                        </li>

                        <li><a href="/men/tops"> Tops</a>
                            <ul>
                                <li><a href="/men/tops/tees">Tees</a></li>
                                <li><a href="/men/tops/tanks">TANKS</a></li>
                                <li><a href="/men/tops/jackets">Jackets</a></li>
                            </ul>
                        </li>
                        <li><a href="/mens/bottoms"> Bottoms</a>
                            <ul>
                                <li><a href="/men/bottoms/shorts">Shorts</a></li>
                                <li><a href="/men/bottoms/pants">Pants</a></li></ul>
                        </li>
                        <li><a href="/men/accessories"> Accessories</a>
                            <ul>
<!--                                <li><a href="/mens/accessories/yoga-mats">Yoga Mats</a></li>-->
<!--                                <li><a href="/mens/accessories/yoga-towels">Yoga Towels</a></li>-->
                                <li><a href="/men/accessories/namaskar-bracelets">Namaskár Bracelets</a></li>
								<li><a href="/men/accessories/bags">Bags</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
				<!--<li class="gift-sets" rel="70">
						<a href="/gift-sets" class="menu-heading">Gift Sets</a>
							<ul class="sub-menu menu-ovr">
								<li><ul>
										<li class="gift"><a href="/gift-sets?style=women">Women</a></li>
										<li class="gift"><a href="/gift-sets?style=men">Men</a></li>
									</ul>
								</li>
							</ul>
				</li>-->
            </ul>
        </div>
        <div class="f-right header-right">
            <div class="right-top r-align">
                <ul class="shipping-menu tr-menu">
                    <li class="free-shipping">
                        <span>Free shipping to US and Canada
                            <span>
                                <cite class="fs-icon1">flag</cite>
								<cite class="fs-icon2">flag</cite>
								<cite class="fs-icon3">globe</cite>
								<!--<img src="<?php //  echo get_site_url(); ?>/wp-content/themes/rangoli/images/index.png">
								<img src="<?php //  echo get_site_url(); ?>/wp-content/themes/rangoli/images/index1.png">
								<img src="<?php //  echo get_site_url(); ?>/wp-content/themes/rangoli/images/index3.png">-->
							</span>
                        </span>
                    </li>
                    <li data-blockid="help-new">
                        <a href="/help#faq">Help</a>
                        <span>|</span>
                        <ul style="left: -87px;" class="sub-menu l-align cms-header-link">
                            <li class="blank"></li>
                            <li data-blockid="faq" style="padding-top: 16px;"><a href="/help#faq">FAQ</a></li>
                            <li data-blockid="shipping-returns"><a href="/help#shipping-returns">Shipping and Returns</a></li>
                            <li data-blockid="size-chart"><a href="/help#size-chart">Size Chart</a></li>
                            <li data-blockid="product-care"><a href="/help#product-care">Product Care</a></li>
                            <li class="last" data-blockid="email-us"><a href="/help#email-us">Email Us</a></li>
                        </ul>
                    </li>
                    <li> <a href="#" id="welcome-name">My Account</a>
                        <ul style="left: -64px;" class="sub-menu l-align my-acnt">
                            <li class="blank"></li>
                            <li style="padding-top: 16px;"><a href="/sales/order/history">track order</a></li>
                            <li><a href="/customer/account/index">account settings</a></li>
                            <li class="last login_logout_link"><a href="javascript:void(0);" id="signin">Sign In</a></li>
                        </ul>
                        <span>|</span>
                    </li>
                    <li onclick="window.location='/'"><span id="cart" class="open-cart" href="/">Shopping Bag (<span class="cartitemcount"><?php echo get_cart_count();  ?></span>)</span></li>

                </ul>
            </div>
            <div class="right-bottom-block">
                <div class="in-bl">
                    <ul class="main-nav main-nav2">
                        <li><a class="main-heading" href="/our-story">ys story</a>
                            <ul style="left:-69px;" class="sub-menu l-align cms-header-link">
                                <li><a href="/our-story">Our Story</a></li>
                                <li><a href="/our-core-values">Our core values</a></li>
                                <li><a href="/our-ethics">Our ethics</a></li>
                                <li><a href="/our-stores">Our Stores</a></li>
                                <li><a href="/made-in-usa">Made in usa</a></li>
                                <li><a href="/principles-of-yoga">Principles of yoga</a></li>
                                <li><a href="/namaskar">Namaskár Foundation</a></li>
                                <li><a href="/press">Press</a></li>
                            </ul>

                        </li>
                        <li><a class="main-heading" href="/ys-fabric-tech">ys tech</a>
                            <ul style="left:-73px;" class="sub-menu l-align cms-header-link">
                                <li><a href="/ys-fabric-tech">ys fabric tech</a></li>
                                <li><a href="/ys-color-tech">ys color tech</a></li>
                                <li><a href="/design-elements">ys design elements</a></li>
                            </ul>
                        </li>
                        <li><a class="main-heading" href="/smogi-bucks">Smogi Bucks</a>
                            <ul style="left:-57px;" class="sub-menu mlink l-align">
                                <li><a href="/smogi-bucks">what is smogi bucks</a></li>
                                <li><a href="/smogi-bucks#get-smogi-bucks">how can i get them</a></li>
                                <li><a href="/smogi-bucks#smogi-bucks-balance">smogi bucks balance</a></li>
                            </ul>
                        </li>
                        <li class="rangoli"><a id="rangoli-head" class="rangoliBlu" href="/rangoli">Rangoli</a></li>
                    </ul>
                </div>

                <div class="search-bar in-bl">
                    <form autocomplete="off" method="get" action="/catalogsearch/result/" id="search_frm">
                        <input type="text" data-watermark="Search" maxlength="200" vlogo menu-heading menu-heading1alue="Search" name="q" id="search_input" class="watermark">
                        <input type="submit" style="" value="Search" class="in-bl" id="search-btn">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- header ends here -->



</div>
<div class="body-compensator"  style="<?php echo $style; ?>"></div>
<?php
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
// Set the image size. Accepts all registered images sizes and array(int, int)
$size = 'thumbnail';

$imgURL = get_the_author_meta('cupp_upload_meta', $user_id);
$size = 'thumbnail';
if ($imgURL == ""){
    $imgURL=get_site_url() . '/wp-content/themes/rangoli/images/default.jpg';
}
$current_user = wp_get_current_user();
//$display_name = $current_user->display_name;

$profile = get_user_profile($user_id);
$display_name = $profile->user_display_name;
if($display_name==null)
    $display_name = $current_user->display_name;

?>
<span rel="logged-in-user" style="display: none;"><?php echo $display_name ?></span>
<span rel="current_user_img_url" style="display: none;"><?php echo $imgURL ?></span>
<span rel="template_directory" style="display: none;"><?php echo get_site_url() ?></span>
<span rel="post_id" style="display: none;"><?php echo $display_name ?></span>


<div class="wp_page" id="page">
    <div class="menu-btn" style="<?php echo $style; ?>">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
              x="0px" y="0px" width="30px" height="40px" viewBox="0 -4 30 60" enable-background="new 0 -4 30 60" xml:space="preserve">
        <defs>
        </defs>
        <rect fill="#555" width="30" height="5"/>
        <rect y="11" fill="#555" width="30" height="5"/>
        <rect y="22" fill="#555" width="30" height="5"/>
        </svg>
    </div>

    <div class="color-game" onclick="window.location='<?php echo get_site_url(); ?>'" style="<?php echo $style; ?>; cursor:pointer;">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
        x="0px" y="0px" width="30px" height="40px" viewBox="-0.339 -1 30 60" enable-background="new -0.339 -1 30 60" xml:space="preserve">
        <defs>
        </defs>
        <polygon fill=" #555" stroke=" #555" stroke-width="2" stroke-miterlimit="10" points="1.661,1 28.112,1 14.887,27.01 "/>
        <polygon fill="none" stroke=" #555" stroke-width="2" stroke-miterlimit="10" points="1.661,30 14.887,54.98 27.661,30 "/>
        </svg>
    </div>
    <div class="bullzai"  style="<?php echo $style; ?>">
        <img src="<?php echo get_site_url() ?>/wp-content/themes/rangoli/images/bullzai.png" />
    </div>

<div class="menu-box user-color-shade" style="background:rgba(85,85,85,0.85); <?php echo $style; ?>">
    <div class="menu-content white">
        <img src="<?php bloginfo('template_directory') ?>/images/close.png" class="right close-menu-btn" />

        <ul class="profile-links">
            <li><div id="user_info">
                    <?php
                        if(is_user_logged_in()) {
                            $current_wp_user = get_current_user_id();
                            if ($current_wp_user != 0) {
                                $user_info = get_userdata($current_wp_user);
                                $user_id = $user_info->ID;

                                $imgURL = get_the_author_meta('cupp_upload_meta', $user_id);
                                $user_profile_info=$wpdb->get_results("SELECT * FROM rangoli_user_profiles WHERE user_id=".$user_id);

                                if($user_profile_info){
                                    $user_wpdb=$user_profile_info[0];
                                    $main_color=$user_wpdb->color_main;
                                }
                                else{
                                    $main_color="";
                                }

                                $level = get_user_level($user_id);
                                $main_color=strtoupper($main_color);

                                $profileUrl = get_site_url()."/profile/?user_id=".$user_id;
                                if ($user_info->roles[0] == "smogi" || $user_info->roles[0] == "store") {
                                    $profileUrl = get_author_posts_url($user_id);
                                }



                                if ($imgURL == "") {
                                    echo '<p><a style="width: 40px" href="'.$profileUrl.'" ><img   class="profile-img-small" src="' . get_site_url() . '/wp-content/themes/rangoli/images/default.jpg" /></a>';

                                    echo '<span id="profile_charm"  class="charm color_'.$main_color.' '.$level.'"></span></p>';

                                } else {
                                    echo "<p><a style='width: 40px' href='$profileUrl' ><img src='$imgURL' class='profile-img-small' /></a>";
                                    echo '<span  id="profile_charm"    class="charm color_'.$main_color.' '.$level.'"></span></p>';
                                }
                                echo "<p class='user_name'><a  href='$profileUrl' >$display_name</a></p>";

                                if ($user_info->roles[0] == "smogi" || $user_info->roles[0] == "store" || $user_info->roles[0] == "administrator") {
                                    echo "<p><a href='" . get_site_url() . "/wp-admin/post-new.php'>POST</a></p>";
                                }
                                echo "<p><a href='" . get_site_url() . "/journey'>EDIT COLOR</a></p>";

                                echo "<p><a class='liked-ajax-load' href='/rangoli/liked'>LIKED</a></p>";

                            }
                        }
                    else{
                        ?>

                    <p><a onclick="$('.login_logout_link').click();">Sign In / Sign Up</a></p>
                    <?php
                    }
                    ?>
                </div></li>
            <li><a class="home_link" href="<?php echo get_home_url() ?>/">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  x="0px" y="0px" width="34px" height="30px" viewBox="-0.5 -0.293 34 30" enable-background="new -0.5 -0.293 34 30" xml:space="preserve">
                    <defs>
                    </defs>
                    <path fill="none" stroke="#000000" stroke-miterlimit="10" d="M23.539,12.227v14.886H0.5V12.227l11.52-11.52L23.539,12.227z   M15.06,18.72h-6.08v8.393h6.08V18.72z"/>
                    </svg>

<!--                    <img src="--><?php //bloginfo('template_directory')?><!--/images/home.png" /> -->

                </a> </li>
        </ul>
        <?php
            wp_nav_menu( array( 'theme_location' => 'menu1', 'container_class' => 'category-menu' ) );
            wp_nav_menu( array( 'theme_location' => 'menu2', 'container_class' => 'category-menu' ) );
        ?>
        <ul class="shop-yogasmoga">
            <li style="position: relative">
                <a href="/"><img class="right" src="<?php echo get_site_url() ?>/wp-content/themes/rangoli/images/ys-store.png" /></a>
                <a href="/" style="position: absolute; top:0 ; left:0; "><img class="right" src="<?php echo get_site_url() ?>/wp-content/themes/rangoli/images/ys_store_hover.png" /></a>

            </li>
        </ul>
        <ul class="about-rangoli">
            <li style="padding-right: 5px; position: relative">
                <a href="<?php echo get_site_url() ?>/about"><img class="right" src="<?php echo get_site_url() ?>/wp-content/themes/rangoli/images/about.png" /> </a>
                <a href="<?php echo get_site_url() ?>/about"  style="position: absolute; top:0 ; left:0; "><img class="right" src="<?php echo get_site_url() ?>/wp-content/themes/rangoli/images/ys_rangoli_hover.png" /> </a>

            </li>
        </ul>
    </div>
</div>
    <div class="fixed-container" id="fixed_container">
        <div>
        <!-- START OF WP CODE  -->
