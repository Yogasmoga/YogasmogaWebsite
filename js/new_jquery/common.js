jQuery(document).ready(function($){
    initializesignuppopup();
    initializeinvitepopup();
    initializesigninpopup();
    adjustimg();


        var winHeight = $(window).height();
        $("div.2-columns-wrapper").find(".pg-content,.side-menu-bar").css("min-height", winHeight);    

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



    function adjustimg(){
        var mw = $(".structure").width() - 14;        
        jQuery(".structure").each(function(){
            var jQuerythis = jQuery(this),
            blockOne = jQuerythis.find(".block3"),
            blockTwo = jQuerythis.find(".block4"),
            blockOneImg = blockOne.find("img"),
            blockTwoImg = blockTwo.find("img");
            blockOneImgHeight = blockOneImg.height() - 7,
            blockOneImgWidth = blockOneImg.width() - 7,
            blockTwoImgHeight = blockTwoImg.height() - 7,
            blockTwoImgWidth = blockTwoImg.width() - 7;
            ratioOne = (mw * blockTwoImgHeight) / (blockOneImgHeight * blockTwoImgWidth + blockTwoImgHeight * blockOneImgWidth);
            ratioTwo = (mw * blockOneImgHeight) / (blockOneImgHeight * blockTwoImgWidth + blockTwoImgHeight * blockOneImgWidth);
            blockOneImg.closest(".block3").width(ratioOne * blockOneImgWidth * 100 / mw + "%"); 
            blockTwoImg.closest(".block4").width(ratioTwo * blockTwoImgWidth * 100 / mw + "%");            
        });
    }

    $(".sl-desc-handle").on("mouseover",function(){
        $(this).next(".slide-desc").fadeIn();        
    });
    $(".sl-desc-handle").on("mouseout",function(){ 
        setTimeout(function(){
            $(".slide-desc").fadeOut();            
        },4000);
    });      
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