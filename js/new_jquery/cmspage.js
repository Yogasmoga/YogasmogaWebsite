jQuery(document).ready(function($){


    var objectPage={};
    $(".side-menu-bar").on("click","ul li",function(event){

        $(this).siblings().children("a").removeClass("current");
        $(this).children("a").addClass("current");
        location.hash = $(this).children("a").attr("href");

//        event.preventDefault();
//        alert($(this).text());
        $(".pg-content").html("<img class='cms-loader' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/loading1.gif' />");
        var data = $(this).attr("data");
        retrievecmsblockcontent(data);
        event.preventDefault();
    });

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