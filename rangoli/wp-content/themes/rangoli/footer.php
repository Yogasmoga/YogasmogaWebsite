</div>
</div>
<?php
$style= "";
if(!is_user_logged_in()) {
    $style = "margin-top:25px;";
}

if(!isset($ipInfo)){

    $root = ABSPATH;

    include_once($root . '/Ipinfo/Host.php');
    include_once($root . '/Ipinfo/Ipinfo.php');

    $ipInfo = new Ipinfo\Ipinfo();

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    $host = $ipInfo->getFullIpDetails($ip);

    if (isset($host)) {
        $request_city = $host->getCity();
        $request_state = $host->getRegion();
        $request_zip = $host->getPostal();
    }
    else {
        $request_city = "N/A";
        $request_state = "N/A";
        $request_zip = "N/A";
    }
}

?>
<!-- ------------------------------------------------- -->
<div id="popup" class="user-color-shade" style="<?php echo $style; ?>">

    <img src="<?php bloginfo('template_directory') ?>/images/close.png" class="right close-popup" />
    <div id="stores">

            <div class="row" style="text-align: center;">
                <div class="main-content row">
                    <div class="entry-header">

                    </div>
                    <div class="smogi-list row">

                        <?php
                        get_template_part("content","stores");
                        ?>

                    </div>

                </div>
            </div>
    </div>
    <!-- stores end here ------ -->
    <div class="row" id="smogis" style="text-align: center;">
        <div class="main-content row">
            <div class="entry-header">

            </div>
            <div class="smogi-list row">
                <?php
                get_template_part("content","smogi");
                ?>
            </div>

        </div>
    </div>



    <div class="row" id="invite_friend" style="text-align: center;">
        <div class="main-content row">
            <div class="entry-header">

            </div>
            <div class="smogi-list row">
                <?php
                get_template_part("invite","friend");
                ?>
            </div>

        </div>
    </div>

    <div class="row" id="connect" style="text-align: center;">
        <div class="main-content row">
            <div class="entry-header">

            </div>
            <div class="smogi-list row">
                <?php
                get_template_part("connect");
                ?>
            </div>

        </div>
    </div>

</div>

<div id="signin_popup">
    <?php
    $root = get_site_url();
    $root = str_replace("/rangoli","/",$root);
    ?>

    <!--<div class="signin-block" style="background: url('<?php echo get_site_url()."/wp-content/themes/rangoli/images/red_popup.png" ?>') no-repeat;">

        <div class="close_signin_popup" ></div>
        <div class="form">
            <form id="sign-up-form">
                <input type="hidden" id="p_location_city" name="location_city" value="<?php echo $request_city;?>"/>
                <input type="hidden" id="p_location_state" name="location_state" value="<?php echo $request_state;?>"/>
                <input type="hidden" id="p_location_zip" name="location_zip" value="<?php echo $request_zip;?>"/>
            <input name="" data-watermark="First Name" id="p_fname"/>
            <input data-watermark="Last Name" id="p_lname" />
            <input data-watermark="Email Address" id="p_signup_email" />
            <input data-watermark="Select a password" rel="password" id="p_s_password" />
                <p class="gender_p gender_popup">Select Gender <span><input type="radio" name="gender" value="1" />M</span>  <span><input type="radio" name="gender" value="2" />F</span> </p>
                <img class="loader" src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px; display:none;' />
            <input id="signup" type="button" value="Sign up"  />
                <div class="err-msg" style="color:#fff !important"></div>
            </form>
            <div class="align-center" style=" color:#ff9f9f; font-size: 13px; letter-spacing: 1px; font-family: ITCAvantGardeStd-Bk">
                Already signed up?<br/><a style="cursor: pointer;" onclick="$('.login_logout_link').click();">Sign in here</a>
            </div>
        </div>
    </div>-->
	<!------------------------------mailchimp signup form------------------------------>
	<div id="signup-box" class="mc-signup">
	<div class="close_signin_popup" ></div>
	<div class="signup-content">
		<p class="signup-title">
			<span class="spn_line"><span class="strong">SIGN Up Now</span> To Instantly Get</span>
			<span class="spn_line"><span class="highlight">50% OFF</span> Your First Order</span>
		</p>
		<small>Your Email Address</small>
		<p><input type="text" placeholder="Email Address"/></p>
		<p><input type="submit" value="Sign Up"/></p>
		<p style="margin: 0px auto; font-size: 12px; visibility: hidden; min-height: 20px; width: 236px;" id="err-msg">All fields are required.</p>
	</div><!--signup-content-->
	<div id="thank_you_box" class="signup-thankyou">
		<p class="signup-title">
			<span class="spn_line"><span class="strong">Thank You! Your Special Code is:</span></span>
			<span class="spn_line"><span class="highlight">SMOGILOVE</span></span>
		</p>
		<small>We've also emailed it to you in case you forget.</small>
		<p class="mc-shoplinks">
			<a href="/women"><img src="<?php echo get_stylesheet_directory_uri().'/images/mc-shopwomen.jpg' ?>" alt=""/></a>
			<a href="/men"><img src="<?php echo get_stylesheet_directory_uri().'/images/mc-shopmen.jpg' ?>" alt=""/></a>
		</p>
		
	</div><!--signup-thankyou-->
</div>
<!------------------------------mailchimp signup form end------------------------------>
	
    <div class="your-color-block" style="background: url('<?php echo get_site_url(); ?>/wp-content/themes/rangoli/images/random-color.png') no-repeat; background-size:100%; background-position: 4px -2px; ">
        <div class="close_signin_popup" ></div>
        <div class="color-traingle">
            <?php
                 if(is_user_logged_in()){
                     $userID = get_current_user_id();
                     $userInfo = get_userdata($userID);
                     $user_level = get_user_level($userID);
                     $userProfile = get_user_profile($userID);
                     $main_color = $userProfile->color_main;

            ?>
                    <span class='charmBig charmBig<?php echo $user_level;?> Charmsbigcolor_<?php echo $main_color; ?>'></span>
            <?php
                }
            ?>
        </div>
        <a class="change-color" href="<?php echo get_site_url()?>/journey" ><img src="<?php echo get_site_url(); ?>/wp-content/themes/rangoli/images/change-color.png" /></a>
    </div>
    <div class="login-box">
        <div class="close_signin_popup" ></div>
        <div class="wrapper">
            <div class="sign-up left-shift">
                <h2 class="align">New to YOGASMOGA</h2>

                <form method="post" action="" id="sign-up-form" class="form-1">
                    <input type="hidden" id="location_city" name="location_city" value="<?php echo $request_city;?>"/>
                    <input type="hidden" id="location_state" name="location_state" value="<?php echo $request_state;?>"/>
                    <input type="hidden" id="location_zip" name="location_zip" value="<?php echo $request_zip;?>"/>

                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td>
                                <input type="text" class="register_new" maxlength="30" value="" data-watermark="First Name" class="watermark"
                                       name="fname" id="fname">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text"  class="register_new" maxlength="30" value="" data-watermark="Last Name" class="watermark"
                                       name="lname" id="lname">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" autocapitalize="off" class="register_new"  value="" autocomplete="off" data-watermark="Email"
                                       class="watermark" id="signup_email" name="signup_email">
                            </td>
                        </tr>
                        <tr class="fake_password">
                            <td class="inputholder">
                                <input type="text" defaulterrormsg="Password is required" class="register_new"  name="password"
                                  id="s_password"     data-watermark="Select a password"  rel="password"  class="watermark f_password" maxlength="30"
                                       autocomplete="off">
                            </td>
                        </tr>

                        <tr>
                            <td ><p class="gender_p">Select Gender <span><input type="radio" name="gender" value="1"/>M</span> <span><input type="radio" name="gender" value="2"/>F</span></p></td>

                        </tr>
                        <tr>
                            <td class="no-padding">
                                <input type="button" value="" id="sign-up-button">
                            </td>
                            <td align="center" class="form-loader no-padding c-align"></td>
                        </tr>
                        <tr>
                            <td style="padding: 0px;">
                                <p class="err-msg signup_err" style="min-height: 15px; margin: 0px auto; visibility: hidden;font: 12px ITCAvantGardeStd-Bk !important;line-height: 15px !important;">
                                    All fields are required.</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="sign-in left-shift">
                <h2 class="align">Already a SMOGI</h2>

                <form method="post"  class="bl form-1" id="sign-in-form">
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td>
                                <input type="text" value="" data-watermark="Email"  name="si_email"  class="login_magento"
                                       id="si_email">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text"   rel="password"  name="pwd" data-watermark="Password"  class="login_magento"  class="" id="si_password" >
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <a href="/customer/account/forgotpassword" class="forgot">Forgot your
                                    password?</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-padding">
                                <input type="button" value="" id="sign-in-button">
                            </td>
                            <td align="center" class="form-loader no-padding c-align"></td>
                        </tr>
                        <tr>
                            <td style="padding: 0px;">
                                <p class="err-msg"
                                   style="min-height: 15px; margin: 0px auto; visibility: hidden;font: 12px ITCAvantGardeStd-Bk !important;line-height: 15px !important;">All fields
                                    are required.</p>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
//the_block('footer');
?>
<div class="footer row">
    <div class="side-logo">
        <a class="logo" href="/" style="padding-left:5px">
            <img src="<?php bloginfo('template_directory')  ?>/images/ys_logo.png" alt="logo_footer" />
        </a>
        <div class="clear-fix"></div>
    </div>
    <div class="footer-right">
        <div class="first-list">
            <li>
                <ul>
                    <li><a href="/women">SHOP WOMEN</a></li>
                    <li><a href="/mens">SHOP MEN</a></li>
                    <li>&nbsp;</li>
                    <li><a href="/help#size-chart">SIZE CHARTS</a></li>
                    <li><a href="/help#product-care">PRODUCT CARE</a></li>
                </ul>
            </li>
            <li>
                <ul>
                    <li><a href="/our-story">YS STORY</a></li>
                    <li><a href="/ys-fabric-tech">YS TECH</a></li>
					<li><a href="/our-stores">YS STORES</a></li>
                    <li><a href="/smogi-bucks">SMOGI BUCKS</a></li>
                    <li><a href="/namaskar">NAMASK&Aacute;R FOUNDATION</a></li>
                </ul>
            </li>
            <li>
                <ul>
                    <li><a href="/customer/account/index">MY ACCOUNT</a></li>
                    <li><a href="/gift_of_ys">GIFT CARD</a></li>
                    <li><a href="/sales/order/history">TRACK MY ORDER</a></li>
                </ul>
				 <ul style="padding-top:14px;">
                        <li><span class="bold-heading" style="font-family:gothambold;" >JOIN US</span></li>
                        <li><a href="/careers">CAREERS</a></li>
                    </ul>
            </li>
        </div>
        <div class="first-list contact-us">
            <li>
                <ul>
                    <li><a class="bold-heading" href="mailto:hello@yogasmoga.com">CONTACT US</a></li>
                    <li>888-990-YOGA (9642)</li>
                    <li><a href="mailto:hello@yogasmoga.com ">HELLO@YOGASMOGA.COM</a></li>
                    <li><a href="javascript:void($zopim.livechat.window.show())">LIVE CHAT</a> <span class="chat-status"> online now</span></li>
                    <li><a href="/help#faq">FAQ</a></li>
                </ul>
            </li>
            <li>

                <ul>


                </ul>

                <ul>
                    <?php
                    if(!is_user_logged_in()){
                        ?>
                    <li><a class="bold-heading" href="javascript:void(0)">FEEL THE SMOGI LOVE</a></li>

                    <li>Sign up and earn 50% Off on your first order.</li>
                    <?php
                    }
                    else{
                    ?>
                    <li><a class="bold-heading" href="javascript:void(0)">SMOGI BUCKS</a></li>
                    <li> You currently have <?php $userID=get_current_user_id(); echo get_user_smogi_bucks($userID);  ?> SMOGI Bucks<br/>
                        to use toward your order.</li>
                    <?php
                    }
                    ?>
                </ul>

            </li>
            <li>
                <ul>
                    <li class="bold-heading">STAY IN TOUCH</li>
                    <li>
                        <ul class="social-icons">
                            <li><a target="_blank" class="fb-icon" href="http://www.facebook.com/YOGASMOGA"></a></li>
                            <li><a target="_blank"  class="twtr-icon" href="http://www.twitter.com/YOGASMOGA"></a></li>
                            <li><a target="_blank"  class="insta-icon" href="http://www.instagram.com/YOGASMOGA"></a></li>
                            <li><a  target="_blank" class="pin-icon" href="http://www.pinterest.com/YOGASMOGA"></a></li>

                        </ul>
                    </li>
                    <li>&nbsp;</li>
                    <li><a class="bold-heading" href="javascript:void(0);">SHARE WITH YOUR FRIENDS</a></li>
                </ul>
            </li>
        </div>
        <div class="privacy">
            <ul>
                <li>Copyright &copy; 2015 YOGASMOGA. All Rights Reserved. </li>
                <li> | </li>
                <li><a href="/privacy-policy/">Privacy Policy</a></li>
                <li> | </li>
                <li><a href="/terms-and-conditions/">Terms &amp; Conditions</a></li>
                <li>&nbsp;</li>
                <li>&nbsp;</li>
                <li >
                    <iframe id="fb-like-btn" src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fyogasmoga.com&amp;width&amp;layout=button&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=80&amp;appId=647531145339855" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:20px;width:49px;" allowTransparency="true"></iframe>
                </li>
                <li>&nbsp;</li>
                <li ><a target="_blank" href="https://twitter.com/intent/follow?original_referer=YOGASMOGA.COM%2Fblog%2Fxmlrpc.php&region=follow_link&screen_name=yogasmoga&tw_p=followbutton&variant=2.0">
                        <img src="http://d1iorz83055o8x.cloudfront.net/skin/frontend/new-yogasmoga/yogasmoga-theme/images/footer/64x20xtwtr-sml.jpg.pagespeed.ic.bz-wWsqdpc.jpg">
                    </a>
                </li>
                <li>&nbsp;</li>
                <li ><img src="http://d1iorz83055o8x.cloudfront.net/skin/frontend/new-yogasmoga/yogasmoga-theme/images/footer/50x20xpaypal-sml.jpg.pagespeed.ic.BUgdB7cQsT.jpg" style="height:20px; width:50px;"></li>


            </ul>
        </div>

    </div>
</div>
<!-- ///////////////////////////////  Bullseye Random popup //////////////////////////////////// -->
<div class="bullseye_popup_container">
    <div class="bullseye_popup" >
    </div>
    <div class="center_popup mc-center-popup">
        <section class="random_popup_container">
            <div id="card">
                <div class="front">
                    <img src="" usemap="#open_popup" />
<!--                    <a  style="cursor:pointer; border-radius: 50%; position: absolute; top:0; left:0; right:0; bottom:0;" onclick="flip();"></a>-->
                    <map name="open_popup">
                        <area shape="circle" coords="235,235,235" onclick="flip()">
                    </map>
                </div>
                <div class="back">
                    <!-- --------------------------------------SIGNUP POPUP---------------------------- -->
                    <div id="ap_signin_popup">

                    <div class="signin-block" style="background: url('<?php echo get_site_url()."/wp-content/themes/rangoli/images/red_popup.png" ?>') no-repeat;">
                            <div class="close" ></div>

                            <div class="form">
                                <form id="ap_sign-up-form">
                                    <input type="hidden" id="ap_location_city" name="location_city" value="<?php echo $request_city;?>"/>
                                    <input type="hidden" id="ap_location_state" name="location_state" value="<?php echo $request_state;?>"/>
                                    <input type="hidden" id="ap_location_zip" name="location_zip" value="<?php echo $request_zip;?>"/>
                                    <input name="" data-watermark="First Name" id="ap_fname"/>
                                    <input data-watermark="Last Name" id="ap_lname" />
                                    <input data-watermark="Email Address" id="ap_signup_email" />
                                    <input data-watermark="Select a password" rel="password" id="ap_s_password" />
                                    <p class="gender_p gender_popup">Select Gender <span><input type="radio" name="gender" value="1" />M</span>  <span><input type="radio" name="gender" value="2" />F</span> </p>
                                    <img class="loader" src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px; display:none;' />
                                    <input id="ap_signup" type="button" value="Sign up"  />
                                    <div class="err-msg"></div>
                                </form>
                                <div class="align-center" style=" color:#ff9f9f; font-size: 13px; letter-spacing: 1px; font-family: ITCAvantGardeStd-Bk">
                                    Already signed up?<br/><a style="cursor: pointer;" onclick="$('.close').click(); $('.login_logout_link').click();">Sign in here</a>
                                </div>
                            </div>

                        </div>
                        <!-- ------------------------------------------------------------------------------------ -->
						
                </div>
				
            </div>
        </section>
    </div>
</div>



<script type="text/javascript">
    window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
        $.src='//v2.zopim.com/?2Fg0V06nbC3ddKB1tNUN3VPXPE7wA7eV';z.t=+new Date;$.
            type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');

    jQuery(document).ready(function ($) {
        $zopim(function () {
            $zopim.livechat.button.setPosition('bl');
            $zopim.livechat.window.setPosition('bl');
            $zopim.livechat.setOnStatus(bubble);
        });
    });
    function bubble(status) {
        var img_offline = '<img class="online-status-icon" src="/skin/frontend/new-yogasmoga/yogasmoga-theme/images/footer/offline.png" alt="Offline">';
        var img_online = '<img class="online-status-icon" src="/skin/frontend/new-yogasmoga/yogasmoga-theme/images/footer/online.png" alt="Online">';
        if (status == "offline") {
            $(".chat-status").html(img_offline + ' ' + "Offline now");
        }
        else {
            $(".chat-status").html(img_online + ' ' + "Online now");
        }
    }
</script>


</body>
</html>