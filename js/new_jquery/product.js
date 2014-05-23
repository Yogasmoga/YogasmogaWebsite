jQuery(document).ready(function($){
    // Category links fixed on scroll function
    var wdth = $(".cntn-scroll").width();
    var nav = $('.scroller_anchor');

    if (nav.length) {
        var contentNav = nav.offset().top;
        $(window).scroll(function(){
            if($(window).scrollTop() >= contentNav && $('.cntn-scroll').css('position') != 'fixed') {
                // Change the CSS of the scroller to hilight it and fix it at the top of the screen.
                $('.cntn-scroll').css({
                    'position': 'fixed',
                    'top': '3px'
                });
                
                // this is container div class
                $(".cntn-scrol-not").css({
                    marginLeft: wdth
                });
            }
            else if($(window).scrollTop() < contentNav && $('.cntn-scroll').css('position') != 'relative') {         
                // Change the CSS and put it back to its original position.
                $('.cntn-scroll').css({
                    'position': '',
                    'top': ''
                });

                // this is container div class
                $(".cntn-scrol-not").css({
                    marginLeft: ''
                });
            }
        });
    }
//    else{
//        alert("Scrolling div in not present in the page.");
//    }
});