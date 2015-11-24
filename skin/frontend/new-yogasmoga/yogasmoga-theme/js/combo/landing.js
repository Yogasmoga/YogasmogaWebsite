var winH;
jQuery(document).ready(function () {
    positionBanners();
    descriptionPosition()
    init();
    getActiveSlide();
    winH = jQuery(window).height();
    jQuery(window).scroll(function () {
        positionBanners();
    });
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

    var sliderMainImageHeight = jQuery(".product_set .side2 .product_container .product_slider .slider img").height();
    jQuery(".section").height(sliderMainImageHeight + 80);


    jQuery(".contain_product .side1 .buy_product a.quick_look, .product_set .side2 span.reverse_flip").click(function (e) {
        e.preventDefault();
        var linkHtml = "SEE DETAILS <b>&gt;</b>";
        jQuery(".toggle_description").not(jQuery(this)).html(linkHtml);
        jQuery(".toggle_description").not(jQuery(this)).removeClass("close");
        jQuery(".description_box").removeClass("show");

        var thisSide1 = jQuery(this).closest(".product_set").find(".side1");
        var thisSide2 = jQuery(this).closest(".product_set").find(".side2");
        jQuery(".side1").not(thisSide1).removeClass("inverse-flipped");
        jQuery(".side2").not(thisSide2).addClass("flipped");

        jQuery(this).closest(".product_set").find(".side1").toggleClass("inverse-flipped");
        jQuery(this).closest(".product_set").find(".side2").toggleClass("flipped");
    });

    jQuery(".toggle_description").click(function () {
        //jQuery(".close_desc").click();
        descriptionPosition();
        var linkHtml = jQuery(this).html();
        if(linkHtml == "SEE DETAILS <b>&gt;</b>"){
            jQuery(".description_box").removeClass("show");
            linkHtml = "CLOSE DETAILS";
            jQuery(this).html(linkHtml);
            jQuery(this).addClass("close");
        }else{
            jQuery(this).removeClass("close");
            linkHtml = "SEE DETAILS <b>&gt;</b>";
            jQuery(this).html(linkHtml);
        }

        linkHtml = "SEE DETAILS <b>&gt;</b>";
        jQuery(".toggle_description").not(jQuery(this)).html(linkHtml);
        jQuery(".toggle_description").not(jQuery(this)).removeClass("close");

        jQuery(".description_box").not(jQuery(this).closest(".section").find(".description_box")).removeClass("show");
        jQuery(this).closest(".section").find(".description_box").toggleClass("show");
    });
    /*jQuery(".close_desc").click(function () {
        jQuery(".description_box").css({
            "bottom": "-130px",
            "opacity": 0
        });
    });*/
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

    jQuery(".middle_desc>div a").click(function(e){
        e.preventDefault();
    });
    jQuery(".middle_desc>div").click(function(){
        var url = jQuery(this).find("a").attr("href");
        window.open(url,'_blank');
    });

}

var sectionIndex = 1;

function getActiveSlide() {
    var sectionOffsets = [0];
    jQuery(".section").each(function () {
        sectionOffsets.push(jQuery(this).offset().top);
    });
    setActiveLink(sectionOffsets);
    jQuery(window).scroll(function () {
        setActiveLink(sectionOffsets);
    });

}
function setActiveLink(sectionOffsets) {
    var winScrollTop = jQuery(window).scrollTop() - jQuery(".section").height() + 255;
    jQuery.each(sectionOffsets, function (index) {
        if (sectionOffsets.length > index + 1) {
            if (winScrollTop > sectionOffsets[index]) {
                sectionIndex = index + 1;
            }
        }
    });
    jQuery(".gift_set_link").removeClass("active");
    jQuery(".gift_set_link:nth-child(" + sectionIndex + ")").addClass("active");
    jQuery(".section").removeClass("active");
    jQuery(".section:nth-child(" + sectionIndex + ")").addClass("active");
    var setName = jQuery(".gift_set_link:nth-child(" + sectionIndex + ")").find(".pname>span").text()+" SET";
    var setPrice = jQuery(".gift_set_link:nth-child(" + sectionIndex + ")").find(".pprice").text();

    jQuery(".box.set_name .product_name").html(setName);
    jQuery(".box.set_name .product_price").html(setPrice);

    currentCityIndex = sectionIndex - 1;
    showTemperature();

    var mapPoint = jQuery(".gift_set_link:nth-child(" + sectionIndex + ")").attr("data-map");
    mapPoint = mapPoint.split(",");
    var topPosition = mapPoint[0];
    var leftPosition = mapPoint[1];

    jQuery(".world_map i").css({
        "top": topPosition + "px",
        "left": leftPosition + "px"
    })
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