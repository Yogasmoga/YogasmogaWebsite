var allSizes = [];
var allColors = [];
var bundleImages = [];
var allComboProducts = [];
var setProducts = {};
var setProductCount = 0;

jQuery(document).ready(function () {

    initializeBanner();

    resizeSlider();

    jQuery(window).resize(function () {
        resizeSlider();
    });

    jQuery(".gift_set").click(function(){
        var product_id = jQuery(this).attr("rel");

        changeProduct(product_id);
    });

    jQuery(".gift a").click(function(e){
		e.preventDefault();
		
        var personType = jQuery(this).text().toLowerCase();

        jQuery(".gift_set_link").hide();
        jQuery(".person_" + personType).show();

        var product_id = jQuery(".person_" + personType + ":eq(0)").attr("rel");
        changeProduct(product_id);
    });

});

function initializeBanner(){
    var str = "<p>YOGASMOGA 2015 Holiday Giftsets: Available Until 12.30.2015</p>";

    jQuery(".golden-banner").html(str);

    jQuery(".namaskar-overlay1").css("top","94px");
    jQuery(".ui-widget-overlay").css({"top":"94px","position":"fixed"});
    jQuery(".ui-widget-overlay").css({top:94});
    jQuery(".header-container").css("padding-top", "25px");
    jQuery(".header-container").css("top", "0");
    jQuery("#bodycompensator").css("height", "94px");
}

function resizeSlider(){
    var SliderWidth = jQuery(".slider").width();
    var SliderHeight = SliderWidth * 0.5;

    jQuery(".slider").height(SliderHeight)
}

function changeProduct(product_id){

    var color_code = 216;    // by default all gift set has color "Andaman Green"

    jQuery(".gift_set").removeClass('active');
    jQuery(".gift_set[rel='" + product_id + "']").addClass('active');

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

                    jQuery("#bread-set-name").html(allComboProducts[product_id]["name"]);
                    jQuery(".product_name").html(allComboProducts[product_id]["name"] + " SET");
                    jQuery(".product_price").html(allComboProducts[product_id]["price"] + "<span>" + allComboProducts[product_id]["quantity"] + " REMAINING</span>");
                    jQuery(".set_description").html(allComboProducts[product_id]["description"]);

                    var data = result.data;
                    var strSets = "";
                    bundleImages = {};

                    strSets += "<p class='product_name'>" + allComboProducts[product_id]["name"] + " SET</p>";
                    strSets += "<p class='product_price'>" + allComboProducts[product_id]["price"] + "<span>" + allComboProducts[product_id]["quantity"] + " REMAINING</span>" + "</p>";

                    jQuery(".purchase_box").append(strSets);

                    setProductCount = data.length;
                    var classToApply = data.length>2 ? "individual_product three" : "individual_product two";

                    for(var i=0;i<data.length;i++){

                        addSideBundleProduct(data[i], i);

                        addIndividualBundleProduct(data[i], classToApply);

                        //addBundleProductImages(data[i]);

                        setProducts[data[i].id] = {};
                        setProducts[data[i].id]["name"] = data[i].name;
                        setProducts[data[i].id]["big_image"] = data[i].big_image;

                        var sizeChart = "<div class='size-chart size-chart-" + i + "'>" + data[i].size_chart + "</div>";

                        jQuery(".size-charts").append(sizeChart);
                    }

                    strSets = "";
                    strSets += "<div class='add_to_bag' rel='" + product_id + ":" + color_code + ":" + data.length + "'>ADD TO BAG</div>";
                    strSets += "<p id='loader'> <img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/zoom_assets/preloader.gif' /></p>";
                    strSets += "<p class='free_shipping'>Free and fast shipping to US and Canada</p>";

                    jQuery(".purchase_box").append(strSets);

                    // show first product size chart
                    jQuery(".size-chart").hide();
                    jQuery(".size-chart[rel='0']").show();
                    jQuery(".size-chart-bundle").click(function(){
                        var index = jQuery(this).attr("rel");

                        jQuery(".size-chart").hide();
                        jQuery(".size-chart-" + index).show();

                        $(window).scrollTop($('.size-charts').offset().top);
                    });

                    bindSizes();
                    bindBag();
                    bindSlider();


                    jQuery(".individual_product .product>p").click(function(){
                        window.location = jQuery(this).closest(".product").find("a").attr("href");
                    });

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
    //strSets += "<div class='product_image'><img src='" + data.default_image + "'/></div>";
    strSets += "<div class='product_detail product_detail-" + i + "' rel='" + data.id + "'>";
    strSets += "<p class='pname'>" + data.name + "</p>";
    strSets += "<p class='pcolor pcolor-" + i + "' rel='" + data.color_code + "'>" + allColors[data.color_code] + "</p>";
    strSets += "<p class='psize'>SIZE: <span class='size-chart-bundle' rel='" + i + "'>SIZE CHART</span></p>";
    strSets += "<div class='sizes'>";

    Object.keys(allSizes).forEach(function (key) {
        for (var j = 0; j < arSizes.length; j++) {
            var size = arSizes[j];

            if(key==size) {
                strSets += "<span class='size size-" + i + "' rel='" + allSizes[size] + "'>" + size + "</span>";
                break;
            }
        }
    });

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
    strSets += "<p class='pname'>" + data.name + "</p>";
    strSets += "<p class='pcolor'>" + allColors[data.color_code] + "</p>";
    strSets += "<p class='pprice'>" + data.price + "</p>";
    strSets += "<a href='" + data.url + "' target='_blank'>Sold individually</a>";
    strSets += "</div>";    // product
    strSets += "</div>";    // individual_item

    jQuery(".set_individual_products").append(strSets);
}

/*
function addBundleProductImages(data){

    if(data.images!=undefined && data.images.length>0) {

        bundleImages[data.id] = [];

        for(var i=0; i<data.images.length; i++)
            bundleImages[data.id].push(data.images[i]);
    }
}
*/

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
//            jQuery(this).closest(".purchase_box").find(".add_to_bag").html('');
        }
        else {
            jQuery(this).closest(".purchase_box").find(".add_to_bag").removeClass("bag-active");
//            jQuery(this).closest(".purchase_box").find(".add_to_bag").html('ADD TO BAG');
        }
    });
}

function bindSlider(){
    jQuery(".individual_product").find(".product_img").click(function(){
        var product_id = jQuery(this).attr('rel');
        //startSlider(product_id);
        jQuery(".current_slider_product").html(setProducts[product_id]["name"]);
        jQuery(".current_slider_image").html("<img src='" + setProducts[product_id]["big_image"] + "'/>");
    });
}
/*
function startSlider(product_id){

    var images = bundleImages[product_id];

    if(images!=undefined){

        var str = "";

        for(var i=0;i<images.length;i++)
            str += "<li><img src='" + images[i] + "'/></li>";

        jQuery(".current_slider_product").html(setProducts[product_id]["name"]);
        jQuery(".flexslider ul.slides").html(str);
        jQuery('.flexslider').removeData("flexslider");
        jQuery("div.flexslider").flexslider();
    }
}
*/
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
    jQuery("#loader").show();

    jQuery.ajax({
        type: 'POST',
        url: productUrl,
        data: {},
        success: function (result) {
            jQuery(".sizes").find(".size").removeClass("active-size");
            jQuery(".add_to_bag").removeClass("bag-active");

            jQuery("#loader").hide();
            jQuery("div#myminicart").html(result.html);
            showShoppingBagHtmlOpen();
        }
    });
}