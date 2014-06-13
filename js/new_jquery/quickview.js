jQuery(document).ready(function($){


    $("table.normalproductdetail div#colorcontainer table").live("click", function(){
        $("table.normalproductdetail div#colorcontainer > div").removeClass("selected");
        $(this).parent("div").addClass("selected");
    });

    $(".quick-view").click(function(){
        showQuickViewPopup($(this).attr('id'));
    });

    // $(".quick-prev").click(function(){
    //     alert("dsfsdf");
    // });

    // $(".quick-next").click(function(){
    //     showQuickViewPopup($(this).attr('id'));
    // });        

});

function showQuickViewPopup(productid)
{
    productid = parseInt(productid);
    jQuery("#productdetailpopup").html("<table style='width:100%;height : 530px;'><tr><td style='text-align:center;vertical-align:middle;'><img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' /></td></tr></table>");
    jQuery( "#productdetailpopup" ).dialog( "open" );

    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/details';
    if(_usesecureurl)
        url = securehomeUrl + 'mycatalog/myproduct/details';

    if(_quickViewObjectPage[productid]){
        jQuery("#productdetailpopup").html(_quickViewObjectPage[productid]);
        jQuery("#productdetailpopup #colorcontainer > div:first-child > table").trigger('click');
        var nextIdView = parseInt(jQuery("#" + productid).closest("li").next().children("a").attr("id"));
        var prevIdView = parseInt(jQuery("#" + productid).closest("li").prev().children("a").attr("id"));

        if(nextIdView > 0){
            jQuery(".quick-next").attr("id", nextIdView).css("display", "block");
        }

        if(prevIdView > 0){
            jQuery(".quick-prev").attr("id", prevIdView).css("display", "block");
        }
        jQuery(".quick-next").click(function(){
            showQuickViewPopup(jQuery(this).attr('id'));
        });
        jQuery(".quick-prev").click(function(){
            showQuickViewPopup(jQuery(this).attr('id'));
        });
    }
    else{
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : {'id': productid},
        success : function(data){

            _quickViewObjectPage[productid] = data;
            jQuery("#productdetailpopup").html(data);
            jQuery("#productdetailpopup #colorcontainer > div:first-child > table").trigger('click');

            InitializeProductQty();
            if(jQuery("div#colorcontainer table:first").length > 0)
                changeColor(_dressingroomselectedcolor);

            var nextIdView = parseInt(jQuery("#" + productid).closest("li").next().children("a").attr("id"));
            var prevIdView = parseInt(jQuery("#" + productid).closest("li").prev().children("a").attr("id"));

            if(nextIdView > 0){
                jQuery(".quick-next").attr("id", nextIdView).css("display", "block");
            }

            if(prevIdView > 0){
                jQuery(".quick-prev").attr("id", prevIdView).css("display", "block");
            }

            jQuery(".quick-next").click(function(){
                showQuickViewPopup(jQuery(this).attr('id'));
            });
            jQuery(".quick-prev").click(function(){
                showQuickViewPopup(jQuery(this).attr('id'));
            });
        }
    });

    }

}

// function quickNavigation(){
//     var nextIdView = parseInt(jQuery("#" + productid).closest("li").next().children("a").attr("id"));
//     var prevIdView = parseInt(jQuery("#" + productid).closest("li").prev().children("a").attr("id"));

//     alert(nextIdView);

//     if(nextIdView > 0){
//         jQuery(".quick-next").attr("id", nextIdView).css("display", "block");
//     }

//     if(prevIdView > 0){
//         jQuery(".quick-prev").attr("id", prevIdView).css("display", "block");
//     }
// }