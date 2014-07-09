jQuery(document).ready(function($){

var nav = $('.side-menu-bar');
var hdr = $('.header-container').height();
hdr = hdr+4;

var nav = $('.side-menu-bar');

var ftr = $('#sitemap').height();
var ftr5 = ftr/2;
ftr = ftr/2/2;

var ftr1 = $('#sitemap');

    if (ftr1.length) {          
        var leftnav = ftr1.offset().top;
        $(window).scroll(function(){                                     
            if($(window).scrollTop() >= document.body.offsetHeight && $('.side-menu-bar').css('position') != 'fixed') {
                $('.top-divider').css({
                    'top': hdr
                });
            }
            else if($(window).scrollTop() < leftnav && $('.side-menu-bar').css('position') != 'relative') {  
                $('.top-divider').css({
                    'top': ''
                });
            }
            else if($(window).scrollTop() < leftnav && $('.side-menu-bar').css('position') != 'relative') {
                //alert(scrollBottom);
            }
            else{}
             if(document.documentElement.clientHeight + $(document).scrollTop() >= document.body.offsetHeight  && $('.side-menu-bar').css('position') == 'fixed') {
                $('.side-menu-bar').animate({
                    top: -ftr
                });
            }
            else {  
                $('.side-menu-bar').css({
                    'top': ''
                });
            } 
            
            if($(window).scrollTop() >= document.body.offsetHeight && $('.leftnav').css('position') != 'fixed') {
                $('.leftnav').css({
                    'top': hdr
                });
            }
            else if($(window).scrollTop() < leftnav && $('.leftnav').css('position') != 'relative') {  
                $('.leftnav').css({
                    'top': ''
                });
            }
            else if($(window).scrollTop() < leftnav && $('.leftnav').css('position') != 'relative') {
                //alert(scrollBottom);
            }
            else{}
             if(document.documentElement.clientHeight + $(document).scrollTop() >= document.body.offsetHeight  && $('.leftnav').css('position') == 'fixed') {
                $('.leftnav').animate({
                    top: -ftr5
                });
            }
            else {  
                $('.leftnav').css({
                    'top': ''
                });
            }        
        });
    }


});