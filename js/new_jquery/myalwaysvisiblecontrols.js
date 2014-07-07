jQuery(document).ready(function($){
    setTimeout(function(){ handlealwaysvisiblecontrols();}, 100); 
    $(window).scroll(function(){
        handlealwaysvisiblecontrols();
    });
});

function handlealwaysvisiblecontrols()
{
    jQuery.each(jQuery(".topvisible"), function(){
            h = jQuery(this).parent().height();
            t = jQuery(this).parent().offset().top;
            s = jQuery(window).scrollTop() + _headerHeight;
            if(s > t)
            {
                if(h - (s - t) < _winH)
                {
                    //console.log('removed');
                    jQuery(this).removeClass('fixedposition');
                    //if(jQuery(this).height() > (_winH - (h - (s - t))))
//                        {
//                            console.log(jQuery(this).css('top').substr(0, jQuery(this).css('top').length - 2) * 1);
//                            //console.log(((jQuery(this).css('top') * 1) - (_winH - (h - (s - t)))));
//                            jQuery(this).css('top', ((jQuery(this).css('top').substr(0, jQuery(this).css('top').length - 2) * 1) - (_winH - (h - (s - t)))) + 'px');
//                        }
//                    else
//                        {
//                            jQuery(this).removeClass('fixedposition');
//                            jQuery(this).css('top', 'auto');
//                        }        
                }
                else
                {
                    //console.log('applied');
                    jQuery(this).addClass('fixedposition');
                }        
            }
            else
                jQuery(this).removeClass('fixedposition');
    });
    
    jQuery.each(jQuery(".alwaysvisible"), function(){
        h = jQuery(this).parent().height();
            t = jQuery(this).parent().offset().top;
            s = jQuery(window).scrollTop() + _headerHeight;
            if(s > t)
            {
                if(h - (s - t) < jQuery(this).height())
                //if(h - (s - t) < _winH)
                {
                    //jQuery(this).css('top', 80 + jQuery(this).height() - (h - (s - t)) + 'px'); 
                    
                    jQuery(this).removeClass('fixedposition');
                    jQuery(this).addClass('bottomposition');
                    //if(jQuery(this).height() > (_winH - (h - (s - t))))
//                    {
//                        console.log(jQuery(this).css('top').substr(0, jQuery(this).css('top').length - 2) * 1);
//                        console.log(((jQuery(this).css('top') * 1) - (_winH - (h - (s - t)))));
//                        jQuery(this).css('top', ((jQuery(this).css('top').substr(0, jQuery(this).css('top').length - 2) * 1) - (_winH - (h - (s - t)))) + 'px');
//                    }
//                    else
//                    {
//                        jQuery(this).removeClass('fixedposition');
//                        jQuery(this).css('top', 'auto');
//                    }        
                }
                else
                {
                    jQuery(this).addClass('fixedposition');
                    jQuery(this).removeClass('bottomposition');    
                }        
            }
            else
                jQuery(this).removeClass('fixedposition');
    });
    //((_winW - ($(".mycategory-products div.item").width() * 4)) / 4)mycategory_products
    //console.log(jQuery(".mycategory-products div.item").width());
}