jQuery(document).ready(function($){
    $('.bgimage').toggle(
        function() {
        $("html, body").animate({ scrollTop: ($(this).offset().top - _headerHeight) }, "slow");
        $(this).animate({ height: _winH }, 'slow', function() {
        });
        },
        function() {
        $(this).animate({ height: 300 }, 'slow', function() {
        });
    });
    
    $("div.opimage").each(function(){
        $(this).height(getScaledheight($(this).attr("smorigheight"), $(this).attr("smorigwidth")));
    });
    
    $(window).resize(function(){
        $("div.opimage").each(function(){
            if(!($(this).hasClass('closed')))
            {
                $(this).find('img.big_big').show();
                $(this).find('img.big_small').show();
                if(_winW >= 1600)
                {
                    $(this).find('img.big_small').hide();
                    $(this).height(getScaledheight($(this).attr("origheight"), $(this).attr("origwidth")));
                }
                else
                {
                    $(this).find('img.big_big').hide();
                    $(this).height(getScaledheight($(this).attr("origheightsm"), $(this).attr("origwidthsm")));
                }
            }
            else
                $(this).height(getScaledheight($(this).attr("smorigheight"), $(this).attr("smorigwidth")));     
        });
    });
    
    $("div.opimage").click(function(){
        if($(this).is(':animated'))
            return;
        if($(this).hasClass('closed'))
        {
            if(_winW >= 1600)
            {
                $(this).find('img.big_small').hide();
                var newheight = getScaledheight($(this).attr("origheight"), $(this).attr("origwidth"));
            }
            else
            {
                var newheight = getScaledheight($(this).attr("origheightsm"), $(this).attr("origwidthsm"));
                $(this).find('img.big_big').hide();
            }
            $(this).find('img.small').fadeOut('fast');
            $(this).removeClass('closed');
            //$(this).slideDown('slow');
            $(this).animate({
                height : newheight
            }, 500);
            $(this).find('img.small').fadeOut('500');
        }
        else
        {
            $(this).addClass('closed');
            var newheight = getScaledheight($(this).attr("smorigheight"), $(this).attr("smorigwidth"));
            //console.log(newheight);
            $(this).animate({
                height : newheight
            }, 500, function(){
                //$(this).find('img.small').fadeIn('fast');
                $(this).find('img.big_big').show();
                $(this).find('img.big_small').show();
            });
            $(this).find('img.small').fadeIn('500');
        }
        $("html, body").animate({
            scrollTop: ($(this).offset().top - _headerHeight)
        }, 500);
    });
    
    function getScaledheight(originalheight, originalwidth)
    {
        //console.log('calculating');
        originalheight = originalheight * 1;
        originalwidth = originalwidth * 1;
        return ((originalheight / originalwidth) * (jQuery("div#pagecontainer").width() * 1));
    }
    
});