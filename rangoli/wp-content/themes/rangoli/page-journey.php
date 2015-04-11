<?php
if (!is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
} else {
    $user = wp_get_current_user();
}

get_header();
?>
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/rangoli.css"/>
    <script src="<?php bloginfo('template_directory') ?>/js/rangoli.js"></script>
    <div class="journey-wrapper">
        <div class="color-page">
            <div class="page-head">
                <div class="step">
			<span>
				Step 1 of 2
				<span class="next"></span>
			</span>
                </div>
                <h1 class="page-heading align-center">Choose Your Color</h1>
            </div>
            <div id="color-slider">

            </div>
        </div>
        <div class="interest-page">
            <div class="page-head">
                <div class="step">
			<span>
				<span class="prev"></span>
				Step 2 of 2
				<span class="next"></span>
			</span>
                </div>
                <h1 class="page-heading align-center">Choose Your Interests</h1>
            </div>
            <div class="interests-selector" style="padding-top: 200px">

                <!-- ----------------------------CHOOSE YOUR INTERESTS------------------------ -->
                <div class="interest_listing">
                    <ul>
                        <?php
                        $user_id = get_current_user_id();
                        $ar = get_user_interests($user_id);
                        $args = array(
                            'type' => 'post',
                            'child_of' => 0,
                            'parent' => '',
                            'orderby' => 'name',
                            'order' => 'ASC',
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
                                if($ar) {
                                    if (count($ar) > 0) {
                                        if (isset($ar) && in_array($category->slug, $ar)) {
                                            $url = $interest_remove_url;
                                            $class = "remove";
                                        }
                                    }
                                }

                                if (function_exists('z_taxonomy_image_url'))
                                    echo "<li>
                                        <a  class='user-interest " . $class . "' href='" . $url . "'>
                                            <img src='" . z_taxonomy_image_url($category->term_id, null, 'medium') . "' />";
                                            $image = get_option( 'taxonomy_image_' . $category->term_id );
                                            if($image && $image!="")
                                                echo "<img src='".$image."' />";
                                    echo "</a>";


                              ?>
                                <?php
                              echo "<a href='javascript:void(0)'><span>" . $category->cat_name . "</span></a></li>";

                            }

                        }
                        ?>
                    </ul>
                </div>
                <!-- ------------------------------------------------------------------------- -->
                <div class="row">
                    <button class="next-confirmation-page">Choose 3+</button>
                </div>
            </div>
        </div>
        <div class="confirmation-page">
            <?php

            //  /////////////////////////////////////////////////////////// //

            $get_wp_user_registration_date  ;
            $get_magento_user_registration_date  ;
            $user_id = get_current_user_id();
            $user_info = get_userdata($user_id);
            $rangoli_user = get_user_profile_from_magento($user_id);
            //    print_r($rangoli_user);
            $main_color = $rangoli_user->color_main;
            $visited = 1;
            $visited = is_journey_first_time();
            $user_id = get_current_user_id();
            $user_info = get_userdata($user_id);
            if($visited){
                $welcome_message = "HI ".strtoupper($user_info->display_name).",";
                $smogiBucks_message = "Your profile has been updated.";
                $interest_message = "Your interests are";
                $color_message = "<p style='margin-top:35px;'>Your color is</p>";
            }
            else{
                $root = get_site_url();
                $root = str_replace("/rangoli","/",$root);
                $welcome_message = "WELCOME ".strtoupper($user_info->display_name).",";
                $smogiBucks_message = "You have 25 SMOGI Bucks just for signing up.</p><p>(Learn how to earn more <span>SMOGI BUCKS</span>)</p>";

                $magento_user = json_decode(file_get_contents($root . 'ys/session/getcustomerbyemail/email/' . $user_info->user_login));

                if ($magento_user) {
                    $create_date_mg = $magento_user->create_date;
                    $current_user_id = get_current_user_id();
                    $current_user = get_userdata($current_user_id);
                    $create_date_wp = $current_user->user_registered;
                    $create_date_wp = date('Y-m-d',$create_date_wp);
                    $smogi_bucks = get_user_smogi_bucks($current_user_id);

                    if(strtotime($create_date_mg) > strtotime($create_date_wp)){
                        $smogiBucks_message = "You have $smogi_bucks SMOGI Bucks.</p><p>(Learn how to earn more <span>SMOGI BUCKS</span>)</p>";
                    }

                }


                $interest_message = 'Thanks for being a part of RANGOLI! We are very excited that you are joining this color journey.
                        If you want to change your color, you can do that <a href="/rangoli/journey">here</a>.
                        Evolving interests? Change those <a style="cursor:pointer;" onclick="change_interest();"> here</a>.
                        Looking to take your RANGOLI to the next level? <a href="/smogi-bucks">Learn how</a>';
                $color_message="";
            }
            ?>

            <div class="confirmed_interests">
                <div class="row">
                    <h1 class="page-heading align-center"><?php echo $welcome_message; ?></h1>
                </div>
                <div class="row one align-center">
                    <p><?php echo $smogiBucks_message; ?></p>
                    <?php echo $color_message;  ?>
                </div>
                <div class="user_charm_display row" style="height: 120px; position: relative;">
                    <div class='row align-center'>
                        <?php

                            $user_level = get_user_level($user_id);
//                            $user_profile = get_user_profile($user_id);
//                            $main_color = $user_profile->color_main;
                        ?>
                        <span class='charmBig charmBig<?php echo $user_level;?>'></span>
                    </div>
                </div>
                <div class="interests-selector" style="padding-top: 30px">
                    <p class="text"><?php echo $interest_message;  ?></p>

                    <!-- ----------------------------CHOOSE YOUR INTERESTS------------------------ -->
                    <div class="confirmed_interests">
                        <ul class="selected" style="text-align:center">
                        </ul>
                    </div>
                    <?php
                        if(!$visited) {
                            ?>

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
                                <ul>
                                    <!--<li rel="facebook"><img src="<?php /**/
                                    ?>/rangoli/wp-content/themes/rangoli/images/fb.png"/>
                            </li>-->
                                    <li rel="email"><img
                                            src="<?php ?>/rangoli/wp-content/themes/rangoli/images/mail.png"/></li>
                                    <li rel="twitter"><img
                                            src="<?php ?>/rangoli/wp-content/themes/rangoli/images/tw.png"/></li>
                                </ul>
                            </div>
                        <?php
                            make_journey_visited();
                        }
                        ?>
                    <div class="row align-center" style="margin-top: 50px">
                        <a class="continue_to_rangoli" href="<?php echo get_home_url()."/"; ?>" >Continue to RANGOLI</a>
                    </div>
                    <!-- ------------------------------------------------------------------------- -->

                </div>
            </div>


        </div>
    </div>

    <script>
        var selectedColor, selectedShade, userId = <?php echo $user->ID; ?>;
        //var colors = {
        //	"ff5f01": {"shades": ["ff9c00", "ff7a01", "ff9c46", "f07400", "fe5e00", "ff4900"], "animation": "flower", "bg": "6e3bbe"},
        //	"fe0000": {"shades": ["ff3838", "ff2f53", "cc0033", "820000", "fe0000", "b40001"], "animation": "circh", "bg": "01abff"},
        //	"6f3cbf": {"shades": ["7767c9", "440077", "5e1567", "801f64", "802781", "6f3cbf"], "animation": "donut", "bg": "009e01"},
        //	"01abff": {"shades": ["00ceff", "87e2ff", "017eff", "2400fe", "0050ff", "000076"], "animation": "hexa", "bg": "404042"},
        //	"009e01": {"shades": ["85d979", "a1e901", "4eb800", "006401", "008600", "019e35"], "animation": "pie", "bg": "fec700"},
        //	"414143": {"shades": ["f1f1f3", "d1d2d4", "a7a8ac", "808185", "58595b", "231f20"], "animation": "circv", "bg": "fe5e00"},
        //	"fee600": {"shades": ["fffe88", "ffff3d", "ebd100", "fee600", "ffca00", "bba501"], "animation": "triangle", "bg": "fe0000"},
        //};

        var colors = {
            "color_FF6500": {
                "shades": [ "ff7a00",  "ff9c45", "f07400",  "ff5e00", "ff4900", "ff9d00"],
                "animation": "flower",
                "bg": "6e3bbe"
            }, /* orange */
            "color_fe0000": {
                "shades": ["ff2f53","ff3838" ,"810000" , "b40000", "cc0033", "ff0000"],
                "animation": "circh",
                "bg": "01abff"
            }, /*red*/
            "color_6f3cbf": {
                "shades": [ "7767c8",   "6f3bbe", "802780", "801f63", "5e1567", "440076"],
                "animation": "donut",
                "bg": "009e01"
            },
            "color_01abff": {
                "shades": ["2400ff","007eff" ,"86e2ff" , "00ceff", "000075", "004fff"],
                "animation": "hexa",
                "bg": "999999"
            },
            "color_009e01": {
                "shades": ["a0e900",  "006500", "009e34","008700", "86d979", "4eb800"],
                "animation": "pie",
                "bg": "fec700"
            },
            "color_414143": {
                "shades": ["a6a8ab","d0d2d3" ,"f1f1f2" , "231f20", "58595b", "808184"],
                "animation": "circv",
                "bg": "fe5e00"
            },
            "color_fee600": {
                "shades": ["ffbd00", "FFFF3D","ffe600" , "ffd700" , "ffdf53", "f0da4f"],
                "animation": "triangle",
                "bg": "fe0000"
            }
        };



        function change_interest(){
            $(".confirmation-page").slideUp();
            $(".interest-page").show();
        }
        function get_height(){
            $("#color-slider .arrow-next").height("100%");
            $("#color-slider .arrow-prev").height("100%");
        }
        $(window).resize(function(){
            get_height();
        })
        jQuery(document).ready(function ($) {
            count_interests()
            var rangoli = new $.Rangoli($("#color-slider"), colors);
            rangoli.initColorSlider();
            get_height();
            $("#color-slider .arrow-next .arrow").click(function(){
                $("#colors .next span").click();
//                alert();
            });
            $("#color-slider .arrow-prev .arrow").click(function(){
                $("#colors .prev span").click();
//                alert();
            });


            $("li.active .primary").click(function () {
                $(this).parent().addClass("animate");
            });
            $("svg .shade").click(function () {
                var shade = $(this).attr('fill');
                var color = $(this).closest('li.color').attr('data-color');
                color = color.replace("#", "");
                selectedColor = color;
                user_color_shade = shade ;
                fillcolor();

                var charm_class = $("#profile_charm").attr("class");
//                alert("charm_class: "+charm_class);
                var ar_charm = charm_class.split(" ");
                if(ar_charm.length == 3){
                    var level = ar_charm[2];
                    var color = selectedColor.toUpperCase();
                    $("#profile_charm").attr("class","charm color_"+color+" "+level);
                }

                selectedShade = shade.replace("#", "");
                $(this).closest('.shades').find('svg.bgsvg path.heart').css({
                    fill: '#ffffff'
                });
                $(".color-game").find('svg polygon:first').attr('fill', shade);
                $(".color-game").find('svg polygon').attr('stroke', shade).removeAttr('style');
                $(".menu-btn").find('svg rect').attr('fill', shade).removeAttr('style');
                $('.step').find('.next').fadeIn(200);
                setTimeout(function () {
                    $.post(homeUrl + 'rangoli/mage_wp_update_user_color.php', {
                        'user_id': userId,
                        'color_main': selectedColor,
                        'color_shade': selectedShade
                    }, function (resp) {
                        if (resp == "done") {
                            $('.color-page').slideUp();
                            $('.interest-page').slideDown(300, function () {
                                user_color_shade = "#" + selectedShade;
                                selectedShade = hexToRgb(selectedShade);
                                $(".interest_listing li a.remove svg path").css("fill", user_color_shade).css("stroke", user_color_shade);
                                $(".user-color-shade").css({'background': 'rgba(' + selectedShade + ',0.9)'});
                            });



                            $(".next-confirmation-page").click(function(){
                                if(getSelectedInterestCount()>=3) {
                                    $('.interest-page').slideUp();
                                    $(".confirmation-page").slideDown();
                                    copytoClipboard();
                                    $(".charmBig").addClass("Charmsbigcolor_"+selectedColor.toUpperCase());
                                    $(".confirmation-page").css("min-height", $(window).height());
                                    $(".invite_friend").find("li").hover(function () {
                                        $(this).css({
                                            "background": user_color_shade,
                                            "transition-duration": "500ms"
                                        });
                                    }, function () {
                                        $(this).css({
                                            "background": "#f2f2f2",
                                            "transition-duration": "500ms"
                                        });
                                    });
                                    $(window).scrollTop(0);
                                    var selected_interests = '';
                                    $(document).find("a.remove").each(function () {
                                        $(this).attr("href", "");
                                        selected_interests = selected_interests + '<li>' + $(this).parent().html() + '</li>';

                                    });

                                    $(".confirmed_interests ul.selected").html(selected_interests);
                                    //                                $("a").remove(".remove");
                                    $(".link").css("color", user_color_shade);
                                }
                            });
                        } else {
                            alert('OOps! there was an error saving your color, please try again.')
                        }
                        ;
                        $('.step span span.prev').css({
                            "background": "url('<?php echo get_site_url(); ?>/wp-content/themes/rangoli/images/prvarw1.png') no-repeat scroll 0 center rgba(0, 0, 0, 0)",
                            "display": "block"
                        });
                        $('.interest-page .step span span.next').css("background", "transparent");
                    });
                }, 0)
            });
            /*$('.color-page .step .next').click(function(){

             })*/
            $('.step .prev').click(function () {
                $('.color-page').slideDown();
                $('.interest-page').slideUp();
            })
        });
    </script>

<?php

get_footer();

?>