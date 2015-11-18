$(document).ready(function () {
    var wh = $(window).height();
    $('#fullpage').fullpage({

        afterLoad: function (anchorLink, index) {

            if (index == 2) {
                $(".map_data_section_fixed").fadeIn();
            }
            //currentCityIndex = jm(".combos.active").index();
            //showTemperature();
        },
        onLeave: function (anchorLink, index) {

            if (index == 1) {
                $(".map_data_section_fixed").hide();
            }
            $(".product_set>div.side1").removeClass("flipped");
            $(".product_set>div.side2").addClass("flipped");

        },
        afterResize: function () {
            wh = $(window).height();
            $("#fullpage .section,.fp-tableCell").height(wh - 89);
        }
    });

    $("#fullpage .section,.fp-tableCell").height(wh - 89);


    init();

});


function init() {
    $(".contain_product .side1 .buy_product, .product_set .side2 .product_container .product_filters span.reverse_flip").click(function () {
        $(this).closest(".product_set").find(".side1").toggleClass("flipped");
        $(this).closest(".product_set").find(".side2").toggleClass("flipped");
    });
}