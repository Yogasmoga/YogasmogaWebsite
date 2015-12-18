var winH;

jQuery(document).ready(function () {

    positionBanners();
    jQuery("#fullpage").css("visibility","hidden");

/*
    jQuery("#fullpage").css("visibility","hidden");
    descriptionPosition();

    getActiveSlide();
    winH = jQuery(window).height();
    jQuery(window).scroll(function () {
        positionBanners();
    });
*/
});

jQuery(window).load(function(){

    jQuery(".top_banners").show();

    positionBanners();
    descriptionPosition();

    winH = jQuery(window).height();
    jQuery(window).scroll(function () {
        positionBanners();
    });

    init();

    var sliderMainImageHeight = jQuery(".product_set .side2 .product_container .product_slider .slider img").height();
    jQuery(".section").height(sliderMainImageHeight + 80);
    jQuery("#fullpage").css("visibility","visible");

    getActiveSlide();
});

function positionBanners() {
    if (jQuery(window).scrollTop() >= 103) {
        jQuery(".setmargin").show();
        jQuery(".top_banners").addClass("fixed");
        jQuery(".page-title_fixed").css("visibility", "visible");
    }
    else {
        jQuery(".top_banners").removeClass("fixed");
        jQuery(".setmargin").hide();
        jQuery(".page-title_fixed").css("visibility", "hidden");
    }
}


function init() {

    jQuery(".contain_product .side1 .buy_product a.quick_look, .product_set .side2 span.reverse_flip").click(function (e) {
        e.preventDefault();
        var linkHtml = "SEE DETAILS <b>&gt;</b>";
        jQuery(".toggle_description").not(jQuery(this)).html(linkHtml);
        jQuery(".toggle_description").not(jQuery(this)).removeClass("close_description");
        jQuery(".description_box").removeClass("show");

        var thisSide1 = jQuery(this).closest(".product_set").find(".side1");
        var thisSide2 = jQuery(this).closest(".product_set").find(".side2");
        jQuery(".side1").not(thisSide1).removeClass("inverse-flipped");
        jQuery(".side2").not(thisSide2).addClass("flipped");

        jQuery(this).closest(".product_set").find(".side1").toggleClass("inverse-flipped");
        jQuery(this).closest(".product_set").find(".side2").toggleClass("flipped");

        /********* close description when quick look is clicked *************/
        jQuery(".toggle_description").removeClass("close_description");
        linkHtml = "SEE DETAILS <b>&gt;</b>";
        jQuery(".toggle_description").html(linkHtml);
        jQuery(".description_box").css('transition-duration', '500ms').removeClass("show").removeClass("show_fast");

    });

    jQuery(".toggle_description").click(function () {
        //jQuery(".close_desc").click();
        descriptionPosition();
        var linkHtml = jQuery(this).html();
        if (linkHtml == "SEE DETAILS <b>&gt;</b>") {
            jQuery(".description_box").removeClass("show").removeClass("show_fast");
            linkHtml = "CLOSE DETAILS";
            jQuery(this).html(linkHtml);
            jQuery(this).addClass("close_description");

            jQuery(".description_box").not(jQuery(this).closest(".section").find(".description_box")).removeClass("show");
            jQuery(this).closest(".section").find(".description_box").addClass("show");

        } else {
            jQuery(this).removeClass("close_description");
            linkHtml = "SEE DETAILS <b>&gt;</b>";
            jQuery(this).html(linkHtml);
            jQuery(".description_box").css('transition-duration', '500ms').removeClass("show").removeClass("show_fast");
        }

        linkHtml = "SEE DETAILS <b>&gt;</b>";
        jQuery(".toggle_description").not(jQuery(this)).html(linkHtml);
        jQuery(".toggle_description").not(jQuery(this)).removeClass("close_description");

    });
    /*jQuery(".close_desc").click(function () {
     jQuery(".description_box").css({
     "bottom": "-130px",
     "opacity": 0
     });
     });*/

    jQuery(".gift_set_link").hover(
        function () {
            if(jQuery(this).hasClass("active"))
                return;

            jQuery(this).removeClass("gift-set-final");
            jQuery(this).addClass("gift-set-hover");
        },
        function () {
            if(jQuery(this).hasClass("active"))
                return;

            jQuery(this).removeClass("gift-set-hover");
            jQuery(this).addClass("gift-set-final");
        }
    );

    jQuery(".gift_set_link").click(function () {
        var index = jQuery(this).index() + 1;
        if (jQuery(".section:nth-child(" + index + ")").length > 0) {
            var scrollTop = jQuery(".section:nth-child(" + index + ")").offset().top;
            scrollTop = scrollTop - 255;
            if (!isNaN(scrollTop)) {
                jQuery("body, html").stop().animate({
                    "scrollTop": scrollTop
                }, 500);
            }
        }
    });

    jQuery(".middle_desc>div a").click(function (e) {
        e.preventDefault();
    });
    jQuery(".middle_desc>div").click(function () {
        var url = jQuery(this).find("a").attr("href");
        //window.open(url,'_blank');
        window.location = url;
    });

//    jQuery(".gift_sets_landing_page").show();
}

var sectionIndex = 0;

function getActiveSlide() {
    var sectionOffsets = [0];
    jQuery(".section:visible").each(function () {
        sectionOffsets.push(jQuery(this).offset().top);
    });
    setActiveLink(sectionOffsets);
    jQuery(window).scroll(function () {
        setActiveLink(sectionOffsets);
    });

}
function setActiveLink(sectionOffsets) {
    var winScrollTop = jQuery(window).scrollTop() - jQuery(".section:visible").height() + 255;
    jQuery.each(sectionOffsets, function (index) {
        if (sectionOffsets.length > index + 1) {
            if (winScrollTop > sectionOffsets[index]) {
                sectionIndex = index;
            }
        }
    });
    jQuery(".gift_set_link").removeClass("active");
    jQuery(".gift_set_link:visible").eq(sectionIndex).addClass("active");
    jQuery(".section").removeClass("active");
    jQuery(".section:visible").eq(sectionIndex).addClass("active");

    ////////////////////////////////////////////////////////
    // Code for description slider keep changing once open//
    ////////////////////////////////////////////////////////
    var sectionH = jQuery(".section").height();
    if (winH - 250 < sectionH) {
        if (jQuery(".description_box").hasClass("show") || jQuery(".description_box").hasClass("show_fast")) {
            if (!jQuery(".section:visible").eq(sectionIndex).find(".toggle_description").hasClass("close_description")) {

                jQuery(".description_box").css({
                    'transition-duration': '0ms'
                });

                descriptionPosition();

                var currentToggleDescriptionLink = jQuery(".section:visible").eq(sectionIndex).find(".toggle_description");
                var currentDescriptionBox = jQuery(".section:visible").eq(sectionIndex).find(".description_box");
                var linkHtml;
                jQuery(".description_box").removeClass("show").removeClass("show_fast");
                linkHtml = "CLOSE DETAILS";
                currentToggleDescriptionLink.html(linkHtml).addClass("close_description");

                linkHtml = "SEE DETAILS <b>&gt;</b>";
                jQuery(".toggle_description").not(currentToggleDescriptionLink).html(linkHtml).removeClass("close_description");

                jQuery(".description_box").not(currentDescriptionBox).removeClass("show").removeClass("show_fast");
                currentDescriptionBox.addClass("show_fast");
            }
        }
    } else {
        jQuery(".description_box").css({
            'transition-duration': '500ms'
        });
    }
    ///////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////

    if(jQuery.trim(jQuery(".gift_set_link:visible").eq(sectionIndex).find(".pname>span").text()) != "" && jQuery.trim(jQuery(".gift_set_link:visible").eq(sectionIndex).find(".pname>span").text()) != null) {
        var setName = jQuery(".gift_set_link:visible").eq(sectionIndex).find(".pname>span").text() + " SET";
//        var setPrice = jQuery(".gift_set_link:visible").eq(sectionIndex).find(".pprice").text();
        var setPrice = jQuery(".gift_set_link:visible").eq(sectionIndex).find(".pprice").attr('rel');

        if(setPrice=="sold out")
            jQuery(".box.set_name .product_price").html("Sold Out");
        else {
            var arSetPrice = setPrice.split(":");
            jQuery(".box.set_name .product_price").html("$" + arSetPrice[1] + " <b>(a $" + arSetPrice[0] + " value)</b>");
        }

        jQuery(".box.set_name .product_name").html(setName);
        //jQuery(".box.set_name .product_price").html(setPrice);

        currentCityIndex = sectionIndex;

        showTemperature();

        var mapPoint = jQuery(".gift_set_link:visible").eq(sectionIndex).attr("data-map");
        mapPoint = mapPoint.split(",");
        var topPosition = mapPoint[0];
        var leftPosition = mapPoint[1];

        jQuery(".world_map i").css({
            "top": topPosition + "px",
            "left": leftPosition + "px"
        })
    }
}


jQuery(window).resize(function () {
    winH = jQuery(window).height();
    var sliderMainImageHeight = jQuery(".product_set .side2 .product_container .product_slider .slider img").height();
    jQuery(".section").height(sliderMainImageHeight + 80);
    descriptionPosition();
    getActiveSlide();
});

function descriptionPosition() {
    var sectionH = jQuery(".section").height();
    if (winH - 250 < sectionH) {
        jQuery(".description_box").css("position", "fixed");
    }
    else {
        jQuery(".description_box").css("position", "absolute");
    }
}