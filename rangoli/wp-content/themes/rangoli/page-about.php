<?php
get_header();
?>

<div class="row about_banner">
    <img src="<?php echo get_site_url(); ?>/wp-content/themes/rangoli/images/about_1.jpg" />
    <div class="overflow-text">
        <div class="rangoli_logo">
            <div class="logo-box"> <img src="<?php echo get_site_url(); ?>/wp-content/themes/rangoli/images/logo.png" /></div>
        </div>
        <div class="banner_bottom">
            <p>THE GENESIS OF RANGOLI </p>
            <p>IS IN COLOR</p>
        </div>
    </div>
</div>
    <div class="row pad3 grey align-center">
        <p class="bold">CULTURE, CONVERSATION, CONNECTION</p>
        <p class="light"><span>WELCOME TO THE YOGASMOGA COMMUNITY</span></p>
    </div>
<div class="about_section">
    <div class="sixty_six" style="position: relative;">
        <img src="<?php echo get_site_url(); ?>/wp-content/themes/rangoli/images/about_3.jpg" />
        <?php
        $post = get_post(395);
        $permalink = get_the_permalink($post->ID);
        $author_id = $post->post_author;
        $rangoli_profile = get_user_profile($author_id);
        $color = "#".$rangoli_profile->color_shade;
        ?>
        <div class="overlay-text about_us_page" onclick="window.location='<?php echo $permalink; ?>'" >
            <div video="http://youtu.be/MTMcDpqMePY" class="play-video">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                    <defs>
                    </defs>
                    <path fill="<?php echo $color; ?>"
                          opacity="0.9" enable-background="new" d="M32,0C14.327,0,0,14.327,0,32c0,17.674,14.327,32,32,32s32-14.326,32-32  C64,14.327,49.673,0,32,0z M22.321,49.106V14.894L51.951,32L22.321,49.106z"/>
                    </svg>
            </div>
        </div>
    </div>
    <div class="thirty_three golden" style="position: absolute;right: 0;">
        <p class="ITC-book">
            A CONNECTION WITH COLOR
        </p>
        <p class="freight-book">
            We recognize the important role color has in shaping our world. We know when to "stop" and "go" based on interchanging red and green lights, we describe sadness by feeling blue, we find the silver lining in things; in short, color gives meaning and dimension to our world; we have a relationship with color and use color to express who we are and what we connect with.
        </p>
    </div>
</div>
<div class="about_section">
    <div class="thirty_three">
        <img src="<?php echo get_site_url(); ?>/wp-content/themes/rangoli/images/interests.gif" />
        <div class="thirty_three golden2">
            Discover<br/>
            Your Interests
        </div>
    </div>
    <div class="sixty_six" style="position: relative;">
        <img src="<?php echo get_site_url(); ?>/wp-content/themes/rangoli/images/about_4.jpg" />
        <div class="overlay-text" style="cursor:default;">

                <p class="rang">
                    <span>RANG =</span> Color<br/>
                    <span>OLI =</span> That mixes/belongs to (Color)
                </p>

        </div>
        <p class="post_link" style="color:#fff">Choose Your Color</p>
    </div>
</div>
<div class="row no-padding">
    <div class="span4 img-stretch">
        <img src="<?php echo get_site_url(); ?>/wp-content/themes/rangoli/images/read.jpg" />
         <p class="post_link"><a href="/rangoli/read">Read More</a></p>
    </div>
    <div class="span4 img-stretch">
        <img src="<?php echo get_site_url(); ?>/wp-content/themes/rangoli/images/look.jpg" />
        <p class="post_link"><a href="/rangoli/look">Look More</a></p>
    </div>
    <div class="span4 img-stretch">
        <img src="<?php echo get_site_url(); ?>/wp-content/themes/rangoli/images/learn.jpg" />
        <p class="post_link"><a href="/rangoli/learn">Learn More</a></p>
    </div>
</div>
<div class="about-section row last-section">
    <p>When you sign up for RANGOLI, you get a RANGOLI in your favorite color.<br/>
        As you spend and share, your RANGOLI charm becomes more complex and colorful. </p>
    <img src="<?php echo get_site_url(); ?>/wp-content/themes/rangoli/images/charms.png" />
    <p>
        PS— Invite your friends and earn SMOGI Bucks to redeem on YOGASMOGA.com.<br/>
        Learn more about <a href="/smogi-bucks">SMOGI Bucks</a>.
    </p>
</div>
<?php
get_footer();
?>