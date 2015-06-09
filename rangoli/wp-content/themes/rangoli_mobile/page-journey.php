<?php
get_header();
if(!is_user_logged_in()){
    wp_redirect(get_site_url());
}

$home = get_site_url();
$media = $home . "/wp-content/themes/rangoli_mobile/images/";
?>
<div class="journey">
    <div class="color-game">
        <div class="game_message">
            <p>CHOOSE YOUR COLOR</p>
            <span class="accept"><img src="<?php echo $media; ?>accept.png" /></span>
            <span class="discard"><img src="<?php echo $media; ?>discard.png" /></span>
        </div>
        <ul></ul>
    </div>
    <div class="choose_interests">
        <div class="interest_listing">
            <span class="shade_overlay"></span>
            <ul>
                <?php
                $user_id = get_current_user_id();
                $ar = get_user_interests($user_id);
                $args = array(
                    'type' => 'post',
                    'child_of' => 0,
                    'parent' => '',
//                    'orderby' => 'name',
//                    'order' => 'ASC',
                    'hide_empty' => 0,
                    'hierarchical' => 1,
                    'exclude' => '',
                    'include' => '',
                    'number' => '',
                    'taxonomy' => 'category',
                    'pad_counts' => false

                );
                $categories = get_categories($args);

                foreach ($categories as $category) {
                    if ($category->slug != "all" && $category->slug != "read" && $category->slug != "look" && $category->slug != "learn") {


                        $interest_add_url = get_site_url() . "/wp_update_user_interest.php?type=add&user_id=" . $user_id . "&category=" . $category->slug;
                        $interest_remove_url = get_site_url() . "/wp_update_user_interest.php?type=remove&user_id=" . $user_id . "&category=" . $category->slug;

                        $class = "add";
                        $url = $interest_add_url;
                        if ($ar) {
                            if (count($ar) > 0) {
                                if (isset($ar) && in_array($category->slug, $ar)) {
                                    $url = $interest_remove_url;
                                    $class = "remove";
                                }
                            }
                        }

                        if (function_exists('z_taxonomy_image_url'))
                            echo "<li class='$class $category->slug'>
                                <span></span>";
                            ?>
                        <div class="interest_like">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="68px" height="65px" viewBox="-4.858 -2.698 68 65" enable-background="new -4.858 -2.698 68 65" xml:space="preserve">
                                <defs>
                                </defs>
                                <path fill="#FFFFFF" d="M28.2,55.691L54.01,22.354c1.646-2.316,2.616-5.143,2.616-8.191C56.626,6.339,50.288,0,42.468,0  c-7.814,0-14.153,6.339-14.153,14.162C28.315,6.339,21.972,0,14.158,0C6.339,0,0,6.339,0,14.162c0,3.049,0.97,5.875,2.612,8.191  L28.2,55.691z"/>
                                </svg>
                        </div>
    <?php
                                echo "<a href='$url'>$category->cat_name</a>
                                <div class='interest_description'>$category->category_description</div>
                                </li>";




                    }

                }
                        ?>
            </ul>
        </div>
        <!-- ------------------------------------------------------------------------- -->
        <div class="buttons">

            <button class="choose_color"><img src="<?php echo $media ?>go_back.png" /></button>
            <button class="next-confirmation-page user-color-shade">Choose 3+</button>
        </div>

    </div>
    <div class="confirmation_page">
    <?php
        $smogi_bucks = "$".get_user_smogi_bucks(get_current_user_id());
        $get_wp_user_registration_date  ;
        $get_magento_user_registration_date  ;
        $user_id = get_current_user_id();
        $user_info = get_userdata($user_id);
        $rangoli_user = get_user_profile_from_magento($user_id);
        $main_color = $rangoli_user->color_main;
        $visited = 1;
        $visited = is_journey_first_time();
        $user_id = get_current_user_id();
        $user_info = get_userdata($user_id);
        $profile_rangoli = get_user_profile($user_id);
        $name = $profile_rangoli->user_display_name;
        if($name==null){
            $name = $user_info->display_name;
        }

        if($visited){
            $welcome_message = strtoupper($name);
            $smogiBucks_message = "You have <br/><span class='user-color-shade-text smogi_bucks_journey'>$smogi_bucks</span><br/> SMOGI Bucks</p><p class='msg'>Learn how to earn more <span>SMOGI BUCKS</span>";
            $interest_message = "YOUR INTERESTS";
            $color_message="YOUR COLOR";
        }
        else{

            $root = get_site_url();
            $root = str_replace("/rangoli","/",$root);
            $welcome_message = strtoupper($name);
            $smogiBucks_message = "You have <br/><span class='user-color-shade-text smogi_bucks_journey'>$smogi_bucks</span><br/> SMOGI Bucks<br> just for signing up.</p><p class='msg'>Learn how to earn more <span>SMOGI BUCKS</span></p>";

            $magento_user = json_decode(file_get_contents($root . 'ys/session/getcustomerbyemail/email/' . $user_info->user_login));

            if ($magento_user) {
                $create_date_mg = $magento_user->create_date;
                $current_user_id = get_current_user_id();
                $current_user = get_userdata($current_user_id);
                $create_date_wp = $current_user->user_registered;
                $create_date_wp = date('Y-m-d',$create_date_wp);

                if(strtotime($create_date_mg) > strtotime($create_date_wp)){
                    $smogiBucks_message = "<p>You have <br/><span class='user-color-shade-text smogi_bucks_journey'>$smogi_bucks</span><br/> SMOGI Bucks</p><p class='msg'>Learn how to earn more <span>SMOGI BUCKS</span></p>";
                }

            }


            $interest_message = '';
            $color_message="YOUR COLOR";
        }
        ?>

        <div class="confirmed_interests">
            <div class="row">
                <h1 class="username_journey"><?php echo $welcome_message; ?></h1>
            </div>

            <div class="smogi_message" style="margin-bottom:20px; "><?php echo $smogiBucks_message; ?></div>
            <?php //echo $color_message;  ?>



                    <?php

                    $user_level = get_user_level($user_id);
                    ?>
            <div class="profile_pic_journey">
                <p class="smogi_message">YOUR PROFILE PICTURE <span class="edit_pic edit"></span></p>

                <?php
                $home = get_site_url();
                $media = $home."/wp-content/themes/rangoli_mobile/images/";
                $user_id = get_current_user_id();
                $profile = get_user_profile($user_id);
                $urls = get_user_meta($user_id,"cupp_upload_meta");
                $image_src = $media."default.jpg";
                if(is_array($urls) && count($urls)>0) {
                $image_src = $urls[0];
                }
                ?>
                <div class="profile_picture_journey">
                    <img class="profile_pic" src="<?php echo $image_src; ?>" />
                </div>

            </div>



            <div class="profile_pic_journey">
                <p class="smogi_message">USER NAME<span class="edit_username edit"></span>
                    <p class="username_editable">
                    <?php
                    $profile = get_user_profile($user_id);
                    $user_display_name = $profile->user_display_name;

                    ?>
                <div class="ch_username_block">
                    <input class="change_username" type="text" data-watermark="Choose your user name" user_id="<?php echo $user_id; ?>"/>
                    <button id="update_username">Submit</button>
                    <p class="username_update_msg"></p>
                </div>
                    <?php
                    echo "<p class='user_display_name'>".$user_display_name."</p>";

                    ?>
                </p>
            </div>


            <div class="your_color">
                <p class="smogi_message">YOUR COLOR</p>
                <div class="charm <?php echo get_user_level($user_id)." color_".strtoupper($profile->color_main); ?>"></div>
            </div>

            <div class="your_interests">
                <p class="smogi_message">YOUR INTERESTS</p>
            </div>

            <div class="interests-selector">
                <!-- ----------------------------CHOOSE YOUR INTERESTS------------------------ -->
                <div class="confirmed_interests">
                    <div class="interest_listing" style="padding-bottom:0px;">
                        <span class="shade_overlay"></span>
                        <ul>
                        </ul>
                    </div>
                </div>
                <?php
                if(!$visited) {
                    ?>
                    <!--
                        <div class="invite_friend">

                            <div class="line"></div>
                            <p>Share the RANGOLI love</p>

                            <p>Earn $2 SMOGI Bucks when an invited friend shops on YOGASMOGA.com</p>

                            <div class="user_link">
                                <p>Your Invite link</p>

                                <p class="link"></p>
                                <span>Copy link</span>

                                <p>Invite friends to RANGOLI</p>
                            </div>
                        </div>
                    -->
                    <?php
                    make_journey_visited();
                }
//                ?>
<!--                <div class="row align-center" style="margin-top: 50px">-->
<!--                    <a class="continue_to_rangoli" href="--><?php //echo get_home_url()."/"; ?><!--" >Continue to RANGOLI</a>-->
<!--                </div>-->
                <!-- ------------------------------------------------------------------------- -->

            </div>
        </div>


    </div>
</div>
<div class="modal">
    <div class="row right close_cropper"><img src="<?php echo $media;?>/close.png" /></div>
<div id="croppic">

</div>
</div>

<?php
//get_footer();