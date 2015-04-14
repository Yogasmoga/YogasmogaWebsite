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
        $(".first").addClass("fadeInUp").addClass("animated");
    }
    else{
        $(".first").removeClass("fadeInUp").removeClass("animated");

    }
    if (content_offset_second <= $(window).height() - 200) {
        $(".second").animate({
            "opacity": 1
        }, 2000);
        $(".second .one-three").addClass("fadeInUp").addClass("animated");
        $(".second .invite_signup").addClass("fadeInUp").addClass("animated");
        setTimeout(function () {
            $(".second .one-three .overlay-text p").animate({
                "opacity": 1
            }, 4000);
            $(".second .one-three .overlay-text p").addClass("fadeInUpLittle").addClass("animated");

        }, 300);

    }
    if (content_offset_third <= $(window).height() - 200) {
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

