jQuery(document).ready(function($){
        //console.clear();
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