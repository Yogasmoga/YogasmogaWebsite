jQuery(document).ready(function($){
    setTimeout(function(){ resizeDesignFeatures(); }, 100);
    $(window).resize(function(){
        setTimeout(function(){ resizeDesignFeatures(); }, 100);    
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
    //$("table.productdesignfeatures td div img").capty();
    //$("table.productdesignfeatures td div img").hover(function(){
//       var div = $(this).parent().find("div.caption:first");
//       console.log(($(this).css('top')));
//       if(($(this).css('top')) == 'auto')
//       {
//            
//       }
//       //($(this).css('top').substr(0, jQuery(this).parent().css('top').length - 2) * -1) + $(this).height();
//       //div.css('margin-top', );    
//    },
//    function(){
//         
//    });
});

function resizeDesignFeatures()
{
    var globalcorrection = 80;
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