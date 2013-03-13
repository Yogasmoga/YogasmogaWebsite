var _productcolorinfo = new Array();
jQuery(document).ready(function($){
	
        //console.clear();
	//jQuery('#productdetails select, .cart select').customSelect();
	/*$(window).load(function(){
		jQuery('.cart select, .checkout-onepage-index select').each(function(){
			jQuery(this).customSelect();
		})
	});*/
    $(".spbutton").live("mousedown", function(){
        $(this).css('background-image', "url('" + $(this).attr('downimageurl') + "')");
    });
    $(".spbutton").live("mouseup", function(){
        $(this).css('background-image', "url('" + $(this).attr('imageurl') + "')");
    });
    $(".spbutton").live("mouseleave", function(){
        $(this).css('background-image', "url('" + $(this).attr('imageurl') + "')");
    });
    
    $(".spbutton").each(function(){
        $("body").append("<img src='" + $(this).attr('downimageurl') + "' class='nodisplay' />");
    });
    $j('.cart-table tr, #wishlist-table tr').hover(function(){
		$j(this).find('.btn-remove2').css('visibility','visible');
	}, function(){
		$j(this).find('.btn-remove2').css('visibility','hidden');
	})
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
	var popOpen = false;
	jQuery('.poplink').live('click',function(e){
		e.preventDefault();
		var target = $j(this).attr('href');
		$j(target).fadeIn(400);
	});
	$j('.popbox').live('mouseover', function(){
        popOpen = true;
    });
    $(".popbox").live('mouseout', function(){
        popOpen = false;
    });
	$("body").click(function(){
        if(!popOpen) $j('.popbox').fadeOut(400);
    });
    
    $("img#closesmlight").live('click', function(){
        $(this).parent().fadeOut('normal');
    });
    
    //$("table.gfredeem input").keypress(function(){
//        console.log($(this).val().length);
//    });
    
    $("table.gfredeem input, table#redeem input").keyup(function(e){
        //console.log(e.keyCode);
        if(e.keyCode == 9 || e.keyCode == 13 || e.keyCode == 16 || e.keyCode == 17 || (e.keyCode >= 37 && e.keyCode <= 40))
            return;
        //console.log($(this).val().length);
        if($(this).val().length > 5)
        {
            $(this).val($(this).val().substr(0,5));
            $(this).parent().next().next().find('input').focus().select();
        }
        if($(this).val().length == 5)
        {
            $(this).parent().next().next().find('input').focus().select();
        }
    });
    
    
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