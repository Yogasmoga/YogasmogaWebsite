/***Left navigation fixation***/
jQuery(window).scroll(function() {   
    if(jQuery("body.catalog-category-view").find("div.product-grid").length){        
        var element = jQuery(".leftnav");  
        leftNav_scroll(element);
    } 
     if(jQuery("body").hasClass("cms-help")){
        var element = jQuery(".side-menu-bar");   
        leftNav_scroll(element);
    } 
     if(jQuery("body").hasClass("accountbg") || jQuery("body").hasClass("rewardpoints-index-referral") || jQuery("body").hasClass("cms-payment-methods")){
        var element = jQuery(".account-nav");  
        leftNav_scroll(element);
    } 
    if(jQuery("body").hasClass("cms-smogi-bucks")){
        var element = jQuery(".cms-side-nav");  
        leftNav_scroll(element);
    }
})
function leftNav_scroll(element){
    // console.log("test");      
    var offset = element.parent().offset();
    var scroll_top = jQuery(window).scrollTop();
    var origAttr = "";
            if(scroll_top > offset.top && !element.hasClass('scrolltop')) {
                element.addClass('scrolltop');
                
                if(scroll_top > (element.parent().height() + offset.top) - element.height()) {
                    element.addClass('scrolltopend');
                }
            } else if(scroll_top <= offset.top) {
                element.removeClass('scrolltop');
            } else if(scroll_top > (element.parent().height() - element.height())) {                
                element.addClass('scrolltopend');
                element.attr('style', origAttr + 'top: '+ '29px !important;');                 
            } else if(scroll_top <= (element.parent().height() + offset.top) - element.height()) {
                element.removeClass('scrolltopend');
                element.attr('style', origAttr);
                if(element.hasClass('cntn-scroll')) {
                    
                }
            }   
            element.show();

}
        
        