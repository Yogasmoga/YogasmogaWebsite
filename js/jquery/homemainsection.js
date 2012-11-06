jQuery(document).ready(function($){
    $('.flexslider').flexslider({
        controlNav: false,
        slideshowSpeed: 6000,
        directionNav: false,
        start: function(slider) {
            fixFlexisliderImage();
          },
        after: function(slider) {
        //$('.current-slide').text(slider.currentSlide);
        fixFlexisliderImage();
        }
    });
    
});

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
            jQuery(this).css('top',((_winH - height) / 2) + 'px');        
        }
    });
}