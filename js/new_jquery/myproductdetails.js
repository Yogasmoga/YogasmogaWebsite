_preorderinfohovered = false;
var _rewardpoints = 0;
var currentColorObject;     // to store what color is clicked

var arPartOfGiftSets = [];

var fabrics = Array();
var bra_cup_insert_value_array = Array();
var bra_cup_insert_color_array = Array();
var bra_cup_insert_count = 0;

jQuery(window).load(function ($) {
    selectfirstsizeonload();
   //insertBraOption();
});
jQuery(document).ready(function ($) {
	 insertBraOption();
	 
});

//Upsell product ..........
function getUpsellProduct(id,colorCode){

    jQuery.ajax({
        type: 'POST',
        url: homeUrl+"ys/upsellproduct/index",
        data: {'id':_productid,'code':colorCode},
        dataType: 'json',
        success: function (result) {
            if(result.message=='found'){
                var upsellHtml;
                upsellHtml = "<h2 class='pg-strong'>Also Wearing:</h2><ul>";
                var i;
                for(i=0;i < result.data.length; i++){
                    upsellHtml = upsellHtml + "<li><a href='" + result.data[i]['path'] + "'>" + result.data[i]['name'] + "</a><span> in "+result.data[i]['color']+"</span></li>";
                }
                upsellHtml = upsellHtml + "</ul>";

                //   jQuery("div#upsell-products").html(upsellHtml);
            }
            else{
                //   jQuery("div#upsell-products").html("");
            }

        },
        error:function(result){

        }
    });
}
//Upsell product End..........

/*---for new design--*/
function prodnewdetail(){
	var jQ = jQuery.noConflict();	
	var windW = jQ('#productdetails').width();	
	var imgrowh = jQ('.thumb-imgs table.smallimagecontiner tr td img').height();	
	jQ('.prod-col .pcol-right-content').height(imgrowh);
		
	
	
	if(jQ('.thumb-imgs table.smallimagecontiner tr td:nth-child(5)').length){
		jQ('.thumb-imgs table.smallimagecontiner tr td:nth-child(4),.thumb-imgs table.smallimagecontiner tr td:nth-child(5)').addClass('two-col');
		var imgrow4W = jQ('.thumb-imgs table.smallimagecontiner tr td:nth-child(4),.thumb-imgs table.smallimagecontiner tr td:nth-child(5)').css({			
			'width': windW/2 - 5
		});
		var pcolRightContent4W = jQ('.pcol-right-content4').css({
			
			'width': windW/2 - 5
		});
	}
	
	
	var imgrow4w = jQ('.thumb-imgs table.smallimagecontiner tr td:nth-child(4)').width();	
	var imgrow4h = jQ('.thumb-imgs table.smallimagecontiner tr td:nth-child(4)').height();	
	
	
	jQ('.prod-col .img_madeinusa').css({
		'top':imgrowh,
		'opacity':1
	});
	jQ('.prod-col .img_rnd').css({
		'left':imgrow4w,
		'bottom':imgrow4h
	});
	
	
}
		
	
	

function prodnewdetailresize(){	
	var windW = jQuery('#productdetails').width();	
	var imgrowh = jQuery('.thumb-imgs table.smallimagecontiner tr td img').height();		
	
	jQuery('.prod-col .pcol-right-content').height(imgrowh);
	if(jQuery('.thumb-imgs table.smallimagecontiner tr td:nth-child(5)').length){
		jQuery('.thumb-imgs table.smallimagecontiner tr td:nth-child(4),.thumb-imgs table.smallimagecontiner tr td:nth-child(5)').addClass('two-col');
		var imgrow4W = jQuery('.thumb-imgs table.smallimagecontiner tr td:nth-child(4),.thumb-imgs table.smallimagecontiner tr td:nth-child(5)').css({			
			'width': windW/2 - 5
		});
		var pcolRightContent4W = jQuery('.pcol-right-content4').css({			
			'width': windW/2 - 5
		});
	}
	
	
	
	var imgrow4w = jQuery('.thumb-imgs table.smallimagecontiner tr td:nth-child(4)').width(); 	
	var imgrow4h = jQuery('.thumb-imgs table.smallimagecontiner tr td:nth-child(4)').height(); 	
	
	jQuery('.prod-col .img_madeinusa').css({
		'top':imgrowh,
		'opacity':1
	});
	jQuery('.prod-col .img_rnd').css({
		'left':imgrow4w,
		'bottom':imgrow4h
	});
	
	
	
}

jQuery(document).ready(function ($) {

    if (_sizesuperattribute == false)
        jQuery(".qty").empty().html("Step 2");
    $(document).keydown(function (e) {
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        if (key == 37) {  ///left key
            if ($(".selected").prev('div').length) {
                $(".selected").removeClass('selected').prev('div').addClass('selected');
                changeColor($(".selected > table").attr("color"));
            }
        }
        else if (key == 39) {  ///right key
            if ($(".selected").next('div').length) {
                $(".selected").removeClass('selected').next('div').addClass('selected');
                changeColor($(".selected > table").attr("color"));
            }
        }
    });
    $("table.normalproductdetail div#colorcontainer table").live("click", function () {
		
		$('.product-row-container').addClass("row-container-loading"); //for new design
        currentColorObject = $(this);
        $('.errormsg').empty().hide();
        jQuery("#orderitem").removeClass('bagdisabled');
        jQuery("#orderitem").addClass('spbutton');
        changeColor($(this).attr("color"));
        selectfirstsizeonload();

        /*------------Change Upsell product Edited By Fahim (code start)------------*/
        getUpsellProduct(_productid,$(this).attr("value"));
        /*------------Change Upsell product Edited By Fahim (code end)------------*/


        changePartOfGiftSet($(this).attr("value"));
		/*---new design js--*/
		var mpx = 0;
		$('.product-details .product-row').removeClass('interval-ends');
		var intervalID = setInterval(function () {
			// logic here
			prodnewdetail();
			if (++mpx === 3) {
				window.clearInterval(intervalID);			
				//$('.product-row-container img').load(function(){	
					$('.product-row-container').removeClass("row-container-loading"); //for new design					
				//});		
			}
		}, 1000);
		/*---new design js end--*/		
		
		
		
    });

    $("table.smallimagecontiner td:not(.selectedimage)").live("click", function () {
        $("table.smallimagecontiner td").removeClass("selectedimage");
		$("table.tdbigimagecontainer .bigimage-loader").remove();
        $(this).addClass("selectedimage");
			$("table.tdbigimagecontainer td").append('<span class="bigimage-loader"></span>');
			$("table.tdbigimagecontainer .bigimage-loader").show('fast');
        $("table.tdbigimagecontainer img").hide();
        $("table.tdbigimagecontainer img").attr("src", $(this).attr("bigimageurl"));
        $("table.tdbigimagecontainer img").attr("alt", $(this).find("img:first").attr('alt'));
        $("table.tdbigimagecontainer img").attr("title", $(this).find("img:first").attr('title'));
        _curshareimgurl = $(this).attr("bigimageurl");
        $("table.tdbigimagecontainer img").fadeIn('fast',function(){
				$(this).load(function(){
						$("table.tdbigimagecontainer .bigimage-loader").fadeOut('slow');
				});
				
		});
		
			
    });

    $("td#tdpopupproductsmallimages td:not(.selectedimage)").live("click", function () {
        $("td#tdpopupproductsmallimages td").removeClass("selectedimage");
        $(this).addClass("selectedimage");
        $("td#tdpopupproductbigimage img").hide();
        $("td#tdpopupproductbigimage img").attr("src", $(this).attr("bigimageurl"));
        $("td#tdpopupproductbigimage img").attr("alt", $(this).find("img:first").attr('alt'));
        $("td#tdpopupproductbigimage img").attr("title", $(this).find("img:first").attr('title'));
        $("td#tdpopupproductbigimage img").fadeIn('fast');
    });

    $("#orderitem, #preorderitem").live("click", function () {
        if (_addingtocart)
            return;
        addtocart();
    });

    $("div#sizecontainer td:not(.disabled) div:not(.dvselectedsize)").live("click", function () {
        $('.errormsg').empty().hide();
        jQuery("#orderitem").removeClass('bagdisabled');
        jQuery("#orderitem").addClass('spbutton');
        changeproductsize($(this));
		
    });

    $(".selectedlength div:visible").live("click", function () {
        $('.errormsg').empty().hide();
        jQuery("#orderitem").removeClass('bagdisabled');
        jQuery("#orderitem").addClass('spbutton');
        changelengthtype($(this));
        $(this).addClass("selected");
        $(this).siblings().removeClass("selected");
		
		// to show selected length name using attribute
		var lengthVal = $(this).attr('lengthtype');		
		$('.length-name').html(lengthVal+' Length')
    });

    InitializeProductQty();
    $("div.sizeselector select.qtyselector").live("change", function () {
        $('.errormsg').empty().hide();
        jQuery("#orderitem").removeClass('bagdisabled');
        jQuery("#orderitem").addClass('spbutton');
        changeOrderqty($(this).val());
    });

    if (_defaultprcolor != '') {
        changePartOfGiftSet(_defaultprcolor);
        if ($("div#colorcontainer table[value='" + _defaultprcolor + "']").length > 0)
            changeColor($("div#colorcontainer table[value='" + _defaultprcolor + "']").attr("color"));
        else {
            if ($("div#colorcontainer table:first").length > 0)
                changeColor($("div#colorcontainer table:first").attr("color"));
        }
        //_defaultprcolor = '';
    }
    else {
        if ($("div#colorcontainer table:first").length > 0) {
            changeColor($("div#colorcontainer table:first").attr("color"));
            changePartOfGiftSet(changeColor($("div#colorcontainer table:first").attr("value")));
        }
    }


    $("table.productdetailtable td.howdoesitfitlink a").live("click", function () {
        $("div#howdoesitfitbox").fadeIn('normal');
    });

    $("div#howdoesitfitbox").live('mouseover', function () {
        _howdoesitfithovered = true;
    });
    $("div#howdoesitfitbox").live('mouseout', function () {
        _howdoesitfithovered = false;
    });
    $("div#preorderinfo").live('mouseover', function () {
        _preorderinfohovered = true;
    });
    $("div#preorderinfo").live('mouseout', function () {
        _preorderinfohovered = false;
    });
    $("div#sizechart").live('mouseover', function () {
        _sizecharthovered = true;
    });
    $("div#sizechart").live('mouseout', function () {
        _sizecharthovered = false;
    });
    $("body").click(function () {
        if (!_howdoesitfithovered)
            $("div#howdoesitfitbox").fadeOut('normal');
        if (!_sizecharthovered)
            $("div#sizechart").fadeOut('normal');
        if (!_preorderinfohovered)
            $("div#preorderinfo").fadeOut('normal');
    });

    $("img#closesmlight").live('click', function () {
        $(this).parent().fadeOut('normal');
    });

    $("table.productdetailtable td.sizechartlink a").live('click', function () {
        if (_productdisplaymode == 'popup') {
            var ppdialog = $("div.yogidialog.ui-dialog:first");
        }
        else {
        }
        $("td.sizechartlink div#sizechart").fadeIn('normal');
    });

    $("#preorderhelp").live('click', function () {
        //if(_productdisplaymode == 'page')
//        {
//            var tp = $("#preorderitem").position().top - $("div#preorderinfo").height() - 10;
//            if(tp <80)
//                tp = 80;
//            $("div#preorderinfo").css('top', tp + 'px');
//        }
        $("div#preorderinfo").fadeIn('normal');
        _preorderinfohovered = true;
        setTimeout(function () {
            _preorderinfohovered = false;
        }, 10);
    });

    $("div#preorderinfo img.closeinfo").live('click', function () {
        $("div#preorderinfo").fadeOut('normal');
    });
    //$("div#preorderitem img").hover(function(){
//        //$("div#preorderinfo").show();
//        $("div#preorderinfo").fadeIn('fast');
//    },
//    function(){
//        //$("div#preorderinfo").hide();
//        $("div#preorderinfo").fadeOut('fast');
//    });
});

function InitializeProductQty() {
    _productorderqty = jQuery("div.sizeselector select.qtyselector").val();
    _productorderqty = 1;


}

function changelengthtype(sz) {

    jQuery("div.selectedlength div").removeClass("selected");
    sz.addClass("selected");


    if (sz.hasClass("outofstock")) {
        jQuery("#orderitem").hide();
        jQuery("#preorderitem").hide();
        jQuery("#preorderhelp").hide();
        jQuery("#outofstockitem").show();
//        return;
    }
    else {
        jQuery("#outofstockitem").hide();
        var qty = sz.attr("qty") * 1;
        var orderqty = _productorderqty;
        if ((qty - orderqty) >= 0) {
            jQuery("#orderitem").show();
            jQuery("#preorderitem").hide();
            jQuery("#preorderhelp").hide();
            jQuery("#outofstockitem").hide();
        }
        else {
            if (sz.hasClass("canbackorder")) {
				jQuery("#orderitem").hide();
                jQuery("#preorderitem").show();
                jQuery("#preorderhelp").show();
                jQuery("#outofstockitem").hide();
            }
            else {
                jQuery("#orderitem").hide();
                jQuery("#preorderitem").hide();
                jQuery("#preorderhelp").hide();
                jQuery("#outofstockitem").show();
//                return;
            }
        }

    }


    var price = sz.attr("price");
    jQuery("div.productcost").html("$" + price);
    //var rewardpoints = Math.floor((price * 1) * _rewardpointsearned);
//    jQuery("div.smogibuckcount td").html(rewardpoints);
    _rewardpoints = sz.attr("rewardpoints") * 1;
    if ((jQuery("select.qtyselector").val() * 1) > 0)
        jQuery("div.smogibuckcount td").html(_rewardpoints * (jQuery("select.qtyselector").val() * 1));
    else
        jQuery("div.smogibuckcount td").html(_rewardpoints);

    jQuery("#orderitem").removeClass("bagdisabled");
    jQuery("#orderitem").addClass("spbutton");
}

function changeFabric(current_color) {

    if (jQuery(".fabric_story_block") != null) {

//        var current_color = jQuery(".selectedcolortext").html().toLowerCase();

        var found = false;
        jQuery(".fabric_story_block").hide();
        jQuery(".fabric_story_block").each(function () {

            var fabric_color = jQuery(this).attr('rel').toLowerCase();

            if (current_color.toLowerCase() == fabric_color) {
                jQuery(this).show();
                jQuery(".mainfabric").hide();
                found = true;
                return;
            }
        });

        if (!found) {
            jQuery(".fabric_story_block").hide();
            jQuery(".mainfabric").show();
        }
    }
}

//changed by fahim khan for product color description start here.
function changeDescription(current_color) {

    if (jQuery(".product_description_block") != null) {

//        var current_color = jQuery(".selectedcolortext").html().toLowerCase();

        var found = false;
        jQuery(".product_description_block").each(function () {

            var fabric_color = jQuery(this).attr('rel').toLowerCase();

            if (current_color.toLowerCase() == fabric_color) {
                jQuery(".product_description_block").hide();
                jQuery(this).show();
                jQuery(".main-description").hide();
                found = true;
                return;
            }
        });

        if (!found) {
            jQuery(".product_description_block").hide();
            jQuery(".main-description").show();
        }
    }
}
//changed by fahim khan for product color description end here.

function changeBraCupInsert(current_color) {

    var hide = false;

    for (var i = 0; i < bra_cup_insert_color_array.length; i++) {
        var color = bra_cup_insert_color_array[i];
        var value = bra_cup_insert_value_array[i];
        if (color.toLowerCase() == current_color.toLowerCase()) {
            if (value.toLowerCase() == "yes") {
                jQuery("#includeoption").hide();
                hide = true;
                break;
            }
        }
    }

    if (!hide && bra_cup_insert_count > 0)
        jQuery("#includeoption").show();
}

function changeproductsize(sz) {
    //update price
    var salePrice = sz.attr("price");
    jQuery(".amount").html("$" + salePrice);
    //update price ends
    jQuery("body").find("#includeoption div:nth-child(1)").trigger("click");
    if (_islengthavailable) {
        jQuery("div.selectedlength div").removeClass("selected");
        jQuery("div#sizecontainer div").removeClass("dvselectedsize");
        sz.addClass("dvselectedsize");
        var colorName = jQuery("#colorcontainer div.selected table").attr("color");
        var colorindex = searchproductcolorinfoarrray(colorName);
        var sizeVal = sz.attr("size");
        jQuery(".selectedlength div").hide();
        for (i = 0; i < _productcolorinfo[colorindex].lengths[sizeVal].length; i++) {
            var lengthtemp = _productcolorinfo[colorindex].lengths[sizeVal][i].split("|");
            var lengthType = lengthtemp[0];
            var qty = lengthtemp[1];
            var price = lengthtemp[2];
            var rewardpoints = lengthtemp[3];
            var instock = lengthtemp[4];
			var show_pre = lengthtemp[6]; //fahim
			var show_pre_msg = lengthtemp[7]; //fahim
            var canbackorder = false;
            jQuery(".selectedlength div[lengthtype='" + lengthType + "']").attr("qty", qty);
            jQuery(".selectedlength div[lengthtype='" + lengthType + "']").attr("price", price);
            jQuery(".selectedlength div[lengthtype='" + lengthType + "']").attr("rewardpoints", rewardpoints);
			jQuery(".selectedlength div[lengthtype='" + lengthType + "']").attr("showpre", show_pre); //fahim
			jQuery(".selectedlength div[lengthtype='" + lengthType + "']").attr("showpremsg", show_pre_msg); //fahim
			jQuery(".selectedlength div[lengthtype='" + lengthType + "']").show();
			
			// fahim	
			
			if(show_pre == 'Yes'){
				jQuery(".selectedlength div[lengthtype='" + lengthType + "']").addClass('showing-pre');
			}
			else{
				jQuery(".selectedlength div[lengthtype='" + lengthType + "']").removeClass('showing-pre');
			}
			
			
			
			
            if ((lengthtemp[5] * 1) > 0)
                canbackorder = true;
			

            if (instock == 0)
                jQuery(".selectedlength div[lengthtype='" + lengthType + "']").addClass('outofstock');
            else
                jQuery(".selectedlength div[lengthtype='" + lengthType + "']").removeClass('outofstock');

            if (canbackorder)
                jQuery(".selectedlength div[lengthtype='" + lengthType + "']").addClass('canbackorder');
            else
                jQuery(".selectedlength div[lengthtype='" + lengthType + "']").removeClass('canbackorder');

        }
		
        // check for insale
        var amount = jQuery(".amount");
        var firstSize = jQuery("div.selectedlength div").first().next();
        var firstSizePrice = firstSize.attr("price");
        if (_productcolorinfo[colorindex].insale == 'Yes') {
            firstSize.trigger("click");
            amount.html("$" + firstSizePrice);
            amount.addClass("insale-price");
            jQuery(".box-seprtr").find("p.insale").removeClass("dnone");
            jQuery(".was-amount").removeClass("no-display");

        } else {
            amount.html("$" + firstSizePrice);
        }
        //end insale
		//make regular size default selected
		jQuery("body").find("div.selectedlength div:nth-child(1)").trigger("click");
		//make regular size default selected
    } 
else {
        jQuery("div#sizecontainer div").removeClass("dvselectedsize");
        sz.addClass("dvselectedsize");
		
		var premsghtml='';
		

        if (sz.hasClass("outofstock")) {
            jQuery("#orderitem").hide();
            jQuery("#preorderitem").hide();
            jQuery("#preorderhelp").hide();
            jQuery("#outofstockitem").show();
//        return;
        }
        else {
			
			
            jQuery("#outofstockitem").hide();
			
            var qty = sz.attr("qty") * 1;
            var orderqty = _productorderqty;
            if ((qty - orderqty) >= 0) {
				//fahim
				if (sz.hasClass("showing-pre")) {
					
					var preordermsg =  sz.attr("showpremsg");
					premsghtml = premsghtml + preordermsg;
					jQuery(".pre-order-msg").html(preordermsg);
					jQuery(".pre-order-msg").show();
                    alert(preordermsg);
					jQuery("#orderitem").hide();
                    jQuery("#preorderitem").show();
                    jQuery("#preorderhelp").show();
                    jQuery("#outofstockitem").hide();
                }
				else{
				jQuery(".pre-order-msg").hide();
				jQuery("#orderitem").show();
                jQuery("#preorderitem").hide();
                jQuery("#preorderhelp").hide();
                jQuery("#outofstockitem").hide();	
				}
                
            }
            else {
				if (sz.hasClass("canbackorder")) {
					
					var preordermsg =  sz.attr("showpremsg");
					premsghtml = premsghtml + preordermsg;
					jQuery(".pre-order-msg").html(preordermsg);
					jQuery(".pre-order-msg").show();
					alert("2");
                    jQuery("#orderitem").hide();
                    jQuery("#preorderitem").show();
                    jQuery("#preorderhelp").show();
                    jQuery("#outofstockitem").hide();
                }
                else {
                    jQuery("#orderitem").hide();
                    jQuery("#preorderitem").hide();
                    jQuery("#preorderhelp").hide();
                    jQuery("#outofstockitem").show();
					jQuery(".pre-order-msg").show();//fahim
//                return;
                }
            }

        }


        var price = sz.attr("price");
        jQuery("div.productcost").html("$" + price);
        //var rewardpoints = Math.floor((price * 1) * _rewardpointsearned);
//    jQuery("div.smogibuckcount td").html(rewardpoints);
        _rewardpoints = sz.attr("rewardpoints") * 1;
        if ((jQuery("select.qtyselector").val() * 1) > 0)
            jQuery("div.smogibuckcount td").html(_rewardpoints * (jQuery("select.qtyselector").val() * 1));
        else
            jQuery("div.smogibuckcount td").html(_rewardpoints);

        jQuery("#orderitem").removeClass("bagdisabled");
        jQuery("#orderitem").addClass("spbutton");

    }

}

function changeOrderqty(qty) {
    if (_islengthavailable) {
        qty = qty * 1;
        _productorderqty = qty;

        if (jQuery("div.selectedlength div.selected").length == 0)
            return;
        if (qty > 0)
            jQuery("div.smogibuckcount td").html(_rewardpoints * qty);
        else
            jQuery("div.smogibuckcount td").html(_rewardpoints);
        //jQuery("div.smogibuckcount td").html(_rewardpoints * qty);
        var stockqty = jQuery("div.selectedlength div.selected").attr("qty") * 1;
        if (jQuery("div.selectedlength div.selected").hasClass("outofstock")) {
            jQuery("#orderitem").hide();
            jQuery("#preorderitem").hide();
            jQuery("#preorderhelp").hide();
            jQuery("#outofstockitem").show();
            //        return;
        }
        else {
            jQuery("#outofstockitem").hide();
            if ((stockqty - qty) >= 0) {
                jQuery("#orderitem").show();
                jQuery("#preorderitem").hide();
                jQuery("#preorderhelp").hide();
                jQuery("#outofstockitem").hide();
            }
            else {
                if (jQuery("div.selectedlength div.selected").hasClass('canbackorder')) {
                    jQuery("#orderitem").hide();
                    jQuery("#preorderitem").show();
                    jQuery("#preorderhelp").show();
                    jQuery("#outofstockitem").hide();
                }
                else {
                    jQuery("#orderitem").hide();
                    jQuery("#preorderitem").hide();
                    jQuery("#preorderhelp").hide();
                    jQuery("#outofstockitem").show();
                }
            }
        }
    }
    else {
        qty = qty * 1;
        _productorderqty = qty;

        if (jQuery("div#sizecontainer div.dvselectedsize").length == 0)
            return;
        if (qty > 0)
            jQuery("div.smogibuckcount td").html(_rewardpoints * qty);
        else
            jQuery("div.smogibuckcount td").html(_rewardpoints);
        //jQuery("div.smogibuckcount td").html(_rewardpoints * qty);
        var stockqty = jQuery("div#sizecontainer div.dvselectedsize").attr("qty") * 1;
        if (jQuery("div#sizecontainer div.dvselectedsize").hasClass("outofstock")) {
            jQuery("#orderitem").hide();
            jQuery("#preorderitem").hide();
            jQuery("#preorderhelp").hide();
            jQuery("#outofstockitem").show();
//        return;
        }
        else {
            jQuery("#outofstockitem").hide();
            if ((stockqty - qty) >= 0) {
                jQuery("#orderitem").show();
                jQuery("#preorderitem").hide();
                jQuery("#preorderhelp").hide();
                jQuery("#outofstockitem").hide();
            }
            else {
                if (jQuery("div#sizecontainer div.dvselectedsize").hasClass('canbackorder')) {
					alert("3");
                    jQuery("#orderitem").hide();
                    jQuery("#preorderitem").show();
                    jQuery("#preorderhelp").show();
                    jQuery("#outofstockitem").hide();
                }
                else {
                    jQuery("#orderitem").hide();
                    jQuery("#preorderitem").hide();
                    jQuery("#preorderhelp").hide();
                    jQuery("#outofstockitem").show();
                }
            }
        }
    }

}

function searchproductcolorinfoarrray(clr) {
    for (i = 0; i < _productcolorinfo.length; i++) {
        if (_productcolorinfo[i].color == clr)
            return i;
    }
    return -1;
}

function changePartOfGiftSet(clr){

    if(arPartOfGiftSets[clr]!=undefined) {
        var title = arPartOfGiftSets[clr][0];
        var url = arPartOfGiftSets[clr][1];
        var str = "<span>Part of</span> <a style='border-bottom:solid 2px #cc0033' href='" + url + "'>" + title + "</a>";
        jQuery(".part-of-gift-set").html(str).show();
    }
    else
        jQuery(".part-of-gift-set").html("").hide();
}

function changeColor(clr) {
    changeFabric(clr);
    changeDescription(clr);
    changeBraCupInsert(clr);
    getUpsellProduct(_productid,jQuery("div.selected > table").attr("value"));

    jQuery(".amount").removeClass("insale-price");
    jQuery(".box-seprtr").find("p.insale").addClass("dnone");
    jQuery(".was-amount").addClass("no-display");

    jQuery("body").find("#includeoption div:nth-child(1)").trigger("click");
    var colorindex = searchproductcolorinfoarrray(clr);
    if (colorindex == -1)
        return;

    _rewardpoints = 0;
    jQuery("div.smogibuckcount td").html(_cnfrewardpoint);
    jQuery("table.normalproductdetail table.selectedcolor td:last").html(clr);
    jQuery("table.normalproductdetail div#colorcontainer table td").removeClass("tdselectedcolor");
    jQuery("table.normalproductdetail div#colorcontainer > div").removeClass("selected");
    jQuery("table.normalproductdetail div#colorcontainer table[color='" + clr + "'] tr:nth-child(2) td").addClass("tdselectedcolor");
    jQuery("table.normalproductdetail div#colorcontainer table[color='" + clr + "']").parent("div").addClass("selected");
    jQuery("div#sizecontainer div").removeClass("dvselectedsize");
    //jQuery("div#sizecontainer div").addClass("disabled");
    jQuery("div#sizecontainer div").parent().addClass("disabled");
    for (i = 0; i < _productcolorinfo[colorindex].sizes.length; i++) {
        var sizetemp = _productcolorinfo[colorindex].sizes[i].split("|");
        var size = sizetemp[0];
        var qty = sizetemp[1];
        var price = sizetemp[2];
        var rewardpoints = sizetemp[3];
        var instock = sizetemp[4];
		var show_pre = sizetemp[6]; //fahim
		var show_pre_msg = sizetemp[7]; //fahim
		var canbackorder = false;
        
        //var size = _productcolorinfo[colorindex].sizes[i].substr(0, _productcolorinfo[colorindex].sizes[i].indexOf('|'));
//        var qty = _productcolorinfo[colorindex].sizes[i].substr(_productcolorinfo[colorindex].sizes[i].indexOf('|') + 1, _productcolorinfo[colorindex].sizes[i].indexOf('|') + 1);
//        var price = _productcolorinfo[colorindex].sizes[i].substr(_productcolorinfo[colorindex].sizes[i].indexOf('|', _productcolorinfo[colorindex].sizes[i].indexOf('|') + 1) + 1);
        jQuery("div#sizecontainer div[size='" + size + "']").parent().removeClass("disabled");
        jQuery("div#sizecontainer div[size='" + size + "']").attr("qty", qty);
        jQuery("div#sizecontainer div[size='" + size + "']").attr("price", price);
        jQuery("div#sizecontainer div[size='" + size + "']").attr("rewardpoints", rewardpoints);
		jQuery("div#sizecontainer div[size='" + size + "']").attr("showpre", show_pre); //fahim.
		jQuery("div#sizecontainer div[size='" + size + "']").attr("showpremsg", show_pre_msg); //fahim.
		
		if ((sizetemp[5] * 1) > 0)
            canbackorder = true;
        if (instock == 0) {
            jQuery("div#sizecontainer div[size='" + size + "']").addClass('outofstock');
            jQuery("div#sizecontainer div[size='" + size + "']").find('img').show();
        }
        else {
            jQuery("div#sizecontainer div[size='" + size + "']").removeClass('outofstock');
            jQuery("div#sizecontainer div[size='" + size + "']").find('img').hide();
        }
		if(show_pre == "Yes"){
			 jQuery("div#sizecontainer div[size='" + size + "']").addClass('showing-pre');
		}
		else{
			jQuery("div#sizecontainer div[size='" + size + "']").removeClass('showing-pre');
		}

        if (canbackorder)
            jQuery("div#sizecontainer div[size='" + size + "']").addClass('canbackorder');
        else
            jQuery("div#sizecontainer div[size='" + size + "']").removeClass('canbackorder');

    }
    jQuery("#orderitem").show();
    jQuery("#preorderitem").hide();
    jQuery("#preorderhelp").hide();
    jQuery("#outofstockitem").hide();
    var smallimagehtml = '';

    if (_productdisplaymode == 'popup') {
        for (i = 0; i < _productcolorinfo[colorindex].smallimages.length; i++) {
            smallimagehtml = smallimagehtml + "<tr><td bigimageurl='" + _productcolorinfo[colorindex].bigimages[i][0] + "'><img src='" + _productcolorinfo[colorindex].smallimages[i][0] + "' alt='" + _productcolorinfo[colorindex].smallimages[i][1] + "'  title='" + _productcolorinfo[colorindex].smallimages[i][2] + "'></td></tr>";
        }
        jQuery("td#tdpopupproductbigimage, td#tdpopupproductsmallimages").hide();
        jQuery("td#tdpopupproductsmallimages table tbody").html(smallimagehtml);
        if (jQuery("td#tdpopupproductsmallimages td").length > 0) {
            if (jQuery("td#tdpopupproductbigimage img").length > 0) {
                jQuery("td#tdpopupproductbigimage img").attr("src", jQuery("td#tdpopupproductsmallimages table tbody td:first").attr("bigimageurl"));
                jQuery("td#tdpopupproductbigimage img").attr("alt", jQuery("td#tdpopupproductsmallimages table tbody td:first").find('img:first').attr("alt"));
                jQuery("td#tdpopupproductbigimage img").attr("title", jQuery("td#tdpopupproductsmallimages table tbody td:first").find('img:first').attr("title"));
            }
            else
                jQuery("td#tdpopupproductbigimage").html("<img src='" + jQuery("td#tdpopupproductsmallimages table tbody td:first").attr("bigimageurl") + "' alt='" + jQuery("td#tdpopupproductsmallimages table tbody td:first").find('img:first').attr("alt") + "' title='" + jQuery("td#tdpopupproductsmallimages table tbody td:first").find('img:first').attr("title") + "'>");
            jQuery("td#tdpopupproductsmallimages table tbody td:first").addClass('selectedimage');
        }
        jQuery("td#tdpopupproductbigimage, td#tdpopupproductsmallimages").fadeIn('fast');


        var clrvalue = jQuery("table.productdetailtable div#colorcontainer table[color='" + clr + "']").attr("value");
        var href = jQuery("table.productdetailpopupbottomlinks div.viewfulldetails a").attr("href");
        if (href.indexOf('?') > 0)
            href = href.substr(0, href.indexOf('?'));
        href = href + '?from=dressingroom&color=' + clrvalue;
        jQuery("table.productdetailpopupbottomlinks div.viewfulldetails a").attr("href", href);


    }
    else {
        smallimagehtml = '<tr>';
        for (i = 0; i < _productcolorinfo[colorindex].smallimages.length; i++) {
            smallimagehtml = smallimagehtml + "<td bigimageurl='" + _productcolorinfo[colorindex].bigimages[i][0] + "' zoomimageurl='" + _productcolorinfo[colorindex].zoomimages[i][0] + "'><img src='" + _productcolorinfo[colorindex].smallimages[i][0] + "' alt='" + _productcolorinfo[colorindex].smallimages[i][1] + "' title='" + _productcolorinfo[colorindex].smallimages[i][2] + "'></td>";
        }
        smallimagehtml = smallimagehtml + "</tr>";
        jQuery("table.productimagecontainer").hide();
        jQuery("table.smallimagecontiner tbody").html(smallimagehtml);
        if (jQuery("table.smallimagecontiner td").length > 0) {
            if (jQuery("table.tdbigimagecontainer img").length > 0) {
                setTimeout(function () {
                    // setImageContheightPDP();
                    if (jQuery(".video-block").length <= 0) {
                        jQuery(".fitDetail .com-a-prd-links").hide();
                    }
                }, 500);
                jQuery("table.tdbigimagecontainer img").attr("src", jQuery("table.smallimagecontiner td:first").attr("bigimageurl"));
                jQuery("table.tdbigimagecontainer img").attr("alt", jQuery("table.smallimagecontiner td:first").find('img:first').attr("alt"));
                jQuery("table.tdbigimagecontainer img").attr("title", jQuery("table.smallimagecontiner td:first").find('img:first').attr("title"));
            }
            else {
                jQuery("table.tdbigimagecontainer td").html("<img class='shareit' src='" + jQuery("table.smallimagecontiner td:first").attr("bigimageurl") + "' alt='" + jQuery("table.smallimagecontiner td:first").find('img:first').attr("alt") + "' title='" + jQuery("table.smallimagecontiner td:first").find('img:first').attr("title") + "'>");
            }
            _curshareimgurl = jQuery("table.smallimagecontiner td:first").attr("bigimageurl");
        }
        jQuery("table.smallimagecontiner td:first").addClass("selectedimage");
        jQuery("table.productimagecontainer").fadeIn('fast');
    }
    //if(jQuery("div#sizecontainer td:not(.disabled) div:not(.dvselectedsize)").length == 1)
//    {
//        changeproductsize(jQuery("div#sizecontainer td:not(.disabled) div:not(.dvselectedsize):first"));
//    }
    if (!_sizesuperattribute)
        changeproductsize(jQuery("div#sizecontainer td:not(.disabled) div:not(.dvselectedsize):first"));
    //jQuery("#orderitem").addClass("bagdisabled");


    // check for insale
    var amount = jQuery(".amount");
    var firstSize = '', firstSizePrice = '';
    if (_islengthavailable) {
		//make regular size default selected
		jQuery("body").find("div.selectedlength div:nth-child(1)").trigger("click");
		//make regular size default selected
        // check for insale
        firstSize = jQuery("div.selectedlength div").first().next();
        firstSizePrice = firstSize.attr("price");
        //end insale
    } else {
        firstSize = jQuery("div#sizecontainer td:not(.disabled)").first().find("div");
        firstSizePrice = firstSize.attr("price");
    }

    if (_productcolorinfo[colorindex].insale == 'Yes') {
        firstSize.trigger("click");
        amount.html("$" + firstSizePrice);
        amount.addClass("insale-price");
        jQuery(".box-seprtr").find("p.insale").removeClass("dnone");
        jQuery(".was-amount").removeClass("no-display");

    } else {

        amount.html("$" + firstSizePrice);
    }


    //end insale
}

function addtocart() {

    if (_islengthavailable) {
        var errormsg = '';
        if (jQuery("div.selectedlength div.selected").length == 0 && _productorderqty == 0)
            errormsg = "Please select quantity and length to continue";
        else {
            if (_productorderqty == 0)
                errormsg = "Please select quantity to continue";
            if (jQuery("div.selectedlength div.selected").length == 0)
                errormsg = "Please select length to continue";
			if (jQuery("div#sizecontainer div.dvselectedsize").length == 0)
                errormsg = "Please select a size to continue";
        }
        if (errormsg != '') {
            jQuery("div.producterrorcontainer div.errormsg").hide();
            jQuery("div.producterrorcontainer div.errormsg").html(errormsg);
            jQuery("div.producterrorcontainer div.errormsg").fadeIn('fast');
            jQuery("#orderitem").addClass('bagdisabled');
            jQuery("#orderitem").removeClass('spbutton');
            return;
        }
    } else {
        var errormsg = '';
        if (jQuery("div#sizecontainer div.dvselectedsize").length == 0 && _productorderqty == 0)
            errormsg = "Please select quantity and size to continue";
        else {
            if (_productorderqty == 0)
                errormsg = "Please select quantity to continue";
            if (jQuery("div#sizecontainer div.dvselectedsize").length == 0)
                //errormsg = "Please select size to continue";
				errormsg = "Select size to continue";
        }
        if (errormsg != '') {
            jQuery("div.producterrorcontainer div.errormsg").hide();
            jQuery("div.producterrorcontainer div.errormsg").html(errormsg);
            jQuery("div.producterrorcontainer div.errormsg").fadeIn('fast');
            jQuery("#orderitem").addClass('bagdisabled');
            jQuery("#orderitem").removeClass('spbutton');
            return false;
        }
    }
    jQuery("div.producterrorcontainer div.errormsg").hide();
    var size = jQuery("div#sizecontainer div.dvselectedsize").attr("value");
    var color = jQuery("table.normalproductdetail div#colorcontainer table").has("td.tdselectedcolor").attr("value");
    var length = jQuery("div.selectedlength div.selected").attr("value");
    _addingtocart = true;

    var addurl = homeUrl + 'mycheckout/mycart/add?product=' + _productid + '&qty=' + _productorderqty + '&super_attribute[' + _colorattributeid + ']=' + color;

    if (_sizesuperattribute)
        addurl = addurl + '&super_attribute[' + _sizeattributeid + ']=' + size;

    if (_islengthavailable)
        addurl = addurl + '&super_attribute[' + _lengthattributeid + ']=' + length;

    if (_isoptionavailable && _braSelected) {
//        addurl = addurl + '&options[1]=1';

        addurl = addurl + '&options[' + _braOptionID + ']=' + _braOptionTypeID;
    }

    //if(_isBundleOptionAvailable && ){
    if (false) {
        var optId = jQuery(".cs-addPrd").attr("optionid");
        var optTypeId = jQuery(".cs-addPrd").attr("optiontypeid");
        addurl = addurl + '&options[' + optId + ']=' + optTypeId;
    }
    // for do not call old shopping bag html in new theme
    addurl = addurl + '&showhtml=0';

/************** added by ys team **************/
    jQuery("#addtobagloader").show();
    //jQuery("<div id='addtobagloader'><img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' /></div>").insertAfter(jQuery(this));

    jQuery.ajax({
        type: 'POST',
        url: addurl,
        data: {},
        success: function (result) {
            result = eval('(' + result + ')');
            //jQuery("#addtobagloader").hide();
            _addingtocart = false;

            if (result.status == 'success') {
                if (_productdisplaymode == "popup") {
                    jQuery("#productdetailpopup").dialog("close");
                    jQuery("#bundleProductPopup").dialog("close");

                }

                jQuery("span.cartitemcount").html(result.count);
                jQuery("li#shop-bag-count span").html(result.count); //added by FK.

                jQuery("div#myminicart").html(result.html);

/******* added by ys team ********/
                showShoppingBagHtmlOpen();          // copy of existing method, show shopping bag on adding product
/******* added by ys team ********/

                jQuery("div#myminicart").slideDown('slow', function () {
                    setTimeout(function () {
                        jQuery("div#myminicart").slideUp('slow');
                    }, 4000);
                });
                //jQuery("a.top-link-cart").fadeOut(500, function(){
                //                    jQuery("span.cartitemcount").html(result.count);
                //                    jQuery("a.top-link-cart").fadeIn(500);
                //                });
                //jQuery("a.top-link-cart").animate({
                //                    opacity: 0,
                //                    filter : 0
                //                }, 500, function(){
                //                    jQuery("span.cartitemcount").html(result.count);
                //                    jQuery("a.top-link-cart").animate({
                //                        opacity: 1,
                //                        filter : 100
                //                    },500);
                //                });
            }
            else if(result.status=="ingiftset"){
                jQuery(".gift-set-sorry-popup").show();
                jQuery(".gift-set-sorry-popup").find(".message").html("This product is already in your gift set, please place a separate order.");
                jQuery("#addtobagloader").hide();
            }
			 else if(result.status=="not available"){
                jQuery("#addtobagloader").hide();
                alert('The requested quantity for this product is not available.');
            }
            else {
                jQuery("#addtobagloader").hide();
                alert('This item is out of stock.');
            }
            //
            //            result = eval('(' + result + ')');
            //            if(result.status == "0")
            //                jQuery("#footernotification").html(result.message).removeClass("success").addClass("error").fadeIn();
            //            else
            //                jQuery("#footernotification").html(result.message).removeClass("error").addClass("success").fadeIn();
            //setTimeout(function(){ rremovenotifications(); }, 5000);
        }
    });


}


function setImageContheightPDP() {
    var pdpimagecontH = jQuery("table.tdbigimagecontainer img").height();
    jQuery("table.productimagecontainer").parent(".upper-container").css("min-height", pdpimagecontH + 70);
}

/**In case of length available**/
function selectfirstsizeonload() {
    if (_islengthavailable) {
        if (jQuery(".selectedsize").is(":visible")) {
            var firstSize = jQuery("div#sizecontainer td:not(.disabled)").first().find("div");
            firstSize.addClass("dvselectedsize");
            if (firstSize.hasClass("dvselectedsize")) {
                changeproductsize(firstSize);
            }
        }
        jQuery(".qty").empty().html("Step 4");
		firstSize.removeClass("dvselectedsize");
    }
}

function insertBraOption() {
    _braSelected = 0;
    jQuery("body").find("#includeoption div:nth-child(1)").trigger("click");
    jQuery("body").on("click", "#includeoption div", function () {
        var braValue = parseInt(jQuery("#includeoption div:nth-child(1)").attr("value"));
        jQuery(this).addClass("selected").siblings().removeClass("selected");
        if (jQuery(this).text() == "Y" || jQuery(this).text() == "y") {
            if (_braSelected == 0) {
                var productCost = jQuery(".productcost").text().split("$");
                var productCostV = parseInt(productCost[1]) + braValue;

                jQuery(".productcost").text("$" + productCostV);
                _braSelected = 1;
                _braOptionTypeID = jQuery(this).attr("optiontypeid");
                _braOptionID = jQuery(this).attr("optionid");
            }
        }
        if (jQuery(this).text() == "N" || jQuery(this).text() == "n") {
            if (_braSelected == 1) {
                _braSelected = 0;
                var productCost = jQuery(".productcost").text().split("$");
                var productCostV = parseInt(productCost[1]) - braValue;
                jQuery(".productcost").text("$" + productCostV);
            }
        }
    });

}

/*--new design--*/
jQuery(window).resize(function(){
	prodnewdetailresize();		
});
jQuery(document).ready(function($){
	var windH = $(window).height();	
	var imgrowtr = $('.thumb-imgs table.smallimagecontiner tr td img');
	if(imgrowtr.length > 0){		
		var px = 0;
		$('.product-row-container').addClass("row-container-loading"); //for new design
		var intervalID = setInterval(function () {
			// logic here			
			prodnewdetail();
			if (px++ === 5) {
				window.clearInterval(intervalID);				
					$('.product-row-container').removeClass("row-container-loading"); //for new design
			}
		}, 2000);
	}
});	