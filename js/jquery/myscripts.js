var _productcolorinfo = new Array();

jQuery(document).ready(function($){
        //console.clear();
	$(window).load(function(){
		jQuery('.cart select, .catalog-product-view select, .checkout-onepage-index select').each(function(){
			jQuery(this).customSelect();
		})
	});
    $(".spbutton").live("mousedown", function(){
        $(this).css('background-image', "url('" + $(this).attr('downimageurl') + "')");
    });
    $(".spbutton").live("mouseup", function(){
        $(this).css('background-image', "url('" + $(this).attr('imageurl') + "')");
    });
    $(".spbutton").live("mouseleave", function(){
        $(this).css('background-image', "url('" + $(this).attr('imageurl') + "')");
    });
    
    //setTimeout(function(){ fixiebug();}, 100);
    //$(".spbutton").mousedown(function(){
//        $(this).css('background-image', "url('" + $(this).attr('downimageurl') + "')");
//    });
//    
//    $(".spbutton").mouseup(function(){
//        $(this).css('background-image', "url('" + $(this).attr('imageurl') + "')");
//    });
//    
//    $(".spbutton").mouseleave(function(){
//        $(this).css('background-image', "url('" + $(this).attr('imageurl') + "')");
//    });
    //console.log(_productcolorinfo);
});

function removenotifications()
{
    jQuery(".notification").fadeOut();
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

//document.onscroll = function() { jQuery("#pagecontainer").css('background-position','0px -' + (jQuery(window).scrollTop()) + 'px'); };



function handleScroll()
{
    $("#pagecontainer").css('background-position','0px -' + ($(window).scrollTop()) + 'px');
}

function isScrolledIntoView(elem)
{
    var docViewTop = jQuery(window).scrollTop();
    var docViewBottom = docViewTop + jQuery(window).height();

    var elemTop = jQuery(elem).offset().top;
    var elemBottom = elemTop + jQuery(elem).height();
    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

function fixiebug()
{
    jQuery("table.staticproductgrid td.productimage img").each(function(){
        if(jQuery(this).height() > jQuery(this).parent().height())
            jQuery(this).css('max-height','400px');
        else
            jQuery(this).css('max-height','auto');
    });
}