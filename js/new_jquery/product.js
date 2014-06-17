jQuery(document).ready(function($){
    scrollingLink();
    wishList();
    openShoppingCart();

    // image lazy loading
    $(function() {
        $("img.lazy").lazyload({
            skip_invisible  : false,
            failure_limit : 1,
            threshold : 500
        });
    }); 
    //click on readmore on product detail page for description

//    $(".readmore").on("click", function(){
//        $(".dot").css("display","none");
//        $(".sec-desc").slideDown('slow');
////alert('tets');
//    },function(){
//        $(".sec-desc").slideUp('slow');
//
//    });
    $(function(){
        if($(".readmore").click()){
            alert('stes');
        }
    })


    function wishList(){
        var wishlist = $(".wishlist-link");
        //$(wishlist).find("a").removeAttr("href").css("cursor", "pointer");

        $(wishlist).on("click", "a", function(event){
            event.preventDefault();
            if(!_islogedinuser)
            {
                _isClickAddtowishlist = true;
                $("#signing_popup").dialog( "open" );

            }

            if(_islogedinuser)
            {

                var productid = $(wishlist).find("a").attr('id');
                if(window.location.href.indexOf('https://') >= 0)
                    _usesecureurl = true;
                else
                    _usesecureurl = false;
                var url = homeUrl + 'mynewtheme/addtowishlist/applyAddToWishlist';
                if(_usesecureurl)
                    url = securehomeUrl + 'mynewtheme/addtowishlist/applyAddToWishlist';
                $.ajax({

                    type : 'POST',
                    url : url,
                    data : {'productid': productid},
                    success : function(data){

                        data = eval('('+data +')');
                        var status = data.status;
                        if(status == "success")
                        {
                            $(wishlist).text("ADDED TO WISH LIST").css("color", "#D90D3D");
                        }
                        else{
                            $(this).text(data.errors).css("color", "#D90D3D");
                        }

                    }

                });

            }




        });
    }


    // image rotate
    //$(".prod-img").find("img:eq(0)").show();

    xyzinterval = null;
    $('.prod-img').hover(function(){
        $(this).css("background", "none");
        var $imgs = $(this).find("img"), current = 0;
        
        var xyzinterval = function() {
            if (current >= $imgs.length) current = 0;
            $imgs.eq(current++).fadeIn(function() {
                $(this).delay(500).fadeOut(xyzinterval);
            });
        };
        xyzinterval();
    }, function(){
        $(this).css("");
        $(this).find("img").clearQueue().stop();
        $(this).find("img").hide();
        $(this).find("img:eq(0)").fadeIn();
    });

    // Category links fixed on scroll function
    var scrollBottom = $("#sitemap").height();
    function scrollingLink(){
        var wdth = $(".cntn-scroll").width();
        var nav = $('.scroller_anchor');
        var ftr = $('#sitemap').height();

        if (nav.length) {
            var contentNav = nav.offset().top;
            $(window).scroll(function(){
                if($(window).scrollTop() >= contentNav && $('.cntn-scroll').css('position') != 'fixed') {
                    // Change the CSS of the scroller to hilight it and fix it at the top of the screen.
                    $('.cntn-scroll').css({
                        'position': 'fixed',
                        'bottom': ftr
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
                        'top': '',
                        'bottom': ''
                    });

                    // this is container div class
                    $(".cntn-scrol-not").css({
                        marginLeft: ''
                    });
                }
                else if($(window).scrollTop() < contentNav && $('.cntn-scroll').css('position') != 'relative') {
                    //alert(scrollBottom);
                }
            });
        }

    };

    $(window).scroll(function(){
        // var bnnr = $(".bannerFluid").height();
        // $('.cntn-scroll').css("top", bnnr);
        // $('.cntn-scroll').stop();
        // $('.cntn-scroll').animate({top:$(window).scrollTop()},400)
    });

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