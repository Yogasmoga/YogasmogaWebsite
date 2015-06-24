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
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             width="172.684px" height="25px" viewBox="0 0 172.684 25" enable-background="new 0 0 172.684 25" xml:space="preserve">
<g>
    <g>
        <g>
            <path fill="#FFFFFF" d="M68.893,3.312h4.639c2.788,0,4.086,0.335,4.999,0.913c1.442,0.866,2.428,2.764,2.428,4.783
				c0.023,1.201-0.313,2.476-1.058,3.484c-1.058,1.441-2.332,1.779-3.965,1.948l4.422,6.657h-2.163l-5.023-7.763h0.577
				c1.25,0,2.98-0.024,3.942-0.913c0.938-0.913,1.346-1.995,1.346-3.27c0-1.32-0.649-2.716-1.755-3.437
				c-0.89-0.576-1.995-0.649-3.604-0.649h-2.789v16.032h-1.995V3.312z"/>
            <path fill="#FFFFFF" d="M83.222,21.096h-2.139L88.51,3.312h1.922l7.354,17.784h-2.162l-2.067-4.999h-8.292L83.222,21.096z
				 M89.398,5.547l-3.532,8.916h7.09L89.398,5.547z"/>
            <path fill="#FFFFFF" d="M111.341,18.164l-0.024-14.852h1.923v17.784h-1.923L100.766,6.123l0.048,14.973h-1.923V3.312h2.02
				L111.341,18.164z"/>
            <path fill="#FFFFFF" d="M130.657,7.925c-0.554-0.769-1.227-1.417-1.996-1.924c-1.153-0.792-2.547-1.249-4.134-1.249
				c-3.894,0-7.282,2.98-7.282,7.427c0,4.519,3.413,7.499,7.307,7.499c1.874,0,3.532-0.649,4.759-1.61
				c1.249-0.986,2.115-2.331,2.403-3.726h-8.846v-1.634h11.153c-0.024,1.033-0.265,2.331-0.793,3.437
				c-1.539,3.341-5.097,5.287-8.677,5.287c-5.191,0-9.302-3.988-9.302-9.251c0-5.336,4.182-9.182,9.326-9.182
				c3.604,0,6.944,2.019,8.341,4.928H130.657z"/>
            <path fill="#FFFFFF" d="M155.262,3.312h1.995v16.029h8.701v1.755h-10.696V3.312z"/>
            <path fill="#FFFFFF" d="M167.001,3.312h1.971v17.784h-1.971V3.312z"/>
        </g>
        <path fill="#FFFFFF" d="M144.416,3c-4.88,0-9.333,3.588-9.333,9.379v0.024c0,4.546,3.734,8.972,9.308,8.972
			c5.505,0,9.381-4.257,9.381-9.187S149.871,3,144.416,3z M145.843,17.653l-1.438,2.48l-1.446-2.525
			c-2.376-0.704-3.77-3.021-3.77-5.473V12.11c0-2.705,1.844-5.622,5.252-5.622c3.54,0,5.229,3.201,5.229,5.7
			C149.669,14.315,148.415,16.958,145.843,17.653z"/>
    </g>
    <g>
        <text transform="matrix(1 0 0 1 3.2412 21.0913)" fill="#FFFFFF" font-family="'ITCAvantGardeStd-Bk'" font-size="24">JOIN</text>
    </g>
</g>
</svg>

        <p class="random">& GET $25<br/>SMOGI BUCKS</p>

        <div class="singup_form">
            <input type="text" data-watermark="First Name" name="fname" />
            <input type="text" data-watermark="Last Name" name="lname" />
            <input type="text" data-watermark="Email" name="email" />
            <input type="text" data-watermark="Select a password"  name="password" rel="password"/>
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