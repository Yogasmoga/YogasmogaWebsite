jQuery(document).ready(function($){
	setFeatureVideoWidth();
	/***Functions to called on resize***/
	$(window).resize(function(){
        setImageContheightPDP();
        madeinusa();
        setFeatureVideoWidth();
    });
	
	$("body.cms-help").on("click", ".choosefile-cover", function(){
		$(this).parent().find("input#file_upload").trigger("click");		
	});

	/**Menu delay**/
	 $('ul.ctag-menu>li').hover(
    function()
    {
      var timer = $(this).data('timer');
      if(timer) clearTimeout(timer);
      var li = $(this);
      li.data('showTimer', setTimeout(function(){li.addClass('over'); },1));
    },

    function()
    {
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
    $("div.2-columns-wrapper").find(".pg-content").css("min-height", winHeight);    

	$(".footer-block").on("click","#smogi-love",function(){
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
    $(".footer-block").on("click","#welcome-name","#footer-trackorder",function(e){

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
                        $(".ui-widget-overlay").css({top:80});
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
                $(".ui-widget-overlay").css({top:80});
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
                $(".ui-widget-overlay").css({top:80});
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
 	var measureVideo = jQuery(".video-block video");
 	var leftMostLi = jQuery(".product-details ul.featureList li:nth-child(1)").width(); 	 	
 	var leftmidLi = jQuery(".product-details ul.featureList li:nth-child(2)").width();
 	var rightmidLi = jQuery(".product-details ul.featureList li:nth-child(3)").width();
 	var rightMostLi = jQuery(".product-details ul.featureList li:nth-child(4)").width();
 	var margnLeft = leftMostLi + 19;
 	var margnRight = jQuery("ul.featureList").width() - (leftMostLi + leftmidLi + rightmidLi + rightMostLi + 62);
 	var vidFeatureWidth = leftmidLi + rightmidLi + 24;
 	var vidMeasureWidth = rightMostLi + rightmidLi + 19;
 	$(featureVideo).css({"width": vidFeatureWidth, "margin-left" : margnLeft});
 	$(measureVideo).css({"width": vidMeasureWidth, "margin-right" : margnRight});
 }
// function hdrCenter(){     var _wnWdth = jQuery(window).width();

//     var _hdrWdth = jQuery(".header-container").width();

//     var dvdWdth = _wnWdth - _hdrWdth;

//     var fCount = dvdWdth/2;

//     alert(fCount);


//     jQuery(".header-container").css("left", fCount); // }
