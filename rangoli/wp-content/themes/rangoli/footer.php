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

    <div class="signin-block mage" style="background: url('<?php echo get_site_url()."/wp-content/themes/rangoli/images/red_popup.png" ?>') no-repeat;">

        <div class="close_signin_popup" ></div>
        <div class="form">
			<!--<img class="svg-logontext" src="<?php // echo get_site_url()."/wp-content/themes/rangoli/images/25bucks.svg" ?>" alt=""/>-->
			<svg class="svg-logontext" width="410px" height="165px" viewBox="0 0 410 165" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <!-- Generator: Sketch 39.1 (31720) - http://www.bohemiancoding.com/sketch -->
    <title>Group</title>
    <desc>Created with Sketch.</desc>
    <defs></defs>
    <g id="SIGNUP-25-SMB" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="PopupSMB-Desktop_v3" transform="translate(-599.000000, -154.000000)">
            <g id="Group" transform="translate(594.000000, 154.000000)">
                <g id="Text" transform="translate(0.000000, 96.500000)" font-size="32" font-family="ITCAvantGardeStd-Md,AvantGardeGothicITCW01D, ITCAvantGardeStd-Demi, ITC Avant Garde Gothic Std" line-spacing="34" letter-spacing="0.129999995" font-weight="500">
                    <text id="SIGN-UP-NOW-TO-RECEI">
                        <tspan x="5.08500005" y="24" fill="#FFFFFF">SIGN UP NOW TO RECEIVE </tspan>
                        <tspan x="62.245" y="58" fill="#AE8536">$25 SMOGI BUCKS</tspan>
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
            <form id="sign-up-form">
				<input type="hidden" id="p_location_city" name="location_city" value="<?php echo $request_city;?>"/>
				<input type="hidden" id="p_location_state" name="location_state" value="<?php echo $request_state;?>"/>
				<input type="hidden" id="p_location_zip" name="location_zip" value="<?php echo $request_zip;?>"/>
				<input name="" data-watermark="First Name" id="p_fname" class="text"/>
				<input data-watermark="Last Name" id="p_lname" class="text" />
				<input data-watermark="Email Address" id="p_signup_email" class="text" />
				<input data-watermark="Select a password" rel="password" id="p_s_password" class="text" />
				<p class="gender_p gender_popup">Gender <label><span><input type="radio" name="gender" value="1" />M</span>Male</label> <label> <span><input type="radio" name="gender" value="2" />F</span>Female</label> </p>
				<img class="loader" src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px; display:none;' />
				<div class="err-msg" style="color:#fff"></div>
				<input id="signup" type="button" value="Sign up"  />
                
            </form>
			<p class="close-text" onclick="jQuery('.close_signin_popup').click()">No Thank You, I’m not interested in Made in the USA apparel.</p>
			<!--<p class="opensignin" onclick="$('.login_logout_link').click();">I’m already signed up.</p>-->
			<p class="opensignin" onclick="$('.close_signin_popup').click();">I’m already signed up.</p>
            <!--<div class="align-center" style=" color:#ff9f9f; font-size: 13px; letter-spacing: 1px; font-family: ITCAvantGardeStd-Bk">
                Already signed up?<br/><a style="cursor: pointer;" onclick="$('.login_logout_link').click();">Sign in here</a>
            </div>-->
        </div>
    </div>

	<?php if(false){ ?>
	<!------------------------------mailchimp signup form------------------------------>
	<div id="signup-box" class="mc-signup">
	<div class="signin-block">
	<!--<div class="close_signin_popup" ></div>-->
	<div class="signup-content">
	
		<form action="" method="post" id="popup-mailsignup" style="display: block;">
		<img class="svg-logontext" src="<?php echo get_stylesheet_directory_uri().'/images/25-off.svg' ?>" alt=""/>
		<div class="fields-area">
		<p><input type="text" id="Memail_address" class="watermark" placeholder="Your Email Address" autocomplete="off" value=""/></p>
		<p class="button-area"><span class="form-loader-mail"></span><input type="submit" value="Sign Up" id="signup-button-mailc"/></p>
		</div>
		<p style="margin: 0px auto; font-size: 12px; visibility: hidden; min-height: 20px; width: 236px;" id="err-msg">All fields are required.</p>
		<p class="close-text">No Thank You, I’m not interested in Made in the USA apparel.</p>
		</form>
	</div><!--signup-content-->


	<div id="thank_you_box" class="signup-thankyou">
	<div class="signup-thankyou-content">
	<img class="svg-logo" src="<?php echo get_stylesheet_directory_uri().'/images/m.svg' ?>" alt=""/>
		<p class="signup-title">
			<span class="spn_line"><span class="strong">Thank You</span> 
				<span class="strong"><small>Please Check Your email</small><small> &amp; Feel the SMOGI LOVE</small></span></span>
   
  </p>
  
		<p class="mc-shoplinks">
			<a href="/women"><img src="<?php echo get_stylesheet_directory_uri().'/images/mc-shopwomen3.jpg' ?>" alt=""/></a>
			<a href="/men"><img src="<?php echo get_stylesheet_directory_uri().'/images/mc-shopmen3.jpg' ?>" alt=""/></a>
		</p>
	</div>	
	</div><!--signup-thankyou-->
	</div>

</div>

<script type="application/javascript">
    jQuery(document).ready(function($){
		//$("#signup-box").dialog( "open" );
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
						/*jQuery("#popup-mailsignup .form-loader-mail").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px;' />");*/
                        jQuery("#popup-mailsignup #signup-button-mailc").attr("value","SIGNING UP...");
						//jQuery("#popup-mailsignup").parent().hide();
						jQuery("#popup-mailsignup .form-loader-mail").show();
					},
					success: function (data) {
						data = eval('(' + data + ')');
						var status = data.status;
						jQuery("#popup-mailsignup .form-loader-mail").hide();
						
						if (status == "success") {
							jQuery("#popup-mailsignup").parent().hide();
							$(".signup-thankyou").show();
							jQuery("#popup-mailsignup #signup-button-mailc").attr("value","SIGN UP");
							$('.close_signin_popup').click(function(){
								$(".signup-thankyou").hide();
								$(".signup-content").show();
								$("#Memail_address").val('');
							});
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
	$('#Memail_address').on('focus keypress',function(){		
			if($(this).val().length > 0){
				$('#signup-button-mailc').addClass('on');			
			}
			else{
				$('#signup-button-mailc').removeClass('on');			
			}
			
		});
});
</script>
<!-- Shivaji New Code -->
<!------------------------------mailchimp signup form end------------------------------>
<?php } ?>

	
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
        <a class="logo" href="/" >
           <img src="<?php bloginfo('template_directory')  ?>/images/footer-logo1.svg" alt="logo_footer" />
			
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
                    <li><a class="bold-heading" href="javascript:void(0)" onclick="open_red_popup()">FEEL THE SMOGI LOVE</a></li>

                    <!--<li>Sign up and earn 50% Off on your first order.</li>-->
					<li class="smogilove-txt">Sign up now<br/> to receive $25 Smogi Bucks</li>
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

</div><!--page-wrapper ends-->

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
<script type="text/javascript">
$(document).ready(function(){
	if($(".signin-block").fadeIn()){
		
		$('#signin_popup').addClass('mc_signinpopup');
	}
	
	$('.login_logout_link').click(function(){
		$('#signin_popup').removeClass('mc_signinpopup');
	})
});	
</script>
<style>
.footer.row{  display: block;
    float: none !important;
    margin: 0 auto 30px !important;
    overflow: hidden;
    overflow-wrap: break-word;
    padding-top: 60px;
    text-align: center !important;
    width: 98.5%;}
.side-logo{ float: left;
    width: 33%;
	 margin-top: 2%;
	 padding:0;
	}
	.footer.row .first-list{overflow:hidden;}
	.side-logo .logo img{ left: 0;
    position: relative;
    width: 94px;}
	.footer .footer-right{width:67%;}
	.footer.row .side-logo .logo{float:left;padding-left:30px;}
	
.footer.row .side-logo .logo span svg{width:100%;}
.smogilove-txt{text-transform:uppercase;}
 .footer-right .first-list ul li a,.footer-right ul li{  color: #555;
    font-family: ITCAvantGardeStd-Bk;
    font-size: 12px;
    letter-spacing: 0.5px;}
	.footer li .bold-heading{font-family:AvantGardeGothicITCW01D!important}
	.footer li:hover,.footer li:hover a{color: #ae8536;}
	.footer-right .privacy li, .footer-right .privacy li a{font:12px/1.55 ITCAvantGardeStd-Bk;}
	.footer.row .first-list > li a:hover, div.copy-privacy-likes ul li a:hover{color: #ae8536!important;}
</style>

</body>
</html>