jQuery(document).ready(function($){
    $(window).load(function(){
        $('.flexslider').flexslider({
            controlNav: false,
            slideshowSpeed: 9000,
			animationSpeed:1250,
			easing:"linear",
            directionNav: false,
            start: function(slider) {
                //fixFlexisliderImage();
              },
            before: function(slider) {
            //$('.current-slide').text(slider.currentSlide);
            //fixFlexisliderImage();
             setTimeout(function(){ positionfloatingimages();;}, 50);
            }
        });
		$('#playBtn').fadeIn(500, function(){$('.flexslider').css('background','#fff')});
		$('.page-overlay').fadeOut(500, function(){$('.page-overlay').remove();});
		$('body').css({overflow:'auto', marginRight:0});
        positionfloatingimages();
    });
	//fixmainimage();
    
    $(window).resize(function($) {
        //alert("resized");
        positionfloatingimages();
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

///this was added for gilt promotion
function positionfloatingimages()
{
    jQuery("div#Welcome ul.slides>li").each(function(){
        if(jQuery(this).find("img.barimg").length == 0)
            return;
        //console.log(jQuery(this).find("img.barimg").length);
        var leftspace = ((jQuery(this).find("img.barimg").position()).left) + jQuery(this).find("img.barimg").width();
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