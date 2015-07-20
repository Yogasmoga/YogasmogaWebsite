<?php
if(!is_user_logged_in()){
    wp_redirect(site_url());
}
get_header();

?>
    <div class="block">
        1. Invite Friends
    </div>
    <div class="row link_heading borderTop">
          Your invite link
    </div>
    <div class="invite_link" style="background: #555; height:50px;">
    <p <?php if(!is_user_logged_in()){echo "style='background:rgba(85,85,85,0.95);'";} else { echo "class='user-color-shade'";} ?> style="height: 50px;"><i class="link"></i> <span class="copy_link" data-clipboard-text="">Copy link</span></p>
    </div>

    <div style="text-align: center; padding-bottom: 25px;">
        <p style="font:15px/58px GraphikRegular;">Invite friends to join Rangoli</p>
           <a class="email_invite"></a>
           <a class="twitter_invite"></a>
    </div>

    <div class="block borderTop">
        2. Post to your friends pages
    </div>
    <div class="block borderTop">
        3. Earn SMOGI Bucks more easily
    </div>
<style>
    .borderTop {
        border-top: 1px solid #bfbfbf;
    }
</style>
<?php
get_footer();