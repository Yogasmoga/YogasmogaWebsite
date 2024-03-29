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
		    if(!($(this).hasClass('fxheight'))){
            if(!($(this).hasClass('closed')))
            {
                if(_winW >= 1600)
                {
                    $(this).find('img.big_small').hide();
                    $(this).height(getScaledheight($(this).attr("origheight"), $(this).attr("origwidth")));
                }
                else
                {
					var newheight = getScaledheight($(this).attr("origheightsm"), $(this).attr("origwidthsm"));
					if(newheight < 770) newheight = 770;
                    $(this).find('img.big_big').hide();
                    $(this).height(newheight);
                }
            }
            else{
                $(this).height(getScaledheight($(this).attr("smorigheight"), $(this).attr("smorigwidth")));
			}
			}
        });
    });
    
    $("div.opimage").click(function(){
        if($(this).is(':animated'))
            return;
			if($(this).hasClass('closed'))
			{
				if(_winW >= 1600)
				{
					$(this).find('.big_big').fadeIn(0);
					var newheight = getScaledheight($(this).attr("origheight"), $(this).attr("origwidth"));
				}
				else
				{
					var newheight = getScaledheight($(this).attr("origheightsm"), $(this).attr("origwidthsm"));
					$(this).find('.big_small').fadeIn(0);
				}
				if(newheight < 770) newheight = 770;
				$(this).find('.small').fadeOut('fast');
				$(this).removeClass('closed');
				//$(this).slideDown('slow');
				$(this).animate({
					height : newheight
				}, 500);
			}
			else
			{
				$(this).addClass('closed');
				var newheight = getScaledheight($(this).attr("smorigheight"), $(this).attr("smorigwidth"));
				//console.log(newheight);
				$(this).find('.big_big').fadeOut('fast');
				$(this).find('.big_small').fadeOut('fast');
				$(this).find('.small').fadeIn('500');
				$(this).animate({
					height : newheight
				}, 500);
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
   navigator.sayswho= (function(){
		var N= navigator.appName, ua= navigator.userAgent, tem;
		var M= ua.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
		if(M && (tem= ua.match(/version\/([\.\d]+)/i))!= null) M[2]= tem[1];
		M= M? [M[1], M[2]]: [N, navigator.appVersion, '-?'];

		return M;
	})();
	var brwsr = navigator.sayswho[0].toLowerCase();
	var versn = navigator.sayswho[1].substring(0,3);
	if(brwsr == "safari"){
		if(versn == "5.1"){
			jQuery('div.opimage div.small').addClass('scrollbg');
		}
	}
});