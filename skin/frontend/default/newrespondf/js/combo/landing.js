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
                var chooseNext = slider.closest(".details").find(".choose_next");
                chooseNext.click(function () {
                    var slideNo = slider.currentSlide + 1;

                    if(chooseNext.closest(".details").find(".product_"+slideNo +"_details").find(".size.active-size").length>0) {
                        slider.find('.flex-next').trigger('click');
                        chooseNext.closest(".details").find(".error-text").html("");
                    }else{
                        chooseNext.closest(".details").find(".error-text").html("Please choose a size to continue.");
                    }
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


        var personType = getParameterByName('style');
        if(personType!=undefined){

            if(personType=='men' || personType=='women') {
                filterGiftSet(personType.toUpperCase());
            }
        }

        $(".dropdown_links.gift_sets_filter>ul li a").click(function (e) {
            e.preventDefault();
            var linkText = $(this).text().toUpperCase();

            filterGiftSet(linkText);
        });

        $(".bra_cup_toggle").click(function(){
            $(this).find("span").toggleClass("selected");
        });

    });

    $(window).resize(function () {
        $(".thumbnail,.pageThumbnail").height($(".page").width() * 3 / 4);
        $(".gift-set .details .flexslider .slides li").height($(".gift-set .details").width() * 3 / 4);
    });
}(jQuery));

function filterGiftSet(linkText){
    $(".gift-set").show();
    if (linkText == "WOMEN") {
        $(".gift-set[data-filter='men']").hide();
    }
    if (linkText == "MEN") {
        $(".gift-set[data-filter='women']").hide();
    }
    $(".sign-in-box .toggle_dropdown").click();
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}