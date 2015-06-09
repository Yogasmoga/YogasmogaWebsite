<?php
$home = get_site_url();
$media = $home . "/wp-content/themes/rangoli_mobile/images/";
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
            <p class="forgot_y_p"><a href="">Forgot your password?</a></p>
            <p class="forgot_y_p open_signup"><a href="javascript:void(0);">I don't have a account here?</a></p>
            <p class="small err_msg" style="text-align: left;"></p>
            <button class="login_customer">
                <img src="<?php echo $media ?>/accept.png" />
            </button>
        </div>
    </div>
    <div class="signup_popup">
        <span class="close_signup_popup"></span>
        <p>JOIN RANG<span class="rangoli_o">O</span>LI</p>
        <p class="random">& GET $25<br/>SMOGI BUCKS</p>

        <div class="singup_form">
            <input type="text" data-watermark="First Name" name="fname" />
            <input type="text" data-watermark="Last Name" name="lname" />
            <input type="text" data-watermark="Email" name="email" />
            <input type="text" data-watermark="Select a password" rel="password" name="password" />
            <p class="gender_p">Select a Gender
                                              <span class="gender">
                                                    M<input type="radio" name="gender" value="male"/>
                                              </span>
                                              <span class="gender">
                                                    F<input type="radio" name="gender" value="female"/>
                                              </span>
            </p>

            <p class="forgot_y_p open_signin"><a href="javascript:void(0);">Already a SMOGI?</a></p>
            <p class="small err_msg" style="text-align: left"></p>
            <button class="create_account">
                <img src="<?php echo $media ?>/accept.png" />
            </button>
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

<div id="back_to_top" class="user-color-shade">

</div>

</body>
</html>