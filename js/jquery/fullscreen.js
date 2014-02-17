jQuery(document).ready(function($){
    //setfullscreenheight();
    setTimeout(function(){setfullscreenheight();},50);
    //setTimeout(function(){$(window).trigger("resize");},1500);
    
    //setfullscreenheight(true);
    $(window).resize(function($) {
        //alert("resized");
        setfullscreenheight();
       // getvideowidth();
    });
});

/*function getvideowidth()
{
    winW = _winW;
    if(winW < 1100)
        winW = 1100;
    videowidth = (1920/1080) * _winH;
    videoheight = (1080/1920) * winW;
    if((winW - videowidth) > (_winH - videoheight))
    {
        newwidth = winW + (winW - videowidth);
        newheight = (1080/1920) * newwidth;
    }
    else
    {
        newheight = _winH + (_winH - videoheight);
        newwidth = (1920/1080) * newheight;
    }
    jQuery(".fullscreenovfhidden iframe").width(newwidth);
    jQuery(".fullscreenovfhidden iframe").height(newheight);
    jQuery(".fullscreenovfhidden iframe").css('left',((winW - newwidth) / 2) + 'px');
    jQuery(".fullscreenovfhidden iframe").css('top',((_winH - newheight)/ 2) + 'px');
    return;
}
*/
function setfullscreenheight()
{
    //console.log('called');
    if (document.body && document.body.offsetWidth) {
     _winW = document.body.offsetWidth;
     _winH = document.body.offsetHeight;
    }
    if (document.compatMode=='CSS1Compat' &&
        document.documentElement &&
        document.documentElement.offsetWidth ) {
     _winW = document.documentElement.offsetWidth;
     _winH = document.documentElement.offsetHeight;
    }
    if (window.innerWidth && window.innerHeight) {
     _winW = window.innerWidth;
     _winH = window.innerHeight;
    }
    _winH = _winH - _headerHeight;
    jQuery("div.fullscreen").css('min-height', (_winH) + 'px');
    //jQuery("div.fullscreen, div.fullscreenovfhidden, div.bgimage").css('width', (_winW) + 'px');
    //jQuery("div.fullscreen, div.fullscreenovfhidden, div.bgimage").css('min-width', '1500px');
    
    //jQuery("div.fullscreenovfhidden").css('height', (_winH) + 'px');
    jQuery("div.fullscreenovfhidden").each(function(){
        if(jQuery(this).hasClass('neglectheaderwidth'))
        {
            if(!(jQuery("div#globalheader").hasClass('top0')))
            {
                jQuery(this).css('height', (_winH + _headerHeight) + 'px');
                //console.log('setting special height');
            }
            else
                jQuery(this).css('height', (_winH) + 'px');        
        }
        else
            jQuery(this).css('height', (_winH) + 'px');
        
    });
    var specialheight = false;
    jQuery.each(jQuery(".fullscreen"), function(){
        //jQuery(this).find("table:first").css('min-height',(_winH) + 'px');
//        jQuery(this).find("table:first").css('height',(_winH) + 'px');
        specialheight = false;
        //if(jQuery(this).hasClass('neglectheaderwidth'))
//        {
//            if(!(jQuery("div#globalheader").hasClass('top0')))
//            {
//                specialheight = true;
//            }
//        }
        if(specialheight)
        {
            jQuery(this).find("table.fullscreentable").css('min-height',(_winH + _headerHeight) + 'px');
            jQuery(this).find("table.fullscreentable").css('height',(_winH + _headerHeight) + 'px');
        }
        else
        {
            var tempheight = _winH;
            if(jQuery(this).hasClass("hdependson"))
            {
                tempheight = jQuery("#" + jQuery(this).attr("hdependson")).height();
                console.log(tempheight);
                if(tempheight < _winH)
                    tempheight = _winH; 
                else
                {
                    tempheight = tempheight + 30;
                    jQuery(this).css('min-height',(tempheight) + 'px');        
                }
            }
            jQuery(this).find("table.fullscreentable").css('min-height',(tempheight) + 'px');
            jQuery(this).find("table.fullscreentable").css('height',(tempheight) + 'px');   
        }
    });
    jQuery(".fullwidth").each(function(){
        //jQuery(this).width(_winW);
        jQuery(this).width(jQuery(".fullscreen:first").width());
    });
    jQuery(".fullscreenovfhidden img.fullscreen, .fullscreenovfhidden video.fullscreen").each(function(){
        var height = jQuery(this).height();
        height = getScaledheight(jQuery(this).attr("iheight"), jQuery(this).attr("iwidth")) * 1;
        if(height > _winH)
        {
            jQuery(this).css('top',((_winH - height) / 2) + 'px');
            jQuery(this).css('left', 0);
            jQuery(this).css('width', '100%');
            jQuery(this).css('height', 'auto');
        }
        else
    	{
        	height = getScaledwidth(jQuery(this).attr("iheight"), jQuery(this).attr("iwidth")) * 1;
        	//jQuery(this).css('left',((_winW - height) / 2) + 'px');
        	jQuery(this).css('top', 0);
        	jQuery(this).css('left',((_winW - height) / 2) + 'px');
            jQuery(this).css('width', 'auto');
            jQuery(this).css('height', '100%');
    	}
    });
    //jQuery(".fullscreen table:first").css('min-height',_winH + 'px');
//    jQuery(".fullscreen table:first").css('height',_winH + 'px');
    
    //jQuery("img.fullscreen").css('height',_winH + 'px');
    
    /* Comment out the below line to keep the parallax image fullscreen */
    //jQuery(".bgimage").css('background-size', _winW + 'px ' + _winH + 'px');
    
    //if(firsttime)
//        jQuery("#pageScrollerNav").css('top', (((_winH - jQuery("#pageScrollerNav").height()) / 2) - 40) + 'px');
//    else
    //if(_isglobalsharingopen)
//        jQuery("#pageScrollerNav").css('top', ((_winH + (_headerHeight * 2) - jQuery("#pageScrollerNav").height() - jQuery("#pageScrollerNav #shareicons").css('height')) / 2) + 'px');
//    else
//        jQuery("#pageScrollerNav").css('top', ((_winH + (_headerHeight * 2) - jQuery("#pageScrollerNav").height()) / 2) + 'px');
    
    if(_isglobalsharingopen)
        jQuery("#pageScrollerNav").css('top', ((_winH + (_headerHeight) - jQuery("#pageScrollerNav").height() - jQuery("#pageScrollerNav #shareicons").css('height')) / 2) + 'px');
    else
        jQuery("#pageScrollerNav").css('top', ((_winH + (_headerHeight) - jQuery("#pageScrollerNav").height()) / 2) + 'px');
    //console.log('w = ' + _winW + ' h = ' + _winH + ' s = ' + jQuery("#pageScrollerNav").height());
    
}