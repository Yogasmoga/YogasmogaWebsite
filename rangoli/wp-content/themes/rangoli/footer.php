</div>
</div>
<!-- ------------------------------------------------- -->
<div id="popup" class="user-color-shade">

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

<div id="welcome_popup">

        <div class="popup" style="background:#CE0D3D">
            <span class="close-popup"></span>
            <div class="content">

            </div>
        </div>

</div>


<div id="signin_popup">

    <div class="signin-block" style="background: rgba(197, 4, 52, 0.95)">
        <?php
            $root = get_site_url();
            $root = str_replace("/rangoli","/",$root);
        ?>

        <div class="close_signin_popup" ></div>
        <img alt="FEEL THE SMOGI LOVE. Sign up and get $25 SMOGI bucks toward your first order." src="<?php echo $root;  ?>skin/frontend/new-yogasmoga/yogasmoga-theme/images/sign_up_text.png" class="form-text" />
        <div class="form">
            <form id="sign-up-form">
            <input name="" data-watermark="First Name" id="p_fname"/>
            <input data-watermark="Last Name" id="p_lname" />
            <input data-watermark="Email Address" id="p_signup_email" />
            <input data-watermark="Select a password" rel="password" id="p_s_password" />
                <img class="loader" src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px; display:none;' />
            <input id="signup" type="button" value=""  />
                <div class="err-msg"></div>
            </form>
        </div>
    </div>

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
                            <td >&nbsp;</td>

                        </tr>
                        <tr>
                            <td class="no-padding">
                                <input type="button" value="" id="sign-up-button">
                            </td>
                            <td align="center" class="form-loader no-padding c-align"></td>
                        </tr>
                        <tr>
                            <td style="padding: 0px;">
                                <p class="err-msg"
                                   style="min-height:15px;  margin: 0 auto; font-size: 12px; visibility:hidden">All fields
                                    are required.</p>
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
                                <a href="/customer/account/forgotpassword" class="forgot">Forgot Your
                                    Password?</a>
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
                                   style="min-height:15px; margin: 0 auto; font-size: 12px; visibility:hidden">All fields
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


<!--<div class="video-popup">-->
<!--    <div class="close">-->
<!---->
<!--    </div>-->
<!--    <video src="" controls autoplay>-->
<!---->
<!--    </video>-->
<!---->
<!--</div>-->
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
                    <li><a href="/smogi-bucks">SMOGI BUCKS</a></li>
                    <li><a href="/namaskar">NAMASKÁR FOUNDATION</a></li>
                </ul>
            </li>
            <li>
                <ul>
                    <li><a href="/customer/account/index">MY ACCOUNT</a></li>
                    <li><a href="/gift_of_ys">GIFT CARD</a></li>
                    <li><a href="/sales/order/history">TRACK MY ORDER</a></li>
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

                    <li>Sign up for $25 SMOGI Bucks<br/> toward your first order.</li>
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
                <li><a href="/terms-of-use-and-conditions/">Terms &amp; Conditions</a></li>
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