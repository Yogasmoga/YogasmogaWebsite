//jQuery.noConflict();
$j = jQuery.noConflict();
$j(function () {
    var html = $j('html, body'), navContainer = $j('.nav-container'), navToggle = $j('.nav-toggle'), navDropdownToggle = $j('.has-dropdown');

    // Nav toggle
    navToggle.on('click', function (e) {
        var $jthis = $j(this);
        e.preventDefault();
        $jthis.toggleClass('is-active');
        navContainer.toggleClass('is-visible');
        html.toggleClass('nav-open');
    });

    // Nav dropdown toggle
    navDropdownToggle.on('click', function () {
        var $jthis = $j(this);
        $jthis.toggleClass('').children('ul').toggleClass('is-visible');
    });

    navDropdownToggle.on('click', '*', function (e) {
        e.stopPropagation();
    });
});
$j(document).ready(function () {
    $j(".arrow-tag").click(function () {
        $j(this).toggleClass('is-active');
    });
    $j(".nav-toggle").click(function () {
        $j(".cross-btn").fadeIn();
        $j('.nav-container').fadeIn();
    });
    $j(".cross-btn").click(function (){
        $j(".cross-btn").fadeOut();
        $j('.nav-container').fadeOut();
    });

    $j(".menu-item .arrow-tag").click(function () {
        $j(this).parent().children(".menu-item .nav-dropdown").slideToggle();
    });

    $j("#menu_signup").click(function () {
        $j("#error_msg").html("");
        $j(".f-right label").removeClass("current");
        $j(".cross-btn").fadeOut();
        $j('.nav-container').fadeOut();
        $j("#popForm").show();
        init_watermark();
    });
    $j(".description-block .arrow-tag").click(function () {
        $j(".description-block .arrow-tag").not($(this)).removeClass("is-active");
        $j(".detail-view .inner-content").not($j(this).parent().children(".detail-view .inner-content")).slideUp();
        $j(this).parent().children(".detail-view .inner-content").slideToggle();
        //$j(this).toggleClass("is-active");
    });

    $j("#opc-cart .arrow-tag").click(function () {
        $j("#checkout-step-cart").slideToggle();
    });
    /************** my account page nav end */

    //$j(".my-account-block .sign-in-box .arrow-tag").click(function () {
    //    $j(".my-account-block .account-nav ").slideToggle();
    //});
    /************** my account page nav end */

    $j(".sign-in-box .arrow-tag").click(function () {

        $j(".account-nav.l-align").slideToggle();
    });

    $j(".smogi-content #show-tag").click(function () {
        $j(".smogi-content .hidden-txt").toggle();
        $j(this).hide();
        $j(".close-icn").fadeOut();
        $j("#link2content").hide();
        $j("#link3content").hide();
        $j("#link1content .close-icn").fadeIn();
    });

    $j("#link1content .close-icn").click(function(){
        $j(".smogi-content .hidden-txt").toggle();
        $j(".close-icn").fadeOut();
        $j("#link2content").hide();
        $j(".read-more").show();
        $j("#link3content").hide();
    });
    $j("#linkwrapper li a").click(function (e) {
        e.preventDefault();
        var obj_id = $j(this).attr("rel");
        if (obj_id == "link2content") {
            $j("#buck-balance-blk1").click();
        }
        else if (obj_id == "link3content") {
            $j("#buck-balance-blk2").click();
        }

        var offset = $j("#" + obj_id).offset().top - 88;

        $j("body,html").animate({
            "scrollTop": offset
        }, 200);

        //$j(".account-nav.l-align").slideUp();
        $j(".arrow-icon").click();
    });

    $j(".inner-part1").click(function () {
        $j("#linkwrapper li a[rel='link2content']").click();

    });
    $j(".inner-part2").click(function () {
        $j("#linkwrapper li a[rel='link3content']").click();
    });


});


/*////////////////////////////////////////////////////////////////////////////////////////////*/

        jQuery(document).ready(function($){
           $(".already_signed_up").click(function(){
               openLogin();
               closeSignup();
           });


            $("#sizechart").click(function(){
                var size_chart = $(".lg-size-chart").html();
                $(".size_chart_popup").fadeIn();
                $(".size_chart_popup .chart_container").html(size_chart);
            });
            $(".close_size_cart").click(function(){
                $(".size_chart_popup").fadeOut();
            });
            $(".video-block.f-right > img").click(function(){
                $(".html-vid-pop.html-fit-vid-popup").fadeIn();
            });

            $(".close_video_popup").click(function(){
                $(".html-vid-pop").fadeOut();
            });
            $(".vid-pl-btn").click(function(){
                $(".html-des-vid-popup").fadeIn();
            });

            $(".arrow-icon").click(function(){
                $(this).toggleClass("active");
                $(".account-nav.l-align").slideToggle();
            });
            $(".story-box .txt-cnt a").click(function(e){
                e.preventDefault();
            });
            $(".story-box .textContainer a").click(function(e){
                e.preventDefault();
            });

            $(".story-box .txt-cnt").click(function(){
                $(this).next().show();
                $(".story-box .txt-cnt").next().removeClass("has_slider");
                $(this).next().addClass("has_slider");
                $(".story-box .inside-content").not($(this).next()).hide();
                var top = $(this).offset().top;
                $(window).scrollTop(top-88);
                $(".story-box").find(".close-icn").hide();
                $(this).parent().find(".close-icn").fadeIn();
                $(".flexslider").resize();
                $(".flexslider .slides").css("margin-left",0);
            });
            $(".story-box .close-icn").click(function(){
                $(this).fadeOut();
                $(this).next().next().hide();
            });
            $("p.apply_promo_label > span").click(function(){
                $(".apply_promo_code_div").show();
                $(this).parent().remove();
            });
             
			  $("p.apply_smogi_label > span").click(function(){
                $(".apply_smogi_code_div").show();
                $(this).parent().remove();
            });

            $(".arrow-tag.narrow").click(function(){
                $(".arrow-tag.narrow").next().not($(this).next()).slideUp();
                $(".arrow-tag.narrow").not($(this)).removeClass("is-active");
                $(this).next().slideToggle();
            });
            $(".buck-balance-title .arrow-tag").click(function(){
                $(".buck-balance-title .arrow-tag").removeClass("is-active");
                $(".buck-balance-title").not($(this).parent()).next().hide();
                $(".close-icn").hide();
                $(".smogi-icn").removeClass("active");
                $(".buck-balance-title .close-icn").not($(this).parent().find(".close-icn")).fadeOut();
                $(this).parent().next().slideDown(0);
                $(this).parent().find(".close-icn").fadeIn();
                $(".read-more").show();
                $(".smogi-content .hidden-txt").hide();
                $(this).parent().find(".smogi-icn").addClass("active");
                var top = $(this).parent().offset().top;
                $(window).scrollTop(top-88);
            });
            $(".buck-balance-title .close-icn").click(function(){
                $(".smogi-icn").removeClass("active");
                $(".buck-balance-title .arrow-tag").removeClass("is-active");
                $(this).fadeOut();
                $(this).parent().find(".smogi-icn").removeClass("active");
                $(this).closest(".buck-balance-title").next().slideUp();
            });
            $(".ys_static_page_dropdown li a").click(function(e){
                e.preventDefault();
                $(".arrow-icon").click();
                $(".story-box .close-icn").click();
                var heading = $(this).attr("data-heading");
                var obj_id = $(this).attr("rel");
                var obj =$("#" + obj_id);
                if(obj.length>0) {
                    var top = obj.offset().top;
                    top = top - 88;
                    $("html,body").animate({
                        scrollTop: top
                    }, 200);
                    $("#" + obj_id + " .txt-cnt").click();
                    $(".sign-in-box h1").html(heading);
                }
                else{
                    window.location = $(this).attr("href");
                }
            });

            $(".see_our_colors").click(function(){
                $(".colors_list").slideToggle();
                $(this).find("span").toggleClass("active");
            });
            $(".customer_gender_selection > div > label").click(function(){
                $(".customer_gender_selection > div > label").removeClass("selected");
                $(this).addClass("selected");
            });

        });


jQuery(window).load(function(){
    var height = jQuery(".productimagecontainer .flexslider li img").height();
    var newSliderImg = jQuery(".new-slider li img").height();
    jQuery(".has_slider .new-slider .flex-control-nav").show();
    jQuery(".has_slider .new-slider .flex-control-nav").css("top",newSliderImg);

    jQuery(".productimagecontainer .flexslider").css("height",height);
    jQuery(".productimagecontainer ").css("height",height);
    var ww = jQuery(window).width();
    var wh = jQuery(window).height();
    if(ww < wh){
        jQuery("video").css("top","30%");
    }
    else{
        jQuery("video").css("top","0%");
    }

});
jQuery(window).resize(function(){
    var height = jQuery(".productimagecontainer .flexslider img").height();
    jQuery(".productimagecontainer .flexslider").css("height",height);
    jQuery(".productimagecontainer ").css("height",height);
    var newSliderImg = jQuery(".has_slider .new-slider li img").height();
    jQuery(".has_slider .new-slider .flex-control-nav").css("top",newSliderImg);

    var ww = jQuery(window).width();
    var wh = jQuery(window).height();

    if(ww < wh){
        jQuery("video").css("top","30%");
    }
    else{
        jQuery("video").css("top","0%");
    }

});

