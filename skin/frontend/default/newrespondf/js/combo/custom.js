var jm = jQuery.noConflict();
var isBraCupSelected = false;
var braOptionId;
var braOptionTypeId;

var braOptionYesId;
var braOptionTypeYesId;
var braOptionNoId;
var braOptionTypeNoId;

jm(document).ready(function() {

    jm(".close_gift_duplicate_popup").click(function(){
        jm(".gift_duplicate_popup").fadeOut();
    });

    jm(".add_to_shopping_bag").click(function(){

        if(jm(this).hasClass("bag-active")) {

            var giftIdCount = jm(this).attr('rel');

            var arGiftIdCount = giftIdCount.split(':');

            var giftId = arGiftIdCount[0];
            var currentProductColorCode = arGiftIdCount[1];
            var count = arGiftIdCount[2];

            addToBag(giftId, count, jm(this).closest(".details"), currentProductColorCode);
        }
    });

    jm(".size").click(function(){
        jm(this).closest(".sizes").find(".size").removeClass("active-size");
        jm(".error-text").html("");
        if(jm(this).hasClass("active-size"))
            jm(this).removeClass("active-size");
        else
            jm(this).addClass("active-size");

        var totalSetProducts = jm(this).closest(".details").find(".related_blocks>div").length;
        if(jm(this).closest(".details").find(".active-size").length==totalSetProducts) {
            jm(this).closest(".details").find(".add_to_shopping_bag").addClass("bag-active");
            jm(this).closest(".details").find(".choose_next").hide();
//			jm(this).closest(".product_filters").find(".add_to_wishlist").addClass("bag-active");
        }
        else {
            jm(this).closest(".product_filters").find(".add_to_bag").removeClass("bag-active");
            jm(this).closest(".details").find(".choose_next").show();
//			jm(this).closest(".product_filters").find(".add_to_wishlist").removeClass("bag-active");
        }
    });
});

function addToBag(giftProductId, count, parent, currentProductColorCode){
    var colorAttributeId = 92;
    var sizeAttributeId = 138;

    var ar = Array();
    for(var i=1;i<=count;i++){
        var size = parent.find(".size-" + i + ".active-size").attr("rel");
        var size_data = sizeAttributeId + "-" + size;
        var color_data = colorAttributeId + "-" + parent.find(".product-color-" + i).attr("rel");
        var product_id = parent.find(".product_" + i + "_details").attr("rel");

        isBraCupSelected = parent.find(".bra-cup-" + i).find(".bra_cup_toggle").find(".selected").hasClass("yes");
        if(isBraCupSelected){
            var optId = jQuery(".bra-cup-" + i).find('.selected').attr("optionid");
            var optTypeId = jQuery(".bra-cup-" + i).find('.selected').attr("optiontypeid");
            var bra_data = optId + "-" + optTypeId;

            ar.push(product_id + ":" + color_data + ":" + size_data + ":" + bra_data);
        }
        else
            ar.push(product_id + ":" + color_data + ":" + size_data);
    }

    var bundle_data = ar.join();

    var productUrl = homeUrl + 'mycheckout/mycart/addmobile?product=' + giftProductId;
    productUrl += '&qty=' + _productorderqty;
    productUrl += '&super_attribute[' + colorAttributeId + ']=' + currentProductColorCode;

    productUrl += '&type=gift';
    productUrl += '&bundle=' + bundle_data;

    productUrl += '&showhtml=0';

    parent.find(".add_to_shopping_bag").html("Adding...");

    jm.ajax({
        type: 'POST',
        url: productUrl,
        data: {},
        success: function (result) {

            result = eval('(' + result + ')');

            if (result.status == 'success') {
                jm(".sizes").find(".size").removeClass("active-size");
                jm(".add_to_shopping_bag").removeClass("bag-active");
                parent.find(".add_to_shopping_bag").html("ADD TO BAG");
                jm(".shoping-cart .cartgo").html(result.count);
                jm(".add_to_bag").removeClass("bag-active");
                jm(".details").find(".choose_next").show();

                jQuery(".shoping-cart svg path").css("fill","#fff");
                jQuery(".shoping-cart svg rect").css("fill","#fff");

                jQuery(".product_add_conf_popup").fadeIn();

                jQuery(".product_add_conf_popup").find(".qty").html(result.count);
            }
            else if(result.status == "exists"){
                //alert("This gift set already exists in the cart");
                jm(".sizes").find(".size").removeClass("active-size");
                jm(".add_to_shopping_bag").removeClass("bag-active");
                parent.find(".add_to_shopping_bag").html("ADD TO BAG");
                jm(".add_to_bag").removeClass("bag-active");
                jm(".details").find(".choose_next").show();
                jm(".gift_duplicate_popup").show();
            }
            else if(result.status == "ingiftset"){
                jm(".sizes").find(".size").removeClass("active-size");
                jm(".add_to_bag").removeClass("bag-active");
                jm(".add_to_bag").html('ADD TO BAG');

                parent.find(".add_to_bag").html("ADD TO BAG");
                //showShoppingBagHtmlOpen();
                jQuery(".gift-set-sorry-popup").show();
                jQuery(".gift-set-sorry-popup").find(".message").html("This product is already in your gift set, please place a separate order.");
            }
            else{
                jm(".sizes").find(".size").removeClass("active-size");
                jm(".add_to_shopping_bag").removeClass("bag-active");
                parent.find(".add_to_shopping_bag").html("ADD TO BAG");
                jm(".add_to_bag").removeClass("bag-active");
                jm(".details").find(".choose_next").show();
                jQuery(".gift-set-sorry-popup").find(".message").html("This product is out of stock.");
            }
        }
    });
}
