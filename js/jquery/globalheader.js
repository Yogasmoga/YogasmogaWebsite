jQuery(document).ready(function($){
        //$('.header-container').hover(
//        function() {
//        _ismenuhovered = true;
//        $('div.header').stop().animate({ top: 0 }, 'fast')},
//        function() {
//            //jQuery('div.header').stop().animate({ top: -65 }, 'fast');
//            _ismenuhovered = false;
//            closeHeader();    
//        }
//    );

    //setTimeout(function(){closeHeader(false);},4000);
    
    
    
//    $("*").click(function(){
//        closeHeader();
//    });


    setTimeout(function(){
    $("div.header-container div#smallmenu").fadeOut(500, function(){
        $("div.header-container div.header").animate({
            top : '0px'
        },500);
    })
    },4000);
    
    $("#search_text").blur(function(){
        //closeHeader();
        close_search_box();
    });
    
    selectcurrentanchors();    
});

function selectcurrentanchors()
{
    jQuery.each(jQuery("ul.topmenulinks a"), function(){
        if(jQuery(this).attr("href") == _currenturl)
        {
            jQuery(this).parent("li").addClass("selected");
        }
    });
}

function closeHeader()
{
    var ishover = _ismenuhovered;
    if(!jQuery("#search_text").is(':focus'))
    {
        //console.log(jQuery("div.header").is(':hover'));    
        if(!ishover)
        {
            close_search_box();
            jQuery('div.header').stop().animate({ top: -_headerHeight }, 'fast');
            setfullscreenheight();
        }   
    }
}