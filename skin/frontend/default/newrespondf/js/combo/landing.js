(function ($) {
    $(document).ready(function () {
        $(".thumbnail,.pageThumbnail").height($(".page").width() * 3 / 4);
        $(".gift-set .details .flexslider .slides li").height($(".gift-set .details").width() * 3 / 4);
        
        $(".gift-set .details .flexslider").flexslider({
            after: function (slider) {
                var slideNo = slider.currentSlide + 1;
                var relatedContentClass = slider.find("li:nth-child(" + slideNo + ")").attr("rel");
                slider.closest(".details").find(".related_blocks>div").hide();
                $("." + relatedContentClass).fadeIn();
            },

            start: function (slider) {
                slider.closest(".details").find(".choose_next").click(function () {
                    slider.find('.flex-next').trigger('click');
                });
            }

        });

        $(".gift-set .thumbnail").click(function () {
            $(".close_icon").show();
            $(".gift-set .thumbnail > p").show();
            $(this).find("p").hide();
            $(".gift-set .details").not($(this).closest(".thumbnail").find(".details")).hide();
            $(".gift-set .details .related_blocks>div").hide();
            $(this).next().find(".related_blocks>div:first-child").show();
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
            $(".size").removeClass("active-size");
            $(".add_to_shopping_bag").removeClass("bag-active");
            $(".choose_next").show();
        });

        $(".dropdown_links.gift_sets_filter>ul li a").click(function (e) {
            e.preventDefault();
            if ($(this).text() == "WOMEN") {
                $(".gift-set[data-filter='men']").hide();
            }
            if ($(this).text() == "MEN") {
                $(".gift-set[data-filter='men']").hide();
            } else {
                $(".gift-set").show();
            }
            $(".sign-in-box .toggle_dropdown").click();
        });
    });

    $(window).resize(function () {
        $(".thumbnail,.pageThumbnail").height($(".page").width() * 3 / 4);
        $(".gift-set .details .flexslider .slides li").height($(".gift-set .details").width() * 3 / 4);
    });
}(jQuery));