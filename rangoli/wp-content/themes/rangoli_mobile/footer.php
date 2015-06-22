<?php
$home = get_site_url();
$media = $home . "/wp-content/themes/rangoli_mobile/images/";
$logged_in = is_user_logged_in();
?>
<?php
if(!is_user_logged_in()) {
?>
<div class="newsletter">
    <input type="text" name="subscriber_email" data-watermark="Sign up & We’ll surprise you."/>
    <button>
        <img src="<?php echo get_site_url(); ?>/wp-content/themes/rangoli_mobile/images/tick.png" />
    </button>
</div>
<?php
}
?>
<div class="row">
    <p class="copyright">&copy;2015 YOGASMOGA. All Rights Reserved.</p>
</div>
<?php
if(!is_user_logged_in()  && is_home()) {
    ?>
    <div style="padding: 29px; float: left; width: 100%;"></div>
<?php
}
?>

<!-- ------popups---- -->
<div class="popup">
    <div class="signin_popup">
        <span class="close_login_popup"></span>
        <p>ALREADY A SMOGI</p>
        <p class="gold">SIGN IN HERE</p>

        <div class="login_form">
            <input type="text" data-watermark="Email" name="email" />
            <input type="text" data-watermark="Password" rel="password" name="password" />
            <p class="forgot_y_p"><a href="javascript:void(0);">Forgot your password?</a></p>
            <p class="forgot_y_p open_signup"><a href="javascript:void(0);">I don't have an account here?</a></p>
            <p class="small err_msg" style="text-align: left;"></p>
            <button class="login_customer">
                <img src="<?php echo $media ?>/accept.png" />
            </button>
        </div>
        <div class="forgot_password_form">
            <input type="text" data-watermark="Email" name="email" />
            <p class="small err_msg" style="text-align: left;"></p>
            <button class="login_customer" id="forgot_password">
                Forgot password
            </button>
            <p class="forgot_y_p open_signin"><a href="javascript:void(0);">Login here</a></p>
        </div>
    </div>
    <div class="signup_popup">
        <span class="close_signup_popup"></span>
        <p>JOIN RANG<span class="rangoli_o" ></span>LI</p>
        <p class="random">& GET $25<br/>SMOGI BUCKS</p>

        <div class="singup_form">
            <input type="text" data-watermark="First Name" name="fname" />
            <input type="text" data-watermark="Last Name" name="lname" />
            <input type="text" data-watermark="Email" name="email" />
            <input type="text" data-watermark="Select a password" rel="password" name="password" />
            <p class="gender_p">Select a Gender
                                              <span class="gender">
                                                    M<input type="radio" name="gender" value="1" title="male"/>
                                              </span>
                                              <span class="gender">
                                                    F<input type="radio" name="gender" value="2" title="female"/>
                                              </span>
            </p>


            <p class="small err_msg" style="text-align: left"></p>
            <button class="create_account">
                <img src="<?php echo $media ?>/accept.png" />
            </button>
            <p class="forgot_y_p open_signin"><a href="javascript:void(0);">Already a SMOGI? Sign in here</a></p>
        </div>
    </div>
    <div class="after_signup_popup">
        <span class="close_after_signup_popup"></span>
        <p>THANK YOU</p>
        <p>FOR SIGNING UP</p>
        <p class="smogi_bucks_banner"><img src="<?php echo $media?>/25smogi_bucks.png" /></p>
        <p class="small">SMOGI BUCKS <br/><br/>is yours to use at <br/>YOGASMOGA.COM</p>
    </div>

</div>

<div id="back_to_top" class="<?php if($logged_in){echo 'user-color-shade';} ?>">
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
         width="44px" height="44px" viewBox="0 0 44 44" enable-background="new 0 0 44 44" xml:space="preserve">
<g>
    <g>
        <polygon fill="none" stroke="#FFFFFF" stroke-miterlimit="10" points="14.398,19.182 22.014,5.995 29.626,19.182 		"/>
        <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="22.014" y1="19.76" x2="22.014" y2="36.991"/>
    </g>
</g>
</svg>
</div>

</body>
</html>