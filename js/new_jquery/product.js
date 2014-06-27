jQuery(document).ready(function($) {
    scrollingLink();
    wishList();
    readmore();

//    $("#orderitem, #preorderitem").live("click", function(){
    $("#orderitem, #preorderitem").live("click", function() {
        if(_addingtocart) return;
        $("div.producterrorcontainer div.errormsg").empty();
        var errormsg = '';
        if ($("div#sizecontainer div.dvselectedsize").length == 0 && _productorderqty == 0)
            errormsg = "Please select quantity and size to continue.";
        else
        {
            if (_productorderqty == 0)
                errormsg = "Please select quantity to continue.";
            if ($("div#sizecontainer div.dvselectedsize").length == 0)
                errormsg = "Please select size to continue.";
        }
        if (errormsg != '')
        {
            $("div.producterrorcontainer div.errormsg").hide();
            $("div.producterrorcontainer div.errormsg").html(errormsg);
            $("div.producterrorcontainer div.errormsg").fadeIn('fast');
            $("#orderitem").addClass('bagdisabled');
            $("#orderitem").removeClass('spbutton');
            return;
        }
        // var errormsg = '';
        $("#addtobagloader").remove();            
        $( "<div id='addtobagloader'><img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' /></div>" ).insertAfter( jQuery(this) );
        setTimeout(function() {
//            if(jQuery("div#sizecontainer div.dvselectedsize").length == 0 && _productorderqty == 0)
//                {errormsg = "Please select quantity and size to continue.";alert('if');}
//            else
//            {
//                if(_productorderqty == 0)
//                    errormsg = "Please select quantity to continue.";
//                if(jQuery("div#sizecontainer div.dvselectedsize").length == 0)
//                    errormsg = "Please select size to continue.";
//                //alert('else');
//                return;
//            }
       // var errormsg = '';

            if(jQuery("div#sizecontainer div.dvselectedsize").length == 0 && _productorderqty == 0)
                {errormsg = "Please select quantity and size to continue.";}
            else
            {
                if(_productorderqty == 0)
                    errormsg = "Please select quantity to continue.";
                if(jQuery("div#sizecontainer div.dvselectedsize").length == 0)
                    errormsg = "Please select size to continue.";

                return;
            }

            _isClickSigninMenu = true;
            if (!_islogedinuser)
                showShoppingBagHtml();
            else {
                automaticapplysmogibucks();
            }
            

        }, 20);
        setTimeout(function() {
            $(".open-cart").trigger("click");
            $("#addtobagloader").hide();            
        }, 10000);
    });


    // image lazy loading
    // $(function() {
    $("img.lazy").lazyload({
        skip_invisible: false,
        failure_limit: 1,
        threshold: 500
    });
    // }); 




    // image rotate
    //$(".prod-img").find("img:eq(0)").show();

    xyzinterval = null;
    $('.prod-img').hover(function() {
        $(this).css("background", "none");
        var $imgs = $(this).find("img"), current = 0;

        var xyzinterval = function() {
            if (current >= $imgs.length)
                current = 0;
            $imgs.eq(current++).fadeIn(function() {
                $(this).delay(500).fadeOut(xyzinterval);
            });
        };
        xyzinterval();
    }, function() {
        $(this).css("");
        $(this).find("img").clearQueue().stop();
        $(this).find("img").hide();
        $(this).find("img:eq(0)").fadeIn();
    });

    // Category links fixed on scroll function
    var scrollBottom = $("#sitemap").height();

//    $(window).scroll(function(){
//        // var bnnr = $(".bannerFluid").height();
//        // $('.cntn-scroll').css("top", bnnr);
//        // $('.cntn-scroll').stop();
//        // $('.cntn-scroll').animate({top:$(window).scrollTop()},400)
//    });

});
function scrollingLink() {
    var wdth = jQuery(".cntn-scroll").width();
    var nav = jQuery('.scroller_anchor');
    var ftr = jQuery('#sitemap').height();
    var hdr = jQuery('.header-container').height();

    if (nav.length) {
        var contentNav = nav.offset().top;
        jQuery(window).scroll(function() {
            if (jQuery(window).scrollTop() >= contentNav && jQuery('.cntn-scroll').css('position') != 'fixed') {
                // Change the CSS of the scroller to hilight it and fix it at the top of the screen.
                jQuery('.cntn-scroll').css({
                    'position': 'fixed',
                    'top': '0'
                });

                // this is container div class
                jQuery(".cntn-scrol-not").css({
                    marginLeft: wdth
                });
            }
            else if (jQuery(window).scrollTop() < contentNav && jQuery('.cntn-scroll').css('position') != 'relative') {
                // Change the CSS and put it back to its original position.
                jQuery('.cntn-scroll').css({
                    'position': '',
                    'top': '',
                    'bottom': ''
                });

                // this is container div class
                jQuery(".cntn-scrol-not").css({
                    marginLeft: ''
                });
            }
            else if (jQuery(window).scrollTop() < contentNav && jQuery('.cntn-scroll').css('position') != 'relative') {
                //alert(scrollBottom);
            }
        });
    }

}
;

function readmore() {
    jQuery(".readmore").live("click", function() {
        jQuery(".dot").toggleClass("dnone");
        jQuery(".sec-desc").toggleClass("dblock");
        jQuery("#less").toggleClass("dblock");
        jQuery("#more").toggleClass("dnone");
    });
}

function wishList() {
    var wishlist = jQuery(".wishlist-link");
    //$(wishlist).find("a").removeAttr("href").css("cursor", "pointer");

    jQuery(wishlist).live("click", "a", function(event) {
        event.preventDefault();
        if (!_islogedinuser)
        {
            _isClickAddtowishlist = true;
            jQuery("#signing_popup").dialog("open");

        }

        if (_islogedinuser)
        {

            var productid = jQuery(wishlist).find("a").attr('id');
            if (window.location.href.indexOf('https://') >= 0)
                _usesecureurl = true;
            else
                _usesecureurl = false;
            var url = homeUrl + 'mynewtheme/addtowishlist/applyAddToWishlist';
            if (_usesecureurl)
                url = securehomeUrl + 'mynewtheme/addtowishlist/applyAddToWishlist';
            jQuery.ajax({
                type: 'POST',
                url: url,
                data: {'productid': productid},
                success: function(data) {

                    data = eval('(' + data + ')');
                    var status = data.status;
                    if (status == "success")
                    {
                        jQuery(wishlist).text("ADDED TO WISH LIST").css("color", "#D90D3D");
                    }
                    else {
                        jQuery(this).text(data.errors).css("color", "#D90D3D");
                    }

                }

            });

        }




    });
}
