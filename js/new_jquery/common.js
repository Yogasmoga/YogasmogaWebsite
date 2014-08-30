var _refercount = 1;
jQuery(window).load(function($){    
    featuredSec(); 
    colorStorySec();
    featLiHeightAd(); 
    browserTest();
    setFeatureVideoWidth();    
    var featLiH = jQuery(".featureList span.ftrFig img.df-img").first().height();
    jQuery(".featureList span.ftrFig").css("height", featLiH);   
    playBtnPos();
    sizeChartScroll();        
});
jQuery(document).ready(function($){ 
    var isSafari = browserTest();
    if(isSafari){
        jQuery("ul.main-menu2 a.main-heading").css("height","31px");
    }
sizeChartPop(); 
    $("#productdetails").on("click",".vlink-cont a",function(){
        $(".fitDetail .video-block img").click();
    });

    $(".goy-form").on("click",".button.btn-reset", function(e){  
        e.preventDefault();
        $("#createcardform td.inputholder input, #createcardform .goy-form #mail-message").each(function(){
            var goyReset = $(this).attr("watermark");
            $(this).attr("value", goyReset);
        });            
    }); 

    winW = $(window).width();
    var designVid = $(".html-des-vid-popup");
    var fitVid = $(".html-fit-vid-popup");
    var htmlVidpop = $(".html-video-popup");
    var pdpVidPop = $(".vid-popup-overlay");
    /***Functions to called on resize***/
    $(window).resize(function(){        
        featuredSec();
        colorStorySec();
        setImageContheightPDP();
        madeinusa();
        setFeatureVideoWidth();
        goys();
        playBtnPos();
        var featLiH = jQuery(".featureList span.ftrFig img.df-img").first().height();
        jQuery(".featureList span.ftrFig").css("height", featLiH); 
        var vidOverlayW = pdpVidPop.width();
        var vidOverlayH = pdpVidPop.height();
        var vidPopWidth = $(".html-vid-pop").width();
        var vidPopHeight = $(".html-vid-pop").height();
        $(".html-vid-pop").css({"left": (vidOverlayW - vidPopWidth)/2, "top" : (vidOverlayH - vidPopHeight)/2 }); 
        $(".html-video-popup").css({"left": (vidOverlayW - htmlVidpop.width())/2, "top" : (vidOverlayH - htmlVidpop.height())/2 });
        /**Size Chart popup**/
        var sizePop = jQuery(".size-chart-pop");
        var popOver = jQuery(window);        
        var topPos = (popOver.height() - sizePop.height())/2;
        var leftPos = (popOver.width() - sizePop.width())/2;        
        sizePop.css({"top": topPos, "left": leftPos});
        playBtnPos();
        sizeChartScroll();
    });  

    $(".bottom-left-block.mens-left-blockbg").on("click", function(e){
        e.stopImmediatePropagation();
    });  

    $(".bottom-left-block,.top-right-block").on("click", function(){
        var vidHandle = $(this).data("vid-handle");               
        pdpVidPop.fadeIn();      
        $("#" + vidHandle).css({"left" : (pdpVidPop.width() - htmlVidpop.width())/2, "top" : (pdpVidPop.height() - htmlVidpop.height())/2 }).fadeIn();
        jQuery(window).resize();
        var dfVid1 = document.getElementById("vid-1");
        dfVid1.play();
        var dfVid2 = document.getElementById("vid-2");
        dfVid2.play();               
    });

    $("body.catalog-product-view").on("click", "ul.featureList li:nth-child(4)", function(){               
        // $("body").scrollTop(0);
        pdpVidPop.fadeIn();        
        var designVidWidth = designVid.width();
        var designVidHeight = designVid.height();
        var pdpVidPopHeight = pdpVidPop.height();
        var pdpVidPopWidth = pdpVidPop.width();          
        designVid.css({"left" : (pdpVidPopWidth - designVidWidth)/2, "top" : (pdpVidPopHeight - designVidHeight)/2 }).fadeIn();
        var dfVid = document.getElementById("df-vid");
        dfVid.play();
        jQuery(window).resize();        
    });

    $("body.catalog-product-view").on("click", ".fitDetail .video-block img", function(){       
        // $("body").scrollTop(0);
        pdpVidPop.fadeIn();
        var fitVidWidth = fitVid.width();  
        var fitVidHeight = fitVid.height();
        var pdpVidPopHeight = pdpVidPop.height();  
        var pdpVidPopWidth = pdpVidPop.width();              
        fitVid.css({"left" : (pdpVidPopWidth - fitVidWidth)/2, "top" : (pdpVidPopHeight - fitVidHeight)/2}).fadeIn();
         var measureVid = document.getElementById("measure-vid");
        measureVid.play();
        jQuery(window).resize();       
    });
   
    window.onkeyup = function (event) {
        if (event.keyCode == 27) {              
            $(".vid-popup-overlay,.html-des-vid-popup,.html-fit-vid-popup,.size-chart-pop").fadeOut();
            htmlVidpop.fadeOut();
        }
    }
    jQuery("body").on("click",".vid-popup-overlay", function(){
        $(".vid-popup-overlay,.html-des-vid-popup,.html-fit-vid-popup,.size-chart-pop").fadeOut();
            htmlVidpop.fadeOut();
    });
   // $("body").scrollTop(0);
    /**For the cms pages**/
    $(".cms-side-nav ul li").on("click", function(){
        var sideCaller = $(this).data("caller");
        var sideContentOffsetTop = $(".cms-pg").find("section#" + sideCaller).offset().top - 98;
        var sideContentOffsetTopEX = $(".cms-pg").find("section#" + sideCaller).offset().top - 128;
        if(sideCaller == "what-smogi-bucks"){
            $("body,html").animate({scrollTop: sideContentOffsetTopEX}, 1500);
        }else{
            $("body,html").animate({scrollTop: sideContentOffsetTop}, 1500);
        }
        $(this).addClass("selected")
                .siblings()
                    .removeClass("selected");  
    });

	setFeatureVideoWidth();	
	goys();	
    function goys(){
    	var aH = $("body.gift_of_ys").find("button.button.btn-addtoaccount span img").height();    	
    	$("body.gift_of_ys").find("button.button.btn-check span img").css("height", aH);
    }
	
	$("body.cms-help").on("click", ".choosefile-cover", function(){
		$(this).parent().find("input#file_upload").trigger("click");		
	});

	/**Menu delay**/
	 $('ul.ctag-menu>li').hover(function(){
      var timer = $(this).data('timer');
      if(timer) clearTimeout(timer);
      var li = $(this);
      li.data('showTimer', setTimeout(function(){li.addClass('over'); },1));
    },
    function(){
      var showTimer = $(this).data('showTimer');
      if(showTimer) clearTimeout(showTimer);
      var li = $(this);
      li.data('timer', setTimeout(function(){ li.removeClass('over'); }, 500));
    });

   // hdrCenter();
    initializesignuppopup();
    initializeinvitepopup();
    initializesigninpopup();
    madeinusa();
    setTimeout(function(){
    	madeinusa();    	
    },1000);
    
    jQuery(".block3 a img").load(function(){
    	madeinusa();
    });       
    function setImageContheightPDP(){
        var pdpimagecontH = $("table.tdbigimagecontainer").find("img.shareit").height();
        $("table.productimagecontainer").parent(".upper-container").css("min-height", pdpimagecontH + 70);
    }


    var winHeight = $(window).height();
    $("div.2-columns-wrapper").find(".pg-content").css("min-height", winHeight - 96);
    $("#Allproducts").find(".gridProdCubix").css("min-height", winHeight - 96);     
    // $("div#mainimage").find(".pg-content,.account-nav").css("min-height", winHeight - 96);
    // $(".dashboard-index").find(".pg-content,.account-nav").css("min-height", winHeight - 96);        
    $(".share-strip").on("click",".sign-up-new a",function(){
        if(!_islogedinuser)
        {
            $("#signup").dialog( "open" );
        }
    });

	$(".footer-block").on("click",".smogi-love",function(){
         if(!_islogedinuser)
        {
		 $("#signup").dialog( "open" );			
        }
	});
    $(".footer-block").on("click","#invite-friend",function(){

        if(!_islogedinuser)
        {
            _isClickShareWithFriends = true;
            $("#signing_popup").dialog( "open" );
        }else{
            $("#invite_friends").dialog( "open" );
        }            
    });
    $(".footer-block").on("click","#welcome-name",function(e){

        if(!_islogedinuser)
        {
            e.preventDefault();
            _isClickFooterWelcomeName = true;
            $("#signing_popup").dialog( "open" );
        }
    });
    $(".footer-block").on("click","#footer-trackorder",function(e){

        if(!_islogedinuser)
        {
            e.preventDefault();
            _isClickFooterTrackOrder = true;
            $("#signing_popup").dialog( "open" );
        }
    });

    $(".right-top-block").on("click","ul.my-acnt li a",function(event){
        if(!_islogedinuser){
            event.preventDefault();
            _redirectFromSingingPopup = $(this).attr("href");
            $("#signing_popup").dialog( "open" );
        }
    });


        
    function initializesignuppopup(){
        $( "#signup" ).dialog({
                    autoOpen: false,
                    draggable: false,
                    resizable: false,
                    modal: true,
                    dialogClass : 'firstdialog',
                    position: { my: "center center",at: "center center"},
                    show: {
                        effect: "fade",
                        duration: 1000
                    },
                    hide: {
                        effect: "fade",
                        duration: 500
                    },
                    open: function( event, ui ) {
                        // jQuery("#popup-register input").val("").focus().blur();
                        $(".ui-widget-overlay").css("z-index","100");
                        $("input#pfirstname").blur();
                        $(".ui-widget-overlay").css({"top":"69px","position":"fixed"});
                        $(window).trigger("resize");
                        var pW = ($(document).width() - $(this).parent().width())/2;
                        var pH = ($(window).height() - $(this).parent().height())/2;                        
                        $(this).parent().css({left:pW,top:pH+10});
                        if ($(window).width() >= "1000") {
                            $("html,body").css("overflow-x","hidden");
                            //$(window).trigger("resize");
                        };
                    },
                    close: function( event, ui ) {
                        _checkjsnav = true;
                        if ($(window).width() >= "1000") {
                            $("html,body").css("overflow-x","auto");
                        };
            }
        });
    }

    function initializeinvitepopup(){
        $( "#invite_friends" ).dialog({
            autoOpen: false,
            draggable: false,
            resizable: false,
            modal: true,
            dialogClass : 'sharingDialog',
            position: { my: "center center",at: "center center"},
            show: {
                effect: "fade",
                duration: 1000
            },
            hide: {
                effect: "fade",
                duration: 500
            },
            open: function( event, ui ) {
                //$("#invite-friend-form input").val("").focus().blur();
                $(".ui-widget-overlay").css("z-index","100");
                $("input#friendname").blur();                
                $(".ui-widget-overlay").css({"top":"69px","position":"fixed"});
                $(window).trigger("resize");
                var pW = ($(document).width() - $(this).parent().width())/2;
                var pH = ($(window).height() - $(this).parent().height())/2;
                $(this).parent().css({left:pW,top:pH+10});
                if ($(window).width() >= "1000") {
                    $("html,body").css("overflow-x","hidden");
                    //$(window).trigger("resize");
                };
            },
            close: function( event, ui ) {
                _checkjsnav = true;
                if ($(window).width() >= "1000") {
                    $("html,body").css("overflow-x","auto");
                };
            }
        });
    }
    function initializesigninpopup(){
        $( "#signing_popup" ).dialog({
            autoOpen: false,
            draggable: false,
            resizable: false,
            modal: true,
            dialogClass : 'signinDialog',
            position: { my: "center center",at: "center center"},
            show: {
                effect: "fade",
                duration: 1000
            },
            hide: {
                effect: "fade",
                duration: 500
            },
            open: function( event, ui ) {                
                $(".ui-widget-overlay").css("z-index","100");
                if($("#signup").dialog( "isOpen" ) == true ){
                    $("#signup").dialog( "close" );
                }
                if($("#invite_friends").dialog( "isOpen" ) == true){
                    $("#invite_friends").dialog( "close" );
                }                  
                $("#sign-up-form input#fname").blur();
                $("#sign-up-form #s_password,#sign-in-form #si_password").blur();
                $(".ui-widget-overlay").css({top:69});
                $(window).trigger("resize");
                var pW = ($(document).width() - $(this).parent().width())/2;
                var pH = ($(window).height() - $(this).parent().height())/2;
                $(this).parent().css({left:pW,top:pH+10});
                if ($(window).width() >= "1000") {
                    $("html,body").css("overflow-x","hidden");
                    //$(window).trigger("resize");
                };
            },
            close: function( event, ui ) {
                _checkjsnav = true;
                if ($(window).width() >= "1000") {
                    $("html,body").css("overflow-x","auto");
                };
            }
        });
    }

    $(".sl-desc-handle").on("mouseover",function(){
        $(this).next(".slide-desc").fadeIn();        
    });
    $(".sl-desc-handle").on("mouseout",function(){ 
        $(".slide-desc").fadeOut();
        //setTimeout(function(){
            //$(".slide-desc").fadeOut();            
        //},4000);
    });

    // input box highlight on input focus
    $("#search_input").bind({
        focus: function(){
            $(this).parents(".search-bar").addClass("shdow-search-box");
        },
        focusout: function(){
            $(this).parents(".search-bar").removeClass("shdow-search-box");
        }        
    });

    // for holding sub-menu open for 2 sec

    /***Fake password hack***/
    
    $(".f_password").focus(function(){        
        var origPassword = $(this).parent().parent().next();
        $(this).closest(".fake_password").hide();
        $(origPassword).show();
        $(origPassword).find(".o_password").focus();
    });
    $(".o_password").blur(function(){         
        var fakeP = $(this).parent().parent().prev();
        var OrigP = $(this).parent().parent();
        OrigP.hide();
        fakeP.show();
        if($(this).val() != "" )
        {            
            fakeP.hide();
            OrigP.show();
        }        
        // if($.trim($(this).val()) == "Select a password")
        // {
        //     fakeP.show();
        //     OrigP.hide();          
        // }
    });     
    
});


function getCookie(cname)
{
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++)
    {
        var c = ca[i].trim();
        if (c.indexOf(name)==0) return c.substring(name.length,c.length);
    }
    return "";
}

function madeinusa(){
        var block3H = jQuery(".structure .block3").height();
        var usatxt = jQuery(".madeinusa-txt").height();

        var storeH = block3H - usatxt;
        var storeF = storeH/2;
    
        jQuery(".madeinusa-txt").css("top", storeF);        
    }

 function setFeatureVideoWidth(){
 	var featureVideo = jQuery(".video-design-block video");
 	var measureVideo = jQuery(".video-block img");
 	var leftMostLi = jQuery(".product-details ul.featureList li:nth-child(1)").width(); 	 	
 	var leftmidLi = jQuery(".product-details ul.featureList li:nth-child(2)").width();
 	var rightmidLi = jQuery(".product-details ul.featureList li:nth-child(3)").width();
 	var rightMostLi = jQuery(".product-details ul.featureList li:nth-child(4)").width();
 	var margnLeft = leftMostLi + 19;
 	var margnRight = jQuery("ul.featureList").width() - (leftMostLi + leftmidLi + rightmidLi + rightMostLi + 62);
 	var vidFeatureWidth = leftmidLi + rightmidLi + 24;
 	var vidMeasureWidth = rightMostLi + rightmidLi + 19;
 	$(featureVideo).css({"width": vidFeatureWidth, "margin-left" : margnLeft});
 	// $(measureVideo).css({"width": vidMeasureWidth, "margin-right" : margnRight});
    $(measureVideo).css({"width": vidMeasureWidth});   

 }
// function hdrCenter(){     var _wnWdth = jQuery(window).width();

//     var _hdrWdth = jQuery(".header-container").width();

//     var dvdWdth = _wnWdth - _hdrWdth;

//     var fCount = dvdWdth/2;

//     alert(fCount);


//     jQuery(".header-container").css("left", fCount); // }

function featuredSec(){
    var rbW = jQuery('.wl-right-block').width();
    var conWdth = jQuery(".wl-feat-prd").width();
    jQuery('.wl-left-block').css({"width": conWdth - rbW});     
    var fs_right = jQuery('.wl-right-block').height();
    jQuery(".wl-left-block").css("height", fs_right);
    var fs_left = jQuery(".wl-left-block").height();       
    var bIsAppleMobile = fnIsAppleMobile();  
    var isSafari = browserTest();    
    if(!bIsAppleMobile){ 
        jQuery(".wl-left-block .bottom-left-block,.wl-left-block .top-left-block").css("height", fs_right/2);
        if(isSafari){
            jQuery(".wl-left-block .top-left-block").css("height", fs_left/2);
            var fs_left_top = jQuery(".wl-left-block .top-left-block").height();
            var fs_left_bot_H = fs_left - fs_left_top;
            jQuery(".wl-left-block .bottom-left-block").css("height", fs_left_bot_H);
        }       
    }else if(bIsAppleMobile){           
            jQuery(".wl-left-block .top-left-block").css("height", fs_left/2);
            var fs_left_top = jQuery(".wl-left-block .top-left-block").height();
            var fs_left_bot_H = fs_left - fs_left_top;
            jQuery(".wl-left-block .bottom-left-block").css("height", fs_left_bot_H);
    } 
    // lft_vid_img.css("margin-top", (lft_vid - lft_vid_img_height)/2.07);           
        var posContent = setTimeout(function(){
            // jQuery(window).resize();
            jQuery(".wl-color-story-prd .block-content").each(function(){
                var bl_c_H = jQuery(this).height();
                var parH = jQuery(this).parent().height();
                var topPos = (parH - bl_c_H)/1.99;
                jQuery(this).css("top", topPos);                
            });                       
            clearTimeout(posContent);
        },5);
    jQuery(".wl-feat-prd,.wl-color-story-prd").animate({opacity:1},100);
              
}

 function colorStorySec(){
    var lbW = jQuery('.wl-cs-left-block').width();
    var conWdth = jQuery(".wl-color-story-prd").width();
    jQuery('.wl-cs-right-block').css({"width": conWdth - lbW});    
    var cs_left = jQuery('.wl-cs-left-block').height();
    jQuery(".wl-cs-right-block").css("height", cs_left);
    var cs_right = jQuery(".wl-cs-right-block").height();
    // console.log(cs_right + "----" + cs_left);    
    var bIsAppleMobile = fnIsAppleMobile();  
    var isSafari = browserTest();
    if(!bIsAppleMobile){
        jQuery(".wl-cs-right-block .top-right-block,.wl-cs-right-block .bottom-right-block").css("height", cs_right/2);
        if(isSafari){
            jQuery(".wl-cs-right-block .iconspartone").css("height", cs_right/2);    
            var cs_right_top = jQuery(".wl-cs-right-block #iconspartone").css("height");
            var cs_right_bot_H = cs_right - cs_right_top;    
            jQuery(".wl-cs-right-block .bottom-right-block").css("height", cs_right_bot_H);                        
        }
    }else if(bIsAppleMobile){
        jQuery(".wl-cs-right-block .top-right-block").css("height", cs_right/2);    
        var cs_right_top = jQuery(".wl-cs-right-block .top-right-block").height();
        var cs_right_bot_H = cs_right - cs_right_top;    
        jQuery(".wl-cs-right-block .bottom-right-block").css("height", cs_right_bot_H);
    }
    // rgt_vid_img.css("margin-top", (rgt_vid - rgt_vid_img_height)/2.07);

    jQuery(".wl-feat-prd .block-content").each(function(){
        var bl_c_H1 = jQuery(this).height();
        var parH1 = jQuery(this).parent().height();
        var topPos1 = (parH1 - bl_c_H1)/2;
        jQuery(this).css("top", topPos1);        
    });
    jQuery(".wl-feat-prd,.wl-color-story-prd").animate({opacity:1},100);   
       
}

function featLiHeightAd(){
    var featLiH = jQuery(".featureList span.ftrFig").first().height();
    jQuery(".featureList span.ftrFig").css("height", featLiH);
}


function validatereferform(elem)
{
    unsetAllError(elem);
    var flag = validatefields(elem);
    if(elem.find('td.email input').val() != "")
    {
        if(!validateEmail(elem.find('td.email input').val()))
        {
            setOnError(elem.find('td.email input'), "Please enter a valid Email Address.");
            flag = false;
        }
    }
    return flag;
}

function fnIsAppleMobile() 
{
    if (navigator && navigator.userAgent && navigator.userAgent != null) 
    {
        var strUserAgent = navigator.userAgent.toLowerCase();
        var arrMatches = strUserAgent.match(/(iphone|ipod|ipad)/);
        if (arrMatches != null) 
             return true;
    } // End if (navigator && navigator.userAgent) 

    return false;
} // End Function fnIsAppleMobile

function browserTest(){ 
   return jQuery.browser.safari;
}

function playBtnPos(){
    var plBtn =jQuery("ul.featureList li.last-df").find("img.vid-pl-btn");
    var plBtnW = plBtn.width();
    var plBtnH = plBtn.height();
    var pbConW = jQuery("ul.featureList li.last-df span.ftrFig").width();
    var pbConH = jQuery("ul.featureList li.last-df span.ftrFig").height();
    var topPos = (pbConH - plBtnH)/2;
    var leftPos = (pbConW - plBtnW)/2;
    plBtn.css({"top":topPos, "left":leftPos});    
}

function sizeChartScroll(){
    var smallSizeChart = jQuery("div.sm-size-chart");
    if(smallSizeChart.find("div.tble table").is(":visible")){
        smallSizeChart.find("a.size-res").attr("name","sizechart");
    }else{
        smallSizeChart.find("a.size-res").attr("name","");
    }
}

function sizeChartPop(){ 
    jQuery(".cms-help").on("click","#size-chart-vid", function(){  
        var sizePop = jQuery(".size-chart-pop");
        var popOver = jQuery(window);        
        var topPos = (popOver.height() - sizePop.height())/2;
        var leftPos = (popOver.width() - sizePop.width())/2;
        jQuery(".vid-popup-overlay").fadeIn();
        sizePop.css({"top": topPos, "left": leftPos}).fadeIn();
        var sizeChatVid = document.getElementById("sizeChartVid");
        sizeChatVid.play();
    });    
}

