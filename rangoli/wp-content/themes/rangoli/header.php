<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(is_ssl()) {
    $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("location: ".$url);
}
?>
<!DOCTYPE HTML>
<head>
    <title><?php bloginfo('title'); if(!is_home() && !is_author() && !is_404()){ echo ' | '.get_the_title();}  if ( is_author() ) {
            $author_obj = $wp_query->get_queried_object();
            echo ' | '.strtoupper($author_obj->display_name);
        } if(is_404()){ echo ' | 404 Page not found'; }?></title>
    <meta property="og:title" content="Rangoli" />
    <meta property="og:description" content="Rangoli - A Blog based on health and wellness." />
    <meta property="description" content="Rangoli - A Blog based on health and wellness." />

    <?php
    $root = get_site_url();
    $root = str_replace("/rangoli","/",$root);
    ?>
    <script>
        var user_color_shade;
        var  homeUrl="<?php echo $root ?>";
        var today_date="<?php echo date("j.m.y", time()) ?>";

        (function(d) {
            var config = {
                    kitId: 'xta6sbe',
                    scriptTimeout: 3000
                },
                h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
        })(document);

    </script>

    <?php
    //  the_block('head');
    ?>
    <script src="<?php bloginfo('template_directory')?>/js/jquery.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/jquery.flexslider.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/ajaxify.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/zeroClipboard.js" ></script>
    <script data-pace-options='{ "ajax": true }'  src="<?php bloginfo('template_directory')?>/js/pace.min.js" ></script>


    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url')  ?>" />
    <link rel="stylesheet" href="<?php bloginfo('template_directory')  ?>/css/custom.css" />
    <link rel="stylesheet" href="<?php bloginfo('template_directory')  ?>/css/flexslider.css" />
    <link rel="stylesheet" href="<?php bloginfo('template_directory')  ?>/css/animation.css" />
    <link rel="stylesheet" href="<?php bloginfo('template_directory')  ?>/css/header.css" />
    <link rel="stylesheet" href="<?php bloginfo('template_directory')  ?>/css/mystyle.css" />
    <link rel='stylesheet' href="<?php bloginfo('template_directory'); ?>/css/homepage.css" />
    <link rel="stylesheet" href="<?php  bloginfo("template_directory")  ?>/css/rangoli.css" />
    <link rel="stylesheet" href="<?php  bloginfo("template_directory")  ?>/css/jquery.raty.css" />
    <link rel="stylesheet" href="<?php  bloginfo("template_directory")  ?>/css/pace.css" />
    <!--    <link rel='stylesheet' href="--><?php //bloginfo('template_directory'); ?><!--/css/media.css" />-->


    <?php
    if(is_front_page()){
        ?>

        <script src="<?php bloginfo('template_directory')?>/js/jquery.flexslider.js" ></script>
        <script src="<?php bloginfo('template_directory')?>/js/homepage.js" ></script>

    <?php
    }
    ?>
    <script src="<?php bloginfo('template_directory')?>/js/custom.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/smogi.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/rangoli.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/magento_signin.js" ></script>
    <script src="<?php bloginfo('template_directory')?>/js/jquery.raty.js" ></script>

</head>
<body>


<div class="header-container">
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
                                <li><a href="/women/what-s-new"> What's New</a></li>
                                <li><a href="/women/one-too-many"> One 2 Many</a></li>
                                <li><a href="/women/additional-sizes"> ADDITIONAL SIZES</a></li>
                            </ul>
                        </li>
                        <li><a href="/women/tops"> Tops</a>
                            <ul><li><a href="/women/tops/bras">Bras</a></li>
                                <li><a href="/women/tops/tanks">Tanks</a></li>
                                <li><a href="/women/tops/tees">TEES</a></li>
                                <li><a href="/women/tops/tanks/sweaters">SWEATERS</a></li>
                                <li><a href="/women/tops/jackets">Jackets</a></li>
                            </ul>
                        </li>
                        <li><a href="/women/bottoms"> Bottoms</a>
                            <ul>
                                <li><a href="/women/bottoms/pants">Pants</a></li>
                                <li><a href="/women/bottoms/leggings">Leggings</a></li>
                                <li><a href="/women/bottoms/crops">Crops</a></li>
                                <!--                                <li><a href="/women/bottoms/shorts">Shorts</a></li>-->
                            </ul>
                        </li>
                        <li><a href="/women/accessories"> Accessories </a>
                            <ul>
                                <li><a href="/women/accessories/head-bands">Head Bands</a></li>
                                <li><a href="/women/accessories/yoga-mats">Yoga Mats</a></li>
                                <li><a href="/women/accessories/yoga-towels">Yoga Towels</a></li>
                                <li><a href="/women/accessories/yoga-flops">Yoga Flops</a></li>
                                <li><a href="/women/accessories/namaskar-bracelets">Namaskár Bracelets</a></li>
                            </ul>
                        </li>
                    </ul>

                </li>
                <li class="menu-heading"><a class="menu-heading " href="/mens">Men</a>
                    <ul class="sub-menu menu-ovr second-list">
                        <li>
                            <ul>
                                <li><a href="/mens/what-s-new"> What's New</a></li>
                                <!--                                <li><a href="/mens/top-sellers"> Top Sellers</a></li>-->
                            </ul>
                        </li>

                        <li><a href="/mens/tops"> Tops</a>
                            <ul>
                                <li><a href="/mens/tops/tees">Tees</a></li>
                                <li><a href="/mens/tops/tanks">TANKS</a></li>
                                <li><a href="/mens/tops/jackets">Jackets</a></li>
                            </ul>
                        </li>
                        <li><a href="/mens/bottoms"> Bottoms</a>
                            <ul>
                                <li><a href="/mens/bottoms/shorts">Shorts</a></li>
                                <li><a href="/mens/bottoms/pants">Pants</a></li></ul>
                        </li>
                        <li><a href="/mens/accessories"> Accessories</a>
                            <ul>
                                <li><a href="/mens/accessories/yoga-mats">Yoga Mats</a></li>
                                <li><a href="/mens/accessories/yoga-towels">Yoga Towels</a></li>
                                <li><a href="/mens/accessories/namaskar-bracelets">Namaskár Bracelets</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="f-right header-right">
            <div class="right-top r-align">
                <ul class="shipping-menu tr-menu">
                    <li class="free-shipping">
                        <span>Free shipping to US and Canada
                            <span>
                                <img src="<?php  echo get_site_url(); ?>/wp-content/themes/rangoli/images/index.png">
								<img src="<?php  echo get_site_url(); ?>/wp-content/themes/rangoli/images/index1.png">
								<img src="<?php  echo get_site_url(); ?>/wp-content/themes/rangoli/images/index3.png">                           </span>
                        </span>
                    </li>
                    <li data-blockid="help-new">
                        <a href="#">Help</a>
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
                    <li>                        <a href="#" id="welcome-name">My Account</a>
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
<div class="body-compensator"></div>
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
$display_name = $current_user->display_name;

?>
<span rel="logged-in-user" style="display: none;"><?php echo $display_name ?></span>
<span rel="current_user_img_url" style="display: none;"><?php echo $imgURL ?></span>
<span rel="template_directory" style="display: none;"><?php echo get_site_url() ?></span>
<span rel="post_id" style="display: none;"><?php echo $display_name ?></span>


<div class="wp_page" id="page">
    <div class="menu-btn">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px" y="0px" width="30px" height="40px" viewBox="0 -4 30 60" enable-background="new 0 -4 30 60" xml:space="preserve">
        <defs>
        </defs>
            <rect fill="#555" width="30" height="5"/>
            <rect y="11" fill="#555" width="30" height="5"/>
            <rect y="22" fill="#555" width="30" height="5"/>
        </svg>
    </div>

    <div class="color-game">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px" y="0px" width="30px" height="40px" viewBox="-0.339 -1 30 60" enable-background="new -0.339 -1 30 60" xml:space="preserve">
        <defs>
        </defs>
            <polygon fill=" #555" stroke=" #555" stroke-width="2" stroke-miterlimit="10" points="1.661,1 28.112,1 14.887,27.01 "/>
            <polygon fill="none" stroke=" #555" stroke-width="2" stroke-miterlimit="10" points="1.661,30 14.887,54.98 27.661,30 "/>
        </svg>
    </div>
    <div class="bullzai">
        <img src="<?php echo get_site_url() ?>/wp-content/themes/rangoli/images/bullzai.png" />
    </div>

    <div class="menu-box user-color-shade" style="background:rgba(85,85,85,0.85)">
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
                                echo "<p class='user_name'><a  href='$profileUrl' >$user_info->display_name</a></p>";

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
