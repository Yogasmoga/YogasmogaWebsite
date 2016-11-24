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
        jQuery(".dropdown_content").slideUp();
        jQuery(".toggle_dropdown").removeClass("active");
        jQuery(".account-nav.l-align.ys_static_page_dropdown").slideUp();		
        jQuery(".sign-in-box .arrow-icon").removeClass("active");
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
        //$j(this).parent().children(".menu-item .nav-dropdown").slideToggle();
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
    $j(".description-block .detail-view a").click(function(e){e.preventDefault();$(this).next().click();});

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
        $j("#linkwrapper li a").not($j(this)).removeClass("active_link");
        $j(this).addClass("active_link");
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
    /* **************YS MENU ACCORDIAN**************** */
       $(".level1>li>span.arrow-tag").click(function(){
            $(".level1>li>span.arrow-tag").not($(this)).removeClass("is-active");
            var child = $(this).parent().children("ul");
           // $(".level1 li ul").not(child).hide();//for new design
			$(".level2 li ul").hide(); //for new design			
            $(".level2 li>span.arrow-tag").removeClass("is-active");
            child.toggle();
            $(".menu-item.additional_links ul").show();
        });
        $(".level2>li>span.arrow-tag").click(function(){
            $(".level1>li.username>span.arrow-tag").removeClass("is-active");//for new design
			$(".level1>li.username>ul").hide();//for new design
			$(".level2>li>span.arrow-tag").not($(this)).removeClass("is-active");
            var child = $(this).parent().children("ul");
            $(".level2 li ul").not(child).hide();			
            $(".level3 li>span.arrow-tag").not($(this)).removeClass("is-active");
            child.toggle();
        });
        $(".level3>li>span.arrow-tag").click(function(){
            $(".level3>li>span.arrow-tag").not($(this)).removeClass("is-active");
            var child = $(this).parent().children("ul");
            $(".level3 li ul").not(child).hide();
            child.toggle();
        });
    /* *********************************************** */

    $("#sizechart").click(function(){
        var size_chart = $(".lg-size-chart").html();
        $(".size_chart_popup").fadeIn();
        $(".size_chart_popup .chart_container .size-table-cell").html(size_chart);
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
		//$(".account-nav-box").toggleClass('showanb');
		//check if element has showanb class --> remove showanb class with a delay
		   if ($(".account-nav-box").hasClass('showanb')) {
			 var delay = 400; //ms
			 setTimeout(function(){
				 $(".account-nav-box").removeClass('showanb');
			 },delay );
		   }
		   // element doesn't have showanb class --> add it
		   else {
			 $(".account-nav-box").addClass('showanb');
		   }
		
    });
    $(".story-box .txt-cnt a").click(function(e){
        e.preventDefault();
    });
    $(".story-box .textContainer a").click(function(e){
        e.preventDefault();
    });

    $(".story-box .txt-cnt").click(function(){
        $(this).next().show();
        $(".story-box .txt-cnt .bottom-text").show();
        $(this).find(".bottom-text").hide();
        $(".story-box .txt-cnt").next().removeClass("has_slider");
        $(this).next().addClass("has_slider");
        $(".story-box .inside-content").not($(this).next()).hide();
        $(".page_block .block_content").hide();
        var rel_id = $(this).parent().attr("id");
        $(".ys_static_page_dropdown a").removeClass("active-link");
        $(".ys_static_page_dropdown a[rel='"+rel_id+"']").addClass("active-link");
        var heading = $(".ys_static_page_dropdown a[rel='"+rel_id+"']").attr("data-heading");
        $(".sign-in-box h1").html(heading);
        var top = $(this).offset().top;
        $(window).scrollTop(top-88);
        $(".story-box").find(".close-icn").hide();
        $(this).parent().find(".close-icn").fadeIn();
        $(".flexslider").resize();
        $(".flexslider .slides").css("margin-left",0);

        var parent = $(this).closest(".story-box");
        var img_height = parent.find(".slides li:first-child img").height();
        parent.find(".flex-direction-nav").show().css("top",(img_height/2)-10);

    });
    $(".page_block .block_thumbnail").click(function(){
        $(this).next().show();
        $(".page_block .block_thumbnail .overlay-text .text").show();
        $(this).find(".overlay-text .text").hide();
        $(".page_block .block_thumbnail").next().removeClass("has_slider");
        $(this).next().addClass("has_slider");
        $(".page_block .block_content").hide();
        $(this).parent().find(".block_content").show();
        var rel_id = $(this).parent().attr("id");
        $(".ys_static_page_dropdown a").removeClass("active-link");
        $(".ys_static_page_dropdown a[rel='"+rel_id+"']").addClass("active-link");
        var heading = $(".ys_static_page_dropdown a[rel='"+rel_id+"']").attr("data-heading");
        $(".sign-in-box h1").html(heading);
        $(".story-box .inside-content").hide();
        var top = $(this).offset().top;
        $(window).scrollTop(top-88);
        $(".page_block").find(".close-icn").hide();
        $(this).parent().find(".close-icn").fadeIn();
        $(".flexslider").resize();
        $(".flexslider .slides").css("margin-left",0);

        var parent = $(this).closest(".page_block");
        parent.find(".flex-direction-nav").show();

    });
    $(".story-box .close-icn").click(function(){
        $(this).fadeOut();
        $(this).next().next().hide();
        $(".story-box .txt-cnt .bottom-text").show();
    });
    $("p.apply_promo_label > span").click(function(){
        $("#error_msg_coupon").html("");
        $(".apply_promo_code_div").show();
        $(".apply_smogi_code_div").hide();
    });
	$("p.apply_promo_label > span").click(function(){
		if($(this).hasClass('add-code')){
			$("#coupon_code").focus();
		}		
	});
	
    $("p.apply_smogi_label > span").click(function(){
        $("#error_msg_smogi").html("");
        $(".apply_smogi_code_div").show();
        $(".apply_promo_code_div").hide();
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
    $(".ys_static_page_dropdown li a,.static_page li a").click(function(e){
        e.preventDefault();
        $(".ys_static_page_dropdown li a,.static_page li a").not($(this)).removeClass("active_link");
        $(this).addClass("active_link");
        $(".arrow-icon").removeClass("active");
        $(".account-nav.l-align.ys_static_page_dropdown").slideUp();
        $(".story-box .close-icn").click();
        $(".page_block .block_thumbnail .close-icn").click();
        var heading = $(this).attr("data-heading");
        var obj_id = $(this).attr("rel");
        var obj =$("#" + obj_id);
        var type = window.location.hash.substr(1);
        if(obj.length>0) {
            var top = obj.offset().top;
            top = top - 88;
            $("html,body").animate({
                scrollTop: top
            }, 200);
            $("#" + obj_id + " .block_thumbnail").click();
            $("#" + obj_id + " .txt-cnt").click();
            $(".sign-in-box h1").html(heading)
            $(".help_page").hide();
            $(".help_page#"+obj_id).show();

        }
        else{
            window.location = $(this).attr("href");
        }
    });

    $(".see_our_colors").click(function(){
        //$(".colors_list").toggle();
        //$(this).find("span").toggleClass("active");
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



jQuery(document).ready(function($){
   $(".help_page>ul>li>p,.help_page li>.toggle").click(function(){
       $(".help_page li>.toggle").not($(this).parent().find(".toggle")).removeClass("active");
       $(".help_page>ul>li>p,.help_page li").not($(this).parent()).removeClass("active");
       $(this).parent().toggleClass("active");
       $(this).parent().find(".answer_content").slideToggle(200);
       $(".help_page>ul>li>.answer_content").not($(this).parent().find(".answer_content")).slideUp(200);
       $(this).parent().find(".toggle").toggleClass("active");
   });
    //$(".level2 >li:first-child .toggle-ys-menu").click();


    /*$(".sign-in-box h1").click(function(){
        $(this).parent().find(".toggle_dropdown").click();
    });*/
/*
    $(".checkout-onepage-index .head").each(function(){
        $(this).click(function(){
            $(".checkout-onepage-index .head").not($(this)) .next().hide();
            $(this).next().slideDown();
        })
    });
*/

    $(".cross_popup ,  #ajaxlogin_close_icon,.already_signed_up,.new_customer, #ajaxlogin_forgot_pwd_link ,#ajaxlogin_link").click(function(){
        $("#err_msg").html("");
        $("#error_msg").html("");
        $("#err_pass").html("");
        jQuery(".ajaxlogin_forgot_pwd_actions").removeClass("active");
        jQuery("#ajaxlogin_button_send").removeClass("active");
        jQuery("#create_account").removeClass("active");
    });

    $("#pagetitle").click(function(){
        $(this).closest(".sign-in-box").find(".arrow-icon").click();
    });

    $(".detail-page .description-block .first-list .design-feature .inner-content .inner-feature svg").click(function(){
        $(".html-vid-pop.html-des-vid-popup").fadeIn();
    });

    $(".fabric_detail_mobile ul li > p:first-child").click(function(){
        $(".fabric_detail_mobile ul li > p:first-child").not($(this)).removeClass("active");
        $(this).toggleClass("active");
        $(".fabric_detail_mobile ul li > p:first-child +p").not($(this).next()).slideUp();
        $(this).next().slideToggle();
    });

    /*$(".invite-friend a").click(function(e){
        e.preventDefault();
        openLogin();
    });*/
    $("#shopping_arrow").click(function(){
       $(".section").removeClass("active");
        $("#opc-billing .head + div").hide();
        $("#opc-shipping .head + div").hide();
        $("#opc-shipping_method .head + div").hide();
        $("#opc-payment .head + div").hide();
        $("#opc-review .head + div").hide();
        $("#opc-billing").removeClass("completed");
        $("#opc-shipping").removeClass("completed");
        $("#opc-shipping_method").removeClass("completed");
        $("#opc-payment").removeClass("completed");
        $("#opc-review").removeClass("completed");
    });

    $(".sign-in-box h1").click(function(){
        $(this).next().click();
    });

    $(".one-page-checkout .section .head").click(function(){
       //$(this).find(".arrow-tag").click();
    });
    $(".inner-aurum li .innr-txt").click(function(){$(this).next().click();})
    $(".see_our_colors > p").click(function(){$(this).next().click();})

    var placeholder_smogi = $("#points_to_be_used").attr("placeholder");
    var placeholder_coupon = $("#coupon_code").attr("placeholder");

    $("#points_to_be_used").focus(function(){
        $(this).attr("placeholder","");
    });
    $("#points_to_be_used").blur(function(){
        $(this).attr("placeholder",placeholder_smogi);
    });
    $("#coupon_code").focus(function(){
        $(this).attr("placeholder","");
    });
    $("#coupon_code").blur(function(){
        $(this).attr("placeholder",placeholder_coupon);
    });
	
	/******** final level nav task ********/
	var topmenutitle = $('.sign-in-box h1').text().toLowerCase().trim();
	
   
   
    $(".sub_menu_links .menu-link,.dropdown_links .sub_cat").each(function() {   // note that the .each() handler has two parameters that can be used also
		var elm = $(this);
		var currn = elm.text().toLowerCase().trim();
		
		if(currn == topmenutitle )
		{
			elm.addClass("active");
			//elm.parentsUntil('level2').find(".arrow-tag").click();
			elm.closest('.sub_menu_links, ul').show();
			//elm.closest('ul').prev('span').not($(this)).addClass('active');
			elm.closest('ul').prev('span').addClass('active');
			elm.closest('.sub_menu_links').prev('.arrow-tag').addClass('is-active');
			elm.closest('.level3').show();
			elm.closest('.level3').prev('.arrow-tag').addClass('is-active');
			elm.parent('li').addClass("bgclr");
		}
		
		
    });	
	
	/******** final level nav ends********/
	
	
});