(function ($) {
    $(document).ready(function () {
        $(".thumbnail,.pageThumbnail").height($(this).width() * 3 / 4);
        $(".gift-set .details .flexslider").flexslider();
    });
}(jQuery));