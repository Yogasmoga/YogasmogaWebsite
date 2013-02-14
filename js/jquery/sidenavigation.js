var _sidenavtimer = '';
jQuery(document).ready(function($){	
    var temp = $("div.pgsection").length;
    if(temp < 2)
        $("#pageScrollerNav").hide();
    else
    {
        if(!_disablesidenavigation)
        {
            var strHtml = "<div id='pgnavigator'><ul>"; 
            for(i = 1; i <= temp; i++)
            {
                strHtml = strHtml + "<li><a href='#'>&nbsp;&nbsp;&nbsp;</a></li>";
            }
			if(_onipad){
				_headerHeight = 75;
			}
            var strHtml = strHtml + "</ul></div>";
            $("#pgNavUp").after(strHtml);
            $('body').pageScroller({animationSpeed:1000, deepLink:true, navigation: '#pgnavigator', sectionClass : 'pgsection',scrollOffset : '-' + _headerHeight + 'px' });   
			$("#pageScrollerNav").show(0);
        }
        else
            $("#pageScrollerNav").hide();
    }
    $(window).scroll(function(){
        //navAssignTitles();
        setTimeout(function(){ changesidenavpopupdesc();}, 200);
    });
    //setTimeout(function(){navAssignTitles();}, 1000);
    
    $("div#pageScrollerNav div#shareicons").hover(
        function(){
            _isglobalsharinghovered = true;        
        },
        function(){
            _isglobalsharinghovered = false;
            setTimeout(function(){ closeSharingOptions();}, 300);
        }
    );
    
    $("div#pageScrollerNav div#glbshare").hover(function(){
        _isglobalsharinghovered = true;
        if(_isglobalsharingopen || _isglobalsharinganimating)
            return;
        _isglobalsharingopen = true;
        _isglobalsharinganimating = true;
        $("div#pageScrollerNav div#shareicons").animate({
            height : '100px'
        }, 500);
        $("div#pageScrollerNav").animate({
            top : '-=100'
        }, 500, function(){
            _isglobalsharinganimating = false;
        });
    }, function(){
        _isglobalsharinghovered = false;
        if(!_isglobalsharingopen)
            return;
        //console.log('called');
        setTimeout(function(){ closeSharingOptions();}, 300);
    });
    
    $("#pageScrollerNav #shareicons #facebook").click(function(){
        shareonfb();
    });
    
    $("#pageScrollerNav #shareicons #twitter").click(function(){
        shareontw();
    });
    
    $("#pageScrollerNav #shareicons #pinterest").click(function(){
        shareonpt();
    });
    
    $("#pageScrollerNav #shareicons #mail").click(function(){
        shareonmail();
    });
    if(!_onipad){
		$("div#pgNavDown").hover(function(){
			window.clearInterval(_sidenavtimer);
			_sidenavtimer = setTimeout(function(){
				$("div.sidenavpopup").css('top', ($("div#pageScrollerNav").css('top').substr(0, $("div#pageScrollerNav").css('top').length - 2) * 1) + $("div#pageScrollerNav").height() - 23 + 'px').addClass('pgdown');
				if(jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index() + 1).length == 0)
					return;
				$("div.sidenavpopup div").html(jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index() + 1).attr("desc"));
				$("div.sidenavpopup").fadeIn('fast');
			}, 200);
		},
		function(){
			window.clearInterval(_sidenavtimer);
			_sidenavtimer = setTimeout(function(){
				$("div.sidenavpopup").fadeOut('fast');
				$("div.sidenavpopup").removeClass('pgup').removeClass('pgdown');
			}, 200);
		}
		);
		
		$("div#pgNavUp").hover(function(){
			window.clearInterval(_sidenavtimer);
			_sidenavtimer = setTimeout(function(){
				if(_isglobalsharingopen)
					$("div.sidenavpopup").css('top', ($("div#pageScrollerNav").css('top').substr(0, $("div#pageScrollerNav").css('top').length - 2) * 1) + 53 + jQuery("#pageScrollerNav #shareicons").height() + 'px').addClass('pgup');
				else
					$("div.sidenavpopup").css('top', ($("div#pageScrollerNav").css('top').substr(0, $("div#pageScrollerNav").css('top').length - 2) * 1) + 53 + 'px').addClass('pgup');
				if((jQuery("#pgnavigator li.active").index() - 1) < 0)
				//if(jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index() - 1).length == 0)
					return;
				$("div.sidenavpopup div").html(jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index() - 1).attr("desc"));
				$("div.sidenavpopup").fadeIn('fast');
			}, 200);
		},
		function(){
			window.clearInterval(_sidenavtimer);
			_sidenavtimer = setTimeout(function(){
				$("div.sidenavpopup").fadeOut('fast');
				$("div.sidenavpopup").removeClass('pgup').removeClass('pgdown');
			}, 200);
		});
	}
});

function changesidenavpopupdesc()
{
    if(jQuery("div.sidenavpopup").hasClass('pgup'))
    {
        if((jQuery("#pgnavigator li.active").index() - 1) >= 0)
        //if(jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index() - 1).length > 0)
            jQuery("div.sidenavpopup div").html(jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index() - 1).attr("desc"));
        else
        {
            jQuery("div.sidenavpopup").fadeOut('fast');
            jQuery("div.sidenavpopup").removeClass('pgup').removeClass('pgdown');
        }
    }
    if(jQuery("div.sidenavpopup").hasClass('pgdown'))
    {
        if(jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index() + 1).length > 0)
            jQuery("div.sidenavpopup div").html(jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index() + 1).attr("desc"));
        else
        {
            jQuery("div.sidenavpopup").fadeOut('fast');
            jQuery("div.sidenavpopup").removeClass('pgup').removeClass('pgdown');
        }
    }
}

function getcurrentfullscreenid()
{
    return jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index()).attr("id");    
}

function closeSharingOptions()
{
    if(_isglobalsharinghovered || !_isglobalsharingopen)
        return;
    _isglobalsharingopen = false;
    _isglobalsharinganimating = true;
    jQuery("div#pageScrollerNav div#shareicons").animate({
        height : '0px'
    }, 500, function(){
        _isglobalsharinganimating = false;
    });
    jQuery("div#pageScrollerNav").animate({
        top : '+=100'
    }, 500);
}

function shareonfb()
{
    var url = _currenturl;
    var cfscreenid = getcurrentfullscreenid();
    if(!endsWith(url, cfscreenid))
    {
        if(url.indexOf("#") >= 0)
            url = url.substr(0, url.indexOf("#"));
        url = url + '#' + cfscreenid;
    }
    _currentshareurl = url;
    var currentpage = jQuery("#" + cfscreenid);
    //window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + encodeURIComponent(_currentshareurl) + '&p[images][0]=http://staging.yogasmoga.com/skin/frontend/yogasmoga/yogasmoga-theme/images/yoga_logo_side.jpg&p[title]=' + currentpage.attr("desc") + '&p[summary]=Summary Here','Share_on_Faceook','toolbar=0,status=0,menubar=0,width=600,height=300,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 300) / 2);
    if(_curshareimgurl == '')
        _curshareimgurl = 'https://yogasmoga.com/yogasmoga_gold.jpg';
    window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + encodeURIComponent(_currentshareurl) + '&p[images][0]=' + _curshareimgurl + '&p[title]=' + currentpage.attr("desc") + '&p[summary]=Summary Here','Share_on_Faceook','toolbar=0,status=0,menubar=0,width=600,height=300,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 300) / 2);
}

function shareontw()
{
    var url = _currenturl;
    var cfscreenid = getcurrentfullscreenid();
    if(!endsWith(url, cfscreenid))
    {
        if(url.indexOf("#") >= 0)
            url = url.substr(0, url.indexOf("#"));
        url = url + '#' + cfscreenid;
    }
    _currentshareurl = url;
    var currentpage = jQuery("#" + cfscreenid);
    //console.log('http://www.twitter.com/share?url=' + encodeURIComponent(url));
    window.open('http://www.twitter.com/share?url=' + encodeURIComponent(url),'Share_on_Twitter','toolbar=0,status=0,menubar=0,width=600,height=450,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 450) / 2);
}

function shareonpt()
{
    var url = _currenturl;
    var cfscreenid = getcurrentfullscreenid();
    if(!endsWith(url, cfscreenid))
    {
        if(url.indexOf("#") >= 0)
            url = url.substr(0, url.indexOf("#"));
        url = url + '#' + cfscreenid;
    }
    _currentshareurl = url;
    var currentpage = jQuery("#" + cfscreenid);
    //console.log('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(url) + '&media=http://staging.yogasmoga.com/skin/frontend/yogasmoga/yogasmoga-theme/images/yoga_logo_side.jpg&description=hello');
    //window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(url) + '&media=https://yogasmoga.com/yogasmoga_gold.jpg&description=' + currentpage.attr("desc"),'Share_on_Pinterest','toolbar=0,status=0,menubar=0,width=600,height=520,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 520) / 2);
    if(_curshareimgurl == '')
        _curshareimgurl = 'https://yogasmoga.com/yogasmoga_gold.jpg';
    window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(url) + '&media=' + _curshareimgurl + '&description=' + currentpage.attr("desc"),'Share_on_Pinterest','toolbar=0,status=0,menubar=0,width=600,height=520,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 520) / 2);
}

function shareonmail()
{
    var url = _currenturl;
    var cfscreenid = getcurrentfullscreenid();
    if(!endsWith(url, cfscreenid))
    {
        if(url.indexOf("#") >= 0)
            url = url.substr(0, url.indexOf("#"));
        url = url + '#' + cfscreenid;
    }
    _currentshareurl = url;
    var currentpage = jQuery("#" + cfscreenid);
    //console.log('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(url) + '&media=http://staging.yogasmoga.com/skin/frontend/yogasmoga/yogasmoga-theme/images/yoga_logo_side.jpg&description=hello');
    //window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(url) + '&media=http://staging.yogasmoga.com/skin/frontend/yogasmoga/yogasmoga-theme/images/yoga_logo_side.jpg&description=' + currentpage.attr("desc"),'Share_on_Pinterest','toolbar=0,status=0,menubar=0,width=600,height=520,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 520) / 2);
    //window.open('mailto:someone@example.com?Subject=Hello%20again','Share_on_Pinterest','toolbar=0,status=0,menubar=0,width=600,height=520,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 520) / 2);
    window.location = "mailto:?Subject=" + encodeURIComponent("Check it out!!") + "&body=" + encodeURIComponent("Check Out " + currentpage.attr("desc") + " at " + _currentshareurl);
}

function endsWith(str, suffix) {
    return str.indexOf(suffix, str.length - suffix.length) !== -1;
}

function navAssignTitles()
{
    
    jQuery("#pageScrollerNav img").attr("title", '');
    if(jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index() + 1).length > 0)
        jQuery("#pgNavDown img").attr("title", jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index() + 1).attr("desc"));
    if(jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index()).length > 0)
        jQuery("#pgNavUp img").attr("title", jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index()).attr("desc"));
    _currentfullscreenid = jQuery("div.pgsection").eq(jQuery("#pgnavigator li.active").index()).attr("id");
    //jQuery("#pageScrollerNav img").attr("title", '');
//    if(jQuery("div.pgsection:nth-child(" + (jQuery("#pgnavigator li.active").index() + 2) + ")").length > 0)
//        jQuery("#pgNavDown img").attr("title", jQuery("div.pgsection:nth-child(" + (jQuery("#pgnavigator li.active").index() + 2) + ")").attr("desc"));
//    if(jQuery("div.pgsection:nth-child(" + (jQuery("#pgnavigator li.active").index()) + ")").length > 0)
//        jQuery("#pgNavUp img").attr("title", jQuery("div.pgsection:nth-child(" + (jQuery("#pgnavigator li.active").index()) + ")").attr("desc"));
//    _currentfullscreenid = jQuery("div.pgsection:nth-child(" + (jQuery("#pgnavigator li.active").index() + 1) + ")").attr("id");
    //console.log(_currentfullscreenid);
}