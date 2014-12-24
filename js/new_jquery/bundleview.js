jQuery(document).ready(function($){

    $(".bundle-view").click(function(event){
        console.log('test');
        event.preventDefault();
        showBundleViewPopup($(this).attr('pro-id'));
    });

    $("#bundleProductPopup").dialog({
        autoOpen: false,
        show: "fade",
        hide: "fade",
        width : 920,
        minHeight : 530,
        modal : true,
        draggable : false,
        position: { my: "center top",at: "center top+80" },
        resizable : false,
        dialogClass : 'yogidialog bundlePop'
    });
    jQuery("body").on("click",".bundlePop #closelightbox", function(){
        jQuery( "#bundleProductPopup" ).dialog( "close" );
    });
});

function showBundleViewPopup(id)
{
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/bundledetails';
    if(_usesecureurl)
        url = securehomeUrl + 'mycatalog/myproduct/bundledetails';

    jQuery("#bundleProductPopup").html("<table style='width:100%;height : 530px;'><tr><td style='text-align:center;vertical-align:middle;'><img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' /></td></tr></table>");
    jQuery( "#bundleProductPopup" ).dialog( "open" );
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : {'id': id},
        success : function(data){

            //_quickViewObjectPage[productid] = data;

            jQuery("#bundleProductPopup").html(data);
            jQuery("#colorcontainer div:first-child").click();

            var proCost = jQuery(".productcost").html().replace("$", "");
            var optCost = jQuery(".combo-sale").find("div.scarf1").attr("value");
             optCost = parseFloat(optCost).toFixed(2)*1;
            proCost = (proCost*1)+optCost;
            jQuery(".cs-total-price").html("$"+proCost);


            /*insertBraOption();
//            jQuery("#productdetailpopup #colorcontainer > div:first-child > table").trigger('click');
            jQuery("#colorcontainer > div table[value=" + firstClickColor + "]").trigger("click");


            InitializeProductQty();
            if(jQuery("div#colorcontainer table:first").length > 0)
                changeColor(_dressingroomselectedcolor);

            var nextIdView = jQuery("#" + productid).closest("li").next().children("a").attr("id");
            var prevIdView = jQuery("#" + productid).closest("li").prev().children("a").attr("id");
            // console.log(nextIdView+' '+prevIdView);
//alert(nextIdView);
            if(typeof(nextIdView) != 'undefined'){
                jQuery(".quick-next").attr("id", nextIdView).css("display", "block");
            }

            if(typeof(prevIdView) != 'undefined'){
                jQuery(".quick-prev").attr("id", prevIdView).css("display", "block");
            }

            jQuery(".quick-next").click(function(){

                showQuickViewPopup(jQuery(this).attr('id'));
            });
            jQuery(".quick-prev").click(function(){
                showQuickViewPopup(jQuery(this).attr('id'));
            });

            jQuery(document).keydown(function(e){
                //e.preventDefault();
                var PrevID = jQuery('.quick-prev').attr('id');
                if(typeof(PrevID) != 'undefined'){
                    if (e.keyCode == 37) {
                        //jQuery(".quick-prev").trigger('click');
                        jQuery(".quick-prev").trigger('click')(function(){
                            showQuickViewPopup(PrevID);
                        });

                    }

                }
                var NextID = jQuery('.quick-next').attr('id');
                if(typeof(NextID)  != 'undefined'){
                    if (e.keyCode == 39) {
                        //jQuery(".quick-next").trigger('click');
                        jQuery(".quick-next").trigger('click')(function(){
                            showQuickViewPopup(NextID);
                            // showQuickViewPopup(jQuery(this).attr('id'));
                        });


                    }
                }
            });*/

        }
    });
}