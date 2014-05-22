jQuery(document).ready(function($){
    
    // This is for view shopping bag div
    //var shoppingWdth = $(".shopping-cart").width();
    //shoppingWdth += 40;
    //var bodyHght = $(".wrapper").height();
    
    //$("ul.tr-menu").find("li:nth-child(4)").on("click", function(){
       // $(".shopping-cart").show().animate({
       //     height: bodyHght
     //   });
      //  $(".page").css("position", "relative").animate({
      //      left: -shoppingWdth
       //   });
   // });

   // $(".shopping-cart").find(".close").on("click", function(){
     //   $(".page").removeAttr( "style" );
    //    $(".shopping-cart").hide("slow").removeAttr( "style" );
   // });


    // This function is for fixing the category menu on window scroll
    var wdth = $(".cntn-scroll").width();

    $(window).scroll(function(e) {
        // Get the position of the location where the scroller starts.
        // Put Element "scroller_anchor" before the scroll
        var scroller_anchor = $(".scroller_anchor").offset().top;
        
        // Check if the user has scrolled and the current position is after the scroller's start location and if its not already fixed at the top
        // Apply Class "cntn-scroll" to make element scrollable 
        if ($(this).scrollTop() >= scroller_anchor && $('.cntn-scroll').css('position') != 'fixed') {
            // Change the CSS of the scroller to hilight it and fix it at the top of the screen.
            $('.cntn-scroll').css({
                'position': 'fixed',
                'top': '3px'
            });
            
            $(".cntn-scrol-not").css({
                marginLeft: wdth
            });
            
        }
        else if ($(this).scrollTop() < scroller_anchor && $('.cntn-scroll').css('position') != 'relative') {         
            // Change the CSS and put it back to its original position.
            $('.cntn-scroll').css({
                'position': '',
                'top': ''
            });
            $(".cntn-scrol-not").css({
                marginLeft: ''
            });
        }
    });

});