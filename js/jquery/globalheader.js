jQuery(document).ready(function($){
	    if(_currenturl.indexOf('#') > 0){
			//$(window).scrollTop($(window).scrollTop() - _headerHeight);
			//console.log($("#"+ _currenturl.substr(_currenturl.indexOf('#') + 1)));
			var curhash = _currenturl.substr(_currenturl.indexOf('#') + 1)
			var curtarget = "#"+ curhash.charAt(0).toUpperCase() + curhash.slice(1);
			if($(curtarget).length){
				$(window).load(function(){
				$('html,body').animate({
					scrollTop: $(curtarget).offset().top - _headerHeight},
				'slow');
				})
			}
		}
	$(window).load(function(){
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
	    if(!($("div#globalheader").hasClass('top0'))){
			setTimeout(function(){
				//$("div.header-container div#smallmenu").fadeOut(500, function(){
				$("div#bodycompensator").show().height(0);
				$("div#bodycompensator").animate({
					height : 80
				}, 500);
				$("div#mainimage img.fullscreen").each(function(){
					var ttop = ($(this).css('top') * 1) - 120;
					//console.log(ttop);
					$(this).animate({
						top : ttop
					}, 500);
				});
				$("div#mainimage").animate({
					height : (($("div#mainimage").height() * 1) - 80)
				},500);
				$("div.header-container div.header").animate({
					top : '0px'
				},500, function(){
					//$("body").css('padding-top', '80px');
					$("div#globalheader").addClass('top0');
					//setfullscreenheight();
				});
				//})
			},2000);
		}
		var temp = $("div.pgsection").length;
		if(temp > 2 && !_disablesidenavigation){
			$('#pageScrollerNav').fadeIn(500);
		}
	})
    $("#search_text").blur(function(){
        //closeHeader();
        close_search_box();
    });
    
    selectcurrentanchors();    
    
    $("li#minicartlink").click(function(){
        $("div#myminicart").slideDown(500, function(){
            _minicartopen = true;
        });   
    });
    
    $("body").click(function(){
        if(_minicartopen && !_dontclosecart)
        {
            $("div#myminicart").slideUp(500,function(){
                _minicartopen = false; 
            });
        }
        _dontclosecart = false;
    });
    
    $("div#myminicart").click(function(){
        _dontclosecart = true;
    });
    
    loadminicart();
    
    $("div#myminicart img.delete").live("click", function(){
        if(_isdeletingcartitem)
            return;
        _minicartdeleteid = $(this).parents("div.minicartitems:first").attr("id");
        _isdeletingcartitem = true;
        var url = homeUrl + 'mycheckout/mycart/delete';
        if(_usesecureurl)
            url = securehomeUrl + 'mycheckout/mycart/delete';
        $.ajax({
            type : 'POST',
            url : url,
            data : {'id':_minicartdeleteid},
            success : function(result){
                result = eval('(' + result + ')');
                if(result.status == "success")
                {
                    jQuery("span.cartitemcount").html(result.count);
                    $("div#myminicart div#" + _minicartdeleteid).fadeOut('slow', function(){
                        $("div#myminicart div#" + _minicartdeleteid).remove();
                        $("div#myminicart div.subtotal td.totalprice").html(result.grandtotal);
                        if($("div#myminicart div.minicartitems").length == 0)
                        {
                            $("div#myminicart").html("<div class='minctitle'>Shopping bag</div><div class='totalitemcount noitem'>You have no items in your Bag.</div>");
                        }
                    });
                }
                _isdeletingcartitem = false;
            }
        })
    });
    
});

function loadminicart()
{
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mycheckout/mycart/minidetails';
    if(_usesecureurl)
        url = securehomeUrl + 'mycheckout/mycart/minidetails';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : {},
        success : function(result){
            result = eval('(' + result + ')');
            jQuery("div#myminicart").html(result.html);
            jQuery("span#cartitemcount").html(result.count);
        }
    });
}

function selectcurrentanchors()
{
    jQuery.each(jQuery("ul.topmenulinks a"), function(){
        if(jQuery(this).attr("href") == _currenturl)
        {
            jQuery(this).parent("li").addClass("selected");
        }
    });
}

function selectmenulink(link)
{
    jQuery.each(jQuery("ul.topmenulinks a"), function(){
        if(jQuery(this).attr("href") == link)
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