jQuery(document).ready(function($){
    scrollingLink();
    //openShoppingCart();


    function cycleImages(){
        var $active = $('.prod-img .active');
        var $next = ($active.next().length > 0) ? $active.next() : $('.prod-img img:first');
        $next.css('z-index',2);//move the next image up the pile
        $active.fadeOut(1500,function(){//fade out the top image
            $active.css('z-index',1).show().removeClass('active');//reset the z-index and unhide the image
            $next.css('z-index',3).addClass('active');//make the next image the top one
        });
    };

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
                        'top': '50px'
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
        console.log(shoppingWdth);
        console.log(bodyHght);
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