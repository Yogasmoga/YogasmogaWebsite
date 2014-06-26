jQuery(document).ready(function($){
    scrollingLink();
    wishList();
    readmore();

    $("#orderitem, #preorderitem").live("click", function(){
        jQuery("div.producterrorcontainer div.errormsg").empty();
        var errormsg = '';
        if(jQuery("div#sizecontainer div.dvselectedsize").length == 0 && _productorderqty == 0)
            errormsg = "Please select quantity and size to continue.";
        else
        {
            if(_productorderqty == 0)
                errormsg = "Please select quantity to continue.";
            if(jQuery("div#sizecontainer div.dvselectedsize").length == 0)
                errormsg = "Please select size to continue.";
        }
        if(errormsg != '')
        {
            jQuery("div.producterrorcontainer div.errormsg").hide();
            jQuery("div.producterrorcontainer div.errormsg").html(errormsg);
            jQuery("div.producterrorcontainer div.errormsg").fadeIn('fast');
            jQuery("#orderitem").addClass('bagdisabled');
            jQuery("#orderitem").removeClass('spbutton');
            return;
        }
        var errormsg = '';
        setTimeout(function(){
            if(jQuery("div#sizecontainer div.dvselectedsize").length == 0 && _productorderqty == 0)
                {errormsg = "Please select quantity and size to continue.";alert('if');}
            else
            {
                if(_productorderqty == 0)
                    errormsg = "Please select quantity to continue.";
                if(jQuery("div#sizecontainer div.dvselectedsize").length == 0)
                    errormsg = "Please select size to continue.";
                alert('else');
                return;
            }

            _isClickSigninMenu = true;
            if(!_islogedinuser)
                showShoppingBagHtml();
            else{
                automaticapplysmogibucks();
            }
            $(".open-cart").trigger("click");

        },20);
    });


    // image lazy loading
    $(function() {
        $("img.lazy").lazyload({
            skip_invisible  : false,
            failure_limit : 1,
            threshold : 500
        });
    }); 

   function readmore(){
       $(".readmore").on("click", function(){
           $(".dot").toggleClass("dnone");
           $(".sec-desc").toggleClass("dblock");
           $("#less").toggleClass("dblock");
           $("#more").toggleClass("dnone");
       });
   }

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
        var hdr = $('.header-container').height();

        if (nav.length) {
            var contentNav = nav.offset().top;
            $(window).scroll(function(){
                if($(window).scrollTop() >= contentNav && $('.cntn-scroll').css('position') != 'fixed') {
                    // Change the CSS of the scroller to hilight it and fix it at the top of the screen.
                    $('.cntn-scroll').css({
                        'position': 'fixed',
                        'top': '0'
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

});