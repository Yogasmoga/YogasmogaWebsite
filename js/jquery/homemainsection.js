jQuery(document).ready(function($){
    $(window).load(function(){
        $('.flexslider').flexslider({
            controlNav: false,
            slideshowSpeed: 3500,
			animationSpeed:500,
			easing:"easeInOutSine",
            directionNav: false,
            start: function(slider) {
                //fixFlexisliderImage();
              },
            after: function(slider) {
            //$('.current-slide').text(slider.currentSlide);
            //fixFlexisliderImage();
            }
        });
		$('#playBtn').fadeIn(500, function(){$('.flexslider').css('background','#000')});  
		$('.page-overlay').fadeOut(500);
		$('body').css({overflow:'auto', marginRight:0});
    });
	fixmainimage();
    
    
    //setTimeout(function(){ fixmainimage();}, 100);
});

function fixmainimage()
{
	jQuery("div#mainimage img.fullscreen").each(function(){
		if(jQuery("div#globalheader").hasClass('top0'))
			jQuery(this).css('top',((_winH - getScaledheight(jQuery(this).attr("iheight"), jQuery(this).attr("iwidth"))) / 2) + 'px');
		else
			jQuery(this).css('top',((_winH + 80 - getScaledheight(jQuery(this).attr("iheight"), jQuery(this).attr("iwidth"))) / 2) + 'px');
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