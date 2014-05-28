jQuery(document).ready(function($){

    $(".quick-view ").click(function(){

        showQuickViewPopup($(this).attr('id'));
    });
});
function showQuickViewPopup(productid)
{
    productid = parseInt(productid);
    jQuery("#productdetailpopup").html("<table style='width:100%;height : 530px;'><tr><td style='text-align:center;vertical-align:middle;'><img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/loading.gif' /></td></tr></table>");
    jQuery( "#productdetailpopup" ).dialog( "open" );
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/details';
    if(_usesecureurl)
        url = securehomeUrl + 'mycatalog/myproduct/details';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : {'id': productid},
        success : function(data){
            jQuery("#productdetailpopup").html(data);
            InitializeProductQty();
            if(jQuery("div#colorcontainer table:first").length > 0)
                changeColor(_dressingroomselectedcolor);
        }
    });
}