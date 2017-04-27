jQuery(document).ready(function($){
//    var sliderHeight = $(window).width() * 0.523;
    //var ww = $(window).width();
    var ww = $('.wrapper').width();
    if(ww < 1007){
        ww = 1007;
    }
    var sliderHeight = ww * 0.523;
//    var bannerFliudHeight = ww * 0.3125;
    $(".gridfull").css('min-height',ww*0.48);
    $("#bucket1_slider.flexslider .slides li").css({"height": sliderHeight});
	jQuery(".slider-block .slides .slider_li").height(510);

    //$(flexslider)
    $('.flexslider').flexslider({
        controlNav: true,
        slideshowSpeed: 5000,
        animationSpeed:1250,
        easing:"linear",
        directionNav: true,
        startAt: 0,
        start: function(slider) {
            //fixFlexisliderImage();
        },
        before: function(slider) {
            //$('.current-slide').text(slider.currentSlide);
            //fixFlexisliderImage();
            setTimeout(function(){ positionfloatingimages();;}, 50);
        }
    });
    if($("#bucket1_slider").length!=0){
        $("#bucket1_slider").flexslider('pause');
        $("#bucket1_slider .flex-direction-nav").hide();
        $("#bucket1_slider .flex-control-nav").hide();

        $(window).load(function(){

            $("#bucket1_slider").flexslider('play');

            if($("#bucket1_slider .slides li").length>1) {
                $("#bucket1_slider .flex-direction-nav").show();
                $("#bucket1_slider .flex-control-nav").show();
            }

        });
    }

    //$(".gridfull .sliderImg img").load(function(){
    //    $(this).closest(".gridfull").css("opacity",1);
    //});

//    $(".gridfull .sliderImg img").closest(".gridfull").css("opacity",1);

    $('#playBtn').fadeIn(500, function(){$('.flexslider').css('background','#fff')});
    //$('.page-overlay').fadeOut(500, function(){$('.page-overlay').remove();});
    $('body').css({overflow:'auto', marginRight:0});
    //positionfloatingimages();
    fixmainimage();
    
    $(window).resize(function($) {
        var ww = jQuery('.wrapper').width();// new design var
        jQuery(".gridfull").css('min-height',ww*0.48);
        fixmainimage();

        //var ww = jQuery(window).width();

        if(ww < 1007){
            ww = 1007;
        }
        var sliderHeight = ww * 0.523;
        var bannerFliudHeight = ww * 0.3125;
        jQuery(".gridfull").css('min-height',ww*0.48);
        //jQuery(".gridfull").css('min-height',jQuery(window).width()*0.48);
        //jQuery("#bucket1_slider.flexslider .slides li").css({"height": sliderHeight});
        jQuery(".gridfull.nophotoshop .slider_li").css('min-height',ww*0.48);
		jQuery(".slider-block .slides .slider_li").height(500);
        //alert("resized");
        // positionfloatingimages();
        
        //positionDiscoverSection();
        // sliderHeight();
    });
    
    setTimeout(function(){ fixmainimage();}, 100);
    
    $("div.nosheerinfo table.sharenosheer div").click(function(){
        if($(this).hasClass("twshare"))
            $("div#pageScrollerNav div#shareicons div#twitter").trigger('click');
        if($(this).hasClass("fbshare"))
            $("div#pageScrollerNav div#shareicons div#facebook").trigger('click');
        if($(this).hasClass("pinshare"))
            $("div#pageScrollerNav div#shareicons div#pinterest").trigger('click');
        if($(this).hasClass("mlshare"))
            $("div#pageScrollerNav div#shareicons div#mail").trigger('click');
    });
    
});

function showGridContainer(obj){
    console.log(jQuery(obj).attr('class'));
    jQuery(obj).closest(".gridfull").css("opacity",1);
}

 // function sliderHeight()
 //    {
 //        //Height of th header bar and the share strip
 //        var nwinHeight = jQuery(".share-strip").height() + 91 + 50;
 //        //Height of window
 //        var winHeight = jQuery(window).height();
 //        //calculation for the height of the slider
 //        var sHeight = winHeight - nwinHeight;            
 //        //Calculated height applied to the slider
 //        jQuery("div#Welcome").css("height",sHeight);
 //    }


function positionDiscoverSection()
{
    var ht = jQuery("td#discover_fabrics div.fab_text").height();
    //console.log(ht);
    var tdht = jQuery("td#discover_fabrics").height();
    var top = (tdht - ht) / 2;
    jQuery("td#discover_fabrics div.fab_text").css('top', top + 'px');
}

///this was added for gilt promotion
function positionfloatingimages()
{
    jQuery("div#Welcome ul.slides>li").each(function(){
        
        if(jQuery(this).hasClass("slide21127"))
        {
            if(_winW <= 1400)
            {
                jQuery("div#Welcome ul.slides>li.slide21127 img.girl1").hide().removeClass("fltimage");
                jQuery("div#Welcome ul.slides>li.slide21127 img.girl2").show().addClass("fltimage");
                jQuery("div#Welcome ul.slides>li.slide21127 img.giftysimg").removeClass("barimg");
                jQuery("div#Welcome ul.slides>li.slide21127 div.startingnov13.blackfriday").addClass("barimg");
            }
            else
            {
                jQuery("div#Welcome ul.slides>li.slide21127 img.girl1").show().addClass("fltimage");
                jQuery("div#Welcome ul.slides>li.slide21127 img.girl2").hide().removeClass("fltimage");
                jQuery("div#Welcome ul.slides>li.slide21127 img.giftysimg").addClass("barimg");
                jQuery("div#Welcome ul.slides>li.slide21127 div.startingnov13.blackfriday").removeClass("barimg");
            }
        }
        
        if(jQuery(this).find(".barimg").length == 0)
            return;
        //console.log(jQuery(this).find("img.barimg").length);
        var leftspace = ((jQuery(this).find(".barimg").position()).left) + jQuery(this).find(".barimg").width();
        var space = ((_winW - leftspace - jQuery(this).find("img.fltimage").width()) / 2) + leftspace;
        var mmargin = jQuery(this).find("img.fltimage").attr("mymargin") * 1;
        if(space < (leftspace + mmargin))
            space = leftspace + mmargin;
        jQuery(this).find("img.fltimage").css("left", space + "px");    
        
    });
    
    /*
    console.log(_winW);
    console.log((jQuery("img.barimg").position()).left + jQuery("img.barimg").width());
    var _space = ((_winW - ((jQuery("img.barimg").position()).left + jQuery("img.barimg").width()) - jQuery("img.fltimage").width()) / 2) + (jQuery("img.barimg").position()).left + jQuery("img.barimg").width();
     console.log("left = " + _space);
     if(_space < ((jQuery("img.barimg").position()).left + jQuery("img.barimg").width() + 25))
        _space = (jQuery("img.barimg").position()).left + jQuery("img.barimg").width() + 25;
    console.log((jQuery("img.fltimage").position()).left);
    jQuery("img.fltimage").css("left", _space + "px");
    */
    
}

function fixmainimage()
{
    jQuery("div#mainimage img.fullscreen").each(function(){
        if(jQuery("div#globalheader").hasClass('top0'))
            jQuery(this).css('top',((_winH - getScaledheight(jQuery(this).attr("iheight"), jQuery(this).attr("iwidth"))) / 2) + 'px');
        else
            jQuery(this).css('top',((_winH + _headerHeight - getScaledheight(jQuery(this).attr("iheight"), jQuery(this).attr("iwidth"))) / 2) + 'px');
    });
    
    jQuery(".fullscreenovfhidden img.fullscreen").each(function(){
        var height = jQuery(this).height();        
        height = getScaledheight(jQuery(this).attr("iheight"), jQuery(this).attr("iwidth")) * 1;             
        if(height > _winH)
        {
            jQuery(this).css('top',((_winH - height) / 2) + 'px');
            jQuery(this).css('left', 0);
            jQuery(this).css('width', '100%');
            jQuery(this).css('height', 'auto');
        }
        else
        {            
            height = getScaledwidth(jQuery(this).attr("iheight"), jQuery(this).attr("iwidth")) * 1;
            //jQuery(this).css('left',((_winW - height) / 2) + 'px');
            jQuery(this).css('top', 0);
            jQuery(this).css('left',((_winW - height) / 2) + 'px');
            jQuery(this).css('width', 'auto');
            jQuery(this).css('height', '100%');
        }
    });
}

function getScaledheight(originalheight, originalwidth)
{
    //console.log('calculating');
    originalheight = originalheight * 1;
    originalwidth = originalwidth * 1;
    return ((originalheight / originalwidth) * (jQuery("div#pagecontainer").width() * 1));
}

function getScaledwidth(originalheight, originalwidth)
{
    //console.log('calculating');
    originalheight = originalheight * 1;
    originalwidth = originalwidth * 1;
    w = ((originalwidth / originalheight) * _winH);
    return w;
}

function fixFlexisliderImage()
{
    //console.log(_headerHeight);
//    jQuery(".flexslider img.fullscreen").each(function(){
//        var height = jQuery(this).height();
//        console.log(height);
//        if(height > _winH)
//        {
//            jQuery(this).css('top',(((_winH - height) / 2)) + 'px');
//        }
//    });
    jQuery(".fullscreenovfhidden img.fullscreen").each(function(){
        var height = jQuery(this).height();
        if(height > _winH)
        {
            //jQuery(this).animate({
//                top : (_winH - height) / 2
//            }, 500);
            //jQuery(this).fadeOut(500, function(){
//                jQuery(this).css('top',((_winH - height) / 2) + 'px');
//                jQuery(this).fadeIn(500);
//            });
            jQuery(this).css('top',((_winH - height) / 2) + 'px');        
        }
    });
}