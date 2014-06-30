jQuery(document).ready(function($){

    var objectPage={};

    // check for url with HASH value for cms pages
    if(window.location.hash != '') {
        var blockid = window.location.hash;
        blockid = blockid.substring(1, blockid.length);

        // if(blockid == 'get-smogi-bucks') {
        //     scrollToAnchor('get-smogi-bucks');            
        // }

        //if((blockid != 'get-smogi-bucks') && (blockid != 'smogi-bucks-balance')) {
        //  check for cms page hash values
        if((blockid == 'story')||(blockid == 'corevalues')||(blockid == 'outethics')||(blockid == 'mageinusa')||(blockid == 'principles')||(blockid == 'namaskar')||(blockid == 'press')||(blockid == 'ys-fabric-tech')||(blockid == 'ys-color-tech')||(blockid == 'design-elements')||(blockid == 'smogibucks')||(blockid == 'faq')||(blockid == 'shipping-returns')||(blockid == 'size-chart')||(blockid == 'product-care')||(blockid == 'email-us')){
            $(".side-menu-bar ul li").children("a").find("span.arr").text("");
            $(".pg-content").html("<img class='cms-loader' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
            retrievecmsblockcontent(blockid);
            
            $(".side-menu-bar ul li").each(function(){
                $(this).children("a").removeClass("current");
                if($(this).attr("data-blockid") == blockid) {
                    $(this).children("a").addClass("current");
                    $(this).children("a").find("span.arr").text(">");
                }
            });

            $(".main-menu2 li").each(function(){
                $(this).removeClass("active");
                if($(this).attr("data-blockid") == blockid) {
                    $(this).addClass("active");
                }
            });
        }
        // check for login hash value for shot login form
        if(blockid == 'login')
        {
            if(!_islogedinuser)
            {
                _isClickSigninMenu = true;
                $("#signing_popup").dialog( "open" );
            }

        }
        // when there are some product in cart and user hit www.yogasmoga.com/checkout/cart/ than it is redirect to home page and open cart in right side.
        if(blockid == 'cart')
        {
            openShoppingCart();
        }

        $(".side-menu-bar2 ul li").each(function(){
            $(this).children("a").removeClass("current");
            if($(this).attr("data-id") == blockid) {
                $(this).children("a").addClass("current");
                $(this).children("a").find("span.arr").text(">");
            }
        });
    }
    $(".email-us").live("click",function(){
        alert('tests');
        initiateshareurl('mail');
    });

    // check for click from left column in cms pages
    $(".side-menu-bar").on("click","ul li",function(event){
        $(".side-menu-bar ul li").children("a").find("span.arr").text("");
        $(this).siblings().children("a").removeClass("current");
        $(this).children("a").addClass("current");
        location.hash = $(this).children("a").attr("href");
        $(this).children("a").find("span.arr").text(">");
        $(".pg-content").html("<img class='cms-loader' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
        var data = $(this).attr("data-blockid");
        retrievecmsblockcontent(data);
        event.preventDefault();
    });

    // check for click from smogi bucks left column in cms pages
    $(".side-menu-bar2").on("click","ul li",function(event){
        $(".side-menu-bar2 ul li").children("a").find("span.arr").text("");
        $(this).siblings().children("a").removeClass("current");
        $(this).children("a").addClass("current");
        $(this).children("a").find("span.arr").text(">");
        location.hash = $(this).children("a").attr("href");
        event.preventDefault();
    });    

    // check for click from top smogi bucks menu
    $(".mlink").on("click","li",function(event){
        $(".side-menu-bar2 ul li").children("a").find("span.arr").text("");
        var id_data = $(this).attr("data-id");        
        $(".side-menu-bar2 ul li").each(function(){
            $(this).children("a").removeClass("current");
            if($(this).attr("data-id") == id_data)
            {
               $(this).children("a").addClass("current");
               $(this).children("a").find("span.arr").text(">");
            }
        });        
    });    

    // check for click from top menu navigation for cms page
    $(".cms-header-link").on("click","li",function(event){
        if($(this).attr("data-blockid") != "empty"){
            $(".side-menu-bar ul li").children("a").find("span.arr").text("");
            $(".pg-content").html("<img class='cms-loader' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
            var blockid_data = $(this).attr("data-blockid");
            retrievecmsblockcontent(blockid_data);
            
            $(".side-menu-bar ul li").each(function(){
                $(this).children("a").removeClass("current");
                if($(this).attr("data-blockid") == blockid_data)
                {
                   $(this).children("a").addClass("current");
                   $(this).children("a").find("span.arr").text(">");
                }
            });
        }
       });


     // check for click from top menu navigation for cms page
    $(".main-menu2 li").find("a.main-heading").on("click",function(event){
        $(".side-menu-bar ul li, .side-menu-bar2 ul li").children("a").find("span.arr").text("");
        if($(this).parent("li").attr("data-blockid") != "empty"){
            $(".side-menu-bar ul li a").removeClass("current");
            $(".side-menu-bar2 ul li a").removeClass("current");
            $(".pg-content").html("<img class='cms-loader' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
            //alert($(this).parent("li").attr("data-blockid"));
            var blockid_data = $(this).parent("li").attr("data-blockid");
            var data_id = $(this).parent("li").attr("data-id");
            retrievecmsblockcontent(blockid_data);
            $(".side-menu-bar ul li").each(function(){
               $(this).removeClass("current");
               if($(this).attr("data-blockid") == blockid_data)
               {
                   $(this).children("a").addClass("current");
                   $(this).children("a").find("span.arr").text(">");
               }
            });    
        }
    });

    function scrollToAnchor(name){
        var aTag = $("a[name='"+ name +"']");
        $('html,body').animate({scrollTop: aTag.offset().top},'slow');
    }

    $(".side-menu-bar2 li[data-id='get-smogi-bucks'], .main-menu2 li[data-id='get-smogi-bucks']").click(function() {
       scrollToAnchor('get-smogi-bucks');
    });

    $(".side-menu-bar2 li[data-id='smogibucks'], .main-menu2 li[data-id='smogibucks']").click(function() {
       $('html,body').animate({'scrollTop' : 0},'slow');
    });

    $(".side-menu-bar2 li[data-id='smogi-bucks-balance'], .main-menu2 li[data-id='smogi-bucks-balance']").click(function() {
       scrollToAnchor('smogi-bucks-balance');
    });

    $(".sizechartlink .block-link a#sizechart").click(function() {
       scrollToAnchor('sizechart');
    });

    $(".howdoesitfitlink .block-link a#how-does-it-fit").click(function() {
       scrollToAnchor('how-does-it-fit');
    });


    // function for retrieving html for cms page via ajax
    function retrievecmsblockcontent(blockid)
    {
        if(window.location.href.indexOf('https://') >= 0)
            _usesecureurl = true;
        else
            _usesecureurl = false;
        var url = homeUrl + 'mycatalog/myproduct/retrievecmsblockcontent';
        if(_usesecureurl)
            url = securehomeUrl + 'mycatalog/myproduct/retrievecmsblockcontent';
        if(objectPage[blockid]){
            //alert(objectPage[blockid]);
            //$(objectPage[blockid]).appendTo(".pg-content");
            $(".pg-content").html($(objectPage[blockid]));

        }
        else{

            jQuery.ajax({
                url : url,
                type : 'POST',
                data : {'blockid':blockid},

                success : function(data){
                    data = eval('('+data + ')');
                    var status = data.status;

                    objectPage[blockid] = data.html;
                    if(status == "success")
                    {
                        $(".pg-content").html($(objectPage[blockid]));


                    }
                    else
                    {
                        $(".pg-content").html($(objectPage[blockid]));
                    }

                }
            });
        }
    }
});