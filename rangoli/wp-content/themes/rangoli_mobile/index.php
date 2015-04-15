<?php
get_header();
?>
<!--<div class="wrapper">-->
<!--</div>-->
<div class="container">
    <div class="row">
        <div class="close right">
            <a href="/" ><img src="<?php echo get_site_url();?>/wp-content/themes/rangoli_mobile/images/close.png" /></a>
        </div>
    </div>
    <div class="row signup_form">
        <div class="row">
            <img src="<?php echo get_site_url();?>/wp-content/themes/rangoli_mobile/images/signup_text.png" />
        </div>
        <div class="registration_form">
            <input type="text" name="fname" id="fname" data-watermark="First Name"/>
            <input type="text" name="lname" id="lname" data-watermark="Last Name" />
            <input type="text" name="email" id="email" data-watermark="Email"/>
            <input type="text" rel="password" name="password"id="password"  data-watermark="Select password" />
            <button class="submit" id="signup"></button>
            <p class="err-msg"></p>
        </div>
    </div>
    <div class="row confirmation_message">
        Thank You for registering with us. We will update you soon...
    </div>
</div>
<?php
get_footer();
?>