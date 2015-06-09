<?php
get_header();
$home = get_site_url();
$media = $home."/wp-content/themes/rangoli_mobile/images";
?>
<div class="author_post_read_author">
    <img src="<?php echo $media."/about_img1.png"; ?>" />
    <div class="overlay-text">
        <img class="logo_about" src="<?php echo $media."/logo_rangoli.png"; ?>" />
        <p class="about_sub_text">THE GENESIS OF RANGOLI<br/><span>IS IN COLOR</span></p>
    </div>
</div>

<div class="author_post_read_author">
    <img src="<?php echo $media."/about_img1.png"; ?>" />
    <div class="align-top">CULTURE, CONVERSATION, CONNECTION</div>
    <div video="http://youtu.be/yISKeT6sDOg" class="play-video">
        <svg xml:space="preserve" enable-background="new 0 0 64 64" viewBox="0 0 64 64" height="64px" width="64px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">                    <defs>
            </defs>
            <path d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z" enable-background="new" opacity="0.9" fill="#ae8637"/>
                    </svg>
    </div>
</div>

<div class="author_post_read_author" style="background: #ae8637;">
<!--    <img src="--><?php //echo $home; ?><!--/wp-content/themes/rangoli_mobile/images/no-background_posts.png" />-->
    <div class="align-top">A CONNECTION WITH COLOR</div>
    <p class="about_text" style="background: none; padding: 80px 2.4% 50px;">
        We recognize the important role<br/>
        color has in shaping our world.<br/>
        We know when to "stop" and "go"<br/>
        based on interchanging red and<br/>
        green lights, we describe sadness<br/>
        by feeling blue, we find<span class="dots_for_text">...</span><span class="extra-text"> the silver<br/>
        lining in things; in short, color<br/>
        gives meaning and dimension to<br/>
        our world, we have a relationship<br/>
        with color and use color to<br/>
        express who we are and what<br/>
        we connect with.</span>

    </p>
    <div class="align_right read_more">Read More </div>
</div>


<div class="author_post_read_author  half" style="background: #007f00;">
    <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/no-background.png" />
    <div class="about_section_1 overlay-text" style="background: none;">
        <img src="<?php echo $media; ?>/green_thumb.png" />
        <p>See Green Thumb</p>
    </div>
</div>


<div class="author_post_read_author  half" style="background:#555555;" >
    <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/no-background.png" />
    <div class="overlay-text about_section_2" style="background: none;">
        <p>DISCOVER <br/>YOUR INTERESTS</p>
    </div>
</div>



<div class="author_post_read_author">
    <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/no-background_posts.png" />
    <div class="overlay-text about_section_3">
        <span>RANG</span> = Color<br/>
            <span>OLI</span> = That mixes/belongs to (Color)
        <p>Choose your Color</p>
    </div>
</div>


<div class="about_section_5">
    <div class="one-three" style="background: #ff5f00;">
        <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/no-background.png" />
        <div class="about_section_1 overlay-text" style="background: none;">
            <img src="<?php echo $media; ?>/read_more.png" />
            <p>Read More</p>
        </div>
    </div>

    <div class="one-three" style="background: #5ec52f;">
        <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/no-background.png" />
        <div class="about_section_1 overlay-text" style="background: none;">
            <img src="<?php echo $media; ?>/look_more.png" style="margin-top: 5px" />
            <p>Look More</p>
        </div>
    </div>

    <div class="one-three" style="background: #6f3bbe;">
        <img src="<?php echo $home; ?>/wp-content/themes/rangoli_mobile/images/no-background.png" />
        <div class="about_section_1 overlay-text" style="background: none;">
            <img src="<?php echo $media; ?>/learn_more.png" />
            <p>Learn More</p>
        </div>
    </div>

</div>


<div class="about_section_4" >
    When you sign up for RANGOLI,<br/>
    you get a RANGOLI in your favorite color.<br/>
    As spend and share, your RANGOLI charm<br/>
    becomes more complex and colorful.<br/>
    <img src="<?php echo $media; ?>/charms_about.png" />
    <p style="font:14px GraphikRegular;"> PS— Points on RANGOLI are equal to<br/>
    SMOGI Bucks… share with your friends and earn<br/>
    SMOGI Bucks to redeem on YOGASMOGA.com.<br/>
    Learn more about <a href="/smogi-bucks"> SMOGI Bucks.</a></p>

</div>

<?php
get_footer();
?>