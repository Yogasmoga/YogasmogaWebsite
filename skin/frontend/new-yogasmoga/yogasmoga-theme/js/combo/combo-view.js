var allSizes = [];
var allColors = [];
var allComboProducts = [];

jQuery(document).ready(function () {

    resizeSlider();

    jQuery(window).resize(function () {
        resizeSlider();
    });

    jQuery(".gift_set").click(function(){
        var product_id = jQuery(this).attr("rel");

        changeProduct(product_id);
    });
    
    jQuery(".add_to_bag").click(function(){

        if(jQuery(this).hasClass("bag-active")) {

            var giftIdCount = jQuery(this).attr('rel');

            var arGiftIdCount = giftIdCount.split(':');

            var giftId = arGiftIdCount[0];
            var currentProductColorCode = arGiftIdCount[1];
            var count = arGiftIdCount[2];

            addToBag(giftId, count, jQuery(this).closest(".product_filters"), currentProductColorCode);
        }
    });

    jQuery(".size").click(function(){

        jQuery(this).closest(".sizes").find(".size").removeClass("active-size");

        if(jQuery(this).hasClass("active-size"))
            jQuery(this).removeClass("active-size");
        else
            jQuery(this).addClass("active-size");

        if(jQuery(this).closest(".product_filters").find(".active-size").length==2) {
            jQuery(this).closest(".product_filters").find(".add_to_bag").addClass("bag-active");
            jQuery(this).closest(".product_filters").find(".add_to_bag").html('');
        }
        else {
            jQuery(this).closest(".product_filters").find(".add_to_bag").removeClass("bag-active");
            jQuery(this).closest(".product_filters").find(".add_to_bag").html('ADD TO BAG');
        }
    });
});

function resizeSlider(){
    var SliderWidth = jQuery(".slider").width();
    var SliderHeight = SliderWidth * 0.5;

    jQuery(".slider").height(SliderHeight)
}

function changeProduct(product_id){
console.log(allComboProducts);
    alert(product_id);
    jQuery(".product_name").html(allComboProducts[product_id]["name"]);
    jQuery(".product_price").html(allComboProducts[product_id]["price"] + "<span>" + allComboProducts[product_id]["quantity"] + " SETS REMAINING</span>");

/*
    var url = homeUrl + '/ys/utility/giftsetdata';

    jQuery.ajax({
        url: url,
        type: 'GET',
        data: 'id=' + product_id,
        success: function(result){

            changeNames(id);
            changeSizes(id);
            changeImages(id);
        }
    });
*/
}

function changeNames(id){
    jQuery(".sizes").html("");

    for(var i=0; i< sizes[id].length;i++) {
        var size = sizes[id][i];
        var str = "class='size size-" + i + "' rel='" + allSizes[size] + "'>" + size + "</span>";
        jQuery(".sizes").append(str);
    }
}

function changeSizes(id){

}

function changeImages(id){

}


function addToBag(giftProductId, count, parent, currentProductColorCode){
    var colorAttributeId = 92;
    var sizeAttributeId = 138;

    var ar = Array();
    for(var i=0;i<count;i++){
        var size = parent.find(".size-" + i + ".active-size").attr("rel");
        var size_data = sizeAttributeId + "-" + size;
        var color_data = colorAttributeId + "-" + parent.find(".product-color-" + i).attr("rel");
        var product_id = parent.find(".product-detail-" + i).attr("rel");
        ar.push(product_id + ":" + color_data + ":" + size_data);
    }

    var bundle_data = ar.join();

    var productUrl = homeUrl + 'mycheckout/mycart/add?product=' + giftProductId;
    productUrl += '&qty=' + _productorderqty;
    productUrl += '&super_attribute[' + colorAttributeId + ']=' + currentProductColorCode;
    productUrl += '&type=gift';
    productUrl += '&bundle=' + bundle_data;

    productUrl += '&showhtml=0';

    jQuery("#addtobagloader").show();

    jQuery.ajax({
        type: 'POST',
        url: productUrl,
        data: {},
        success: function (result) {
            jQuery(".sizes").find(".size").removeClass("active-size");
            jQuery(".add_to_bag").removeClass("bag-active");
            jQuery(".add_to_bag").html('ADD TO BAG');

            jQuery("#addtobagloader").show();
            jQuery("div#myminicart").html(result.html);
            showShoppingBagHtmlOpen();
        }
    });
}
