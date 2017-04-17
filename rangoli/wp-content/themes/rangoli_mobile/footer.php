<?php
$home = get_site_url();
$media = $home . "/wp-content/themes/rangoli_mobile/images/";
$logged_in = is_user_logged_in();

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
    <p class="copyright">&copy; 2016 YOGASMOGA. All Rights Reserved.</p>
</div>
<?php
if(!is_user_logged_in()  && is_home()) {
    ?>
    <div style="padding: 22px; float: left; width: 100%;"></div>
<?php
}
?>

<!-- ------popups---- -->
<div class="popup">
    <div class="signin_popup">
        <span class="close_login_popup">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 width="44px" height="44px" viewBox="0 0 44 44" enable-background="new 0 0 44 44" xml:space="preserve">
<g>
    <rect fill="#555555" width="44" height="44"/>
    <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="14" y1="14" x2="30" y2="30"/>
    <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="30" y1="14" x2="14" y2="30"/>
</g>
</svg>

</span>
        <p>ALREADY A SMOGI</p>
        <p class="gold">SIGN IN HERE</p>

        <div class="login_form">
            <input type="text" data-watermark="Email" name="email" />
            <input type="text" data-watermark="Password" rel="password" name="password" />
            <p class="forgot_y_p"><a href="javascript:void(0);">Forgot your password?</a></p>
            <p class="forgot_y_p open_signup"><a href="javascript:void(0);">I don't have an account here?</a></p>
            <p class="small err_msg" style="text-align: left;"></p>
            <button class="login_customer">
                <svg width="44px" height="44px" xml:space="preserve" style="enable-background:new 0 0 44 44;" viewBox="0 0 44 44" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">
                                            <style type="text/css">
                                                .st0{fill:none;stroke:#FFFFFF;stroke-miterlimit:10;}
                                            </style>
                    <polyline points="5.9,25.6 14.6,34.3 39.1,9.8 " class="st0"/>
                                        </svg>
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
        <span class="close_signup_popup">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 width="44px" height="44px" viewBox="0 0 44 44" enable-background="new 0 0 44 44" xml:space="preserve">
<g>
    <rect fill="#555555" width="44" height="44"/>
    <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="14" y1="14" x2="30" y2="30"/>
    <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="30" y1="14" x2="14" y2="30"/>
</g>
</svg>

        </span>
        <!--<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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

        <p class="random">& GET 50% OFF<br/>YOUR FIRST ORDER</p>-->
        <!--<img class="svg-logontext" src="<?php echo get_stylesheet_directory_uri().'/images/25bucks.png' ?>" alt=""/>-->
		
		<svg class="svg-logontext" width="410px" height="165px" viewBox="0 0 410 165" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>Group</title>
                        <desc>Created with Sketch.</desc>
                        <defs></defs>
                        <g id="SIGNUP-25-SMB" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="PopupSMB-Desktop_v3" transform="translate(-599.000000, -154.000000)">
                                <g id="Group" transform="translate(594.000000, 154.000000)">
                                    <g id="Text" transform="translate(0.000000, 96.500000)" font-size="32" font-family="AvantGardeGothicITCW01D, ITCAvantGardeStd-Demi, ITC Avant Garde Gothic Std" line-spacing="34" letter-spacing="0.129999995" font-weight="500">
                                        <text id="SIGN-UP-NOW-TO-RECEI">
                                            <tspan x="18" y="24" fill="#AE8536" font-family="ITCAvantGardeStd-Demi">SPREAD THE SMOGI LOVE</tspan>
                                            <tspan x="45" y="60" fill="#FFFFFF" font-size="22"  font-family="ITCAvantGardeStd-Demi">TO YOUR FRIENDS, GET 30% OFF</tspan>
                                        </text>
                                    </g>
                                    <g id="YS-logotype" transform="translate(91.000000, 0.000000)" fill="#AE8536">
                                        <path d="M107.979394,18.9071263 C108.390606,23.1630445 111.450947,24.0480368 113.020436,24.0480368 C115.648266,24.0480368 118.074585,22.0145432 118.074585,19.1772645 C118.074585,15.5975202 115.030628,14.8136225 112.125926,13.8308501 C110.060032,13.2226251 105.66284,11.9117095 105.66284,7.09562762 C105.59567,2.55631304 109.327713,0.0405483376 113.167883,0.0405483376 C116.303585,0.0405483376 119.935691,1.81053299 120.33216,6.63655857 L117.538862,6.63655857 C117.240691,4.99252788 116.419904,2.4717913 113.05484,2.4717913 C110.536777,2.4717913 108.467606,4.20863018 108.467606,6.8420624 C108.443032,9.95279386 110.903755,10.7234332 114.730819,12.0111468 C117.112904,12.9491724 120.882628,14.3031775 120.882628,18.9949627 C120.882628,23.1564153 117.784606,26.4792798 113.06467,26.4792798 C108.846053,26.4792798 105.343372,23.791157 105.174628,18.9071263 L107.979394,18.9071263 L107.979394,18.9071263 Z" id="Fill-3"></path>
                                        <polygon id="Fill-5" points="124.304377 26.0165647 124.304377 0.499285934 128.254313 0.499285934 137.618823 21.906488 146.914526 0.499285934 150.857909 0.499285934 150.857909 26.0165647 148.208781 26.0165647 148.271036 3.31336266 138.485483 26.0165647 136.689909 26.0165647 126.879781 3.31336266 126.950228 26.0165647"></polygon>
                                        <path d="M218.686553,3.71525524 L213.681553,16.5095263 L223.747255,16.5095263 L218.686553,3.71525524 Z M209.938043,26.0173934 L206.894085,26.0173934 L217.431617,0.500114578 L220.156106,0.500114578 L230.592064,26.0173934 L227.523532,26.0173934 L224.59917,18.8496184 L212.850936,18.8496184 L209.938043,26.0173934 Z" id="Fill-7"></path>
                                        <path d="M79.2241532,11.5003703 L66.6649617,11.5003703 L66.6649617,16.7042578 L71.7944723,16.7042578 C71.4520681,17.9488818 70.7394085,18.9846875 69.7154723,19.6708051 C68.6915362,20.3966977 67.3596,20.8093627 65.758983,20.8093627 C62.5888766,20.8093627 58.8388128,18.4991018 58.8388128,13.156002 C58.8388128,8.12281535 62.5577489,5.74129105 65.7278553,5.74129105 C67.5004936,5.74129105 68.8930468,6.39757749 69.9546638,7.32565934 C70.4969404,7.8427335 70.9425574,8.42941381 71.2833234,9.05089719 L78.5114936,9.05089719 C77.1123872,4.1204624 71.9304511,0.0170148338 65.8982383,0.0170148338 C58.4652809,0.0170148338 52.3970255,5.53578721 52.3970255,13.156002 C52.3970255,20.5011069 58.1621957,26.5336389 65.7933872,26.5336389 C69.9546638,26.5336389 75.6100681,24.4321964 78.0658766,18.8090148 C79.1586213,16.3297105 79.3634085,13.3283601 79.2241532,11.5003703" id="Fill-9"></path>
                                        <path d="M197.138021,13.992933 L197.138021,16.3396542 L205.170596,16.3396542 C204.764298,18.3433166 203.545404,20.2508563 201.769489,21.6562373 C200.016511,23.0483601 197.681936,23.9731274 195.014787,23.9731274 C189.492085,23.9731274 184.650915,19.7205238 184.650915,13.2256082 C184.650915,6.82847263 189.485532,2.55598159 195.001681,2.55598159 C197.228128,2.55598159 199.221936,3.21558261 200.866787,4.35414015 C201.939872,5.07671816 202.886809,6.01142916 203.681383,7.11352634 L206.897362,7.11352634 C204.903553,2.9454445 200.155766,0.0435314578 195.057383,0.0435314578 C187.762043,0.0435314578 181.829766,5.5821913 181.829766,13.2256082 C181.829766,20.7745596 187.662106,26.4888921 195.02134,26.4888921 C200.116447,26.4888921 205.13783,23.6930455 207.34134,18.9266824 C208.088404,17.319112 208.409511,15.4762066 208.457021,13.992933 L197.138021,13.992933 Z" id="Fill-11"></path>
                                        <polygon id="Fill-13" points="26.1624702 0.611152941 19.6977468 0.611152941 13.5180872 11.3885033 7.42525745 0.611152941 0.796704255 0.611152941 10.2627894 17.3464573 10.2627894 26.0157361 16.7094915 26.0157361 16.7094915 17.1028358"></polygon>
                                        <path d="M168.321017,20.5214916 L166.438613,23.8078957 L164.543102,20.4601719 C161.430336,19.5287754 159.603634,16.4545043 159.603634,13.2062179 L159.603634,13.1747294 C159.603634,9.58835601 162.021762,5.72190077 166.487762,5.72190077 C171.125783,5.72190077 173.335847,9.96290332 173.335847,13.2774813 C173.335847,16.0965299 171.695911,19.6000389 168.321017,20.5214916 M166.451719,0.0373994885 C159.50206,0.0373994885 153.156932,5.20814118 153.156932,13.550934 L153.156932,13.5840798 C153.156932,20.1403151 158.474847,26.5192205 166.417315,26.5192205 C174.261485,26.5192205 179.782549,20.3822793 179.782549,13.2774813 C179.782549,6.17434066 174.225443,0.0373994885 166.451719,0.0373994885" id="Fill-15"></path>
                                        <path d="M38.8632106,20.5214916 L36.9808064,23.8078957 L35.0836574,20.4601719 C31.9692532,19.5287754 30.1392745,16.4545043 30.1392745,13.2062179 L30.1392745,13.1747294 C30.1392745,9.58835601 32.5606787,5.72190077 37.0250404,5.72190077 C41.6630617,5.72190077 43.8780404,9.96290332 43.8780404,13.2774813 C43.8780404,16.0965299 42.2315511,19.6000389 38.8632106,20.5214916 M36.9922745,0.0373994885 C30.0393383,0.0373994885 23.6942106,5.20814118 23.6942106,13.550934 L23.6942106,13.5840798 C23.6942106,20.1403151 29.0154021,26.5192205 36.9578702,26.5192205 C44.8020404,26.5192205 50.321466,20.3822793 50.321466,13.2774813 C50.321466,6.17434066 44.7659979,0.0373994885 36.9922745,0.0373994885" id="Fill-17"></path>
                                        <path d="M88.425817,0.496302813 L78.4371149,26.0168962 L85.4260936,26.0168962 L86.5843702,22.3277708 L95.4115191,22.3277708 L96.6074766,26.0168962 L103.661987,26.0168962 L93.9829234,0.496302813 L88.425817,0.496302813 Z M90.9143915,8.26070179 L93.7420936,17.1570292 L88.1866255,17.1570292 L90.9143915,8.26070179 Z" id="Fill-2"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
		
		
		
        <div class="singup_form">
            <input type="hidden" id="location_city" name="location_city" value="<?php echo $request_city;?>"/>
            <input type="hidden" id="location_state" name="location_state" value="<?php echo $request_state;?>"/>
            <input type="hidden" id="location_zip" name="location_zip" value="<?php echo $request_zip;?>"/>

            <input type="text" data-watermark="First Name" name="fname" />
            <input type="text" data-watermark="Last Name" name="lname" />
            <input type="text" data-watermark="Email" name="email" />
            <input type="text" data-watermark="Select a password"  name="password" rel="password"/>
            <p class="gender_p">Select Gender
                                              <span class="gender">
                                                    M<input type="radio" name="gender" value="1" title="male"/>
                                              </span>
                                              <span class="gender">
                                                    F<input type="radio" name="gender" value="2" title="female"/>
                                              </span>
            </p>

            <p class="small err_msg" style="text-align: left"></p>
            <button class="create_account">
                <svg xml:space="preserve" style="enable-background:new 0 0 44 44;" viewBox="0 0 44 44" y="0px" x="0px" width="44px" height="44px">
                                            <style type="text/css">
                                                .st0{fill:none;stroke:#FFFFFF;stroke-miterlimit:10;}
                                            </style>
                    <polyline points="5.9,25.6 14.6,34.3 39.1,9.8 " class="st0"/>
                                        </svg>
            </button>
            <p style="clear:both"><a class="no-thanks" onclick="jQuery('.close_signup_popup').click()" >No Thank You, I’m not interested in <br>Made in the USA apparel.</a></p>
            <?php /* ?><p style="clear:both"><a class="already_signed_up open_signin">I’m already signed up.</a></p><?php */ ?>
            <!--<p class="forgot_y_p open_signin"><a href="javascript:void(0);">Already signed up? Sign in here</a></p>-->
            <p style="clear:both"><a class="already-text" onclick="jQuery('.close_signup_popup').click()">I’m already signed up.</a></p>



        </div>
    </div>
    <div class="after_signup_popup">
        <span class="close_after_signup_popup">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 width="44px" height="44px" viewBox="0 0 44 44" enable-background="new 0 0 44 44" xml:space="preserve">
<g>
    <rect fill="#555555" width="44" height="44"/>
    <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="14" y1="14" x2="30" y2="30"/>
    <line fill="none" stroke="#FFFFFF" stroke-miterlimit="10" x1="30" y1="14" x2="14" y2="30"/>
</g>
</svg>
        </span>
        <p>THANK YOU</p>
        <p>FOR SIGNING UP</p>
        <p class="smogi_bucks_banner"><img src="<?php echo $media?>/25smogi_bucks.png" /></p>
        <p class="small">SMOGI BUCKS <br/><br/>is yours to use at <br/>YOGASMOGA.COM</p>
    </div>

    <?php /* ?>

    <!-- MAil chimp poup -->
    <div id="MailpopForm" class="MailpopForm" style="display:none;">
        <div  class="sign-up-popup">
            <a  class="close_login_popup" onclick="closepopup();" href="javascript:void(0)">
                <svg xml:space="preserve" enable-background="new 0 0 55 55" viewBox="0 0 55 55" height="55px" width="55px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">
						<g>
                            <rect height="66" width="66" fill="none"/>
                            <line y2="40" x2="40" y1="14" x1="14" stroke-miterlimit="10" stroke="#FFFFFF" fill="none"/>
                            <line y2="40" x2="14" y1="14" x1="40" stroke-miterlimit="10" stroke="#FFFFFF" fill="none"/>
                        </g>
						</svg>
            </a>

            <div class="signup-info">
                <div class="scroll">
                    <div class="main-heading">
                        SIGN UP NOW<BR>TO INSTANTLY GET <span>25% OFF</span>YOUR FIRST ORDER
                    </div>
                    <div class="popup-form">

                        <form name="" id="popup-mailsignup" class="popup_form" method="post" action="" rel="">
                            <ul style="padding:0;">
                               <!-- <li><span>Your Email Address</span></li>-->
                                <li><div class="input-box">
                                        <input style="padding:0 10px!important;" type="text" class="input-text" id="Memail_address" placeholder="Your Email Address" name="email" value="">
                                    </div>
                                </li>
                                <li class="button-area"><span class="form-loader-mail"></span>
                                    <input type="submit" class="signup_button" id="signup-button-mailc" value="SIGN UP"/></li>
                            </ul>
                            <p style="margin: 0px auto;font-size: 12px;visibility: hidden;min-height: 20px;width: 236px;color:#fff;clear:both;padding-top:5px;" id="err-msg">All fields are required.</p>
                        </form>

                    </div>
                </div>

            </div>
        </div>
        <!-- thank you popup -->
        <div style="display:none;" class="thanks-popup">
            <a  class="close_login_popup" onclick="closepopup()" href="javascript:void(0)">
                <svg xml:space="preserve" enable-background="new 0 0 55 55" viewBox="0 0 55 55" height="55px" width="55px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">
						<g>
                            <rect height="66" width="66" fill="none"/>
                            <line y2="40" x2="40" y1="14" x1="14" stroke-miterlimit="10" stroke="#FFFFFF" fill="none"/>
                            <line y2="40" x2="14" y1="14" x1="40" stroke-miterlimit="10" stroke="#FFFFFF" fill="none"/>
                        </g>
						</svg>
            </a>

            <div class="signup-info">
                <div class="scroll">
                    <div class="main-heading">
                        <span class="strong">THANK YOU!</span> Please Check Your email and Feel the SMOGI LOVE

                    </div>
                    <div class="popup-form">
                        <form name="" id="" class="popup_form" method="" action="" rel="">
                            <ul style="padding:0;">
                                <!--<li><span>We've also emailed it to you<br/>in case you forget.</span></li>-->
                                <li>
                                    <a class="shop-link" href="/women" style="text-decoration:none;">SHOP WOMEN  </a>
                                </li>
                                <li>
                                    <a class="shop-link" href="/men" style="text-decoration:none;">SHOP MEN  </a>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <!-- thank you popup -->
    </div>
    <?php */ ?>
    <!-- MAil chimp poup -->

    <script type="application/javascript">

        jQuery(document).ready(function($){

            jQuery(".mobile-orange-banner").click(function () {

                window.location.assign(homeUrl+'one-too-many');
               /* jQuery(".popup").fadeIn();

                jQuery(".popup").addClass('signup_pop');
                //jQuery(".MailpopForm").fadeIn();
                jQuery(".MailpopForm").fadeOut();
                //jQuery(".signin_popup").fadeOut();
                jQuery(".after_signup_popup").fadeOut();
                //$(".signup_popup").fadeOut();
                jQuery(".signup_popup").fadeIn();

                jQuery(".signup_popup input[type=text],.signup_popup input[type=password]").on('focus keypress',function(){
                    if(jQuery(this).val().length > 0){
                        jQuery(this).addClass('on');
                    }

                });
                jQuery(".signup_popup input[type=text],.signup_popup input[type=password]").on('blur keyup',function(){
                    if(jQuery(this).val().length < 1){
                        jQuery(this).removeClass('on');
                    }
                });

                jQuery('.signup_popup .gender_p .gender').click(function(){
                    if(jQuery(this).hasClass('selected')){
                        jQuery('.signup_popup .gender_p').addClass('on');
                    }
                    else{
                        jQuery('.signup_popup .gender_p').removeClass('on');
                    }
                });
            */
            });
            /*
            jQuery('.no-thanks,.already_signed_up').click(function(){
                jQuery('.popup').removeClass('signup_pop');
            });

            jQuery('.open_signup').click(function(){

                jQuery('.forgot_password_form').hide();
                jQuery('.popup').addClass('signup_pop');
            });

            */

        });




            $("#popup-mailsignup").submit(function(event){
                event.preventDefault();

                $("#err-msg").css("visibility","hidden");

                var formid = "#popup-mailsignup";
                var email_id = $.trim($("#Memail_address").val());
                if(email_id == "" || email_id == "Email Address")
                {
                    event.preventDefault();
                    $("#err-msg").css("visibility","visible");
                    $("#err-msg").text("Please enter an email address.");
                    return;
                }
                if( !isValidEmailAddress(email_id)){
                    event.preventDefault();
                    $("#err-msg").css("visibility","visible");
                    $("#err-msg").text("Enter a valid email.");
                    return;
                }

                var url = homeUrl + 'mailchimp_signup.php';


                jQuery.ajax({
                    url     :   url,
                    type    :   'POST',
                    data    :   {'email':email_id},
                    beforeSend: function() {
                        //jQuery("#popup-mailsignup .form-loader-mail").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px;' />");
                        //jQuery("#popup-mailsignup").parent().hide();
                        jQuery("#popup-mailsignup #signup-button-mailc").attr("value","SIGNING UP...");
                      //  jQuery("#popup-mailsignup .form-loader-mail").show();
                    },
                    success: function (data) {
                        data = eval('(' + data + ')');
                        var status = data.status;
                       // jQuery("#popup-mailsignup .form-loader-mail").hide();


                        if (status == "success") {
                            jQuery("#popup-mailsignup #signup-button-mailc").attr("value","SIGN UP");
                            jQuery(".sign-up-popup").hide();
                            $(".thanks-popup").show();

                        }
                        else
                        {
                            $("#signup-button-mailc").val("SIGN UP");
                            jQuery("#signup-button-mailc").parent().show();
                            $("#popup-mailsignup #err-msg").html(data.error).css("visibility","visible");
                        }
                    }
                });
            });


        function closepopup(){

            jQuery(".signup-thankyou").hide();
            jQuery(".signup-content").show();
            jQuery("#Memail_address").val('');
        }

    </script>
    <!-- Shivaji New Code -->







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