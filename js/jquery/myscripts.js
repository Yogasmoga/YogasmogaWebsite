var currenturl = window.location.href;
var currentfullscreenid = '';
var ismenuhovered = false;
var isglobalsharinghovered = false;
var isglobalsharingopen = false;
var isglobalsharinganimating = false;
var winW = 630, winH = 460;
var _headerHeight = 80;

jQuery(document).ready(function($){
    //console.clear();
    //$('.header-container').hover(
//        function() {
//        ismenuhovered = true;
//        $('div.header').stop().animate({ top: 0 }, 'fast')},
//        function() {
//            //jQuery('div.header').stop().animate({ top: -65 }, 'fast');
//            ismenuhovered = false;
//            closeHeader();    
//        }
//    );
    setTimeout(function(){
        $("div.header-container div#smallmenu").fadeOut(500, function(){
            $("div.header-container div.header").animate({
                top : '0px'
            },500);
        })
        },4000);
    
    setTimeout(function(){setfullscreenheight();},50);
    //setfullscreenheight(true);
    $(window).resize(function($) {
        console.log('resize');
        setfullscreenheight();
    });
    
    $("#search_text").blur(function(){
        //closeHeader();
        close_search_box();
    });
    //setTimeout(function(){closeHeader(false);},4000);
    
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
    
//    $("*").click(function(){
//        closeHeader();
//    });
    
    $('.bgimage').toggle(
        function() {
        $("html, body").animate({ scrollTop: ($(this).offset().top - _headerHeight) }, "slow");
        $(this).animate({ height: winH }, 'slow', function() {
        });
        },
        function() {
        $(this).animate({ height: 300 }, 'slow', function() {
        });
    });
    
    $('.flexslider').flexslider({
        controlNav: false,
        slideshowSpeed: 6000,
        directionNav: false,
        start: function(slider) {
            fixFlexisliderImage();
          },
        after: function(slider) {
        //$('.current-slide').text(slider.currentSlide);
        fixFlexisliderImage();
        }
    }); 
    
    $("#imagevideoarea").click(function(){
        console.log('from image map');
    });
    selectcurrentanchors();
    
    $("#txtNewsletterEmail").keypress(function (event) {
        if (event.which == 13) {
            SubscribeNewsletter();
            return false;
        }
    });
    
    $("#btnNewsletter").click(function(){
        SubscribeNewsletter();
    });
    
    $(window).scroll(function(){
        navAssignTitles();
    });
    setTimeout(function(){navAssignTitles();}, 1000);
    
    $("div#pageScrollerNav div#shareicons").hover(
        function(){
            isglobalsharinghovered = true;        
        },
        function(){
            isglobalsharinghovered = false;
            setTimeout(function(){ closeSharingOptions();}, 300);
        }
    );
    
    $("div#pageScrollerNav div#glbshare").hover(function(){
        isglobalsharinghovered = true;
        if(isglobalsharingopen || isglobalsharinganimating)
            return;
        isglobalsharingopen = true;
        isglobalsharinganimating = true;
        $("div#pageScrollerNav div#shareicons").animate({
            height : '100px'
        }, 500);
        $("div#pageScrollerNav").animate({
            top : '-=100'
        }, 500, function(){
            isglobalsharinganimating = false;
        });
    }, function(){
        isglobalsharinghovered = false;
        if(!isglobalsharingopen)
            return;
        //console.log('called');
        setTimeout(function(){ closeSharingOptions();}, 300);
    });
    
    $("#pageScrollerNav #shareicons #facebook").click(function(){
        shareonfb();
    });
});

function closeSharingOptions()
{
    if(isglobalsharinghovered || !isglobalsharingopen)
        return;
    isglobalsharingopen = false;
    isglobalsharinganimating = true;
    jQuery("div#pageScrollerNav div#shareicons").animate({
        height : '0px'
    }, 500, function(){
        isglobalsharinganimating = false;
    });
    jQuery("div#pageScrollerNav").animate({
        top : '+=100'
    }, 500);
}

function shareonfb()
{
    var url = currenturl;
    if(!endsWith(url, currentfullscreenid))
    {
        if(url.indexOf("#") >= 0)
            url = url.substr(0, url.indexOf("#"));
        url = url + '#' + currentfullscreenid;
    }
    var currentpage = jQuery("#" + currentfullscreenid);
    window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + encodeURIComponent(url) + '&p[images][0]=http://staging.yogasmoga.com/skin/frontend/yogasmoga/yogasmoga-theme/images/yoga_logo_side.jpg&p[title]=' + currentpage.attr("desc") + '&p[summary]=Summary Here','Share_on_Faceook','toolbar=0,status=0,menubar=0,width=600,height=300,left=' + (winW - 600) / 2 + ',top=' + (winH - 300) / 2);
    //window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + encodeURIComponent(url) + '&p[images][0]=http://staging.yogasmoga.com/skin/frontend/yogasmoga/yogasmoga-theme/images/yoga_logo_side.jpg&p[title]=' + currentpage.attr("desc") + '&p[summary]=Summary Here','Share_on_Faceook','toolbar=0,status=0,menubar=0,width=600,height=300');
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
    
    currentfullscreenid = jQuery("div.pgsection:nth-child(" + (jQuery("#pgnavigator li.active").index() + 1) + ")").attr("id");
    //console.log(currentfullscreenid);
}

function SubscribeNewsletter()
{
    if(jQuery("#txtNewsletterEmail").val() == "" || jQuery("#txtNewsletterEmail").val() == jQuery("#txtNewsletterEmail").attr("watermark"))
    {
        jQuery("#footernotification").html("Please provide your Email Address").removeClass("success").addClass("error").fadeIn();
        return;
    }
    if(!validateEmail(jQuery("#txtNewsletterEmail").val()))
    {
        jQuery("#footernotification").html("Doesn't look like that's a valid Email Address").removeClass("success").addClass("error").fadeIn();
        return;
    }
    else
    {
        jQuery("#footernotification").hide();
    }
    jQuery.ajax({
        type : 'POST',
        url : homeUrl + 'mynewsletter/mysubscriber/add',
        data : {'email': jQuery("#txtNewsletterEmail").val()},
        success : function(result){
            result = eval('(' + result + ')');
            if(result.status == "0")
                jQuery("#footernotification").html(result.message).removeClass("success").addClass("error").fadeIn();
            else
                jQuery("#footernotification").html(result.message).removeClass("error").addClass("success").fadeIn();
            //setTimeout(function(){ rremovenotifications(); }, 5000);
        }
    });
}

function removenotifications()
{
    jQuery(".notification").fadeOut();
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

//document.onscroll = function() { jQuery("#pagecontainer").css('background-position','0px -' + (jQuery(window).scrollTop()) + 'px'); };

function selectcurrentanchors()
{
    jQuery.each(jQuery("ul.topmenulinks a"), function(){
        if(jQuery(this).attr("href") == currenturl)
        {
            jQuery(this).parent("li").addClass("selected");
        }
    });
}

function handleScroll()
{
    $("#pagecontainer").css('background-position','0px -' + ($(window).scrollTop()) + 'px');
}

function isScrolledIntoView(elem)
{
    var docViewTop = jQuery(window).scrollTop();
    var docViewBottom = docViewTop + jQuery(window).height();

    var elemTop = jQuery(elem).offset().top;
    var elemBottom = elemTop + jQuery(elem).height();
    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

function closeHeader()
{
    var ishover = ismenuhovered;
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

function fixFlexisliderImage()
{
    //console.log(_headerHeight);
//    jQuery(".flexslider img.fullscreen").each(function(){
//        var height = jQuery(this).height();
//        console.log(height);
//        if(height > winH)
//        {
//            jQuery(this).css('top',(((winH - height) / 2)) + 'px');
//        }
//    });
}

function setfullscreenheight(firsttime)
{
    //console.log('called');
    if (document.body && document.body.offsetWidth) {
     winW = document.body.offsetWidth;
     winH = document.body.offsetHeight;
    }
    if (document.compatMode=='CSS1Compat' &&
        document.documentElement &&
        document.documentElement.offsetWidth ) {
     winW = document.documentElement.offsetWidth;
     winH = document.documentElement.offsetHeight;
    }
    if (window.innerWidth && window.innerHeight) {
     winW = window.innerWidth;
     winH = window.innerHeight;
    }
    winH = winH - _headerHeight;
    jQuery(".fullscreen").css('min-height', (winH) + 'px');
    jQuery(".fullscreenovfhidden").css('height', (winH) + 'px');
    jQuery.each(jQuery(".fullscreen"), function(){
        jQuery(this).find("table:first").css('min-height',(winH) + 'px');
        jQuery(this).find("table:first").css('height',(winH) + 'px');
    });
    jQuery(".fullscreenovfhidden img.fullscreen").each(function(){
        var height = jQuery(this).height();
        if(height > winH)
        {
            jQuery(this).css('top',((winH - height) / 2) + 'px');        
        }
    });
    //jQuery(".fullscreen table:first").css('min-height',winH + 'px');
//    jQuery(".fullscreen table:first").css('height',winH + 'px');
    
    //jQuery("img.fullscreen").css('height',winH + 'px');
    
    /* Comment out the below line to keep the parallax image fullscreen */
    //jQuery(".bgimage").css('background-size', winW + 'px ' + winH + 'px');
    
    //if(firsttime)
//        jQuery("#pageScrollerNav").css('top', (((winH - jQuery("#pageScrollerNav").height()) / 2) - 40) + 'px');
//    else
    if(isglobalsharingopen)
        jQuery("#pageScrollerNav").css('top', ((winH + (_headerHeight * 2) - jQuery("#pageScrollerNav").height() - jQuery("#pageScrollerNav #shareicons").css('height')) / 2) + 'px');
    else
        jQuery("#pageScrollerNav").css('top', ((winH + (_headerHeight * 2) - jQuery("#pageScrollerNav").height()) / 2) + 'px');
    //console.log('w = ' + winW + ' h = ' + winH + ' s = ' + jQuery("#pageScrollerNav").height());
}