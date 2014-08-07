jQuery(document).ready(function($){

// var bnrCMS = $(".bannerFluid").height();
// $('.leftnav').css("margin-top", bnrCMS);

// $(window).resize(function(){
//     var bnrCMS = $(".bannerFluid").height();
//     $('.leftnav').css("margin-top", bnrCMS);
// });

var nav = $('.side-menu-bar');
var hdr = $('.header-container').height();
hdr = hdr+4;

var sideNav = $('.side-menu-bar').height();
sideNav = sideNav/2;

var ftr = $('#sitemap').height();
var footerH = $('#sitemap').height();
var ftr5 = ftr/2;
ftr = ftr/2/1.6;

var ftr1 = $('#sitemap');

    if (ftr1.length) {          
        var leftnav = ftr1.offset().top;
        $(window).scroll(function(){                                     

            // All CMS/Static Pages
            if($(window).scrollTop() >= document.body.offsetHeight && $('.side-menu-bar').css('position') != 'fixed') {
                $('.top-divider').css('top', '');
            }
            else if($(window).scrollTop() < leftnav && $('.side-menu-bar').css('position') != 'relative') {  
                $('.top-divider').css('top', '');
            }
            else if($(window).scrollTop() < leftnav && $('.side-menu-bar').css('position') != 'relative') {
                //alert(scrollBottom);
            }
            else{}
             if(document.documentElement.clientHeight + $(document).scrollTop() >= document.body.offsetHeight  && $('.side-menu-bar').css('position') == 'fixed') {
                $('.side-menu-bar').animate({
                    'top': -sideNav
                }, 400);
            }
            else {  
                $('.side-menu-bar').css('top', '');
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
                // $('.leftnav').addClass('topLeftMenu', 400);
                $('.leftnav').animate({
                    'top': -ftr
                }, 400);
            }
            else {  
                $('.leftnav').removeClass('topLeftMenu');
            }        
        });
    }


});