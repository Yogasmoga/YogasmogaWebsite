jQuery(document).ready(function($){

    var objectPage={};

    // check for url with HASH value for cms pages
    if(window.location.hash != '') {
        var blockid = window.location.hash;
        blockid = blockid.substring(1, blockid.length);
        $(".pg-content").html("<img class='cms-loader' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/loading1.gif' />");
        retrievecmsblockcontent(blockid);
        $(".side-menu-bar ul li").each(function(){
            $(this).children("a").removeClass("current");
            if($(this).attr("data-blockid") == blockid)
            {
                $(this).children("a").addClass("current");
            }
        });

    }


    // check for click from left column in cms pages
    $(".side-menu-bar").on("click","ul li",function(event){

        $(this).siblings().children("a").removeClass("current");
        $(this).children("a").addClass("current");
        location.hash = $(this).children("a").attr("href");

//        event.preventDefault();
//        alert($(this).text());
        $(".pg-content").html("<img class='cms-loader' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/loading1.gif' />");
        var data = $(this).attr("data-blockid");
        retrievecmsblockcontent(data);
        event.preventDefault();
    });
    // check for click from top menu navigation for cms page
    $(".cms-header-link").on("click","li",function(event){
        $(".pg-content").html("<img class='cms-loader' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/loading1.gif' />");
        var blockid_data = $(this).attr("data-blockid");
        retrievecmsblockcontent(blockid_data);
        $(".side-menu-bar ul li").each(function(){
           $(this).children("a").removeClass("current");
           if($(this).attr("data-blockid") == blockid_data)
           {
               $(this).children("a").addClass("current");
           }
        });



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