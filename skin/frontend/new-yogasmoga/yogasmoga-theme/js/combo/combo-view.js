var allSizes = [];
var allColors = [];
var bundleImages = [];
var allComboProducts = [];
var setProductCount = 0;

jQuery(document).ready(function () {

    resizeSlider();

    jQuery(window).resize(function () {
        resizeSlider();
    });

    jQuery(".gift_set").click(function(){
        var product_id = jQuery(this).attr("rel");

        changeProduct(product_id);
    });
});

function resizeSlider(){
    var SliderWidth = jQuery(".slider").width();
    var SliderHeight = SliderWidth * 0.5;

    jQuery(".slider").height(SliderHeight)
}

function changeProduct(product_id){

    var color_code = 216;    // by default all gift set has color "Andaman Green"

    jQuery(".gift_set").removeClass('active');
    jQuery(".gift_set[rel='" + product_id + "']").addClass('active');
    jQuery("#bread-set-name").html(allComboProducts[product_id]["name"]);
    jQuery(".product_name").html(allComboProducts[product_id]["name"]);
    jQuery(".set_description").html(allComboProducts[product_id]["description"]);
    jQuery(".product_price").html(allComboProducts[product_id]["price"] + "<span>" + allComboProducts[product_id]["quantity"] + " SETS REMAINING</span>");

    var ids = allComboProducts[product_id]["bundle_ids"];

    var url = homeUrl + '/ys/utility/getcombodata?s=' + new Date().getMilliseconds();

    jQuery.ajax({
        url: url,
        type: 'GET',
        data: 'ids=' + ids,
        dataType: 'json',
        success: function(result){

            if(result.message!=undefined && result.message.indexOf("found")>-1) {

                if(result.data!=undefined) {

                    jQuery(".purchase_box").html("");
                    jQuery(".set_individual_products").html("");

                    var data = result.data;
                    var strSets = "";

                    strSets += "<p class='product_name'>" + allComboProducts[product_id]["name"] + "</p>";
                    strSets += "<p class='product_price'>" + allComboProducts[product_id]["price"] + "<span>" + allComboProducts[product_id]["quantity"] + " SETS REMAINING</span>" + "</p>";

                    jQuery(".purchase_box").append(strSets);

                    setProductCount = data.length;
                    var classToApply = data.length>2 ? "individual_product three" : "individual_product two";

                    for(var i=0;i<data.length;i++){

                        addSideBundleProduct(data[i], i);

                        addIndividualBundleProduct(data[i], classToApply);

                        addBundleProductImages(data[i]);
                    }

                    strSets = "";
                    strSets += "<div class='add_to_bag' rel='" + product_id + ":" + color_code + ":" + data.length + "'>ADD TO BAG</div>";
                    strSets += "<p class='free_shipping'>Free and fast shipping to US and Canada</p>";

                    jQuery(".purchase_box").append(strSets);

                    bindSizes();
                    bindBag();
                    bindSlider();
                }
            }
        }
    });
}

function addSideBundleProduct(data, i){

    var strSets = "";

    var sizes = data.sizes;
    var arSizes = sizes.split(",");

    strSets += "<div class='set_item'>";
    strSets += "<div class='product_image'><img src='" + data.default_image + "'/></div>";
    strSets += "<div class='product_detail product_detail-" + i + "' rel='" + data.id + "'>";
    strSets += "<p class='pname'><a href='" + data.url + "' target='_blank'>" + data.name + "</a></p>";
    strSets += "<p class='pcolor pcolor-" + i + "' rel='" + data.color_code + "'>" + allColors[data.color_code] + "</p>";
    strSets += "<p class='psize'>SIZE <span class='size-chart-bundle'>SIZE CHART</span></p>";
    strSets += "<div class='sizes'>";

    for(var j=0; j<arSizes.length; j++) {
        var size = arSizes[j];
        strSets += "<span class='size size-" + i + "' rel='" + allSizes[size] + "'>" + size + "</span>";
    }

    strSets += "</div>";    // sizes
    strSets += "</div>";    // product_detail
    strSets += "</div>";    // set_item

    jQuery(".purchase_box").append(strSets);
}

function addIndividualBundleProduct(data, classToApply){

    var strSets = "";

    var sizes = data.sizes;
    var arSizes = sizes.split(",");

    strSets += "<div class='" + classToApply + "'>";
    strSets += "<div class='product'>";
    strSets += "<div class='product_img' rel='" + data.id + "'><img src='" + data.default_image + "'/></div>";
    strSets += "<p class='pname'><a href='" + data.url + "' target='_blank'>" + data.name + "</a></p>";
    strSets += "<p class='pcolor'>" + allColors[data.color_code] + "</p>";
    strSets += "<p class='pprice'>" + data.price + "</p>";
    strSets += "<a href='" + data.url + "' target='_blank'>Buy individually</a>";
    strSets += "</div>";    // product
    strSets += "</div>";    // individual_item

    jQuery(".set_individual_products").append(strSets);
}


function addBundleProductImages(data){
    bundleImages = [];

    if(data.images!=undefined && data.images.length>0) {

        bundleImages[data.id] = [];

        for(var i=0; i<data.images.length; i++)
            bundleImages[data.id].push(data.images[i]);

        console.log(bundleImages);
    }
}

function bindBag(){

    jQuery(".add_to_bag").click(function(){

        if(jQuery(this).hasClass("bag-active")) {

            var giftIdCount = jQuery(this).attr('rel');

            var arGiftIdCount = giftIdCount.split(':');

            var giftId = arGiftIdCount[0];
            var currentProductColorCode = arGiftIdCount[1];
            var count = arGiftIdCount[2];

            addToBag(giftId, count, jQuery(this).closest(".purchase_box"), currentProductColorCode);
        }
    });
}

function bindSizes(){

    jQuery(".size").click(function(){

        jQuery(this).closest(".sizes").find(".size").removeClass("active-size");

        if(jQuery(this).hasClass("active-size"))
            jQuery(this).removeClass("active-size");
        else
            jQuery(this).addClass("active-size");

        if(jQuery(this).closest(".purchase_box").find(".active-size").length==setProductCount) {
            jQuery(this).closest(".purchase_box").find(".add_to_bag").addClass("bag-active");
            jQuery(this).closest(".purchase_box").find(".add_to_bag").html('');
        }
        else {
            jQuery(this).closest(".purchase_box").find(".add_to_bag").removeClass("bag-active");
            jQuery(this).closest(".purchase_box").find(".add_to_bag").html('ADD TO BAG');
        }
    });
}

function bindSlider(){
    jQuery(".individual_product .product_img").click(function(){
        var product_id = jQuery(this).attr('rel');
        startSlider(product_id);
    });
}

function startSlider(product_id){

    var images = bundleImages[product_id];

    if(images!=undefined){

        var str = "";

        for(var i=0;i<images.length;i++){
            str += "<li><img src='" + images[i] + "'/></li>";
        }
        console.log("product id = " + product_id);
console.log(allComboProducts);
        jQuery(".current_slider_product").html(allComboProducts[product_id]["name"]);
        jQuery(".flexslider ul.slides").html(str);
        jQuery('.flexslider').removeData("flexslider");
        jQuery("div.flexslider").flexslider();

    }
}

function addToBag(giftProductId, count, parent, currentProductColorCode){
    var colorAttributeId = 92;
    var sizeAttributeId = 138;

    var ar = Array();
    for(var i=0;i<count;i++){
        var size = parent.find(".size-" + i + ".active-size").attr("rel");
        var size_data = sizeAttributeId + "-" + size;
        var color_data = colorAttributeId + "-" + parent.find(".pcolor-" + i).attr("rel");
        var product_id = parent.find(".product_detail-" + i).attr("rel");
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