jQuery(document).ready(function($){
    initializesignuppopup();
    initializeinvitepopup();
    initializesigninpopup();
    adjustimg();
		$(".footer-block").on("click","#smogi-love",function(){
			$("#signup").dialog( "open" );			
		});
        $(".footer-block").on("click","#invite-friend",function(){

            $("#invite_friends").dialog( "open" );
        });
        $(".right-top-block").on("click","#signin",function(){

            $("#signing_popup").dialog( "open" );
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
            console.log("test");
        },5000);
    });      
        
        
});


