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
            after: function(slider) {
            //$('.current-slide').text(slider.currentSlide);
            //fixFlexisliderImage();
            }
        });
		$('#playBtn').fadeIn(500, function(){$('.flexslider').css('background','#fff')});
		$('.page-overlay').fadeOut(500, function(){$('.page-overlay').remove();});
		$('body').css({overflow:'auto', marginRight:0});
    });
	//fixmainimage();
    
    
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