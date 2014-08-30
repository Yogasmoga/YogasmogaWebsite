/*jQuery(document).ready(function($){
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
            // if($(window).scrollTop() >= document.body.offsetHeight && $('.leftnav').css('position') != 'fixed') {
            //     $('.leftnav').removeClass('topLeftMenu');
            // }
            // else if($(window).scrollTop() < leftnav && $('.leftnav').css('position') != 'relative') {  
            //     $('.leftnav').removeClass('topLeftMenu');
            // }
            // else if($(window).scrollTop() < leftnav && $('.leftnav').css('position') != 'relative') {
            //     //alert(scrollBottom);
            // }
            // else{}
            //  if(document.documentElement.clientHeight + $(document).scrollTop() >= document.body.offsetHeight  && $('.leftnav').css('position') == 'fixed') {
            //     // $('.leftnav').addClass('topLeftMenu', 400);
            //     $('.leftnav').animate({
            //         'top': -ftr
            //     }, 400);
            // }
            // else {  
            //     $('.leftnav').removeClass('topLeftMenu');
            // }        
        });
    }

});*/

jQuery(window).ready(function($){
    leftNavPos();
});
function leftNavPos(){
    var ra = '#sitemap,.scroller_anchor,.bannerFluid,.grid-bottom,.new-bot-divider:last-child';
    jQuery(ra).appear();
    
    var ra1 = jQuery(".gridProdCubix").find(".leftnav");
    var helpNav = jQuery("#pagecontainer").find(".side-menu-bar");
    var accntNav = jQuery("#pagecontainer").find(".account-nav");

    jQuery(document.body).on('appear','.grid-bottom', function(e, $affected) {
        ra1.addClass("pos-abs").removeClass("pos-fix").css({"top":"","bottom" : "400px"})     
     });
    jQuery(document.body).on('disappear', '.grid-bottom', function(e, $affected) { 
        ra1.addClass("pos-fix").removeClass("pos-abs").css({"bottom":"","top":"89px"});        
    });
    jQuery(document.body).on('disappear', '.bannerFluid', function(e, $affected) {         
        ra1.addClass("pos-fix").removeClass("pos-abs").css({"top":"89px"});        
      });
    jQuery(document.body).on('appear', '.bannerFluid,.scroller_anchor', function(e, $affected) {               
        ra1.addClass("pos-abs").removeClass("pos-fix").css({"top":"29px"});       
      });
    jQuery(document.body).on('appear','.new-bot-divider:last-child', function(e, $affected) {
        helpNav.addClass("pos-abs").removeClass("pos-fix").css({"top":"98px"});
        accntNav.addClass("pos-abs").removeClass("pos-fix").css({"top":""});             
     });
    jQuery(document.body).on('disappear', '.new-bot-divider:last-child', function(e, $affected) {          
        helpNav.addClass("pos-fix").removeClass("pos-abs").css({"top":"98px"});
        accntNav.addClass("pos-fix").removeClass("pos-abs").css({"top":"98px"}); 
      });
}

 // function collision($div1, $div2) {
 //      var x1 = $div1.offset().left;
 //      var y1 = $div1.offset().top;
 //      var h1 = $div1.outerHeight(true);
 //      var w1 = $div1.outerWidth(true);
 //      var b1 = y1 + h1;
 //      var r1 = x1 + w1;
 //      var x2 = $div2.offset().left;
 //      var y2 = $div2.offset().top;
 //      var h2 = $div2.outerHeight(true);
 //      var w2 = $div2.outerWidth(true);
 //      var b2 = y2 + h2;
 //      var r2 = x2 + w2;
        
 //      if (b1 < y2 || y1 > b2 || r1 < x2 || x1 > r2) return false;
 //      return true;
 //    }

 // jQuery(window).scroll(function(){
 //        var ra = collision(jQuery('.leftnav'), jQuery('.grid-bottom'));
 //        var ra1 =  collision(jQuery('.leftnav'), jQuery('#sitemap'));    
 //        console.log(ra + "---" + ra1);   
 //        if(ra || ra1){
 //            console.log("yes");
 //            jQuery('.leftnav').css({"top":"","bottom":"600px"});
 //        }else{
 //            jQuery('.leftnav').css({"position":"fixed","top":"89px","bottom":""});
 //        }      
 // });
