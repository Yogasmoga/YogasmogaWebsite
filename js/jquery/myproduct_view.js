jQuery(document).ready(function($){
    setTimeout(function(){ resizeDesignFeatures(); }, 100);
    setTimeout(function(){ resizeProductBigImage(); }, 100);
    $(window).resize(function(){
        setTimeout(function(){ resizeDesignFeatures(); }, 100);
        setTimeout(function(){ resizeProductBigImage(); }, 100);
    });
    
    $("table.productdesignfeatures div[size]").hover(function(){
        $(this).find("div.caption").height();
        //$(this).find("div.caption").css('margin-top', ($(this).find("div.caption").height() * -1) + 'px');
        $(this).find("div.caption").animate({
            'margin-top': ($(this).find("div.caption").height() * -1)
        }, 300);
    },
    function(){
        //$(this).find("div.caption").css('margin-top', '0px');
        $(this).find("div.caption").animate({
            'margin-top': 0
        }, 300);
    });
    clearEmptycaptions();
});

function resizeDesignFeatures()
{
    var globalcorrection = 170;
    var halfcorrection = 10;
    jQuery("table.productdesignfeatures div[size]").each(function(){
         if(jQuery(this).attr("size") == "full")
         {
            jQuery(this).css('height', (_winH - globalcorrection) + 'px');
         }
         else
         {
            jQuery(this).css('height', (((_winH - globalcorrection) / 2) - halfcorrection) + 'px');
         }
    });
    jQuery("table.productdesignfeatures div[size] img").each(function(){
        var height = jQuery(this).height();
        var parentheight = (jQuery(this).parent().css('height').substr(0, jQuery(this).parent().css('height').length - 2) * 1);
        if(height > parentheight)
        {
            //jQuery(this).css('margin-top',((parentheight - height) / 2) + 'px');
            //jQuery(this).parent().css('margin-top',((parentheight - height) / 2) + 'px');        
        }
        //jQuery(this).css('height',parentheight + 'px');
        //var height = jQuery(this).width();
//        var parentheight = jQuery(this).parent().width();// (jQuery(this).parent().css('height').substr(0, jQuery(this).parent().css('height').length - 2) * 1);
//        if(height > parentheight)
//        {
//            jQuery(this).css('margin-left',((parentheight - height) / 2) + 'px');        
//        }
    });
}

function resizeProductBigImage()
{
    var correction = 100;
    var maxHeight = _winH - correction;
    if(maxHeight > 600)
        jQuery("table.tdbigimagecontainer img").css('max-height', maxHeight + 'px');
    else
        jQuery("table.tdbigimagecontainer img").css('max-height', '600px');
}

function clearEmptycaptions()
{
    jQuery("table.productdesignfeatures div[size] div.caption div").each(function(){
        if(jQuery(this).html() == "")
            jQuery(this).parent().css('display', 'none'); 
    });
}