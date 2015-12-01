(function ($) {
    $(document).ready(function () {
        $(".thumbnail,.pageThumbnail").height($(".page").width() * 3 / 4);
        $(".gift-set .details .flexslider").flexslider({
            after: function (slider) {
                var slideNo = slider.currentSlide + 1;
                var relatedContentClass = slider.find("li:nth-child(" + slideNo + ")").attr("rel");
                slider.closest(".details").find(".related_blocks>div").hide();
                $("." + relatedContentClass).fadeIn();
            },

            start: function (slider) {
                console.debug(slider.closest(".details").find("choose_next").length);
                slider.closest(".details").find("choose_next").click(function () {
                    alert("clicked");
                    slider.find('.flex-next').trigger('click');
                });
            }

        });

        $(".gift-set .thumbnail").click(function () {
            $(".close_icon").show();
            $(".gift-set .thumbnail > p").show();
            $(this).find("p").hide();
            $(".gift-set .details").hide();
            var offsetTop = $(window).scrollTop();
            $(this).next().show();
            setTimeout(function () {
                $("body,html").animate({
                    'scrollTop': offsetTop
                }, 0);
            }, 400);
        });

        $(".close_icon").click(function () {
            $(".gift-set .details").hide();
            $(".gift-set .thumbnail > p").show();
            $(this).hide();
        });

        $(".dropdown_links.gift_sets_filter>ul li a").click(function (e) {
            e.preventDefault();
            if ($(this).text() == "WOMEN") {
                $(".gift-set[data-filter='men']").hide();
            } else {
                $(".gift-set[data-filter='women']").hide();
            }
            $(".sign-in-box .toggle_dropdown").click();
        });
    });

    $(window).resize(function () {
        $(".thumbnail,.pageThumbnail").height($(".page").width() * 3 / 4);
    });
}(jQuery));