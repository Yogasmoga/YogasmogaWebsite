var _rewardpoints = 0;
jQuery(document).ready(function($){
    $("table.normalproductdetail div#colorcontainer table").live("click", function(){
        changeColor($(this).attr("color"));
    });
    
    $("table.smallimagecontiner td:not(.selectedimage)").live("click", function(){
        $("table.smallimagecontiner td").removeClass("selectedimage");
        $(this).addClass("selectedimage");
        $("table.tdbigimagecontainer img").hide();
        $("table.tdbigimagecontainer img").attr("src", $(this).attr("bigimageurl"));
        _curshareimgurl = $(this).attr("bigimageurl");
        $("table.tdbigimagecontainer img").fadeIn('fast');
    });
    
    $("td#tdpopupproductsmallimages td:not(.selectedimage)").live("click", function(){
        $("td#tdpopupproductsmallimages td").removeClass("selectedimage");
        $(this).addClass("selectedimage");
        $("td#tdpopupproductbigimage img").hide();
        $("td#tdpopupproductbigimage img").attr("src", $(this).attr("bigimageurl"));
        $("td#tdpopupproductbigimage img").fadeIn('fast');
    });
        
    $("#orderitem, #preorderitem").live("click", function(){
        if(_addingtocart)
            return;
        addtocart();
    });
    
    $("div#sizecontainer td:not(.disabled) div:not(.dvselectedsize)").live("click", function(){
        changeproductsize($(this));
    });
    
    InitializeProductQty();
    $("div.sizeselector select.qtyselector").live("click", function(){
        changeOrderqty($(this).val());
    });
    
    if($("div#colorcontainer table:first").length > 0)
        changeColor($("div#colorcontainer table:first").attr("color"));
        
    $("table.productdetailtable td.howdoesitfitlink a").live("click", function(){
        $("div#howdoesitfitbox").fadeIn('normal');
    });
    
    $("div#howdoesitfitbox").live('mouseover', function(){
        _howdoesitfithovered = true;
    });
    $("div#howdoesitfitbox").live('mouseout', function(){
        _howdoesitfithovered = false;
    });
    $("div#sizechart").live('mouseover', function(){
        _sizecharthovered = true;
    });
    $("div#sizechart").live('mouseout', function(){
        _sizecharthovered = false;
    });
    $("body").click(function(){
        if(!_howdoesitfithovered)
            $("div#howdoesitfitbox").fadeOut('normal');
        if(!_sizecharthovered)
            $("div#sizechart").fadeOut('normal');
    });
    
    $("img#closesmlight").live('click', function(){
        $(this).parent().fadeOut('normal');
    });
    
    $("table.productdetailtable td.sizechartlink a").live('click', function(){
        if(_productdisplaymode == 'popup')
        {
            var ppdialog = $("div.yogidialog.ui-dialog:first");
        }
        else
        {
        }
        $("div#sizechart").fadeIn('normal');
    });
});

function InitializeProductQty()
{
    _productorderqty = jQuery("div.sizeselector select.qtyselector").val();
}

function changeproductsize(sz)
{
    //console.log('changing size');
    jQuery("div#sizecontainer div").removeClass("dvselectedsize");
    sz.addClass("dvselectedsize");
    var qty = sz.attr("qty") * 1;
    var orderqty =_productorderqty;
    if((qty - orderqty) > 0)
    {
        jQuery("#orderitem").show();
        jQuery("#preorderitem").hide();            
    }
    else
    {
        jQuery("#orderitem").hide();
        jQuery("#preorderitem").show();
    }
    var price = sz.attr("price");
    jQuery("div.productcost").html("$" + price);
    //var rewardpoints = Math.floor((price * 1) * _rewardpointsearned);
//    jQuery("div.smogibuckcount td").html(rewardpoints);
    _rewardpoints = sz.attr("rewardpoints") * 1;
    //console.log(jQuery("select.qtyselector").val());
    if((jQuery("select.qtyselector").val() * 1) > 0)
        jQuery("div.smogibuckcount td").html(_rewardpoints * (jQuery("select.qtyselector").val() * 1));
    else
        jQuery("div.smogibuckcount td").html(_rewardpoints);
    
    jQuery("#orderitem").removeClass("bagdisabled");
    jQuery("#orderitem").addClass("spbutton");
}

function changeOrderqty(qty)
{
    qty = qty * 1;
    _productorderqty = qty;
    
    if(jQuery("div#sizecontainer div.dvselectedsize").length == 0)
        return;
    if(qty > 0)
        jQuery("div.smogibuckcount td").html(_rewardpoints * qty);
    else
        jQuery("div.smogibuckcount td").html(_rewardpoints);
    //jQuery("div.smogibuckcount td").html(_rewardpoints * qty);
    var stockqty = jQuery("div#sizecontainer div.dvselectedsize").attr("qty") * 1;
    if((stockqty - qty) >= 0)
    {
        jQuery("#orderitem").show();
        jQuery("#preorderitem").hide();            
    }
    else
    {
        jQuery("#orderitem").hide();
        jQuery("#preorderitem").show();
    }
}

function searchproductcolorinfoarrray(clr)
{
    for(i = 0; i < _productcolorinfo.length; i++)
    {
        if(_productcolorinfo[i].color == clr)
            return i;
    }
    return -1;
}


function changeColor(clr)
{
    var colorindex = searchproductcolorinfoarrray(clr);
    if(colorindex == -1)
        return;

    _rewardpoints = 0;
    jQuery("div.smogibuckcount td").html(_cnfrewardpoint);
    jQuery("table.normalproductdetail table.selectedcolor td:last").html(clr);
    jQuery("table.normalproductdetail div#colorcontainer table td").removeClass("tdselectedcolor");
    jQuery("table.normalproductdetail div#colorcontainer table[color='" + clr + "'] tr:nth-child(2) td").addClass("tdselectedcolor");
    jQuery("div#sizecontainer div").removeClass("dvselectedsize");
    //jQuery("div#sizecontainer div").addClass("disabled");
    jQuery("div#sizecontainer div").parent().addClass("disabled");
    for(i = 0; i < _productcolorinfo[colorindex].sizes.length; i++)
    {
        var sizetemp = _productcolorinfo[colorindex].sizes[i].split("|");
        var size = sizetemp[0];
        var qty = sizetemp[1];
        var price = sizetemp[2];
        var rewardpoints = sizetemp[3];
        //var size = _productcolorinfo[colorindex].sizes[i].substr(0, _productcolorinfo[colorindex].sizes[i].indexOf('|'));
//        var qty = _productcolorinfo[colorindex].sizes[i].substr(_productcolorinfo[colorindex].sizes[i].indexOf('|') + 1, _productcolorinfo[colorindex].sizes[i].indexOf('|') + 1);
//        var price = _productcolorinfo[colorindex].sizes[i].substr(_productcolorinfo[colorindex].sizes[i].indexOf('|', _productcolorinfo[colorindex].sizes[i].indexOf('|') + 1) + 1);
        //console.log(qty);
        jQuery("div#sizecontainer div[size='" +  size + "']").parent().removeClass("disabled");
        jQuery("div#sizecontainer div[size='" +  size + "']").attr("qty", qty);
        jQuery("div#sizecontainer div[size='" +  size + "']").attr("price", price);
        jQuery("div#sizecontainer div[size='" +  size + "']").attr("rewardpoints", rewardpoints);
    }
    jQuery("#orderitem").show();
    jQuery("#preorderitem").hide();
    var smallimagehtml = '';
    if(_productdisplaymode == 'popup')
    {
        for(i = 0; i < _productcolorinfo[colorindex].smallimages.length; i++)
        {
            smallimagehtml = smallimagehtml + "<tr><td bigimageurl='" + _productcolorinfo[colorindex].bigimages[i] + "'><img src='" + _productcolorinfo[colorindex].smallimages[i] + "'></td></tr>";
        }
        jQuery("td#tdpopupproductbigimage, td#tdpopupproductsmallimages").hide();
        jQuery("td#tdpopupproductsmallimages table tbody").html(smallimagehtml);
        if(jQuery("td#tdpopupproductsmallimages td").length > 0)
        {
            if(jQuery("td#tdpopupproductbigimage img").length > 0)
                jQuery("td#tdpopupproductbigimage img").attr("src", jQuery("td#tdpopupproductsmallimages table tbody td:first").attr("bigimageurl"));
            else
                jQuery("td#tdpopupproductbigimage").html("<img src='" + jQuery("td#tdpopupproductsmallimages table tbody td:first").attr("bigimageurl") + "'>");
            jQuery("td#tdpopupproductsmallimages table tbody td:first").addClass('selectedimage');   
        }
        jQuery("td#tdpopupproductbigimage, td#tdpopupproductsmallimages").fadeIn('fast');
    }
    else
    {
        smallimagehtml = '<tr>';
        for(i = 0; i < _productcolorinfo[colorindex].smallimages.length; i++)
        {
            smallimagehtml = smallimagehtml + "<td bigimageurl='" + _productcolorinfo[colorindex].bigimages[i] + "' zoomimageurl='" + _productcolorinfo[colorindex].zoomimages[i] + "'><img src='" + _productcolorinfo[colorindex].smallimages[i] + "'></td>";
        }
        smallimagehtml = smallimagehtml + "</tr>";
        jQuery("table.productimagecontainer").hide();
        jQuery("table.smallimagecontiner tbody").html(smallimagehtml);
        if(jQuery("table.smallimagecontiner td").length > 0)
        {
            if(jQuery("table.tdbigimagecontainer img").length > 0)
                jQuery("table.tdbigimagecontainer img").attr("src", jQuery("table.smallimagecontiner td:first").attr("bigimageurl"));
            else
                jQuery("table.tdbigimagecontainer td").html("<img src='" + jQuery("table.smallimagecontiner td:first").attr("bigimageurl") + "'>");
            _curshareimgurl = jQuery("table.smallimagecontiner td:first").attr("bigimageurl");
        }
        jQuery("table.smallimagecontiner td:first").addClass("selectedimage");
        jQuery("table.productimagecontainer").fadeIn('fast');   
    }
    //jQuery("#orderitem").addClass("bagdisabled");
}

function addtocart()
{
    var errormsg = '';
    if(jQuery("div#sizecontainer div.dvselectedsize").length == 0 && _productorderqty == 0)
        errormsg = "Please select quantity and size to continue.";
    else
    {
        if(_productorderqty == 0)
            errormsg = "Please select quantity to continue.";
        if(jQuery("div#sizecontainer div.dvselectedsize").length == 0)
            errormsg = "Please select size to continue.";
    }
    if(errormsg != '')
    {
        jQuery("div.producterrorcontainer div.errormsg").hide();
        jQuery("div.producterrorcontainer div.errormsg").html(errormsg);
        jQuery("div.producterrorcontainer div.errormsg").fadeIn('fast');
        jQuery("#orderitem").addClass('bagdisabled');
        jQuery("#orderitem").removeClass('spbutton');
        return;
    }
    jQuery("div.producterrorcontainer div.errormsg").hide();
    var size = jQuery("div#sizecontainer div.dvselectedsize").attr("value");
    var color = jQuery("table.normalproductdetail div#colorcontainer table").has("td.tdselectedcolor").attr("value");
    _addingtocart = true;
    jQuery.ajax({
        type : 'POST',
        url : homeUrl + 'mycheckout/mycart/add?product=' + _productid + '&qty=' + _productorderqty + '&super_attribute[' + _colorattributeid + ']=' + color + '&super_attribute[' + _sizeattributeid + ']=' + size,
        data : {},
        success : function(result){
            result = eval('(' + result + ')');
            _addingtocart = false;
            if(result.status == 'success')
            {
                if(_productdisplaymode == "popup")
                    jQuery( "#productdetailpopup" ).dialog( "close" );
                jQuery("span.cartitemcount").html(result.count);
                jQuery("div#myminicart").html(result.html);
                jQuery("div#myminicart").slideDown('slow', function(){
                    setTimeout(function(){ jQuery("div#myminicart").slideUp('slow'); }, 4000);
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
            else
            {
                alert('Oops! An unexpected error occured.');
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