<?php
if (!is_user_logged_in()) {
    wp_redirect(get_site_url());
} else {
    get_header();
    $user_id=get_current_user_id();
    $user_info = get_userdata($user_id);
    $rangoli_user = get_user_profile_from_magento($user_id);
//    print_r($rangoli_user);
    $main_color = $rangoli_user->color_main;
    ?>

    <div class="confirmed_interests">
        <div class="row">
            <h1 class="welcome_user">WELCOME <?php $user_id = get_current_user_id();

                echo strtoupper($user_info->display_name);
                ?>
            </h1>
        </div>
        <div class="row align-center">
            <p>You have 25 SMOGI Bucks just for signing up.</p>
            <p>(Learn how to earn more SMOGI BUCKS)</p>
        </div>
        <div class="user_charm_display row" style="height: 150px; position: relative;">
            <?php
            if ($main_color) {
                $main_color = strtoupper($main_color);
                $level = get_user_level($user_id);
                echo "<div class='row align-center'>
                    <span style='border-top:85px solid #$main_color; border-left:52px solid transparent; border-right:52px solid transparent; border-bottom:0px solid transparent; position: absolute; left: 50%; margin-left: -52px; margin-top: 20px'></span></div>";
            }
            ?>
        </div>
        <div class="interests-selector" style="padding-top: 30px">
            <p class="text">Ut aliquam felis ut consectetur interdum. Donec ipsum velit, vulputate id efficitur non, viverra vitae turpis. Pellentesque posuere, leo et mollis vulputate, enim purus tincidunt dolor.</p>

            <!-- ----------------------------CHOOSE YOUR INTERESTS------------------------ -->
            <div class="confirmed_interests">
                <ul style="text-align:center">
                    <?php
                    $user_id = get_current_user_id();
                    $ar = get_user_interests($user_id);

                    //					print_r($ar);
                    if (count($ar) > 0)
                        foreach ($ar as $category_slug) {

                            if (function_exists('z_taxonomy_image_url')) {
                                $category = get_category_by_slug($category_slug);
//								print_r($category);
                                echo "<li><a  class='user-interest' href='javascript:void(0)'>
									<img src='" . z_taxonomy_image_url($category->term_id, null, 'medium') . "' />
								</a>";
                            }

                            /*$interest_add_url = get_site_url() . "/wp_update_user_interest.php?type=add&user_id=" . $user_id . "&category=" . $category->slug;
                            $interest_remove_url = get_site_url() . "/wp_update_user_interest.php?type=remove&user_id=" . $user_id . "&category=" . $category->slug;

                            $url = $interest_remove_url;
                            $class = "remove";
                            echo "<a class='" . $class . "' href='" . $url . "'>";
                            */?><!--
                            <svg style="height: 50px;" xml:space="preserve" enable-background="new 0 0 36.6 36.3"
                                 viewBox="0 0 36.6 36.3" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1"> <path
                                    d="M18.2,35.5l16.2-21c1-1.5,1.6-3.2,1.6-5.2c0-4.9-4-8.9-8.9-8.9  s-8.9,4-8.9,8.9c0-4.9-4-8.9-8.9-8.9s-8.9,4-8.9,8.9c0,1.9,0.6,3.7,1.6,5.2L18.2,35.5z"
                                    stroke-miterlimit="1" stroke="#fff" fill="none"/> </svg>
                            --><?php
//                            echo "</a>";
                    echo "<a href=''></a>";
                            echo "<a href='javascript:void(0)'><span>" . $category->slug . "</span></a></li>";

                        }


                    ?>
                </ul>
            </div>
            <div class="invite_friend">
                <div class="line"></div>
                <p>Share the RANGOLI love</p>
                <p>Earn $2 SMOGI Bucks just for sharing</p><br/><br/>

                <div class="user_link">
                <p>Your Invite link</p>

                <p class="link" style=" color: <?php echo "#".$main_color ?>;">https://www.rango.li/invite/<?php echo str_replace(" ","-",(strtolower($user_info->display_name))); ?></p>
                <span>Copy link</span>


                <p>Invite friends to RANGOLI</p>
                </div>
                <ul>
                    <li rel="facebook"><img src="<?php ?>/rangoli/wp-content/themes/rangoli/images/fb.png" /> </li>
                    <li rel="email"><img src="<?php ?>/rangoli/wp-content/themes/rangoli/images/ig.png" /></li>
                    <li rel="twitter"><img src="<?php ?>/rangoli/wp-content/themes/rangoli/images/tw.png" /></li>
                </ul>
            </div>
            <!-- ------------------------------------------------------------------------- -->

        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(".invite_friend li").hover(function(){
              $(this).css({"background":"#<?php echo $main_color; ?>", "transition-duration":"500ms"})
            },function(){
                $(this).css({"background":"#f2f2f2", "transition-duration":"500ms"})
            })
        })
    </script>
    <?php
    get_footer();
}