jQuery(document).ready(function($){
    var temp = $("div.pgsection").length;
    var strHtml = "<div id='pgnavigator'><ul>"; 
    for(i = 1; i <= temp; i++)
    {
        strHtml = strHtml + "<li><a href='#'>&nbsp;&nbsp;&nbsp;</a></li>";
    }
    var strHtml = strHtml + "</ul></div>";
    $("#pgNavUp").after(strHtml);
    if(temp <= 0)
        $("#pageScrollerNav").hide();
    else
        $('body').pageScroller({ navigation: '#pgnavigator', sectionClass : 'pgsection',scrollOffset : '-' + _headerHeight + 'px' });
    
    $(window).scroll(function(){
        navAssignTitles();
    });
    setTimeout(function(){navAssignTitles();}, 1000);
    
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
        alert("Mail section here. .");
    });
});

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
    if(!endsWith(url, _currentfullscreenid))
    {
        if(url.indexOf("#") >= 0)
            url = url.substr(0, url.indexOf("#"));
        url = url + '#' + _currentfullscreenid;
    }
    _currentshareurl = url;
    var currentpage = jQuery("#" + _currentfullscreenid);
    window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + encodeURIComponent(_currentshareurl) + '&p[images][0]=http://staging.yogasmoga.com/skin/frontend/yogasmoga/yogasmoga-theme/images/yoga_logo_side.jpg&p[title]=' + currentpage.attr("desc") + '&p[summary]=Summary Here','Share_on_Faceook','toolbar=0,status=0,menubar=0,width=600,height=300,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 300) / 2);
}

function shareontw()
{
    var url = _currenturl;
    if(!endsWith(url, _currentfullscreenid))
    {
        if(url.indexOf("#") >= 0)
            url = url.substr(0, url.indexOf("#"));
        url = url + '#' + _currentfullscreenid;
    }
    _currentshareurl = url;
    var currentpage = jQuery("#" + _currentfullscreenid);
    //console.log('http://www.twitter.com/share?url=' + encodeURIComponent(url));
    window.open('http://www.twitter.com/share?url=' + encodeURIComponent(url),'Share_on_Twitter','toolbar=0,status=0,menubar=0,width=600,height=450,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 450) / 2);
}

function shareonpt()
{
    var url = _currenturl;
    if(!endsWith(url, _currentfullscreenid))
    {
        if(url.indexOf("#") >= 0)
            url = url.substr(0, url.indexOf("#"));
        url = url + '#' + _currentfullscreenid;
    }
    _currentshareurl = url;
    var currentpage = jQuery("#" + _currentfullscreenid);
    //console.log('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(url) + '&media=http://staging.yogasmoga.com/skin/frontend/yogasmoga/yogasmoga-theme/images/yoga_logo_side.jpg&description=hello');
    window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(url) + '&media=http://staging.yogasmoga.com/skin/frontend/yogasmoga/yogasmoga-theme/images/yoga_logo_side.jpg&description=' + currentpage.attr("desc"),'Share_on_Pinterest','toolbar=0,status=0,menubar=0,width=600,height=520,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 520) / 2);
}

function endsWith(str, suffix) {
    return str.indexOf(suffix, str.length - suffix.length) !== -1;
}

function navAssignTitles()
{
    jQuery("#pageScrollerNav img").attr("title", '');
    
    if(jQuery("div.pgsection:nth-child(" + (jQuery("#pgnavigator li.active").index() + 2) + ")").length > 0)
        jQuery("#pgNavDown img").attr("title", jQuery("div.pgsection:nth-child(" + (jQuery("#pgnavigator li.active").index() + 2) + ")").attr("desc"));
    if(jQuery("div.pgsection:nth-child(" + (jQuery("#pgnavigator li.active").index()) + ")").length > 0)
        jQuery("#pgNavUp img").attr("title", jQuery("div.pgsection:nth-child(" + (jQuery("#pgnavigator li.active").index()) + ")").attr("desc"));
    _currentfullscreenid = jQuery("div.pgsection:nth-child(" + (jQuery("#pgnavigator li.active").index() + 1) + ")").attr("id");
    //console.log(_currentfullscreenid);
}

