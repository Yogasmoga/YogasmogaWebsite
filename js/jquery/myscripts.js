var currenturl = window.location.href;
var currentfullscreenid = '';
var ismenuhovered = false;
var winW = 630, winH = 460;
jQuery(document).ready(function($){
    //console.clear();
    $('.header-container').hover(
        function() {
        ismenuhovered = true;
        $('div.header').stop().animate({ top: 0 }, 'fast')},
        function() {
            //jQuery('div.header').stop().animate({ top: -65 }, 'fast');
            ismenuhovered = false;
            closeHeader();    
        }
    );
    setfullscreenheight(true);
    $(window).resize(function($) {
        setfullscreenheight(false);
    });
    
    $("#search_text").blur(function(){
        closeHeader();
    });
    setTimeout(function(){closeHeader(false);},4000);
    
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
        $('body').pageScroller({ navigation: '#pgnavigator', sectionClass : 'pgsection' });
    
    $("*").click(function(){
        closeHeader();
    });
    
    $('.bgimage').toggle(
        function() {
        $("html, body").animate({ scrollTop: $(this).offset().top }, "slow");
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
        directionNav: false
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
});


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
            jQuery('div.header').stop().animate({ top: -80 }, 'fast');
            setfullscreenheight();
        }   
    }
}

function setfullscreenheight()
{
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
    jQuery(".fullscreen").css('min-height',winH + 'px');
    jQuery.each(jQuery(".fullscreen"), function(){
        jQuery(this).find("table:first").css('min-height',winH + 'px');
        jQuery(this).find("table:first").css('height',winH + 'px');    
    });
    //jQuery(".fullscreen table:first").css('min-height',winH + 'px');
//    jQuery(".fullscreen table:first").css('height',winH + 'px');
    
    jQuery("img.fullscreen").css('height',winH + 'px');
    jQuery(".bgimage").css('background-size', winW + 'px ' + winH + 'px');
    jQuery("#pageScrollerNav").css('top', ((winH - jQuery("#pageScrollerNav").height()) / 2) + 'px');
}