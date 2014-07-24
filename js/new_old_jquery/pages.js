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

            // All CMS/Static Pages
            if($(window).scrollTop() >= document.body.offsetHeight && $('.side-menu-bar').css('position') != 'fixed') {
                $('.top-divider').removeClass('topMenu');
            }
            else if($(window).scrollTop() < leftnav && $('.side-menu-bar').css('position') != 'relative') {  
                $('.top-divider').removeClass('topMenu');
            }
            else if($(window).scrollTop() < leftnav && $('.side-menu-bar').css('position') != 'relative') {
                //alert(scrollBottom);
            }
            else{}
             if(document.documentElement.clientHeight + $(document).scrollTop() >= document.body.offsetHeight  && $('.side-menu-bar').css('position') == 'fixed') {
                $('.side-menu-bar').addClass('topMenu', 400);
            }
            else {  
                $('.side-menu-bar').removeClass('topMenu');
            } 
            
            // Women Grid LeftNavigation
            if($(window).scrollTop() >= document.body.offsetHeight && $('.leftnav').css('position') != 'fixed') {
                $('.leftnav').removeClass('topLeftMenu');
            }
            else if($(window).scrollTop() < leftnav && $('.leftnav').css('position') != 'relative') {  
                $('.leftnav').removeClass('topLeftMenu');
            }
            else if($(window).scrollTop() < leftnav && $('.leftnav').css('position') != 'relative') {
                //alert(scrollBottom);
            }
            else{}
             if(document.documentElement.clientHeight + $(document).scrollTop() >= document.body.offsetHeight  && $('.leftnav').css('position') == 'fixed') {
                $('.leftnav').addClass('topLeftMenu', 400);
            }
            else {  
                $('.leftnav').removeClass('topLeftMenu');
            }        
        });
    }


});