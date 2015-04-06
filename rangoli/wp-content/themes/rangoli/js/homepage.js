var offset_first;
var offset_second;
var offset_third;
var offset_fourth;
var offset_fifth;

$(window).load(function () {
    $('.flexslider').flexslider({
        start: function () {

            $(".flex-active-slide .play-video").addClass("fadeInUp").addClass("animated");
            $(" .over-the-slide").css("opacity", 1);
        }
    });
});

$(window).load(function () {
    offset_first = $(".first").offset();
    offset_second = $(".second").offset();
    offset_third = $(".third").offset();
    offset_fourth = $(".fourth").offset();
    offset_fifth = $(".fifth").offset();
    animation();
    $(window).scroll(function () {
        animation();
    });
});


function animation() {
    var content_offset_first = offset_first.top - $(window).scrollTop();
    var content_offset_second = offset_second.top - $(window).scrollTop();
    var content_offset_third = offset_third.top - $(window).scrollTop();
    var content_offset_fourth = offset_fourth.top - $(window).scrollTop();
    var content_offset_fifth = offset_fifth.top - $(window).scrollTop();

    if (content_offset_first <= $(window).height() - 200) {

        //$(".first").animate({
        //    "opacity": 1
        //}, 2000);
        $(".first").addClass("fadeInUp").addClass("animated");

    }
    //else{
    //    $(".first").removeClass("fadeInUp").removeClass("animated");
    //}
    if (content_offset_second <= $(window).height() - 200) {
        //alert("second");
        $(".second").animate({
            "opacity": 1
        }, 2000);
        $(".second .one-three").addClass("fadeInUp").addClass("animated");

        setTimeout(function () {
            $(".second .one-three .overlay-text p").animate({
                "opacity": 1
            }, 4000);
            $(".second .one-three .overlay-text p").addClass("fadeInUpLittle").addClass("animated");

        }, 300)

    }
    //else{
    //    $(".second").css("opacity",0);
    //    $(".second .one-three").removeClass("fadeInUp").removeClass("animated");
    //    $(".second .one-three .overlay-text p").removeClass("fadeInUpLittle").removeClass("animated");
    //}
    if (content_offset_third <= $(window).height() - 200) {
        //alert("third");
        $(".third").animate({
            "opacity": 1
        }, 2000);

        $(".third .one-three").addClass("fadeInUp").addClass("animated");
        $(".third .two-three").addClass("fadeInUp").addClass("animated");
        setTimeout(function () {
            $(".third .one-three .overlay-text p").animate({
                "opacity": 1
            }, 8000);
            $(".third .one-three .overlay-text p").addClass("fadeInUpLittle").addClass("animated");
            $(".third .two-three .overlay-text p").addClass("fadeInUp").addClass("animated");
        }, 600)
    }
    //else{
    //    $(".third").animate("opacity",0);
    //    $(".third .one-three").removeClass("fadeInUp").removeClass("animated");
    //    $(".third .two-three").removeClass("fadeInUp").removeClass("animated");
    //    $(".fourth .one-three .overlay-text p").removeClass("fadeInUpLittle").removeClass("animated");
    //    $(".fourth .two-three .overlay-text p").removeClass("fadeInUpLittle").removeClass("animated");
    //}

    if (content_offset_fourth <= ($(window).height() - 200)) {

        $(".fourth").animate({
            "opacity": 1
        }, 2000);
        $(".fourth .one-three").addClass("fadeInUp").addClass("animated");
        setTimeout(function () {
            $(".fourth .one-three .overlay-text p").animate({
                "opacity": 1
            }, 4000);
            $(".fourth .one-three .overlay-text p").addClass("fadeInUp").addClass("animated");

        }, 300)
    }
    //else{
    //
    //        $(".fourth").css("opacity", 0);
    //        bottomLessThan200 = true;
    //        //alert()
    //        $(".fourth .one-three").removeClass("fadeInUp").removeClass("animated");
    //        $(".fourth .one-three .overlay-text p").removeClass("fadeInUp").removeClass("animated");
    //
    //}

    if (content_offset_fifth <= ($(window).height() - 200)) {

        $(".fifth").animate({
            "opacity": 1
        }, 2000);
        $(".fifth .one-three").addClass("fadeInUp").addClass("animated");
        setTimeout(function () {
            $(".fifth .one-three .overlay-text .fts-jal-fb-message").animate({
                "opacity": 1
            }, 4000);
            $(".fifth .one-three .overlay-text .fts-jal-fb-message").addClass("fadeInUpLittle").addClass("animated");
            $(".fifth .one-three .right").animate({
                "opacity": 1
            }, 4000);
            $(".fifth .one-three .right").addClass("fadeInUpLittle").addClass("animated");

        }, 300)
    }
    //else{
    //
    //    $(".fourth").css("opacity", 0);
    //    bottomLessThan200 = true;
    //    //alert()
    //    $(".fifth .one-three").removeClass("fadeInUp").removeClass("animated");
    //    $(".fifth .one-three .overlay-text .fts-jal-fb-message").removeClass("fadeInUpLittle").removeClass("animated");
    //    $(".fifth .one-three .right").removeClass("fadeInUpLittle").removeClass("animated");
    //
    //}
}


$(window).load(function () {
    animate_tiles();
});
function animate_tiles() {
    alert();
    var offset_section0 = $(document).find(".section0").offset().top;
    var content_offset_section0 = offset_section0 - $(window).scrollTop();
    if (content_offset_section0 <= $(window).height() - 200) {
        $(document).find(".section0").css({"opacity": 1});
        $(document).find(".section0").addClass("fadeInUp").addClass("animated");
    }
    var offset_section3 = $(document).find(".section3").offset().top;
    var content_offset_section3 = offset_section3 - $(window).scrollTop();
    if (content_offset_section3 <= $(window).height() - 200) {
        $(document).find(".section3").css({"opacity": 1});
        $(document).find(".section3").addClass("fadeInUp").addClass("animated");
    }
    var offset_section6 = $(document).find(".section6").offset().top;
    var content_offset_section6 = offset_section6 - $(window).scrollTop();
    if (content_offset_section6 <= $(window).height() - 200) {
        $(document).find(".section6").css({"opacity": 1});
        $(document).find(".section6").addClass("fadeInUp").addClass("animated");
    }
    var offset_section9 = $(document).find(".section9").offset().top;
    var content_offset_section9 = offset_section9 - $(window).scrollTop();
    if (content_offset_section9 <= $(window).height() - 200) {
        $(document).find(".section9").css({"opacity": 1});
        $(document).find(".section9").addClass("fadeInUp").addClass("animated");
    }
    var offset_section12 = $(document).find(".section12").offset().top;
    var content_offset_section12 = offset_section12 - $(window).scrollTop();
    if (content_offset_section12 <= $(window).height() - 200) {
        $(document).find(".section12").css({"opacity": 1});
        $(document).find(".section12").addClass("fadeInUp").addClass("animated");
    }
    $(window).scroll(function () {
        var content_offset_section0 = offset_section0 - $(window).scrollTop();
        if (content_offset_section0 <= $(window).height() - 200) {
            $(document).find(".section0").css({"opacity": 1});
            $(document).find(".section0").addClass("fadeInUp").addClass("animated");
        }
    });
    $(window).scroll(function () {
        var content_offset_section3 = offset_section3 - $(window).scrollTop();
        if (content_offset_section3 <= $(window).height() - 200) {
            $(document).find(".section3").css({"opacity": 1});
            $(document).find(".section3").addClass("fadeInUp").addClass("animated");
        }
    });
    $(window).scroll(function () {
        var content_offset_section6 = offset_section6 - $(window).scrollTop();
        if (content_offset_section6 <= $(window).height() - 200) {
            $(document).find(".section6").css({"opacity": 1});
            $(document).find(".section6").addClass("fadeInUp").addClass("animated");
        }
    });
    $(window).scroll(function () {
        var content_offset_section9 = offset_section9 - $(window).scrollTop();
        if (content_offset_section9 <= $(window).height() - 200) {
            $(document).find(".section9").css({"opacity": 1});
            $(document).find(".section9").addClass("fadeInUp").addClass("animated");
        }
    });
    $(window).scroll(function () {
        var content_offset_section12 = offset_section12 - $(window).scrollTop();
        if (content_offset_section12 <= $(window).height() - 200) {
            $(document).find(".section12").css({"opacity": 1});
            $(document).find(".section12").addClass("fadeInUp").addClass("animated");
        }
    });
}