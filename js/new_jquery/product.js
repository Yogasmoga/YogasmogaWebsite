jQuery(document).ready(function($){
    scrollingLink();
    openShoppingCart();

    // Category links fixed on scroll function
    function scrollingLink(){
        var wdth = $(".cntn-scroll").width();
        var nav = $('.scroller_anchor');

        if (nav.length) {
            var contentNav = nav.offset().top;
            $(window).scroll(function(){
                if($(window).scrollTop() >= contentNav && $('.cntn-scroll').css('position') != 'fixed') {
                    // Change the CSS of the scroller to hilight it and fix it at the top of the screen.
                    $('.cntn-scroll').css({
                        'position': 'fixed',
                        'top': '3px'
                    });
                    
                    // this is container div class
                    $(".cntn-scrol-not").css({
                        marginLeft: wdth
                    });
                }
                else if($(window).scrollTop() < contentNav && $('.cntn-scroll').css('position') != 'relative') {         
                    // Change the CSS and put it back to its original position.
                    $('.cntn-scroll').css({
                        'position': '',
                        'top': ''
                    });

                    // this is container div class
                    $(".cntn-scrol-not").css({
                        marginLeft: ''
                    });
                }
            });
        };        
    };

    // Show/Hide Shopping Cart Container
    function openShoppingCart(){
        var shoppingWdth = $(".shopping-cart").width();
        var bodyHght = $(window).height();

        $(".open-cart").on("click", function(){

            $(".shopping-cart").animate({
                height: bodyHght
            }).show("fast");

            $(".page").css("position", "relative").animate({
                left: -shoppingWdth
            });

            $(".header-container").animate({
                left: -shoppingWdth
            });

            return false;
        });

        $(".continuelink").on("click", function(){
            $(".shopping-cart").hide( "slide", {direction: "right"}, "fast" ).animate({
                height: bodyHght
            });

            $(".page").css("position", "relative").animate({
                left: '0'
            });

            $(".header-container").animate({
                left: "0"
            });

            return false;
        });

        $(".addedItem li").find(".close").on("click", function(){
            $(this).parent("li").remove();
        });

    };

});