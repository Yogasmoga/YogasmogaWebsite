var index = 0;
var sectionNo = 0;
$(document).ready(function () {
    $(" .over-the-slide").css("opacity", 1);
    $(window).load(function () {
        $('.flexslider').flexslider({
            start: function () {
                $(".flex-active-slide .play-video").addClass("fadeInUp").addClass("animated");
            }
        });
    });
    var wH = $(window).height();
    var sectionsOffsets = [0];
    $("section.row").each(function () {
        sectionsOffsets.push($(this).offset().top);
    });
    animateSections(sectionsOffsets);
    $(window).load(function () {
        index = 0;
        $(window).scroll(function () {
            var WS = $(window).scrollTop();
            var WST = WS - 300;
            if (WST > sectionsOffsets[index]) {
                sectionNo = index + 1;
                if(!$("#fixed_container section.row:nth-child(" + sectionNo + ")").hasClass("done_animation"))
                    $("#fixed_container section.row:nth-child(" + sectionNo + ")").addClass("fadeInUp").addClass("animated");
                index++;
            }
            //console.debug(sectionNo+" "+sectionsOffsets.length);
            if(sectionNo >= sectionsOffsets.length){
                $("#fixed_container section.row").css("transition-duration","0").removeClass("fadeInUp").addClass("done_animation");
            }
        });
    });
});
function animateSections(sectionsOffsets) {
    var WS = $(window).scrollTop();
    var WST = WS - 300;
    $.each(sectionsOffsets, function () {
        if (WST > sectionsOffsets[index]) {
            sectionNo = index + 1;
            if(!$("#fixed_container section.row:nth-child(" + sectionNo + ")").hasClass("done_animation"))
                $("#fixed_container section.row:nth-child(" + sectionNo + ")").addClass("fadeInUp").addClass("animated");
            index++;
        }
        //console.debug(sectionNo+" "+sectionsOffsets.length);
        if(sectionNo >= sectionsOffsets.length){
            $("#fixed_container section.row").css("transition-duration","0").removeClass("fadeInUp").addClass("done_animation");
        }
    });
}